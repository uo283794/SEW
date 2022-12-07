"use strict";
class jQ{
//---------------------Tarea 1--------------------------------

    constructor(){
        
    }

    mostrar(){
        $(document.getElementsByTagName('p')[0]).show();
    }
    
    
    ocultar(){
        $(document.getElementsByTagName('p')[0]).hide();
    } 

//----------------------Tarea 2---------------------

    modificar(){
        $(document.getElementsByTagName('p')[1]).text("Al dar a el boton \"Modificar\" se modifica el texto");
    }

    volver(){
        $(document.getElementsByTagName('p')[1]).text("Modificar algunos elementos HTML"); 
    }

  
  //----------------------Tarea 3---------------------

    añadir(){
        $(document.getElementsByTagName('p')[2]).append(" Añadir nuevos elementos HTML.");
    } 
 

   //----------------------Tarea 4---------------------
    eliminar(){
        if(document.getElementsByTagName('p')[2].textContent != "Tarea 3: Añadir nuevos elementos HTML"){
            $(document.getElementsByTagName('p')[2]).remove();
            $(document.getElementsByTagName('h2')[2]).after("<p>Tarea 3: Añadir nuevos elementos HTML</p>");
        }
    }

    //----------------------Tarea 5---------------------
    recorrer(){
       
            $("*", document.body).each(function(){
                var etiquetaPadre = $(this).parent().get(0).tagName;
                $(document.getElementsByTagName('pre')[0]).append(document.createTextNode( "Etiqueta padre : <"  + etiquetaPadre + "> elemento : <" + $(this).get(0).tagName +">\n"));
            });
            
        
    }


    //----------------------Tarea 6---------------------
    

    sumar(){
        var nColumnas =  new Number($(document.getElementsByTagName('th').length-4)[0]);
        
        var c = 1;
        var listaAux = [];
        var contenido = [];
        var fila = 0;

        var a = 0;
        var b = 0;
        var d = 0;
        var e = 0;
        var todo = 0;

        $("table td").each(function() { 
            listaAux.push(new Number($(this).text()));

            if((c%nColumnas) == 0){        
                console.log(listaAux);       
                contenido[fila] = listaAux
                listaAux = []
                fila++;
            }         
            
            c++;
               
        });      
        console.log(contenido);

        for(var i = 0; i < contenido[0].length; i++){
            a+=Number(contenido[0][i]);
            b+=Number(contenido[1][i]);

            d+=Number(contenido[i][0]);
            e+=Number(contenido[i][1]);

            todo+=Number(contenido[0][i]);
            todo+=Number(contenido[1][i]); 
        }

        $(document.getElementsByTagName('td')[2]).append(a);
        $(document.getElementsByTagName('td')[5]).append(b);
        $(document.getElementsByTagName('td')[6]).append(d);
        $(document.getElementsByTagName('td')[7]).append(e);
        $(document.getElementsByTagName('td')[8]).append(todo);
        
    }

    
}

let jq = new jQ();