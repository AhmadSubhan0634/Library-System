<?php
class LibraryBook extends Book{

	// Default Constructor
	public function __construct() {
        parent:: __construct();
    }

	public function UpdateTitle() {
		echo "Enter new title of the book: ";
		$newTitle = readline();
        echo"<br>";
		$this->setTitle($newTitle);
	}

	public function UpdateAuthor() {
		echo "Enter new name of the author of book: ";
		$newAuthor = readline();
        echo"<br>";
		$this->setAuthor($newAuthor);
	}

	public function UpdateCategory() {
		echo "Enter new category of the book: ";
		$newCategory = readline();
        echo"<br>";
		$this->setCategory($newCategory);
	}

	public function updateYear() {
		echo "Enter updated year of the book:";
		$newYear = (int)readline();
        echo"<br>";
		$this->setYear($newYear);
	}

	public function updateISBN() {
		echo "Enter new ISBN of the book: ";
		$newISBN = (int)readline();
        echo"<br>";
		$this->setISBN($newISBN);
	}

	public function PrintBook() {
		echo "Title of the book is: " . $this->getTitle() . "<br>";
		echo "Author of the book is: " . $this->getAuthor() . "<br>";
		echo "ISBN of the book is: " . $this->getISBN() . "<br>";
		echo "Category of the book is: " . $this->getCategory() . "<br>";
		echo "Year of publish of book is: " . $this->getYear() . "<br>";
	}
}
?>