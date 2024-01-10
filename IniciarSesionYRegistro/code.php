<?php 

session_start(); 
include_once('../ConexionPHP.php');

//Controlador Registrar
if (isset($_POST["btn_registrar"])){

    if (!empty($_POST["fullname"]) && !empty(trim($_POST["user"])) && !empty(trim($_POST["confirmpassword"])) && !empty(trim($_POST["mail"])) && !empty(trim($_POST["phone"]))) {

        $usuario = ucfirst(addslashes(trim($_POST["user"])));
        $contra = $_POST["confirmpassword"];
        $email = strtolower($_POST["mail"]);
        $Tele = $_POST["phone"];
        $Nombre = $_POST["fullname"];
        $cifrarContra = password_hash($contra, PASSWORD_DEFAULT);

        //Confirmar correo
        $ConfirmarCorreo = "SELECT * FROM usuario_pass WHERE E_MAIL = :correo";
        $ResConfirmarCorreo = $base->prepare($ConfirmarCorreo);
        $ResConfirmarCorreo->execute(array(":correo" => $email));

        if ($ResConfirmarCorreo->rowCount() == 0) {

            //Confirmar nombre de usuario
            $ConfirmarUsuario = "SELECT * FROM usuario_pass WHERE USUARIOS = :usuario";
            $ResConfirmarUsuario = $base->prepare($ConfirmarUsuario);
            $ResConfirmarUsuario->execute(array(":usuario" => $usuario));

            if ($ResConfirmarUsuario->rowCount() == 0) {

                $cadena = "INSERT INTO usuario_pass (NOMBRECOMPLETO, USUARIOS, CONTRASENA, TELEFONO, E_MAIL, ROL, FOTO, CODE, ACTIVO) VALUES (:nombrecompleto, :usua, :contra, :tele, :email, :cliente, :foto, 0, 1)";
                $resultado = $base->prepare($cadena);

                $resultado->execute(array(
                    ":nombrecompleto" => $Nombre,
                    ":usua" => $usuario, 
                    ":contra" => $cifrarContra,
                    ":tele" => $Tele,
                    ":email" => $email,
                    ":cliente" => "Cliente",
                    ":foto" => "Fotos/Usuarios/UsuarioNoFotos.png"
                ));

                $_SESSION['titulo']="Hecho!";
                $_SESSION['status']="Usuario registrado correctamente";
                $_SESSION['status_code']="success";

                header('location: IniciarSesion.php');
            }else{

                $_SESSION['titulo']="Error";
                $_SESSION['status']="Nombre de usuario ya existe";
                $_SESSION['status_code']="error";

                header('location: RegistrarUsuario.php');
            }

        }else{

            $_SESSION['titulo']="Error";
            $_SESSION['status']="Con este correo ya existe un usuario";
            $_SESSION['status_code']="error";

            header('location: RegistrarUsuario.php');
        }

    } else {

        $_SESSION['titulo']="Error";
        $_SESSION['status']="Los campos no pueden estar vacios";
        $_SESSION['status_code']="error";

        header('location: RegistrarUsuario.php');
    }

}

//Controlador Iniciar Sesion
if(isset($_POST['btn_login'])){

    if (!empty(trim($_POST["user"])) && !empty($_POST["pass"])){

        $resultado = $base->prepare("SELECT * FROM usuario_pass WHERE USUARIOS = :usuario");

        $usuario = ucfirst(strtolower(trim($_POST["user"])));
        $resultado->execute(array(":usuario" => $usuario));

        if ($resultado->rowCount() == 1){
            $registro = $resultado->fetch();
            $contra = $_POST["pass"];

            if ($usuario === $registro["USUARIOS"] && password_verify($contra, $registro["CONTRASENA"]) && $registro["ACTIVO"] == 1){

                $_SESSION["usuarios"] = $usuario;
                $_SESSION["id_usuario"] = $registro['ID'];
                $_SESSION["Rol_usuario"] = $registro['ROL'];
                $_SESSION["foto_usuario"] = $registro['FOTO'];
                $_SESSION['Correos'] = $registro['E_MAIL'];
                $_SESSION['time'] = time();

                if ($registro['ROL'] === "Administrador" || $registro['ROL'] === "Supervisor") {
                    header("location:../Producto.php");
                } else {
                    header("location:../index.php");
                }

            } else if ($registro["ACTIVO"] == 0) {
                $_SESSION['titulo']="Error";
                $_SESSION['status']="Perdona, tu cuenta está bloqueada, si quiere desbloquear tu cuenta, contactanos a nuestro soporte.";
                $_SESSION['status_code']="error";

                header('location: IniciarSesion.php');
            } else {

                $_SESSION['titulo']="Error";
                $_SESSION['status']="El usuario o contraseña incorrecta";
                $_SESSION['status_code']="error";

                header('location: IniciarSesion.php');
            }

        } else{

            $_SESSION['titulo']="Error";
            $_SESSION['status']="Usuario no existe";
            $_SESSION['status_code']="error";

            header('location: IniciarSesion.php');
        }

    }else {

        $_SESSION['titulo']="Error";
        $_SESSION['status']="Los campos no puede estar vacio";
        $_SESSION['status_code']="error";

        header('location: IniciarSesion.php');
    }

}

