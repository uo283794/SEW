// 104-ClaseGeolocalizacion.js
// VersiÃ³n 1.0 16/noviembre/2018. Juan Manuel Cueva Lovelle. Universidad de Oviedo
// Version 1.1 23/10/2021 
"use strict";
class Kml2Map {

    constructor(){
        this.kmlxml;
        this.coordenadas;
        this.listaCoordenadasBruto = [];
        this.listaCoordenadas = []
    }

    cargarKml() {
        var nBytes = 0;
        var archivo = document.getElementsByTagName("input")[0].files[0];        
             
                              
        var lector = new FileReader();
        lector.onload = function (evento) {        
            f.kmlxml = lector.result; 
            f.coordenadas = $('coordinates',f.kmlxml).text();     
                    
                               
        }
        lector.readAsText(archivo);            
    }

    parsear(){
        
        this.listaCoordenadasBruto = this.coordenadas.split(",0.0");
        
        for(var i = 0; i < this.listaCoordenadasBruto.length-1; i++){
            this.listaCoordenadas.push(this.listaCoordenadasBruto[i].trim().split(","));
        }
        
       // console.log(this.listaCoordenadas); 
    }


    initMap(){
        this.parsear();
        var oviedo = {lat: 43.3672702, lng: -5.8502461};
        var mapaOviedo = new google.maps.Map(document.getElementsByTagName('aside')[0],{zoom: 5,center:oviedo});

        for(var i = 0; i < this.listaCoordenadas.length; i++){
            var punto = {lat: Number(this.listaCoordenadas[i][1]), lng: Number(this.listaCoordenadas[i][0])};
            var marcador = new google.maps.Marker({position:punto,map:mapaOviedo});            
        }        
    }      
   
}


let f = new Kml2Map();