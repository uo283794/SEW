"use strict";
class Calculadora{
    constructor(){  
        this.a = "";
        this.b="";
        this.operador="+";
        this.output = document.getElementsByTagName('input')[0];
        this.mrc = "";
        this.res="";
        this.lastB = "";
        this.lastClickOperator= false;
        this.lastWriteB = false;
        this.lastClickEq = false;
        
        
     }
    

   
   

    onOff(){
        this.a = "";
        this.b="";
        this.operador="+";
        this.mrc = "";
        this.res="";
        this.lastB = "";
        this.lastClickOperator= false;
        this.lastWriteB = false;
        this.lastClickEq = false;
        
        this.output.value ="";
    }

    borrar(){
        this.output.value = "";
        if(this.lastWriteB){
            this.b = "";
        }else{
            this.a = "";
        }
    }

    digitos(n){   
        if(this.lastClickEq){
            this.output.value = "";
            this.a = "";
            this.b = "";
        }
        
        if(!this.lastClickOperator){
            this.a = this.a + n;
            try{
                this.output.value = eval(this.a);
            }catch(err){
                this.output.value = "Error: " + err;
            }

        }else{
            this.b = this.b + n;
            try{
                this.output.value = eval(this.b); 
            }catch(err){
                this.output.value = "Error: " + err;
            }
            this.lastWriteB = true;           
        }       
        
        this.lastClickEq = false; 
                
    }

    masMenos(){
        if(this.output.value.length != 0){
            if(this.output.value[0] != "-"){
                this.output.value = "-" + this.output.value;
            }else{
                this.output.value = this.output.value.substring(1,this.output.value.length);
            }

            if(this.b.length == 0){
                if(this.a[0] != "-"){
                    this.a = "-" + this.a;
                }else{
                    this.a = this.a.substring(1,this.a.length);;
                }
            }else{
                if(this.b[0] != "-"){
                    this.b = "-" + this.b;
                }else{
                    this.b = this.b.substring(1,this.b.length);;
                }
            }
        }

        this.lastClickEq = false;
            
    }

    raiz(){
       
        if(this.a.length != 0 && !this.lastClickOperator){
            try{
                this.a = new Number(Math.sqrt(new Number(eval(new Number(this.a)))));
            }catch(err){
                this.output.value = "Error: " + err;
            }            
        
            this.output.value = this.a;
        }else{
            try{
                this.b = new Number(Math.sqrt(new Number(eval(new Number(this.b)))));
            }catch(err){
                this.output.value = "Error: " + err;
            }   
            this.output.value = this.b;
        }    

        this.lastClickOperator = false;

    }

    porcentaje(){
        if(this.operador == "*" || this.operador == "/"){
            if(this.b.length != 0){
                this.b = new Number(this.b)/100;            
                this.output.value = this.b;                          
            
            }else{
                if(this.lastClickOperator){
                    this.b = new Number(this.a)/100;              
                    this.output.value = this.b;
                }else{
                    this.a = "0";              
                    this.output.value = this.a;
                    this.lastClickEq = true;
                }
                
            }
        }else{
            if(this.b.length != 0){
                this.b = new Number(this.a) * new Number(this.b)/100;            
                this.output.value = this.b;                          
            
            }else{
                if(this.lastClickOperator){
                    this.b = new Number(this.a) * new Number(this.a)/100;              
                    this.output.value = this.b;
                }else{
                    this.a = "0";              
                    this.output.value = this.a;
                    this.lastClickEq = true;
                }
                
            }
        }
        
        
    }

   

    resta(){
        if(this.a.length != 0 && this.b.length != 0){            
            this.igual();
            this.operador = "-";
        }else{
            this.operador = "-";
            
        }

        this.lastClickOperator= true;
        this.lastClickEq = false;
    }

    suma(){
        
        if(this.a.length != 0 && this.b.length != 0){
            this.igual();
            this.operador = "+";
        }else{
            this.operador = "+";            
        }

        this.lastClickOperator= true;
        this.lastClickEq = false;
    }

