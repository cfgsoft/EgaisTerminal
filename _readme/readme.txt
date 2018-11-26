Список команд mysql
https://artkiev.com/blog/mysql-full-list-commands.htm

фаервол
https://bozza.ru/art-259.html

база не видна из вне
https://dev.1c-bitrix.ru/community/forums/forum32/topic96617/

база не видна из вне от пользователя root, нужно создать нового и предоставить привелегии
http://qaru.site/questions/3369/mysql-grant-all-privileges-on-database

mysql -u root -p   (Вход в консоль на linux)

CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password'; 
GRANT ALL PRIVILEGES ON * . * TO 'newuser'@'localhost';
FLUSH PRIVILEGES;

//Смена пароля
ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_password'
ALTER USER 'root'@'localhost' PASSWORD EXPIRE NEVER;

Установка composer
https://habr.com/post/197454/


Для виртуральной машине bitrix установить zip
yum install zip
yum install unzip

Отключить все disable в etc/php.d

Перезапуск сети
service httpd restart

Перезапуск ngix 
systemctl restart nginx

Установка minding commander (запуск mc)
yum install mc

меняем путь в appache /etc/http/bx/conf
меняем путь в nginx /etc/nginx/bx/site_enabled
добавляем /public

//Смена разрешения на всех вложенных файлах
chown -R bitrix:bitrix /home/bitrix/www


//Установка Laravel Ubuntu
https://hackernoon.com/a-step-by-step-guide-to-setup-php-laravel-environment-linux-50b55a4fd15e

//Установка web панели 
//http://blog.sedicomm.com/2018/01/22/ustanovka-centos-web-panel-v-centos/

NPM Основные команды
https://habr.com/post/133363/
npm list -g --depth=0 (Глобально установленные пакеты)

//Переход с c# на PHP
https://habr.com/users/GraDea/

//Mobile-Detect Определение устройства с которого открывается сайт
https://github.com/serbanghita/Mobile-Detect

//Установка сервера Ubuntu (web min)
https://www.youtube.com/watch?v=ePw9LQgBAnc
http://webgoal.ru/sistemnoe_administrirovanie/ustanovka_lamp_(linux_apache_mysql_php)_ubuntu_1804_dlya_lokalnoi_razrabotki9.html
sudo apt-get install php-xml
sudo apt-get install php-mbstring

https://www.youtube.com/watch?v=uIXScyhCtPc

0. php artisan key:generate (генерация нового ключа)
1. Создан новый проект для терминала.
2. Добавляем аутентификацию в проект (php artisan make:auth)
3. Создаем модель (php artisan make:model Category -m) 
4. Создаем модель (php artisan make:model Product -m   ключ -m создает миграцию   )
5. В миграции прописываем вручную все поля и связи
6. Выполняем миграцию (php artisan migrate) (php artisan migrate:rollback --step=1  удаляем последнюю миграцию 1шт. ) (php artisan migrate:rollback    удаляет все)
7. Заполнение тестовыми данными (php artisan make:seeder CategoryTableSeeder) 
8. Добавление пустой миграции (php artisan make:migration create_foreign_products)
9. Добавление полей в таблицу (php artisan make:migration create_parrent_id --table categories)
10. Заполнение таблиц (php artisan db:seed          php artisan db:seed --class=UsersTableSeeder)
11. php artisan make:controller ShowProfile --invokable
12. Создаем модель (php artisan make:model ExciseStamp -m) 
13. php artisan make:controller api/v1/ExciseStampController --resource --model=ExciseStamp
14. Изменение размера столбцов (composer require doctrine/dbal)

1. Создание API контроллера (php artisan make:controller api/v1/CategoryController --resource --model=Category)
2. Добавляем путь к api контроллеру в routes\api.php (Route::group(['prefix' => '/v1',  'namespace' => 'Api\V1', 'as' => 'api.'], function () {
        Route::resource('companies', 'CompaniesController', ['except' => ['create', 'edit']]);
    });)
3. Создание API контроллера (php artisan make:controller api/v1/ProductController --resource --model=Product)	


npm run watch

FA-000000041590630