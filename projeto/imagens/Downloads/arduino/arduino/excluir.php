<?php
include 'conexao.php';

$id_usuario = @$_GET['idu'];
$id_aparelho = @$_GET['ida'];

if(isset($id_usuario)){

    

    $sql = $db -> prepare('UPDATE usuario set usuario= null where id_usuario = ?');
    $sql -> bind_param('i',$id_usuario);
    $sql -> execute();

    header('location:usuario.php?c');
    
}elseif(isset($id_aparelho)){

    $sql = $db -> prepare('UPDATE aparelho set relay= null where id_aparelho = ?');
    $sql -> bind_param('i',$id_aparelho);
    $sql -> execute();

    header('location:aparelho.php?c');
}else{
    header('location:sair.php');
}

?>