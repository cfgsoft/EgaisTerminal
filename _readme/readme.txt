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

��������� composer
https://habr.com/post/197454/


��� ������������ ������ bitrix ���������� zip
yum install zip
yum install unzip

��������� ��� disable � etc/php.d

���������� ����
service httpd restart


1. ������ ����� ������ ��� ���������.
2. ��������� �������������� � ������ (php artisan make:auth)
3. ������� ������ (php artisan make:model Category -m) 
4. ������� ������ (php artisan make:model Product -m   ���� -m ������� ��������   )
5. � �������� ����������� ������� ��� ���� � �����
6. ��������� �������� (php artisan migrate) (php artisan migrate:rollback --step=1  ������� ��������� �������� 1��. ) (php artisan migrate:rollback    ������� ���)
7. ���������� ��������� ������� (php artisan make:seeder CategoryTableSeeder) 
8. ���������� ������ �������� (php artisan make:migration create_foreign_products)
9. ���������� ����� � ������� (php artisan make:migration create_parrent_id --table categories)

1. �������� API ����������� (php artisan make:controller api/v1/CategoryController --resource --model=Category)
2. ��������� ���� � api ����������� � routes\api.php (Route::group(['prefix' => '/v1',  'namespace' => 'Api\V1', 'as' => 'api.'], function () {
        Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    });)
	


npm run watch

