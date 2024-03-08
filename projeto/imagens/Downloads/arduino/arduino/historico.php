<!DOCTYPE html>

<html lang="pt-BR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Registro</title><link rel='shortcut icon' href='imagens/favicon_.ico' />
	<link rel="stylesheet" type="text/css" href="css/historico_.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
	
<nav>
	<a id=logo href=index.php><h2 class="logo">
		Smart<span> Tech</span></h2>
	</a>
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
			<li><a href="historico.php">Histórico</a></li>
			
			<li><a href="sair.php">Sair</a></li>
	</ul>
	</nav>


<div class="box">	
	<div class="card">
		
		<h5>Histórico</h5>
					
		<div id="conteudo"></div>
		<script>
			var qnt_result_pg = 9; //quantidade de registro por página
			var pagina = 1; //página inicial
			$(document).ready(function () {
				listar_usuario(pagina, qnt_result_pg); //Chamar a função para listar os registros
			});
			
			function listar_usuario(pagina, qnt_result_pg){
				var dados = {
					pagina: pagina,
					qnt_result_pg: qnt_result_pg
				}
				$.post('listar_usuario.php', dados , function(retorna){
					//Subtitui o valor no seletor id="conteudo"
					$("#conteudo").html(retorna);
				});
			}
		</script>
	</div>
																
</div>

</body>
</html>