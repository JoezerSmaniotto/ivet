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

    /* Config_upload */
    //parâmetros de configuração para o upload
    // limitar as extensões? (sim ou não)
    $limitar_ext="sim";

    //extensões autorizadas
    $extensoes_validas=array(".gif",".jpg",".jpeg",".bmp",".GIF",".JPG",".JPEG",".BMP",".PNG",".png");

    // limitar o tamanho do arquivo? (sim ou não)
    $limitar_tamanho="sim";

    //tamanho limite do arquivo em bytes
    $tamanho_bytes="20000000";

    // se já existir o arquivo indica se ele deve ser sobrescrito (sim ou não)
    $sobrescrever="não";
    
    // caminho absoluto onde os arquivos serão armazenados
    $caminho="../../imagens";

    // /*executa_upload*/
    $nome_arquivo=$_FILES['img']['name']; 
    $tamanho_arquivo=$_FILES['img']['size']; 
    $arquivo_temporario=$_FILES['img']['tmp_name']; 

    if (!empty($nome_arquivo)){
        if($sobrescrever=="não" && file_exists("$caminho/$nome_arquivo")){
            // die("Arquivo já existe");
            $vet['result']="Arquivo ja existe";
            echo json_encode($vet);
            die();
        }
        if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes)){
            // die("Arquivo deve ter o no máximo $tamanho_bytes bytes");
            // $vet['result']="Arquivo deve ter o no máximo  bytes";
            $vet['result']="Arquivo deve ter o no maximo 20000000 bytes";
            echo json_encode($vet);
            die();

    
        }
        $ext = strrchr($nome_arquivo,'.');
        if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas)){
            // die("Extensão de arquivo inválida para upload");
            $vet['result']="Extensao de arquivo invalida para upload";
            echo json_encode($vet);
            die();

        }
        if (move_uploaded_file($arquivo_temporario, "$caminho/$nome_arquivo")){
            // $vet['result']="Imagem Movida";
            // echo json_encode($vet);
            // die();
            $res = 1;
        }
        else{
            // echo "Arquivo não pode ser copiado para o servidor.";
            $vet['result']="Arquivo nao pode ser copiado para o servidor";
            echo json_encode($vet);
            die();
        }
    }else{ 
        // die("Selecione o arquivo a ser enviado");
        $vet['result']="Selecione o arquivo a ser enviado";
        echo json_encode($vet);
        die();
    }

    if($res){
      $img = $nome_arquivo;
      $array = array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$idUsuario,$img);
      $resultad=inserirPet($conexao, $array);
      if($resultad){
        $res=0;
        echo json_encode($resultad);
      }
    }
    // else {
    //   $vet['result']="Imagem Nao Movida";
    //   echo json_encode($vet);
    // }
  
  
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
    $imagemExclui = $data->imagem;
    $caminho2="../../imagens";
    $way = "$caminho2/$imagemExclui";
    if( unlink($way)){
      $array = array($idAnimal);
      $result=deletarPet($conexao, $array);
      echo json_encode($result);
    }
    
  }

  
  #Recupera Dados Pet Para Edição
  if(isset($data->recuperaDadosPet)){
    $idUsuario = $_SESSION['id'];
    $idAnimal = $data->idAnimal;    
    $array = array($idAnimal,$idUsuario);
    $resul=recuperadaDadosPet($conexao, $array);
    echo json_encode($resul); 
  }
  
  
  # Efetiva a Edição Salvando no Banco de Dados
  if(isset($_POST['editaPet'])){

    $tipo        = $_POST['tipo']; 
    $dt_nasc     = $_POST['dt_nasc']; 
    $sexo        = $_POST['sexo'];
    $localizacao = $_POST['localizacao'];
    $nome        = $_POST['nome']; 
    $obs         = $_POST['obs']; 
    $raca        = $_POST['raca'];
    $id_Animal   = $_POST['id_Animal'];
    $idUsuario   = $_SESSION['id'];

    if($_FILES){ // COM Imagem
      $imgAnt = $_POST['imgAnt'];
      /* Config_upload */
      //parâmetros de configuração para o upload
      // limitar as extensões? (sim ou não)
      $limitar_ext1="sim";

      //extensões autorizadas
      $extensoes_validas1=array(".gif",".jpg",".jpeg",".bmp",".GIF",".JPG",".JPEG",".BMP",".PNG",".png");

      // limitar o tamanho do arquivo? (sim ou não)
      $limitar_tamanho1="sim";

      //tamanho limite do arquivo em bytes
      $tamanho_bytes1="20000000";

      // se já existir o arquivo indica se ele deve ser sobrescrito (sim ou não)
      $sobrescrever1="não";
      
      // caminho absoluto onde os arquivos serão armazenados
      $caminho1="../../imagens";

      // /*executa_upload*/
      $nome_arquivo1=$_FILES['img']['name']; 
      $tamanho_arquivo1=$_FILES['img']['size']; 
      $arquivo_temporario1=$_FILES['img']['tmp_name']; 

      if (!empty($nome_arquivo1)){
          if($sobrescrever1=="não" && file_exists("$caminho1/$nome_arquivo1")){
              // die("Arquivo já existe");
              $vet1['result']="Arquivo ja existe";
              echo json_encode($vet1);
              die();
          }
          if($limitar_tamanho1=="sim" && ($tamanho_arquivo1 > $tamanho_bytes1)){
              // die("Arquivo deve ter o no máximo $tamanho_bytes bytes");
              // $vet['result']="Arquivo deve ter o no máximo  bytes";
              $vet1['result']="Arquivo deve ter o no maximo 20000000 bytes";
              echo json_encode($vet1);
              die();
      
          }
          $ext1 = strrchr($nome_arquivo1,'.');
          if (($limitar_ext1 == "sim") && !in_array($ext1,$extensoes_validas1)){
              // die("Extensão de arquivo inválida para upload");
              $vet1['result']="Extensao de arquivo invalida para upload";
              echo json_encode($vet1);
              die();

          }
          if (move_uploaded_file($arquivo_temporario1, "$caminho1/$nome_arquivo1")){
              // $vet['result']="Imagem Movida";
              // echo json_encode($vet);
              // die();
              $movida1 = 1;
          }
          else{
              // echo "Arquivo não pode ser copiado para o servidor.";
              $vet1['result']="Arquivo nao pode ser copiado para o servidor";
              echo json_encode($vet1);
              die();
          }
      }else{ 
          // die("Selecione o arquivo a ser enviado");
          $vet1['result']="Selecione o arquivo a ser enviado";
          echo json_encode($vet1);
          die();
      }

      if($movida1){
        $img1 = $nome_arquivo1;
        $array1 = array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$img1,$id_Animal,$idUsuario);
        $res1=alteraPetComImg($conexao,$array1);
        if($res1){
          $movida1=0;
          $cam = "$caminho1/$imgAnt";
          if( unlink($cam)){
            echo json_encode($res1);
          }
           
        }
      }
      
      // $array = array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$id_Animal,$idUsuario);
      // $res=alteraPet($conexao, $array);
      // echo json_encode($res);

     
    }else { // Sem  IMAGEM

      $array2= array($tipo,$dt_nasc,$sexo,$localizacao,$nome,$obs,$raca,$id_Animal,$idUsuario);
      $res2=alteraPet($conexao, $array2);
      if($res2){
        echo json_encode($res2); 
        die();
      }

    }
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
      $retorSolict = array();
      unset($retorSolict);
      $array = array($data_Solicita,$status_Solicita,$idUsuario,$id_Animal);
      $resulta=solicitaAdocao($conexao,$array);
      echo json_encode($resulta); 

      // Manda Email
      $retorSolict = emailSolicitacao($conexao,$id_Animal,$idUsuario);
      // var_dump($retorSolict);
      $nomeDono=$retorSolict[0]["nomedono"];
      // var_dump($nomeDono);
      // die();
      $emailDono=$retorSolict[0]["emaildono"];
      $nomeanimal=$retorSolict[0]["nomeanimal"];
      $nomeSolicitante=$_SESSION['nome'];
      $retorSolict = array();
      unset($retorSolict);
          
      $mensagem1= "Olá {$nomeDono} ,<br><br> {$nomeSolicitante} Deseja Adotar seu Pet: {$nomeanimal}, respota esta solicitação !!! <br><br><br><br> Atenciosamente <br> Equipe  Ivet" ;
      $solAd=enviaEmail($emailDono,$mensagem1);
      if($solAd){
        
      }
      
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
        $resultRej=solicitaDados($conexao,$id_Animal,$idUsuario);
        // var_dump($resultRej);
        $nomeSolitc=$resultRej[0]["nomesolict"];
        $emailSolict=$resultRej[0]["emailsolict"];
        $nomeanimal=$resultRej[0]["nomeanimal"];
        $nomeDono=$_SESSION['nome'];
        $emailDono=$_SESSION['email'];
        $link = "www.ivet.com.br";
        $mensagem = "Olá {$nomeSolitc} ,<br><br>{$nomeDono} aceitou sua solicitação de adoção do  Pet: {$nomeanimal}, entre em contato pelo e-mail {$emailDono}!!! <br><br><br> Atenciosamente <br> Equipe  Ivet <br>{$link}" ;
        $retornoEmail=enviaEmail($emailSolict,$mensagem);
        if($retornoEmail){

        }
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
    $resultRej=solicitaDados($conexao,$id_Animal,$idUsuario);
    // var_dump($resultRej);
    $nomeSolitc=$resultRej[0]["nomesolict"];
    $emailSolict=$resultRej[0]["emailsolict"];
    $nomeanimal=$resultRej[0]["nomeanimal"];
    $nomeDono=$_SESSION['nome'];
    $link = "www.ivet.com.br";
    $mensagem = "Olá {$nomeSolitc} ,<br><br>{$nomeDono} rejeitou sua  solicitação de adoção do  Pet: {$nomeanimal}, acesse nosso site e encontre outros pets  acesse o link !!! {$link}<br><br><br> Atenciosamente <br> Equipe  Ivet" ;
    $retornoEmail=enviaEmail($emailSolict,$mensagem);
    if($retornoEmail){

    }

    
  }

  








































?>