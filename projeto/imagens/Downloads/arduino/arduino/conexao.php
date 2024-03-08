<?php
$host = "localhost";
$usuario= "root";
$senha = "";
$db=mysqli_connect("$host","$usuario","$senha") or die ("Problema no servidor!");
$db -> select_db("arduino") or die ("Problema com o banco de dados!");
$db2 = $db
?>
