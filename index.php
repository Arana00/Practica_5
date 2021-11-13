<?php
    //Función 1 para que salga un mensaje en caso de que se introduzcan números en vez de letras en los campos de nombre,
    //apellido y ciudad. Con expresión regular.
    function nom($string){
        $regex = "/[0, 9]/"; //No puede tener ningún número, en el caso de los número se cambiaría a [A-Za-zÑñ] para comprobar
        //que no haya ninguna letra.
        //La función preg_match devuelve uno cuando encuentra un número en la expresión
        if (preg_match($regex,$string) != 1){
            $mensaje = "Has escrito un número en vez de una letra";
        }
        return $mensaje;

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
        <label for="a">Nombre:</label> <input name="a" id="a" type="text" placeholder="Jose">
        <label for="b">Apellidos:</label> <input name="b" id="b" type="text" placeholder="García Pérez"><br/>
        <label for="c">Dirección:</label> <input name="c" id="c" type="text" placeholder="C. Alustante, 13"><br/>
        <label for="d">Ciudad:</label> <input name="d" id="d" type="text" placeholder="Madrid"><br/>
        <label for="e">Provincia:</label> <input name="e" id="e" type="file" multiple><br/>
        <label for="f">Código postal:</label> <input name="f" id="f" type="text" placeholder="28002"><br/>
        <label for="g">Teléfono:</label> <input name="g" id="g" type="tel" placeholder="123-45-67-89"><br/>
        <label for="h">Email:</label> <input name="h" id="h" type="email" placeholder="ejemplo@gmail.com">
        <label for="i">Contraseña:</label> <input name="i" id="i" type="password" placeholder="**********">
        <label for="j">Web:</label> <input name="j" id="j" type="url" placeholder="www.holamundo.com">
    </fieldset>
</form>

</body>
</html>
   