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
        
        this.lastClickEq = true;
    }

    mMenos(){
        try{
            this.mrc = new Number(eval(new Number(this.mrc) - new Number(this.output.value)));
        }catch(err){
            this.output.value = "Error: " + err;
        }   
        
        
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

let c = new Calculadora();
document.addEventListener('keydown',(event) =>{c.keys(event)});
