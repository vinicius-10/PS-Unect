<?php
session_start();
include 'conexao.php';

if (isset($_POST['aparelho'])){

    $nome= $_POST['nome'];
    $relay= $_POST['relay'];

    $ext=pathinfo($_FILES['arquivo']['name'],PATHINFO_EXTENSION);
    $novoNome="./imagens_aparelhos/".uniqid().".$ext";

    
    if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $novoNome)){

        $sql = $db -> prepare("INSERT INTO aparelho values (null, ?,?,? )");
        $sql -> bind_param('sis',$nome, $relay,$novoNome);
        $sql -> execute();

    }else{

        $sql = $db -> prepare("INSERT INTO aparelho values (null, ?,?, './imagens_aparelhos/sem_imagen.png' )");
        $sql -> bind_param('si',$nome, $relay);
        $sql -> execute();
    }
    header('location:cad_aparelho.php?c');
}elseif(isset($_POST['usu'])){
    $nome=$_POST['nome'];
    $senha=$_POST['senha'];
    $usuario=$_POST['usuario'];
    $email=@$_POST['email']?$_POST['email']: null;
    $nivel=@$_POST['visualiza']? $_POST['visualiza'] : 2;

    $sql = $db -> prepare("SELECT id_usuario from usuario where usuario='$usuario'");
    $sql -> execute();
    $sql -> bind_result($id_usuario);
    $sql -> fetch();
    $sql -> close();


    
    if(!isset($id_usuario)){

        $insert = $db2 -> prepare("INSERT INTO usuario values (null, ?,?,?,?,?)");
        $insert -> bind_param('ssssi',$nome, $email ,$usuario, $senha, $nivel);
        $insert -> execute();

        $sql = $db -> prepare("SELECT id_usuario from usuario where usuario='$usuario'");
        $sql -> execute();
        $sql -> bind_result($id_usuario);
        $sql -> fetch();
        $sql -> close();

        $sql = $db -> prepare("SELECT id_aparelho from aparelho");
        $sql -> execute();
        $sql-> bind_result($id_aparelho );

        $comando = 'INSERT INTO usuario_aparelho VALUES';

        while($sql ->fetch()){
            if(isset($_POST["$id_aparelho"])){
                $controle=1;
                $comando=$comando." ($id_usuario,$id_aparelho),";

            }
        }
        if (isset($controle)){
        $comando = substr($comando, 0, -1);
        $sql = $db -> prepare("$comando");

        $sql -> execute();
        }
        
        header('location:cad_usuario.php?c');
    }else{
        echo "<script>window.history.back()</script>";
        $_SESSION['usuario']='Nome de usuario já cadastrado.';
    }

    
    

}else{
    header("location:index.php");
}

?>

