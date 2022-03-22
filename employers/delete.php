<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete</title>
    <link rel="stylesheet" href="acceuil.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="popup.css">
</head>
<body>
<nav>
      <div class="nav">
        <div class="nav-header">
          <div class="nav-title">
          <img id="logo" src="logo.svg"></img>
          </div>
        </div>
        <div class="nav-links">
        <ul>
          <i class="fas fa-user-circle"></i>
          <i class="fas fa-home"></i>
          <i class="fas fa-sign-out-alt"></i>
          </ul>
        </div>
      </div>
      </nav>
      <aside>
      <div class="row">
        <div class="panel">
          <ul>
            <li class="item-panel">
              <i class="fas fa-home"></i>
              <span>home</span>
            </li>
            <li class="item-panel">
              <i class="fas fa-border-all"></i>
              <span>Products</span>
            <li class="item-panel">
              <i class="fas fa-users"></i>
              <span>Employers</span>
          <li><a href="logout.php"> <button>LOG OUT</button></a></li>  
            </ul>
            </div>
            </div>
            </aside>
            <main>
    <div class="wrapper">
                        <h2 id="titre2"> <span>Employees</span> Details</h2>
                     <a  class="ajouter" href="create.php"><i class="fa fa-plus"></i> Add New Employee</a>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    echo "<div>";
                    echo '<table>';
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Name</th>";
                            echo "<th>Address</th>";
                            echo "<th>Salary</th>";
                            echo "<th>Action</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php? id='. $row['id'] .'"><i class="fa fa-eye"></i></a>
                                             <a href="update.php?id='. $row['id'] .'"><i class="fas fa-pen-alt"></i></a>
                                            <a href="delete.php?id='. $row['id'] .'" ><i class="fa fa-trash"></i></a>';
                                            echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            echo "</div>";
                            // Free result set
                            mysqli_free_result($result);
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
</div>
<div class="affichage">
                    <h1>Delete Record</h1>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="supprimer">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this employee record?</p>
                            <div class="lire">
                                <input type="submit" value="Yes">
                              <button id="bt_supp"><a href="index.php">No</a></button>
                            </p>
                          </div>
                        </div>
                    </form>
</div>        
</main>
</body>
</html>