<?php

require_once __DIR__ . '/App/Entities/Book.php';
require_once __DIR__ . '/App/Contracts/BookRepositoryInterface.php';
require_once __DIR__ . '/App/Database/Database.php';
require_once __DIR__ . '/App/Repositories/MySqlBookRepository.php';
require_once __DIR__ . '/App/Services/LibraryService.php';
require_once __DIR__ . '/App/Console/LibraryApplication.php';

use App\Database\Database;
use App\Repositories\MySqlBookRepository;
use App\Services\LibraryService;
use App\Console\LibraryApplication;

$database= new Database();

$repository = new MySqlBookRepository($database);
$service = new LibraryService($repository);
$app = new LibraryApplication($service);

$app->run();
