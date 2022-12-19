<?php
session_start();

class Plata{
    public function __construct(){      
        
        $this->dia = "";
        $this->mes = "";

        $this->apikey = "5rhs8bfz37eqwfetcsj24pkbc560q9wtk0hph4ilbiacjr905e312lr83gc2";        
        $this->endpoint = "";
        $this->base = "XAG";
        $this->url = "https://commodities-api.com/api/" . $this->endpoint . "?access_key=". $this->apikey . "&base=" . $this->base;
                
    }

    public function cargarDatos(){   
        
        $this->dia = $_POST['d'];
        $this->mes = $_POST['m'];

        $this->setUrl();
        $datos = file_get_contents($this->url);
        $info = json_decode($datos);

        
        if(is_numeric($this->dia) && is_numeric($this->mes)){        
            $stringDatos = "<p>Fecha: " . $info->data->date . "</p>";
            $stringDatos .= "<p>Precio:</p>";
            $stringDatos .= "<p>USD: " . $info->data->rates->USD . " $</p>";
            $stringDatos .= "<p>EUR: " . $info->data->rates->EUR . " €</p>";
        }else{
            $stringDatos = "<p>Datos inexistentes</p>";
        }

        echo $stringDatos ;
                
            
                

        $this->dia = "";
        $this->mes = "";
        $this->endpoint = "";
    }

    public function setUrl(){
        $date = getdate();
       
        if(floatval($this->mes) <= floatval($date["mon"])){
            if(floatval($this->mes) == floatval($date["mon"])){
                if(floatval($this->dia) <= floatval($date["mday"])){
                    $this->endpoint = "2022-". $this->mes . "-".$this->dia; 
                }else{
                    $this->endpoint = "latest";
                }
            }else{
                $this->endpoint = "2022-". $this->mes . "-" . $this->dia; 
            } 
              
        }else{
            $this->endpoint = "latest";            
        }
        $this->url = "https://commodities-api.com/api/" . $this->endpoint . "?access_key=". $this->apikey . "&base=" . $this->base;
    }

    

    

    
}

?>


<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Ejercicio4</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Daniel Alberto Alonso Fernandez" />
    <meta name ="description" content ="Ejercicio de php" />
    <meta name ="keywords" content ="php, plata, usd" />

    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />    
    <link rel="stylesheet" type="text/css" href="Ejercicio4.css"/>
   
</head>

<body>
    <h1>Precio del Petroleo (Barril de Brent) 2022</h1>

    <form action='#' method='post'>
        <label for="dia">Introducza un dia(1-31)</label>
        <input type="text" name = "d" id = "dia" />
        
        <label for="mes">Introduzca un mes(1-12):</label>
        <input type="text" name = "m" id = "mes" />

        <input type="submit" name = "cDatos" value="Ver Datos" />
    </form>
        
    <aside>

        <?php
        
            if(!isset($_SESSION['p'])) {
                $_SESSION['p'] = new Plata();
            }        
            $ag = $_SESSION['p'];
            if (count($_POST)>0) {           
                if(isset($_POST['cDatos'])) $ag->cargarDatos();  
                        
            }
        
        ?>

    </aside>

</body>
</html>

