<?php

namespace App\Entities;

require_once __DIR__ . '/Book.php';

class LibraryBook extends Book{
    public function __construct(string $title = "",string $author = "",string $ISBN = "",string $category = "",int $year = 0) {
        parent::__construct($title, $author, $ISBN, $category, $year);
    }

    public function updateTitle(): void{
        echo "Enter new title: ";
        $this->setTitle(trim(fgets(STDIN)));
    }

    public function updateAuthor(): void{
        echo "Enter new author: ";
        $this->setAuthor(trim(fgets(STDIN)));
    }

    public function updateCategory(): void{
        echo "Enter new category: ";
        $this->setCategory(trim(fgets(STDIN)));
    }

    public function updateYear(): void{
        echo "Enter new year: ";
        $this->setYear((int) trim(fgets(STDIN)));
    }

    public function updateISBN(): void{
        echo "Enter new ISBN: ";
        $this->setISBN(trim(fgets(STDIN)));
    }

    public function printBook(): void{
        echo "Title: " . $this->getTitle() . "\n";
        echo "Author: " . $this->getAuthor() . "\n";
        echo "ISBN: " . $this->getISBN() . "\n";
        echo "Category: " . $this->getCategory() . "\n";
        echo "Year: " . $this->getYear() . "\n";
    }

    public function toArray(): array{
        return [
            'title' => $this->getTitle(),
            'author' => $this->getAuthor(),
            'isbn' => $this->getISBN(),
            'category' => $this->getCategory(),
            'year' => $this->getYear(),
        ];
    }

    public static function fromArray(array $data): self{
        return new self(
            $data['title'],
            $data['author'],
            $data['isbn'],
            $data['category'],
            (int) $data['year']
        );
    }
}