    getMrc(){     
        if(this.lastClickEq){
            this.output.value = "";
            this.a = "";
            this.b = "";
        }

        if(this.lastClickOperator){
            this.a = this.mrc;
            try{
                this.output.value = eval(this.a); 
            }catch(err){
                this.output.value = "Error: " + err;
            }   
        }else{
            this.b = this.mrc;
            try{
                this.output.value = eval(this.b);     
            }catch(err){
                this.output.value = "Error: " + err;
            }          
        }
       
        
    }

    mMas(){
        try{
            this.mrc = eval(new Number(this.mrc) + new Number(this.output.value));
        }catch(err){
            this.output.value = "Error: " + err;
        }   
        console.log(this.mrc);     
        
        this.lastClickEq = true;
    }

    mMenos(){
        try{
            this.mrc = new Number(eval(new Number(this.mrc) - new Number(this.output.value)));
        }catch(err){
            this.output.value = "Error: " + err;
        }   
        console.log(this.mrc); 
        
        this.lastClickEq = true;
        
    }

    
    multiplicacion(){
        if(this.a.length != 0 && this.b.length != 0){
            this.igual();
            this.operador = "*";
        }else{
            this.operador = "*";        
        }

        this.lastClickOperator= true;
        this.lastClickEq = false;
        
    }

    division(){
        if(this.a.length != 0 && this.b.length != 0){
            this.igual();
            this.operador = "/";
        }else{
            this.operador = "/";        
        }

        this.lastClickOperator= true;
        this.lastClickEq = false;
        
    }

    punto(){
        if(this.b.length == 0){
            this.a = this.a + ".";
            this.output.value = this.a; 
        }else{
            this.b = this.b + ".";
            this.output.value = this.b;
        }
        
        this.lastClickEq = false;
    }

    igual(){
        
        if(this.b.length == 0){
            this.b = this.lastB;
        }

        if(this.lastWriteB){
            this.lastClickOperator = false;
            this.lastWriteB = false;
        }        

        if(this.lastClickOperator && this.b.length == 0){
            this.b = this.a;
        }
        try{
            this.res = new Number(eval(new Number(this.a) + this.operador + new Number(this.b)));
        }catch(err){
            this.output.value = "Error: " + err;
        }   
        this.output.value = this.res;
        
        this.a = this.res;
        this.lastB = this.b;
        this.b = "";
        this.lastClickOperator = false;

        console.log(this.a+"");
        console.log(this.operador);
        console.log(this.b+"");

        this.lastClickEq = true;
        
        
    }

    keys(event){
        if(event.key == "o"){
            this.onOff();        
        }else if(event.key == "c"){            
            this.borrar();
        }else if(event.key == "r"){
            this.raiz();
        }else if(event.key == "º"){
            this.masMenos();
        }else if(event.key == "%"){
            this.porcentaje();
        }else if(event.key == "*"){
            this.multiplicacion();
        }else if(event.key == "/"){
            this.division();
        }else if(event.key == "-"){
            this.resta();
        }else if(event.key == "m"){
            this.getMrc();
        }else if(event.key == "1"){
            this.digitos(1);
        }else if(event.key == "2"){
            this.digitos(2);
        }else if(event.key == "3"){
            this.digitos(3);
        }else if(event.key == "4"){
            this.digitos(4);
        }else if(event.key == "5"){
            this.digitos(5);
        }else if(event.key == "6"){
            this.digitos(6);
        }else if(event.key == "7"){
            this.digitos(7);
        }else if(event.key == "8"){
            this.digitos(8);
        }else if(event.key == "9"){
            this.digitos(9);
        }else if(event.key == "0"){
            this.digitos(0);
        }else if(event.key == "+"){
            this.suma();
        }else if(event.key == "n"){
            this.mMenos();
        }else if(event.key == "b"){
            this.mMas();
        }else if(event.key == "="){
            this.igual();
        }else if(event.key == "."){
            this.punto();
        }
    }
      

    
}
//----------------------------------------------------------------------------------------------------------------------

