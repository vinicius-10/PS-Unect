<?php 

$permissao=@$_COOKIE['permissao'];

if($permissao != 1){
    header('location:sair.php');
    Die();
}

include 'conexao.php';
include "consent.html";

if(isset($_GET['c'])){
    echo "    <div class='popup' > <a href='scheduling.php'><img class= fechar src=./imagens/fechar.png ></a> <div class='mensagem'>Ação cadastrado com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}elseif(isset($_GET['d'])){
    echo "    <div class='popup' > <a href='scheduling.php'><img class= fechar src=./imagens/fechar.png ></a> <div class='mensagem'>Ação excluida com susceso<br><br><img src='imagens/sucesso.png' width='70'> </div> </div>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Smart Tech - Agendamento</title>
    <meta charset="utf-8"/>

    <link rel='shortcut icon' href='imagens/favicon_.ico' />

    <link rel="stylesheet" type="text/css" href="css/scheduling.css">

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

<aside> 

    <h2>Agendamentos</h2>

</aside>

<main>
<?php
    $query = $db -> prepare('SELECT a.id_action,a.hour,ap.nome_aparelho, a.action, a.repeat_action, a.starting_day, a.last_day, a.weekly from automatic_action a, aparelho ap where id_aparelho=id_aparelho_fk order by hour');
    $query ->execute();
    $query ->bind_result($id,$hour,$appliances,$action,$repeat,$start,$end,$weekly);
    while($query->fetch()){

        if($repeat=='no'){
            $repeat_day ='Dia: '.$start;

        }elseif($repeat=='period'){
            $repeat_day = 'Dia inicial: '.$start.'<br>
            Dia final: '.$end;

        }elseif($repeat=='weekly'){
            $weekly=str_split($weekly);
            $list_weekly= ['1'=>'Domingo','2'=>'Segunda','3'=>'Terça','4'=>'Quarta','5'=>'Quinta','6'=>'Sexta','7'=>'Sabado'];

            foreach ($weekly as $day_weekly){
                
                $repeat_day=@$repeat_day?$repeat_day. ', '.$list_weekly[$day_weekly]: $list_weekly[$day_weekly];
            }
        }
        $repeat_pt=['no'=>' não repetir',
        'period'=> ' periodo','weekly' => ' semanalmente'];

        $hour=substr($hour,0,-3);
        echo "
            <div class='card'>
                <h2>Aparelho: $appliances </h2>
                    
                <p>Horario: $hour</p>
                <p> Repetição: {$repeat_pt[$repeat]}</p>
                $repeat_day
                            
                <div class='button'>
                  <a href='excluir.php?idac=$id'>

                        <button>
                        Excluir
                        </button>
                    </a>
                </div>      
            </div>";
        unset($repeat_day);
    }
?>
</main>

<aside>
    
    <button onclick="open_reg()">Cadastrar novo agendamento</button>

</aside>



<footer>

<h1>Smart<span> Tech</span></h1>

Fernanda Carvalho, Emilly Meireles, Sther dos Reis e Vinicius Souza.

</footer>

<div id="reg" class="cad">
    <div class="img">

        <img src="imagens/logoprincipal.png">
    </div>
    <div class="from">
        
        <h2>Cadastrar Ação</h2>

        <form action="cadastrar.php" method= "POST" id="register">

            <div class="field">
                <label for="time"> Horaio</label>
                <input type="time" id="time" name='time' required >
            </div>

            <div class="field">
                <label for="app">Aparelho</label>
                <Select name="app" class="select" id="app" required>
                    <?php
                    $query = $db -> prepare('SELECT id_aparelho, nome_aparelho from aparelho  where ativo=1');
                    $query ->execute();
                    $query ->bind_result($id,$name);
                    while($query->fetch()){
                        echo "<option value=$id>$name</option>";
                    }
                    ?>
                </Select>
            </div>
            <div class="field_radio">
                <label class="title">Ação</label> 

                <label for="action_on" class="action">
                <input name="action" class="select" id="action_on" type="radio" value="on" required>Ligar</label>

                <label for="action_off" class="action">
                <input name="action" class="select" id="action_off" type="radio" value="off" required>Desligar</label>
            </div>
            
            <div class="field">
                <label for="repeat">Repetição</label>
                <Select name="repeat" class="select" onchange="show_repeat()" id="repeat">
                    <option value="no">Não repetir</option>
                    <option value="weekly">Semanalmente</option>
                    <option value="period">Periodo</option>
                </Select>
                <div id="period"></div><div id='men'></div>
            </div>
        
        
            <button id="cadastrar" name=acao onclick="check()">Cadastrar</button>

        </form>

    </div>
    <a ><img src="imagens/fechar.png" onclick="fechar()"></a>

</div>

<script> 
    function check(){
        const form = document.getElementById('register');
        const men = document.getElementById('men');
        var value = document.getElementById('repeat').value;
        var action_on =document.getElementById('action_on');
        var action_off =document.getElementById('action_off');
        var time =document.getElementById('time').value;

        
        if(value == 'weekly'){   
            for(var i = 0; i<=6;i++){

                var key = String(i);
                var filled = document.getElementById(i);
                
                if(filled.checked){
                    i =10;
                }
            }
            
            if(i==11){
                men.innerHTML='';
                if(time !='' && action_on.checked || action_off.checked){
                    form.submit();
                }else{
                    men.innerHTML="Prencha todos os campos.";
                }
            }else{  
                men.innerHTML="Selecione pelo menos um dia para repetir.";
            }
        }
    }

    function open_reg(){
        document.getElementById('reg').style.display =  'flex';
    }

    function fechar(){
        document.getElementById('reg').style.display =  'none';
    }

    function show_repeat(){
        var value = document.getElementById('repeat').value;
        const field = document.getElementById('period');
        const cadastrar = document.querySelector("#cadastrar");
        const men = document.getElementById('men');

        if(value=='period'){
            field.innerHTML= "<div class='field'><label for='start'>Inicio</label><input type='date' id='start' name='start' onchange='check_date()' required></div><div class='field'><label for='end'>Fim</label><input type='date' id='end' name='end' onchange='check_date()' required></div>";
            cadastrar.type='submit';
            men.innerHTML='';
        }else if(value=='weekly'){
            field.innerHTML= "<input name='acao' type='hidden'><input type='checkbox' id='0' class='check' value='1' name='1'><labeL class='wekly' for='0'>D</labeL><input type='checkbox' id='1' class='check' value='2' name='2'><labeL class='wekly' for='1'>S</labeL><input type='checkbox' id='2' class='check' value='3' name='3'><labeL class='wekly' for='2'>T</labeL><input type='checkbox' id='3' class='check' value='4' name='4'><labeL class='wekly' for='3'>Q</labeL><input type='checkbox' id='4' class='check' value='5' name='5'><labeL class='wekly' for='4'>Q</labeL><input type='checkbox' id='5' class='check' value='6' name='6'><labeL class='wekly' for='5'>S</labeL><input type='checkbox' id='6' class='check' value='7' name='7'><labeL class='wekly' for='6'>S</labeL>";
            cadastrar.type='button';
            men.innerHTML='';
        }else{
            field.innerHTML= "";
            cadastrar.type='submit';
            men.innerHTML='';
        }
    }

    function check_date(){
        const cadastrar = document.querySelector("#cadastrar");
        const men = document.getElementById('men');

        var date_end = new Date(document.getElementById('end').value);
        var date_start = new Date(document.getElementById('start').value);
        
        var date = new Date();
        var date_today = new Date(date.setDate(date.getDate() - 1));

        if(date_start < date_today){
            
            men.innerHTML='Data de inicio invalida.';
            cadastrar.style.opacity = '0.2';
            cadastrar.disabled= true;

        }else if(date_start > date_end){
            men.innerHTML='Data final invalida.';
            cadastrar.style.opacity = '0.2';
            cadastrar.disabled= true;

        }else{
            men.innerHTML='';
            cadastrar.style.opacity = '1';
            cadastrar.disabled= false;       
            
        }
    }
   
</script>
</body>
</html>
