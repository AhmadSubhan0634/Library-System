<?php
require_once __DIR__ . '/App/Entities/Book.php';
require_once __DIR__ . '/App/Entities/LibraryBook.php';
require_once __DIR__ . '/App/Services/Library.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library_System</title>
    
    <style>
        /* Set the image as background */
        body {
            background-image: url('https://th.bing.com/th/id/R.35840fbef8314c640f9a09f3f917b9bf?rik=UOmCKbiB6cijQQ&riu=http%3a%2f%2fwww.pixelstalk.net%2fwp-content%2fuploads%2f2016%2f08%2fHD-Library-Wallpaper.jpg&ehk=fWuJgfNqg3VG4VT26EAm0NXdvqhXaVLXyrdddUn3h%2fQ%3d&risl=&pid=ImgRaw&r=0');
            background-size: cover; /* Makes image cover entire screen */
            background-position: center; /* Centers the image */
            background-repeat: no-repeat; /* Prevents repeating */
            background-attachment: fixed; /* Image stays fixed while scrolling */
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Semi-transparent overlay for better text readability */
        .overlay {
            background: rgba(0, 0, 0, 0.5); /* Dark overlay */
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        /* Content container with white background for better readability */
        .content {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border-radius: 15px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        
        h3 {
            color: #2c3e50;
            font-size: 28px;
            margin-top: 0;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }
        
        p {
            color: #34495e;
            font-size: 18px;
            margin: 20px 0;
        }
        
        ol {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        
        ol li {
            margin: 15px 0;
        }
        
        ol li a {
            display: inline-block;
            background: #3498db;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 80%;
            max-width: 300px;
        }
        
        ol li a:hover {
            background: #2980b9;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        /* Remove the old img tag styling */
        .lib {
            display: none; /* Hides the img tag */
        }
    </style>
</head>
<body>
    <!-- Semi-transparent overlay to make text readable -->
    <div class="overlay">
        <div class="content">
            <h3>Welcome to the console based library management system</h3>
            <ol>

            <li><a href="App/Entities/Book.php"> Add a book to the library   </a></li>
            <li><a href="App/Entities/LibraryBook.php"> Delete a book from the library  </a></li>
            <li><a href="App/Services/Library.php"> List all books in the library  </a></li>
            <li><a href="App/Entities/LibraryBook.php"> Search for a book in the library   </a></li>
            <li><a href="App/Entities/LibraryBook.php"> Update a book in the library  </a></li>

            </ol>
        </div>
    </div>
    
    <img class="lib" src="https://th.bing.com/th/id/R.35840fbef8314c640f9a09f3f917b9bf?rik=UOmCKbiB6cijQQ&riu=http%3a%2f%2fwww.pixelstalk.net%2fwp-content%2fuploads%2f2016%2f08%2fHD-Library-Wallpaper.jpg&ehk=fWuJgfNqg3VG4VT26EAm0NXdvqhXaVLXyrdddUn3h%2fQ%3d&risl=&pid=ImgRaw&r=0" alt="Library" width="1000">
</body>
</html>