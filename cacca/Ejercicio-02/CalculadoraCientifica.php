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
        print_r("xegue");
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

//----------------------------------------------------------------------------------------------------------------------

class CalculadoraCientifica extends Calculadora{
    protected $numero;
    protected $operacion;
    protected $operacionMath;
    protected $operacionesEspeciales;

    protected $nParentesisAbiertos;
    protected $nParentesisCerrados;
    protected $isShift;
    protected $isHyp;
    protected $isDeg;

    protected $isPunto;
    
    public function __construct(){
        parent::__construct();
        $this->numero = "";
        $this->operacion = [];
        $this->operacionMath = "";
        $this->operacionesEspeciales = ["sqrt(", "sin(","cos(","tan(","sinh("
        ,"cosh(","tanh(",'$this->factorial(','$this->pow2(',"asin(","acos(","atan("
        ,"asinh(","acosh(","atanh(","log10("];

        $this->nParentesisAbiertos = 0;
        $this->nParentesisCerrados = 0;
        $this->isShift = false;
        $this->isHyp = false;
        $this->isDeg = 0;

        $this->isPunto = false;
        
    }

    public function onOff(){
        $this->numero = "";
        $this->operacion = [];
        $this->operacionMath = "";
        $this->nParentesisAbiertos = 0;
        $this->nParentesisCerrados = 0;
        $this->isShift = false;
        $this->isHyp = false;
        $this->isDeg = 0;
        $this->isPunto = false;

        $this->output = "";
    }

    public function borrar(){
             
        $this->numero = "0";   
        $this->isPunto = false;
        $this->printCalculus();
    }

    public function borrar1(){        
        if($this->numero != ""){
            $this->numero = $this->numero.substring(0,strlen($this->numero)-1);
            if(str_contains(strval($this->numero),".")){                
                $this->isPunto = true;
            }else{
                $this->isPunto = false;
            }
        }else{
            $last = array_pop($this->operacion);
            if(is_numeric($last)){
                $this->numero = strval($last).substring(0,strlen(strval($last))-1);
                if(str_contains(strval($this->numero),".")){                
                    $this->isPunto = true;
                }else{
                    $this->isPunto = false;
                }
            }
        }

        $this->printCalculus();
        $this->output .= $this->numero;
    }

     public function fe(){
    //     if(count($this->operacion) == 0 || !is_numeric($this->operacion[count($this->operacion)-1])){
    //         $numeroExp = Number.parseFloat(new Number($this->numero)).toExponential();  
    //         printCalculus(); 
                    
    //         $this->numero = numeroExp;            
    //         $this->output .= $this->numero;  
              
    //     }       

        
    }

    public function ponerPunto(){
        
        if(!$this->isPunto){
            if($this->numero == ""){
                $this->numero = "0";
            }
            $this->numero .= ".";
            $this->isPunto = true;
            $this->printCalculus();
            $this->output .= $this->numero;
        }

    } 
        
    

    public function pi(){        
        if(count($this->operacion) == 0 || is_numeric($this->operacion[count($this->operacion)-1])){
            $this->printCalculus();
            $this->output .= "PI";
            $this->numero = pi();
            
        }else{
            $this->numero = pi();
            $this->printCalculus();
            $this->output .= "PI";
        }
        
    }

    public function deg(){
        if($this->isDeg == 0){
            //document.getElementsByTagName('input')[1].value = "DEG";
            $this->isDeg = 1;
        }else if($this->isDeg == 1){
            //document.getElementsByTagName('input')[1].value = "GRAD";
            $this->isDeg = 2;
        }else{
            //document.getElementsByTagName('input')[1].value = "RAD";
            $this->isDeg = 0;
        }
    }

    public function shift(){
        if(!$this->isShift){
            $this->isShift = true;
            if(!$this->isHyp){                
                // document.getElementsByTagName('input')[12].value = "arcCos";
                // document.getElementsByTagName('input')[11].value = "arcSin";
                // document.getElementsByTagName('input')[13].value = "arcTan";
            }else{
                // document.getElementsByTagName('input')[11].value = "arcCosh";
                // document.getElementsByTagName('input')[12].value = "arcSinh";
                // document.getElementsByTagName('input')[13].value = "arcTanh";
            }
        }else{
            $this->isShift = false;
            if(!$this->isHyp){
                
                // document.getElementsByTagName('input')[12].value = "cos";
                // document.getElementsByTagName('input')[11].value = "sin";
                // document.getElementsByTagName('input')[13].value = "tan";
            }else{
                // document.getElementsByTagName('input')[12].value = "cosh";
                // document.getElementsByTagName('input')[11].value = "sinh";
                // document.getElementsByTagName('input')[13].value = "tanh";
            }
            
        }

    }

