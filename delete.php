<?php
session_start();
require_once "pdo.php";
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_SESSION['user_id'])) {
    die('Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :pid AND user_id = :uid');
    $stmt->execute([
        ':pid' => $_POST['profile_id'],
        ':uid' => $_SESSION['user_id']
    ]);
    $_SESSION['success'] = 'Profile deleted';
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid AND user_id = :uid');
$stmt->execute([
    ':pid' => $_GET['id'],
    ':uid' => $_SESSION['user_id']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    die('Invalid profile ID');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Profile</title>
</head>
<body>
<div style='margin: auto;
  width: 50%;
  padding: 10px;'>
<h1 >Confirm Delete</h1>
<p>Are you sure you want to delete <?= htmlspecialchars($row['first_name']) ?> <?= htmlspecialchars($row['last_name']) ?>?</p>
<form method="POST">
    <input type="number" name="profile_id" value="<?= htmlspecialchars($_GET['id']) ?>">
    <input type="submit" value="Delete">
    <a href="index.php">Cancel</a>
</form>
</div>
</body>
</html>
