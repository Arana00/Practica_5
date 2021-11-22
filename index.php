<?php

//Función para extraer ciudades de una lista
$provincias = [];
$string = file_get_contents('cpProvincias.csv');
$provincias_cod = explode("\n",$string);
foreach($provincias_cod as $fila){
    $separar = explode(";",$fila);
    $provincias[] = [
        'codigo' => $separar[0],
        'provincia' => $separar[1]
    ];
}

//Función 1 para que salga un mensaje en caso de que se introduzcan números en vez de letras en los campos de nombre,
//apellido y ciudad. Con expresión regular.
function letras($string)
{
    $regex = "/^[A-Za-zÑñ]+$/"; //No puede tener ningún número el ^ y +$ son para obligarle a que todo sean letras
    //que no haya ninguna letra.
    //La función preg_match devuelve uno cuando encuentra un número en la expresión
    if (preg_match($regex, $string) != 1) {
        $mensaje = "No todos tus caracteres son letras";
    }
    if($string != "") {
        return $mensaje;
    }
}

//Escribe una función que devuelva un mensaje en caso de que el usuario escriba letras en el campo de entrada de
// teléfono o en el de código postal.
function numeros($string,$num,$nProv){
    $regex = "/^[0-9]{".$num."}+$/"; //No puede tener letras, el ^ y +$ son para obligarle a que todo sean números
    //La función preg_match devuelve uno cuando comprueba que toda la expresion son numeros
    //La función strlen nos devuelve la longitus del string que la igualamos a la cantidad que necesitamos
    if (preg_match($regex, $string) != 1) {
        $mensaje = "No todos tus caracteres son números o la cantidad de caracteres es diferente a " . $num;
    }
    if ($nProv != substr($string, 0,2) && $num == 5){
        $mensProv= "la provincia no coincide con el CP";
    }
    if($string != "") {
        return $mensaje . $mensProv;
    }
}

//funcion para el correo electronico
function email($string){

    $regex = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}+$/"; //Estructura email: letras, numeros, ciertos
    // caracteres especiales + @ + letras, punto o guion + punto + mas letras de como minimo 2 de longitus y maximo 6.
    //La función preg_match devuelve uno cuando encuentra un número en la expresión
    if (preg_match($regex, $string) != 1) {
        $mensaje = "No has introducido una direccion de email correcta";
    }
    if($string != "") {
        return $mensaje;
    }
}

//Función para comprobar los carácteres de la contraseña
function contrasenia($string)
{
    $regex = "/((?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^A-Za-z0-9])).{8,16}/"; //Estructura, que pueda contener en
    //cualquier parte al menos una vez, una letras mayuscula, la siguiente lo mismo pero miniscula, la siguiente lo mismo
    // pero con numeros, la siguiente que no tenga ni minusculas ni mayusculas ni numeros y la ultima que sea de minimo 8 y de maximo 16.
    //If que compara la contraseña insertada con mi expresión regular, si esta no cumple
    //los patrones me devuelve un mensaje de que es incorrecta.
    if (preg_match($regex, $string) != 1) {
        $mensaje = "La contraseña no cumple las normas, inserte una nueva";
    }
    if($string != "") {
        return $mensaje;
    }
}
//Función para comprobar una dirección web
function web($string)
{
    $regex = "/^http[s]?:\/\/[\w]+([\.]+[\w]+)+$/"; //EStructura. tiene que empezar obligatoriamente por http p https://,
    //seguido de cualquier caracter alfanumérico, seguido de un punto, seguido de cualquier caracter alfanumérico y que obligatoriamente acabe así
    //If que compara la web insertada con mi expresión regular, si esta no cumple
    //los patrones me devuelve un mensaje de que es incorrecta.
    if (preg_match($regex, $string) != 1) {
        $mensaje = "La web no cumple las normas, inserte una nueva";
    }
    if($string != "") {
        return $mensaje;
    }
}

//Comprobación de envío de formulario
//con el if compruebo que he enviado el formulario
if(isset($_POST['guardar'])) {
    //recojo los valores
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $postal = filter_input(INPUT_POST, 'postal', FILTER_SANITIZE_STRING);
    $ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING);
    $domicilio = filter_input(INPUT_POST, 'domicilio', FILTER_SANITIZE_STRING);
    $contrasena = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_STRING);
    $web = filter_input(INPUT_POST, 'web', FILTER_SANITIZE_STRING);
    $provSelect= filter_input(INPUT_POST, 'select', FILTER_SANITIZE_STRING);

    //<--------------------ERROR DE CÓDIGO------------->
    //Guardar los datos recogidos en un archivo csv
    //creo mi array de campos
    /*$datos = [$nombre, $apellido, $email, $telefono, $postal, $ciudad, $domicilio, $contrasena, $web, $provSelect];
    //selecciono la ruta donde quiero que se me guarde y el nombre del fichero
    $ruta = 'registros.csv';
    //Función para guardar los datos del formulario en un archivo csv
    function generarCSV($datos, $ruta, $delimitador){
        $archivo = fopen($ruta, 'w');//abro mi archivo en la ruta que quería, la w le da las propiedades de apertura
        // para solo escritura
        foreach ($datos as $linea) {
            fputcsv($archivo, $linea, $delimitador);//da formato a la linea de mis datos
        }
        rewind($archivo);//vuelve el puntero del archivo al principio
        fclose($archivo);//cierra el archivo
    }
    generarCSV($datos, $ruta, $delimitador = ';');*/

    //<--------------------ERROR DE CÓDIGO------------->


}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<form action="index.php" method="post">
    <fieldset>
        <legend>Datos Personales</legend>
        <label for="nombre">Nombre:</label> <input name="nombre" id="nombre" type="text" placeholder="Jose">
        <?php echo letras($nombre); ?>
        <label for="apellido">Apellidos:</label> <input name="apellido" id="apellido" type="text" placeholder="García Pérez"><br/>
        <?php echo letras($apellido); ?>
        <label for="domicilio">Dirección:</label> <input name="domicilio" id="domicilio" type="text" placeholder="C. Alustante, 13"><br/>

        <label for="ciudad">Ciudad:</label> <input name="ciudad" id="ciudad" type="text" placeholder="Madrid"><br/>
        <?php echo letras($ciudad); ?>
        <label for="e">Provincia:</label>
        <select name="select">
            <option hidden selected>Selecciona una provincia</option>
            <?php foreach ($provincias as $provincia){?>
                <option value="<?php echo $provincia['codigo']?>" ><?php echo $provincia['provincia']?> </option>
            <?php } ?>
        </select>
        <label for="postal">Código postal:</label> <input name="postal" id="postal" type="text" placeholder="28002"><br/>
        <?php echo numeros($postal, 5, $provSelect); ?>
        <label for="telefono">Teléfono:</label> <input name="telefono" id="telefono" type="tel" placeholder="123-45-67-89"><br/>
        <?php echo numeros($telefono, 9, $provSelect); ?>
        <label for="email">Email:</label> <input name="email" id="email" type="email" placeholder="ejemplo@gmail.com">
        <?php echo email($email); ?>
        <label for="contrasena">Contraseña:</label> <input name="contrasena" id="contrasena" type="password" placeholder="**********">
        <?php echo contrasenia($contrasena); ?>
        <label for="web">Web (debe empezar por http o https):</label> <input name="web" id="web" type="url" placeholder="www.holamundo.com">
        <?php echo web($web); ?>
        <input class="boton" type="submit" name="guardar" value="Guardar">
    </fieldset>
</form>

</body>
</html>
