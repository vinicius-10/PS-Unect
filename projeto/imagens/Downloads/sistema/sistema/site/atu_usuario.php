<?php
include "conexao.php";
include "consent.html";

$permissao=@$_COOKIE['permissao'];
$id_usuario=$_GET['id'];
$aparelhos=[];

if($permissao != 1){
    header('location:sair.php');
    die();
}


$sql = $db -> prepare("SELECT nome_usuario,email, usuario, senha, permissao from usuario where id_usuario=$id_usuario");
$sql -> execute();
$sql -> bind_result($nome, $email,$usuario,$senha, $tipo);
$sql -> fetch();
$sql -> close();

$view = @$tipo == 3? 'checked' : '';

$adm = @$tipo == 1? 'checked' : '';

$sql = $db -> prepare("SELECT id_aparelho_fk from usuario_aparelho where id_usuario_fk=$id_usuario");
$sql -> execute();
$sql -> bind_result($id_apara);
while($sql -> fetch()){
    array_push($aparelhos, $id_apara);
}

if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='atu_usuario.php?id=$id_usuario'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Usuario atualizado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - Atualizar de usuarios</title>
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

        <h2>Atualizar Usuário</h2>
        
        
        <form action="atualizar.php?id=<?php echo $_GET['id']; ?>" method=POST>
            <div class="field">
                <label for="nome"> Nome Completo*</label>
                <input type="text" id="nome" placeholder="Nome completo" required name=nome value=<?php echo $nome ?>>
            </div>

            <div class="field">
                <label for="email">Nome de usuario/apelido* <b class='keep'>Nome que será usado para fazer login.</b></label>
                <input type="text" id="email" placeholder="Usuario" required name=usuario value=<?php echo $usuario ?>>
                
            </div>
            <div class="field">
                <label for="email">Email <b class='keep'>Adicione um email para receber notificação quando o status do aparelho mudar.</b></label>
                <input type="text" id="email" placeholder="Email" name=email value=<?php echo $email ?>>

            </div>
            <div class="view">
                <label for="adm"><input class='check' type=checkbox  name='adm' id="adm"  <?php echo $adm ?> >Administrador <b class='keep'>Não é preciso selecionar os aparelhos para administradores</b></label>
                
            </div>
            <div class="field">
            <label for="email">Aparelhos</label> </div>
            <div class="aparelhos">
                
                <?php

                    $sql = $db -> prepare('SELECT id_aparelho, nome_aparelho from aparelho where ativo=1');
                    $sql -> execute();
                    $sql -> bind_result($id_aparelho,$nome);
                    while($sql->fetch()){

                        if(array_search($id_aparelho, $aparelhos) !== false){
                            $selecionado= 'checked';
                            
                        }else{
                            $selecionado ="";
                        }
                        Echo "
                        <div class=aparelho>
                        <input class='check' type=checkbox value='$id_aparelho' name='$id_aparelho' $selecionado >$nome
                        </div>
                        ";
                    }

                    

                ?>
         
            </div>
            <div class="view">
                <label for="view"><input class='check' type=checkbox value='3' name='view' id="view" <?php echo $view ?>  > Apenas visualizar</label>
                
                </div><br>
            

            <div class="field">
                <label for="senha">Senha</label>
                <input onkeyup="verifica_senha()" type="text" id="senha" placeholder="Senha" required name=senha value=<?php echo $senha ?>>
            </div>

            <div class="field">
                <label for="Confirmarsenha">Confirmar Senha</label>
                <input type="text" onkeyup="verifica_senha()" id='confirmacao' placeholder="Confirme a senha" required value=<?php echo $senha ?>>
            </div>

            <div class="field">
                <button id="cadastrar" name=usu>Atualizar</button><a href=usuario.php><button id="cancelar" type=button>Cancelar</button></a>
            </div>

        </form>
    </div>

</main>


<footer>

    <h1>Smart<span> Tech</span></h1>

   Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

</footer

</body>
</html>