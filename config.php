<?php 

date_default_timezone_set("America/Sao_Paulo");


$email_site = "www.jladvocacia.com";
$nome_empresa = "JL Advocacia";
$url_sistema = "http://carlos.pc/advocacia/";
const BASE_URL = "http://carlos.pc/advocacia/";


//BANCO DE DADOS LOCAL
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'advocacia';

// //Conecta-se ao MailServer
// $host = "outlook.com"; 
// $usuario = 'jladvocaciajl@hotmail.com';
// $senha = 'sorvete40';
// $mbox = imap_open("{".$host.":143/novalidate-cert}Inbox", $usuario, $senha)or die("can't connect: " . imap_last_error());
// imap_close($mbox);

/*
//BANCO DE DADOS HOSPEDADO
$host = 'br534.hostgator.com.br';
$usuario = 'hugocu75_adv';
$senha = 'hospedagem';
$banco = 'hugocu75_advocacia';
*/



//VALORES PARA A COMBOBOX DE PAGINAÇÃO
$opcao1 = 10;
$opcao2 = 25;
$opcao3 = 50;

 ?>
