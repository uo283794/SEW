// 104-ClaseGeolocalizacion.js
// VersiÃ³n 1.0 16/noviembre/2018. Juan Manuel Cueva Lovelle. Universidad de Oviedo
// Version 1.1 23/10/2021 
"use strict";
class Kml2Map {

    constructor(){
        this.gjson;
        this.coordenadas;
        this.listaCoordenadasBruto = [];
        this.listaCoordenadas = []
    }

    cargarGjson() {
        var nBytes = 0;
        var archivo = document.getElementsByTagName("input")[0].files[0];        
             
                              
        var lector = new FileReader();
        lector.onload = function (evento) {        
            f.gjson = JSON.parse(lector.result); 
            
           
                    
                               
        }
        lector.readAsText(archivo);            
    }
    


    initMap(){        
        var centro = {lat: 43.3672702, lng: -5.8502461};
        var mapa = new google.maps.Map(document.getElementsByTagName('aside')[0],{zoom: 5,center:centro});

        for(var i = 0; i < this.gjson.red.length; i++){
            var punto = {lat: Number(this.gjson.red[i].geometry.coordinates[1]), lng: Number(this.gjson.red[i].geometry.coordinates[0])};
            var marcador = new google.maps.Marker({position:punto,map:mapa});            
        }        
    }      
   
}


let f = new Kml2Map();