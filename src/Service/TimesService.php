<?
namespace App\Service;

class TimesService
{
    public function timed($ftime, $pad = 0)
    {
        if (!$ftime) {
            return "";
        }

        $min = floor($ftime/60);
        $sec = $ftime%60;
        $ms = $ftime * pow(10, $pad) % pow(10, $pad);
        if ($min < 10) {
            $min = '0'.$min;
        }
        if ($sec < 10) {
            $sec = '0'.$sec;
        }
        if ($ms < pow(10, $pad-1) && $ms!=0) {
            $ms = '0'.$ms;
        }
        $ms = str_pad($ms, $pad, '0');

        return $min.':'.$sec.'.'.$ms;
    }

    public function time_elasped($time)
    {
        $sec = $time%60;
        $mins = floor($time/60);
        $min = $mins%60;
        $hours = floor($mins/60);
        $hour = $hours%24;
        $days = floor($hours/24);
        $day = $days%365;
        $year = floor($days/365);

        $out = "{$year}y {$day}d {$hour}h {$min}m {$sec}s";

        return $out;
    }
}