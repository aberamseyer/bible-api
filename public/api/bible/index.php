<?php

require_once __DIR__ . "/../../inc/init.php";

$db = \BibleApi\Database::get_instance();
$books = array_column($db->select("SELECT id, LOWER(REPLACE(name, ' ', '-')) name FROM books"), 'name', 'id');

$p = explode('/', $_SERVER['REQUEST_URI']);
$chapter = $book = $verse = false;
while ($p && (!$p[0] || in_array($p[0], ['api', 'bible'], true))) array_shift($p);
while ($p && !$p[count($p) - 1]) array_pop($p);

switch (count($p)) {
  case 3:
    list($book, $chapter, $verse) = $p;
    break;
  case 2:
    list($book, $chapter) = $p;
    break;
  case 1:
    list($book) = $p;
    break;
  default:
    print_json([]);
}

$query = "
  SELECT v.reference ref, REPLACE(v.rcv, '\n', ' / ') rcv
  FROM verses v
  JOIN chapters c ON c.id = v.chapter_id
  JOIN books b ON b.id = c.book_id
  WHERE LOWER(REPLACE(b.name, ' ', '-')) = '" . $db->esc($book) . "'";

if ($chapter)
  $query .= " AND c.number = " . intval($chapter);
if ($verse)
  $query .= " AND v.number = " . intval($verse);

$results = $db->select($query . " 
    ORDER BY b.id, c.number, v.number");

$response = [
  'book' => $db->col("SELECT name FROM books b WHERE LOWER(REPLACE(b.name, ' ', '-')) = '" . $db->esc($book) . "'"),
];
if (!$response['book'])
  redirect("/sitemap.txt");

if ($chapter)
  $response['chapter'] = $chapter;

$response['results'] = $results;

print_json($response);
