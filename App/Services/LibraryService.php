<?php

namespace App\Services;

require_once __DIR__ . '/../Contracts/BookRepositoryInterface.php';
require_once __DIR__ . '/../Entities/Book.php';
require_once __DIR__ . '/../Entities/LibraryBook.php';

use App\Contracts\BookRepositoryInterface;
use App\Entities\Book;
use App\Entities\LibraryBook;

class LibraryService
{
    private BookRepositoryInterface $repo;

    public function __construct(BookRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function addBook(string $title, string $author, string $isbn, string $category, int $year): string
    {
        if ($this->repo->findByISBN($isbn) !== null) {
            return "Error: A book with ISBN '$isbn' already exists.";
        }
        $book = new LibraryBook($title, $author, $isbn, $category, $year);
        $this->repo->save($book);
        return "Book '$title' added successfully.";
    }

    public function listBooks(): array
    {
        return $this->repo->getAll();
    }

    public function searchByTitle(string $title): array
    {
        return $this->repo->findByTitle($title);
    }

    public function searchByISBN(string $isbn): ?Book
    {
        return $this->repo->findByISBN($isbn);
    }

    public function updateBook(string $isbn, array $data): string
    {
        $updated = $this->repo->update($isbn, $data);
        return $updated
            ? "Book updated successfully."
            : "Error: No book found with ISBN '$isbn'.";
    }

    public function deleteBook(string $isbn): string
    {
        $deleted = $this->repo->delete($isbn);
        return $deleted
            ? "Book deleted successfully."
            : "Error: No book found with ISBN '$isbn'.";
    }
}
