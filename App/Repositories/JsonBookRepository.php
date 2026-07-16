<?php

namespace App\Repositories;

require_once __DIR__ . '/../Contracts/BookRepositoryInterface.php';
require_once __DIR__ . '/../Entities/Book.php';
require_once __DIR__ . '/../Mappers/BookMapper.php';

use App\Contracts\BookRepositoryInterface;
use App\Entities\Book;
use App\Mappers\BookMapper;

class JsonBookRepository implements BookRepositoryInterface{
    private string $filePath;

    public function __construct(string $filePath){
        $this->filePath = $filePath;
    }

    private function readAll(): array{
        if (!file_exists($this->filePath)) {
            return [];
        }

        $json = file_get_contents($this->filePath);
        if ($json === false) {
            throw new \RuntimeException("Failed to read book data file: {$this->filePath}");
        }

        if (trim($json) === '') {
            return [];
        }

        $result = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Failed to parse book data file '{$this->filePath}': " . json_last_error_msg());
        }

        return $result ?? [];
    }

    private function writeAll(array $books): void{
        $json = json_encode($books, JSON_PRETTY_PRINT);
        if ($json === false) {
            throw new \RuntimeException("Failed to encode book data: " . json_last_error_msg());
        }

        $written = file_put_contents($this->filePath, $json);
        if ($written === false) {
            throw new \RuntimeException("Failed to write book data file: {$this->filePath}");
        }
    }

    public function getAll(): array{
        $data = $this->readAll();
        return array_map(fn($b) => BookMapper::fromArray($b), $data);
    }

    public function findByisbn(string $isbn): ?Book{
        foreach ($this->readAll() as $book) {
            if ($book['isbn'] === $isbn) {
                return BookMapper::fromArray($book);
            }
        }
        return null;
    }

    public function findByTitle(string $title): array{
        $results = [];
        foreach ($this->readAll() as $book) {
            if (stripos($book['title'], $title) !== false) {
                $results[] = BookMapper::fromArray($book);
            }
        }
        return $results;
    }

    public function save(Book $book): void{
        $books   = $this->readAll();
        $books[] = BookMapper::toArray($book);
        $this->writeAll($books);
    }

    public function update(Book $book): bool{
    $books = $this->readAll();
    foreach ($books as $index => $existing) {
        if ($existing['isbn'] === $book->getIsbn()) {
            $books[$index] = BookMapper::toArray($book);
            $this->writeAll($books);
            return true;
        }
    }
    return false;
    }

    public function delete(string $isbn): bool{
        $books    = $this->readAll();
        $filtered = array_filter($books, fn($b) => $b['isbn'] !== $isbn);
        if (count($filtered) === count($books)) {
            return false;
        }
        $this->writeAll(array_values($filtered));
        return true;
    }
}