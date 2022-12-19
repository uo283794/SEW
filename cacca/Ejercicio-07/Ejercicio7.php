<?php

session_start();
class BaseDatos{

    protected $con;
    protected $servername;
    protected $username;
    protected $password;
    protected $message;
    protected $dbname;   
    protected $veh;
    protected $in;

    public function __construct(){  
        $this->servername = "localhost";
        $this->username = "DBUSER2022";
        $this->password = "DBPSWD2022"; 
        $this->dbname = "sew7"; 
        $this->message = "";
        $this->in = "";
        $this->veh = "";
        

    }



    public function crearDB(){
        try{
            $this->con = new mysqli($this->servername, $this->username, $this->password);
            if($this->con->connect_errno){
                $this->message =  "<p>Error en la conexion: " . $this->db->connect_error . "</p>";          
                
            }else{            
                $this->message = "<p>Conexion exitosa</p>";  
                $this->booleanQuerys("CREATE DATABASE IF NOT EXISTS sew7;");         
            }
            $this->cerrarDB();
        }catch(Throwable $err){
            $this->message = "Error SQL: " . $err;
        }
    }

    public function crearTabla(){
        
        try{
            $this->conectarDB();
            $this->booleanQuerys("CREATE TABLE IF NOT EXISTS sew7.duenio 
                (dni VARCHAR(255) NOT NULL,
                nombre VARCHAR(255) NOT NULL,                     
                CONSTRAINT PK_duenio PRIMARY KEY (dni));"); 
                
            $this->booleanQuerys("CREATE TABLE IF NOT EXISTS sew7.casa
                (id_c VARCHAR(255) NOT NULL,
                tipo VARCHAR(255) NOT NULL,
                dni VARCHAR(255) NOT NULL,                     
                CONSTRAINT PK_casa PRIMARY KEY (id_c),
                CONSTRAINT FK_casa FOREIGN KEY (dni) REFERENCES sew7.duenio(dni));");
            
            $this->booleanQuerys("CREATE TABLE IF NOT EXISTS sew7.garage
                (id_g VARCHAR(255) NOT NULL,
                calle VARCHAR(255) NOT NULL,
                dni VARCHAR(255) NOT NULL,                     
                CONSTRAINT PK_garage PRIMARY KEY (id_g),
                CONSTRAINT FK_garage FOREIGN KEY (dni) REFERENCES sew7.duenio(dni));");
            
            $this->booleanQuerys("CREATE TABLE IF NOT EXISTS sew7.moto
                (id_m VARCHAR(255) NOT NULL,
                marca VARCHAR(255) NOT NULL,
                id_g VARCHAR(255) NOT NULL,                     
                CONSTRAINT PK_moto PRIMARY KEY (id_m),
                CONSTRAINT FK_moto FOREIGN KEY (id_g) REFERENCES sew7.garage(id_g));");
            
            $this->booleanQuerys("CREATE TABLE IF NOT EXISTS sew7.coche
                (id_co VARCHAR(255) NOT NULL,
                modelo VARCHAR(255) NOT NULL,
                id_g VARCHAR(255) NOT NULL,                     
                CONSTRAINT PK_coche PRIMARY KEY (id_co),
                CONSTRAINT FK_coche FOREIGN KEY (id_g) REFERENCES sew7.garage(id_g));"); 
            
        }catch(Throwable $err){
            $this->message = "Error SQL: " . $err;
        }finally{
            $this->cerrarDB();
        }
    }


    public function addCoche(){

    }

    public function addMoto(){
        
    }

    public function addGarage(){
        
    }

    public function addCasa(){
        
    }

    public function addDuenio(){
        
    }


    public function cargarDatos(){
        $this->insertarDuenio();
        $this->insertarCasa();
        $this->insertarGarage();
        $this->insertarCoche();
        $this->insertarMoto();
    }

   

    private function insertarDuenio(){
        $this->conectarDB();        
        try{
            $this->booleanQuerys("INSERT INTO sew7.duenio (dni,nombre) VALUES('1','Juan');"); 
            $this->booleanQuerys("INSERT INTO sew7.duenio (dni,nombre) VALUES('2','Pedro');"); 
            $this->booleanQuerys("INSERT INTO sew7.duenio (dni,nombre) VALUES('3','Ana');");     
            
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{           
            $this->cerrarDB();
        }                           
    }

    private function insertarCasa(){
        $this->conectarDB();        
        try{
            $this->booleanQuerys("INSERT INTO sew7.casa (id_c,tipo,dni) VALUES('1','piso','1');"); 
            $this->booleanQuerys("INSERT INTO sew7.casa (id_c,tipo,dni) VALUES('2','piso','2');"); 
            $this->booleanQuerys("INSERT INTO sew7.casa (id_c,tipo,dni) VALUES('3','piso','3');"); 
            
            $this->booleanQuerys("INSERT INTO sew7.casa (id_c,tipo,dni) VALUES('4','adosado','2');"); 
            $this->booleanQuerys("INSERT INTO sew7.casa (id_c,tipo,dni) VALUES('5','chalet','3');"); 
            
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{           
            $this->cerrarDB();
        }                 
    }

    private function insertarGarage(){
        $this->conectarDB();        
        try{
            $this->booleanQuerys("INSERT INTO sew7.garage (id_g,calle,dni) VALUES('1','uria','1');"); 
            $this->booleanQuerys("INSERT INTO sew7.garage (id_g,calle,dni) VALUES('2','leon','1');"); 
            $this->booleanQuerys("INSERT INTO sew7.garage (id_g,calle,dni) VALUES('3','constitucion','2');"); 
                      
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{           
            $this->cerrarDB();
        }                 
                  
    }

    private function insertarCoche(){
        $this->conectarDB();        
        try{
            $this->booleanQuerys("INSERT INTO sew7.coche (id_co,modelo,id_g) VALUES('1','ibiza','1');"); 
            $this->booleanQuerys("INSERT INTO sew7.coche (id_co,modelo,id_g) VALUES('2','i8','2');"); 
            $this->booleanQuerys("INSERT INTO sew7.coche (id_co,modelo,id_g) VALUES('3','discovery','2');"); 
                      
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{           
            $this->cerrarDB();
        }          
          
    }

    private function insertarMoto(){
        $this->conectarDB();        
        try{
            $this->booleanQuerys("INSERT INTO sew7.moto (id_m,marca,id_g) VALUES('1','honda','1');"); 
            $this->booleanQuerys("INSERT INTO sew7.moto (id_m,marca,id_g) VALUES('2','yamaha','3');"); 
            $this->booleanQuerys("INSERT INTO sew7.moto (id_m,marca,id_g) VALUES('3','kawasaki','3');"); 
                      
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{           
            $this->cerrarDB();
        } 
       
    }


    public function prepareDuenio(){
        $this->conectarDB();
        
        try{
            $pre = $this->con->prepare("INSERT INTO sew7.duenio (dni,nombre) VALUES(?,?);");                
            $pre->bind_param('ss',$_POST['dId'],$_POST['nId']);
            $success = $pre->execute();

            if(!$success){
                $this->message =  "Error al insertar";       
                
            }else{            
                $this->message = "Titular insertada correctamente";           
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{                
            $this->cerrarDB();
        }        

    }

    public function prepareCasa(){
        $this->conectarDB();
        
        try{
            $pre = $this->con->prepare("INSERT INTO sew7.casa (id_c,tipo,dni) VALUES(?,?,?);");                
            $pre->bind_param('sss',$_POST['cId'],$_POST['tcId'],$_POST['dcId']);
            $success = $pre->execute();

            if(!$success){
                $this->message =  "Error al insertar";       
                
            }else{            
                $this->message = "Moto insertada correctamente";           
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{                
            $this->cerrarDB();
        }        

    }


    public function prepareGarage(){
        $this->conectarDB();
        
        try{
            $pre = $this->con->prepare("INSERT INTO sew7.garage (id_g,calle,dni) VALUES(?,?,?);");                
            $pre->bind_param('sss',$_POST['gId'],$_POST['cgId'],$_POST['dgId']);
            $success = $pre->execute();

            if(!$success){
                $this->message =  "Error al insertar";       
                
            }else{            
                $this->message = "Garage insertado correctamente";           
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{                
            $this->cerrarDB();
        }        

    }


    public function prepareMoto(){
        $this->conectarDB();
        
        try{
            $pre = $this->con->prepare("INSERT INTO sew7.moto (id_m,marca,id_g) VALUES(?,?,?);");                
            $pre->bind_param('sss',$_POST['mId'],$_POST['mamId'],$_POST['dmId']);
            $success = $pre->execute();

            if(!$success){
                $this->message =  "Error al insertar";       
                
            }else{            
                $this->message = "Moto insertada correctamente";           
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{                
            $this->cerrarDB();
        }        

    }

    public function prepareCoche(){
        $this->conectarDB();        
        try{
            $pre = $this->con->prepare("INSERT INTO sew7.coche (id_co,modelo,id_g) VALUES(?,?,?);");                
            $pre->bind_param('sss',$_POST['coId'],$_POST['mcoId'],$_POST['dcoId']);
            $success = $pre->execute();

            if(!$success){
                $this->message =  "Error al insertar";       
                
            }else{            
                $this->message = "Coche insertado correctamente";           
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{                
            $this->cerrarDB();
        }        

    }


    public function buscarIG(){
        $this->buscarI();
        $this->buscarG();
    }

    public function buscarI(){
        $this->conectarDB();

        try{
            $pre = $this->con->prepare("SELECT * FROM sew7.casa WHERE dni = ? ");
            $pre->bind_param('s',$_POST['giId']);
            $rs = $pre->execute();           

            if($rs){                
                $this->printI($pre->get_result());
                $this->message = "Consulta realizada de forma exitosa";
            }else{
                $this->message = "Error al realizar la consulta";
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{            
            $this->cerrarDB();
        }    

    }

    public function buscarG(){
        $this->conectarDB();

        try{
            $pre = $this->con->prepare("SELECT * FROM sew7.garage WHERE dni = ? ");
            $pre->bind_param('s',$_POST['giId']);
            $rs = $pre->execute();           

            if($rs){                
                $this->printG($pre->get_result());
                $this->message = "Consulta realizada de forma exitosa";
            }else{
                $this->message = "Error al realizar la consulta";
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{            
            $this->cerrarDB();
        }    

    }


    private function printI($rs){  
        $this->in = "";
        while($row = $rs->fetch_array()){
                $this->in .= "<p>Id casa: ". $row["id_c"] . "     Tipo: " . $row["tipo"] . "</p>\n";                
        }        

    }

    private function printG($rs){                
        while($row = $rs->fetch_array()){
            $this->in .= "<p>Id garage: ". $row["id_g"] . "     Calle: " . $row["calle"] . "</p>\n";                
        }  

    }



    public function buscarCM(){
        $this->buscarC();
        $this->buscarM();
    }

    public function buscarC(){
        $this->conectarDB();

        try{
            $pre = $this->con->prepare("SELECT * FROM sew7.coche NATURAL JOIN sew7.garage WHERE sew7.garage.dni = ?");
            $pre->bind_param('s',$_POST['gvId']);
            $rs = $pre->execute();           

            if($rs){                
                $this->printC($pre->get_result());
                $this->message = "Consulta realizada de forma exitosa";
            }else{
                $this->message = "Error al realizar la consulta";
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{            
            $this->cerrarDB();
        }    

    }

    public function buscarM(){
        $this->conectarDB();

        try{
            $pre = $this->con->prepare("SELECT * FROM sew7.moto NATURAL JOIN sew7.garage WHERE sew7.garage.dni = ?");
            $pre->bind_param('s',$_POST['gvId']);
            $rs = $pre->execute();           

            if($rs){                
                $this->printM($pre->get_result());
                $this->message = "Consulta realizada de forma exitosa";
            }else{
                $this->message = "Error al realizar la consulta";
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{            
            $this->cerrarDB();
        }    

    }


    private function printC($rs){  
        $this->veh = "";
        while($row = $rs->fetch_array()){
                $this->veh .= "<p>Id coche: ". $row["id_co"] . "     Modelo: " . $row["modelo"] . "</p>\n";                
        }        

    }

    private function printM($rs){                
        while($row = $rs->fetch_array()){
            $this->veh .= "<p>Id moto: ". $row["id_m"] . "     Marca: " . $row["marca"] . "</p>\n";                
        }  

    }


    private function conectarDB(){
        try{
        $this->con = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if($this->con->connect_errno){
            $this->message =  "Error en la conexion: " . $this->db->connect_error;          
            
        }else{            
            $this->message = "Conexion exitosa";           
        }
        }catch(Throwable $err){
            $this->message = "Error en la conexion: " . $err; 
        }

    }

    private function cerrarDB(){
        try{
            $this->con->close(); 
        }catch(Throwable $err){
            $this->message = "Error en la conexion: " . $err; 
        }
    }

    private function booleanQuerys($query){
        try{
            $res = $this->con->query($query);
            if($query){
                $this->message = "Sentencia ejecutada correctamente";
            }else{
                $this->message = "Error al ejecutar:" . $query;
            }
        }catch(Throwable $err){
            $this->message = "Error en la conexion: " . $err;
        }
    }

    public function getMessage(){
        return $this->message;
    }

    public function getInm(){
        return $this->in;
    }

    public function getVeh(){
        return $this->veh;
    }

}


?>




<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Ejercicio7</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Daniel Alberto Alonso Fernandez" />
    <meta name ="description" content ="Formulario en php con mysql" />
    <meta name ="keywords" content ="mysql, php, form" />

    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />    
    <link rel="stylesheet" type="text/css" href="Ejercicio7.css"/>
   
</head>

<body>

    <?php
    
        if(!isset($_SESSION['db2'])) {
            $_SESSION['db2'] = new BaseDatos();
        }
        
        $db = $_SESSION['db2'];

        if (count($_POST)>0) {           

            if(isset($_POST['creardb'])) $db->crearDB();
            else if(isset($_POST['crearTabla'])) $db->crearTabla();
            else if(isset($_POST['cargar'])) $db->cargarDatos();
            else if(isset($_POST['addMo'])) $db->prepareMoto();
            else if(isset($_POST['addCo'])) $db->prepareCoche();
            else if(isset($_POST['addD'])) $db->prepareDuenio();
            else if(isset($_POST['addG'])) $db->prepareGarage();
            else if(isset($_POST['addC'])) $db->prepareCasa();
            else if(isset($_POST['buscarIn'])) $db->buscarIG();
            else if(isset($_POST['buscarVe'])) $db->buscarCM();
            
           
                    
        }
    
    ?>

    <nav>
        <a tabindex="1" accesskey="q" href="Ejercicio7.php#crearB">Crear Base de Datos</a>
        <a tabindex="2" accesskey="w" href="Ejercicio7.php#crearT">Crear tablas</a>
        <a tabindex="3" accesskey="e" href="Ejercicio7.php#cargarD">Cargar Datos</a>
        <a tabindex="4" accesskey="r" href="Ejercicio7.php#addD">Add Titular</a>
        <a tabindex="5" accesskey="t" href="Ejercicio7.php#addC">Add Casa</a>
        <a tabindex="6" accesskey="y" href="Ejercicio7.php#addG">Add Garage</a>
        <a tabindex="7" accesskey="u" href="Ejercicio7.php#addCo">Add Coche</a>
        <a tabindex="8" accesskey="i" href="Ejercicio7.php#addM">Add Moto</a>
        <a tabindex="9" accesskey="o" href="Ejercicio7.php#buscarI">Ver Inmuebles</a>
        <a tabindex="10" accesskey="p" href="Ejercicio7.php#buscarV">Ver Vehiculos</a>
        
                     
    </nav>


    <form action='#' method='post' enctype = "multipart/form-data"> 
        <fieldset>
            <fieldset id= "crearB">
                <legend> Crear Base de Datos </legend>                   
                <input type="submit" name ="creardb" value="Crear Base de Datos" />
            </fieldset>

            <fieldset id = "crearT">
                <legend> Crear Tablas </legend>                   
                <input type="submit" name ="crearTabla" value="Crear tablas" />
            </fieldset>   

            <fieldset id = "cargarD">
                <legend>Cargar datos</legend>    
                <input type="submit" name ="cargar" value="Cargar datos de prueba" />
            </fieldset>


            <fieldset id = "addD">
                <legend> Add Titular </legend>                                 
                <label for="idd">DNI del nuevo titular: </label>
                <input type="text" name = "dId" id = "idd" />

                <label for="nd">Nombre del nuevo titular:</label>
                <input type="text" name = "nId" id = "nd" />                  
                
                <input type="submit" name ="addD" value="Nuevo Titular" />                      
            </fieldset>

            <fieldset>
                <legend> Propiedades </legend> 
                <fieldset id = "addC">
                    <legend> Add Casa </legend>                                 
                    <label for="iddc">Introduzca el dni del propietario: </label>
                    <input type="text" name = "dcId" id = "iddc" />

                    <label for="idc">Id del inmueble:</label>
                    <input type="text" name = "cId" id = "idc" />   
                    
                    <label for="idtc">Tipo de inmueble:</label>
                    <input type="text" name = "tcId" id = "idtc" /> 
                    <input type="submit" name ="addC" value="Nuevo Inmueble" />                      
                </fieldset>

                <fieldset id = "addG">
                    <legend> Add Garage </legend>                                 
                    <label for="iddg">Introduzca el dni del propietario: </label>
                    <input type="text" name = "dgId" id = "iddg" />

                    <label for="idg">Id del garage:</label>
                    <input type="text" name = "gId" id = "idg" />   
                    
                    <label for="idcg">Calle del garage:</label>
                    <input type="text" name = "cgId" id = "idcg" /> 
                    <input type="submit" name ="addG" value="Nuevo Garage" />  
                        
                </fieldset>
            </fieldset>


            <fieldset>
                <legend> Vehiculos </legend> 
                <fieldset id = "addCo">
                    <legend> Add Coche </legend>                                 
                    <label for="iddco">Introduzca el codigo del garage: </label>
                    <input type="text" name = "dcoId" id = "iddco" />

                    <label for="idco">Id del coche:</label>
                    <input type="text" name = "coId" id = "idco" />   
                    
                    <label for="idmco">Modelo:</label>
                    <input type="text" name = "mcoId" id = "idmco" /> 
                    <input type="submit" name ="addCo" value="Nuevo Coche" />                      
                </fieldset>

                <fieldset id = "addM">
                    <legend> Add Moto </legend>                                 
                    <label for="iddm">Introduzca el codigo del garage: </label>
                    <input type="text" name = "dmId" id = "iddm" />

                    <label for="idm">Id de la moto:</label>
                    <input type="text" name = "mId" id = "idm" />   
                    
                    <label for="idmam">Marca:</label>
                    <input type="text" name = "mamId" id = "idmam" /> 
                    <input type="submit" name ="addMo" value="Nueva Moto" />  
                        
                </fieldset>
            </fieldset>


            <fieldset id = "buscarI">
                <legend> Inmuebles </legend>                                 
                <label for="idgi">Introduzca el dni del propietario: </label>
                <input type="text" name = "giId" id = "idgi" />
                <input type="submit" name ="buscarIn" value="Buscar Inmuebles" />
                <section>
                    <h2>Inmuebles:</h2>
                    <?php echo $db->getInm(); ?>
                </section>
            </fieldset>

            <fieldset id = "buscarV">
                <legend> Vehiculos </legend>                                 
                <label for="idgv">Introduzca el dni del propietario: </label>
                <input type="text" name = "gvId" id = "idgv" />
                <input type="submit" name ="buscarVe" value="Buscar Vehiculos" />
                <section>
                    <h2>Vehiculos:</h2>
                    <?php echo $db->getVeh(); ?>
                </section>
            </fieldset>           

        </fieldset>


        <fieldset>
            <legend> Log </legend>                                 
            <p><?php echo $db->getMessage(); ?></p>
        </fieldset>
        
    </form>
    
</body>
</html>