������ ������ mysql
https://artkiev.com/blog/mysql-full-list-commands.htm

�������
https://bozza.ru/art-259.html

���� �� ����� �� ���
https://dev.1c-bitrix.ru/community/forums/forum32/topic96617/

���� �� ����� �� ��� �� ������������ root, ����� ������� ������ � ������������ ����������
http://qaru.site/questions/3369/mysql-grant-all-privileges-on-database

mysql -u root -p   (���� � ������� �� linux)

CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password'; 
GRANT ALL PRIVILEGES ON * . * TO 'newuser'@'localhost';
FLUSH PRIVILEGES;

//����� ������
ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_password'
ALTER USER 'root'@'localhost' PASSWORD EXPIRE NEVER;

��������� composer
https://habr.com/post/197454/


��� ������������ ������ bitrix ���������� zip
yum install zip
yum install unzip

��������� ��� disable � etc/php.d

���������� ����
service httpd restart

���������� ngix 
systemctl restart nginx

��������� minding commander (������ mc)
yum install mc

������ ���� � appache /etc/http/bx/conf
������ ���� � nginx /etc/nginx/bx/site_enabled
��������� /public

//����� ���������� �� ���� ��������� ������
chown -R bitrix:bitrix /home/bitrix/www


//��������� Laravel Ubuntu
https://hackernoon.com/a-step-by-step-guide-to-setup-php-laravel-environment-linux-50b55a4fd15e

//��������� web ������ 
//http://blog.sedicomm.com/2018/01/22/ustanovka-centos-web-panel-v-centos/

NPM �������� �������
https://habr.com/post/133363/
npm list -g --depth=0 (��������� ������������� ������)

//������� � c# �� PHP
https://habr.com/users/GraDea/

//Mobile-Detect ����������� ���������� � �������� ����������� ����
https://github.com/serbanghita/Mobile-Detect

//��������� ������� Ubuntu (web min)
https://www.youtube.com/watch?v=ePw9LQgBAnc
http://webgoal.ru/sistemnoe_administrirovanie/ustanovka_lamp_(linux_apache_mysql_php)_ubuntu_1804_dlya_lokalnoi_razrabotki9.html
sudo apt-get install php-xml
sudo apt-get install php-mbstring

https://www.youtube.com/watch?v=uIXScyhCtPc

0. php artisan key:generate (��������� ������ �����)
1. ������ ����� ������ ��� ���������.
2. ��������� �������������� � ������ (php artisan make:auth)
3. ������� ������ (php artisan make:model Category -m) 
4. ������� ������ (php artisan make:model Product -m   ���� -m ������� ��������   )
5. � �������� ����������� ������� ��� ���� � �����
6. ��������� �������� (php artisan migrate) (php artisan migrate:rollback --step=1  ������� ��������� �������� 1��. ) (php artisan migrate:rollback    ������� ���)
7. ���������� ��������� ������� (php artisan make:seeder CategoryTableSeeder) 
8. ���������� ������ �������� (php artisan make:migration create_foreign_products)
9. ���������� ����� � ������� (php artisan make:migration create_parrent_id --table categories)
10. ���������� ������ (php artisan db:seed          php artisan db:seed --class=UsersTableSeeder)
11. php artisan make:controller ShowProfile --invokable
12. ������� ������ (php artisan make:model ExciseStamp -m) 
13. php artisan make:controller api/v1/ExciseStampController --resource --model=ExciseStamp
14. ��������� ������� �������� (composer require doctrine/dbal)

1. �������� API ����������� (php artisan make:controller api/v1/CategoryController --resource --model=Category)
2. ��������� ���� � api ����������� � routes\api.php (Route::group(['prefix' => '/v1',  'namespace' => 'Api\V1', 'as' => 'api.'], function () {
        Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    });)
3. �������� API ����������� (php artisan make:controller api/v1/ProductController --resource --model=Product)	


npm run watch

FA-000000041590630