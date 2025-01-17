<?php
session_start();
require_once "pdo.php";
echo "<div style='margin: auto;
  width: 50%;
  padding: 10px;'>";
if (basename(__FILE__) === 'login.php') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $salt = 'XyZzy12*_'; 
        $check = hash('md5', $salt . $_POST['password']);

        $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
        $stmt->execute([':em' => $_POST['email'], ':pw' => $check]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row !== false) { 
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            header('Location: index.php');   
            return;
        } else {
            
            $_SESSION['error'] = 'Incorrect email or password';
            header('Location: login.php');       
            return;
        }
    }
    echo "<h1 style ='text-align:center;'>Login</h1>";

    if (isset($_SESSION['error'])) {
        
        echo "<p style='color: red;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }

    echo "<div style=' background-color: aqua; padding: 30px;position: relative; display: flex; justify-content: center;'><form method='POST'>
        Email: <input style='  font-size:1.2rem; margin-bottom:10px ;' type='text' id='eml' name='email'><br>
        Password: <input style='  font-size:1.2rem;margin-bottom:10px ; ' id='pass' type='password' name='password'><br>
        <br>
        <input style='font-size:1.2rem; ' onclick='return doValidate();' type='submit' value='Log In'> <button style='font-size:1.2rem;' type='button'><a style='text-decoration: none;' href='index.php'>Cancel</a></button> 
    </form>";

}
echo "</div>";
?>






<script>function doValidate() {
         console.log('Validating...');
         try {
             pw = document.getElementById('pass').value;
             em = document.getElementById('eml').value;
             console.log("Validating pw="+pw);
             if (pw == null || pw == "") {
                 alert("Both fields must be filled out");
                 return false;
             }
             
             if ( em.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
            }
             return true;
         } catch(e) {
             return false;
         }
         return false;
     }</script>