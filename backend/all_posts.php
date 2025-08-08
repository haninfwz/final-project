<?php
require_once '../connection.php';

$sql = "
    SELECT p.id, p.title, p.content, p.user_id,
           (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count
    FROM posts p
    ORDER BY p.id DESC
";
$rows = pdo()->query($sql)->fetchAll();
json_response(['ok' => true, 'data' => $rows]);
