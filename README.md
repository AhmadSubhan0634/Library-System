# Library Management System

A PHP console app for managing a library — books, authors, categories, borrowers, the whole thing. Built as a way to actually practice OOP and the Repository Pattern instead of just reading about them.

---

## Project Overview

This started as a simple console app to add, list, search, update, and delete books. Under the hood it's built around a few OOP principles and, most importantly, the Repository Pattern — the idea being that the business logic shouldn't care *how* data gets stored, just that it can ask for it.

I actually put that to the test partway through: the app originally saved everything to a JSON file, and I later swapped it over to a real MySQL database. The business logic (`LibraryService`) didn't need a single line changed — only the repository underneath it did. That's basically the whole point of this project.

### What it can do

- Add new books
- View all books
- Search for a book by ISBN
- Update book info
- Delete books
- Store everything in MySQL through PDO
- Swap storage backends (JSON or MySQL) without touching the service layer

### Built with

- PHP 8.x
- MySQL
- PDO
- OOP
- Repository Pattern

---

## Architecture

The app is split into three layers:

`LibraryApplication` (the console menu) → `LibraryService` (the actual logic) → `BookRepositoryInterface` (just a contract), which is implemented by either `JsonBookRepository` or `MySqlBookRepository`.

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

Nothing above the interface knows or cares which repository is plugged in. That's what let me switch from JSON to MySQL without rewriting the service or the CLI.

### Database connection

There's a small `Database` class that just hands out a PDO connection (and reuses the same one instead of reconnecting every time):

```php
class Database
{
    public function getConnection(): PDO
}
```

### Database schema

**Authors**

| Column | Type |
|---|---|
| id | INT |
| name | VARCHAR |
| email | VARCHAR |
| country | VARCHAR |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

**Categories**

| Column | Type |
|---|---|
| id | INT |
| name | VARCHAR |
| description | TEXT |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

**Books**

| Column | Type |
|---|---|
| id | INT |
| title | VARCHAR |
| isbn | VARCHAR |
| published_year | YEAR |
| author_id | INT |
| category_id | INT |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

Foreign keys: `author_id → authors(id)`, `category_id → categories(id)`

**Borrowers**

| Column | Type |
|---|---|
| id | INT |
| name | VARCHAR |
| email | VARCHAR |
| phone | VARCHAR |
| address | TEXT |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

**Borrow Records**

| Column | Type |
|---|---|
| id | INT |
| book_id | INT |
| borrower_id | INT |
| borrow_date | DATE |
| return_date | DATE |
| status | VARCHAR |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

Foreign keys: `book_id → books(id)`, `borrower_id → borrowers(id)`

### How things relate

- An author can write many books.
- A category can hold many books.
- A borrower can borrow many books.
- A single book can be borrowed over and over (each borrow gets its own record).

### Normalization

Kept this at 3NF (and it holds up to BCNF too):

- **1NF** — every field holds one value, no repeating groups.
- **2NF** — non-key fields depend on the whole primary key, not just part of it.
- **3NF** — author and category details live in their own tables instead of being duplicated on every book row.
- **BCNF** — `isbn` is `UNIQUE` on the books table, so there's no non-key field that could quietly cause anomalies.

---

## Folder Structure

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

## Installation

### 1. What you'll need

- PHP 8.x
- MySQL Server
- The MySQL command line client

### 2. Set up the database

Open the MySQL CLI and run:

```sql
SOURCE app/Database/library.sql;
```

That takes care of the database itself, the tables, and all the constraints.

### 3. Load some sample data (optional but recommended)

```sql
SOURCE app/Database/seed.sql;
```

### 4. Point it at your database

Update the connection details wherever `Database` gets instantiated:

```php
$host = "127.0.0.1";
$dbname = "Library_System";
$user = "root";
$password = "your_password";
```

---

## Running the Program

From the project root:

```bash
php index.php
```

You'll get a menu:

- Add a new book
- View all books
- Search for a book (by ISBN)
- Update book info
- Delete a book
- Exit

Everything you do goes straight through `MySqlBookRepository` into the database, so it's persisted immediately — nothing's cached in memory between runs.

### What's in the SQL files

