<?php

    /**
    * @author Soraya León González
    * IES TRASSIERRA
    */

require_once CONTROLLER_PATH . "ControladorBD.php";

class Paginador {

    // Variables
    private $limite = 5;
    private $pagina;
    private $consulta;
    private $parametros;
    private $total;
    private $bd;
    private $res;

    /**
     * Constructor por defecto
     * @param type $consulta
     * @param type $limite
     */
    public function __construct($consulta, $parametros, $limite) {
        $this->limite = $limite;
        $this->consulta = $consulta;
        $this->parametros = $parametros;
        $this->bd = ControladorBD::getControlador();
        $this->bd->abrirBD();
        $this->res = $this->bd->consultarBD($consulta, $parametros);
        $this->filas=$this->res->fetchAll(PDO::FETCH_OBJ);
        $this->total = count($this->filas);
        $this->bd->cerrarBD();
    }

    /**
     * Obtener datos de una página
     * @param type $p
     * @return \stdclass
     */
    public function getDatos($p) {
        $this->pagina = $p;
        $inicio = ( $this->pagina - 1 ) * $this->limite;
        
        if ($inicio < 0) {
            $inicio = 0;
            $this->pagina = 1;
        }

        if ($inicio > ($this->total - $this->limite)) {
              $this->pagina = $this->pagina - 1;
        }
        
        // Devuelvo el objeto
        $result = new stdclass();
        $result->pagina = $this->pagina;
        $result->limite = $this->limite;
        $result->total = $this->total;
        $result->datos = Array();

        // Consulta
        if($inicio>=0){
            $consultar = $this->consulta . ' limit ' . $inicio . ',' . $this->limite;
            $this->bd->abrirBD();
            $this->res = $this->bd->consultarBD($consultar,$this->parametros);
            $respuesta = $this->res->fetchAll(PDO::FETCH_OBJ);

            foreach ($respuesta as $dato) {
                $result->datos[] = $dato;
            }
            
            $this->bd->cerrarBD();
        }

        return $result;
    }

    /**
     * Crea los enlaces
     * @param type $enlaces
     * @return string
     */
    public function crearLinks($enlaces) {
        $ultimo = ceil($this->total / $this->limite);
        $comienzo = (($this->pagina - $enlaces) > 0) ? $this->pagina - $enlaces : 1;
        $fin = (($this->pagina + $enlaces ) < $ultimo) ? $this->pagina + $enlaces : $ultimo;
        
        $clase = ($this->pagina == 1) ? "" : "";
        $html = '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . ($comienzo) . '">&laquo;</a></li>';

        if ($comienzo > 1) {
            $html .= '<li><a href="?limit=' . $this->limite . '&page=1">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $comienzo; $i <= $fin; $i++) {
            $clase = ( $this->pagina == $i ) ? "active" : "";
            $html .= '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . $i . '">' . $i . '</a></li>';
        }

        if ($fin < $ultimo) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="?limit=' . $this->limite . '&page=' . $ultimo . '">' . $ultimo . '</a></li>';
        }
        
        $clase = ( $this->pagina == $fin ) ? "disabled" : "enabled";
        $html .= '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . ($fin) . '">&raquo;</a></li>';
        return $html;
    }

}