//Controlador recuperar contraseña con correo electronico
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; 

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST["btn_enviarCorreo"])){

    if (!empty($_POST['mail'])){

        $email = $_POST['mail'];

        $cadena = "SELECT * FROM usuario_pass WHERE E_MAIL = :correo";

        $resultado = $base->prepare($cadena);
        $resultado->execute(array(":correo" => $email));

        if ($resultado->rowCount() == 1){
            $code = rand(999999, 111111);
            $UpdateCode = "UPDATE usuario_pass SET CODE = :codigo WHERE E_MAIL = :mail";

            $resultadoUpdate = $base->prepare($UpdateCode);
            $resultadoUpdate->execute(array(":codigo" => $code, "mail" => $email));

            $sujeto = 'Codigo de verificacion de correo electronico';
            $mensaje = 'El codigo de verificación es: ' . $code;
            $send = 'vicentealimentacion1969@gmail.com';

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vicentealimentacion1969@gmail.com';
            $mail->Password = 'ccvvcjddchlrrgqq';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom($send);
            $mail->addAddress($_POST['mail']);
            $mail->isHTML(true);
            $mail->Subject = $sujeto;
            $mail->Body = $mensaje;

            if ($mail->Send()){
                $_SESSION['email'] = $email;

                $_SESSION['titulo']="Hecho!";
                $_SESSION['status']="Código enviado correctamente";
                $_SESSION['status_code']="success";

                header('location: VerificarCodigo.php');
            } else {

                $_SESSION['titulo']="Error";
                $_SESSION['status']="Fallo de enviar codigo";
                $_SESSION['status_code']="error";

                header('location: EnviarCorreo.php');
            }

        }else{

            $_SESSION['titulo']="Error";
            $_SESSION['status']="Este correo no existe, no eres nuestro cliente";
            $_SESSION['status_code']="error";

            header('location: EnviarCorreo.php');
        }

    }else{

        $_SESSION['titulo']="Error";
        $_SESSION['status']="El campo de correo no puede estar vacio";
        $_SESSION['status_code']="error";

        header('location: EnviarCorreo.php');
    }

}


//Controlador verificar codigo de 6 digitos
if (isset($_POST["btn_enviarCodigo"])){

    if (!empty($_POST['OTPVerificar'])){

        $email = $_SESSION['email'];

        $codigo = $_POST['OTPVerificar'];

        $cadena = "SELECT * FROM usuario_pass WHERE CODE = :code";

        $resultado = $base->prepare($cadena);
        $resultado->execute(array(":code" => $codigo));

        if ($resultado->rowCount() == 1){

            $UpdateCode = "UPDATE usuario_pass SET CODE = 0";

            $_SESSION['titulo']="Hecho!";
            $_SESSION['status']="Código correcto";
            $_SESSION['status_code']="success";

            header("location:RestablecerPassword.php");
        }else{

            $_SESSION['titulo']="Error";
            $_SESSION['status']="Este código no es que te enviemos";
            $_SESSION['status_code']="error";

            header('location: VerificarCodigo.php');
        }

    }else{

        $_SESSION['titulo']="Error";
        $_SESSION['status']="El campo de los códigos no puede estar vacio";
        $_SESSION['status_code']="error";

        header('location: VerificarCodigo.php');
    }

}

//Controlador Restablecer contraseña
if (isset($_POST['btn_restablece'])){

    $contrase = $_POST['password'];
    $confirmarcontrase = $_POST['confirmpassword'];

    if ($contrase !== $confirmarcontrase){

        $_SESSION['titulo']="Error";
        $_SESSION['status']= "Ambas contraseañas son diferentes";
        $_SESSION['status_code']="error";

        header('location: RestablecerPassword.php');

    }else{

        $email = $_SESSION['email'];
        $cifrarContra = password_hash($confirmarcontrase, PASSWORD_DEFAULT);

        $UpdatePassword = "UPDATE usuario_pass SET CONTRASENA = :password WHERE E_MAIL = :mail";

        $resultadoUpdate = $base->prepare($UpdatePassword);
        $resultadoUpdate->execute(array(":password" => $cifrarContra, "mail" => $email));

        $_SESSION['titulo']="Hecho!";
        $_SESSION['status']="La contraseña se ha modificado correctamente";
        $_SESSION['status_code']="success";

        unset($_SESSION['email']);
        header('location: IniciarSesion.php');

    }
}

?>