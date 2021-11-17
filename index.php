<?php

    //Función 1 para que salga un mensaje en caso de que se introduzcan números en vez de letras en los campos de nombre,
    //apellido y ciudad. Con expresión regular.
    function nom($string)
    {
        $regex = "/[0, 9]/"; //No puede tener ningún número, en el caso de los número se cambiaría a [A-Za-zÑñ] para comprobar
        //que no haya ninguna letra.
        //La función preg_match devuelve uno cuando encuentra un número en la expresión
        if (preg_match($regex, $string) != 1) {
            $mensaje = "Has escrito un número en vez de una letra";
        }
        return $mensaje;
    }

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

    //CON EL IF COMPRUEBO QUE HE ENVIADO EL FORMULARIO
    if(isset($_POST['guardar'])) {
        //recojo los valores
        $contrasenia = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_STRING);
    }
    //Expresión para comprobar los carácteres de la contraseña
    $regex = "/((?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^A-Za-z0-9])).{8,16}/";
    //If que compara la contraseña insertada con mi expresión regular, si la contraseña esta insertada y esta no cumple
    //los patrones me devuelve un mensaje de que es incorrecta.
    if ($contrasenia != "" && preg_match($regex, $contrasenia) != 1) {
        $mensaje = "La contraseña no cumple las normas, inserte una nueva";
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
                    <label for="a">Nombre:</label> <input name="a" id="a" type="text" placeholder="Jose">
                    <label for="b">Apellidos:</label> <input name="b" id="b" type="text" placeholder="García Pérez"><br/>
                    <label for="c">Dirección:</label> <input name="c" id="c" type="text" placeholder="C. Alustante, 13"><br/>
                    <label for="d">Ciudad:</label> <input name="d" id="d" type="text" placeholder="Madrid"><br/>
                    <label for="e">Provincia:</label>
                    <select name="select" >
                        <option hidden selected>Selecciona una provincia</option>
                        <?php foreach ($provincias as $provincia){?>
                            <option value="value1"><?php echo $provincia['provincia']?> </option>
                        <?php } ?>
                    </select>
                    <label for="f">Código postal:</label> <input name="f" id="f" type="text" placeholder="28002"><br/>
                    <label for="g">Teléfono:</label> <input name="g" id="g" type="tel" placeholder="123-45-67-89"><br/>
                    <label for="h">Email:</label> <input name="h" id="h" type="email" placeholder="ejemplo@gmail.com">
                    <label for="i">Contraseña:</label> <input name="i" id="i" type="password" placeholder="**********">
                    <?php echo $mensaje; ?>
                    <label for="j">Web:</label> <input name="j" id="j" type="url" placeholder="www.holamundo.com">
                    <input class="boton" type="submit" name="guardar" value="Guardar">
                </fieldset>
            </form>

        </body>
    </html>
