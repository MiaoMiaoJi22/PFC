function hbRgpd() {
	localStorage.setItem("rgpd", "Aceptado");
	document.getElementsByClassName("rgpdbh")[0].style.display = "none";
}

var rgpdval = localStorage.getItem("rgpd");

if (rgpdval == "Aceptado") {
	document.getElementsByClassName("rgpdbh")[0].style.display = "none";
} else {
	document.getElementsByClassName("rgpdbh")[0].style.display = "inherit";
}