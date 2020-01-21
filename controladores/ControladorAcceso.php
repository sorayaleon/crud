<?php

/**
 * @author Soraya León González
 * IES TRASSIERRA
 */

require_once CONTROLLER_PATH."ControladorBD.php";

class ControladorAcceso {
    // Instancia Singleton
    static private $instancia = null;
    
    // Constructor--> Private por el patrón Singleton
    private function __construct() {
       
    }

    /**
     * Patrón Singleton
     * @return instancia 
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAcceso();
        }
        return self::$instancia;
    }
    
    public function salirSesion() {
        // Recupero la información
        session_start();
        // Elimino las variables de la sesión y cookies
        unset($_SESSION['USUARIO']);
       
        // Destruyo la sesión
        //session_unset();
        session_destroy();
    }
    
    
    public function procesarIdentificacion($email, $password){

            $password = md5($password);
            // Conexión con la base de datos
            $bd = ControladorBD::getControlador();
            $bd->abrirBD();
            // Consulta a la BD
            $consulta = "SELECT * FROM admin WHERE email=:email and password=:password";
            $parametros = array(':email' => $email, ':password' => $password);
            // Obtengo las filas como objetos con las columnas de la tabla
            $res = $bd->consultarBD($consulta,$parametros);
            $filas=$res->fetchAll(PDO::FETCH_OBJ);
            
            if (count($filas) > 0) {
                 // Almaceno el usuario en la sesión
                 $_SESSION['USUARIO']['email']=$email;
                 header("location: ../index.php"); 
                 exit();              
            } else {
                echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Usuario/a incorrecto</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-warning fade in'>";
                                    echo "<p>Lo siento, el email o password es incorrecto. Por favor <a href='login.php' class='alert-link'>regresa</a> e inténtalo de nuevo.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                //<!-- Pie de página -->
                require_once VIEW_PATH."pie.php";
                exit();
            }
    }
    
    

}
