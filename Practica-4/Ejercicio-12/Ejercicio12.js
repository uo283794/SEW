// 104-ClaseGeolocalizacion.js
// VersiÃ³n 1.0 16/noviembre/2018. Juan Manuel Cueva Lovelle. Universidad de Oviedo
// Version 1.1 23/10/2021 
"use strict";
class File {

    calcularTamañoArchivos() {
        var nBytes = 0;
        var archivo = document.getElementsByTagName("input")[0].files[0];
        
             
                 
        var data = "<p>Archivo = "+ archivo.name  + " Tamaño: " + archivo.size +" bytes " +
            " Tipo: " + archivo.type+"</p>";          
             
        
        
       
        $(document.getElementsByTagName('p')[1]).remove();
        $(document.getElementsByTagName('input')[0]).after("<p>"+data+"</p>");

        var tipoTexto = /text.*/;        
        var tipoJson = /.json/;
        if (archivo.type.match(tipoTexto) || archivo.type.match(tipoJson)){
              
            var lector = new FileReader();
            lector.onload = function (evento) {
            
                $("p:last").after("<pre></pre>");
                $("pre:last").text("Contenido:" + lector.result);
            }

            lector.readAsText(archivo);
            }
        }
}


let f = new File();