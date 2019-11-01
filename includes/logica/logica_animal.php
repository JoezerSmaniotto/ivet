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
    $resultad=inserirPet($conexao, $array);
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











































?>