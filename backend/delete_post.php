<?php
require_once '../connection.php';

$body = read_json_body();
$id = $body['id'] ?? null;
if (!$id) json_response(['ok' => false, 'error' => 'Missing id'], 400);

$stmt = pdo()->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);

json_response(['ok' => true, 'message' => 'Post deleted', 'id' => (int)$id]);
