<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

    
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                       <!--  <div class="title-box">
                            <h1>Videojuegos</h1>
                        </div> -->
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Añadir juego</a>
                    </div>
                    <div class="row">
                        <?php
                        // Include config file
                        require_once "config.php"; // IMPORTAMOS CONFIG.PHP

                        // Attempt select query execution
                        $sql = "SELECT * FROM juegos ORDER BY id";

                        if($result = $mysqli->query($sql)){
                            if($result->num_rows > 0){
                                while($row = $result->fetch_array()){
                                    echo '<div class="col-md-4 mb-4">';
                                    echo '<div class="card">';
                                    echo '<img src="' . $row['imagen'] . '" class="card-img-top" alt="' . $row['titulo'] . '">';
                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . $row['titulo'] . '</h5>';
                                    echo '<p class="card-text">Plataforma: ' . $row['plataforma'] . '</p>';
                                    echo '<p class="card-text">Precio: ' . $row['precio'] . '</p>';
                                    echo '<div class="botones" >';
                                    echo '<a href="read.php?id=' . $row['id'] . '" class="btn btn-primary btn-action">Ver</a>';
                                    echo '<a href="update.php?id=' . $row['id'] . '" class="btn btn-secondary btn-action">Editar</a>';
                                    echo '<a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-action">Eliminar</a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else{
                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }

                        // Close connection
                        $mysqli->close();
                        ?>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
