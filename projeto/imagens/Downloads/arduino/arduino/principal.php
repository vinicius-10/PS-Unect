<!DOCTYPE html>
<html>
<head>
	<title>Principal</title><link rel='shortcut icon' href='imagens/favicon_.ico' />
	<link rel="stylesheet" type="text/css" href="css/principal.css">

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
			
				
				
				
				
				
				<li><a href="sair.php">Sair</a></li>

			
			</ul>
		</nav>
</div>
<div class="hero">

		<img class="imagemprincipal" src="imagens/principal.png"> </img>

	<div class="content">
	
		<img class="imagem" src="imagens/logoprincipal.png"> </img>
		<div class="newslatter">
			
		</div>
		
	</div>
</div>

	

	<!-----service section start----------->
	<div class="service">
		<div class="title">
			<h2>Nossos Serviços</h2>
		</div>

	
<br><br><br>
		<div class="box">

			<?php
			include "conexao.php";
			$permissao=@$_COOKIE['permissao'];

			if($permissao == 2 or $permissao == 3 ){
				$id_usuario=@$_COOKIE['logado'];

				if($id_usuario==1){
					$busca_aparelho = $db  -> query("SELECT A.id_aparelho, A.nome_aparelho, A.relay, A.img  FROM aparelho A");
				
				}else{
					$busca_aparelho = $db  -> query("SELECT A.id_aparelho, A.nome_aparelho, A.relay, A.img  FROM usuario_aparelho U, aparelho A where U.id_usuario_fk=$id_usuario and U.id_aparelho_fk=A.id_aparelho ");
				
				}

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
					if($permissao == 3){
						$botao='';
					}else{
						$botao="<a class='button' href='comando.php?id_apa=$id_aparelho&statu=$statu&relay=$relay'>{$botao[$statu]}</a>";
					}

					
					echo "
					<div class='card'>
							<img class='imagemicone' src='$img'> </img>
							<br><br>
							<h5>$nome_aparelho</h5>
							<div class='pra'>
								<p>Status do aparelho: {$status[$statu]}</p>

								<p style='text-align: center;'>
									<br><br><br>
									$botao
								</p>
							</div>
						</div>
						
					";
				}
			}else{

				header("location:index.php");
				setcookie('logado', '', time()-3600);
			}
			?>

			
		</div>
	</div>

	
	<!------footer start--------->
	<footer>
		<h2 class="logo">Smart<span> Tech</span></h2>
		
		<p><br> Contrate nossos serviços para ter mais <br>praticidade no seu dia a dia.</p>
		<div class="social">
			<a href="#"><i class="fab fa-facebook-f"></i></a>
			<a href="#"><i class="fab fa-instagram"></i></a>
			<a href="#"><i class="fab fa-whatsapp"></i></a>
		</div>
		<p class="end">Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.</p>
	</footer>
</body>
</html>