<?php

require_once __DIR__ . "/../inc/init.php";

$db = \BibleApi\Database::get_instance();
$books = $db->cols("SELECT name FROM books");
if (!$_GET['name']) {
  http_response_code(400);
  print_json($books);
}
$esc = $db->esc(strtolower($_GET['name']));
$book = $db->row("
  SELECT * 
  FROM books 
  WHERE LOWER(name) = '$esc' OR abbreviations like '$esc%'");
if (!$book) {
  http_response_code(400);
  print_json($books);
}

$rsp = [
  'name' => $book['name'],
  'testament' => $book['testament'] ? 'new' : 'old',
  'abbreviations' => json_decode($book['abbreviations'], true),
  'word_count' => $book['word_count'],
  'chapters' => $db->select("SELECT number number, verses FROM chapters WHERE book_id = $book[id]")
];

print_json($rsp);
