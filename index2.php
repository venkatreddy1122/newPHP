<?php
require 'vendor/autoload.php';
require 'src/BookController.php';
require 'src/AuthorController.php';


// Book endpoints
$app->get('/books', 'BookController:getAllBooks');
$app->get('/books/{id}', 'BookController:getBookById');
$app->post('/books', 'BookController:createBook');
$app->put('/books/{id}', 'BookController:updateBook');
$app->delete('/books/{id}', 'BookController:deleteBook');

// Author endpoints
$app->get('/authors', 'AuthorController:getAllAuthors');
$app->get('/authors/{id}', 'AuthorController:getAuthorById');
$app->post('/authors', 'AuthorController:createAuthor');
$app->put('/authors/{id}', 'AuthorController:updateAuthor');
$app->delete('/authors/{id}', 'AuthorController:deleteAuthor');

$app->run();
?>
