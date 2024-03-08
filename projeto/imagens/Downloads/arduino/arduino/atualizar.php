<?php
include 'conexao.php';


if (isset($_POST['aparelho'])){

    $id=$_GET['id'];
    $nome= $_POST['nome'];
    $relay= $_POST['relay'];

    $ext=pathinfo($_FILES['arquivo']['name'],PATHINFO_EXTENSION);
    $novoNome="./imagens_aparelhos/".uniqid().".$ext";

    
    if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $novoNome)){

        $sql = $db -> prepare("UPDATE aparelho set nome_aparelho=?, relay=?, img=? where id_aparelho=?");
        $sql -> bind_param('sisi',$nome, $relay,$novoNome,$id);
        $sql -> execute();

    }else{

        $sql = $db -> prepare("UPDATE aparelho set nome_aparelho=?, relay=? where id_aparelho=?");
        $sql -> bind_param('sii',$nome, $relay,$id);
        $sql -> execute();
    }
     header('location:cad_aparelho.php?c');

}elseif(isset($_POST['usu'])){

    #variaeis
    $aparelhos=[];
    $id_usuario=$_GET['id'];
    $nome=$_POST['nome'];
    $senha=$_POST['senha'];
    $usuario=$_POST['usuario'];
    $email=@$_POST['email']?$_POST['email']: null;
    $nivel=@!$_POST['visualiza']? 2 : $_POST['visualiza'];

    $insert = $db2 -> prepare("UPDATE usuario set nome_usuario=?, email=?,usuario=?,senha=?,permissao=? where id_usuario=?");
    $insert -> bind_param('ssssii',$nome,$email, $usuario, $senha,$nivel,$id_usuario);
    $insert -> execute();

    $sql = $db -> prepare("SELECT id_aparelho_fk from usuario_aparelho where id_usuario_fk=$id_usuario");
    $sql -> execute();
    $sql-> bind_result($id_apara);
    while($sql ->fetch()){
        array_push($aparelhos, $id_apara);
    }


    $sql = $db -> prepare("SELECT id_aparelho from aparelho");
    $sql -> execute();
    $sql-> bind_result($id_aparelho );

    print_r($aparelhos);

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
    print_r($aparelhos);

    if (isset($controle)){
        $comando = substr($comando, 0, -1);
        echo $comando;
        $sql = $db -> prepare("$comando");
        $sql -> execute();
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