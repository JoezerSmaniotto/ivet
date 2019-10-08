<?php
    require_once('conecta.php');
    require_once('funcoes_usuario.php');
#CADASTRO USUÁRIO
    $json = file_get_contents('php://input');
    $data = json_decode($json);


    if(isset($data->cadastrar)){
        $nome        = $data->nome;    
        $cpf         = $data->cpf;     
        $email       = $data->email;
        $cep         = $data->cep;    
        $rua         = $data->rua;         
        $numero      = $data->numero; 
        $cidade      = $data->cidade;  
        $estado      = $data->estado;
        $complemento = $data->complemento;
        $telefone    = $data->telefone;
        $senha       = $data->senha;
        $status      = $data->status;
        $senhaEncriptada =  base64_encode($senha);
    
        $array = array($nome,$cpf,$email,$cep,$rua,$numero,$cidade,$estado,$complemento,$status,$senhaEncriptada,$telefone);
        $result=inserirUsuario($conexao, $array);
        //echo $result;
        //die;
        


        //header('location:../../index.php');
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




#SAIR
    if(isset($_POST['sair'])){
            session_start();
            session_destroy();
            header('location:../../login.php');
    }

#EDITAR USUÁRIO
    if(isset($_POST['editar'])){
    
            $id = $_POST['editar'];
            $array = array($id);
            $usuario= json_encode(buscarUsuario($conexao, $array)); 
            
            //require_once('../../alterarUsuario.php');
    }    
#ALTERAR USUÁRIO
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
#DELETAR USUÁRIO
    if(isset($_POST['deletar'])){
        $id = $_POST['deletar'];
        $array=array($id);
        deletarUsuario($conexao, $array);
        header('Location:../../index.php');
    }


#DELETAR USUÁRIO Logado
if(isset($_GET['excluirConta'])){
    session_start();
    $array = array($_SESSION['id']);
    $result = deletarUsuario($conexao, $array);
    if( $result  == true){
        session_destroy();
    }
    var_dump($result);
    header('Location:../../index.php');
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


?>