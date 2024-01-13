<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$titulo = $plataforma = $precio = $imagen="";
$titulo_err = $plataforma_err = $precio_err = $imagen_err= "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validar titulo
    $input_name = trim($_POST["titulo"]);
    if(empty($input_name)){
        $titulo_err = "Introduce un título";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $titulo_err = "Introduce un título válido";
    } else{
        $titulo = $input_name;
    }
    
    // Validar plataforma
    $input_address = trim($_POST["plataforma"]);
    if(empty($input_address)){
        $plataforma_err = "Por favor introduce plataforma.";     
    } else{
        $plataforma = $input_address;
    }
    
    // Validar precio
    $input_salary = trim($_POST["precio"]);
    if(empty($input_salary)){
        $precio_err = "Por favor introduce precio.";     
    } elseif(!ctype_digit($input_salary)){
        $precio_err = "Por favor introduce un número entero";
    } else{
        $precio = $input_salary;
    }

       // Validar imagen
       $input_imagen = trim($_POST["imagen"]);
       if(empty($input_imagen)){
           $imagen_err = "Por favor introduce una url.";     
       } else{
           $imagen = $input_imagen;
       }
    
    // Check input errors before inserting in database
    if(empty($titulo_err) && empty($plataforma_err) && empty($precio_err) && empty($imagen_err)){
        // Prepare an update statement
        $sql = "UPDATE juegos SET titulo=?, plataforma=?, precio=?, imagen=? WHERE id=?";
 
        if($stmt = $mysqli->prepare($sql)){

              // Set parameters
              $param_title = $titulo;
              $param_plataforma = $plataforma;
              $param_precio = $precio;
              $param_imagen = $imagen;

            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_title, $param_plataforma, $param_precio, $param_imagen);
            
          
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM juegos WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $titulo = $row["titulo"];
                    $plataforma = $row["plataforma"];
                    $precio = $row["precio"];
                    $imagen = $row["imagen"];
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
        $stmt->close();
        
        // Close connection
        $mysqli->close();
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="title-box">
                    <h1>Edita videojuegos</h1>
                </div>
                    
                    <div class="form-box"> 
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <p>Introduce los datos del videojuego que vamos a editar</p>    
                        
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" name="titulo" class="form-control <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titulo; ?>">
                                <span class="invalid-feedback"><?php echo $titulo_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Plataforma</label>
                                <input type="text" name="plataforma" class="form-control <?php echo (!empty($plataforma_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $plataforma; ?>">
                                <span class="invalid-feedback"><?php echo $plataforma_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="number" name="precio" class="form-control <?php echo (!empty($precio_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $precio; ?>">
                                <span class="invalid-feedback"><?php echo $precio_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Imagen</label>
                                <img src="<?php echo $imagen; ?>" alt="Imagen del videojuego" class="img-thumbnail" style="width: 100%; height: auto;">
                                <input type="text" name="imagen" class="form-control <?php echo (!empty($imagen_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $imagen; ?>">
                                <span class="invalid-feedback"><?php echo $imagen_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
