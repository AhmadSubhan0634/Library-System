<?php

namespace App\Console;

use App\Services\LibraryService;

class LibraryApplication{
    private LibraryService $service;

    public function __construct(LibraryService $service){
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
                    try { $this->addBook(); }
                    catch (\Throwable $e) { echo "Error Occured: " . $e->getMessage() . "\n"; }
                    break;
                case '2':
                    try { $this->listBooks(); }
                    catch (\Throwable $e) { echo "Error Occured: " . $e->getMessage() . "\n"; }
                    break;
                case '3': 
                    try { $this->searchBook(); }
                    catch (\Throwable $e) { echo "Error Occured: " . $e->getMessage() . "\n"; }
                    break;
                case '4': 
                    try { $this->updateBook(); }
                    catch (\Throwable $e) { echo "Error Occured: " . $e->getMessage() . "\n"; }
                    break;
                case '5': 
                    try { $this->deleteBook(); }
                    catch (\Throwable $e) { echo "Error Occured: " . $e->getMessage() . "\n"; }
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

        do{
        $title = $this->input("Enter title of the book: ");
        if($title==""){echo "Enter a valid title of a book.\n";}
        }while($title=="");

        do{
        $author = $this->input("Enter author of the book: ");
        if($author==""){echo "Enter a valid name of author.\n";}
        }while($author=="");

        do{
        $isbn = $this->input("Enter isbn of the book: ");
        if($isbn==""){echo "Enter a valid ISBN.\n";}
        }while($isbn=="");

        do{
        $category = $this->input("Enter category of the book: ");
        if($category==""){echo "Enter a valid category of book.\n";}
        }while($category=="");

        do{
        $year = (int) $this->input("Enter year of publication of the book: ");
        if($year>2027 or $year<1200){ echo "Enter a valid year for publish of book.\n";}
        }while($year>2027 or $year<1200);

        $message = $this->service->addBook($title, $author, $isbn, $category, $year);
        echo $message . "\n";
    }

    private function listBooks(): void{
        echo "\n-- Book List --\n";

        try {
            $books = $this->service->listBooks();
        } catch (\RuntimeException $e) {
            echo "Failed to load books (" . $e->getMessage() . ").\n";
            return;
        }

        if (empty($books)) {
            echo "No books found.\n";
            return;
        }

        foreach ($books as $i => $book) {
// CORRECT - using getters
        echo ($i + 1) . ". " . $book->getTitle() . " by author " . $book->getAuthor() . " .\nISBN of book is: " . $book->getisbn() . " .\nCategory of book is:" . $book->getCategory() . ".\nYear of publish of book was: " . $book->getYear() . "\n\n"; }
    }

    private function searchBook(): void{
        echo "\n-- Search Book --\n";

        $isbn = $this->input("Enter isbn: ");
        try {
            $book = $this->service->searchByisbn($isbn);
        } catch (\RuntimeException $e) {
            echo "Failed to search for book (" . $e->getMessage() . ").\n";
            return;
        }

        if ($book === null) {
            echo "No book is available in the library with that ISBN.\n";
        } else {
            echo "Found: " . $book->getTitle() . " by " . $book->getAuthor() . " .Category of book is " . $book->getCategory() . ". Book was published in  " . $book->getYear() . "\n";
        }
    }

    private function updateBook(): void{
        echo "\n-- Update Book --\n";
        $isbn = $this->input("Enter isbn of book to update: ");

        echo "Leave blank to keep current value.\n";
        $title = $this->input("Enter new Title of the book: ");
        $author = $this->input("Enter new Author of the book: ");
        $category = $this->input("Enter new Category of the book: ");
        $yearStr = $this->input("Enter new Year of publication of the book: ");

        $data=[
            'title'=>$title,
            'author'=> $author,
            'category'=> $category
        ];
        if($yearStr!==''){
            $data['year']=(int)$yearStr;
        }

        $message = $this->service->updateBook($isbn, $data);
        echo $message . "\n";
    }

    private function deleteBook(): void{
        echo "\n-- Delete Book --\n";
        $isbn = $this->input("Enter isbn of book to delete: ");
        $message = $this->service->deleteBook($isbn);
        echo $message . "\n";
    }

    private function input(string $prompt): string{
        echo $prompt;
        return trim(fgets(STDIN));
    }
}