<?php
/**
 * Operaciones sobre números racionales.
 *
 * Esta clase extiende Operacion y se encarga de:
 *  - Construir una operación racional a partir de una operación previa.
 *  - Ejecutar la operación delegando en métodos privados que realizan
 *    suma, resta, multiplicación y división sobre instancias de Racional.
 *
 * @package Calculadora
 * @author Alberto
 * @license MIT
 * @version 1.0
 *
 * @see Operacion
 */
class OperacionRacional extends Operacion {
    /**
     * Constructor.
     *
     * Recibe una instancia (u objeto) que contiene las propiedades
     * `operando1`, `operador` y `operando2` y llama al constructor
     * del padre con la concatenación correspondiente.
     *
     * @param Operacion $operacion Objeto con propiedades operando1, operador y operando2.
     * @return void
     *
     * @see Operacion::__construct()
     */
    public function __construct($operacion){
        parent::__construct($operacion->operando1.$operacion->operador.$operacion->operando2);
    }

    /**
     * Calcula el resultado de la operación racional.
     *
     * Crea dos instancias de Racional a partir de los operandos y delega en
     * los métodos privados correspondientes a cada operador.
     *
     * @return Racional Resultado simplificado de la operación racional.
     */
    public function calcular(): Racional {
        $operando1 = new Racional($this->operando1);
        $operando2 = new Racional($this->operando2);

        switch ($this->operador) {
            case "+":
                $resultado = self::sumar($operando1, $operando2);
                break;
            case "-":
                $resultado = self::restar($operando1, $operando2);
                break;
            case "*":
                $resultado = self::multiplicar($operando1, $operando2);
                break;
            case ":":
                $resultado = self::dividir($operando1, $operando2);
                break;
            default:
                $resultado = new Racional();
        }

        return $resultado;
    }

    /**
     * Suma dos racionales y devuelve el resultado simplificado.
     *
     * @param Racional $racional1 Primer sumando.
     * @param Racional $racional2 Segundo sumando.
     * @return Racional Resultado simplificado de la suma.
     */
    private function sumar(Racional $racional1, Racional $racional2): Racional {
        $numerador = $racional1->getNumerador() * $racional2->getDenominador() + $racional1->getDenominador() * $racional2->getNumerador();
        $denominador = $racional1->getDenominador() * $racional2->getDenominador();

        var_Dump($racional1, $racional2);
        var_dump($numerador, $denominador);

        $resultado = Racional::simplificar(new Racional($numerador, $denominador));

        return $resultado;
    }

    /**
     * Resta dos racionales y devuelve el resultado simplificado.
     *
     * @param Racional $racional1 Minuendo.
     * @param Racional $racional2 Sustraendo.
     * @return Racional Resultado simplificado de la resta.
     */
    private function restar(Racional $racional1, Racional $racional2): Racional {
        $numerador = $racional1->getNumerador() * $racional2->getDenominador() - $racional1->getDenominador() * $racional2->getNumerador();
        $denominador = $racional1->getDenominador() * $racional2->getDenominador();

        $resultado = Racional::simplificar(new Racional($numerador, $denominador));

        return $resultado;
    }

    /**
     * Multiplica dos racionales y devuelve el resultado simplificado.
     *
     * @param Racional $racional1 Primer factor.
     * @param Racional $racional2 Segundo factor.
     * @return Racional Resultado simplificado de la multiplicación.
     */
    private function multiplicar(Racional $racional1, Racional $racional2): Racional {
        $numerador = $racional1->getNumerador() * $racional2->getNumerador();
        $denominador = $racional1->getDenominador() * $racional2->getDenominador();

        $resultado = Racional::simplificar(new Racional($numerador, $denominador));

        return $resultado;
    }

    /**
     * Divide dos racionales y devuelve el resultado simplificado.
     *
     * @param Racional $racional1 Dividendo.
     * @param Racional $racional2 Divisor.
     * @return Racional Resultado simplificado de la división.
     */
    private function dividir(Racional $racional1, Racional $racional2): Racional {
        $numerador = $racional1->getNumerador() * $racional2->getDenominador();
        $denominador = $racional1->getDenominador() * $racional2->getNumerador();

        $resultado = Racional::simplificar(new Racional($numerador, $denominador));

        return $resultado;
    }
}
?>
