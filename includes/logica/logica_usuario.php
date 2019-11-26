<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    session_start();
    require_once('conecta.php');
    require_once('funcoes_usuario.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    
    
    
#CADASTRO USUÁRIO // OK    
if(isset($data->cadastrar)){
    $nome        = $data->nome;    
    $cpf         = $data->cpf;     
    $email       = $data->email;
    $cep         = $data->cep;    
    $rua         = $data->rua;         
    $numero      = $data->numero; 
    $bairro      = $data->bairro;
    $cidade      = $data->cidade;  
    $estado      = $data->estado;
    $complemento = $data->complemento;
    $telefone    = $data->telefone;
    $senha       = $data->senha;
    $status      = $data->status;
    $senhaEncriptada =  base64_encode($senha);

    $array = array($nome,$cpf,$email,$cep,$rua,$numero,$cidade,$estado,$complemento,$status,$senhaEncriptada,$telefone,$bairro);
    $result=inserirUsuario($conexao, $array);
    // echo var_dump($result);
    // die();
    echo json_encode($result); 
 
}
#ENTRAR
if(isset($_POST['entrar'])){ 
            
    $email = addslashes($_POST['email']);//impede que o sql seja alterado
    $senha = $_POST['senha'];
    $senhaEncriptada = base64_encode($senha);
    $array = array($email, $senhaEncriptada);
    $usuario = acessarUsuario($conexao,$array);
    // echo "<pre>";
    // var_dump($usuario);
    // die;
    
    if($usuario){
        session_start();
        $_SESSION['logado'] = true;
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        header('location:../../index.php');
    }
    else{
        header('location:../../login.php');
    }
}

#Apresenta Dados Usuario  => OK
if(isset( $data->apresentarUser)){ 
    $id =  $_SESSION['id'];
    $array = array($id);
    $retorno=(buscarNomeUsuario($conexao, $array));
    echo json_encode($retorno);     
}  


#SAIR 
if(isset($_POST['sair'])){
        session_start();
        session_destroy();
        header('location:../../login.php');
}

#EDITAR USUÁRIO  => OK
if(isset($_POST['editar'])){ 
        $id =  $_SESSION['id'];
        //$id = $_POST['editar'];
        $array = array($id);
        $retorno=(buscarUsuario($conexao, $array));
        echo json_encode($retorno);       
}   

#ALTERAR USUÁRIO  => OK         
if(isset($data->alterar)){
    $id =  $_SESSION['id'];
    $nome        = $data->nome;    
    $cpf         = $data->cpf;     
    $email       = $data->email;
    $cep         = $data->cep;    
    $rua         = $data->rua;         
    $numero      = $data->numero; 
    $bairro      = $data->bairro; 
    $cidade      = $data->cidade;  
    $estado      = $data->estado;
    $complemento = $data->complemento;
    $telefone    = $data->telefone;

    $array = array($nome,$cpf,$email,$cep,$rua,$numero,$cidade,$estado,$complemento,$telefone,$bairro,$id);
    $retorno=alterarUsuario($conexao, $array);
    echo json_encode($retorno);

    // header('location:../../index.php');
}
#DELETAR USUÁRIO
if(isset($_POST['deletar'])){
    $id = $_POST['deletar'];
    $array=array($id);
    deletarUsuario($conexao, $array);
    header('Location:../../index.php');
}


#DELETAR USUÁRIO Logado    OK
if(isset($data->excluirConta)){
    session_start();
    $array = array($_SESSION['id']);
    $result = deletarUsuario($conexao, $array);
    if($result){
        echo json_encode($result);
        session_destroy();
             
    }
    
} 


# VERIFICA SE O EMAIL JÁ FOI CADASTRADO
if(isset( $data->validaEmail)){
    $email = $data->email;
    $array = array($email);
    $result = validaEmail($conexao, $array);
    // echo var_dump($result);
    // die();
    echo json_encode($result); 
    
}


#ALTERAR USUÁRIO_Logado
if(isset($_POST['alterar'])){
    
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = base64_encode($_POST['senha']);
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $dt_nascimento = $_POST['dt_nascimento'];
    
    $array = array($nome, $email, $senha, $endereco, $telefone, $dt_nascimento, $id);
    alterarUsuario($conexao, $array);

    header('location:../../index.php');
}


# Contato
if(isset($data->contato)){ 
    $nome        = $data->nome;    
    $EmailRes    = $data->EmailRes;     
    $assunto     = $data->assunto;
    $conteudo    = $data->conteudo;


    // var_dump( $nome );
    // var_dump($EmailRes );
    // var_dump($assunto );
    // var_dump( $conteudo );



    require_once('PHPMailer/src/PHPMailer.php');
    require_once('PHPMailer/src/Exception.php');
    require_once('PHPMailer/src/SMTP.php');    

    $mail = new PHPMailer();
    $mail->SetLanguage("br");
    $mail->IsSMTP();
    $mail->isHTML(true);
    $mail->SMTPDebug = 0; //exibe erros e mensagens, 0 não exibe nada
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";

    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->Username = "animalsivet@gmail.com";
    $mail->Password = "@1234567j";
    $mail->CharSet = "utf-8";

    $mail->From = "animalsivet@gmail.com"; //remetente
    $mail->FromName = "Ivet";
    $mail->AddAddress($EmailRes);

    $mail->Subject = "Contato - Ivet";
    $mail->Body = "Olá ".$nome.",<br><br>Obrigado por entrar em contato conosco, retornaremos assim que possível!";

    // var_dump($mail);

    $vetore = array();
    if(!$mail->Send()){
        // $message = $mail->ErrorInfo;
        // echo(json_encode(['success' => false, 'message' => $message]));
        $vetore['success']=false;
        echo json_encode($vetore); 
    } else {
        // echo(json_encode(['success' => true, 'message' => 'Seu contato foi enviado com sucesso!']));
        $vetore['success']=true;
        echo json_encode($vetore); 
    }

    // else echo(json_encode(['success' => false, 'message' => 'Erro ao enviar sua mensagem, tente novamente!']));


}    







?>