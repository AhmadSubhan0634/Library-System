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
 
/* Table for borrowed books */
create table borrow_records(
id int primary key,
book_id int,
borrower_id int,
borrow_date date,
return_date date,
status varchar(10),
created_at date,
updated_at date
);

/* Alter statements to add constraints */
alter table books add constraint c1 foreign key(author_id) references authors(id);
alter table books add constraint c2 foreign key(category_id) references category(id);
alter table books add constraint c3 unique(isbn);
alter table authors add constraint c4 unique(email);
alter table borrow_records add constraint c5 foreign key(book_id) references books(id);
alter table borrow_records add constraint c6 foreign key(borrower_id) references borrowers(id);