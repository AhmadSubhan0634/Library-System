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
        $result = json_decode($json, true);
        if ($result === null) {
            return [];
        }
        return $result;
    }

    private function writeAll(array $books): void{
        file_put_contents($this->filePath, json_encode($books, JSON_PRETTY_PRINT));
    }

    public function getAll(): array{
        $data = $this->readAll();
        return array_map(fn($b) => BookMapper::fromArray($b), $data);
    }

    public function findByISBN(string $isbn): ?Book{
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

    public function update(string $isbn, array $data): bool{
        $books = $this->readAll();
        foreach ($books as &$book) {
            if ($book['isbn'] === $isbn) {
                foreach ($data as $key => $value) {
                    if (array_key_exists($key, $book) && $value !== '') {
                        $book[$key] = $value;
                    }
                }
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