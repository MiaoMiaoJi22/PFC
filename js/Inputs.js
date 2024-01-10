const inputCantidad = document.querySelector('.cantidad');
const btnIncrement = document.querySelectorAll('.incrementar');
const btnDescrement = document.querySelectorAll('.decrementar');

let valueByDefault = parseInt(inputCantidad.value);


for (let boton of btnIncrement) {
  boton.addEventListener('click', () => {
    valueByDefault += 1
    inputCantidad.value = valueByDefault
  });
};


for (let botons of btnDescrement) {

  botons.addEventListener('click', () => {
    valueByDefault -= 1
    inputCantidad.value = valueByDefault
  });
};