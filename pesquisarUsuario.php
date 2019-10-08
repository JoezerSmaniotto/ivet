<!DOCTYPE html>
<html lang="en">

<?php
include_once('includes/componentes/cabecalho.php');
include_once('includes/componentes/header.php');
include_once('includes/logica/funcoes_usuario.php');
include_once('includes/logica/conecta.php');
?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pesquisa Nome</title>
    </head>
    <body>
        <section>
            <form action="#" method="post">
              <p><label for="nome">Nome: </label><input type="text" name="nome" id="nomePesq"></p>
              <p><button type="submit" id='pesquisa' name='pesquisar' value="Pesquisar"> Pesquisar </button>  </p>
              

            </form>
        </section>
  
<?php
    
    if(isset($_POST['pesquisar'])){
        $nome = $_REQUEST['nome'];
        $nome;
        $usuarios = buscarUsuarioNome($conexao,$nome);
        if($usuarios){
            foreach($usuarios as $usuario){
                echo("Nome: {$usuario['nome']} <br>");
                echo("Email: {$usuario['email']}<br>");
                echo("Email: {$usuario['endereco']}<br>");
                echo("Telefone: {$usuario['telefone']}<br>");
                echo("Data de Nascimento: {$usuario['dt_nascimento']}<br><hr>");
                //$nome, $email, $senhaEncriptada, $endereco, $telefone, $dt_nascimento
            }
        }else {
            echo "Não há Usuarios Cadastrados";
             
        }  
    }
?>
<br>
<button> <a href="index.php"> Voltar </a> </button>


</body>
    
</html>
    