
<?php

session_start();

class Calculadora{

    protected $a;
    protected $b;
    protected $operador;
    protected $output;
    protected $mrc;
    protected $res;
    protected $lastB;
    protected $lastClickOperator;
    protected $lastWriteB;
    protected $lastClickEq;

    public function __construct(){  
        $this->a = "";
        $this->b="";
        $this->operador="+";
        $this->output = "";
        $this->mrc = "";
        $this->res="";
        $this->lastB = "";
        $this->lastClickOperator= false;
        $this->lastWriteB = false;
        $this->lastClickEq = false;
        
    }    
       

     public function onOff(){
        $this->a = "";
        $this->b="";
        $this->operador="+";
        $this->mrc = "";
        $this->res="";
        $this->lastB = "";
        $this->lastClickOperator= false;
        $this->lastWriteB = false;
        $this->lastClickEq = false;
        
        $this->output ="";
    }

    public function borrar(){
        $this->output = "";
        if($this->lastWriteB){
            $this->b = "";
        }else{
            $this->a = "";
        }
    }

    public function digitos($n){   
        if($this->lastClickEq){
            $this->output = "";
            $this->a = "";
            $this->b = "";
        }
        
        if(!$this->lastClickOperator){
            $this->a = $this->a . $n;
            try{
                $this->output = eval("return $this->a ;");
            }catch(Throwable $err){
                $this->output = "Error: " . $err;
            }   

        }else{
            $this->b = $this->b . $n;
            try{
                $this->output = eval("return $this->b ;"); 
            }catch(Throwable $err){
                $this->output = "Error: " . $err;
            }   
            $this->lastWriteB = true;           
        }       
        
        $this->lastClickEq = false; 
                
    }

    public function masMenos(){
        if(strlen($this->output) != 0){
            if($this->output[0] != "-"){
                $this->output = "-" . $this->output;
            }else{
                $this->output = $this->output.substring(1,strlen($this->output));
            }

            if(strlen($this->b) == 0){
                if($this->a[0] != "-"){
                    $this->a = "-" . $this->a;
                }else{
                    $this->a = $this->a.substring(1,strlen($this->a));
                }
            }else{
                if($this->b[0] != "-"){
                    $this->b = "-" . $this->b;
                }else{
                    $this->b = $this->b.substring(1,strlen($this->b));
                }
            }
        }

        $this->lastClickEq = false;
            
    }

    public function raiz(){
       
        if(strlen($this->a) != 0 && !$this->lastClickOperator){
            try{
                $this->a = sqrt(eval("return $this->a ;"));
            }catch(Throwable $err){
                $this->output = "Error: " . $err;
            }   
            $this->output = $this->a;
        }else{
            try{
                $this->b = sqrt(eval("return $this->b ;"));
            }catch(Throwable $err){
                $this->output = "Error: " . $err;
            }   
            $this->output = $this->b;
        }    

        $this->lastClickOperator = false;

    }

    public function porcentaje(){
        if($this->operador == "*" || $this->operador == "/"){
            if(strlen($this->b) != 0){
                $this->b = $this->b/100;            
                $this->output = $this->b;                          
            
            }else{
                if($this->lastClickOperator){
                    $this->b = $this->a/100;              
                    $this->output = $this->b;
                }else{
                    $this->a = "0";              
                    $this->output = $this->a;
                    $this->lastClickEq = true;
                }
                
            }
        }else{
            if(strlen($this->b) != 0){
                $this->b = $this->a * $this->b/100;            
                $this->output = $this->b;                          
            
            }else{
                if($this->lastClickOperator){
                    $this->b = $this->a * $this->a/100;              
                    $this->output = $this->b;
                }else{
                    $this->a = "0";              
                    $this->output = $this->a;
                    $this->lastClickEq = true;
                }
                
            }
        }
        
        
    }

   

    public function resta(){
        if(strlen($this->a) != 0 && strlen($this->b) != 0){            
            $this->igual();
            $this->operador = "-";
        }else{
            $this->operador = "-";
            
        }

        $this->lastClickOperator= true;
        $this->lastClickEq = false;
    }

    public function suma(){
        
        if(strlen($this->a) != 0 && strlen($this->b) != 0){
            $this->igual();
            $this->operador = "+";
        }else{
            $this->operador = "+";            
        }

        $this->lastClickOperator= true;
        $this->lastClickEq = false;
    }

    public function getMrc(){     
        if($this->lastClickEq){
            $this->output = "";
            $this->a = "";
            $this->b = "";
        }

        if($this->lastClickOperator){
            $this->a = $this->mrc;
            try{
                $this->output = eval("return $this->a ;"); 
            }catch(Throwable $err){
                $this->output = "Error: " . $err;
            }   
        }else{
            $this->b = $this->mrc;
            try{
                $this->output = eval("return $this->b ;"); 
            }catch(Throwable $err){
                $this->output = "Error: " . $err;
            }              
        }
       
        
    }

    public function mMas(){
        try{
            $this->mrc = eval("return $this->mrc + $this->output ;");
        }catch(Throwable $err){
            $this->output = "Error: " . $err;
        }            
        
        $this->lastClickEq = true;
    }

