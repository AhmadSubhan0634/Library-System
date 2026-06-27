<?php
require_once __DIR__ . '/..' . '/Entities/LibraryBook.php';
class Library {

	private $books=array();
	private $bookCount=0;


	// Constructor
	public function __construct() {
		for ($i = 0; $i < 100; $i++) {
			$this->books[$i] = null;
		}
		$this->bookCount = 0;
	}

    // Search function to find a book by its ISBN
	public function SearchBook($ISBN) {
		for ($i = 0; $i < 100; $i++) {
			if (isset($this->books[$i]) && $this->books[$i]->getISBN() == $ISBN) {
				$books[$i]->PrintBook();
				return true;
			}
		}
		return false;
	}

    // Function to add a new book to the library
	public function AddBook($book) {
		for ($i = 0; $i < 100; $i++) {
			if (!isset($books[$i])) {
				$books[$i] = $book;
				$bookCount++;
				break;
			}
		}
	}

    // Function to delete a book from the library
	public function DeleteBook($ISBN) {
		for ($i = 0; $i < 100; $i++) {
			if (isset($books[$i]) && $books[$i]->getISBN() == $ISBN) {
				unset($books[$i]);
				$bookCount--;
				return true;
			}
		}
		return false;
	}

    // Function to list all books in the library
	public function ListBooks() {
		echo "Total books in library are: " . $bookCount . "<br><br>";
		for ($i = 0; $i < 100; $i++) {
			if (isset($books[$i])) {
				$books[$i]->PrintBook();
				echo "<br>";
			}
		}
	}

    // Function to update the details of a book in the library
	public function UpdateBook($ISBN) {
		for ($i = 0; $i < 100; $i++) {
			if (isset($books[$i]) && $books[$i]->getISBN() == $ISBN) {
				$books[$i]->UpdateTitle();
				$books[$i]->UpdateAuthor();
				$books[$i]->UpdateCategory();
				$books[$i]->updateYear();
				$books[$i]->updateISBN();
				return true;
			}
		}
		return false;
	}
}

?>