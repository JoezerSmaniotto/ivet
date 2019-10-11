<?php
session_start(); 

		if(isset($_SESSION["email"])) 
		{
		$retorno = array('sucesso'=>true,'mensagem'=>'usuário logado');

		} 
		else 
		 { 
			$retorno = array('sucesso'=>false,'mensagem'=>'usuário inválido');

		 }

echo json_encode($retorno);
?> 
