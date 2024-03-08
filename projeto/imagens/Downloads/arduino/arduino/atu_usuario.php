<?php

include "conexao.php";
$permissao=@$_COOKIE['permissao'];
$id_usuario=$_GET['id'];
$aparelhos=[];

if($permissao != 1){
    header('location:sair.php');
    die();
}

#buscar os dados do ususuario
$sql = $db -> prepare("SELECT nome_usuario,email, usuario, senha, permissao from usuario where id_usuario=$id_usuario");
$sql -> execute();
$sql -> bind_result($nome, $email,$usuario,$senha, $tipo);
$sql -> fetch();
$sql -> close();

$tipo = @$tipo == 3? 'checked' : '';

$sql = $db -> prepare("SELECT id_aparelho_fk from usuario_aparelho where id_usuario_fk=$id_usuario");
$sql -> execute();
$sql -> bind_result($id_apara);
while($sql -> fetch()){
    array_push($aparelhos, $id_apara);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastrar.css">
    <title>Atualizar Usuário</title><link rel='shortcut icon' href='imagens/favicon_.ico' />
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
            <h2>Atualizar Usuário</h2>
        
            <form action="atualizar.php?id=<?php echo $_GET['id']; ?>" method=POST>
                <div class="input-group">
                    <label for="nome"> Nome Completo</label>
                    <input type="text" id="nome" placeholder="Nome completo" required name=nome value=<?php echo $nome ?>>
                </div>

                <div class="input-group">
                    <label for="email">Nome de usuario</label>
                    <input type="text" id="email" placeholder="Usuario" required name=usuario value=<?php echo $usuario ?>>
                    
                </div>
                <div class="input-group">
                    <label for="email">Email <h5>(opcional)</h5></label>
                    <input type="text" id="email" placeholder="Email" name=email value=<?php echo $email ?>>

                </div>
				<div class="input-group">
                <label for="email">Aparelhos</label> </div>
                <div class="aparelhos">
                    
                    <?php
    
                        $sql = $db -> prepare('SELECT id_aparelho, nome_aparelho from aparelho where relay is not null');
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
                <div class="visualiza">
                    <label for="email"><input class='check' type=checkbox value='3' name='visualiza' <?php echo $tipo ?>  > Apenas visualizar</label>
                    
                    </div><br>
				

                <div class="input-group w50">
                    <label for="senha">Senha</label>
                    <input onkeyup="verifica_senha()" type="text" id="senha" placeholder="Senha" required name=senha value=<?php echo $senha ?>>
                </div>

                <div class="input-group w50">
                    <label for="Confirmarsenha">Confirmar Senha</label>
                    <input type="text" onkeyup="verifica_senha()" id='confirmacao' placeholder="Confirme a senha" required value=<?php echo $senha ?>>
                </div>

                <div class="input-group">
                    <button id="cadastrar" name=usu>Atualizar</button><a href=usuario.php><button id="cancelar" type=button>Cancelar</button></a>
                </div>

            </form>
        </div>
    </div>
    <?php
if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='atu_usuario.php?id=$id_usuario'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Aparelho cadastrado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}
?>
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
