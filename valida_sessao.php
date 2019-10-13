<?php
session_start();
//header('Content-type: application/json');
//$json = file_get_contents('php://input');
//$data = json_decode($json); 


  if(isset($_POST['acao']) and $_POST['acao']=='sair'){
    session_destroy();
    $retorno = array('sair'=>true);
  
  }else{
    $email=$_POST["email"]; 
    $senha=$_POST["senha"];
    if(!(empty($email) OR empty($senha))){ // testa se os campos do formulário não estão vazios 
          require_once('includes/logica/conecta.php');
          require_once('includes/logica/funcoes_usuario.php');
          $senhaEncriptada = base64_encode($senha);
          $array = array($email, $senhaEncriptada);
          $usuario = acessarUsuario($conexao,$array);
          
          if($usuario){  
              //$_SESSION['logado'] = true;
              $_SESSION['id'] = $usuario['id_usuario'];
              $_SESSION['nome'] = $usuario['nome'];
              $_SESSION['email'] = $usuario['e_mail'];
              $retorno = array('sucesso'=>true,'id' => $_SESSION['id'],'nome'=>$_SESSION['nome'],'email' => $_SESSION['email']);
            
          } else { // else correspondente ao teste do resultado da função pg_num_rows
            $retorno = array('sucesso'=>false,'mensagem'=>'usuário inválido');
          } 
    } else {  // else correspondente ao resultado da função !empty
      $retorno = array('sucesso'=>false,'mensagem'=>'campos vazios');
    }  
  }  
    echo json_encode($retorno);
     
?> 
  












