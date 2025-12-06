/**
 * @module racional
 * @description
 * Clase simple para representar números racionales (fracciones) y operaciones básicas.
 * Implementación intencionalmente sencilla para mantener paridad de complejidad con la versión PHP.
 */

/**
 * Clase que representa un número racional.
 */
export class Racional {
  /**
   * Crea un racional.
   * - Acepta new Racional(numerator, denominator)
   * - Acepta new Racional("a/b")
   * - Acepta new Racional(n)  (denominator = 1)
   *
   * @param {number|string} numerador Entero o cadena "a/b".
   * @param {number} [denominador=1] Denominador (si numerador fue string con '/', se sobrescribe).
   */
  constructor(numerador = 1, denominador = 1) {
    if (typeof numerador === 'string') {
      var partes = numerador.split('/');
      numerador = parseInt(partes[0], 10);
      denominador = partes[1] ? parseInt(partes[1], 10) : 1;
    }

    this.numerador = parseInt(numerador, 10);
    this.denominador = parseInt(denominador, 10);

    // No lanzamos excepción aquí (paralelo a la versión PHP); dejamos que el usuario lo gestione.
    if (this.denominador === 0) {
      // Mantener comportamiento similar a PHP: no romper automáticamente.
      // Para dejar rastro en debug:
      console.warn('Racional: denominador igual a 0');
    }

    // Aseguramos que el signo quede en el numerador
    if (this.denominador < 0) {
      this.numerador = -this.numerador;
      this.denominador = -this.denominador;
    }
  }

  /**
   * Representación en cadena "numerador/denominador".
   * @returns {string}
   */
  toString() {
    return this.numerador + '/' + this.denominador;
  }

  /**
   * Devuelve el valor en punto flotante.
   * @returns {number}
   */
  valueOf() {
    return this.numerador / this.denominador;
  }

  /**
   * Getter numerador.
   * @returns {number}
   */
  getNumerador() {
    return this.numerador;
  }

  /**
   * Getter denominador.
   * @returns {number}
   */
  getDenominador() {
    return this.denominador;
  }

  /**
   * Calcula el máximo común divisor por el algoritmo de Euclides.
   * Implementación sencilla y tradicional.
   *
   * @private
   * @param {number} a
   * @param {number} b
   * @returns {number}
   */
  static _mcd(a, b) {
    a = Math.abs(a);
    b = Math.abs(b);
    while (b !== 0) {
      var t = a % b;
      a = b;
      b = t;
    }
    return a;
  }

  /**
   * Simplifica el racional y devuelve una nueva instancia.
   * @param {Racional} racional
   * @returns {Racional}
   */
  static simplificar(racional) {
    var n = racional.numerador;
    var d = racional.denominador;

    if (d === 0) {
      // Igual que en PHP: no lanzamos, solo devolvemos como está (pero avisamos).
      console.warn('simplificar: denominador 0 detectado');
      return new Racional(n, d);
    }

    var g = Racional._mcd(n, d);
    // Dividir usando enteros (similar intención que en PHP, pero sin forzar floats)
    return new Racional(n / g, d / g);
  }
}
