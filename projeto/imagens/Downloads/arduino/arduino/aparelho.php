<?php

$p=$_COOKIE['permissao'];
if($p!=1){
	header('location:sair.php');
	Die();
}
include 'conexao.php';
$id=$_COOKIE['logado'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ver Usuários</title><link rel='shortcut icon' href='imagens/favicon_.ico' />
	<link rel="stylesheet" type="text/css" href="css/atualiza.css">

	<link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
	
	<!----hero Section start---->
<div class="menu" >
		<nav>
		<a id=logo href=index.php><h2 class="logo">Smart<span> Tech</span></h2></a>
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
			<ul>
        
    </ul>
  
  
			</ul>
			
		</nav>
	

	

	<!-----service section start----------->
	<div class="service">
		<div class="title">
			<h2>Aparelhos</h2>
		</div>
<br><br><br><br>
		<div class="box">
			
				<?php
					
					$Query_usu = $db -> query("SELECT id_aparelho, nome_aparelho, relay  from aparelho where relay is not null ORDER BY nome_aparelho ");
					while($row = $Query_usu -> fetch_array()){
						$id_aparelho = $row['id_aparelho'];
						$nome = $row['nome_aparelho'];
						$relay = $row['relay'];
						
						

						
						echo "
						<div class='card_a'>
					
							<br><br>
							<h5>$nome</h5>
							
							<div class='pra'>
							<ul class='listaaparelhos'>
								relay: $relay
						
							</ul>
									
								<p style='text-align: center;'>
									<br>
									<a class='button' href='atu_aparelho.php?id=$id_aparelho'>Editar</a>
					
									<a class='button' href='excluir.php?ida=$id_aparelho'>Excluir</a>
								</p>
							</div>
						</div>
						";
					}

				?>
		</div>
	</div>
	<?php 
	if(isset($_GET['c'])){
		echo "    <div class='popup' > <a href='aparelho.php'><img class= fechar src=./imagens/fechar.png  width='30px'></a> <div class='mensagem'>Aparelho excluido com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
	}elseif(isset($_GET['a'])){
		echo "    <div class='popup' > <a href='aparelho.php'><img class= fechar src=./imagens/fechar.png  width='30px'></a> <div class='mensagem'>Aparelho atualizado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
	}
	?>
</body>
</html>