<?php
$mysqli = require __DIR__ . "/account_management/database.php";

// 検索
$stmt = $mysqli->prepare("SELECT s.*, u.name, COALESCE(v.total_votes, 0) AS total_votes
FROM shortcuts s
JOIN users u ON s.user_id = u.id
LEFT JOIN (
  SELECT shortcut_id, SUM(vote) AS total_votes
  FROM votes
  GROUP BY shortcut_id
) v ON s.id = v.shortcut_id
WHERE private = 0 AND (s.shortcut_name LIKE ? OR s.comments LIKE ? OR s.address LIKE ? OR u.name LIKE ?)
ORDER BY total_votes DESC;
");

$stmt->execute(["%".$_POST["search"]."%", "%".$_POST["search"]."%", "%".$_POST["search"]."%", "%".$_POST["search"]."%"]);
$resultSet = $stmt->get_result();
$results = $resultSet->fetch_All(MYSQLI_ASSOC);
if (isset($_POST["ajax"])) {
    echo json_encode($results);
}