    public function mMenos(){
        try{
            $this->mrc = eval("return $this->mrc - $this->output ;");
        }catch(Throwable $err){
            $this->output = "Error: " . $err;
        }   
        
        
        $this->lastClickEq = true;
        
    }

    
    public function multiplicacion(){
        if(strlen($this->a) != 0 && strlen($this->b) != 0){
            $this->igual();
            $this->operador = "*";
        }else{
            $this->operador = "*";        
        }

        $this->lastClickOperator= true;
        $this->lastClickEq = false;
        
    }

    public function division(){
        if(strlen($this->a) != 0 && strlen($this->b) != 0){
            $this->igual();
            $this->operador = "/";
        }else{
            $this->operador = "/";        
        }

        $this->lastClickOperator= true;
        $this->lastClickEq = false;
        
    }

    public function punto(){
        
        if(strlen($this->b) == 0){
            $this->a = $this->a .".";
            $this->output = $this->a; 
        }else{
            $this->b = $this->b .".";
            $this->output = $this->b;
        }
        
        $this->lastClickEq = false;
    }

    public function igual(){
        
        if(strlen($this->b) == 0){
            $this->b = $this->lastB;
        }

        if($this->lastWriteB){
            $this->lastClickOperator = false;
            $this->lastWriteB = false;
        }        

        if($this->lastClickOperator && strlen($this->b) == 0){
            $this->b = $this->a;
        }

        try{
            $this->res =eval("return ". $this->a . $this->operador . $this->b ." ;");
        }catch(Throwable $err){
            $this->output = "Error: " . $err;
        }   
        $this->output = $this->res;
        
        $this->a = $this->res;
        $this->lastB = $this->b;
        $this->b = "";
        $this->lastClickOperator = false;

       
        $this->lastClickEq = true;        
        
    }

    public function ver(){
        return $this->output;
    }
  

    
}
?>





<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>CalculadoraMilan</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Daniel Alberto Alonso Fernandez" />
    <meta name ="description" content ="Simulador de la calculadora milan" />
    <meta name ="keywords" content ="calculadora, milan, php" />

    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />    
    
    <link rel="stylesheet" type="text/css" href="CalculadoraMilan.css"/>
   
</head>

<body>

    <?php 
       
      if(!isset($_SESSION['calcM'])) {
        $_SESSION['calcM'] = new Calculadora();
      }
      
      $calc = $_SESSION['calcM'];

      if (count($_POST)>0) {           

        if(isset($_POST['bOn'])) $calc->onOff();
        else if(isset($_POST['bCe'])) $calc->borrar();
        else if(isset($_POST['b+-'])) $calc->masMenos();
        else if(isset($_POST['bRaiz'])) $calc->raiz();
        else if(isset($_POST['b%'])) $calc->porcentaje();
        
        else if(isset($_POST['b7'])) $calc->digitos(7);
        else if(isset($_POST['b8'])) $calc->digitos(8);
        else if(isset($_POST['b9'])) $calc->digitos(9);
        else if(isset($_POST['bx'])) $calc->multiplicacion();
        else if(isset($_POST['b/'])) $calc->division();

        else if(isset($_POST['b4'])) $calc->digitos(4);
        else if(isset($_POST['b5'])) $calc->digitos(5);
        else if(isset($_POST['b6'])) $calc->digitos(6);
        else if(isset($_POST['b-'])) $calc->resta();
        else if(isset($_POST['bMrc'])) $calc->getMrc();

        else if(isset($_POST['b1'])) $calc->digitos(1);
        else if(isset($_POST['b2'])) $calc->digitos(2);
        else if(isset($_POST['b3'])) $calc->digitos(3);
        else if(isset($_POST['b+'])) $calc->suma();
        else if(isset($_POST['bM-'])) $calc->mMenos();

        else if(isset($_POST['b0'])) $calc->digitos(0);
        else if(isset($_POST['bp'])) $calc->punto();
        else if(isset($_POST['b='])) $calc->igual();
        else if(isset($_POST['bM+'])) $calc->mMas();
                
    }
    
    ?>

    <form action='#' method='post' >
        <label for="inputText">Nata by Milan</label>
        <input type="text" readonly id = "inputText" value = "<?php echo $calc->ver(); ?>"/>

        <input type="submit" name = "bOn" value="On" />
        <input type="submit" name = "bCe" value="CE" />
        <input type="submit" name = "b+-" value="+/-" />
        <input type="submit" name = "bRaiz" value="Raiz" />
        <input type="submit" name = "b%" value="%" />
        
        <input type="submit" name = "b7" value="7" />
        <input type="submit" name = "b8" value="8" />
        <input type="submit" name = "b9" value="9" />
        <input type="submit" name = "bx" value="x" />
        <input type="submit" name = "b/" value="/" />
        
        <input type="submit" name = "b4" value="4" />
        <input type="submit" name = "b5" value="5" />
        <input type="submit" name = "b6" value="6" />
        <input type="submit" name = "b-" value="-" />
        <input type="submit" name = "bMrc" value="Mrc" />

        <input type="submit" name = "b1" value="1" />
        <input type="submit" name = "b2" value="2" />
        <input type="submit" name = "b3" value="3" />
        <input type="submit" name = "b+" value="+" />
        <input type="submit" name = "bM-" value="M-" />

        <input type="submit" name = "b0" value="0" />
        <input type="submit" name = "bp" value="." />
        <input type="submit" name = "b=" value="=" />
        <input type="submit" name = "bM+" value="M+" />
</form>
    
</body>
</html>