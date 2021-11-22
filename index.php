<?php

//Expesión para extraer ciudades de una lista
$provincias = [];
$string = file_get_contents('cpProvincias.csv');
$provincias_cod = explode("\n", $string);
foreach ($provincias_cod as $fila) {
    $separar = explode(";", $fila);
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
    if ($string != "") {
        return $mensaje;
    }
}

//Escribe una función que devuelva un mensaje en caso de que el usuario escriba letras en el campo de entrada de
// teléfono o en el de código postal.
function numeros($string, $num, $nProv)
{
    print_r('codigo postal'.$string.'<br/>');
    $regex = "/^[0-9]{" . $num . "}+$/"; //No puede tener letras, el ^ y +$ son para obligarle a que todo sean números
    //La función preg_match devuelve uno cuando comprueba que toda la expresion son numeros
    //La función strlen nos devuelve la longitus del string que la igualamos a la cantidad que necesitamos
    if (preg_match($regex, $string) != 1) {
        $mensaje = "No todos tus caracteres son números o la cantidad de caracteres es diferente a " . $num;
    }
    print_r('codigo: '.$nProv.'<br/>');
    if ($nProv != substr($string, 0, 2) && $num == 5) {
        $mensProv = "la provincia no coincide con el CP";
    }
    if ($string != "") {
        return $mensaje . $mensProv;
    }
}

//funcion para el correo electronico
function email($string)
{

    $regex = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}+$/"; //Estructura email: letras, numeros, ciertos
    // caracteres especiales + @ + letras, punto o guion + punto + mas letras de como minimo 2 de longitus y maximo 6.
    //La función preg_match devuelve uno cuando encuentra un número en la expresión
    if (preg_match($regex, $string) != 1) {
        $mensaje = "No has introducido una direccion de email correcta";
    }
    if ($string != "") {
        return $mensaje;
    }
}

//Función para comprobar una dirección web
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
    if ($string != "") {
        return $mensaje;
    }

}

//Función para comprobar los carácteres de la contraseña
function web($string)
{
    $regex = "/^http[s]?:\/\/[\w]+([\.]+[\w]+)+$/"; //EStructura. tiene que empezar obligatoriamente por http p https://,
    //seguido de cualquier caracter alfanumérico, seguido de un punto, seguido de cualquier caracter alfanumérico y que obligatoriamente acabe así
    //If que compara la web insertada con mi expresión regular, si esta no cumple
    //los patrones me devuelve un mensaje de que es incorrecta.
    if (preg_match($regex, $string) != 1) {
        $mensaje = "La web no cumple las normas, inserte una nueva";
    }
    if ($string != "") {
        return $mensaje;
    }
}

