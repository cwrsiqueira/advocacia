<?php 

require_once("conexao.php");


$senha = '123';
$senha_cript = md5($senha);
$res_usuarios = $pdo->query("SELECT * from usuarios");
$dados_usuarios = $res_usuarios->fetchAll(PDO::FETCH_ASSOC);
$linhas_usuarios = count($dados_usuarios);
if($linhas_usuarios == 0){
  $res_insert = $pdo->query("INSERT into usuarios (nome, cpf, usuario, senha, senha_original, nivel) values ('Administrador', '000.000.000-00', '$email_site', '$senha_cript', '$senha', 'admin')");
}

 ?>


 <!DOCTYPE html>
<html>
<head>
  <title>Painel Administrativo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <meta name="google-site-verification" content="6GcQqGrAVTfeYXKeKwIGle9zmIXtSbQ6NyUfWO46mNo" />
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167499901-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167499901-1');
</script>


     
      <link rel="shortcut icon" href="https://www.jladvocacia.com/images/favicon.ico" type="image/x-icon">
      <link class="include" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">
      <link class="include" href="https://fonts.googleapis.com/css?family=Raleway:400,300,700" rel="stylesheet" type="text/css">
      <meta name="keywords" content="escritório de advocacia em Suzano - SP, advogados em Suzano em mogi das cruzes itaqua aruja poa, Advocacia em Suzano, Advocacia em Mogi das cruzes, Advocacia em Arujá, Advocacia em Itaquaquecetuba¸ advocacia no alto tietê, advocacia zona leste de são Paulo, direito de família em Suzano em mogi das cruzes itaqua aruja poa , direito do consumidor em Suzano em mogi das cruzes itaqua aruja poa, acidente de trânsito em Suzano em mogi das cruzes itaqua aruja poa, direito médico em Suzano em mogi das cruzes itaqua aruja poa, execução penalem Suzano em mogi das cruzes itaqua aruja poa , direito penal em Suzano em mogi das cruzes itaqua aruja poa, isenções de impostos carro zero em Suzano em mogi das cruzes itaqua aruja poa, cr exército em Suzano em mogi das cruzes itaqua aruja poa, arma de fogo em Suzano em mogi das cruzes itaqua aruja poa, porte e posse de arma em Suzano em mogi das cruzes itaqua aruja poa, cac em Suzano em mogi das cruzes itaqua aruja poa, advogado em suzano eme mogi das cruzes, telefone de escritório de advocacia, reinaldo lourenço, fabio justino, reinaldo de brito lourenço, fabio justino de freitas, divórcio em Suzano em mogi das cruzes itaqua aruja poa, jl advocacia em Suzano em mogi das cruzes itaqua aruja poa, advise, tf, tjsp, stj, stj,software jurídico, advogados em suzano mogi das cruze">
      
      

  
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">

<link href="css/style.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



</head>
<body>

<section class="login-block">
    <div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">Faça seu Login</h2>
		    <form class="login-form" method="post" action="autenticar.php">
  <div class="form-group">
    <label for="exampleInputEmail1" class="text-uppercase">Usuário</label>
    <input autofocus type="email" name="usuario" class="form-control" placeholder="Digite seu Email" required value="financeiro@email.com">
    
  </div>
 <div class="form-group">
    <label for="password" for="exampleInputPassword1" class="text-uppercase">Senha</label>
    <input id="password" value="123" type="password" name="senha" class="form-control" placeholder="Senha" required>
    
      <a  href="" id="mostrar_senha" style="color:black;">Mostrar Senha</a>
     
    </div>
  
  
    <div class="form-check">
    <label class="form-check-label">
      <input type="checkbox" class="form-check-input">
      <small>Lembrar-Me</small>
    </label>
    <button type="submit" class="btn btn-login float-right"><i class="fa fa-sign-in" aria-hidden="true"></i> |
Logar</button><br><br>
    <a href="https://www.jladvocacia.com/"  type="button" class="btn btn-dark   float-right btn-rounded">Site</a> 
  </div>
  
</form>
<div class="copy-text"><a class="text-dark" href="" data-toggle="modal" data-target="#modal-recuperar">Recuperar Senha</a></div>
		</div>
		<div class="col-md-8 banner-sec">
           
	</div>
</div>
</section>


</body>
</html>





<div class="modal fade" id="modal-recuperar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Recuperar Senha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body">

          <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Seu Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="txtEmail">

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button name="recuperar-senha" type="submit" class="btn btn-primary">Recuperar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<?php 
if(isset($_POST['recuperar-senha'])){
  $email_usuario = $_POST['txtEmail'];

  $res = $pdo->prepare("SELECT * from usuarios where usuario = :usuario");

  $res->bindValue(":usuario", $email_usuario);
  $res->execute();

  $dados = $res->fetchAll(PDO::FETCH_ASSOC);
  $linhas = count($dados);

  if($linhas > 0){
    $nome_usu = $dados[0]['nome'];
    $senha_usu = $dados[0]['senha_original'];
    $nivel_usu = $dados[0]['nivel'];

  }else{
    echo "<script language='javascript'>window.alert('Este email não está cadastrado no sistema!'); </script>";
  }


  //AQUI VAI O CÓDIGO DE ENVIO DO EMAIL
  $to = $email_usuario;
  $subject = "Recuperação de Senha $nome_empresa ";

  $message = "

  Olá $nome_usu!! 
  <br><br> Sua senha é <b>$senha_usu </b>

  <br><br> Ir Para o Sistema -> <a href='$url_sistema'  target='_blank'> Clique Aqui </a>

  ";

  $remetente = $email_site;
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
  $headers .= "From: " .$remetente;
  mail($to, $subject, $message, $headers);

  

  echo "<script language='javascript'>window.alert('Sua senha foi enviada no seu email, verifique no spam ou lixo eletrônico!!'); </script>";

  echo "<script language='javascript'>window.location='index.php'; </script>";


}
?>


 

<div style="text-align: center;">
               Copyright © JL Advocacia  2010 | 2020  -  Desenvolvido por <a href="https://jladvocacia.com">Reinaldo Lourenço</a
                                          
            </div>
     
      <div style="text-align: right;">
         <div style="text-align: center;">
        <!-- Desenvolvido por <a href="https://jladvocacia.com">Reinaldo Lourenço</a>-->
        
         </div>
</div>
<!-- FUNÇÃO MOSTRAR E ESCONDER SENHA -->

<script>
  $(function(){
    $('#mostrar_senha').click(function(e){
      e.preventDefault();
      let type = $('#password').attr('type');
      let text = $('#mostrar_senha').html();
      if(type == 'password') {
        $('#password').attr('type', 'text');
      } else {
        $('#password').attr('type', 'password');
      }
      if(text == 'Mostrar Senha') {
        $('#mostrar_senha').html('Esconder Senha');
      } else {
        $('#mostrar_senha').html('Mostrar Senha');
      }
    })
  })
</script>