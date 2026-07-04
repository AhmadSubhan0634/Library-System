create database Library_System;
use Library_System;
 
 
/* Books table */
create table books(
id int primary key,
title varchar(50) not null,
isbn varchar(10),
published_year date,
author_id int,
category_id int,
created_at date,
updated_at date
);

/* Authors table */
create table authors(
id int primary key,
name varchar(50) not null,
email varchar(50) not null,
country varchar(50) not null,
created_at date,
updated_at date
);

/* Category table */
create table category(
id int primary key,
name varchar(50) not null,
description varchar(100),
created_at date,
updated_at date
);

/* Borrower table */
create table borrowers(
id int primary key,
name varchar(50) not null,
email varchar(50) not null,
phone varchar(15),
address varchar(100) not null,
created_at date,
updated_at date
);
 