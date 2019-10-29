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













































?>