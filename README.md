# lonis4
Web statistic and registration CS 1.6 (Symfony)

***

## Before Install
1. Install `git` here https://git-scm.com
```bash
apt-get install git
```
2. Install `composer` here https://getcomposer.org
```bash
apt-get install curl
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```
3. Install `yarn` here https://yarnpkg.com/en/docs/install
```
sudo apt-get update && sudo apt-get install yarn
```

***

## Install project

1. Clone github project `lonis4`
```bash
git clone https://github.com/LeoWyatt666/lonis4.git
```
2. Edit `.env`. MySql and SteamAPI(here https://steamcommunity.com/dev/apikey)
```bash
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
STEAM_API_KEY= 
```
3. Add `packages`
```bash
composer install
yarn install
```
4. Bulid `assets`
```bash
yarn encore production
```
5. Create `Database`
```bash
php bin/console doctrine:database:create
```
6. Add `tables`
```bash
php bin/console doctrine:schema:update --force
```
8. Load `fixtures`.
```bash
php bin/console doctrine:fixtures:load
```
7. Update `MaxMind GeoIP2` in dev and production!
```bash
php bin/console geoip2:update
```
9. Set production in `.env`
```bash
APP_ENV=prod
```