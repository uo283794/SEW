"use strict";
class Meteo{
    constructor(){        
        this.apikey = "fa1accaa5523321bbd75f61333b5de03";        
        this.codigoPais = "ES";
        this.unidades = "&units=metric";
        this.tipo = "&mode=xml";
        this.idioma = "&lang=es";
        this.url = "";
        this.correcto = "¡Todo correcto! JSON recibido de <a href='http://openweathermap.org'>OpenWeatherMap</a>"
        
    }
    cargarDatos(){
        $.ajax({
            dataType: "xml",
            url: this.url,
            method: 'GET',
            success: function(datos){
                //$(document.getElementsByTagName('input')[0]).after("<aside></aside>");
                   // $("section").text(JSON.stringify(datos, null, 2)); //muestra el json en un elemento pre
                
                    //PresentaciÃ³n de los datos contenidos en JSON
                    var totalNodos            = $('*',datos).length; // cuenta los elementos de XML: son los nodos del Ã¡rbol DOM de XML
                    var ciudad                = $('city',datos).attr("name");
                    var longitud              = $('coord',datos).attr("lon");
                    var latitud               = $('coord',datos).attr("lat");
                    var pais                  = $('country',datos).text();
                    var amanecer              = $('sun',datos).attr("rise");
                    var minutosZonaHoraria    = new Date().getTimezoneOffset();
                    var amanecerMiliSeg1970   = Date.parse(amanecer);
                        amanecerMiliSeg1970  -= minutosZonaHoraria * 60 * 1000;
                    var amanecerLocal         = (new Date(amanecerMiliSeg1970)).toLocaleTimeString("es-ES");
                    var oscurecer             = $('sun',datos).attr("set");          
                    var oscurecerMiliSeg1970  = Date.parse(oscurecer);
                        oscurecerMiliSeg1970  -= minutosZonaHoraria * 60 * 1000;
                    var oscurecerLocal        = (new Date(oscurecerMiliSeg1970)).toLocaleTimeString("es-ES");
                    var temperatura           = $('temperature',datos).attr("value");
                    var temperaturaMin        = $('temperature',datos).attr("min");
                    var temperaturaMax        = $('temperature',datos).attr("max");
                    var temperaturaUnit       = $('temperature',datos).attr("unit");
                    var humedad               = $('humidity',datos).attr("value");
                    var humedadUnit           = $('humidity',datos).attr("unit");
                    var presion               = $('pressure',datos).attr("value");
                    var presionUnit           = $('pressure',datos).attr("unit");
                    var velocidadViento       = $('speed',datos).attr("value");
                    var nombreViento          = $('speed',datos).attr("name");
                    var direccionViento       = $('direction',datos).attr("value");
                    var codigoViento          = $('direction',datos).attr("code");
                    var nombreDireccionViento = $('direction',datos).attr("name");
                    var nubosidad             = $('clouds',datos).attr("value");
                    var nombreNubosidad       = $('clouds',datos).attr("name");
                    var visibilidad           = $('visibility',datos).attr("value");
                    var precipitacionValue    = $('precipitation',datos).attr("value");
                    var precipitacionMode     = $('precipitation',datos).attr("mode");
                    var descripcion           = $('weather',datos).attr("value");
                    var horaMedida            = $('lastupdate',datos).attr("value");
                    var horaMedidaMiliSeg1970 = Date.parse(horaMedida);
                        horaMedidaMiliSeg1970 -= minutosZonaHoraria * 60 * 1000;
                    var horaMedidaLocal       = (new Date(horaMedidaMiliSeg1970)).toLocaleTimeString("es-ES");
                    var fechaMedidaLocal      = (new Date(horaMedidaMiliSeg1970)).toLocaleDateString("es-ES");
                    var icon           = $('weather',datos).attr("icon");



                    var stringDatos = "<p>Ciudad: " + ciudad + "</p>";
                        stringDatos += "<p>Pai­s: " + pais + "</p>";
                        stringDatos += "<p>Latitud: " + latitud + " grados</p>";
                        stringDatos += "<p>Longitud: " + longitud + " grados</p>";
                        stringDatos += "<p>Temperatura: " + temperatura + " grados Celsius</p>";
                        stringDatos += "<p>Temperatura maxima: " + temperaturaMax + " grados Celsius</p>";
                        stringDatos += "<p>Temperatura mi­nima: " + temperaturaMin + " grados Celsius</p>";
                        stringDatos += "<p>Presion: " + presion + " mipbares</p>";
                        stringDatos += "<p>Humedad: " + humedad + " %</p>";
                        stringDatos += "<p>Amanece a las: " + amanecerLocal + "</p>";
                        stringDatos += "<p>Oscurece a las: " + oscurecerLocal + "</p>";
                        stringDatos += "<p>Direccion del viento: " + direccionViento + " grados</p>";
                        stringDatos += "<p>Velocidad del viento: " + velocidadViento + " metros/segundo</p>";
                        stringDatos += "<p>Hora de la medida: " + horaMedidaLocal + "</p>";
                        stringDatos += "<p>Fecha de la medida: " + fechaMedidaLocal + "</p>";
                        stringDatos += "<p>Descripcion: " + descripcion + "</p>";
                        stringDatos += "<p>Visibipdad: " + visibilidad + " metros</p>";
                        stringDatos += "<p>Nubosidad: " + nubosidad + " %</p>";
                        stringDatos += "<img title=\"Imagen tiempo\" src=\"https://openweathermap.org/img/w/"+icon+".png\" alt=\"Clima\" />";
                    
                        $("aside").remove();
                        
                        $(document.getElementsByTagName('input')[document.getElementsByTagName('input').length-1]).after("<aside></aside>");
                        $("aside").append(stringDatos);
                    
                },
            error:function(){
                $("h3").html("Â¡Tenemos problemas! No puedo obtener JSON de <a href='http://openweathermap.org'>OpenWeatherMap</a>"); 
                $("h4").remove();
                $("pre").remove();
                $("p").remove();
                }
        });
    }

    cargarCiudad(nombre){        
        this.url = "http://api.openweathermap.org/data/2.5/weather?q=" + nombre + this.tipo + this.unidades + this.idioma + "&APPID=" + this.apikey;
        this.cargarDatos();
        
    }

    crearElemento(tipoElemento, texto, insertarAntesDe){
        // Crea un nuevo elemento modificando el Ã¡rbol DOM
        // El elemnto creado es de 'tipoElemento' con un 'texto' 
        // El elemnto se coloca antes del elemnto 'insertarAntesDe'
        var elemento = document.createElement(tipoElemento); 
        elemento.innerHTML = texto;
        $(insertarAntesDe).before(elemento);
    }
    verJSON(){
              //Muestra el archivo JSON recibido
              this.crearElemento("h2","Datos en JSON desde <a href='http://openweathermap.org'>OpenWeatherMap</a>","footer"); 
              this.crearElemento("h3",this.correcto,"footer"); // Crea un elemento con DOM 
              this.crearElemento("h4","JSON","footer"); // Crea un elemento con DOM        
              this.crearElemento("pre","","footer"); // Crea un elemento con DOM para el string con JSON
              this.crearElemento("h4","Datos","footer"); // Crea un elemento con DOM 
              this.crearElemento("p","","footer"); // Crea un elemento con DOM para los datos obtenidos con JSON
              this.cargarDatos();
              $("button").attr("disabled","disabled");
    }
}
var m = new Meteo();