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

    $tipo        = $_POST['tipo']; 
    $dt_nasc     = $_POST['dt_nasc'];     
    $sexo        = $_POST['sexo'];
    $localizacao = $_POST['localizacao']; 
    $nome        = $_POST['nome'];
    $obs         = $_POST['obs'];  
    $raca        = $_POST['raca'];         
    $idUsuario = $_SESSION['id'];
    
    // caminho absoluto onde os arquivos serão armazenados
    $caminho="../../imagens";

    // /*executa_upload*/
    $nome_arquivo=$_FILES['img']['name']; 
    $tamanho_arquivo=$_FILES['img']['size']; 
    $arquivo_temporario=$_FILES['img']['tmp_name']; 
    if (move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo")){
      // $vetResult['result']=' Upload do arquivo foi concluído com sucesso';
      // echo json_ennome_arquivocode($vetResult); 
      // die("Upload do arquivo foi concluído com sucesso");
      $res = 1;
    }
    if($res){
      $img = $nome_arquivo;
      $array = array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$idUsuario,$img);
      $resultad=inserirPet($conexao, $array);
      if($resultad){
        $res=0;
        echo json_encode($resultad);
      }
    }else {
      $vet['result']="Imagem Nao Movida";
      echo json_encode($vet);
    }
  
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
    // $idUsuario = $_SESSION['id'];
    // $array = array($idUsuario);
    $resulta=listarPetsAdota($conexao); // ,$idUsuario
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

   # Lista as Solictaçoes De Adoção Para o Dono do Pet
  if(isset($data->apresentarSolicitacoesAdocao)){
    $idUsuario = $_SESSION['id'];
    // $array = array($idUsuario);
    $resulta=apresentarSolicitacoesAdocao($conexao,$idUsuario);
    echo json_encode($resulta); 

  }

  # Efetica a Adoção do Pet
  if(isset($data->efetivaAdocao)){
    $idUsuario = $data->id_usu;
    $id_Animal = $data->id_animal;
    $data_adocao = date('d/m/y'); 
    $status_Solicita = 1;
    $array = array($data_adocao,$status_Solicita,$idUsuario,$id_Animal);
    $resulta=efetivaAdocao($conexao,$array);
    
    if($resulta){
      $id_Animal = $data->id_animal;
      $data_adocao = date('d/m/y');
      $array = array($data_adocao,$id_Animal);
      $resul = atualizaDataAdocao($conexao,$array);
      if($resul){
        echo json_encode($resul); 
      }
    }
  }


  # Rejeitar a Adoção do Pet
  if(isset($data->rejeitarAdocao)){
    $id_Animal = $data->id_animal;
    $idUsuario = $data->id_usu;
    $status_Solicita = 2;
    $array = array($status_Solicita,$idUsuario,$id_Animal);
    $resul=rejeitaAdocao($conexao,$array);
    echo json_encode($resul); 
    
  }








































?>