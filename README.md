# comando mais usados:

php artisan make:migration create_users_table --create=users
php artisan make:migration add_votes_to_users_table --table=users
php artisan migrate:reset
php artisan migrate:refresh
php artisan db:seed --class=UserTableSeeder
php artisan migrate:refresh --seed
php artisan db:seed

php artisan tinker
use App\Condinvest\PropLoca as p;

sudo git fetch --all
sudo git reset --hard origin/master

php artisan make:controller PhotoController --api

php -m | grep intl
sudo apt install php7.4-intl
sudo su
service apache2 restart
#You just need to enable this extension in php.ini by uncommenting this line:
cd /etc/php/7.4/cli/
sudo vim php.ini
extension=ext/php_intl.dll

#por conta do erro FPDF Error “Some data has already been output” tem que remover os echos na classe do fpdf:
 cd vendor/setasign/fpdf/
sudo vim fpdf.php
#mudar nas linhas na linas 1008 e 1017
echo $this->buffer;
to 
return $this->buffer;

# Comandos basicos

sudo apt-get install php7.4-mysql

apt-get install apache2 php7.4 libapache2-mod-php7.4 php7.4-curl php-pear php7.4-gd php7.4-dev php7.4-zip php7.4-mbstring php7.4-mysql php7.4-xml curl -y

# mysql necessário

mysql -u root -p
CREATE DATABASE "database name";
CREATE USER 'newuser'@'localhost' IDENTIFIED WITH mysql*native_password BY 'password';
GRANT ALL PRIVILEGES ON * . \_ TO 'newuser'@'localhost';
FLUSH PRIVILEGES;

systemctl start apache2
systemctl enable apache2

composer install
composer dump-autoload

php artisan key:generate
php artisan migrate --seed
php artisan passport:install

php artisan serve
php artisan make:migration create_users_table --create=users
php artisan make:migration add_votes_to_users_table --table=users
php artisan migrate:reset
php artisan migrate:refresh
php artisan db:seed --class=UserTableSeeder
php artisan migrate:refresh --seed
php artisan db:seed
php artisan make:controller PhotoController --api

php artisan tinker

# comandos em etc/apache2/sites-avaliable

sudo a2enmod rewrite

sudo a2ensite meuarquivo.conf
sudo a2dissite 000-default.conf

sudo a2enmod rewrite

sudo systemctl restart apache2
sudo service apache2 restart

sudo a2dissite 000-default.conf

# configurar https

sudo snap install core
sudo snap refresh core
sudo snap install --classic certbot
sudo ln -s /snap/bin/certbot /usr/bin/certbot
sudo certbot --apache