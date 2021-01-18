<?php
    require_once('db.class.php');
    //Resgatar informações e filtrar
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $cnpj = filter_var($_POST['cnpj'], FILTER_SANITIZE_NUMBER_INT);
    $password = md5($_POST['password']);
    $description = htmlspecialchars($_POST['descript$description'], ENT_QUOTES);
    // $logo = $_FILES['logo'];


    // Tratamento imagem
    if($logo != NULL) {
        $nomeFinal = time().'.jpg';
        if (move_uploaded_file($logo['tmp_name'], $nomeFinal)) {
            $tamanhoImg = filesize($nomeFinal);

            $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));
            // Linkar ao db
            $db = new db;
            $link = $db->connect_mysql();
            $sql = "INSERT INTO business(name, password, description, cnpj, logo) VALUES ('$name', '$password', '$description', '$cnpj', '$mysqlImg')";

            mysqli_query($link, $sql) or die("Erro ao registrar a empresa!");
            
            // unlink($nomeFinal);
            // header("location:exibir.php");
        } else {
            $db = new db;
            $link = $db->connect_mysql();
            $sql = "INSERT INTO business(name, password, description, cnpj) VALUES ('$name', '$password', '$description', '$cnpj')";

            mysqli_query($link, $sql) or die("Erro ao registrar a empresa!");
            header("location: loginEmpresa.html");
        }
    }
?>