<?php 

$permissao=@$_COOKIE['permissao'];

$permisoes= [2,3];

if(!in_array($permissao,$permisoes)){
    header('location:sair.php');
    Die();

}
if(!isset($_COOKIE['logado'])){
    header('location:sair.php');
    Die();
}

$id_usuario=$_COOKIE['logado'];

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


<header>
    <a class=logo href=index.php><h2>Smart<span> Tech</span></h2></a>
    
    <nav>
        <ul>
                    
            <li><a href="sair.php">Sair</a></li>
        </ul>
    </nav>
</header>
<article>

    <img class="imagem" src="imagens/logoprincipal.png">
    
    <img class="imagemprincipal" src="imagens/principal.png">

</article>

<aside> 

    <h2>Aparelhos disponiveis</h2>
</aside>

<main>
<?php
        $busca_aparelho = $db  -> query("SELECT id_aparelho, nome_aparelho, relay, img  FROM aparelho where id_usuario_fk=$id_usuario and relay is not null ");
                    
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

                    <button>'.$botao[$statu].'</button>
                    
                </a>
                                
            </div>';
            unset($statu);
        }
    ?>

    <div class='card'>
        <img class='imagemicone' src='imagens/principal.png'>
        
        <p>$nome_aparelho</p>

        Status do aparelho: Desligado

        
        <a  href='comando.php?id_apa=$id_aparelho&statu=$statu&relay=$relay'>

            <button>Ligar</button>
            
        </a>
        
        
    </div>

</main>

<footer>

    <h1>Smart<span> Tech</span></h1>

   Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

</footer>



</body>
</html>