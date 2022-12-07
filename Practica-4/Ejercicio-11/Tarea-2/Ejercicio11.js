// 104-ClaseGeolocalizacion.js
// VersiÃ³n 1.0 16/noviembre/2018. Juan Manuel Cueva Lovelle. Universidad de Oviedo
// Version 1.1 23/10/2021 
"use strict";
class Geolocalizacion {
    constructor (){
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this),this.verErrores.bind(this));
    }
    getPosicion(posicion){
        this.mensaje = "Se ha realizado correctamente la peticion de geolocalizacion";
        this.longitud         = posicion.coords.longitude; 
        this.latitud          = posicion.coords.latitude;  
        this.precision        = posicion.coords.accuracy;
        this.altitud          = posicion.coords.altitude;
        this.precisionAltitud = posicion.coords.altitudeAccuracy;
        this.rumbo            = posicion.coords.heading;
        this.velocidad        = posicion.coords.speed;       
    }
    getLongitud(){
        return this.longitud;
    }
    getLatitud(){
        return this.latitud;
    }
    getAltitud(){
        return this.altitud;
    }
    verTodo(){
        
        var datos=''; 
        datos+='<p>'+this.mensaje +'</p>';
        datos+='<p>Longitud: '+this.longitud +' grados</p>'; 
        datos+='<p>Latitud: '+this.latitud +' grados</p>';
        datos+='<p>Precision de la latitud y longitud: '+ this.precision +' metros</p>';
        datos+='<p>Altitud: '+ this.altitude +' metros</p>';
        datos+='<p>Precision de la altitud: '+ this.precisionAltitud +' metros</p>'; 
        datos+='<p>Rumbo: '+ this.rumbo +' grados</p>'; 
        datos+='<p>Velocidad: '+ this.velocidad +' metros/segundo</p>';
        
        $(document.getElementsByTagName('aside')[document.getElementsByTagName('aside').length-1]).after(datos);
        $(document.getElementsByTagName('input')).remove();
    }


    verErrores(error){
        switch(error.code) {
        case error.PERMISSION_DENIED:
            this.mensaje = "El usuario no permite la peticion de geolocalizacion"
            break;
        case error.POSITION_UNAVAILABLE:
            this.mensaje = "InformaciÃ³n de geolocalizacion no disponible"
            break;
        case error.TIMEOUT:
            this.mensaje = "La peticiÃ³n de geolocalizacion ha caducado"
            break;
        case error.UNKNOWN_ERROR:
            this.mensaje = "Se ha producido un error desconocido"
            break;
        }
    }
}
var g = new Geolocalizacion();