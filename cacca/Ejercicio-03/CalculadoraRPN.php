<?php
session_start();
class CalculadoraRPN{

    protected $stack;        
    protected $outputFinal;
    protected $outputEnter;    
    protected $res;            
    protected $number;


    public function __construct(){  
        $this->stack = [];        
        $this->outputFinal = "";
        $this->outputEnter = "";        
        $this->res="";                
        $this->number = "";        
    }

    public function digitos($n){                 
        $this->number = $this->number . $n;        
        $this->outputEnter = $this->number;                
    }

    public function enter(){        
        array_push($this->stack,$this->number);
        $this->mostrarPila();
        $this->outputEnter = "";
        $this->number = "";
        $this->isPunto = false;
    }

    
    public function resta(){    
        if(count($this->stack) <= 1){
            return;
        }
        $a = array_pop($this->stack);
        $b = array_pop($this->stack);          
        
        $this->res = $b - $a;
        array_push($this->stack,$this->res);
        $this->mostrarPila();
    }

    public function suma(){        
        if(count($this->stack) <= 1){
            return;
        }
        $this->res = array_pop($this->stack) + array_pop($this->stack);
        array_push($this->stack,$this->res);
        $this->mostrarPila();      
    }

    public function multiplicacion(){   
        if(count($this->stack) <= 1){
            return;
        }             
        $this->res = array_pop($this->stack) * array_pop($this->stack);
        array_push($this->stack,$this->res);
        $this->mostrarPila();        
    }

    public function division(){
        if(count($this->stack) <= 1){
            return;
        }
        $a = array_pop($this->stack);
        $b = array_pop($this->stack);          
        
        try{
            $this->res = $b / $a;
            array_push($this->stack,$this->res);
            $this->mostrarPila();
        }catch(Throwable $err){
            $this->onOff();
        }
        
    }


    public function sin(){
        if(count($this->stack) == 0){
            return;
        }
        $this->res = sin(array_pop($this->stack));
        array_push($this->stack,$this->res);
        $this->mostrarPila();

    }

    public function cos(){
        if(count($this->stack) == 0){
            return;
        }
        $this->res = cos(array_pop($this->stack));
        array_push($this->stack,$this->res);
        $this->mostrarPila();

    }

    public function tan(){
        if(count($this->stack) == 0){
            return;
        }
        $this->res = tan(array_pop($this->stack));
        array_push($this->stack,$this->res);
        $this->mostrarPila();

    }

    public function arcsin(){
        if(count($this->stack) == 0){
            return;
        }
        $this->res = asin(array_pop($this->stack));
        array_push($this->stack,$this->res);
        $this->mostrarPila();

    }

    public function arccos(){
        if(count($this->stack) == 0){
            return;
        }
        $this->res = acos(array_pop($this->stack));
        array_push($this->stack,$this->res);
        $this->mostrarPila();

    }

    public function arctan(){
        if(count($this->stack) == 0){
            return;
        }
        $this->res = atan(array_pop($this->stack));
        array_push($this->stack,$this->res);
        $this->mostrarPila();
       
    }


    public function mostrarPila(){     
        $this->outputFinal = "";   
        for($i = 0; $i < count($this->stack);$i++){  
            $this->outputFinal .= $this->stack[$i] . "\n";         
                       
        }  
    }   

    public function punto(){
        if(!$this->isPunto){
            if($this->number == ""){
                $this->number = 0; 
            }
            $this->number = $this->number . "."; 
            $this->isPunto = true;
            $this->outputEnter = $this->number;
        }

    }

    public function ce() {
        $this->number = "";
        $this->outputEnter = $this->number;
        $this->isPunto = false;
    }

    public function onOff() {
        
        $this->borrarDatos();
        $this->mostrarPila();
    }
    
    private function borrarDatos(){
        $this->stack = [];
        
        $this->outputFinal = "";
        $this->outputEnter = "";
        
        $this->res="";        
        
        $this->number = "";
    }

    public function verPila(){
       
        return $this->outputFinal;
    }

