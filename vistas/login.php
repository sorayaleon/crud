<!-- Cabecera -->
<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/crudpdo/dirs.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorAcceso.php";


$controlador = ControladorAcceso::getControlador();
$controlador->salirSesion();
?>

<?php require_once VIEW_PATH."cabecera.php"; ?>


<?php
    
    // Proceso la indetificación
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $controlador = ControladorAcceso::getControlador();
        $controlador->procesarIdentificacion($_POST['email'], $_POST['password']);
    }
 
?>


<!-- Cuerpo -->

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Identificación de Usuario/a:</h2>
                </div>
                <!-- Formulario-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- Nombre-->
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" required name="email" class="form-control" value="pepe@pepe.com">
                    </div>
                    <!-- Contraseña -->
                    <div class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" required name="password" class="form-control" value="pepe">
                    </div>
                    <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-log-in"></span>  Entrar</button>
                    <a href="../index.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                </form>
            </div>
        </div>        
    </div>
</div>
<br>

<!-- Pie -->
<?php require_once VIEW_PATH."pie.php"; ?>