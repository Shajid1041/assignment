<?php
session_start();
require_once "pdo.php"; 
echo "<div style='margin: auto;
  width: 50%;
  padding: 10px;'>";
if (basename(__FILE__) === 'index.php') {
    echo "<h1 style='text-align:center;'>Resume Database</h1>";
    
    if (isset($_SESSION['success'])) {
        echo '<p style="color: green;">' . htmlspecialchars($_SESSION['success']) . '</p>';
        unset($_SESSION['success']); 
    }

    if (isset($_SESSION['name'])) {
        echo "<p>Welcome, {$_SESSION['name']}!</p>";
        echo "<a href='add.php'>Add New Entry</a> | <a href='logout.php'>Logout</a><br><br>";   
        $stmt = $pdo->query("SELECT * FROM Profile");
        $table_onoff = true;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($table_onoff){
                echo "<table style='border: 1px solid black; border-collapse: collapse;'> <tr><th>Name</th><th>Headline</th> <th>Action</th></tr>";
                $table_onoff = false;
            }
            echo "
            <tr style='border: 1px solid black; border-collapse: collapse;'>
                <td style='border: 1px solid black; border-collapse: collapse; width:200px; text-align: center;'>
                    <a style='text-decoration: none;' href='view.php?id={$row['profile_id']}'>
                        {$row['first_name']} {$row['last_name']}
                    </a>
                </td>
                <td style='border: 1px solid black; border-collapse: collapse; width:100px; text-align: center;'>
                    {$row['headline']}
                </td>
                <td style='border: 1px solid black; border-collapse: collapse; width:100px; text-align: center;'>
                    <a style='text-decoration: none;' href='edit.php?id={$row['profile_id']}'>Edit</a>  |  <a style='text-decoration: none;' href='delete.php?id={$row['profile_id']}'>Delete</a>
                </td>
            </tr>";

            
                          
        }
        echo "</table>";
    } else {
        echo "<div style='background-color: coral ; text-align:center; font-size: 2rem'><p>Please <button style= 'margin-bottom:3px' type='button'><a style='font-size:1.2rem ; text-decoration: none;' href='login.php'>log in</a></button>   to manage resumes.</p></div>";
        $stmt = $pdo->query("SELECT * FROM Profile");
        $table_onoff = true;        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($table_onoff){
                echo "<table style='border: 1px solid black; border-collapse: collapse;'> <tr><th>Name</th><th>Headline</th></tr>";
                $table_onoff = false;
            }
            echo "
            <tr style='border: 1px solid black; border-collapse: collapse;'>
                <td style='border: 1px solid black; border-collapse: collapse; width:200px; text-align: center;'>
                    <a style='text-decoration: none;' href='view.php?id={$row['profile_id']}'>
                        {$row['first_name']} {$row['last_name']}
                    </a>
                </td>
                <td style='border: 1px solid black; border-collapse: collapse; width:200px; text-align: center;'>
                    {$row['headline']}
                </td>
                
            </tr>";

            
                          
        }

        echo "</table>";
 
    }
    
}
echo "</div>";
?>