class CalculadoraCientifica extends Calculadora{
    constructor(){
        super();
        this.numero = "";
        this.operacion = [];
        this.operacionMath = "";
        this.operacionesEspeciales = ["Math.sqrt(", "Math.sin(","Math.cos(","Math.tan","Math.sinh("
        ,"Math.cosh(","Math.tanh(","this.factorial(","this.pow2(","Math.asin(","Math.acos(","Math.atan"
        ,"Math.asinh(","Math.acosh(","Math.atanh(","Math.log10("];

        this.nParentesisAbiertos = 0;
        this.nParentesisCerrados = 0;
        this.isShift = false;
        this.isHyp = false;
        this.isDeg = 0;

        this.isPunto = false;
        
    }

    onOff(){
        this.numero = "";
        this.operacion = [];
        this.operacionMath = "";
        this.nParentesisAbiertos = 0;
        this.nParentesisCerrados = 0;
        this.isShift = false;
        this.isHyp = false;
        this.isDeg = 0;
        this.isPunto = false;

        this.output.value = "";
    }

    borrar(){
        console.log(this.operacion[this.operacion.length-1]);         
        this.numero = "0";   
        this.isPunto = false;
        this.printCalculus();
    }

    borrar1(){        
        if(this.numero != ""){
            this.numero = this.numero.substring(0,this.numero.length-1);
            if(this.numero.toString().includes(".")){                
                this.isPunto = true;
            }else{
                this.isPunto = false;
            }
        }else{
            var last = this.operacion.pop();
            if(!isNaN(last)){
                this.numero = last.toString().substring(0,last.toString().length-1);
                if(this.numero.toString().includes(".")){                
                    this.isPunto = true;
                }else{
                    this.isPunto = false;
                }
            }
        }

        this.printCalculus();
        this.output.value += this.numero;
    }

    fe(){
        if(this.operacion.length == 0 || !Number.isNaN(this.operacion[this.operacion.length-1])){
            var numeroExp = Number.parseFloat(new Number(this.numero)).toExponential();  
            this.printCalculus(); 
                    
            this.numero = numeroExp;            
            this.output.value += this.numero;  
              
        }       

        
    }

    ponerPunto(){
        if(!this.isPunto){
            if(this.numero == ""){
                this.numero = "0";
            }
            this.numero += ".";
            this.isPunto = true;
            this.printCalculus();
            this.output.value += this.numero;
        }

    } 
        
    

    pi(){        
        if(this.operacion.length == 0 || !Number.isNaN(this.operacion[this.operacion.length-1])){
            this.printCalculus();
            this.output.value += "PI";
            this.numero = Math.PI;
            
        }else{
            this.numero = Math.PI;
            this.printCalculus();
            this.output.value += "PI";
        }
        
    }

    deg(){
        if(this.isDeg == 0){
            document.getElementsByTagName('input')[1].value = "DEG";
            this.isDeg = 1;
        }else if(this.isDeg == 1){
            document.getElementsByTagName('input')[1].value = "GRAD";
            this.isDeg = 2;
        }else{
            document.getElementsByTagName('input')[1].value = "RAD";
            this.isDeg = 0;
        }
    }

    shift(){
        if(!this.isShift){
            this.isShift = true;
            if(!this.isHyp){                
                document.getElementsByTagName('input')[12].value = "arcCos";
                document.getElementsByTagName('input')[11].value = "arcSin";
                document.getElementsByTagName('input')[13].value = "arcTan";
            }else{
                document.getElementsByTagName('input')[11].value = "arcCosh";
                document.getElementsByTagName('input')[12].value = "arcSinh";
                document.getElementsByTagName('input')[13].value = "arcTanh";
            }
        }else{
            this.isShift = false;
            if(!this.isHyp){
                
                document.getElementsByTagName('input')[12].value = "cos";
                document.getElementsByTagName('input')[11].value = "sin";
                document.getElementsByTagName('input')[13].value = "tan";
            }else{
                document.getElementsByTagName('input')[12].value = "cosh";
                document.getElementsByTagName('input')[11].value = "sinh";
                document.getElementsByTagName('input')[13].value = "tanh";
            }
            
        }

    }

