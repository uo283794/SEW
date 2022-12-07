"use strict";
class Meteo{
    constructor(){      
        this.dia = document.getElementsByTagName('input')[0];
        this.mes = document.getElementsByTagName('input')[1];

        this.apikey = "a3el3ir402wl1n5qmilx7hf9cqqjudw9s6kxhdtyzgdg5hac4qt2fa4zgbd6";        
        this.endpoint = "";
        this.url = "https://commodities-api.com/api/" + this.endpoint + "?access_key="+ this.apikey;
                
    }

    cargarDatos(){       

        this.setUrl();

        $.ajax({
            dataType: "json",
            url: this.url,
            method: 'GET',
            success: function(datos){
                //$(document.getElementsByTagName('input')[0]).after("<aside></aside>");
                //$("pre").text(JSON.stringify(datos, null, 2)); //muestra el json en un elemento pre
                
                var stringDatos = "<p>Fecha: " + datos.data.date + "</p>";
                stringDatos += "<p>Precio:</p>";
                stringDatos += "<p>USD: " + datos.data.rates.USD + " $</p>";
                stringDatos += "<p>EUR: " + datos.data.rates.EUR + " €</p>";


                
            
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

        this.dia.value = "";
        this.mes.value = "";
        this.endpoint = "";
    }

    setUrl(){
        var date = new Date();
       
        if(new Number(this.mes.value) <= new Number(date.getMonth())+1){
            if(new Number(this.mes.value) == new Number(date.getMonth())+1){
                if(new Number(this.dia.value) <= new Number(date.getDate())){
                    this.endpoint = "2022-"+ this.mes.value + "-"+this.dia.value; 
                }else{
                    this.endpoint = "latest";
                }
            }else{
                this.endpoint = "2022-"+ this.mes.value + "-"+this.dia.value; 
            } 
        console.log("cambio");      
        }else{
            this.endpoint = "latest";
            console.log("fumo");
        }
        this.url = "https://commodities-api.com/api/" + this.endpoint + "?access_key="+ this.apikey;
    }

    

    
}

let m = new Meteo();