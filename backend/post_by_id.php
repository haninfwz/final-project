<?php
require_once '../connection.php';

$body = read_json_body();
$id = $body['id'] ?? null;
if (!$id) json_response(['ok' => false, 'error' => 'Missing id'], 400);

$stmt = pdo()->prepare("SELECT id, title, content, user_id FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) json_response(['ok' => false, 'error' => 'Post not found'], 404);

$stmt = pdo()->prepare("
    SELECT c.id, c.content, c.user_id, c.post_id, u.name AS user_name
    FROM comments c
    JOIN users u ON u.id = c.user_id
    WHERE c.post_id = ?
    ORDER BY c.id DESC
    LIMIT 15
");
$stmt->execute([$id]);
$comments = $stmt->fetchAll();

json_response(['ok' => true, 'data' => ['post' => $post, 'comments' => $comments]]);
