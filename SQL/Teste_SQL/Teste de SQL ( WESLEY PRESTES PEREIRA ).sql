drop database if exists sql_test;
create database sql_test
default character set utf8
default collate utf8_general_ci;

use sql_test;

create table lojas(
loj_prod int(8) auto_increment,
desc_loj varchar(40) not null,
primary key(loj_prod)
)ENGINE=innodb default charset=utf8;

create table produtos(
cod_prod int(8) auto_increment,
loj_prod int(8) not null,
desc_prod Varchar(40) not null,
dt_inclu_prod date not null,
preco_prod decimal(8,2) not null,
primary key(cod_prod),
foreign key(loj_prod) references lojas(loj_prod)
)ENGINE=innodb default charset=utf8;

create table estoque(
cod_prod int(8) auto_increment,
loj_prod int(8) not null,
qtd_prod int(15) not null,
primary key (cod_prod),
foreign key(loj_prod) references lojas(loj_prod)
)ENGINE=innodb default charset=utf8;

insert into lojas (desc_loj) values ('Loja america');
insert into lojas (desc_loj) values ('Super mercado');
insert into lojas (desc_loj) values ('Hiper mercado');
insert into lojas (desc_loj) values ('varejo');
insert into produtos (cod_prod, loj_prod, desc_prod, dt_inclu_prod, preco_prod) values ('190', '1', 'INSETICIDA', '2010-03-30', '45.30');
insert into produtos (cod_prod, loj_prod, desc_prod, dt_inclu_prod, preco_prod) values ('170', '2', 'LEITE CONDESADO MOCOCA', '2010-12-30', '45.40');
insert into produtos (cod_prod, loj_prod, desc_prod, dt_inclu_prod, preco_prod) values ('180', '3', 'LEITE SEMIDESNATADO', '2015-12-30', '160.00');
insert into produtos (cod_prod, loj_prod, desc_prod, dt_inclu_prod, preco_prod) values ('160', '4', 'PILHA AAA', '2020-12-30', '258.00');
insert into produtos (cod_prod, loj_prod, desc_prod, dt_inclu_prod, preco_prod) values ('200', '1', 'CAFE', '2015-12-20', '160.00');
insert into estoque (cod_prod, loj_prod, qtd_prod) values ('160', '1', '150');
insert into estoque (cod_prod, loj_prod, qtd_prod) values ('170', '2', '12');
insert into estoque (cod_prod, loj_prod, qtd_prod) values ('180', '3', '48');
insert into estoque (cod_prod, loj_prod, qtd_prod) values ('190', '4', '73');
insert into estoque (cod_prod, loj_prod, qtd_prod) values ('110', '4', '70');

