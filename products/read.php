<?php 
 include "../employers/config.php";
$category = $quantity = $price =$taille="";
$category_error = $quantity_error =$price_error =$images_error =$taille_error= "";
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);
    
    // Prepare a select statement
    $sql = "SELECT * FROM products WHERE id = ?";
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
                
                // Définir les paramètres
          $category = $row['category'];
          $taille = $row['taille'];
          $quantity= $row['quantity'];
          $price= $row['price'];
          $name_image = $row['name_image'];
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
    header("location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<title>read</title>
<link rel="stylesheet" href="../employers/acceuil.css">
<link rel="stylesheet" href="../employers/popup.css">
<link rel="stylesheet" href="products.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>

<body>
      <nav>
      <div class="nav">
        <div class="nav-header">
          <div class="nav-title">
          <img id="logo" src="../employers/logo.svg"></img>
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
             <a href="../products/products.php"><span>Products</span></a>
            </li>
            <li class="item-panel">
              <i class="fas fa-users"></i>
              <span>Employers</span>
          <li><a href="logout.php"> <button>LOG OUT</button></a></li>  
            </ul>
            </div>
            </div>
            </aside>
            <main>
         
</main>
             <div class="affichage">
              <h1><span>View</span> product </h1>
                <br>
                <img  class="image_product" src="images_product/<?php echo $row['name_image']; ?>"  alt="probleme" >
                <br>
              <div>
                    <p> category :<?php echo $row['category']; ?></p><br>
                </div>  
                <div> 
                    <p>taille :<?php echo $row['taille']; ?></p><br>
                </div>
                <div>
                    <p>Quantity : <?php echo $row['quantity']; ?></p><br>
                </div>
                <div>
                    <p> Price : <?php echo $row['price']; ?></p><br>
                </div>
                <button id="back"><a href="products.php">Back</a></button>
                </div>
                
</body>
</html>