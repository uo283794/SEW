"use strict";
class Calculadora{
    constructor(){  
        this.stack = new Array();
        
        this.outputFinal = document.getElementsByTagName('textarea')[0];
        this.outputEnter = document.getElementsByTagName('input')[0];
        this.mrc = "";
        this.res="";
        
        
        this.number = "";
        
        
    }

    digitos(n){   
        this.number = this.number + n;
        this.outputEnter.value = this.number;
                
    }

    enter(){
        this.stack.push(this.number);
        this.mostrarPila();
        this.outputEnter.value = "";
        this.number = "";
        this.isPunto = false;
    }

    
    resta(){    
        if(this.stack.length <= 1){
            return;
        }
        var a = this.stack.pop();
        var b = this.stack.pop();          
        
        this.res = new Number(b) - new Number(a);
        this.stack.push(this.res);
        this.mostrarPila();
    }

    suma(){        
        if(this.stack.length <= 1){
            return;
        }
        this.res = new Number(this.stack.pop()) + new Number(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();      
    }

    multiplicacion(){   
        if(this.stack.length <= 1){
            return;
        }             
        this.res = new Number(this.stack.pop()) + new Number(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();        
    }

    division(){
        if(this.stack.length <= 1){
            return;
        }
        var a = this.stack.pop();
        var b = this.stack.pop();          
        
        this.res = new Number(b) / new Number(a);
        this.stack.push(this.res);
        this.mostrarPila();
        
    }


    sin(){
        if(this.stack.length == 0){
            return;
        }
        this.res = Math.sin(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();

    }

    cos(){
        if(this.stack.length == 0){
            return;
        }
        this.res = Math.cos(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();

    }

    tan(){
        if(this.stack.length == 0){
            return;
        }
        this.res = Math.tan(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();

    }

    acrsin(){
        if(this.stack.length == 0){
            return;
        }
        this.res = Math.asin(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();

    }

    arccos(){
        if(this.stack.length == 0){
            return;
        }
        this.res = Math.acos(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();

    }

    arctan(){
        if(this.stack.length == 0){
            return;
        }
        this.res = Math.atan(this.stack.pop());
        this.stack.push(this.res);
        this.mostrarPila();
       
    }


    mostrarPila(){     
        this.outputFinal.textContent = "";   
        for(let i = 0; i < this.stack.length;i++){  
            this.outputFinal.textContent += this.stack[i] + "\n";         
                       
        }  
    }   

    punto(){
        if(!this.isPunto){
            if(this.number == ""){
                this.number = new Number(0); 
            }
            this.number = this.number + "."; 
            this.isPunto = true;
            this.outputEnter.value = this.number;
        }

    }

    ce() {
        this.number = "";
        this.outputEnter.value = this.number;
        this.isPunto = false;
    }

    onOff() {
        this.stack = new Array();
        this.borrarDatos();
        this.mostrarPila();
    }

    keys(event){
        if(event.key == "o"){
            this.onOff();
        }else if(event.key == "Enter"){
            event.preventDefault();
            this.enter();
        }else if(event.key == "c"){            
            this.ce();
        }else if(event.key == "s"){
            this.sin();
        }else if(event.key == "d"){
            this.cos();
        }else if(event.key == "t"){
            this.tan();
        }else if(event.key == "z"){
            this.acrsin();
        }else if(event.key == "x"){
            this.arccos();
        }else if(event.key == "v"){
            this.arctan();
        }else if(event.key == "0"){
            this.digitos(0);
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
        }else if(event.key == "+"){
            this.suma();
        }else if(event.key == "-"){
            this.resta();
        }else if(event.key == "*"){
            this.multiplicacion();
        }else if(event.key == "/"){
            this.division();
        }else if(event.key == "."){
            this.punto();
        }
    }
    
}

class CalculadoraEspecializada extends Calculadora{
    constructor(){
        super();
        this.isShift = false;
    }

    shift(){
        if(this.isShift){
            this.isShift = false;
            document.getElementsByTagName('input')[25].value = "Km->Mi"
            document.getElementsByTagName('input')[26].value = "Cm->In"
            document.getElementsByTagName('input')[27].value = "Cm->Ft"
            document.getElementsByTagName('input')[28].value = "Cm->Yd"
        }else{
            this.isShift = true;
            document.getElementsByTagName('input')[25].value = "Mi->Km"
            document.getElementsByTagName('input')[26].value = "In->Cm"
            document.getElementsByTagName('input')[27].value = "Ft->Cm"
            document.getElementsByTagName('input')[28].value = "Yd->Cm"
        }

    }

    Km2Mi(){
        if(this.stack.length == 0){
            return;
        }
        if(!this.isShift){
            this.res = this.stack.pop() / 1.6093;
        }else{
            this.res = this.stack.pop() * 1.6093;
        }
        this.stack.push(this.res);
        this.mostrarPila();
    }

    Cm2In(){
        if(this.stack.length == 0){
            return;
        }
        if(!this.isShift){
            this.res = this.stack.pop() / 2.54;
        }else{
            this.res = this.stack.pop() * 2.54;
        }
        this.stack.push(this.res);
        this.mostrarPila();
    }

    Cm2Ft(){
        if(this.stack.length == 0){
            return;
        }
        if(!this.isShift){
            this.res = this.stack.pop() / 30.48;
        }else{
            this.res = this.stack.pop() * 30.48;
        }
        this.stack.push(this.res);
        this.mostrarPila();
    }

    Cm2Yd(){
        if(this.stack.length == 0){
            return;
        }
        if(!this.isShift){
            this.res = this.stack.pop() / 91.44;
        }else{
            this.res = this.stack.pop() * 91.44;
        }
        this.stack.push(this.res);
        this.mostrarPila();
    }

    keys(event){
        if(event.key == "Shift"){
            this.shift();
        }else if(event.key == "p"){
            this.Km2Mi();
        }else if(event.key == "o"){
            this.Cm2In();
        }else if(event.key == "i"){
            this.Cm2Ft();
        }else if(event.key == "u"){
            this.Cm2Yd();
        }else{
            super.keys(event);
        }
        
    }
}

var c = new CalculadoraEspecializada();

document.addEventListener('keydown',(event) =>{c.keys(event)});