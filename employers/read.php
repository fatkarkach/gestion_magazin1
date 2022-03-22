<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>READ</title>
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
            <div class="wrapper">
                        <h2 id="titre2"> <span>Employees</span> Details</h2>
                     <a  class="ajouter" href="create.php"><i class="fa fa-plus"></i> Add New Employee</a>
            </div>
            <div class="affichage" style="margin-top:20px">
                    <h1><span>View</span> Record</h1>
                    <div>
                        <p>Name:<b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div>
                        <p>Address:<b><?php echo $row["address"]; ?></b></p>
                    </div>
                    <div>
                        <p>Salary:<b><?php echo $row["salary"]; ?></b></p>
                    </div>
                    <button><a href="index.php">Back</a></button>
            </div>  
            </div>                
</body>
</html>