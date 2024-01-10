const pwShowHide = document.querySelectorAll(".showHodePW"),
	  pwFields = document.querySelectorAll(".contrase");

pwShowHide.forEach(eyeIcon => {
	eyeIcon.addEventListener("click", ()=>{
		pwFields.forEach(pwField =>{
			if(pwField.type === "password"){
				pwField.type = "text";

				pwShowHide.forEach(icon =>{
					icon.classList.replace("fa-eye-slash", "fa-eye");
				})
			}else{
				pwField.type = "password";

				pwShowHide.forEach(icon =>{
					icon.classList.replace("fa-eye", "fa-eye-slash");
				})
			}
		})
	})
});