    public function hyp(){
        if($this->isHyp){
            $this->isHyp = false;
            if(!$this->isShift){                
                // document.getElementsByTagName('input')[12].value = "cos";
                // document.getElementsByTagName('input')[11].value = "sin";
                // document.getElementsByTagName('input')[13].value = "tan";
            }else{
                // document.getElementsByTagName('input')[12].value = "arcCos";
                // document.getElementsByTagName('input')[11].value = "arcSin";
                // document.getElementsByTagName('input')[13].value = "arcTan";
            }
        }else{
            $this->isHyp = true;
            if(!$this->isShift){
                
                // document.getElementsByTagName('input')[12].value = "cosh";
                // document.getElementsByTagName('input')[11].value = "sinh";
                // document.getElementsByTagName('input')[13].value = "tanh";
            }else{
                // document.getElementsByTagName('input')[12].value = "arcCosh";
                // document.getElementsByTagName('input')[11].value = "arcSinh";
                // document.getElementsByTagName('input')[13].value = "arcTanh";
            }
            
        }
    }

    public function digitos($n){   
        if($this->lastClickEq){
            $this->numero = "";
            $this->output = "";
            $this->lastClickEq = false;
        }

        if($this->numero == pi()){
            $this->printCalculus();
            $this->output .="";
            $this->numero = "";
        }
        $this->ultimosNumeros = $this->numero;
        $this->numero = $this->ultimosNumeros  . $n;
        $this->output = $this->output . $n; 
        
                        
    }

    public function masMenos(){
        if($this->numero[0] != "-" || $this->numero == ""){
            $this->numero = "-" . $this->numero;
        }else{
            $this->numero = str_replace("-","",$this->numero);
        }
        $this->printCalculus();
        $this->output .= $this->numero;     
            
    }

    public function raiz(){
        $this->operarMath("sqrt(");
    }

    public function log(){
        $this->operarMath("log10(");
    }

    public function cos(){
        if($this->isShift){
            if($this->isHyp){
                $this->operarMath("acosh(");
            }else{
                $this->operarMath("acos(");
            }
        }else{
            if($this->isHyp){
                $this->operarMath("cosh(");
            }else{
                $this->operarMath("cos(");
            } 
        }
    }

    public function sin(){
        if($this->isShift){
            if($this->isHyp){
                $this->operarMath("asinh(");
            }else{
                $this->operarMath("asin(");
            }
        }else{
            if($this->isHyp){
                $this->operarMath("sinh(");
            }else{
                $this->operarMath("sin(");
            } 
        }

    }

    public function tan(){
        if($this->isShift){
            if($this->isHyp){
                $this->operarMath("atanh(");
            }else{
                $this->operarMath("atan(");
            }
        }else{
            if($this->isHyp){
                $this->operarMath("tanh(");
            }else{
                $this->operarMath("tan(");
            } 
        }

    }

    public function factorialRec(){
        $this->operarMath('$this->factorial(');
    }

    public function pow2Rec(){
        $this->operarMath('$this->pow2(');
    }

       

    public function resta(){
        $this->operar("-");
        
    }

    public function suma(){
        $this->operar("+");
       
    }

    public function multiplicacion(){
        $this->operar("*");
        
    }

    public function division(){
        $this->operar("/");
    }

    public function mod(){
        $this->operar("%");
    }

    public function pow(){
        $this->operar("**");
    }

    public function exp(){
        $this->operar("*10**");
    }

   
    public function pizq(){
        $this->operar("(");
        $this->nParentesisAbiertos++;
    }

    public function pdch(){
        $this->operar(")");
        $this->nParentesisCerrados++;
    }

    public function operar($op){
        if($this->numero != ""){
            array_push($this->operacion ,$this->numero);
        }
        array_push($this->operacion,$op);
        
        $this->numero = "";
        $this->lastClickEq = false;
        if($this->numero == pi()){
            $this->numero = 0;
        }
        $this->isPunto = false;
        $this->printCalculus();
    }

    public function operarMath($op){
        if($this->numero != ""){
            array_push($this->operacion,$this->numero);
        }
        array_push($this->operacion,$op);
        $this->numero = "";
        $this->lastClickEq = false;
        if($this->numero == pi()){
            $this->numero = 0;
        }
        $this->isPunto = false;
        $this->printCalculus();
    }

    public function factorial($n){
        if($n == 0){
            return 1;
        }
        return $n * $this->factorial($n-1);
        
    }

