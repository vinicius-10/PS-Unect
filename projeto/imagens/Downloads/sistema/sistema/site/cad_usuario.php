<?php 
session_start();
$men = @$_SESSION['usuario'];
session_destroy();


include 'conexao.php';
include 'consent.html';

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}


if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='cad_usuario.php'><img class= fechar src=./imagens/fechar.png ></a> <div class='mensagem'>Usuaio cadastrado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - Cadastro de usuarios</title>
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

        <h2>Cadastrar Usuário</h2>
        
        
        <form action="cadastrar.php" method=POST>
            <div class="field">
                <label for="nome"> Nome Completo*</label>
                <input type="text" id="nome" placeholder="Nome completo" required name=name maxLength=100>
            </div>

            <div class="field"><label for="email">Nome de usuario/apelido* <b class='keep'>Nome que será usado para fazer login.</b></label>
                
                <input type="text" id="email" placeholder="Usuario" required name=usuario maxLength=50>
                <p class= "men"><?php echo $men; ?></p>
            </div>

            <div class="field">
                <label for="email">Email <b class='keep'>Adicione um email para receber notificação quando o status do aparelho mudar.</b></label>
                <input type="text" id="email" placeholder="Email" name=email maxLength=256>

            </div>
            
            <div class="view">
                <label for="adm"><input class='check' type=checkbox  name='adm' id="adm" >Administrador <b class='keep'>Não é preciso selecionar os aparelhos para administradores</b></label>
                
            </div>
            <div class="field">
            <label for="email">Aparelhos:</label> </div>
            <div class="aparelhos">

            <?php
    
                $sql = $db -> prepare('SELECT id_aparelho, nome_aparelho from aparelho where ativo = 1');
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
            <div class="view">
                <label for="view"><input class='check' type=checkbox value='3' name='view' id="view" > Apenas visualizar os aparelhos selecionados</label>
                
            </div>

            
            
                
            <div class="field">
                <label for="senha">Senha*</label>
                <input onkeyup="verifica_senha()" type="password" id="senha" placeholder="Senha" required name='password' maxLength=20>
            </div>

            <div class="field">
                <label for="Confirmarsenha">Confirmar Senha*</label>
                <input type="password" onkeyup="verifica_senha()" id='confirmacao' placeholder="Confirme a senha" required>
                <p class= "men" id='men'></p>
            </div>

            <div class="field">
                <b class='keep'>Os campos com * são obrigratorios.</b>
                <button id="cadastrar" name=usu >Cadastrar</button>
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


    function verifica_senha(){

        password = document.getElementById('senha').value;
        ConfirmationPassword = document.getElementById('confirmacao').value;
        

        if(ConfirmationPassword!=''){
            const confirmation = document.querySelector("#confirmacao");
            const cadastrar = document.querySelector("#cadastrar");
            const message = document.querySelector("#men");

            if (password != ConfirmationPassword) {
                confirmation.style.border= 'solid 2px red';
                message.innerHTML= "Senhas diferentes"

            }else{
                confirmation.style.border= '0';
                cadastrar.style.opacity = '1';
                cadastrar.disabled= false;
                message.innerHTML= ""
            }
        }else{
            cadastrar.style.opacity = '0.2';
            cadastrar.disabled= true;
        }

    }
    verifica_senha();
</script>