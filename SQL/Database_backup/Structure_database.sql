create database php_test
default character set utf8
default collate utf8_general_ci;

use php_test;



create table preco(
idpreco int(8) auto_increment,
preco decimal(12,2) not null,
primary key(idpreco)
)ENGINE=innodb default charset=utf8;


create table produtos(
idprod int(8) auto_increment,
nome varchar(40) not null,
cor Varchar(10) not null,
primary key(idprod)
)ENGINE=innodb default charset=utf8;
