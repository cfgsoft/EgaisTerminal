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

Установка composer
https://habr.com/post/197454/


Для виртуральной машине bitrix установить zip
yum install zip
yum install unzip

Отключить все disable в etc/php.d

Перезапуск сети
service httpd restart


1. Создан новый проект для терминала.
2. Добавляем аутентификацию в проект (php artisan make:auth)
3. Создаем модель (php artisan make:model Category -m) 
4. Создаем модель (php artisan make:model Product -m   ключ -m создает миграцию   )
5. В миграции прописываем вручную все поля и связи
6. Выполняем миграцию (php artisan migrate) (php artisan migrate:rollback --step=1  удаляем последнюю миграцию 1шт. ) (php artisan migrate:rollback    удаляет все)

7. Заполнение тестовыми данными (php artisan make:seeder CategoryTableSeeder) 


npm run watch

