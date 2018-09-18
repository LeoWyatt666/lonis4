<?php
namespace App\Library;

class CSMonitoring
{
    ///////////
    // SETUP //
    ///////////

    const CONNECTION_PROTOCOL = 'udp://';

    const QUERY_GET_SERVER_INFO    = "\xFF\xFF\xFF\xFFTSource Engine Query\x00";
    const QUERY_GET_SERVER_PLAYERS = "\xFF\xFF\xFF\xFF\x55\x00\x00\x00\x00";

    const ERROR_CONNECTION = 'Не удалось установить соединение с игровым сервером...';
    const ERROR_RESPONSE_1 = 'Не удалось получить информацию о игровом сервере...';
    const ERROR_RESPONSE_2 = 'Не удалось получить информацию о игроках на сервере...';

    /////////
    // API //
    /////////

    /**
     *
     * @brief     Получение информации о игровом сервере и статистики активных игроков
     *
     * @param     String     IP-адрес или домен сервера Counter-Strike
     * @param     Integer    Порт сервера Counter-Strike
     * @param     String     В случае ошибки в эту переменную будет записан текст ошибки.
     *
     * @return    False      Если информацию о сервере не удалось получить.
     *            Array      Массив с информацией о состоянии сервера Counter-Strike.
     *
     *                       nm – Название карты
     *                       nh – Название хоста
     *                       pc – Количество игроков на сервере
     *                       pm – Максимальное количество игроков на сервере
     *                       dr – Описание сервера
     *                       ps – Массив со статистикой игроков на сервере
     *                       os – Операционная система сервера
     *
     *                          [n] – Ник игрока на сервере
     *                          [s] – Текущий счет игрока на сервере
     */
    public static function getServerInfo($host = '127.0.0.1', $port = 27015, &$error)
    {
        $connection = self::Connect( $host, $port );

        if( !$connection )
        {
            $error = self::ERROR_CONNECTION;
            return FALSE;
        }

        $response = self::Query( $connection, self::QUERY_GET_SERVER_INFO );

        self::Disconnect( $connection );

        if( !$response )
        {
            $error = self::ERROR_RESPONSE_1;
            return FALSE;
        }

        $response = trim( substr( $response, 4 ) );
        $server_info = array();

        $source = explode( "\x00", $response );
        $offset = strlen( $source[ 0 ].
                          $source[ 1 ].
                          $source[ 2 ].
                          $source[ 3 ].
                          $source[ 4 ] ) + 5;

        $server_info['map'] = $source[ 1 ];
        $server_info['name'] = substr($source[ 0 ], 2);
        $server_info['players_count'] = ord( $response[ $offset + 0 ] );
        $server_info['players_max'] = ord( $response[ $offset + 1 ] );
        $server_info['dr'] = $source[ 4 ];
        $server_info['os'] = 'l' == $response[ $offset + 4 ] ? 'Linux' : 'Windows';
        $server_info['ps'] = FALSE;

        $connection = self::Connect( $host, $port );

        if( !$connection )
        {
            $error = self::ERROR_CONNECTION;
            return $server_info;
        }

        $response = self::Query( $connection, self::QUERY_GET_SERVER_PLAYERS );

        if( !$response )
        {
            self::Disconnect( $connection );
            $error = self::ERROR_RESPONSE_2;
            return $server_info;
        }

        $response = self::Query( $connection, "\xFF\xFF\xFF\xFFU".substr( $response, 5, 4 ) );

        self::Disconnect( $connection );

        if( !$response )
        {
            $error = self::ERROR_RESPONSE_2;
            return $server_info;
        }

        $response = trim( substr( $response, 4 ) );

        $resp_len   = strlen( $response );
        $player_num = 0;
        $position   = 2;
        $players    = array();

        while( $position < $resp_len )
        {
            ++$player_num;
            ++$position;
			$players[ $player_num ]['n'] = "";

            while( $response[ $position ] != "\x00" && $position < 4000 ) {
                $players[ $player_num ]['n'] .= $response[ $position++ ];
			}

            $players[ $player_num ]['s'] = (ord( $response[ $position + 1 ] ))
                                         + (ord( $response[ $position + 2 ] ) * 256)
                                         + (ord( $response[ $position + 3 ] ) * 65536)
                                         + (ord( $response[ $position + 4 ] ) * 16777216);

            if (2147483648 < $players[ $player_num ]['s']) {
                $players[$player_num ]['s'] -= 4294967296;
			}

            $position += 9;
        }

        usort($players, function($first, $second)
        {
            return $second['s'] - $first['s'];
        });

        $server_info['ps'] = $players;

        return $server_info;
    }

    //////////////
    // INTERNAL //
    //////////////

    /**
     *
     * @brief     Установка соединения с игровым сервером
     *
     * @param     String             IP-адрес или домен игрового сервера
     * @param     Integer            Порт игрового сервера
     *
     * @return    FALSE              Если открыть соединение с игровым сервером не удалось
     *            socket(handler)    Дескриптор соединения с игровым сервером
     */
    private static function Connect( $host, $port )
    {
        $connection = fsockopen(self::CONNECTION_PROTOCOL.$host, $port, $errno, $errstr, 0);

        if( !$connection )
            return FALSE;

        // Ждем ответа от сервера, читаем данные только при полном ответе.
        stream_set_timeout($connection, 1, 0);
        stream_set_blocking($connection, true);

        return $connection;
    }

    /**
     *
     * @brief    Закрытие соединения с игровым сервером
     *
     * @param    socket(handler)    Дескриптор соединения с игровым сервером
     */
    private static function Disconnect( $connection )
    {
        fclose($connection);
    }

    /**
     *
     * @brief     Запрос к игровому серверу (и получение ответа)
     *
     * @param     socket(handler)    Дескриптор соединения с игровым сервером
     * @param     String             Строка с текстовым запросом к игровому серверу
     *                               Документация Valve: https://developer.valvesoftware.com/wiki/Server_queries
     *
     * @return    String             4096 байт ответа от игрового сервера, прочтенных через сокет
     */
    private static function Query( $connection, $query )
    {
        if (!$connection)
            return FALSE;

        fwrite($connection, $query);

        $response = fread($connection, 4096);

        return $response;
    }
}