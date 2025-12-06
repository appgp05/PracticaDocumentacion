<?php
/**
 * Operaciones sobre números reales.
 *
 * Esta clase extiende Operacion y ejecuta la operación cuando los operandos son reales.
 * Delegación:
 *  - Recibe una instancia de Operacion (con operando1, operador, operando2).
 *  - Llama al constructor del padre con la expresión reconstruida.
 *  - Implementa el método calcular() que realiza la operación aritmética.
 *
 * @package Calculadora
 * @author Alberto
 * @license MIT
 * @version 1.0
 *
 * @see Operacion
 */
class OperacionReal extends Operacion {
    /**
     * Constructor.
     *
     * Inicializa la operación real a partir de un objeto Operacion que contiene
     * las propiedades `operando1`, `operador` y `operando2`.
     *
     * @param Operacion $operacion Objeto con propiedades operando1, operador y operando2.
     * @return void
     *
     * @see Operacion::__construct()
     */
    public function __construct(Operacion $operacion){
        parent::__construct($operacion->operando1.$operacion->operador.$operacion->operando2);
    }

    /**
     * Calcula el resultado de la operación sobre operandos reales.
     *
     * Nota sobre tipos: este método devuelve un float. El código actual utiliza
     * directamente `$this->operando1` y `$this->operando2` en las operaciones;
     * phpDocumentor documenta aquí la expectativa de que esos valores sean numéricos
     * (float|int) o coercibles a float.
     *
     * @return float Resultado de la operación como número de punto flotante.
     */
    public function calcular(): float {
        $resultado = null;

        var_dump($this->operador, $this->operando1, $this->operando2);

        switch ($this->operador) {
            case "+":
                $resultado = $this->operando1 + $this->operando2;
                break;
            case "-":
                $resultado = $this->operando1 - $this->operando2;
                break;
            case "*":
                $resultado = $this->operando1 * $this->operando2;
                break;
            case "/":
                $resultado = $this->operando1 / $this->operando2;
                break;
            default:
                break;
        }

        return $resultado;
    }
}
?>
