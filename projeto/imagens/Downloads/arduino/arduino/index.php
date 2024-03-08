<!DOCTYPE html>
<html lang="pt-BR" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title><link rel='shortcut icon' href='imagens/favicon_.ico' />
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
	    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
</head>

<body>

    
    <div class="container" id="container">
        
        
        <div class="form-container sign-in-container">
            
            <form method="POST" action="#">
                <h1>Entrar</h1>
                <br>
               
            <input type="text" placeholder="Usuario" name="username" />
			<input type="password" placeholder="Senha" name="password" />
			<button>Entrar</button>
            <h2>
			<?php
            include "conexao.php";

            $permisao=@$_COOKIE['permissao'];

            if($permisao==1){

                header("location:adm.php");
            }elseif($permisao==2 or $permisao==3 ){
                header("location:principal.php");
            }

            if(isset($_POST['username'])){

                $usu=@$_POST['username'];
                $senha=@$_POST['password'];


                $sql = $db -> prepare("SELECT id_usuario, permissao FROM usuario where usuario=? and senha=? ");
                $sql -> bind_param('ss',$usu, $senha);
                $sql -> execute();
                $sql -> bind_result($id,$p);
                while($sql ->fetch()){
                    if ($p ==1){
                        header("location:adm.php");
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
        </h2>
        </form>
        
        
        
    </div>
    

    <div class="overlay-container">
		<div class="overlay">
			
			<div class="overlay-panel overlay-right">
				<h1>Bem Vindo!</h1>
			
				<p>Faça login, para ter acesso a nossa plataforma.</p>
				<br> <br>
							

				
			</div>
		</div>
	</div>
</div>

<script src="script.js" charset="utf-8"></script>

</body>
</html>

