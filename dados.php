<?php
session_start(); 

		if(isset($_SESSION["email"])) {
			$retorno = array('id' => $_SESSION['id'],'nome'=>$_SESSION['nome'],'email' => $_SESSION['email']);
		} 
		else{ 
			$retorno = array('sucesso'=>false,'mensagem'=>'usuário inválido');
		}

echo json_encode($retorno);
?> 
