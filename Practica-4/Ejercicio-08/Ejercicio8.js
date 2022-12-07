"use strict";
class Meteo{
    constructor(){        
        this.apikey = "fa1accaa5523321bbd75f61333b5de03";        
        this.codigoPais = "ES";
        this.unidades = "&units=metric";
        this.idioma = "&lang=es";
        this.url = "";
        this.correcto = "¡Todo correcto! JSON recibido de <a href='http://openweathermap.org'>OpenWeatherMap</a>"
        
    }
    cargarDatos(){
        $.ajax({
            dataType: "json",
            url: this.url,
            method: 'GET',
            success: function(datos){
                //$(document.getElementsByTagName('input')[0]).after("<aside></aside>");
                   // $("section").text(JSON.stringify(datos, null, 2)); //muestra el json en un elemento pre
                
                    //PresentaciÃ³n de los datos contenidos en JSON
                    
                    var stringDatos = "<p>Ciudad: " + datos.name + "</p>";
                        stringDatos += "<p>Pai­s: " + datos.sys.country + "</p>";
                        stringDatos += "<p>Latitud: " + datos.coord.lat + " grados</p>";
                        stringDatos += "<p>Longitud: " + datos.coord.lon + " grados</p>";
                        stringDatos += "<p>Temperatura: " + datos.main.temp + " grados Celsius</p>";
                        stringDatos += "<p>Temperatura maxima: " + datos.main.temp_max + " grados Celsius</p>";
                        stringDatos += "<p>Temperatura mi­nima: " + datos.main.temp_min + " grados Celsius</p>";
                        stringDatos += "<p>Presion: " + datos.main.pressure + " mipbares</p>";
                        stringDatos += "<p>Humedad: " + datos.main.humidity + " %</p>";
                        stringDatos += "<p>Amanece a las: " + new Date(datos.sys.sunrise *1000).toLocaleTimeString() + "</p>";
                        stringDatos += "<p>Oscurece a las: " + new Date(datos.sys.sunset *1000).toLocaleTimeString() + "</p>";
                        stringDatos += "<p>Direccion del viento: " + datos.wind.deg + " grados</p>";
                        stringDatos += "<p>Velocidad del viento: " + datos.wind.speed + " metros/segundo</p>";
                        stringDatos += "<p>Hora de la medida: " + new Date(datos.dt *1000).toLocaleTimeString() + "</p>";
                        stringDatos += "<p>Fecha de la medida: " + new Date(datos.dt *1000).toLocaleDateString() + "</p>";
                        stringDatos += "<p>Descripcion: " + datos.weather[0].description + "</p>";
                        stringDatos += "<p>Visibipdad: " + datos.visibipty + " metros</p>";
                        stringDatos += "<p>Nubosidad: " + datos.clouds.all + " %</p>";
                        stringDatos += "<img title=\"Imagen tiempo\" src=\"https://openweathermap.org/img/w/"+datos.weather[0].icon+".png\" alt=\"Clima\" />";
                    
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
        this.url = "http://api.openweathermap.org/data/2.5/weather?q=" + nombre + "," + this.codigoPais + this.unidades + this.idioma + "&APPID=" + this.apikey;
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