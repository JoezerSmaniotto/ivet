<?php
session_start(); 

		if(isset($_SESSION["email"])) {
			$retorno = array('sucesso'=>true,'mensagem'=>'usuario logado');
          
		} 
		else { 
			$retorno = array('sucesso'=>false,'mensagem'=>'usuario inválido');

		}

echo json_encode($retorno);
?> 