    public function pow2($n){
        if($n == 0){
            return 1;
        }
        return 2 * $this->pow2($n -1);
    }

    public function mrcC(){
        $this->mrc = 0;
    }

    public function getMrc(){     
        if($this->lastClickEq){
            $this->numero = "";
            $this->output = "";
            $this->lastClickEq = false;
        }
        $this->numero = "" . $this->mrc;
        $this->output = $this->output . $this->mrc;
        
    }

    public function mMas(){
        try{
            $this->mrc = eval("return " . $this->numero . ";") + eval("return " . $this->mrc . ";");
        }catch(Throwable $err){
            $this->output = "Error: " . $err;
        }
    }

    public function mMenos(){
        try{
            $this->mrc = eval("return " . $this->mrc . ";") - eval("return " . $this->numero . ";");
        }catch(Throwable $err){
            $this->output = "Error: " . $err;
        }
        
    }

    public function ms(){
        $this->mrc = $this->numero;
    }

    
   

    public function punto(){
       
    }

    public function igual(){
        $this->operar("=");
        
        if($this->nParentesisAbiertos == $this->nParentesisCerrados){
            $this->fromList2Math();
            
            if($this->isDeg == 1){
                $this->toDeg();
            }else if($this->isDeg == 2){
                $this->toGrad();
            }   

            $this->operacionMath = str_replace("--","+",$this->operacionMath);
            

           
            try{       
                $this->ret = eval("return " . $this->operacionMath . ";");
            }catch(Throwable $err){
                $this->output = "Error: " . $err;
            }   
            
            $this->vaciarOperacion();
            $this->numero = "" . $this->ret;            
            $this->output = $this->ret;
            $this->ret = "";
            $this->lastClickEq = true;
            
           
        }else{
            $this->output = "SYNTAX.ERROR";
        }
        
        
    }

    public function toDeg(){
        
        $this->operacionMath = str_replace("cos(","cos(" . (pi()/180) . "*",$this->operacionMath);
        $this->operacionMath = str_replace("sin(","sin(".(pi()/180)."*",$this->operacionMath);
        $this->operacionMath = str_replace("tan(","tan(".(pi()/180)."*",$this->operacionMath);

        $this->operacionMath = str_replace("acos(","acos(".(pi()/180)."*",$this->operacionMath);
        $this->operacionMath = str_replace("asin(","asin(".(pi()/180)."*",$this->operacionMath);
        $this->operacionMath = str_replace("atan(","atan(".(pi()/180)."*",$this->operacionMath);

        $this->operacionMath = str_replace("cosh(","cosh(".(pi()/180)."*",$this->operacionMath);
        $this->operacionMath = str_replace("sinh(","sinh(".(pi()/180)."*",$this->operacionMath);
        $this->operacionMath = str_replace("tanh(","tanh(".(pi()/180)."*",$this->operacionMath);

        $this->operacionMath = str_replace("acosh(","acosh(".(pi()/180)."*",$this->operacionMath);
        $this->operacionMath = str_replace("asinh(","asinh(".(pi()/180)."*",$this->operacionMath);
        $this->operacionMath = str_replace("atanh(","atanh(".(pi()/180)."*",$this->operacionMath);
    }

    public function toGrad(){
        $this->operacionMath = str_replace("cos(","cos(". (pi()/200). "*",$this->operacionMath);
        $this->operacionMath = str_replace("sin(","sin(". (pi()/200). "*",$this->operacionMath);
        $this->operacionMath = str_replace("tan(","tan(". (pi()/200) . "*",$this->operacionMath);

        $this->operacionMath = str_replace("acos(","acos(" . (pi()/200) . "*",$this->operacionMath);
        $this->operacionMath = str_replace("asin(","asin(".(pi()/200)."*",$this->operacionMath);
        $this->operacionMath = str_replace("atan(","atan(".(pi()/200)."*",$this->operacionMath);

        $this->operacionMath = str_replace("cosh(","cosh(".(pi()/200)."*",$this->operacionMath);
        $this->operacionMath = str_replace("sinh(","sinh(".(pi()/200)."*",$this->operacionMath);
        $this->operacionMath = str_replace("tanh(","tanh(".(pi()/200)."*",$this->operacionMath);

        $this->operacionMath = str_replace("acosh(","acosh(".(pi()/200)."*",$this->operacionMath);
        $this->operacionMath = str_replace("asinh(","asinh(".(pi()/200)."*",$this->operacionMath);
        $this->operacionMath = str_replace("atanh(","atanh(".(pi()/200)."*",$this->operacionMath);
    }

