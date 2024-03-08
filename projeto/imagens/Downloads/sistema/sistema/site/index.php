<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech</title>
    <meta charset="utf-8"/>

    <link rel='shortcut icon' href='imagens/favicon_.ico' />

    <link rel="stylesheet" type="text/css" href="css/index.css">

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>


<header>
    <a class=logo href=index.php><h2>Smart<span> Tech</span></h2></a>
    
</header>

<main>
    <div class="from">
        <form method="POST" action="#">
            <h1>Entrar</h1>
           
        <input type="text" placeholder="Usuario" name="username" maxLength='50'>
        <input type="password" placeholder="Senha" name="password" maxLength=''><br>
        <button>Entrar</button>
        <h3>
        <?php
            include "consent.html";
            include "conexao.php";

            $permission=@$_COOKIE['permissao'];

            $permissions_common= [2,3];
            $permission_adm=1;

            if($permission==$permission_adm){

                header("location:principal_adm.php");

            }elseif(in_array($permission,$permissions_common) ){

                header("location:principal.php");
            }

            if(isset($_POST['username'])){

                $user=@$_POST['username'];
                $password=@$_POST['password'];


                $sql = $db -> prepare("SELECT id_usuario, permissao FROM usuario where usuario=? and senha=? and ativo=1 ");
                $sql -> bind_param('ss',$user, $password);
                $sql -> execute();
                $sql -> bind_result($id,$p);

                while($sql ->fetch()){
                    if ($p ==1){
                        header("location:principal_adm.php");
                    }else{
                        header("location:principal.php");
                    }
                    setcookie('permissao',$p);
                    setcookie('logado',$id);
                    
                }

            if (empty($id)){
                
                echo "Login invalido.";
            }
            }
            ?>
        </h3>
    </form>
    </div>

    <aside>
        <h1 class="title">Bem Vindo!</h1>
			
        <p>Faça login, para ter acesso a nossa plataforma.</p>

    </aside>

</main>

<footer>

<h1>Smart<span> Tech</span></h1>

Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

        </footer>

</body>
</html>