- **library.sql** — creates the database, tables, and all the constraints (primary/foreign keys, unique on ISBN, etc.)
- **seed.sql** — sample authors, categories, books, borrowers, and borrow records so there's actually something to look at
- **queries.sql** — a handful of reference queries I wrote while testing things: books with their authors, books by category, which books have never been borrowed, most-borrowed books, borrowers with more than 3 books out, overdue books, and so on

---

## Design Decisions

A few choices here weren't the "default" way of doing things, so I wanted to explain why.

### Updates take a full object, not a partial array

`BookRepositoryInterface::update()` takes a whole `Book` object rather than something like `(string $isbn, array $data)`. I went back and forth on this, but landed on the full object because:

- It's one strongly-typed contract — no chance of a typo'd array key (`'tittle'` instead of `'title'`) silently doing nothing.
- Both repositories stay simple. They just overwrite the whole record every time instead of having to figure out which fields actually changed.

The downside: the CLI's "leave a field blank to keep it as-is" behavior can't live in the repository anymore. That logic moved into `LibraryService::updateBook()` instead — it grabs the existing book, only overwrites the fields the user actually typed something for, and hands the finished object down to `update()`. So the repository stays dumb and typed, and the "partial update" convenience lives where it's actually needed.

### Cleaning up ISBN casing

Early on I had `$ISBN`, `$isbn`, and `getISBN()`/`getIsbn()` all floating around inconsistently between the entity, mapper, and repositories. PHP treats differently-cased *properties* as genuinely different things (even though method names are case-insensitive), so this was a bug waiting to happen. Standardized everything to `isbn` — lowercase for properties/variables, consistent casing on the methods.

### How errors are handled

Storage failures — bad file reads, corrupted JSON, failed queries — get thrown as `\RuntimeException` from both repositories instead of getting swallowed quietly:

- `JsonBookRepository` treats "the file doesn't exist yet" (fine, just return an empty list) very differently from "the file exists but is corrupted" (throw). Earlier on I hadn't made that distinction, and a corrupted data file just looked like an empty library — meaning the very next save would happily overwrite it and wipe out everything that was there.
- `MySqlBookRepository` relies on PDO's `ERRMODE_EXCEPTION` mode so a failed query actually throws instead of failing silently.

Where those exceptions get caught depends on what the calling method returns:

- `addBook`, `updateBook`, and `deleteBook` already return a status string, so they catch the exception and turn it into a normal-looking error message.
- `listBooks`, `searchByTitle`, and `searchByisbn` return actual data, so there's no string to fold an error into — they just let the exception bubble up, and `LibraryApplication` catches it at the top level so the app prints an error instead of crashing outright.

---

## Future Improvements

- **Actually validate the `Book` entity**: right now `Book` will happily accept a blank title, a blank ISBN, or a negative year without complaint. Moving that validation into the constructor/setters (and throwing `InvalidArgumentException` when something's off) would catch bad data right at the source instead of relying entirely on CLI-level checks. This also ties into a real bug: `LibraryApplication::addBook()` hardcodes the upper year bound as `2026`, which will start rejecting perfectly valid books the moment that year passes — it should be `date('Y') + 1` instead. And `updateBook()` doesn't validate the year at all right now, so it's possible to add a book with a valid year and then "update" it into an invalid one.
- **More specific exception types**: everything storage-related throws a generic `\RuntimeException` right now. Splitting these into something like `StorageException` vs `DataCorruptionException` would let calling code actually react differently depending on what went wrong.
- **Finish the Author/Category/Borrower/Borrow Record features**: the database already supports all of this, but right now only books have a repository and CLI flow behind them. These would just follow the same pattern already in place.
- **Get credentials out of the code**: `Database.php` currently has real-looking hardcoded connection details, including a password, sitting in plain PHP. That needs to move to a `.env` file or similar, and honestly that password should get rotated regardless.
- **Add actual tests**: there aren't any yet. Since the repository pattern is already there, `BookRepositoryInterface` is a natural seam to test `LibraryService` against a fake/in-memory repository, plus separate tests per repository implementation.
- **Pagination on `listBooks()`**: fine for a handful of books, but `getAll()` currently loads and prints every single record at once — that won't hold up once the library actually grows.
- **Some kind of logging**: right now, a storage failure just prints once to whoever happens to be sitting at the terminal. A simple log file would make it a lot easier to figure out what went wrong later.

---

## Author

**Ahmad Subhan**

BSCS Student

Library Management System Project