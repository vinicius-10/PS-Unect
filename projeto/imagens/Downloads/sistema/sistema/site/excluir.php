<?php
$permissao=@$_COOKIE['permissao'];
if($permissao != 1){
    header('location:sair.php');
    Die();
}
include 'conexao.php';

$id_usuario = @$_GET['idu'];
$id_aparelho = @$_GET['ida'];
$id_action=@$_GET['idac'];

if(isset($id_usuario)){

    $admQuery = $db -> prepare('SELECT id_usuario from usuario where id_usuario != ? and permissao=1 and ativo =1');
    $admQuery -> execute([$id_usuario]);
    $admQuery -> bind_result($id_adm);
    $admQuery -> fetch();
    $admQuery -> close();

    if (empty($id_adm)){
        header('location:usuario.php?men');
        Die();
    }

    $delet= $db -> prepare('DELETE FROM usuario_aparelho where id_usuario_fk=? ');
    $delet -> execute([$id_usuario]);
    $delet -> close();

    $regQuery = $db -> prepare('SELECT id_registro from registro where id_usuario_fk=? limit 1');
    $regQuery -> execute([$id_usuario]);
    $regQuery -> bind_result($register);
    $regQuery -> fetch();
    $regQuery -> close();
    
    if(empty($register)){
        $deletAppliances = $db -> prepare('DELETE FROM usuario where id_usuario=?');
        $deletAppliances -> execute([$id_usuario]);

    }else{

        $sql = $db -> prepare('UPDATE usuario set usuario= null, ativo=0 where id_usuario = ?');
        $sql -> bind_param('i',$id_usuario);
        $sql -> execute();
    }

    if($id_usuario==$_COOKIE['logado']){
        header("location:sair.php");
    }else{
    
        header('location:usuario.php?c');
    }
    
}elseif(isset($id_aparelho)){

    $delet= $db -> prepare('DELETE FROM usuario_aparelho where id_aparelho_fk=? ');
    $delet -> execute([$id_aparelho]);
    $delet -> close();

    $imgQuery = $db -> prepare('SELECT img from aparelho where id_aparelho=?');
    $imgQuery -> execute([$id_aparelho]);
    $imgQuery -> bind_result($img);
    $imgQuery -> fetch();
    $imgQuery -> close();
    unlink($img);
    
    $regQuery = $db -> prepare('SELECT id_registro from registro where id_aparelho_fk=? limit 1');
    $regQuery -> execute([$id_aparelho]);
    $regQuery -> bind_result($register);
    $regQuery -> fetch();
    $regQuery -> close();
    
    if(empty($register)){

        $deletAppliances = $db -> prepare('DELETE FROM aparelho where id_aparelho=?');
        $deletAppliances -> execute([$id_aparelho]);

    }else{

        $sql = $db -> prepare('UPDATE aparelho set ativo=0 where id_aparelho = ?');
        $sql -> execute([$id_aparelho]);
    }

    header('location:aparelho.php?c');
}elseif(isset($id_action)){

    $del = $db -> prepare('DELETE from automatic_action where id_action=?');
    $del -> execute([$id_action]);
    header('location:scheduling.php?d');

}else{
    header('location:sair.php');
}

?>