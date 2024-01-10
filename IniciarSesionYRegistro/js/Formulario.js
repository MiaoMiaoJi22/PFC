const formulario  = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario input');

const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,20}$/, //Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ý\s]{1,50}$/, //Letras y espacios, pueden llevar acentos
	password:/^.{4,50}$/, //4-50 digitos
	mail: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-.]+$/,
	phone: /^\d{7,14}$/ //7-1
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
	}else{
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
	}
}	

const ValidarContra = () => {
	const inputPassword1 = document.getElementById('pass');
	const inputPassword2 = document.getElementById('pass2');

	if (inputPassword1.value !== '' && inputPassword2.value !== ''){
		if (inputPassword1.value !== inputPassword2.value){
			document.querySelector(`#grupo__confirmpass .formulario__input-error`).classList.add('formulario__input-error-activo');
		}else{
			document.querySelector(`#grupo__confirmpass .formulario__input-error`).classList.remove('formulario__input-error-activo');
		}
	}
}

const validarFormulario = (e) =>{
	switch (e.target.name){
	case "fullname":
		validarCampo(expresiones.nombre, e.target, 'nombre');
		break;
	case "user":
		validarCampo(expresiones.usuario, e.target, 'usuario');
		break;
	case "mail":
		validarCampo(expresiones.mail, e.target, 'mail');
		break;
	case "phone":
		validarCampo(expresiones.phone, e.target, 'tel');
		break;
	case "password":
		validarCampo(expresiones.password, e.target, 'pass');
		ValidarContra();
		break;
	case "confirmpassword":
		ValidarContra();
		break;
	}
}

inputs.forEach((input) =>{
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});