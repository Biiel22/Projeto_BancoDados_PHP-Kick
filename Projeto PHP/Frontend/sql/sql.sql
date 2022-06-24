create database projetophp;

use projetophp;

create table usuario (
	id int not null auto_increment,
	nome varchar(40),
    email varchar (125),
    senha varchar(12),
    primary key(id)
);

create table tarefa (
	id int not null auto_increment,
    feito varchar(15),
	dataCriado date,
    tarefa text,
    dataTermina date,
    idUsuario int,
    primary key(id),
	foreign key(idUsuario) references usuario(id)
);