    hyp(){
        if(this.isHyp){
            this.isHyp = false;
            if(!this.isShift){                
                document.getElementsByTagName('input')[12].value = "cos";
                document.getElementsByTagName('input')[11].value = "sin";
                document.getElementsByTagName('input')[13].value = "tan";
            }else{
                document.getElementsByTagName('input')[12].value = "arcCos";
                document.getElementsByTagName('input')[11].value = "arcSin";
                document.getElementsByTagName('input')[13].value = "arcTan";
            }
        }else{
            this.isHyp = true;
            if(!this.isShift){
                
                document.getElementsByTagName('input')[12].value = "cosh";
                document.getElementsByTagName('input')[11].value = "sinh";
                document.getElementsByTagName('input')[13].value = "tanh";
            }else{
                document.getElementsByTagName('input')[12].value = "arcCosh";
                document.getElementsByTagName('input')[11].value = "arcSinh";
                document.getElementsByTagName('input')[13].value = "arcTanh";
            }
            
        }
    }

    digitos(n){   
        if(this.lastClickEq){
            this.numero = "";
            this.output.value = "";
            this.lastClickEq = false;
        }

        if(this.numero == Math.PI){
            this.printCalculus();
            this.output.value +="";
            this.numero = "";
        }
        this.ultimosNumeros = this.numero;
        this.numero = new Number(this.ultimosNumeros  + n).toString();
        this.output.value = this.output.value + n; 
        
                        
    }

    masMenos(){
        if(this.numero[0] != "-" || this.numero == ""){
            this.numero = "-"+this.numero;
        }else{
            this.numero = this.numero.replace("-","");
        }
        this.printCalculus()
        this.output.value += this.numero;     
            
    }

    raiz(){
        this.operarMath("Math.sqrt(");
    }

    log(){
        this.operarMath("Math.log10(");
    }

    cos(){
        if(this.isShift){
            if(this.isHyp){
                this.operarMath("Math.acosh(");
            }else{
                this.operarMath("Math.acos(");
            }
        }else{
            if(this.isHyp){
                this.operarMath("Math.cosh(");
            }else{
                this.operarMath("Math.cos(");
            } 
        }
    }

    sin(){
        if(this.isShift){
            if(this.isHyp){
                this.operarMath("Math.asinh(");
            }else{
                this.operarMath("Math.asin(");
            }
        }else{
            if(this.isHyp){
                this.operarMath("Math.sinh(");
            }else{
                this.operarMath("Math.sin(");
            } 
        }

    }

    tan(){
        if(this.isShift){
            if(this.isHyp){
                this.operarMath("Math.atanh(");
            }else{
                this.operarMath("Math.atan(");
            }
        }else{
            if(this.isHyp){
                this.operarMath("Math.tanh(");
            }else{
                this.operarMath("Math.tan(");
            } 
        }

    }

    factorialRec(){
        this.operarMath("this.factorial(");
    }

    pow2Rec(){
        this.operarMath("this.pow2(");
    }

       

    resta(){
        this.operar("-");
        
    }

    suma(){
        this.operar("+");
       
    }

    multiplicacion(){
        this.operar("*");
        
    }

    division(){
        this.operar("/");
    }

    mod(){
        this.operar("%");
    }

    pow(){
        this.operar("**");
    }

    exp(){
        this.operar("*10**")
    }

   
    pizq(){
        this.operar("(");
        this.nParentesisAbiertos++;
    }

    pdch(){
        this.operar(")")
        this.nParentesisCerrados++;
    }

    operar(op){
        if(this.numero != ""){
            this.operacion.push(this.numero)
        }
        this.operacion.push(op);
        
        this.numero = "";
        this.lastClickEq = false;
        if(this.numero == Math.PI){
            this.numero = 0;
        }
        this.isPunto = false;
        this.printCalculus();
    }

