<?php
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;

  function buscarRaca($conexao){
    try {
      $query = $conexao->prepare("SELECT id,nomer from raca");      
      $query->execute();
      $usuarios = $query->fetchAll();
      return $usuarios;
    
    }catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
    }  
    
  }

  function inserirPet($conexao,$array){
  try {
        $query = $conexao->prepare("insert into pet_tipo (tipo,nascimento,sexo,localizacao,nome,observacoes,fk_raca_id,id_usuario,imagem) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $pet = $query->execute($array);
        $vetora=array();
        if($pet){
          return $vetora['result']="true";
      
        }   
    
    }catch(PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

  // function inserirImagem($conexao,$array){
  //   try {
        
  //        $query = $conexao->prepare("insert into imagens (link_imagens,fk_pet_tipo_id_animal) values (?, ?)");
  //        $pet = $query->execute($array);
  //        if($pet){
  //           $vetora['result']="true";
  //           // var_dump($vetor);
  //           // die();
  //           return  $vetora;
  //         }  
  //       //  echo "PETs";
  //       //  var_dump($pet);
    
  //   }catch(PDOException $e) {
  //     echo 'Error: ' . $e->getMessage();
  //   }  
  // }


  
  function listarPetsUsuario($conexao,$idUsuario){
    try {
      
        $query = $conexao->prepare("select pet_tipo.id_animal,pet_tipo.imagem,pet_tipo.nome,pet_tipo.observacoes,pet_tipo.sexo,pet_tipo.tipo,pet_tipo.nascimento,pet_tipo.localizacao,pet_tipo.fk_raca_id,raca.id,raca.nomer from pet_tipo full join raca on(pet_tipo.fk_raca_id = raca.id)  where id_usuario='$idUsuario' and dataadoc IS NULL ");
        $query->execute();
        $pets = $query->fetchAll(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
        $vetore=array();
        if($pets){
              return $pets;
        }else {
            $vetore['result']='Não Há Animais Cadastrados';
            return $vetore;
          
        }       
    
    }
    
    catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
    }
        
  }

  function deletarPet($conexao, $array){ // ok
    try {
        $query = $conexao->prepare("delete from pet_tipo where id_animal = ?");
        $usuario = $query->execute($array);
        $vetor=array();
        if($usuario){
          $vetor['result']='Animal Exluído';
          return $vetor;
        }else{
          $vetor['result']='Animal Não Exluído';
          return $vetor;
        }  
        return $usuario;
    }catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

  }


  function recuperadaDadosPet($conexao, $array){ // ok
    try {
        
      $query = $conexao->prepare("select * from pet_tipo where id_animal= ? and id_usuario= ? ");
      if($query->execute($array)){
          $pet = $query->fetch(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
          $veto=array();
          if($pet){
              // foreach($usuario as $indice=>$valor){
              //     $vetor["$indice"]=$valor;
              // }
              // $vetor['result']='true'; 

              return $pet;
              
          }else {
              $veto['result']='Pet Não Encontrado';
              return $veto;
            
          }      
      }
    }
    catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }  

  }

      
  function alteraPet($conexao, $array){ // OK
    try {
        $query = $conexao->prepare("update pet_tipo set tipo= ?, nascimento= ?, sexo = ?, localizacao= ?, nome = ?,  observacoes = ?, fk_raca_id = ? where id_animal = ? and id_usuario = ?");
        $pets = $query->execute($array);
        $vet=array();
        if($pets){
          $vet['result']= "true";
          return $vet;

        }else{
          $vet['result']= "Dados Pet Não Alterado";
          return $vet;
        } 
        
    }catch(PDOException $e) {// Erro ao executar a query cai no catch
        echo 'Error: ' . $e->getMessage();
    }
  }


  function alteraPetComImg($conexao, $array){ // OK
    try {
        $query = $conexao->prepare("update pet_tipo set tipo= ?, nascimento= ?, sexo = ?, localizacao= ?, nome = ?,  observacoes = ?, fk_raca_id = ?, imagem = ? where id_animal = ? and id_usuario = ?");
        $pets = $query->execute($array);
        $vet=array();
        if($pets){
          $vet['result']= "true";
          return $vet;

        }else{
          $vet['result']= "Dados Pet Não Alterado";
          return $vet;
        } 
        
    }catch(PDOException $e) {// Erro ao executar a query cai no catch
        echo 'Error: ' . $e->getMessage();
    }
  }


  function listarPetsAdota ($conexao){ // ,$idUsuario
    try {
      
      $query = $conexao->prepare("select pet_tipo.id_animal,pet_tipo.imagem,pet_tipo.nome,pet_tipo.observacoes,pet_tipo.sexo,pet_tipo.tipo,pet_tipo.nascimento,pet_tipo.localizacao,pet_tipo.fk_raca_id,raca.id,raca.nomer from pet_tipo join raca on(pet_tipo.fk_raca_id = raca.id) where dataadoc IS NULL ");
      $query->execute();
      $pets = $query->fetchAll(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
      $vetore=array();
      if($pets){
            
        return $pets;
          
      }else {
          $vetore['result']='false';
          return $vetore;
        
      }
         
    }
  
    catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
    }

  }

  function solicitaAdocao($conexao,$array){
    try {
      $query = $conexao->prepare("insert into adota (data_solicitacao,status_adocao,id_usuario,id_animal) values (?, ?, ?, ?)");
      $solicita = $query->execute($array);
      $vetora=array();
      if($solicita){
         $vetora['result']="true";
         return  $vetora;
      }  
 
    }catch(PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }  
  }

  function apresentarSolicitacoesAdocao($conexao,$idUsuario){
    try {
      $query = $conexao->prepare("select adota.id_usuario as id_usu,pet_tipo.nome as nomeAni,raca.nomer,pet_tipo.imagem,pet_tipo.id_animal,usuario.nome,usuario.e_mail
      from adota join pet_tipo on( adota.id_animal = pet_tipo.id_animal) join usuario 
      on (adota.id_usuario= usuario.id_usuario) join raca 
      on (pet_tipo.fk_raca_id = raca.id)
      where pet_tipo.dataadoc is NULL and adota.status_adocao= '0' and pet_tipo.id_usuario ='$idUsuario' ");
      $query->execute();
      $solitacoes = $query->fetchAll(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
      $vetore=array();
      if($solitacoes){
            return $solitacoes;
      }else {
          $vetore['result']='Não Há Solicitações';
          return $vetore; 
      }       
    }

    catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
    }
  }
  
  function efetivaAdocao($conexao,$array){
    try {
      //  $array = array($data_adocao,$status_Solicita,$idUsuario,$id_Animal);
      $query = $conexao->prepare("update adota set data_adocao= ?, status_adocao= ? where id_usuario = ? and id_animal = ? ");
      $resultado = $query->execute($array);
      $ret= 1;
      if($resultado){
        return $ret;

      }else{
        $ret = 0;
        return $vet;
      } 
      
    }catch(PDOException $e) {// Erro ao executar a query cai no catch
        echo 'Error: ' . $e->getMessage();
    }
  }

  function atualizaDataAdocao($conexao,$array){
    try {
      //   $array = array($data_adocao,$id_Animal);
      $query = $conexao->prepare("update pet_tipo set dataadoc= ? where id_animal = ? ");
      $resultado = $query->execute($array);
      $vetore = array();
      if($resultado){
        $vetore['result']='Adoção Efetivada';
        return $vetore;

      }else{
        $vetore['result']='Adoção Não Efetivada';
        return $vetore;
      } 
      
    }catch(PDOException $e) {// Erro ao executar a query cai no catch
        echo 'Error: ' . $e->getMessage();
    }    
  }

  function rejeitaAdocao($conexao,$array){
    try {
      
      //  $array = array($data_adocao,$status_Solicita,$idUsuario,$id_Animal);
      $query = $conexao->prepare("update adota set status_adocao= ? where id_usuario = ? and id_animal = ? ");
      $resultado = $query->execute($array);
      $vetore = array();
      if($resultado){
        $vetore['result']='Rejeição Efetivada';
        return $vetore;

      }else{
        $vetore['result']='Rejeição Não Efetivada';
        return $vetore;
      } 
      
    }catch(PDOException $e) {// Erro ao executar a query cai no catch
        echo 'Error: ' . $e->getMessage();
    }
  }


  function emailSolicitacao($conexao,$idAnimal,$idUsuario){
    try {
      $solitacoes=array();
      unset($solitacoes);
      $query = $conexao->prepare("select usuario.nome as nomedono,usuario.e_mail as emaildono,pet_tipo.nome as nomeAnimal
      from adota left join pet_tipo on(adota.id_animal = pet_tipo.id_animal) 
      left join usuario on (pet_tipo.id_usuario = usuario.id_usuario) 
      where adota.id_animal = '$idAnimal' and adota.id_usuario = '$idUsuario' ");
      $query->execute();
      $solitacoes = $query->fetchAll(PDO::FETCH_ASSOC); //coloca os dados num array 
      if($solitacoes){
            return $solitacoes;
      }       
    }
   
    catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
    }
  }

  function solicitaDadosRejeitado($conexao,$id_Animal,$idUsuario){
    try {
      $solitacoe=array();
      unset($solitacoe);
      $query = $conexao->prepare("select usuario.nome as nomeSolict,usuario.e_mail as emailSolict,pet_tipo.nome as nomeAnimal
      from adota left join pet_tipo on(adota.id_animal = pet_tipo.id_animal) 
      left join usuario on (adota.id_usuario = usuario.id_usuario) 
      where adota.id_animal = '$id_Animal' and adota.id_usuario = '$idUsuario' ");
      $query->execute();
      $solitacoe = $query->fetchAll(PDO::FETCH_ASSOC); //coloca os dados num array 
      if($solitacoe){
        return $solitacoe;
      }       
    }

    catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
    }   

  }

  function enviaEmail($emailResp,$mensag){

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
    $mail->AddAddress($emailResp);

    $mail->Subject = "Contato - Ivet";
    $mail->Body = $mensag;
    
    $vetore = array();
    if(!$mail->Send()){
        // $message = $mail->ErrorInfo;
        // echo(json_encode(['success' => false, 'message' => $message]));
        // $vetore['success']=false;
        // echo json_encode($vetore); 
    } else {
        // echo(json_encode(['success' => true, 'message' => 'Seu contato foi enviado com sucesso!']));
        // $vetore['success']=true;
        // echo json_encode($vetore); 
    }
  



  
  }


?>