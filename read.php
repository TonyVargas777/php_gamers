<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM juegos WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = $_GET["id"];
        
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
                // URL doesn't contain valid id parameter. Redirect to error page
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
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="title-box">
                    <h1>Ver Entrada</h1>
                </div>
                    <div class="box">
                        <div class="form-group">
                            <label>Titulo:</label>
                            <p><b><?=$titulo?></b></p>
                        </div>
                        <div class="form-group">
                            <label>Plataforma:</label>
                            <p><b><?=$plataforma?></b></p>
                        </div>
                        <div class="form-group">
                            <label>Precio:</label>
                            <p><b><?=$precio?></b></p>
                        </div>
                        <div class="form-group">
                            <label>Imagen:</label><br>
                            <img src="<?=$imagen?>" alt="<?=$titulo?>" style="width: 100%; height: auto;">
                        </div>
                        <p><a href="index.php" class="btn btn-primary">Back</a></p>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
