<?php 

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}
if(!isset($_COOKIE['logado'])){
    header('location:sair.php');
    Die();
}

include 'conexao.php';
include 'consent.html';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - ADM</title>
    <meta charset="utf-8"/>

    <link rel='shortcut icon' href='imagens/favicon_.ico' />

    <link rel="stylesheet" type="text/css" href="css/principal.css">

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>
<?php

?>
<header>
    <a class=logo href=index.php><h2>Smart<span> Tech</span></h2></a>
    
    <nav>
        <ul>
            
            
            <li>
                <a href="#">Usuário</a>           
                <ul class="dropdown">

                    <li><a href="cad_usuario.php">Cadastrar</a></li>
                    <li><a href="usuario.php">Visualizar</a></li>

                </ul>
            </li>

            <li>
                <a href="#">Aparelhos</a>
                <ul class="dropdown">

                    <li><a href="cad_aparelho.php">Cadastrar</a></li>
                    <li><a href="aparelho.php">Visualizar</a></li>
                    
                </ul>
            </li>
                
            <li><a href="scheduling.php">Ação automatica</a></li>
                
            <li><a href="historico.php">Histórico</a></li>
                    
            <li><a href="sair.php">Sair</a></li>
        </ul>
    </nav>
</header>

<aside> 

    <h2>Aparelhos disponiveis</h2>
</aside>

<main>
    <?php
        $busca_aparelho = $db  -> query("SELECT id_aparelho, nome_aparelho, relay, img  FROM aparelho where ativo=1 ");
                    
        while($linha = $busca_aparelho ->fetch_array()){
            
            $id_aparelho=$linha['id_aparelho'];
            $nome_aparelho=$linha['nome_aparelho'];
            $relay=$linha['relay'];
            $img=$linha['img'];


            $busca_status = $db  -> query("SELECT operacao  FROM registro where id_aparelho_fk=$id_aparelho ORDER by id_registro desc limit 1");
            while($linha = $busca_status ->fetch_array()){
                $statu= $linha['operacao'];
            }

            if(empty($statu)){
                $statu=0;
            }

            $status= array(
                0=>'Desligado',
                1=>'Ligado'
            );

            $botao= array(
                0=>'Ligar',
                1=>'Desligar');

            
            echo '
            <div class="card">
                <img class="imagemicone" src="'.$img.'">
                
                <p>'.$nome_aparelho.'</p>

                Status do aparelho: '.$status[$statu].'

                
                <a  href="comando.php?id_apa='.$id_aparelho.'&statu='.$statu.'&relay='.$relay.'">

                    <button type=button>'.$botao[$statu].'</button>
                    
                </a>
                                
            </div>';
            unset($statu);
        }
    ?>

</main>

<aside>

    <a href="cad_aparelho.php">

        <button>Cadastrar aparelhos</button>
    </a>
</aside>

<footer>

    <h1>Smart<span> Tech</span></h1>

   Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

</footer>



</body>
</html>