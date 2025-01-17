<?php
session_start();
require_once "pdo.php"; 
echo "<div style='margin: auto;
  width: 50%;
  padding: 10px;'>";
if (basename(__FILE__) === 'edit.php') {
    
    if (!isset($_SESSION['user_id'])) {
        die('Not logged in');
    }

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['headline']) || empty($_POST['summary'])) {
            $_SESSION['error'] = 'All fields are required';
            header("Location: edit.php?id=" . $_GET['id']);
            return;
        }
        $email = $_POST['email'];
        if (strpos($email, '@') === false) {
            $_SESSION['error'] = "Email must contain an '@' symbol.";
            header("Location: edit.php?id=" . $_GET['id']);
            return;
        }  
        $stmt = $pdo->prepare('UPDATE Profile 
            SET first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su 
            WHERE profile_id = :pid AND user_id = :uid');
        $stmt->execute([
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'],
            ':pid' => $_GET['id'],
            ':uid' => $_SESSION['user_id']
        ]);

        $_SESSION['success'] = 'Profile updated';
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
        <title>Edit Profile</title>
    </head>
    <body>
    <h1>Edit Profile</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        <label>First Name:</label><br>
        <input type="text" style='margin: 10px 0;' name="first_name" value="<?= htmlentities($row['first_name']) ?>"><br>
        <label>Last Name:</label><br>
        <input type="text" style='margin: 10px 0;' name="last_name" value="<?= htmlentities($row['last_name']) ?>"><br>
        <label>Email:</label><br>
        <input type="text"  style='margin: 10px 0;' name="email" value="<?= htmlentities($row['email']) ?>"><br>
        <label>Headline:</label><br>
        <input type="text" style='margin: 10px 0;'  name="headline" value="<?= htmlentities($row['headline']) ?>"><br>
        <label>Summary:</label><br>
        <textarea name="summary"  style='margin: 10px 0;' ><?= htmlentities($row['summary']) ?></textarea><br>
        <input type="submit"  style='margin: 10px 0;'  value="Save">
        <a href="index.php">Cancel</a>
    </form>
    </body>
    </html>
    <?php
}
echo "</div>";
?>
