<?php
/**
 * Clase para representar números racionales y operaciones básicas sobre ellos.
 *
 * Proporciona:
 *  - Constructor que acepta un par (numerador, denominador) o una cadena "a/b".
 *  - Conversión a cadena mediante __toString().
 *  - Método estático simplificar() que intenta devolver la fracción en su forma irreducible.
 *  - Getters para numerador y denominador.
 *
 * NOTA: Se han añadido estos docblocks para que phpDocumentor genere una documentación
 * navegable; la implementación interna no se ha modificado.
 *
 * @package Calculadora
 * @author Alberto
 * @license MIT
 * @version 1.0
 */
class Racional {
    /**
     * Numerador de la fracción.
     *
     * @var int
     */
    private int $numerador;

    /**
     * Denominador de la fracción.
     *
     * @var int
     */
    private int $denominador;

    /**
     * Constructor.
     *
     * Acepta:
     *  - dos enteros: new Racional(3, 4)
     *  - una cadena tipo "a/b": new Racional("6/3")
     *  - un único entero (numerador), con denominador por defecto = 1.
     *
     * @param int|string $numerador Numerador o cadena "numerador/denominador".
     * @param int $denominador Denominador (por defecto 1). Si $numerador es cadena, este parámetro se sobrescribe.
     * @return void
     */
    public function __construct(
        int|string $numerador = 1,
        int $denominador = 1
    ) {
        if(is_string($numerador)){
            $numeradorYDenominador = explode("/", $numerador);
            $numerador = $numeradorYDenominador[0];
            $denominador = $numeradorYDenominador[1]??1;
        }

        $this->numerador = (int) $numerador;
        $this->denominador = $denominador;
    }

    /**
     * Representación en cadena del racional.
     *
     * @return string Cadena en formato "numerador/denominador".
     */
    public function __toString(): string {
        return "$this->numerador/$this->denominador";
    }

    /**
     * Devuelve una nueva instancia de Racional simplificada (forma irreducible).
     *
     * Implementación: se intenta aplicar un algoritmo (similar al algoritmo de Euclides)
     * para obtener el máximo común divisor y dividir numerador y denominador por él.
     *
     * @param Racional $racional Racional a simplificar.
     * @return Racional Nueva instancia simplificada.
     */
    public static function simplificar(Racional $racional): Racional {
        $numerador = $racional->numerador;
        $denominador = $racional->denominador;

        while($numerador % $denominador > 1){
            $antiguoNumerador = $numerador;
            $numerador = $denominador;
            $denominador = $antiguoNumerador % $denominador;
        }

        return new Racional($racional->numerador/$denominador, $racional->denominador/$denominador);
    }

    /**
     * Getter del numerador.
     *
     * @return int Numerador del racional.
     */
    public function getNumerador(): int {
        return $this->numerador;
    }

    /**
     * Getter del denominador.
     *
     * @return int Denominador del racional.
     */
    public function getDenominador(): int
    {
        return $this->denominador;
    }
}
?>
