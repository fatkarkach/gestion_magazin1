<?php
//inclure le fichier auth.php sur toutes les pages sécurisées
include("auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Acceuil</title>
<link rel="stylesheet" href="acceuil.css">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="employers.">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
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
        <ul id="nav">
      <li><i class="fas fa-user-circle"></i></li>
      <li><a href="home.php"><i class="fas fa-home"></i></a></li>
      <li> <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a></li>
      </ul>
        </div>
      </div>
      </nav>
      <aside>
      <div class="row">
        <div class="panel">
          <ul>
            <li class="item-panel">
            <a href="home.php"><i class="fas fa-home"></i>
             <span>home</span></a>
            </li>
            <li class="item-panel">
            <a href="../products/products.php"><i class="fas fa-border-all"></i>
             <span>Products</span></a>
            </li>
            <li class="item-panel">
              <i class="fas fa-users"></i>
              <span>Employers</span>
          <li><a href="logout.php"> <button>LOG OUT</button></a></li>  
            </ul>
            </div>
            </div>
            </aside>
            <!-- forms-->
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
</main>            
</body>
</html>
</body>
</html>