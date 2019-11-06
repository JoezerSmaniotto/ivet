<?php
    session_start();
    require_once('conecta.php');
    require_once('funcoes_animal.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json);

        
  # Buscar Raca
  if(isset($data->racass) ){ // && $_SERVER['REQUEST_METHOD'] == 'post'
    $resultado=buscarRaca($conexao);
    echo json_encode($resultado); 

  }

   # Cadastro Animal
   if(isset($_POST['cadastrar'])){   
    // $senha = $_POST['senha'];
    // if(isset($data->cadastrar)){

    // $nome        = $_POST['nome']   
    // $dt_nasc     = $data->dt_nasc; $_POST['dt_nasc']      
    // $tipo        = $data->tipo; $_POST['tipo'] 
    // $sexo        = $data->sexo; $_POST['sexo']    
    // $raca        = $data->raca;  $_POST['nome']          
    // $localizacao = $data->localizacao; $_POST['nome'] 
    // $obs         = $data->obs; $_POST['nome'] 
    // $idUsuario   = $_SESSION['id']; $_POST['nome'] 
    
    $array = array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$idUsuario);
    $resultad=inserirPet($conexao, $array);
    // if($resultad){

    // }
    echo json_encode($resultad); 

  }

  #Listar Pets
  if(isset($data->apresentarPets)){
    $idUsuario = $_SESSION['id'];
    // $array = array($idUsuario);
    $resulta=listarPetsUsuario($conexao, $idUsuario);
    echo json_encode($resulta); 

  }

  #Exclui Pet
  if(isset($data->excluirPet)){
    // $idUsuario = $_SESSION['id'];
    $idAnimal = $data->idAnimal;    
    $array = array($idAnimal);
    $result=deletarPet($conexao, $array);
    echo json_encode($result); 
  }

  
  #Recupera Dados Pet Para Edição
  if(isset($data->recuperaDadosPet)){
    $idUsuario = $_SESSION['id'];
    $idAnimal = $data->idAnimal;    
    $array = array($idAnimal,$idUsuario);
    $resul=recuperadaDadosPet($conexao, $array);
    echo json_encode($resul); 
  }
                  
  if(isset($data->editaPet) ){
    $idUsuario = $_SESSION['id'];
    $nome        = $data->nome;    
    $dt_nasc     = $data->dt_nasc;     
    $tipo        = $data->tipo;
    $sexo        = $data->sexo;    
    $raca        = $data->raca;         
    $localizacao = $data->localizacao; 
    $obs         = $data->obs;
    $id_Animal   = $data->id_Animal;
    
    $array = array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$id_Animal,$idUsuario);
    $res=alteraPet($conexao, $array);
    echo json_encode($res); 
  }

  # Apresenta animais para serem adotados
  if(isset($data->apresentarPetsTotal)){
    $idUsuario = $_SESSION['id'];
    // $array = array($idUsuario);
    $resulta=listarPetsAdota($conexao,$idUsuario);
    echo json_encode($resulta); 

  }

   # Faz as notificações nas para os animais a serem adotados.
   if(isset($data->solicitaAdocao)){
    $idUsuario = $_SESSION['id'];
    $id_Animal = $data->id_animal; 
    $data_Solicita = date('d/m/y'); 
    $status_Solicita = 0;
    $array = array($data_Solicita,$status_Solicita,$idUsuario,$id_Animal);
    $resulta=solicitaAdocao($conexao,$array);
    echo json_encode($resulta); 

  }








































?>