    operarMath(op){
        if(this.numero != ""){
            this.operacion.push(this.numero)
        }
        this.operacion.push(op);
        this.numero = "";
        this.lastClickEq = false;
        if(this.numero == Math.PI){
            this.numero = 0;
        }
        this.isPunto = false;
        this.printCalculus();
    }

    factorial(n){
        if(new Number(n) == 0){
            return 1;
        }
        return new Number(n) * this.factorial(new Number(n)-1);
        
    }

    pow2(n){
        if(new Number(n) == 0){
            return 1;
        }
        return 2 * this.pow2(new Number(n) -1);
    }

    mrcC(){
        this.mrc = 0;
    }

    getMrc(){     
        if(this.lastClickEq){
            this.numero = "";
            this.output.value = "";
            this.lastClickEq = false;
        }
        this.numero = ""+this.mrc;
        this.output.value = this.output.value + this.mrc;
        
    }

    mMas(){
        this.mrc = new Number(this.numero) + new Number(this.mrc);
    }

    mMenos(){
        this.mrc = new Number(this.mrc) - new Number(this.numero);
        
    }

    ms(){
        this.mrc = new Number(this.numero);
    }

    
   

    punto(){
       
    }

    igual(){
        this.operar("=");
        
        if(this.nParentesisAbiertos == this.nParentesisCerrados){
            this.fromList2Math();
            console.log(this.operacion);
            if(this.isDeg == 1){
                this.toDeg();
            }else if(this.isDeg == 2){
                this.toGrad();
            }   

            this.operacionMath = this.operacionMath.replace("--","+");

            console.log(this.isDeg); 
            console.log(this.operacionMath); 
            try{       
                this.ret = new Number(eval(this.operacionMath));
            }catch(err){
                this.output.value = "Error: " + err;
            }   
            
            this.vaciarOperacion();
            this.numero = ""+this.ret;            
            this.output.value = this.ret;
            this.ret = "";
            this.lastClickEq = true;
            
            console.log(this.operacion)
        }else{
            this.output.value = "SYNTAX.ERROR";
        }
        
        
    }

