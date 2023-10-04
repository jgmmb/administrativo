<?php
    require("../Mailer/src/PHPMailer.php");
    include("../Mailer/src/SMTP.php");


    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");

    class Email2 extends PHPMailer{
        
        public function recuperar($usu_correo){
            $usuario = new Usuario();
            $datos = $usuario->get_correo_usuario($usu_correo);
            foreach ($datos as $row) {
                $nom = $row["usu_nom"].' '.$row["usu_ape"];
                $pass = $row["usu_pass"];
            }

            $this->IsSMTP();
            $this->Host = 'smtp.office365.com';
            $this->Port = 587;
            $this->SMTPAuth = true;
            $this->Username = $this->tu_email = 'jmendoza@sugit.com.ar';
            $this->Password = $this->tu_password = 'Yob91104';
            $this->SMTPSecure = 'tls';
            $this->From = $this->tu_email;
            $this->CharSet='UTF8';
            $this->addAddress($usu_correo);
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Recuperar Contraseña";
                $cuerpo = file_get_contents('../public/recuperar.html');
                $cuerpo = str_replace('lblnomx',$nom,$cuerpo);
                $cuerpo = str_replace('lblpassx',$pass,$cuerpo);
            $this->Body = $cuerpo;
            $this->IsHTML(true);
            return $this->send();
        }

    }
?>