    public function verEnter(){
        return $this->outputEnter;
    }
    
}
?>


<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>CalculadoraRPN</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Daniel Alberto Alonso Fernandez" />
    <meta name ="description" content ="Simulador de una calculadora RPN" />
    <meta name ="keywords" content ="calculadora, RPN, php" />

    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />    
    <link rel="stylesheet" type="text/css" href="CalculadoraRPN.css"/>
   
</head>

<body>

    <?php
    
        if(!isset($_SESSION['calcR'])) {
            $_SESSION['calcR'] = new CalculadoraRPN();
        }
        
        $calc = $_SESSION['calcR'];

        if (count($_POST)>0) {           

            if(isset($_POST['bOn'])) $calc->onOff();
            else if(isset($_POST['bCE'])) $calc->ce();
            else if(isset($_POST['bSin'])) $calc->sin();
            else if(isset($_POST['bCos'])) $calc->cos();
            else if(isset($_POST['bTan'])) $calc->tan();

            else if(isset($_POST['b7'])) $calc->digitos(7);
            else if(isset($_POST['b8'])) $calc->digitos(8);
            else if(isset($_POST['b9'])) $calc->digitos(9);
            else if(isset($_POST['bx'])) $calc->multiplicacion();
            else if(isset($_POST['b/'])) $calc->division();

            else if(isset($_POST['b4'])) $calc->digitos(4);
            else if(isset($_POST['b5'])) $calc->digitos(5);
            else if(isset($_POST['b6'])) $calc->digitos(6);        
            else if(isset($_POST['b-'])) $calc->resta();
            else if(isset($_POST['bArcSin'])) $calc->arcsin();

            else if(isset($_POST['b1'])) $calc->digitos(1);
            else if(isset($_POST['b2'])) $calc->digitos(2);
            else if(isset($_POST['b3'])) $calc->digitos(3);
            else if(isset($_POST['b+'])) $calc->suma();
            else if(isset($_POST['bArcCos'])) $calc->arccos();

            else if(isset($_POST['b0'])) $calc->digitos(0);
            else if(isset($_POST['bp'])) $calc->punto();
            else if(isset($_POST['bEnter'])) $calc->enter();
            else if(isset($_POST['bArcTan'])) $calc->arctan();
                    
        }
    
    ?>


    <form action='#' method='post'>
        <label for="textArea">Calculadora RPN</label>
        <textarea rows="6" disabled id = "textArea" ><?php echo $calc->verPila(); ?></textarea>
        <label for="inputText">Input:</label>
        <input type="text" disabled id = "inputText" value = "<?php echo $calc->verEnter(); ?>"/>

        <input type="submit" name ="bOn" value="On" />
        <input type="submit" name ="bCE" value="CE" />
        <input type="submit" name ="bSin" value="Sin" />
        <input type="submit" name ="bCos" value="Cos" />
        <input type="submit" name ="bTan" value="Tan" />
        
        <input type="submit" name ="b7" value="7" />
        <input type="submit" name ="b8" value="8" />
        <input type="submit" name ="b9" value="9" />
        <input type="submit" name ="bx" value="x" />
        <input type="submit" name ="b/" value="/" />
        
        <input type="submit" name ="b4" value="4" />
        <input type="submit" name ="b5" value="5" />
        <input type="submit" name ="b6" value="6" />
        <input type="submit" name ="b-" value="-" />
        <input type="submit" name ="bArcSin" value="ArcSin" />

        <input type="submit" name ="b1" value="1" />
        <input type="submit" name ="b2" value="2" />
        <input type="submit" name ="b3" value="3" />
        <input type="submit" name ="b+" value="+" />
        <input type="submit" name ="bArcCos" value="ArcCos" />

        <input type="submit" name ="b0" value="0" />
        <input type="submit" name ="bp" value="." />
        <input type="submit" name ="bEnter" value="Enter" />
        <input type="submit" name ="bArcTan" value="ArcTan" />
</form>
    
</body>
</html>