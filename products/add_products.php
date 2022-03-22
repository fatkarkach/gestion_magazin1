<?php 
 include "../employers/config.php";
 $category = $quantity = $price =$taille="";
 $category_error = $quantity_error =$price_error =$images_error =$taille_error= "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // validation de donne
    $category_input = trim($_POST['category']);
    if(empty($category_input))
    {
        $category_error = "entrer category";
    }
    else{
      $category= $category_input;
    }

    $quantity_input = trim($_POST['quantity']);
    if(empty($quantity_input)){
        $quantity_error = "entrer quantity";
    }
    else{
      $quantity= $quantity_input;
    }

    $taille_input = trim($_POST['taille']);
    if(empty($taille_input)){
        $taille_error = "entrer taille";
    }
    else{
      $taille= $taille_input;
    }


    $price_input = trim($_POST['price']);
    if(empty($price_input)){
        $price_error = "entrer price";
    }
    else{
      $price= $price_input;
    }
    // Check extensions

    $extension = pathinfo($_FILES['image']['name']);
    
    if ($extension["extension"] == "jpg" || $extension["extension"] == "png" || $extension["extension"] == "gif") {
        $image = $_FILES['image']['name'];       
    }
    else {
      $image_error = "File is not image.";
        exit;
    }
    $post_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($post_image_temp, "images_product/$image");

    // Vérifier les erreurs de saisie avant d'insérer dans la base de données
      if(empty($category_error) && empty($quantity_error)&& empty($price_error)&& empty($image_error)&& empty($taille_error))
      {
          // Préparer une déclaration d'insertion
          $sql = "INSERT INTO products ( name_image,category, taille, quantity, price) 
                    VALUES (?, ?, ?, ?, ?)";
  
          if($stmt = mysqli_prepare($link, $sql)){
              // Lie les variables à l'instruction préparée en tant que paramètres
              mysqli_stmt_bind_param($stmt, "sssii", $param_image,$param_category, $param_taille, $param_quantity, $param_price);
  
              // Définir les paramètres
              $param_category = $category;
              $param_quantity = $quantity;
              $param_price = $price;
              $param_image = $image;
              $param_taille=$taille;
  
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
      mysqli_close($link);
} 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>products</title>
<link rel="stylesheet" href="../employers/acceuil.css">
<link rel="stylesheet" href="../employers/popup.css">
<link rel="stylesheet" href="products.css">
<script src="brands.js"></script>
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
              <a href="../employers/index.php"><span>Employers</span></a>
          <li><a href="logout.php"> <button>LOG OUT</button></a></li>  
            </ul>
            </div>
            </div>
            </aside>
            <main>
            <div class="wrapper">
                     <div>
                     <table>
                    <thead>
                    </thead>
                    <tbody>
                    <div class="affichage" id="add_products">
                    <h1><span>Add </span> product </h1>
                    <br>
<form method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" >
                <span ><?php echo (!empty($image_error)) ? 'is-invalid' : ''; ?></span>
                    <input type="file" id="Image" name="image" placeholder="image" class="text"><br><br>
                     <span ><?php echo (!empty($category_error)) ? 'is-invalid' : ''; ?></span>
                    <select class="text" id="category" placeholder="category" name="category" value="<?php echo $category; ?>">
                      <option value="men">men</option>
                      <option value="women">women</option>
                      <option value="childs">childs</option>
                  </select>
                  <br>
                  <br>
                  <span ><?php echo (!empty($taille_error)) ? 'is-invalid' : ''; ?></span>
                    <select class="text" id="taille" placeholder="taille" name="taille" value="<?php echo $taille; ?>">
                      <option value="M">M</option>
                      <option value="L">L</option>
                      <option value="XL">XL</option>
                  </select>
                     <span ><?php echo (!empty($quantity_error)) ? 'is-invalid' : ''; ?></span>
                     <br>
                     <br>
                    <input class="text" type="number"placeholder="quantity" name="quantity" id="quantity" min="1" value="<?php echo $quantity; ?>"><br>
                    <span ><?php echo (!empty($price_error)) ? 'is-invalid' : ''; ?></span><br>
                    <input class="text" type="number"placeholder="price"  name="price" id="price" min="0" value="<?php echo $price; ?>">
                    <br>
                  
                    <div class="creation">
                   <p> <input  type="submit"  value="Add"  id="creer"></p>
                    <p> <button id="cancel"> <a href="products.php">Cancel</a></button></p>
                    </div>
</div>
</form>
</body>
</html>