
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Fichas del Alumnado</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="no_imprimir">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="alumno" class="sr-only">Nombre o DNI</label>
                        <input type="text" class="form-control" id="buscar" name="alumno" placeholder="Nombre o DNI">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
                    
                    <a href="javascript:window.print()" class="btn pull-right"> <span class="glyphicon glyphicon-print"></span> IMPRIMIR</a>
                    <a href="utilidades/descargar.php?opcion=TXT" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  TXT</a>
                    <a href="utilidades/descargar.php?opcion=PDF" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  PDF</a>
                    <a href="utilidades/descargar.php?opcion=XML" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  XML</a>
                    <a href="utilidades/descargar.php?opcion=JSON" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  JSON</a>
                    <a href="vistas/create.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir Alumno/a</a>
                    
                </form>
            </div>
           
            <div class="page-header clearfix">        
            </div>
            <?php
            
            require_once CONTROLLER_PATH."ControladorAlumno.php";
            require_once CONTROLLER_PATH . "Paginador.php";
            require_once UTILITY_PATH."funciones.php";
            
            if (!isset($_POST["alumno"])) {
                $nombre = "";
                $dni = "";
            } else {
                $nombre = filtrado($_POST["alumno"]);
                $dni = filtrado($_POST["alumno"]);
            }
            
            $controlador = ControladorAlumno::getControlador();
            
            // Parte del paginador
            $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;

             $consulta = "SELECT * FROM alumnadocrud WHERE nombre LIKE :nombre OR dni LIKE :dni";
             $parametros = array(':nombre' => "%".$nombre."%", ':nombre' => "%".$nombre."%", ':dni' => "%".$dni."%");
             $limite = 2; // Limite del paginador
             $paginador  = new Paginador($consulta, $parametros, $limite);
             $resultados = $paginador->getDatos($pagina);

            if(count( $resultados->datos)>0){
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>DNI</th>";
                echo "<th>Nombre</th>";
                echo "<th>EMail</th>";
                echo "<th>Contraseña</th>";
                echo "<th>Idiomas</th>";
                echo "<th>Matrícula</th>";
                echo "<th>Lenguajes</th>";
                echo "<th>Fecha</th>";
                echo "<th>Imagen</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // Recorro los registros encontrados
                foreach ($resultados->datos as $a) {
                    $alumno = new Alumno($a->id, $a->dni, $a->nombre, $a->email, $a->password, $a->idioma, $a->matricula, $a->lenguaje, $a->fecha, $a->imagen);
                    echo "<tr>";
                    echo "<td>" . $alumno->getDni() . "</td>";
                    echo "<td>" . $alumno->getNombre() . "</td>";
                    echo "<td>" . $alumno->getEmail() . "</td>";
                    echo "<td>" . str_repeat("*",strlen($alumno->getPassword())) . "</td>";
                    echo "<td>" . $alumno->getIdioma() . "</td>";
                    echo "<td>" . $alumno->getMatricula() . "</td>";
                    echo "<td>" . $alumno->getLenguaje() . "</td>";
                    echo "<td>" . $alumno->getFecha() . "</td>";
                    echo "<td><img src='imagenes/".$alumno->getImagen()."' width='48px' height='48px'></td>";
                    echo "<td>";
                    echo "<a href='vistas/read.php?id=" . encode($alumno->getId()) . "' title='Ver Alumno/a' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='vistas/update.php?id=" . encode($alumno->getId()) . "' title='Actualizar Alumno/a' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='vistas/delete.php?id=" . encode($alumno->getId()) . "' title='Borar Alumno/a' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "<ul class='pager' id='no_imprimir'>"; 
                echo $paginador->crearLinks($enlaces);
                echo "</ul>";
            } else {
                // Si no hay nada seleccionado
                echo "<p class='lead'><em>No se ha encontrado datos de alumnos/as.</em></p>";
            }
            ?>

        </div>
    </div>
    <div id="no_imprimir">
    <?php
        if(isset($_COOKIE['CONTADOR'])){
            echo $contador;
            echo $acceso;
        }
        else
            echo "Es tu primera visita hoy";
    ?>
    </div>
    <br><br><br> 