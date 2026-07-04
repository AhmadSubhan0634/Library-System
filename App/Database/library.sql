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