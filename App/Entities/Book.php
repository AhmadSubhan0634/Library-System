<?php

namespace App\Entities;

class Book{
    public string $title;
    public string $author;
    public string $ISBN;
    public string $category;
    public int $year;

    // Default constructor
    public function __construct(string $title = "",string $author = "",string $ISBN = "",string $category = "",int $year = 0) {
        $this->title = $title;
        $this->author = $author;
        $this->ISBN = $ISBN;
        $this->category = $category;
        $this->year = $year;
    }

    // Getters
    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getISBN(): string { return $this->ISBN; }
    public function getCategory(): string { return $this->category; }
    public function getYear(): int { return $this->year; }

    // Setters
    public function setTitle(string $title): void { $this->title = $title; }
    public function setAuthor(string $author): void { $this->author = $author; }
    public function setISBN(string $ISBN): void { $this->ISBN = $ISBN; }
    public function setCategory(string $category): void { $this->category = $category; }
    public function setYear(int $year): void { $this->year = $year; }
}
