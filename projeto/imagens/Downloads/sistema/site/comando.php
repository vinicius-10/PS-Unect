<?php 
include 'conexao.php';
date_default_timezone_set("America/Sao_Paulo");
$permissao=@$_COOKIE['permissao'];

if($permissao == 2 or $permissao == 1 ){

    $id_usuario=$_COOKIE['logado'];
    $id_aparelho=@$_GET['id_apa'];
    $statu=@$_GET['statu'];
    $relay=@$_GET['relay'];
    $dia=date("Y-m-d");
    $hora=date("H:i");

    $operacao= array(
        0=>1,
        1=>0
    );

    $comando= array(
        0=>'on',
        1=>'off'
    );

    $acao= array(
        1=>'desligado',
        0=>'ligado'
    );

    $sql = $db -> prepare("SELECT email from usuario where id_usuario=?");
    $sql -> bind_param("i",$id_usuario );
    $sql -> execute();
    $sql -> bind_result($email);
    $sql -> fetch();
    $sql -> close();

    $sql = $db -> prepare("INSERT into registro values(null,?,?,?,?,?)");
    $sql -> bind_param("ssiss",$id_usuario,$id_aparelho,$operacao[$statu],$hora,$dia );
    $sql -> execute();

    
'
    $pagina= "192.168.0.103/?relay$relay=$comando[$statu]";
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $pagina);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $retorno= curl_exec( $ch);
    curl_close($ch);
    ';
    

    header("location:index.php");
    if(!empty($email)){
        shell_exec("python notifica.py $id_aparelho $email $acao[$statu] usu");
    }
    
}else{
    header("location:sair.php");
}

?>