    public function fromList2Math(){       
        $this->operacionMath = "";
        $this->parserEspecial();
        for($i = 0; $i < count($this->operacion)-1 ; $i++){              
            $this->operacionMath = $this->operacionMath . $this->operacion[$i];            
        }
        
    }

    public function parserEspecial(){        
        $parentesisPeligroso = $this->checkParentesisConMath();
        //var especialEnEspecial = $this->checkEspecialEnEspecial();
       
        if( $parentesisPeligroso != -1){
            $this->findParentesis($parentesisPeligroso);
        }

      /*  if(especialEnEspecial != -1){
            $this->execEspecialEnEspecial(especialEnEspecial);
        } */

        for($i = 1; $i < count($this->operacion) ; $i++){              
            if(in_array($this->operacion[$i],$this->operacionesEspeciales)){
                if($this->operacion[$i-1] != ")"){
                    $this->operacion[$i-1] = $this->operacion[$i] . $this->operacion[$i-1] . ")";
                    array_pop($this->operacion);
                }
                
            }
        }

    }

    

    public function printCalculus(){        
        
        $this->parserEspecial();
        
        $txt = "";
        for($i = 0; $i < count($this->operacion); $i++){  
                     
            $txt .= $this->operacion[$i];
        }

        $this->output = str_replace('$this->',"",$txt);
        
    }

    public function checkParentesisConMath(){
        for($i = 1; $i < count($this->operacion) ; $i++){ 
            if($this->operacion[$i-1] == ")" && in_array($this->operacion[$i],$this->operacionesEspeciales)){
                return $i;
            }
        }
        return -1;               
    }

    public function checkEspecialEnEspecial(){
        for($i = 0; $i < count($this->operacion)-2 ; $i++){             
            if($this->operacion[$i].substring(0,4) == "Math" || $this->operacion[$i].substring(0,7) == '$this->' && in_array($this->operacion[$i+2],$this->operacionesEspeciales)){
                return $i;
            }
        }
        return -1;               
    }



    public function findParentesis($n){
        $posI = -1;
        $posD = $n;
        for($i = $n; $i >= 0 ; $i--){ 
            if($posI == -1){
                if($this->operacion[$i] == "("){
                    $posI = $i;
                    
                }
            }
        }
        $this->execParentesis($posI,$posD); 
    }

    public function execEspecialEnEspecial($n){
        $exec = "";
        $result = 0;
        $exec = $this->operacion[$n+1] .$this->operacion[$n] . ")"; 
        try{ 
            $result = eval("return $exec ;");
        }catch(Throwable $err){
            $this->output = "Error: " . $err;
        }   
        array_splice($this->operacion,$n,2,$result);
    }

    public function execParentesis($posI,$posD){
        $exec = "";
        $result = 0;
        $siguiente = array_pop($this->operacion);
        do{
            $exec =  array_pop($this->operacion) . $exec ; 
            $posD--;
        }while($posI < $posD);                                
        
       
        try{
            $result = eval("return $exec ;");  
        }catch(Throwable $err){
            $this->output = "Error: " . $err;
        }         
        array_push($this->operacion,$siguiente . $result . ")");
        
    }

    public function vaciarOperacion(){
        while(count($this->operacion) != 0){            
            array_pop($this->operacion);            
        }
    }

   
}

?>

<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>CalculadoraCientifica</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Daniel Alberto Alonso Fernandez" />
    <meta name ="description" content ="Simulador de la calculadora cientifica" />
    <meta name ="keywords" content ="calculadora, cientifica, php" />

    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />    
    <link rel="stylesheet" type="text/css" href="CalculadoraCientifica.css"/>
   
</head>

