<!DOCTYPE html>
<html>
<?php
 include_once('includes/componentes/cabecalho.php');
 include_once('includes/componentes/header.php');
 include_once('includes/logica/conecta.php');
 include_once('includes/logica/funcoes_usuario.php');
?>
<?php
    $id = $_SESSION['id'];
    $array = array($id);
    $usuario = buscarUsuario($conexao,$array);

?>

    <title>Alterar Usuário</title>
</head>
<body>

<main>
    <section>
    <form action="includes/logica/logica_usuario.php" method="post">
      <p><label for="nome">Nome: </label><input type="text" name="nome" id="nome" value="<?php echo $usuario['nome']; ?>"></p>
      <p><label for="email">email: </label><input type="text" name="email" id="email" value="<?php echo $usuario['email']; ?>"></p>
      <p><label for="senha">Senha: </label><input type="password" name="senha" id="senha" value="<?php echo $usuario['senha']; ?>"></p>
      <p><label for="endereco">Endereço: </label><input type="text" name="endereco" id="endereco" value="<?php echo $usuario['endereco']; ?>"></p>
      <p><label for="telefone">Telefone: </label> <input type="text" name="telefone" id="telefone" value="<?php echo $usuario['telefone']; ?>"></p>
      <p><label for="dt_nascimento">Data Nascimento: </label><input type="text" name="dt_nascimento" id="dt_nascimento" value="<?php echo $usuario['dt_nascimento']; ?>"> </p>
      <input type="hidden" id='id' name='id' value="<?php echo $usuario['id']; ?>">
      <p> <input type="submit" id='alterar' name='alterar' value="Alterar">
      </p>        
        </form>
    </section>
</main>

<script>
    


</script>

</body>
</html>