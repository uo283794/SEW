
<?php
session_start();
class BaseDatos{

    protected $con;
    protected $servername;
    protected $username;
    protected $password;
    protected $message;
    protected $dbname;
    protected $printedRs;
    protected $allData;
    protected $informe;

    public function __construct(){  
        $this->servername = "localhost";
        $this->username = "DBUSER2022";
        $this->password = "DBPSWD2022"; 
        $this->dbname = "sew"; 
        $this->message = "";
        $this->printedRs = "";
        $this->informe = "";

    }

    public function crearDB(){
        try{
            $this->con = new mysqli($this->servername, $this->username, $this->password);
            if($this->con->connect_errno){
                $this->message =  "<p>Error en la conexion: " . $this->db->connect_error . "</p>";          
                
            }else{            
                $this->message = "<p>Conexion exitosa</p>";  
                $this->booleanQuerys("CREATE DATABASE IF NOT EXISTS sew;");         
            }
            $this->cerrarDB();
        }catch(Throwable $err){
            $this->message = "Error SQL: " . $err;
        }
    }

    public function crearTabla(){
        $this->conectarDB();
        try{
            $this->booleanQuerys("CREATE TABLE IF NOT EXISTS sew.pruebasusabilidad 
                (dni VARCHAR(255) NOT NULL,
                nombre VARCHAR(255) NOT NULL,
                apellido VARCHAR(255) NOT NULL, 
                email VARCHAR(255) NOT NULL, 
                telefono VARCHAR(255) NOT NULL, 
                edad INT NOT NULL, 
                sexo VARCHAR(255) NOT NULL, 
                experiencia INT NOT NULL,
                tiempo INT NOT NULL, 
                aprobado BOOLEAN NOT NULL, 
                comentario VARCHAR(255) NOT NULL,
                propuesta VARCHAR(255) NOT NULL, 
                puntuacion INT NOT NULL,
                CONSTRAINT CK_exp_pun CHECK (experiencia >= 0 AND experiencia <= 10 AND puntuacion >= 0 AND experiencia <= 10),
                CONSTRAINT PK_pruebasusabilidad PRIMARY KEY (dni));"); 
        }catch(Throwable $err){
            $this->message = "Error SQL: " . $err;
        }finally{
            $this->cerrarDB();
        }
    }


    public function insertar(){
        $this->conectarDB();

        if(is_numeric($_POST['inEd']) && is_numeric($_POST['inEx']) && is_numeric($_POST['inTi']) && is_numeric($_POST['inVa'])){
            try{
                $pre = $this->con->prepare("INSERT INTO sew.pruebasusabilidad 
                    (dni,nombre,apellido,email,telefono,edad,sexo,experiencia,tiempo,aprobado,comentario,propuesta,puntuacion) 
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);");
                    
                $pre->bind_param('sssssisiiissi',$_POST['inId'],$_POST['inNo'],$_POST['inAp'],$_POST['inEm'],$_POST['inTf'],$_POST['inEd'],$_POST['inSe'],
                $_POST['inEx'],$_POST['inTi'],$_POST['inExito'],$_POST['inCo'],$_POST['inPr'],$_POST['inVa']);

                $success = $pre->execute();

                if(!$success){
                    $this->message =  "Error al insertar";       
                    
                }else{            
                    $this->message = "Usuario insertado correctamente";           
                }

                $pre->close();
            }catch(Throwable $err){
                $this->message = "Error: " . $err;
            }finally{                               
                $this->cerrarDB();
            }            

                
        }else{
            $this->message = "Valor introducido no valido"; 
        }       


    }

    public function buscar(){
        $this->conectarDB();

        try{
            $pre = $this->con->prepare("SELECT * FROM sew.pruebasusabilidad WHERE dni = ?");
            $pre->bind_param('s',$_POST['bId']);
            $rs = $pre->execute();

            if($rs){                
                $this->printRs($pre->get_result());
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

    public function modificar(){
        $this->conectarDB();

        if(is_numeric($_POST['mEd']) && is_numeric($_POST['mEx']) && is_numeric($_POST['mTi']) && is_numeric($_POST['mVa'])){
            try{
                $pre = $this->con->prepare("UPDATE sew.pruebasusabilidad 
                    SET nombre = ? ,apellido = ? ,email = ? ,telefono = ? ,edad = ? ,sexo = ? ,experiencia = ? ,
                    tiempo = ? ,aprobado = ? ,comentario = ? ,propuesta = ? ,puntuacion = ? 
                    WHERE dni = ?;");
                    
                $pre->bind_param('ssssisiiissis',$_POST['mNo'],$_POST['mAp'],$_POST['mEm'],$_POST['mTf'],$_POST['mEd'],$_POST['mSe'],
                $_POST['mEx'],$_POST['mTi'],$_POST['mExito'],$_POST['mCo'],$_POST['mPr'],$_POST['mVa'],$_POST['mId']);

                $success = $pre->execute();

                if(!$success){
                    $this->message =  "Error al modificar";       
                    
                }else{            
                    $this->message = "Usuario modificado correctamente";           
                }
                $pre->close();
            }catch(Throwable $err){
                $this->message = "Error: " . $err;
            }finally{                
                $this->cerrarDB();
            }
        }else{
            $this->message = "Valor introducido no valido"; 
        }      

    }

    public function eliminar(){
        $this->conectarDB();
        
        try{
            $pre = $this->con->prepare("DELETE FROM sew.pruebasusabilidad WHERE dni = ?;");                    
            $pre->bind_param('s',$_POST['dId']);

            $success = $pre->execute();

            if(!$success){
                $this->message =  "Error al eliminar";       
                
            }else{            
                $this->message = "Usuario eliminado correctamente";           
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{
            
            $this->cerrarDB();
        }            

    }

    public function generarInforme(){  
        
        if($this-> getEM() == -1){
            $this->informe = "Error: posiblemente la base de datos este vacia";
        }else{
            $edadMedia = "<p>Edad media: " . $this-> getEM() . "</p>";
            $fH = "<p>Porcentaje de hombres: " . $this-> getFH() . "%</p>";
            $fM = "<p>Porcentaje de mujeres: " . 100-($this-> getFH()) . "%</p>";
            $nivelMedio = "<p>Nivel medio de pericia informatica: " . $this-> getNM() . "</p>";
            $tiempoMedio = "<p>Tiempo medio en realizar la prueba: " . $this-> getTM();
            $porCorrecto = "<p>Porcentaje de usuarios que han realizado la prueba correctamente: " . $this-> getPC() . "%</p>";
            $valoracionMedia ="<p>Valoracion media de la aplicacion: " . $this-> getVM() . "</p>";


            $this->informe = $edadMedia . $fH . $fM . $nivelMedio . $tiempoMedio . $porCorrecto . $valoracionMedia; 
        }
        

    }


    private function getAllData(){
        $this->conectarDB();

        try{
            $pre = $this->con->prepare("SELECT * FROM sew.pruebasusabilidad");            
            $pre->execute();
            $this->allData = $pre->get_result();
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{
            
            $this->cerrarDB();
        }    

    }

    private function getEM(){
        $this->getAllData();
        
        $edades = 0;
        $c = 0;
        while($row = $this->allData->fetch_array()){
            $edades += intval($row["edad"]);
            $c++;
        }    
        
        if($c == 0){
            return -1;
        }
        
        return $edades / $c;
    }

    private function getFH(){
        $this->getAllData();
        $hombres = 0;
        $c = 0;
        while($row = $this->allData->fetch_array()){
            if($row["sexo"] == "hombre"){
                $hombres++;
            }
            $c++;
        }    
        
        if($hombres == 0){
            return 0;
        }
        
        return ($hombres / $c) * 100;
    }

    private function getNM(){
        $this->getAllData();
        $nivel = 0;
        $c = 0;
        while($row = $this->allData->fetch_array()){
            $nivel += intval($row["experiencia"]);
            $c++;
        }        
        return $nivel / $c;
    }

    private function getTM(){
        $this->getAllData();
        $t = 0;
        $c = 0;
        while($row = $this->allData->fetch_array()){
            $t += intval($row["tiempo"]);
            $c++;
        }        
        return $t / $c;
    }

    private function getPC(){
        $this->getAllData();
        $pc = 0;
        $c = 0;
        while($row = $this->allData->fetch_array()){
            $pc += intval($row["aprobado"]);
            $c++;
        }        
        return ($pc / $c) * 100;
    }

    private function getVM(){
        $this->getAllData();
        $vm = 0;
        $c = 0;
        while($row = $this->allData->fetch_array()){
            $vm += intval($row["puntuacion"]);
            $c++;
        }        
        return $vm / $c;
    }


    public function importarDatos(){
        if(!empty($_FILES['csvF'])){
            $file = fopen($_FILES['csvF']['tmp_name'], 'r');
            while(($line = fgets($file))){
                $user = explode(',',$line);
                $this->insertarUser($user);
            }
            $this->message = "Archivo importado correctamente";
            fclose($file);

        }else{
            $this->message = "Fallo al importar el archivo";
        }       

    }

    private function insertarUser($user){
        $this->conectarDB();        
        try{
            $pre = $this->con->prepare("INSERT INTO sew.pruebasusabilidad 
                (dni,nombre,apellido,email,telefono,edad,sexo,experiencia,tiempo,aprobado,comentario,propuesta,puntuacion) 
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);");
                
            $pre->bind_param('sssssisiiissi',$user[0], $user[1], $user[2], $user[3], $user[4], $user[5], $user[6],
             $user[7], $user[8], $user[9], $user[10], $user[11], $user[12]);

            $success = $pre->execute();

            if(!$success){
                $this->message =  "Error al insertar";       
                
            }else{            
                $this->message = "Archivo importado correctamente";           
            }
            $pre->close();
        }catch(Throwable $err){
            $this->message = "Error: " . $err;
        }finally{           
            $this->cerrarDB();
        }                           
         

    }


    public function exportarDatos(){
        $this->getAllData();
        $txtEx = "";
        while($row = $this->allData->fetch_array()){
            $txtEx .= $row["dni"] . "," . $row["nombre"] . "," . $row["apellido"] . "," . $row["email"] . "," . $row["telefono"] . 
                "," . $row["edad"] . "," . $row["sexo"] . "," . $row["experiencia"] . "," . $row["tiempo"] . "  " . $row["aprobado"] . 
                "," . $row["comentario"] . "," . $row["propuesta"] . "," . $row["apellido"] . "," . $row["email"] . "," . $row["puntuacion"] . "\n";
            
        }   
        $file = fopen("pruebasUsabilidad.csv", 'w'); 
        fwrite($file, $txtEx);
        fclose($file);

        $this->message = "Datos exportados";  

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

    private function printRs($rs){  
        $this->printedRs = 'DNI inexistente';   
        while($row = $rs->fetch_array()){
                $this->printedRs = "DNI: ". $row["dni"] . "   Nombre: " . $row["nombre"] . "   Apellido: " . $row["apellido"] . 
                "   Email: " . $row["email"] . "   Telefono: " . $row["telefono"] . "   Edad: " . $row["edad"] . "   Sexo: " . $row["sexo"] . 
                "   Experiencia: " . $row["experiencia"] . "   Tiempo: " . $row["tiempo"] . "   Aprobado: " . $row["aprobado"] . 
                "   Comentario: " . $row["comentario"] . "   Propuesta: " . $row["propuesta"] . "   Puntuacion: " . $row["puntuacion"] . "\n";
        }     

    }

    public function getMessage(){
        return $this->message;
    }

    public function getPrintedRs(){
        return $this->printedRs;
    }

    public function getInforme(){
        return $this->informe;
    }

}

?>


<!DOCTYPE HTML>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Ejercicio6</title>
    <!--Metadatos de los documentos HTML5-->
    <meta name ="author" content ="Daniel Alberto Alonso Fernandez" />
    <meta name ="description" content ="Formulario en php con mysql" />
    <meta name ="keywords" content ="mysql, php, form" />

    <!--Definición de la ventana gráfica-->
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />    
    <link rel="stylesheet" type="text/css" href="Ejercicio6.css"/>
   
</head>

<body>

    <?php
    
        if(!isset($_SESSION['db'])) {
            $_SESSION['db'] = new BaseDatos();
        }
        
        $db = $_SESSION['db'];

        if (count($_POST)>0) {           

            if(isset($_POST['creardb'])) $db->crearDB();
            else if(isset($_POST['crearTabla'])) $db->crearTabla();
            else if(isset($_POST['add'])) $db->insertar();
            else if(isset($_POST['buscar'])) $db->buscar();
            else if(isset($_POST['modificar'])) $db->modificar();
            else if(isset($_POST['eliminar'])) $db->eliminar();
            else if(isset($_POST['informe'])) $db->generarInforme();
            else if(isset($_POST['importar'])) $db->importarDatos();
            else if(isset($_POST['exportar'])) $db->exportarDatos();
           
                    
        }
    
    ?>

    <nav>
        <a tabindex="1" accesskey="q" href="Ejercicio6.php#crearB">Crear Base de Datos</a>
        <a tabindex="2" accesskey="w" href="Ejercicio6.php#crearT">Crear una tabla</a>
        <a tabindex="3" accesskey="e" href="Ejercicio6.php#insertarD">Insertar datos</a>           
        <a tabindex="4" accesskey="r" href="Ejercicio6.php#buscarD">Buscar datos</a>
        <a tabindex="5" accesskey="t" href="Ejercicio6.php#modificarD">Modificar datos</a>  
        <a tabindex="6" accesskey="y" href="Ejercicio6.php#eliminarD">Eliminar datos</a>
        <a tabindex="7" accesskey="u" href="Ejercicio6.php#informeD">Generar informe</a>
        <a tabindex="8" accesskey="i" href="Ejercicio6.php#importarD">Importar CSV</a>           
        <a tabindex="9" accesskey="o" href="Ejercicio6.php#exportarD">Exportar CSV</a>
                     
    </nav>


    <form action='#' method='post' enctype = "multipart/form-data"> 
        <fieldset>
            <fieldset id= "crearB">
                <legend> Crear Base de Datos </legend>                   
                <input type="submit" name ="creardb" value="Crear Base de Datos" />
            </fieldset>

            <fieldset id = "crearT">
                <legend> Crear una tabla </legend>                   
                <input type="submit" name ="crearTabla" value="Crear una tabla" />
            </fieldset>

            <fieldset id = "insertarD">
                <legend> Insertar datos en la tabla</legend>                   
                <label for="dni">DNI</label>
                <input type="text" name = "inId" id = "dni" />

                <label for="nombre">Nombre</label>
                <input type="text" name = "inNo" id = "nombre" />

                <label for="apellido">Apellido</label>
                <input type="text" name = "inAp" id = "apellido" />

                <label for="email">E-mail</label>
                <input type="text" name = "inEm" id = "email" />

                <label for="tf">Telefono</label>
                <input type="text" name = "inTf" id = "tf" />

                <label for="edad">Edad</label>
                <input type="text" name = "inEd" id = "edad" />

                <fieldset>
                    <legend> Sexo </legend>
                    <p><input type=radio name="inSe" value = "hombre" id = "h"/><label for="h">Hombre</label></p>
                    <p><input type=radio name="inSe" value = "mujer" id = "m"/><label for="m">Mujer</label></p>
                </fieldset>

                <label for="exp">Experiencia informatica (0-10)</label>
                <input type="text" name = "inEx" id = "exp" />

                <label for="tmp">Tiempo de la resolucion de la prueba</label>
                <input type="text" name = "inTi" id = "tmp" />

                <fieldset>
                    <legend> Resolución de la prueba de forma correcta </legend>
                    <p><input type=radio name="inExito" value = "1" id = "si"/><label for="si">Si</label></p>
                    <p><input type=radio name="inExito" value = "0" id = "no"/><label for="no">No</label></p>                   
                </fieldset>

                <label for="com">Comentario sobre los problemas</label>
                <input type="text" name = "inCo" id = "com" />

                <label for="pro">Propuestas de mejora</label>
                <input type="text" name = "inPr" id = "pro" />

                <label for="val">Valoracion de la aplicacion (0-10)</label>
                <input type="text" name = "inVa" id = "val" />

                <input type="submit" name ="add" value="Insertar datos" />
            </fieldset>


            <fieldset id = "buscarD">
                <legend> Buscar Datos </legend>                                 
                <label for="idb">Introduzca el dni: </label>
                <input type="text" name = "bId" id = "idb" />
                <input type="submit" name ="buscar" value="Buscar datos" />
                <p><?php echo $db->getPrintedRs(); ?></p>
            </fieldset>


            <fieldset id = "modificarD">
                <legend> Modificar Datos </legend>                                 
                <label for="idm">Introduzca el dni del usuario a modificar: </label>
                <input type="text" name = "mId" id = "idm" />

                <label for="nombrem">Nombre</label>
                <input type="text" name = "mNo" id = "nombrem" />

                <label for="apellidom">Apellido</label>
                <input type="text" name = "mAp" id = "apellidom" />

                <label for="emailm">E-mail</label>
                <input type="text" name = "mEm" id = "emailm" />

                <label for="tfm">Telefono</label>
                <input type="text" name = "mTf" id = "tfm" />

                <label for="edadm">Edad</label>
                <input type="text" name = "mEd" id = "edadm" />

                <fieldset>
                    <legend> Sexo </legend>
                    <p><input type=radio name="mSe" value = "hombre" id = "hm"/><label for="hm">Hombre</label></p>
                    <p><input type=radio name="mSe" value = "mujer" id = "mm"/><label for="mm">Mujer</label></p>
                </fieldset>

                <label for="expm">Experiencia informatica (0-10)</label>
                <input type="text" name = "mEx" id = "expm" />

                <label for="tmpm">Tiempo de la resolucion de la prueba</label>
                <input type="text" name = "mTi" id = "tmpm" />

                <fieldset>
                    <legend> Resolución de la prueba de forma correcta </legend>
                    <p><input type=radio name="mExito" value = "1" id = "sim"/><label for="sim">Si</label></p>
                    <p><input type=radio name="mExito" value = "0" id = "nom"/><label for="nom">No</label></p>                
                </fieldset>   

                <label for="comm">Comentario sobre los problemas</label>
                <input type="text" name = "mCo" id = "comm" />

                <label for="prom">Propuestas de mejora</label>
                <input type="text" name = "mPr" id = "prom" />

                <label for="valm">Valoracion de la aplicacion (0-10)</label>
                <input type="text" name = "mVa" id = "valm" />

                <input type="submit" name ="modificar" value="Modificar usuario" />
                    
            </fieldset>


            <fieldset id = "eliminarD">
                <legend> Eliminar Usuario </legend>                                 
                <label for="idd">Introduzca el dni del usuario a eliminar: </label>
                <input type="text" name = "dId" id = "idd" />
                <input type="submit" name ="eliminar" value="Eliminar usuario" />
            </fieldset>

            <fieldset id = "informeD">
                <legend> Informe de los datos </legend>                                 
                <input type="submit" name ="informe" value="Generar informe" />
                <section>
                    <h2>Informe:</h2>
                    <?php echo $db->getInforme();?>
                </section>
            </fieldset>

            <fieldset id = "importarD">
                <legend>Importar documento</legend>    
                <label for = "fi">Importe un documento .csv</label>                             
                <input type = "file" name = "csvF" id = "fi"/>
                <input type="submit" name ="importar" value="Importar archivo" />
            </fieldset>

            <fieldset id = "exportarD">
                <legend>Exportar datos en .csv</legend>          
                <input type="submit" name ="exportar" value="Exportar datos" />
            </fieldset>



            <fieldset>
                <legend> Log </legend>                                 
                <p><?php echo $db->getMessage(); ?></p>
            </fieldset>

        </fieldset>
        
    </form>
    
</body>
</html>