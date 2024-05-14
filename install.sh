#!/bin/bash

echo -e "database name?"
read database

echo -e "database dump location?"
read dump

echo -e "username?"
read username

echo -e "password?"
read password

sudo apt-get update
sudo apt -y install software-properties-common php php-common php-mysql php-xml mariadb-server composer
sudo apt-get -y install php-curl
sudo systemctl start mariadb.service
echo -e "[y] unix socket [n] change password [y] remove users [y] login remote [y] reload tables"
read
sudo mysql_secure_installation

sudo mariadb -e "CREATE DATABASE $database;"
sudo mariadb -e "CREATE USER IF NOT EXISTS '$username'@'%' IDENTIFIED BY '$password'"
sudo mariadb -e "GRANT ALL PRIVILEGES ON *.* TO '$username'@'%' WITH GRANT OPTION;"
sudo mariadb -e "FLUSH PRIVILEGES;"
sudo mariadb $database < $dump
echo "mariadb database configured"

cd /var/www/html
sudo git clone "https://github.com/cakephp/cakephp"
echo "cakephp repository cloned"

cd /var/www/html/cakephp
sudo git checkout tags/2.10.24
echo "cake vs 2.x loaded"

sudo git clone "https://github.com/rafaelcastrocouto/mural"
echo "mural repository cloned"

sudo chown -R www-data /var/www/html/cakephp
sudo chmod -R a+w /var/www/html/cakephp/mural
sudo chmod -R a+w /var/www/html/cakephp/tmp
sudo usermod -a -G www-data $username
sudo a2enmod rewrite
echo "mod rewrite configured"

cd /var/www/html/cakephp/mural
echo "[n] use cakephp composer.json [y] trust installers"
composer require twbs/bootstrap:4.1.3
composer --dev require cakephp/debug_kit "^2.2.0"
composer update
echo "composer requirements installed"

echo nano /etc/apache2/apache2.conf
echo "<Directory /var/www>"
echo "	Options Indexes FollowSymLinks"
echo "	AllowOverride All <<<<<<<< CHANGE THIS"
echo "	Require all granted"
echo "</Directory>"
echo -e "enter to proceed to nano"
read
sudo nano /etc/apache2/apache2.conf

echo nano /etc/apache2/sites-available/000-default.conf
echo "DocumentRoot /var/www/html/cakephp/mural/webroot <<<<<<<< CHANGE THIS"
echo -e "enter to proceed to nano"
read
sudo nano /etc/apache2/sites-available/000-default.conf

echo nano /var/www/html/cakephp/index.php
echo "define('APP_DIR', 'mural'); <<<<<<<< change this"
echo -e "enter to proceed to nano"
read
sudo nano /var/www/html/cakephp/index.php

echo nano /var/www/html/cakephp/mural/Config/database.php.default
echo "public $default = array("
echo "	'datasource' => 'Database/Mysql',"
echo "	'host' => 'localhost',     <<<<<<<< CHANGE THIS"
echo "	'login' => '$username',    <<<<<<<< CHANGE THIS"
echo "	'password' => '$password', <<<<<<<< CHANGE THIS"
echo "	'database' => 'ess_apps',  <<<<<<<< CHANGE THIS"
echo "save as database.php"
echo -e "enter to proceed to nano"
read
sudo nano /var/www/html/cakephp/mural/Config/database.php.default

echo nano /var/www/html/cakephp/mural/webroot/index.php
echo "define('CAKE_CORE_INCLUDE_PATH', ROOT  . DS . 'lib'); <<<<<<<< change this"
echo -e "enter to proceed to nano"
read
sudo nano /var/www/html/cakephp/mural/webroot/index.php

#echo nano /var/www/html/cakephp/mural/Config/core.php
#echo "Configure::write('Security.salt', '');       <<<<<<<< CHANGE THIS"
#echo "Configure::write('Security.cipherSeed', ''); <<<<<<<< CHANGE THIS"
#echo -e "enter to proceed to nano"
#read
#sudo nano /var/www/html/cakephp/mural/Config/core.php

sudo systemctl restart apache2
echo systemctl restart apache2
echo "apache server restarted"

