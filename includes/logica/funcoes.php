<?php
 
    function inserirUsuario($conexao,$array){
       try {
            $usuarios = $conexao->prepare("insert into usuarios (nome, email, senha, endereco, telefone, dt_nascimento) values (?, ?, ?, ?, ?, ?)");
            $query = $usuarios->execute($array);
        
            return $query;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
    

    function alterarUsuario($conexao, $array){
        try {
            $usuarios = $conexao->prepare("update usuarios set nome= ?, email = ?, senha= ?, endereco= ?, telefone= ?, dt_nascimento=? where id = ?");
            $query = $usuarios->execute($array);   
            return $query;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    function deletarUsuario($conexao, $array){
        try {
            $usuarios = $conexao->prepare("delete from usuarios where id = ?");
            $query = $usuarios->execute($array);   
             return $query;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
 
    function listarUsuarios($conexao){
      try {
        $medicamentos = $conexao->prepare("SELECT * FROM usuarios");      
        $medicamentos->execute();
        $query = $medicamentos->fetchAll();
        return $query;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  

    }

     function buscarUsuario($conexao,$array){
        try {
        $usuarios = $conexao->prepare("select * from usuarios where id= ?");
        if($usuarios->execute($array)){
            $usuario = $usuarios->fetch(); //coloca os dados num array $usuario
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