<body>

    <?php 
       
      if(!isset($_SESSION['calcC'])) {
        $_SESSION['calcC'] = new CalculadoraCientifica();
      }
      
      $calc = $_SESSION['calcC'];

      if (count($_POST)>0) {           

        if(isset($_POST['bRAD'])) $calc->deg();
        else if(isset($_POST['bHYP'])) $calc->hyp();
        // else if(isset($_POST['bF-E'])) $calc->fe();

        else if(isset($_POST['bMc'])) $calc->mrcC();
        else if(isset($_POST['bMr'])) $calc->getMrc();
        else if(isset($_POST['bM+'])) $calc->mMas();
        else if(isset($_POST['bM-'])) $calc->mMenos();
        else if(isset($_POST['bMs'])) $calc->ms();

        else if(isset($_POST['bx2'])) $calc->pow2Rec();
        else if(isset($_POST['bxy'])) $calc->pow();
        else if(isset($_POST['bsin'])) $calc->sin();
        else if(isset($_POST['bcos'])) $calc->cos();
        else if(isset($_POST['btan'])) $calc->tan();
        
        else if(isset($_POST['braiz'])) $calc->raiz();
        else if(isset($_POST['b10x'])) $calc->pow10();
        else if(isset($_POST['blog'])) $calc->log();
        else if(isset($_POST['bexp'])) $calc->exp();
        else if(isset($_POST['bmod'])) $calc->mod();

        else if(isset($_POST['bShift'])) $calc->shift();
        else if(isset($_POST['bCE'])) $calc->borrar();
        else if(isset($_POST['bC'])) $calc->onOff();
        else if(isset($_POST['bDelete'])) $calc->borrar1();
        else if(isset($_POST['b/'])) $calc->division();

        else if(isset($_POST['bpi'])) $calc->pi();
        else if(isset($_POST['b7'])) $calc->digitos(7);
        else if(isset($_POST['b8'])) $calc->digitos(8);
        else if(isset($_POST['b9'])) $calc->digitos(9);
        else if(isset($_POST['bx'])) $calc->multiplicacion();
        
        else if(isset($_POST['bn!'])) $calc->factorialRec();
        else if(isset($_POST['b4'])) $calc->digitos(4);
        else if(isset($_POST['b5'])) $calc->digitos(5);
        else if(isset($_POST['b6'])) $calc->digitos(6);
        else if(isset($_POST['b-'])) $calc->resta();
       
        else if(isset($_POST['b+/-'])) $calc->masMenos();
        else if(isset($_POST['b1'])) $calc->digitos(1);
        else if(isset($_POST['b2'])) $calc->digitos(2);
        else if(isset($_POST['b3'])) $calc->digitos(3);
        else if(isset($_POST['b+'])) $calc->suma();      
        
        else if(isset($_POST['b('])) $calc->pizq();
        else if(isset($_POST['b)'])) $calc->pdch();
        else if(isset($_POST['b0'])) $calc->digitos(0);
        else if(isset($_POST['bp'])) $calc->ponerPunto();  
        else if(isset($_POST['b='])) $calc->igual();
                      
                
    }
    
    ?>

    <form action='#' method='post' >
        <label for="inputText">Calculadora Cientifica</label>
        <input type="text" disabled id = "inputText" value = "<?php echo $calc->ver(); ?>" />

        <input type="submit" name="bRAD" value="RAD" />
        <input type="submit" name="bHYP" value="HYP" />
        <!-- <input type="submit" name="bF-E" value="F-E" /> -->

        <input type="submit" name="bMc" value="Mc" />
        <input type="submit" name="bMr" value="Mr" />
        <input type="submit" name="bM+" value="M+" />
        <input type="submit" name="bM-" value="M-" />
        <input type="submit" name="bMs" value="Ms" />
        
        <input type="submit" name="bx2" value="x2" />
        <input type="submit" name="bxy" value="xy" />
        <input type="submit" name="bsin" value="sin" />
        <input type="submit" name="bcos" value="cos" />
        <input type="submit" name="btan" value="tan" />

        <input type="submit" name="braiz" value="raiz" />
        <input type="submit" name="b10x" value="10x" />
        <input type="submit" name="blog" value="log" />
        <input type="submit" name="bexp" value="exp" />
        <input type="submit" name="bmod" value="mod" />


        <input type="submit" name="bShift" value="Shift" />
        <input type="submit" name="bCE" value="CE" />
        <input type="submit" name="bC" value="C" />
        <input type="submit" name="bDelete" value="Delete" />
        <input type="submit" name="b/" value="/" />
        
        <input type="submit" name="bpi" value="pi" />
        <input type="submit" name="b7" value="7" />
        <input type="submit" name="b8" value="8" />
        <input type="submit" name="b9" value="9" />
        <input type="submit" name="bx" value="x" />
        
        
        <input type="submit" name="bn!" value="n!" />
        <input type="submit" name="b4" value="4" />
        <input type="submit" name="b5" value="5" />
        <input type="submit" name="b6" value="6" />
        <input type="submit" name="b-" value="-" />
        
        <input type="submit" name="b+/-" value="+/-" />
        <input type="submit" name="b1" value="1" />
        <input type="submit" name="b2" value="2" />
        <input type="submit" name="b3" value="3" />
        <input type="submit" name="b+" value="+" />
        
        <input type="submit" name="b(" value="(" />
        <input type="submit" name="b)" value=")" />
        <input type="submit" name="b0" value="0" />
        <input type="submit" name="bp" value="." />
        <input type="submit" name="b=" value="=" />
        
</form>
    
</body>
</html>