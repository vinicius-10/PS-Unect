<?php
$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}

include 'conexao.php';


if (isset($_POST['aparelho'])){

    $id_aparelho=$_GET['id'];
    $nome= $_POST['nome'];
    $relay= $_POST['relay'];

    $ext=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $novoNome="./imagens_aparelhos/".uniqid().".$ext";

    
    if(move_uploaded_file($_FILES['file']['tmp_name'], $novoNome)){
        $imgQuery = $db -> prepare('SELECT img from aparelho where id_aparelho=?');
        $imgQuery -> execute([$id_aparelho]);
        $imgQuery -> bind_result($img);
        $imgQuery -> fetch();
        $imgQuery -> close();

        unlink($img);

        $sql = $db -> prepare("UPDATE aparelho set nome_aparelho=?, relay=?, img=? where id_aparelho=?");
        $sql -> execute([$nome, $relay,$novoNome,$id_aparelho]);

    }else{

        $sql = $db -> prepare("UPDATE aparelho set nome_aparelho=?, relay=? where id_aparelho=?");
        $sql -> execute([$nome, $relay,$id]);
    }
    header("location:atu_aparelho.php?id=$id_aparelho&c");

}elseif(isset($_POST['usu'])){

    $aparelhos=[];
    $id_usuario=$_GET['id'];
    $nome=$_POST['nome'];
    $senha=$_POST['senha'];
    $usuario=$_POST['usuario'];
    $email=@$_POST['email']?$_POST['email']: null;
    $nivel=@$_POST['view']? 3 : 2;
    $nivel =@$_POST['adm']? 1 : $nivel;

    $admQuery = $db -> prepare('SELECT id_usuario from usuario where id_usuario != ? and permissao=1 and ativo =1');
    $admQuery -> execute([$id_usuario]);
    $admQuery -> bind_result($id_adm);
    $admQuery -> fetch();
    $admQuery -> close();

    if (empty($id_adm)){

        if($nivel!=1){
            header('location:usuario.php?men2');
            Die();
        }
    }

    $insert = $db2 -> prepare("UPDATE usuario set nome_usuario=?, email=?,usuario=?,senha=?,permissao=? where id_usuario=?");
    $insert -> execute([$nome,$email, $usuario, $senha,$nivel,$id_usuario]);

    $sql = $db -> prepare("SELECT id_aparelho_fk from usuario_aparelho where id_usuario_fk=$id_usuario");
    $sql -> execute();
    $sql-> bind_result($id_apara);
    while($sql ->fetch()){
        array_push($aparelhos, $id_apara);
    }


    if( $nivel != 1 ){

        $sql = $db -> prepare("SELECT id_aparelho from aparelho");
        $sql -> execute();
        $sql-> bind_result($id_aparelho );

        $comando = 'INSERT INTO usuario_aparelho VALUES';

        while($sql ->fetch()){

            $id_apa_formulario=@$_POST["$id_aparelho"];
            
            if(isset($id_apa_formulario)){

                if(array_search($id_apa_formulario, $aparelhos) !== false){

                    unset($aparelhos[array_search($id_apa_formulario, $aparelhos)]);

                }else{
                    $controle=1;
                    $comando=$comando." ($id_usuario,$id_aparelho),";
                }
            }
        }

        if (isset($controle)){
            $comando = substr($comando, 0, -1);
            echo $comando;
            $insert = $db -> prepare("$comando");
            $insert -> execute();
        }
    }

    $excluir = "DELETE from usuario_aparelho WHERE id_usuario_fk = $id_usuario and id_aparelho_fk = ";
    foreach($aparelhos as $aparelho){
        if (!isset($control)){
            $excluir = $excluir."$aparelho";
            $control=1;

        }else{
            $excluir = $excluir." or id_aparelho_fk=$aparelho ";
        }
    }
    if (isset($control)){
        echo "$excluir";
        $sql = $db -> prepare("$excluir");
        $sql -> execute();
    }

    header("location:atu_usuario.php?id=$id_usuario&c");

}else{
    header('location:sair.php');
}
?>