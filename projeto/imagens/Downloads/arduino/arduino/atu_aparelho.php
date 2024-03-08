<?php
$permissao=@$_COOKIE['permissao'];

if($permissao == 1){

include 'conexao.php';
$id_aparelho=$_GET['id'];

$sql= $db -> prepare("SELECT nome_aparelho, relay from aparelho where id_aparelho=$id_aparelho");
$sql -> execute();
$sql -> bind_result($nome, $relay);
$sql -> fetch();
$sql -> close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastrar.css">
    <title>Atualiza Aparelho</title><link rel='shortcut icon' href='imagens/favicon_.ico' />
</head>

<body>
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
            </ul>
        </nav>
</div>
    <div class="box">
        
        <div class="img-box">
            <img src="imagens/logoprincipal.png">
        </div>
        <div class="form-box">
            <h2>Atualizar Aparelho</h2>
        
            <form action="atualizar.php?id=<?php echo $id_aparelho ?> " method= "POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="nome"> Nome do aparelho</label>
                    <input type="text" id="nome" placeholder="Nome completo" name='nome' required maxLength=50 value='<?php echo $nome ?>'>
                </div>

                <div class="input-group">
                    <label for="cod">Relay</label>
                    <input type="number" id="relay" placeholder="Relay" name='relay' required maxLength=10 value=<?php echo $relay ?>>
                </div>

                <div class="input-imag">
				    <label for="cod">Imagem</label>
                    <input name='arquivo' type='file' accept="image/*" placeholder="Imagem"><br>

                
                <div class="input-group">
                    <button type='submit' name='aparelho'>Cadastrar</button><a href=aparelho.php><button id="cancelar" type=button >Cancelar</button></a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>

<?php
if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='cad_aparelho.php'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Aparelho cadastrado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}
}else{
    header('location:index.php');
}
?>