<?php

$pdo = new PDO('mysql:host=localhost;dbname=cvdata', 'fred', 'ruhi');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();

if (!isset($_GET['id'])) {
    die('Profile ID is missing');
}
$stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid');
$stmt->execute([':pid' => $_GET['id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
    die('Invalid profile ID');
}

echo "<h1>Profile Details</h1>";
echo "<p>First Name: {$row['first_name']}</p>";
echo "<p>Last Name: {$row['last_name']}</p>";
echo "<p>Email: {$row['email']}</p>";
echo "<p>Headline: {$row['headline']}</p>";
echo "<p>Summary: {$row['summary']}</p>";

?>
