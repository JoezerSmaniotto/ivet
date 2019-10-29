<?php
    
    function inserirUsuario($conexao,$array){
       try {
            $query = $conexao->prepare("insert into usuario (nome,cpf,e_mail,cep,rua,numero,cidade,estado,complemento,status,senha,telefone,bairro) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $usuario = $query->execute($array);
            
            if($usuario){
                $vetor['result']='true';
                return  $vetor;
            }
            echo var_dump($usuario);
            echo var_dump($vetor);
            die();

        }catch(PDOException $e) {
            echo var_dump($usuario);
             

            echo 'Error: ' . $e->getMessage();
            // echo var_dump( $e->getMessage());
            // die();
        }
    }

    function deletarUsuario($conexao, $array){ // ok
        try {
            $query = $conexao->prepare("delete from usuario where id_usuario = ?");
            $usuario = $query->execute($array);   
            return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
 
    function listarUsuarios($conexao){
      try {
        $query = $conexao->prepare("SELECT * FROM usuarios");      
        $query->execute();
        $usuarios = $query->fetchAll();
        return $usuarios;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
      
    }

    
    function alterarUsuario($conexao, $array){ // OK
        try {
            $query = $conexao->prepare("update usuario set nome= ?, cpf= ?, e_mail = ?, cep= ?, rua= ?, numero = ?,  cidade = ?, estado = ?, complemento = ?, telefone= ?, bairro = ? where id_usuario = ?");
            $usuario = $query->execute($array);  
            return $usuario;

        }catch(PDOException $e) {// Erro ao executar a query cai no catch
            echo 'Error: ' . $e->getMessage();
        }
    }

    function buscarUsuario($conexao,$array){ // OK
        try {
      
            $query = $conexao->prepare("select * from usuario where id_usuario= ?");
            if($query->execute($array)){
                $usuario = $query->fetch(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
                $vetor=array();
                if($usuario){
                    foreach($usuario as $indice=>$valor){
                        $vetor["$indice"]=$valor;
                    }
                    $vetor['result']='true';    
                    return $vetor;
                    
                }else {
                    $vetor['result']='false';
                    return $vetor;
                  
                }
                  
            }
          
        }
        catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }  
    }


    function buscarNomeUsuario($conexao,$array){ // OK
        try {
      
            $query = $conexao->prepare("select nome from usuario where id_usuario= ?");
            if($query->execute($array)){
                $usuario = $query->fetch(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
                $vetor=array();
                if($usuario){
                    foreach($usuario as $indice=>$valor){
                        $vetor["$indice"]=$valor;
                    }
                    $vetor['result']='true';    
                    return $vetor;
                    
                }else {
                    $vetor['result']='false';
                    return $vetor;
                  
                }
                  
            }
          
        }
        catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }  
    }


    function acessarUsuario($conexao,$array){
       
        try {
        $query = $conexao->prepare("select * from usuario where e_mail=? and senha=?");
      
        if($query->execute($array)){
            $usuario = $query->fetch(); //coloca os dados num array $usuario
           
          if ($usuario)
            {  
                return $usuario;
            }
        else
            {
                return false;
            }
        }
        else{
           
            return false;
        }
         }catch(PDOException $e) {
           
            echo 'Error: ' . $e->getMessage();
      }  
    }

    function buscarUsuarioNome($conexao,$nome){
        try {
        $query = $conexao->prepare("select * from usuarios where  nome like'%$nome%'");
        if($query->execute()){
            $usuario = $query->fetchAll(); //coloca os dados num array $usuario
            return $usuario;
            
        }
        else{
            return false;
        }
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

    function validaEmail($conexao,$array){
        try {
            $query = $conexao->prepare("select e_mail from usuario where e_mail=?");
            if($query->execute($array)){
                $usuario = $query->fetch(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
                $vetor=array();
                if($usuario){
                    $vetor['result']='true';    
                    return $vetor;
                    
                }else {
                    $vetor['result']='false';
                    return $vetor;
                  
                }            

        }
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }



    
?>
