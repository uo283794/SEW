class Dibujar{

    constructor(){
        this.puntos;
        this.puntosParseados = [];
        this.coordenadas = [];
        
        this.archivo;
        this.canvas = document.getElementsByTagName('canvas')[0];
        this.canvas1 = this.canvas.getContext('2d');
        
    }

    cargar() {
        var nBytes = 0;

        this.archivo = document.getElementsByTagName("input")[0].files[0];                           
            
            
        var lector = new FileReader();
        lector.onload = function (evento) {
        
            d.puntos = lector.result.trim();
           // console.log(d.puntos);
        }

        lector.readAsText(this.archivo);
    }


    parsear(){
        this.puntos = this.puntos.split("\n");
        for(var i = 0; i < this.puntos.length; i++){
            this.puntosParseados.push(this.puntos[i].trim().split("-"));
            this.coordenadas.push(this.puntosParseados[i][1].split(","));
        }

        
        console.log(this.coordenadas);
    }

    renderizar(){
        if(this.coordenadas.length == 0){
            this.parsear();
        }
        
        this.canvas1.beginPath();
        this.canvas1.strokeStyle = "rgba(255, 0, 0, 1.0)";
        this.canvas1.moveTo(this.coordenadas[0][0],this.coordenadas[0][1]);
        for(var i = 0; i < this.coordenadas.length; i++){           
            this.canvas1.lineTo(Number(this.coordenadas[i][0]),Number(this.coordenadas[i][1]));                        
        }

        this.canvas1.closePath();
        this.canvas1.stroke();     

    }


           

}

let d = new Dibujar();
document.addEventListener("dragover", (e) =>  {
    e.preventDefault();
});

document.getElementsByTagName('canvas')[0].addEventListener("drop", (e) =>  {
    e.preventDefault();
    document.getElementsByTagName("input")[0].files = e.dataTransfer.files;
    d.cargar();
});