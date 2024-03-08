<?php
session_start();
$men = @$_SESSION['usuario'];
session_destroy();
include "conexao.php";
$permissao=@$_COOKIE['permissao'];

if($permissao == 1){

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastrar.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Cadastrar Usuário</title><link rel='shortcut icon' href='imagens/favicon_.ico' />
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
            <h2>Cadastrar Usuário</h2>
        
            <form action="cadastrar.php" method=POST>
                <div class="input-group">
                    <label for="nome"> Nome Completo</label>
                    <input type="text" id="nome" placeholder="Nome completo" required name=nome maxLength=100>
                </div>

                <div class="input-group">
                    <label for="email">Nome de usuario</label>
                    <input type="text" id="email" placeholder="Usuario" required name=usuario maxLength=50>
                    <p style="color:red"><?php echo $men; ?></p>
                </div>
                <div class="input-group">
                    <label for="email">Email <h5>(opcional)</h5></label>
                    <input type="text" id="email" placeholder="Email" name=email maxLength=256>

                </div>

				<div class="input-group">
                <label for="email">Aparelhos</label> </div>
                <div class="aparelhos">
                    
                    <?php
    
                        $sql = $db -> prepare('SELECT id_aparelho, nome_aparelho from aparelho where relay is not null');
                        $sql -> execute();
                        $sql -> bind_result($id_aparelho,$nome);
                        while($sql->fetch()){
                            Echo "
                            <div class=aparelho>
                            <input class='check' type=checkbox value='$id_aparelho' name='$id_aparelho'>$nome
                            </div>
                            ";
                        }

                        

                    ?>
             
                </div>
                <div class="visualiza">
                    <label for="email"><input class='check' type=checkbox value='3' name='visualiza' > Apenas visualizar</label>
                    
                    </div><br>
                
				

                <div class="input-group w50">
                    <label for="senha">Senha</label>
                    <input onkeyup="verifica_senha()" type="password" id="senha" placeholder="Senha" required name=senha maxLength=20>
                </div>

                <div class="input-group w50">
                    <label for="Confirmarsenha">Confirmar Senha</label>
                    <input type="password" onkeyup="verifica_senha()" id='confirmacao' placeholder="Confirme a senha" required>
                </div>

                <div class="input-group">
                    <button id="cadastrar" name=usu>Cadastrar</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
<script>


    function verifica_senha(){

        NovaSenha = document.getElementById('senha').value;
        CNovaSenha = document.getElementById('confirmacao').value;

        if(CNovaSenha!=''){

            if (NovaSenha != CNovaSenha) {
                const senha = document.querySelector("#confirmacao");
                const cadastrar = document.querySelector("#cadastrar");
                

                senha.style.border= 'solid 2px red';
                cadastrar.style.opacity = '0.2';
                cadastrar.disabled= true;
            }else{
                const cpf = document.querySelector("#confirmacao");
                const cadastrar = document.querySelector("#cadastrar");

                cpf.style.border= '0';
                cadastrar.style.opacity = '1';
                cadastrar.disabled= false;
            }
        }

    }
</script>

<?php
if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='cad_usuario.php'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Usuario cadastrado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}
}else{
    header('location:index.php');
}
?>