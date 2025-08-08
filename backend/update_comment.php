<?php
require_once '../connection.php';

$body = read_json_body();
$id = $body['id'] ?? null;
$content = trim($body['content'] ?? '');
if (!$id || $content === '') {
    json_response(['ok' => false, 'error' => 'Missing id or content'], 400);
}

$stmt = pdo()->prepare("UPDATE comments SET content = ? WHERE id = ?");
$stmt->execute([$content, $id]);

json_response(['ok' => true, 'message' => 'Comment updated', 'id' => (int)$id]);
