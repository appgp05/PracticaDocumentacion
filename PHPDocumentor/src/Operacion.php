<?php
/**
 * Clase que representa una operación entre dos operandos (real o racional).
 *
 * Este fichero contiene la definición de la clase Operacion, que se encarga de:
 *  - Determinar el tipo de operación (REAL, RACIONAL o ERROR).
 *  - Extraer el operador y los operandos desde la cadena de entrada.
 *  - Delegar el cálculo a OperacionReal o OperacionRacional según corresponda.
 *
 * NOTA: Este archivo no modifica la lógica existente; los docblocks se han añadido
 * para que phpDocumentor pueda documentar correctamente la API de la clase.
 *
 * @package Calculadora
 * @author Alberto
 * @license MIT
 * @version 1.0
 */
class Operacion {
    /**
     * Tipo: operación con números reales (ej. 5.1+3.2).
     */
    const REAL = 1;

    /**
     * Tipo: operación con números racionales (ej. 5/1:2/3).
     */
    const RACIONAL = 2;

    /**
     * Tipo: operación inválida / no reconocida.
     */
    const ERROR = 3;

    /**
     * Tipo de la operación.
     *
     * Valores esperados: self::REAL | self::RACIONAL | self::ERROR
     *
     * @var int
     */
    protected string $tipo;

    /**
     * Operador extraído de la expresion (por ejemplo '+', '-', '*', '/', ':').
     *
     * @var string
     */
    protected string $operador;

    /**
     * Primer operando como cadena (tal y como vino en la entrada).
     *
     * @var string
     */
    protected string $operando1;

    /**
     * Segundo operando como cadena (tal y como vino en la entrada).
     *
     * @var string
     */
    protected string $operando2;

    /**
     * Construye la operación a partir del texto de entrada.
     *
     * Flujo:
     *  - determina el tipo (REAL, RACIONAL, ERROR) mediante resolverTipo()
     *  - según el tipo, obtiene operador y operandos mediante resolverOperadorYOperandos()
     *  - inicializa las propiedades tipo, operador, operando1 y operando2
     *
     * @param string $textoOperacion Expresión recibida (sin espacios entre operandos y operador).
     *                               Ejemplos válidos: "5.1+4", "6/3:2/1"
     * @return void
     */
    public function __construct($textoOperacion){
        $tipo = self::resolverTipo($textoOperacion);
        var_dump($tipo);

        switch ($tipo) {
            case self::REAL:
                $operadorYOperandos = $this->resolverOperadorYOperandos($textoOperacion, "/[+\-*\/]/");
                break;
            case self::RACIONAL:
                $operadorYOperandos = $this->resolverOperadorYOperandos($textoOperacion, "/[+\-*:]/");
                break;
            case self::ERROR:
                $operadorYOperandos = ["", "", ""];
                break;
        }

        $this->tipo = $tipo;
        $this->operador = $operadorYOperandos[0];
        $this->operando1 = $operadorYOperandos[1];
        $this->operando2 = $operadorYOperandos[2];
    }

    /**
     * Determina el tipo de la operación a partir de la cadena de entrada.
     *
     * Comprueba contra dos patrones (real y racional). Devuelve una de las constantes:
     *  - self::REAL
     *  - self::RACIONAL
     *  - self::ERROR
     *
     * @param string $textoOperacion Texto con la operación a analizar.
     * @return int Uno de los valores self::REAL | self::RACIONAL | self::ERROR.
     */
    private function resolverTipo(string $textoOperacion): string{
        $patronNumeroReal = "\-?[0-9]([0-9]+)?(\.[0-9]+)?";
        $patronOperadorReal = "[+\-*\/]";
        $patronReal = "/^{$patronNumeroReal}{$patronOperadorReal}{$patronNumeroReal}$/";

        $patronNumeroRacional = "\-?[1-9]([0-9]+)?(\/[1-9]([0-9]+)?)?";
        $patronOperadorRacional = "[+\-*:]";
        $patronRacional = "/^{$patronNumeroRacional}{$patronOperadorRacional}{$patronNumeroRacional}$/";


        switch (true) {
            case preg_match($patronReal, $textoOperacion):
                return self::REAL;
            case preg_match($patronRacional, $textoOperacion):
                return self::RACIONAL;
            default:
                return self::ERROR;
        }
    }

    /**
     * Extrae el operador y los dos operandos desde la expresión, usando un patrón de operador.
     *
     * El resultado es un array de tres elementos:
     *  - [0] => operador (string)
     *  - [1] => operando1 (string)
     *  - [2] => operando2 (string)
     *
     * @param string $textoOperacion Texto con la operación (sin espacios).
     * @param string $patronOperadores Patrón regex que identifica el operador (p.e. "/[+\-*\/]/").
     * @return string[] Array con [operador, operando1, operando2].
     */
    private function resolverOperadorYOperandos(string $textoOperacion, string $patronOperadores): array{
        preg_match($patronOperadores, $textoOperacion, $operador);
        $operadorYOperadores[0] = $operador[0];

        $operandos = preg_split($patronOperadores, $textoOperacion);
        $operadorYOperadores[1] = $operandos[0];
        $operadorYOperadores[2] = $operandos[1];

        return $operadorYOperadores;
    }

    /**
     * Calcula el resultado delegando en la clase correspondiente según el tipo.
     *
     * - Para self::REAL crea OperacionReal y devuelve su resultado (float).
     * - Para self::RACIONAL crea OperacionRacional y devuelve su resultado (Racional).
     * - Para self::ERROR devuelve una cadena con mensaje de error HTML.
     *
     * @return float|\Racional|string Resultado del cálculo (float para reales,
     *         instancia Racional para racionales, o string de error).
     *
     * @see OperacionReal::calcular()
     * @see OperacionRacional::calcular()
     */
    public function calcular(): float|Racional|string {
        switch ($this->tipo) {
            case self::REAL:
                $operacionReal = new OperacionReal($this);
                return $operacionReal->calcular();
            case self::RACIONAL:
                $operacionRacional = new OperacionRacional($this);
                return $operacionRacional->calcular();
            case self::ERROR:
                return "<p class='destacado'>Operacion inválida</p>";
            default:
                return 0;
        }
    }
}
?>
