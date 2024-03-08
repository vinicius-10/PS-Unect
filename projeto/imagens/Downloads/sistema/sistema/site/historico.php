<?php 
include 'consent.html';

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}

$id_usuario=$_COOKIE['logado'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - histórico</title>
    <meta charset="utf-8"/>

    <link rel='shortcut icon' href='imagens/favicon_.ico' />

    <link rel="stylesheet" type="text/css" href="css/historico.css">

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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

    <div class="box">
		
		<h2>Histórico</h2>
					
		<div id="conteudo"></div>
		<script>
			var qnt_result_pg = 6;
			var pagina = 1;
			$(document).ready(function () {
				List_Register(pagina, qnt_result_pg); 
			});
			
			function List_Register(pagina, qnt_result_pg){
				var dados = {
					pagina: pagina,
					qnt_result_pg: qnt_result_pg
				}
				$.post('List_Register.php', dados , function(retorna){
					$("#conteudo").html(retorna);
				});
			}
		</script>
	</div>
</main>


<footer>

<h1>Smart<span> Tech</span></h1>

Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

</footer>

</body>
</html>
