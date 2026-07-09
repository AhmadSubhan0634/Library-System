# Library Management System

## Project Overview

The Library Management System is a PHP console application developed using Object-Oriented Programming (OOP) principles. It allows users to manage books, authors, categories, borrowers, and borrowing records.

# Change from json file to mysql
In this version, the storage mechanism has been migrated to a MySQL database while keeping the business logic unchanged to show the Repository Design Pattern, where only the repository implementation changes without affecting the service layer.

---

# Features

- Add new books
- View all books
- Search books
- Update book information
- Delete books
- Manage authors
- Manage categories
- Manage borrowers
- Borrow books
- Return books
- MySQL database storage
- PDO database connection
- Repository Pattern implementation

---

# Technologies Used

- PHP 8.x
- MySQL
- PDO
- Object-Oriented Programming
- Repository Pattern

---

# Project Structure

```
library-system/

app/
├── Console/
├── Contracts/
├── Database/
│   ├── Database.php
│   ├── library.sql
│   ├── seed.sql
│   └── queries.sql
├── Entities/
├── Repositories/
│   ├── JsonBookRepository.php
│   └── MySqlBookRepository.php
├── Services/
└── README.md

index.php
```

---

# Database Schema

## Authors

| Column | Type |
|----------|------|
| id | INT |
| name | VARCHAR |
| email | VARCHAR |
| country | VARCHAR |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## Categories

| Column | Type |
|----------|------|
| id | INT |
| name | VARCHAR |
| description | TEXT |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## Books

| Column | Type |
|----------|------|
| id | INT |
| title | VARCHAR |
| isbn | VARCHAR |
| published_year | YEAR |
| author_id | INT |
| category_id | INT |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

Foreign Keys

- author_id → authors(id)
- category_id → categories(id)

---

## Borrowers

| Column | Type |
|----------|------|
| id | INT |
| name | VARCHAR |
| email | VARCHAR |
| phone | VARCHAR |
| address | TEXT |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## Borrow Records

| Column | Type |
|----------|------|
| id | INT |
| book_id | INT |
| borrower_id | INT |
| borrow_date | DATE |
| return_date | DATE |
| status | VARCHAR |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

Foreign Keys

- book_id → books(id)
- borrower_id → borrowers(id)

---

# ER Diagram

Relationships

- One Author can write many Books.
- One Category can contain many Books.
- One Person can borrow many Books.
- One Book can be borrowed multiple times.

---

# Normalization

The database is normalized to Third Normal Form (3NF).

### First Normal Form (1NF)

- No violation of atomicity.
- No repeating groups.
- Each field stores a single value.

### Second Normal Form (2NF)

- No partial Dependency.
- Every non-key attribute depends on the whole primary key.

### Third Normal Form (3NF)

- No transitive dependencies.
- Author and Category information are stored in separate tables to avoid redundancy.


### Boyce-Codd Normal Form (BCNF)

- Every determinant in each table is a candidate key.
- isbn is enforced as UNIQUE in the Books table, so no non-key determinant introduces anomalies.

---

# Architecture

The application is layered into three parts: LibraryApplication (console entry point), LibraryService (business logic), and a repository layer accessed only through BookRepositoryInterface. LibraryApplication and LibraryService depend only on the interface, not on a concrete repository.

## Repository Pattern

The application follows the Repository Pattern.

```
LibraryApplication
        │
        v
   LibraryService
        │
        v
BookRepositoryInterface
        │
        ├── JsonBookRepository
        └── MySqlBookRepository
```

The business logic depends only on the interface.

Changing the storage mechanism does not require changes to:

- LibraryService
- LibraryApplication
- BookRepositoryInterface

Only the repository implementation changes.

## Database Connection

The project uses a dedicated Database class.

```php
class Database
{
    public function getConnection(): PDO
}
```

The class creates a reusable PDO connection with proper error handling.

---

# Installation

## 1. Requirements

- PHP 8.x
- MySQL Server
- MySQL command line client

## 2. Create the database

Open MySQL Command Line.

Run:

```sql
SOURCE app/Database/library.sql;
```

This creates:

- Database
- Tables
- Constraints
- Indexes

---

## 3. Insert sample data

```sql
SOURCE app/Database/seed.sql;
```

---

## 4. Configure the database

Update the connection settings.

```php
$host = "127.0.0.1";
$dbname = "Library_System";
$user = "root";
$password = "your_password";
```

---

## Run the application

```bash
php index.php
```
---

# Usage

Once running, the console displays a menu of operations. Choose an option by entering its number and pressing Enter:

- Add a new book
- View all books
- Search books
- Update book information
- Delete a book
- Manage authors
- Manage categories
- Manage borrowers
- Borrow a book
- Return a book

The application reads from and writes to MySQL through MySqlBookRepository, so any changes made are persisted in the database.

---

# SQL Files

## library.sql

Contains

- CREATE DATABASE
- CREATE TABLE
- PRIMARY KEY
- FOREIGN KEY
- UNIQUE Constraints

---

## seed.sql

Contains sample records for

- Authors
- Categories
- Books
- Borrowers
- Borrow Records

---

## queries.sql

Contains solutions for:

- Show all books with authors
- Books by category
- Borrowed books
- Never borrowed books
- Most borrowed books
- Borrowers with more than three books
- Authors with more than five books
- Overdue books
- Books in each category
- Last five borrowed books

---

# Git Workflow

Example commit messages

- Design ER diagram
- Create authors table
- Create categories table
- Create books table
- Create borrowers table
- Create borrow_records table
- Add foreign key constraints
- Add indexes
- Implement PDO database connection
- Implement MySqlBookRepository
- Replace JSON repository
- Write SQL challenge queries
- Improve README documentation

---

# Author

**Ahmad Subhan**

BSCS Student

Library Management System Project