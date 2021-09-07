<?php 

require_once("config.php");
@session_start();


global $pdo;
try {
	$pdo = new PDO("mysql:dbname=$banco;host=$host", "$usuario", "$senha", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

	//conexao mysqli para o backyp e outras apis que precisem de mysqli
	$conn = mysqli_connect($host, $usuario, $senha, $banco);

} catch (Exception $e) {
	echo 'Erro ao conectar com o banco!!' .$e;
}


 ?>