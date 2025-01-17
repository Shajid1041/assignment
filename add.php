<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['user_id'])) {
    die('Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['first_name'])) || 
        empty(trim($_POST['last_name'])) || 
        empty(trim($_POST['email'])) || 
        empty(trim($_POST['headline'])) || 
        empty(trim($_POST['summary']))) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }
    $email = trim($_POST['email']);
    if (strpos($email, '@') === false) {
        $_SESSION['error'] = "Email must contain an '@' symbol.";
        header("Location: add.php");
        return;
    }

    $stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary)
                           VALUES (:uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute([
        ':uid' => $_SESSION['user_id'],
        ':fn' => trim($_POST['first_name']),
        ':ln' => trim($_POST['last_name']),
        ':em' => $email,
        ':he' => trim($_POST['headline']),
        ':su' => trim($_POST['summary'])
    ]);
    $_SESSION['success'] = 'Profile added';
    header('Location: index.php');
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Profile</title>
</head>
<body>
<div style='margin: auto; width: 50%; padding: 10px;'>
<h1>Add Profile</h1>




<?php
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . htmlentities($_SESSION['error']) . "</p>";
    unset($_SESSION['error']);
}
?>

<form method="POST">
    First Name: <br>
    <input type="text" style='margin: 10px 0;' name="first_name"><br>
    Last Name: <br>
    <input type="text" style='margin: 10px 0;' name="last_name"><br>
    Email: <br>
    <input type="text" style='margin: 10px 0;' name="email"><br>
    Headline: <br>
    <input type="text" style='margin: 10px 0;' name="headline"><br>
    Summary: <br>
    <textarea name="summary" style='margin: 10px 0;'></textarea><br>
    <input type="submit" value="Add">
</form>
</div>
</body>
</html>
