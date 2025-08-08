<?php
require_once '../connection.php';

$body = read_json_body();
$userId = $body['user_id'] ?? null;
if (!$userId) json_response(['ok' => false, 'error' => 'Missing user_id'], 400);

$stmt = pdo()->prepare("
    SELECT id, title, content, user_id
    FROM posts
    WHERE user_id = ?
    ORDER BY id DESC
    LIMIT 10
");
$stmt->execute([$userId]);
$rows = $stmt->fetchAll();

json_response(['ok' => true, 'data' => $rows]);
