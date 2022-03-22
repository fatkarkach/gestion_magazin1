<?php 
 include "../employers/config.php";
 $category = $quantity = $price =$taille="";
 $category_error = $quantity_error =$price_error  =$taille_error= "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get hidden input value
    $id = $_POST["id"];
    // validation de donne
    $taille_input = trim($_POST['taille']);
    if(empty($taille_input)){
        $taille_error  = "error entrer taille";
    }
    else{
      $taille = $taille_input;
    }

    $category_input = trim($_POST['category']);
    if(empty($category_input)){
        $category_error = "error entrer category";
    }
    else{
      $category= $category_input;
    }

    $quantity_input = trim($_POST['quantity']);
    if(empty($quantity_input)){
        $quantity_error = "error entrer category";
    }
    else{
      $quantity= $quantity_input;
    }

    $price_input = trim($_POST['price']);
    if(empty($price_input)){
        $price_error = "error entrer price";
    }
    else{
      $price= $price_input;
    }
    // Check extensions

    // Vérifier les erreurs de saisie avant d'insérer dans la base de données
      if(empty($taille_error) && empty($category_error) && empty($quantity_error) && empty($price_error))
      {
          // Préparer une déclaration d'insertion
        //   $sql = "INSERT INTO products (titres, categore, quantite, prix, name_image) 
        //             VALUES (?, ?, ?, ?, ?)";
          $sql = "UPDATE products SET taille=?, category=?, quantity=?, price=? WHERE id = ?";
  
          if($stmt = mysqli_prepare($link, $sql)){
              // Lie les variables à l'instruction préparée en tant que paramètres
              mysqli_stmt_bind_param($stmt, "ssiii", $param_taille, $param_category, $param_quantity, $param_price, $param_id);
  
              // Définir les paramètres
              $param_taille = $taille;
              $param_category = $category;
              $param_quantity= $quantity;
              $param_price= $price;
              $param_id=$id;
  
              // Tentative d'exécution de l'instruction préparée
          if(mysqli_stmt_execute($stmt)){
                  // Enregistrements créés avec succès. Rediriger vers la page de destination
                  header("location: products.php");
                  exit();
              } else{
                  echo "Oops! Something went wrong. Please try again later.";
              }
          }
  
          // Fermer la déclaration
          mysqli_stmt_close($stmt);
      }
      // Fermer la connexion
      mysqli_close($conn);
}else{
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
<div class="affichage" id="update1">
              <h1> <span>update</span> product </h1>
              <form method="POST"  action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" enctype="multipart/form-data" >
                     <span ><?php echo (!empty($category_error)) ? 'is-invalid' : ''; ?></span>
                    <select class="text" id="category" name="category" value="<?php echo $category ?>">
                      <option value="men">men</option>
                      <option value="women">women</option>
                      <option value="childs">childs</option>
                  </select>
                  <br>
                  <br>
                  <span ><?php echo (!empty($taille_error)) ? 'is-invalid' : ''; ?></span>
                    <select class="text" id="taille" name="taille" value="<?php echo $taille; ?>">
                      <option value="M">M</option>
                      <option value="L">L</option>
                      <option value="XL">XL</option>
                  </select>
                     <span ><?php echo (!empty($quantity_error)) ? 'is-invalid' : ''; ?></span>
                     <br>
                     <br>
                    <input class="text" type="number"placeholder="quantity" name="quantity" id="quantity" min="1" value="<?php echo  $quantity; ?>"><br>
                    <span ><?php echo (!empty($price_error)) ? 'is-invalid' : ''; ?></span><br>
                    <input class="text" type="number"placeholder="price"  name="price" id="price" min="0" value="<?php echo $price; ?>">
                    <br>
                  
                    <div class="creation">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                   <p> <input  type="submit"  value="Add"  id="creer"></p>
                    <p> <button id="cancel"> <a href="products.php">Cancel</a></button></p>
                    </div>
</div>
</form>
</main>
</body>
<html>