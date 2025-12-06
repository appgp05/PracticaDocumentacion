/**
 * @module main
 * @description
 * Punto de entrada: conecta UI con la lógica de operaciones.
 *
 * Incluye:
 * - lectura del input
 * - creación de Operacion
 * - mostrar resultado (número o racional)
 */

import { Operacion } from './operacion.js';
import { Racional } from './racional.js';
import { getInputValue, setResult, onFormSubmit } from './ui.js';

/**
 * Evalúa la expresión y devuelve una representación adecuada para mostrar.
 * @param {string} expression
 * @returns {string}
 */
function evaluateExpression(expression) {
  var op = new Operacion(expression);
  var res = op.calcular();

  // Si es Racional (objeto con toString y valueOf)
  if (res && typeof res === 'object' && typeof res.toString === 'function') {
    // Mostrar "a/b (≈ float)" similar a ejemplo anterior
    return res.toString() + ' (≈ ' + res.valueOf() + ')';
  }

  // Si es número
  if (typeof res === 'number') {
    if (Number.isNaN(res)) {
      return "<span class='destacado'>Error: operación inválida (p. ej. división por cero)</span>";
    }
    return String(res);
  }

  // Si es string (mensaje de error)
  return String(res);
}

/**
 * Inicializa la app: enlaza formulario y muestra resultado.
 */
function init() {
  onFormSubmit('#calc-form', function () {
    var input = getInputValue('#operacion');
    var out = evaluateExpression(input);
    setResult('#resultado', out);
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
