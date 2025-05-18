1) Скачать и установить xampp https://www.apachefriends.org/
2) Откройте этот файл php.ini он где-то здесь C:\xampp\php.
3) раскомментить тут эти строчки:
extension=php_pdo_pgsql.dll
extension=php_pgsql.dll

4) Скачать и установить postgresSQL
5) Создать БД portfolioBD
6) Перейти в папку, где установлен psql и открыть в консоли 
7) следующая команда для переноса бекапа в БД: psql -U postgres -d portfolioDB < C:\Users\olezh\Desktop\portfolio_v2.0.sql
8) Перейти по следующему пути C:\xampp\htdocs 
9) Cклонировать проект в папку https://github.com/bes-germes/portfolio
10) открыть http://localhost/potfolio/index.php

ALTER TABLE public.info_project ALTER COLUMN refs TYPE json USING to_json(refs)::json;