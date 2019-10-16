<?php
 
    function inserirUsuario($conexao,$array){
       try {
            $query = $conexao->prepare("insert into usuario (nome,cpf,e_mail,cep,rua,numero,cidade,estado,complemento,status,senha,telefone) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $usuario = $query->execute($array);
            return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    function alterarUsuario($conexao, $array){
        try {
            $query = $conexao->prepare("update usuarios set nome= ?, email = ?, senha= ?, endereco= ?, telefone= ?, dt_nascimento=? where id = ?");
            $usuario = $query->execute($array);   
            return $usuario;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    function deletarUsuario($conexao, $array){
        try {
            $query = $conexao->prepare("delete from usuarios where id = ?");
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

    function buscarUsuario($conexao,$array){
        try {

        $query = $conexao->prepare("select * from usuario where id_usuario= ?");
        if($query->execute($array)){
            $usuario = $query->fetch(PDO::FETCH_ASSOC); //coloca os dados num array $usuario
            $vetor=array();
             foreach($usuario as $indice=>$valor)
             {
                 $vetor["$indice"]=$valor;

            }

            $vetor['status']='true';    
            return $vetor;
            
        }
        else{
            //return false;
            //echo("Não Existe Usuarios");
            $ret = array("status"=>"false");
;            return $ret;
            
        }
         }catch(PDOException $e) {
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

    
?>
