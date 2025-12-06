/**
 * @module ui
 * @description
 * Helpers DOM simples para conectar el formulario HTML con la lógica JS.
 */

/**
 * Obtiene el valor del input indicado por selector.
 * @param {string} selector
 * @returns {string}
 */
export function getInputValue(selector) {
  var el = document.querySelector(selector);
  return el ? (el.value || '').trim() : '';
}

/**
 * Inserta HTML en el contenedor indicado.
 * @param {string} selector
 * @param {string} html
 */
export function setResult(selector, html) {
  var el = document.querySelector(selector);
  if (el) {
    el.innerHTML = String(html);
  }
}

/**
 * Añade un listener al submit del formulario y previene submit real.
 * @param {string} formSelector
 * @param {function(Event):void} handler
 */
export function onFormSubmit(formSelector, handler) {
  var form = document.querySelector(formSelector);
  if (!form) return;
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    handler(e);
  });
}
