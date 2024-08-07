<?php
class BookController {
    private $db;

    public function __construct() {
        $this->db = new PDO('sqlite:library.db');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->initializeDatabase();
    }

    private function initializeDatabase() {
        $this->db->exec("CREATE TABLE IF NOT EXISTS books (
            id INTEGER PRIMARY KEY,
            title TEXT,
            author_id INTEGER,
            published_date TEXT,
            FOREIGN KEY (author_id) REFERENCES authors (id)
        )");

        $this->db->exec("CREATE TABLE IF NOT EXISTS authors (
            id INTEGER PRIMARY KEY,
            name TEXT,
            biography TEXT
        )");
    }

    public function getAllBooks($request, $response, $args) {
        $stmt = $this->db->query('SELECT * FROM books');
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $response->withJson($books);
    }

    public function getBookById($request, $response, $args) {
        $stmt = $this->db->prepare('SELECT * FROM books WHERE id = :id');
        $stmt->bindParam(':id', $args['id']);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        return $response->withJson($book);
    }

    public function createBook($request, $response, $args) {
        $input = $request->getParsedBody();
        $stmt = $this->db->prepare('INSERT INTO books (title, author_id, published_date) VALUES (:title, :author_id, :published_date)');
        $stmt->bindParam(':title', $input['title']);
        $stmt->bindParam(':author_id', $input['author_id']);
        $stmt->bindParam(':published_date', $input['published_date']);
        $stmt->execute();
        return $response->withJson(['id' => $this->db->lastInsertId()]);
    }

    public function updateBook($request, $response, $args) {
        $input = $request->getParsedBody();
        $stmt = $this->db->prepare('UPDATE books SET title = :title, author_id = :author_id, published_date = :published_date WHERE id = :id');
        $stmt->bindParam(':id', $args['id']);
        $stmt->bindParam(':title', $input['title']);
        $stmt->bindParam(':author_id', $input['author_id']);
        $stmt->bindParam(':published_date', $input['published_date']);
        $stmt->execute();
        return $response->withJson(['message' => 'Book updated']);
    }

    public function deleteBook($request, $response, $args) {
        $stmt = $this->db->prepare('DELETE FROM books WHERE id = :id');
        $stmt->bindParam(':id', $args['id']);
        $stmt->execute();
        return $response->withJson(['message' => 'Book deleted']);
    }
}
?>
