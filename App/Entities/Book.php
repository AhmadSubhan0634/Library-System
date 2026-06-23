<?php
class Book{
    private $title;
    private $author;
    private $ISBN;
    private $category;
    private $year;

	// Default Constructors
    public function __construct() {
		$this->title = "";
		$this->author = "";
		$this->ISBN = 0;
		$this->category = "";
		$this->year = 0;
	}


	// Getters
	public function getTitle() { return $this->title; }
	public function getAuthor() { return $this->author; }
	public function getISBN() { return $this->ISBN; }
	public function getCategory() { return $this->category; }
	public function getYear() { return $this->year; }


	// Setters
	public function setTitle(string $title) { $this->title = $title; }
	public function setAuthor(string $author) { $this->author = $author; }
	public function setISBN(int $ISBN) { $this->ISBN = $ISBN; }
	public function setCategory(string $category) { $this->category = $category; }
	public function setYear(int $year) { $this->year = $year; }

}
?>