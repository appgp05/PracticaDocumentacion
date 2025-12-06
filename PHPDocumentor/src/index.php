<?php
/**
 * Archivo front controller para la calculadora (index).
 *
 * Maneja la petición POST enviada desde el formulario, crea una instancia de
 * Operacion y obtiene el resultado para mostrar en la vista.
 *
 * Requisitos/convención:
 * - Espera $_POST['operacion'] con el texto de la operación.
 * - Espera $_POST['submit'] con el valor "Calcular" para disparar el cálculo.
 *
 * @package Calculadora
 * @author Alberto
 * @license MIT
 * @version 1.0
 */

/**
 * Autoloader simple que carga clases desde ./../src/{Class}.php.
 *
 * Nota: phpDocumentor puede indexar este bloque; aquí documentamos el
 * callback del autoload para dejar claro el parámetro esperado.
 *
 * @param string $class Nombre de la clase a cargar.
 * @return void
 */
spl_autoload_register(fn ($class) => require_once "./../src/$class.php");

/**
 * Valor del botón submit enviado por el formulario.
 *
 * @var string|null $submit Puede ser "Calcular" o null si no se ha enviado.
 */
$submit = $_POST['submit']??null;

/**
 * Resultado de la operación a mostrar en la vista.
 *
 * @var string $resultado Cadena con el resultado o cadena vacía por defecto.
 */
$resultado = "";

/**
 * Procesamiento de la petición POST.
 *
 * Comportamiento:
 *  - Si $submit === "Calcular": obtiene $_POST['operacion'], crea
 *    una instancia de Operacion y calcula el resultado.
 *  - Otros valores (null u otros): no realiza acción.
 *
 * @uses Operacion Clase que interpreta y calcula la operación.
 */
switch ($submit) {
    case "Calcular":
        /**
         * Texto de la operación enviada por el usuario.
         *
         * @var string $textoOperacion Expresión en formato soportado por la calculadora.
         */
        $textoOperacion = $_POST['operacion'];

        /**
         * Instancia que representa la operación a calcular.
         *
         * Documentación recomendada para la clase Operacion:
         * - Método __construct(string $texto)
         * - Método calcular(): string|float (según tu implementación)
         *
         * @var Operacion $operacion
         */
        $operacion = new Operacion($textoOperacion);

        /**
         * Se delega en el método calcular() de la clase Operacion.
         * @see Operacion::calcular()
         */
        $resultado = $operacion->calcular();

        break;
    case null:
        // No se ha enviado formulario: no hacemos nada.
        break;
    default:
        // Otros valores de submit no contemplados: no hacemos nada.
        break;
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
    <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
</head>
<body>
<header>
    <h1>Calculadora Real / Racional</h1>
</header>
<aside>
    <fieldset id="ayuda">
        <legend>Reglas de uso de la calculadora</legend>
        <ul>
            <li>La calculadora se usa escribiendo la operación.</li>
            <li>La  operación será <strong>Operando_1 operación Operando_2</strong>.</li>
            <li>Cada operando puede ser número <i>positivo</i><strong> real  o racional.</strong></li>
            <li>Real p.e. <strong>5</strong> o <strong>5.12 </strong> Racional p.e <strong> 6/3 </strong>o<strong> 7/1</strong></li>
            <li>Los operadores reales permitidos son <strong><span class="destacado"> +  -  *  /</span></strong></li>
            <li>Los operadores racionales permitidos son <strong><span class="destacado"> +  -  *  :</span> </strong></li>
            <li>No se deben de dejar espacios en blanco entre operandos y operación</li>
            <li>Si un operando es real y el otro racional se considerará operación racional</label></li>
            <li>Ejemplos:
                <ul>
                    <li>(Real) <strong>5.1+4</strong></li>
                    <li>(Racional) <strong>5/1:2</strong></li>
                    <li>(Error) <strong>5.2+5/1</strong></li>
                    <li>(Error) <strong>52214+</strong></li>
                </ul>
            </li>
        </ul>
    </fieldset>
</aside>
<main>
    <fieldset>
        <legend>Establece la operación</legend>
        <form action="index.php" method="post">
            <label for="operacion">Operación</label>
            <input type="text" name="operacion" value="<?= $_POST['operacion']??"" ?>">
            <input type="submit" name="submit" value="Calcular">
        </form>
    </fieldset>

    <fieldset id=rtdo><legend>Resultado</legend>
        <label><?= $resultado ?></label>
    </fieldset>
</main>

</body>
</html>