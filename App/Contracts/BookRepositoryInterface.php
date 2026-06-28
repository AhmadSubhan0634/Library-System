<?php

namespace App\Contracts;

require_once __DIR__ . '/../Entities/Book.php';

use App\Entities\Book;

interface BookRepositoryInterface
{
    public function getAll(): array;
    public function findByISBN(string $isbn): ?Book;
    public function findByTitle(string $title): array;
    public function save(Book $book): void;
    public function update(string $isbn, array $data): bool;
    public function delete(string $isbn): bool;
}