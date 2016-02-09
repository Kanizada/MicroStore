create database if not exists microstore character set utf8 collate utf8_unicode_ci;
use microstore;

grant all privileges on microstore.* to 'microstore_user'@'localhost' identified by 'beret';