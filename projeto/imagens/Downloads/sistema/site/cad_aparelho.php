<?php 
include 'consent.html';

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}
if(!isset($_COOKIE['logado'])){
    header('location:sair.php');
    Die();
}



if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='cad_aparelho.php'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Aparelho cadastrado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - Cadastro de aparelho</title>
    <meta charset="utf-8"/>

    <link rel='shortcut icon' href='imagens/favicon_.ico' />

    <link rel="stylesheet" type="text/css" href="css/register.css">

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

    <div class="img">

        <img src="imagens/logoprincipal.png">
    </div>

    <div class="from">

        <h2>Cadastrar Aparelho</h2>
        
        
        <form action="cadastrar.php" method= "POST" enctype="multipart/form-data">

            <div class="field">
                <label for="nome"> Nome</label>
                <input type="text" id="nome" placeholder="Nome" name='nome' required maxLength=50>
            </div>

            <div class="field">
                <label for="relay">Relay</label>
                <input type="number" id="relay" placeholder="Relay" name='relay' required maxLength=10>
            </div>

            <div class="image">
                <label for="file" class="file">Selecione a imagem</label>
                <input type='file' id='file' name='file' accept="image/*" placeholder="Imagem" required><br>
            
                <img src="" id="image" >
            </div>
            
            <div class="field">
                <button type='submit' name='aparelho' mousehover >Cadastrar</button>

            </div>
</form>
</div>

</main>


<footer>

<h1>Smart<span> Tech</span></h1>

Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

</footer>

</body>
</html>

<script> 
    const imgMeme = document.querySelector('#image');
    const memeInput = document.querySelector('#file');
    
    memeInput.addEventListener('change', function(evt) {
      if (!(evt.target && evt.target.files && evt.target.files.length > 0)) {
        return;
      }
    
      var r = new FileReader();
      r.onload = function() {
         imgMeme.src = r.result;
      }
      r.readAsDataURL(evt.target.files[0]);
      
    })
</script>