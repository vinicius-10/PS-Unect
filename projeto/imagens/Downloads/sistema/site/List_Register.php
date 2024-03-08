<?php
include "conexao.php";

$pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
$qnt_result_pg = filter_input(INPUT_POST, 'qnt_result_pg', FILTER_SANITIZE_NUMBER_INT);

$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;


$result_usuario = "SELECT u.nome_usuario, a.nome_aparelho, r.data, r.hora , r.operacao from registro r, usuario u, aparelho a where u.id_usuario =r.id_usuario_fk and a.id_aparelho=r.id_aparelho_fk order by id_registro desc LIMIT $inicio, $qnt_result_pg  ";
$resultado_usuario = $db -> query($result_usuario);



if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
	?>
<table id="customers">
	<tbody>
		<tr>
			<th class='data'>Data</th>
			<th class='data'>Hora</th>
			<th>usuario</th>
			<th>aparelho</th>
			<th>ação</th>
		</tr>
			<?php
			$acao= array(
				0=>'Desligar',
				1=>'Ligar'
			);
			while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){

				$date=date('d/m/Y',strtotime($row_usuario['data']));
				$time=substr($row_usuario['hora'],0,-3);

				echo "
				<tr>

					<td>$date</td>
					<td>$time</td>
					<td>{$row_usuario['nome_usuario']} </td>
					<td>{$row_usuario['nome_aparelho']}</td>
					<td>{$acao[$row_usuario['operacao']]}</td>

				</tr>";
			
			}?>
		</tbody>
	</table>
</div>
<?php

$result_pg = "SELECT COUNT(id_registro) AS num_result FROM registro";
$resultado_pg = $db ->query($result_pg);
$row_pg = mysqli_fetch_assoc($resultado_pg);


$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

$max_links = 2;

echo "<ul class='pagination'><li><a href='#' onclick='List_Register(1, $qnt_result_pg)'><<<</a></li> ";

for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
	if($pag_ant >= 1){
		echo " <li><a href='#' onclick='List_Register($pag_ant, $qnt_result_pg)'>$pag_ant </a> </li>";
	}
}

echo "<li><a class='active'> $pagina </a></li>";

for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
	if($pag_dep <= $quantidade_pg){
		echo " <li><a href='#' onclick='List_Register($pag_dep, $qnt_result_pg)'>$pag_dep</a></li> ";
	}
}

echo " <li><a href='#' onclick='List_Register($quantidade_pg, $qnt_result_pg)'>>>></a></li></ul>";
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum registro encontrado!</div>";
}