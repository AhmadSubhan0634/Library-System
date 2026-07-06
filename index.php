<?php

require_once __DIR__ . '/App/Entities/Book.php';
require_once __DIR__ . '/App/Entities/LibraryBook.php';
require_once __DIR__ . '/App/Contracts/BookRepositoryInterface.php';
require_once __DIR__ . '/App/Database/Database.php';
require_once __DIR__ . '/App/Repositories/mysqlBookRepository.php';
require_once __DIR__ . '/App/Services/LibraryService.php';
require_once __DIR__ . '/App/Console/LibraryApplication.php';

use App\Database\Database;
use App\Repositories\mysqlBookRepository;
use App\Services\LibraryService;
use App\Console\LibraryApplication;

$database= new Database();

$repository = new mysqlBookRepository($database);
$service = new LibraryService($repository);
$app = new LibraryApplication($service);

$app->run();
