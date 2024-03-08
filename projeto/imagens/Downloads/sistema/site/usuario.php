<?php 

include "consent.html";
include 'conexao.php';

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}

$id_logado=$_COOKIE['logado'];


if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='usuario.php'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Usuario excluido com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";

}elseif(isset($_GET['men'])){
    echo "    <div class='popup' > <a href='usuario.php'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Usuario não pode ser excluido.<br> É obrigratório ter pelo menos um administrador </div> </div>";

}elseif(isset($_GET['men2'])){
    echo "    <div class='popup' > <a href='usuario.php'><img class= fechar src=./imagens/fechar.png onclik=fechar() width='30px'></a> <div class='mensagem'>Usuario não pode ser excluido de administrador.<br> É obrigratório ter pelo menos um administrador </div> </div>";

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - Atualizar aparelho</title>
    <meta charset="utf-8"/>

    <link rel='shortcut icon' href='imagens/favicon_.ico' />

    <link rel="stylesheet" type="text/css" href="css/list.css">

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

    <?php
        $Query_usu = $db -> query("SELECT id_usuario, nome_usuario,usuario,permissao from usuario where ativo = '1' ORDER BY nome_usuario ");
        while($row = $Query_usu -> fetch_array()){
            $id_usuario = $row['id_usuario'];
            $nome = $row['nome_usuario'];
            $usuario = $row['usuario'];
            $permissao= $row['permissao'];
            $aparelho='';
            
            if($permissao==1){
                $aparelho='<h3>Administrador<h3>';
            }else{

                $query_apa=$db -> query("SELECT a.nome_aparelho from aparelho a, usuario_aparelho u where u.id_usuario_fk=$id_usuario and u.id_aparelho_fk=a.id_aparelho and a.relay is not null");
                while($lista = $query_apa-> fetch_array()){
                    $aparelho = $aparelho . "<li> $lista[nome_aparelho].<li>";
                }
            }
        
            ?>
            
            <div class='BoxUsuario'>
                <h2><?php echo $nome ?></h2>
                                    
                <p>Aparelhos conectados:</p>
                    
                <ul class='ListAppliances'>
                <?php  echo $aparelho ?>   
                </ul>
                  
                        
                <div class='button'>

                <a href='atu_usuario.php?id= <?php echo $id_usuario  ?>'>
                    <button>
                    Atualizar
                    </button>
                </a>
    
                
    
                    
                    <button onclick="confim( <?php echo  "'$nome ' , '$id_usuario' , '$id_logado' " ?>  )">
                    Excluir
                    </button>
                
            </div>  
            </div>
            <?php
            
        }

    ?>

</main>

<footer>

<h1>Smart<span> Tech</span></h1>

Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

</footer>

<div class='popup' id='popup' > <div class='mensagem' id='men'>Desejas excluir o usuario:</div><div id='name'></div><button onclick=fechar()>Cancelar</button><a href='#' id='link'> <button>Excluir</button></a></div>

<script>
    
    var fill = document.getElementById('name');
    var link = document.getElementById('link');
    var men= document.getElementById('men');

    function confim(name, id,id_log){

        if (id == id_log){

            men.innerHTML= 'Deseja realmete se autoexcluir?<br> Está ação irá deslogalo';
        }else{

            fill.innerHTML= name;
        }
        link.href='excluir.php?idu=' + id;
        
        document.getElementById('popup').style.display =  'block';
    }

    function fechar(){
        document.getElementById('popup').style.display =  'none';
        men.innerHTML="Desejas excluir o usuario:";
        fill.innerHTML="";
    }

</script>
</body>
</html>
