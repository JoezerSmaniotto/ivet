<?php


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
        
         $query = $conexao->prepare("insert into pet_tipo (tipo,nascimento,sexo,localizacao,nome,observacoes,fk_raca_id,id_usuario) values (?, ?, ?, ?, ?, ?, ?, ?)");
         $pet = $query->execute($array);
         if($pet){
            $vetora['result']="true";
            // var_dump($vetor);
            // die();
            return  $vetora;
          }  
        //  echo "PETs";
        //  var_dump($pet);
    
    }catch(PDOException $e) {
      echo 'Error: ' . $e->getMessage();
  }  

}

// function inserirPet($conexao,$array){
// try {
//          if($pet){
//             $vetor['result']="true";
//             // var_dump($vetor);
//             // die();
//             return  $vetor;
//          }
//          die();
//      }catch(PDOException $e) {
//         //  echo "Entrou no Catch";
//         //  die(); 
//          echo 'Error: ' . $e->getMessage();
//          // echo var_dump( $e->getMessage());
//          // die();
//      }
//   }

  
  function listarPetsUsuario($conexao,$idUsuario){
    try {
      
        $query = $conexao->prepare("select pet_tipo.id_animal,pet_tipo.nome,pet_tipo.observacoes,pet_tipo.sexo,pet_tipo.tipo,pet_tipo.nascimento,pet_tipo.localizacao,pet_tipo.fk_raca_id,raca.id,raca.nomer from pet_tipo full join raca on(pet_tipo.fk_raca_id = raca.id)  where id_usuario='$idUsuario' ");
        $query->execute();
        $pets = $query->fetchAll(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
        $vetore=array();
        if($pets){
            // foreach($pets as $indice=>$valor){
            //     $vetor["$indice"]=$valor;
            // }
            // $vetor['result']='true';    
            // return $vetor;
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

































?>