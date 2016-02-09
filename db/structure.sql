drop table if exists t_user;

create table t_user (
    usr_id integer not null primary key auto_increment,
    usr_name varchar(50) not null,
    usr_password varchar(88) not null,
    usr_salt varchar(23) not null,
    usr_role varchar(50) not null,
    usr_mail varchar(255) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

drop table if exists t_produit;

create table t_produit (
    prod_id integer not null primary key auto_increment,
    prod_name varchar(50) not null,
    prod_lib varchar(88) not null,
    prod_prixK integer(23) not null,
) engine=innodb character set utf8 collate utf8_unicode_ci;