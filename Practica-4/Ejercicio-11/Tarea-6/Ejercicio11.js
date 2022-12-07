class MapaDinamico{

  constructor(){
    this.lugares = [[43.354810,-5.851208],[43.524506,-5.625336],[43.242262251605815,-5.77662984961504],
    [43.357824376240686, -5.854500862213242],[43.3550096440145, -5.872064337611254],[43.368549028513584, -5.841389090344375]]
  }
   

  initMap(n){
    if(n != 6){
      var centro = {lat: 43.3672702, lng: -5.8502461};
      var escuela = {lat: this.lugares[n][0], lng: this.lugares[n][1]};
      var mapaOviedo = new google.maps.Map(document.getElementsByTagName('aside')[0],{zoom: 9,scaleControl: true,center:centro});
      
      var ubiEscuela = new google.maps.Marker({position:escuela,map:mapaOviedo});  
    }else{
      var centro = {lat: 43.3672702, lng: -5.8502461};      
      var mapaOviedo = new google.maps.Map(document.getElementsByTagName('aside')[0],{zoom: 9,scaleControl: true,center:centro});      
     
      for(var i = 0; i < this.lugares.length; i++){
        var escuela = {lat: this.lugares[i][0], lng: this.lugares[i][1]};
        var ubiEscuela = new google.maps.Marker({position:escuela,map:mapaOviedo});
      }
    }
 
}      

}

let mD = new MapaDinamico();
