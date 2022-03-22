<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    }
    else{
        $name = $input_name;
    }
    
    // Validate address address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an update statement
        $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
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
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
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
    <title>Update Record</title>
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
            <div class="affichage" id="edit">
                    <h1><span>Update</span> Record</h1>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <br>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div>
                            <input type="text" placeholder="Name" name="name" <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?> value="<?php echo $name; ?>">
                            <span><?php echo $name_err;?></span>
                        </div>
                        <br>
                        <div>
                            <textarea placeholder="Address:" name="address" <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>><?php echo $address; ?></textarea>
                            <span><?php echo $address_err;?></span>
                        </div>
                        <br>
                        <div>
                            <input type="text" name="salary" placeholder="Salary"<?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?> value="<?php echo $salary; ?>">
                            <span><?php echo $salary_err;?></span>
                        </div>
                        <br>
                        <div class="read">
                        <p> <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit"value="Submit" id="envoye">
                        </p>
                        <p><button id="modifier"><a href="index.php">Cancel</a></button></p>
                        </div>
                    </form>
                </div>
</body>
</html>