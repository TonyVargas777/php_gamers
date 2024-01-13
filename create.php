<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$titulo = $plataforma = $precio = $imagen = "";
$titulo_err = $plaforma_err = $precio_err = $imagen_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate titulo
    $input_name = trim($_POST["titulo"]);
    if(empty($input_name)){
        $titulo_err = "Introduce un título";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $titulo_err = "Introduce un título válido";
    } else{
        $titulo = $input_name;
    }
    
    // Validate plataforma
    $input_address = trim($_POST["plataforma"]);
    if(empty($input_address)){
        $plataforma_err = "Por favor introduce plataforma.";     
    } else{
        $plataforma = $input_address;
    }
    
    // Validate precio
    $input_salary = trim($_POST["precio"]);
    if(empty($input_salary)){
        $precio_err = "Por favor introduce precio.";     
    } elseif(!ctype_digit($input_salary)){
        $precio_err = "Por favor introduce un número entero";
    } else{
        $precio = $input_salary;
    }

    // Validate imagen
    $input_imagen = trim($_POST["imagen"]);
    if(empty($input_imagen)){
        $imagen_err = "Por favor introduce una url.";     
    } else{
        $imagen = $input_imagen;
    }

    
    // Check input errors before inserting in database
    if(empty($titulo_err) && empty($plataforma_err) && empty($precio_err) && empty($imagen_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO juegos (titulo, plataforma, precio, imagen) VALUES (?, ?, ?, ?)";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_title, $param_plataforma, $param_precio, $param_imagen);
            
            // Set parameters
            $param_title = $titulo;
            $param_plataforma = $plataforma;
            $param_precio = $precio;
            $param_imagen = $imagen;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="title-box">
                    <h1>Insertar videojuego</h1>
                </div>
                <div class="box">
                    <h2>Introduce los datos del videojuego que vamos a introducir</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Título:</label>
                            <input type="text" name="titulo" class="form-control <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titulo; ?>">
                            <span class="invalid-feedback"><?php echo $titulo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Plataforma:</label>
                            <input name="plataforma" class="form-control <?php echo (!empty($plataforma_err)) ? 'is-invalid' : ''; ?>"><?php echo $plataforma; ?>
                            <span class="invalid-feedback"><?php echo $plataforma_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Precio:</label>
                            <input type="number" name="precio" class="form-control <?php echo (!empty($precio_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $precio; ?>">
                            <span class="invalid-feedback"><?php echo $precio_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Imagen:</label>
                            <input type="text" name="imagen" class="form-control <?php echo (!empty($imagen_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $imagen; ?>">
                            <span class="invalid-feedback"><?php echo $imagen_err;?></span>
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