//Comprobación de envío de formulario
//con el if compruebo que he enviado el formulario
if (isset($_POST['guardar'])) {
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
    $provSelect = filter_input(INPUT_POST, 'select', FILTER_SANITIZE_STRING);

    //En caso de que los campos estén vacios
    if (empty($nombre)){$error_nombre = "Introduce un nombre<br>";}
    if (empty($apellido)){$error_apellidos = "Introduce un apellido<br>";}
    if (empty($email)){$error_email = "Introduce un email<br>";}
    if (empty($telefono)){$error_telefono = "Introduce un telefono<br>";}
    if (empty($postal)){$error_postal = "Introduce un código postal<br>";}
    if (empty($ciudad)){$error_ciudad = "Introduce una ciudad<br>";}
    if (empty($domicilio)){$error_domicilio = "Introduce un domicilio<br>";}
    if (empty($contrasena)){$error_contrasena = "Introduce una contraseña<br>";}
    if (empty($web)){$error_web = "Introduce una URL<br>";}
    if (empty($provSelect)) {$error_provincia = "Selecciona una provincia <br>";}
    if (!empty($nombre) and !empty($apellidos) and !empty($email) and !empty($telefono)
        and !empty($postal) and !empty($ciudad) and !empty($domicilio) and !empty($contrasena) and !empty($web)){
        //Extraer emails de mis registros
        //me creo un array para almacenar mis datos del registro
        $todosDatos = [];
        //me saco mis registros para poder comparar el campo de email que necesito
        $string_email = file_get_contents('registros.csv');
        //uso el explode para separar mis diferentes líneas del fichero
        $emails_reg = explode("\n", $string_email);
        //hago un foreach para separar dentro de cada línea del fichero cada campo
        foreach ($emails_reg as $linea) {
            $separo = explode(";", $linea);
            //relleno mi array con cada campo
            $todosDatos[] = [
                'nombre' => $separo[0],
                'apellido' => $separo[1],
                'email' => $separo[2],
                'telefono' => $separo[3],
                'postal' => $separo[4],
                'ciudad' => $separo[5],
                'domicilio' => $separo[6],
                'contraseña' => $separo[7],
                'web' => $separo[8]
            ];
        }
        //creo una variable contador que me va a ayudar a saber si tengo el email registrado o no
        $contador = 0;
        //hago un if para contabilizar las veces que esta en mi email en el caso de que mi array no este vacío
        if ($todosDatos != "") {
            foreach ($todosDatos as $correo) {
                //hago un if para saber cuantas veces aparece en mi documento el email que se intenta introducir, va sumando al contador cada vez
                //que encuentra una coincidencia
                if ($email == $correo['email']) {
                    $contador++;
                }
            }
        }
        //Guardar los datos recogidos en un archivo csv
        //creo mi array de campos
        $datos = [$nombre, $apellido, $email, $telefono, $postal, $ciudad, $domicilio, $contrasena, $web];
        //uso la función file_put_contens() para escribir en mi archivo registros.csv
        //Creo un if que tiene como condición que si el email que se introduce ya está en mi archivo, entonces no se insertan nuevos campos
        //para ello uso mi variable contador la cual si está a 0 permitirá que se escriba en el fichero
        if ($contador == 0) {
            //hago un foreach para ir introduciendo dato a dato con el separador ;
            foreach ($datos as $dato) {
                //uso la función file_put_contents para escribir en mi archivo, le paso como parámetros el archivo, el dato
                //que quiero escribir concatenado con ; como separador y pongo el FILE_APPEND para que no me sobreescriba
                //el archivo sino que añada contenido
                file_put_contents('registros.csv', $dato . ';', FILE_APPEND);
            }
            //hago otra escritura cuando acaba cada fila entera para que me haga un salto de línea
            file_put_contents('registros.csv', "\n", FILE_APPEND);
        } else {
            //Si encuentra una coincidencia de email, manda un mensaje de alerta de que el email ya está registrado.
            $error = "Esta cuenta de correo ya está registrada";
        }

    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Haz tu registro GRATIS!</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
</head>
<body>
<div id="contenedor">
    <div class="header">
        <h1>¡Haz tu registro GRATIS!</h1>
        <form action="index.php" method="post">
            <fieldset>
                <legend>Datos Personales</legend>
                <label for="nombre">Nombre:</label> <input name="nombre" id="nombre" type="text" placeholder="Jose">
                <p class="error"><?php echo letras($nombre); ?></p>
                <p class="error"><?php echo $error_nombre ?></p>
                <label for="apellido">Apellidos:</label> <input name="apellido" id="apellido" type="text"
                                                                placeholder="García Pérez"><br/>
                <p class="error"><?php echo letras($apellido); ?></p>
                <p class="error"><?php echo $error_apellidos ?></p>
                <label for="domicilio">Dirección:</label> <input name="domicilio" id="domicilio" type="text"
                                                                 placeholder="C. Alustante, 13"><br/>
                <p class="error"><?php echo $error_domicilio ?></p>

                <label for="ciudad">Ciudad:</label> <input name="ciudad" id="ciudad" type="text"
                                                           placeholder="Madrid"><br/>
                <p class="error"><?php echo letras($ciudad); ?></p>
                <p class="error"><?php echo $error_ciudad ?></p>
                <label for="e">Provincia:</label>
                <select name="select">
                    <option hidden selected>Selecciona una provincia</option>
                    <?php foreach ($provincias as $provincia) { ?>
                        <option value="<?php echo $provincia['codigo'] ?>"><?php echo $provincia['provincia'] ?> </option>
                    <?php } ?>
                </select>
                <p class="error"><?php echo $error_provincia ?></p>
                <label for="postal">Código postal:</label> <input name="postal" id="postal" type="text"
                                                                  placeholder="28002"><br/>
                <p class="error"><?php echo numeros($postal, 5, $provSelect); ?></p>
                <p class="error"><?php echo $error_postal ?></p>
                <label for="telefono">Teléfono:</label> <input name="telefono" id="telefono" type="tel"
                                                               placeholder="123-45-67-89"><br/>
                <p class="error"><?php echo numeros($telefono, 9, $provSelect); ?></p>
                <p class="error"><?php echo $error_telefono ?></p>
                <label for="email">Email:</label> <input name="email" id="email" type="email"
                                                         placeholder="ejemplo@gmail.com">
                <p class="error"><?php echo email($email);?></>
                <p class="error"><?php echo $error_email ?></p>
                <label for="contrasena">Contraseña:</label> <input name="contrasena" id="contrasena" type="password"
                                                                   placeholder="**********">
                <p class="error"><?php echo contrasenia($contrasena); ?></p>
                <p class="error"><?php echo $error_contrasena ?></p>
                <label for="web">Web <small>(debe empezar por http o https)</small>:</label> <input name="web" id="web" type="url"
                                                                                                    placeholder="www.holamundo.com">
                <p class="error"><?php echo web($web); ?></p>
                <p class="error"><?php echo $error_web ?></p>
                <input class="boton" type="submit" name="guardar" value="Guardar">

            </fieldset>
        </form>
    </div>
</div>

</body>
</html>
