<?php

/**
 * @author Soraya León González
 * IES TRASSIERRA
 */

/**
 * Conector BD usando objetos MySQL con PDO
 */
class ControladorBD {
    
    // Configuración del servidor
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "CRUD";
    private $server ="mysql";
    
    // Variables
    private $bd; // Relativo a la conexion de la base de datos
    private $rs; // ResultSet donde se almacenan las consultas
    private $st; // donde se almacena el statement paremetrizado
    
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
            self::$instancia = new ControladorBD();
        }
        return self::$instancia;
    }

    /**
     * Abrir conexión a la BD
     */
    public function abrirBD() {
        try {
            $this->bd = new PDO($this->server.":host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            // Pongo el modo de errores de PDO a excepciones
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("conexión fallida " . $e->getMessage());
        }
    }

    /**
     * Cerrar la conexión y el manejador de la BD
     */
    public function cerrarBD() {
        $this->bd = null;
        $this->rs = null;
        $this->st = null;
    }

    /**
     * Actualizar la BD a través de una consulta
     * @param type $consulta
     * @return boolean
     */

    public function actualizarBD($consulta, $parametros=null) {
        if($parametros!=null)
            return $this->actualizarBDParametros($consulta,$parametros);
        else
            return $this->actualizarBDDirecta($consulta);
    }

    private function actualizarBDDirecta($consulta){
        if ($this->bd->exec($consulta) != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function actualizarBDParametros($consulta, $parametros){
        $this->st = $this->bd->prepare($consulta);
        return $this->st->execute($parametros);
    }


   
    /**
     *Consultar BD
     */

    public function consultarBD($consulta, $parametros=null){
        if($parametros!=null)
            return $this->consultarBDParametros($consulta,$parametros);
        else
            return $this->consultarBDDirecta($consulta);
            
    }

    private function consultarBDDirecta($consulta) {
        $this->rs = $this->bd->query($consulta);
        return $this->rs;
    }

    private function consultarBDParametros($consulta, $parametros) {
        $this->st = $this->bd->prepare($consulta);
        $this->st->execute($parametros);
        return $this->st;
    }

    /**
     * Devuelve los datos de conexion
     * @return type
     */
    public function datosConexion() {
        return $this->servername;
    }

    private function alerta($texto) {
        echo '<script type="text/javascript">alert("' . $texto . '")</script>';
    }

}
