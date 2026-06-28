<?php

require_once __DIR__ . '/App/Entities/Book.php';
require_once __DIR__ . '/App/Entities/LibraryBook.php';
require_once __DIR__ . '/App/Contracts/BookRepositoryInterface.php';
require_once __DIR__ . '/App/Repositories/JsonBookRepository.php';
require_once __DIR__ . '/App/Services/LibraryService.php';
require_once __DIR__ . '/App/Console/LibraryApplication.php';

use App\Repositories\JsonBookRepository;
use App\Services\LibraryService;
use App\Console\LibraryApplication;

$storagePath = __DIR__ . '/storage/books.json';

$repository = new JsonBookRepository($storagePath);
$service = new LibraryService($repository);
$app = new LibraryApplication($service);

$app->run();
