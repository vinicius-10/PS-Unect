<?php
session_start();

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}

$ativo= 1;

include 'conexao.php';

if (isset($_POST['aparelho'])){

    $nome= $_POST['nome'];
    $relay= $_POST['relay'];

    
    $ext=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $novoNome="./imagens_aparelhos/".uniqid().".$ext";
    move_uploaded_file($_FILES['file']['tmp_name'], $novoNome);

    $sql = $db -> prepare("INSERT INTO aparelho values (null,?,?,?,? )");
    $sql -> bind_param('isis',$ativo,$nome, $relay,$novoNome);
    $sql -> execute();

    
    header('location:cad_aparelho.php?c');

}elseif(isset($_POST['usu'])){
    $nome=$_POST['name'];
    $senha=$_POST['password'];
    $usuario=$_POST['usuario'];
    $email=@$_POST['email']?$_POST['email']: null;
    $nivel=@$_POST['view']? 3 : 2;
    $nivel =@$_POST['adm']? 1 : $nivel;

    
    $sql = $db -> prepare("SELECT id_usuario from usuario where usuario='$usuario'");
    $sql -> execute();
    $sql -> bind_result($id_usuario);
    $sql -> fetch();
    $sql -> close();
    
    if(isset($id_usuario)){
        echo "<script>window.history.back()</script>";
        $_SESSION['usuario']='Nome de usuario já cadastrado.';
        Die();

    }

    $insert = $db2 -> prepare("INSERT INTO usuario values (null,?,?,?,?,?,?)");
    $insert -> execute([$ativo,$nome, $email ,$usuario, $senha, $nivel]);

    $sql = $db -> prepare("SELECT id_usuario from usuario where usuario=?");
    $sql -> execute([$usuario]);
    $sql -> bind_result($id_usuario);
    $sql -> fetch(); 
    $sql -> close();

    $sql = $db -> prepare("SELECT id_aparelho from aparelho");
    $sql -> execute();
    $sql-> bind_result($id_aparelho );
    
    if($nivel !=1){

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
    }
    
    header('location:cad_usuario.php?c');

}elseif(isset($_POST['acao'])){
    $time = $_POST['time'];
    $appliances = $_POST['app'];
    $action=$_POST['action'];
    $repeat=$_POST['repeat'];
    $start=@$_POST['start'];
    $end=@$_POST['end'];

    $insert = $db2 -> prepare("INSERT INTO automatic_action values (null,?,1,?,?,?,?,?,?)");

    if($repeat=='no'){
        date_default_timezone_set("America/Sao_Paulo");

        if(strtotime($time) < strtotime(date("H:i"))){
            $day=date("Y-m-d",strtotime(date("Y-m-d")."+1 day"));
        }else{
            $day=date("Y-m-d");
        }

        $insert -> execute([$appliances,$time, $action ,$repeat, $day,null,null]);

    }elseif($repeat=='period'){
        $insert -> execute([$appliances,$time, $action ,$repeat, $start,$end,null]);

    }elseif($repeat=='weekly'){
        $weekly='';
        for($i = 1; $i<=7;$i++){           
            $day=@$_POST[$i];
            $weekly=$weekly.$day;
        }
        $insert -> execute([$appliances,$time, $action ,$repeat, null,null,$weekly]);
    }else{
        header("location:index.php");
        Die();
    } 
    header("location:scheduling.php?c");

}else{
    header("location:index.php");
}

?>

