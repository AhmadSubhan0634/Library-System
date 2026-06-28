<?php

namespace App\Console;

use App\Services\LibraryService;

class LibraryApplication
{
    private LibraryService $service;

    public function __construct(LibraryService $service)
    {
        $this->service = $service;
    }

    public function run(): void
    {
        echo "\n********** Library Management System *********\n";

        while (true) {
            $this->showMenu();
            $choice = $this->input("Choose an option: ");

            switch ($choice) {
                case '1':
                    $this->addBook();
                    break;
                case '2':
                    $this->listBooks();  
                    break;
                case '3': 
                    $this->searchBook(); 
                    break;
                case '4': 
                    $this->updateBook(); 
                    break;
                case '5': 
                    $this->deleteBook(); 
                    break;
                case '6':
                    echo "Goodbye!\n";
                    exit(0);
                default:
                    echo "Invalid option. Please try again.\n";
            }

            echo "\n";
        }
    }

    private function showMenu(): void
    {
        echo "\n*=========== Menu ===========*\n";
        echo "| 1. Add Book                |\n";
        echo "| 2. List Books              |\n";
        echo "| 3. Search Book             |\n";
        echo "| 4. Update Book             |\n";
        echo "| 5. Delete Book             |\n";
        echo "| 6. Exit                    |\n";
        echo "------------------------------\n";
    }

    private function addBook(): void{
        echo "-- Add Book --\n";
        $title = $this->input("Enter title of the book: ");
        $author = $this->input("Enter author of the book: ");
        $isbn = $this->input("Enter ISBN of the book: ");
        $category = $this->input("Enter category of the book: ");
        $year = (int) $this->input("Enter year of publication of the book: ");

        $message = $this->service->addBook($title, $author, $isbn, $category, $year);
        echo $message . "\n";
    }

    private function listBooks(): void{
        echo "\n-- Book List --\n";
        $books = $this->service->listBooks();

        if (empty($books)) {
            echo "No books found.\n";
            return;
        }

        foreach ($books as $i => $book) {
// CORRECT - using getters
        echo ($i + 1) . ". " . $book->getTitle() . " by " . $book->getAuthor() . " ISBN of book is: " . $book->getISBN() . " Category of book is:" . $book->getCategory() . ".Year of publish of book was: " . $book->getYear() . "\n"; }
    }

    private function searchBook(): void{
        echo "\n-- Search Book --\n";

        $isbn = $this->input("Enter ISBN: ");
        $book = $this->service->searchByISBN($isbn);
        if ($book === null) {
            echo "No book is available in the library with that ISBN.\n";
        } else {
            echo "Found: " . $book->getTitle() . " by " . $book->getAuthor() . " .Category of book is " . $book->getCategory() . ". Book was published in  " . $book->getYear() . "\n";
        }
    }

    private function updateBook(): void{
        echo "\n-- Update Book --\n";
        $isbn = $this->input("Enter ISBN of book to update: ");

        echo "Leave blank to keep current value.\n";
        $title = $this->input("Enter new Title of the book: ");
        $author = $this->input("Enter new Author of the book: ");
        $category = $this->input("Enter new Category of the book: ");
        $yearStr = $this->input("Enter new Year of publication of the book: ");

        $data = [
            'title'    => $title,
            'author'   => $author,
            'category' => $category,
            'year'     => $yearStr !== '' ? (int) $yearStr : '',
        ];

        $message = $this->service->updateBook($isbn, $data);
        echo $message . "\n";
    }

    private function deleteBook(): void{
        echo "\n-- Delete Book --\n";
        $isbn = $this->input("Enter ISBN of book to delete: ");
        $message = $this->service->deleteBook($isbn);
        echo $message . "\n";
    }

    private function input(string $prompt): string{
        echo $prompt;
        return trim(fgets(STDIN));
    }
}
