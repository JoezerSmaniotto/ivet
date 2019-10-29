<?php
    session_start();
    require_once('conecta.php');
    require_once('funcoes_animal.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json);

        
  # Buscar Raca
  if(isset($data->raca)){
    $result=buscarRaca($conexao);
    echo json_encode($result); 

  }

   # Cadastro Animal
   if(isset($data->cadastrar)){

    $nome        = $data->nome;    
    $dt_nasc     = $data->dt_nasc;     
    $tipo        = $data->tipo;
    $sexo        = $data->sexo;    
    $raca        = $data->raca;         
    $localizacao = $data->localizacao; 
    $obs         = $data->obs;
    $idUsuario   = $_SESSION['id'];
    
    $array = array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$idUsuario);
    $result=inserirPet($conexao, $array);
    echo json_encode($result); 

  }

  #Listar Pets
  if(isset($data->apresentarPets)){
    $idUsuario = $_SESSION['id'];
    // $array = array($idUsuario);
    $result=listarPetsUsuario($conexao, $idUsuario);
    echo json_encode($result); 

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
    $result=recuperadaDadosPet($conexao, $array);
    echo json_encode($result); 
  }

                  
  if(isset($data->editaPet)){
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
    $result=alteraPet($conexao, $array);
    echo json_encode($result); 
  }











































?>