    toDeg(){
        
        this.operacionMath = this.operacionMath.replace("cos(","cos("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("sin(","sin("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("tan(","tan("+(Math.PI/180)+"*");

        this.operacionMath = this.operacionMath.replace("acos(","acos("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("asin(","asin("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("atan(","atan("+(Math.PI/180)+"*");

        this.operacionMath = this.operacionMath.replace("cosh(","cosh("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("sinh(","sinh("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("tanh(","tanh("+(Math.PI/180)+"*");

        this.operacionMath = this.operacionMath.replace("acosh(","acosh("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("asinh(","asinh("+(Math.PI/180)+"*");
        this.operacionMath = this.operacionMath.replace("atanh(","atanh("+(Math.PI/180)+"*");
    }

    toGrad(){
        this.operacionMath = this.operacionMath.replace("cos(","cos("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("sin(","sin("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("tan(","tan("+(Math.PI/200)+"*");

        this.operacionMath = this.operacionMath.replace("acos(","acos("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("asin(","asin("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("atan(","atan("+(Math.PI/200)+"*");

        this.operacionMath = this.operacionMath.replace("cosh(","cosh("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("sinh(","sinh("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("tanh(","tanh("+(Math.PI/200)+"*");

        this.operacionMath = this.operacionMath.replace("acosh(","acosh("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("asinh(","asinh("+(Math.PI/200)+"*");
        this.operacionMath = this.operacionMath.replace("atanh(","atanh("+(Math.PI/200)+"*");
    }

    fromList2Math(){       
        this.operacionMath = "";
        this.parserEspecial();
        for(let i = 0; i < this.operacion.length-1 ; i++){              
            this.operacionMath = this.operacionMath + this.operacion[i];            
        }
        
    }

    parserEspecial(){        
        var parentesisPeligroso = this.checkParentesisConMath()
        //var especialEnEspecial = this.checkEspecialEnEspecial();
        console.log(this.operacion);
        if( parentesisPeligroso != -1){
            this.findParentesis(parentesisPeligroso);
        }

      /*  if(especialEnEspecial != -1){
            this.execEspecialEnEspecial(especialEnEspecial);
        } */

        for(let i = 0; i < this.operacion.length ; i++){              
            if(this.operacionesEspeciales.includes(this.operacion[i])){
                if(this.operacion[i-1] != ")"){
                    this.operacion[i-1] = this.operacion[i] + this.operacion[i-1] + ")";
                    this.operacion.pop();
                }
                
            }
        }

    }

    

    printCalculus(){        
        
        this.parserEspecial();
        
        var txt = "";
        for(let i = 0; i < this.operacion.length; i++){  
                     
            txt += this.operacion[i];
        }

        this.output.value = txt.replace("Math.","").replace("this.","");
        
    }

    checkParentesisConMath(){
        for(let i = 1; i < this.operacion.length ; i++){ 
            if(this.operacion[i-1] == ")" && this.operacionesEspeciales.includes(this.operacion[i])){
                return i;
            }
        }
        return -1;               
    }

    checkEspecialEnEspecial(){
        for(let i = 0; i < this.operacion.length-2 ; i++){             
            if(this.operacion[i].substring(0,4) == "Math" || this.operacion[i].substring(0,4) == "this"  && this.operacionesEspeciales.includes(this.operacion[i+2])){
                return i;
            }
        }
        return -1;               
    }



    findParentesis(n){
        var posI = -1;
        var posD = n;
        for(let i = n; i >= 0 ; i--){ 
            if(posI == -1){
                if(this.operacion[i] == "("){
                    posI = i;
                    
                }
            }
        }
        this.execParentesis(posI,posD); 
    }

    execEspecialEnEspecial(n){
        var exec = "";
        var result = 0;
        exec = this.operacion[n+1] +this.operacion[n] + ")"; 
        try{ 
            result = new Number(eval(exec));
        }catch(err){
            this.output.value = "Error: " + err;
        }   
        this.operacion.splice(n,2,result)
    }

    execParentesis(posI,posD){
        var exec = "";
        var result = 0;
        var siguiente = this.operacion.pop();
        do{
            exec =  this.operacion.pop() + exec ; 
            posD--;
        }while(posI < posD)                                
        
        console.log(exec);
        try{
            result = new Number(eval(exec));  
        }catch(err){
            this.output.value = "Error: " + err;
        }         
        this.operacion.push(siguiente + result + ")");
        
    }

    vaciarOperacion(){
        while(this.operacion.length != 0){            
            this.operacion.pop();            
        }
    }

    keys(event){
        
        if(event.key == "o"){
            this.onOff();        
        }else if(event.key == "c"){            
            this.borrar();
        }else if(event.key == "r"){
            this.raiz();
        }else if(event.key == "º"){
            this.masMenos();
        }else if(event.key == "%"){
            this.mod();
        }else if(event.key == "*"){
            this.multiplicacion();
        }else if(event.key == "/"){
            this.division();
        }else if(event.key == "-"){
            this.resta();
        }else if(event.key == "m"){
            this.getMrc();
        }else if(event.key == "1"){
            this.digitos(1);
        }else if(event.key == "2"){
            this.digitos(2);
        }else if(event.key == "3"){
            this.digitos(3);
        }else if(event.key == "4"){
            this.digitos(4);
        }else if(event.key == "5"){
            this.digitos(5);
        }else if(event.key == "6"){
            this.digitos(6);
        }else if(event.key == "7"){
            this.digitos(7);
        }else if(event.key == "8"){
            this.digitos(8);
        }else if(event.key == "9"){
            this.digitos(9);
        }else if(event.key == "0"){
            this.digitos(0);
        }else if(event.key == "+"){
            this.suma();
        }else if(event.key == "n"){
            this.mMenos();
        }else if(event.key == "b"){
            this.mMas();
        }else if(event.key == "="){
            this.igual();
        }else if(event.key == "."){
            this.ponerPunto();
        }
    }
}



let c = new CalculadoraCientifica();

document.addEventListener('keydown',(event) =>{c.keys(event)});