<?php 

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}

include 'conexao.php';
include "consent.html";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - Atualizar aparelho</title>
    <meta charset="utf-8"/>

    <link rel='shortcut icon' href='imagens/favicon_.ico' />

    <link rel="stylesheet" type="text/css" href="css/list.css">

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>


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

<main>
    <?php
					
        $Query_usu = $db -> query("SELECT id_aparelho, nome_aparelho, relay  from aparelho where ativo='1' ORDER BY nome_aparelho ");
        while($row = $Query_usu -> fetch_array()){
            $id_aparelho = $row['id_aparelho'];
            $nome = $row['nome_aparelho'];
            $relay = $row['relay'];
            
            

            
            echo "
            <div class='BoxAppliances'>
                <h2>$nome</h2>
                    
                <p>relay: $relay</p>
                            
                <div class='button'>

                    <a href='atu_aparelho.php?id=$id_aparelho'>
                        <button>
                        Atualizar
                        </button>
                    </a>

                    <a href='excluir.php?ida=$id_aparelho'>

                        <button>
                        Excluir
                        </button>
                    </a>
                </div>      
            </div>
            ";
        }

    ?>

</main>


<footer>

<h1>Smart<span> Tech</span></h1>

Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

    </footer>

</body>
</html>
