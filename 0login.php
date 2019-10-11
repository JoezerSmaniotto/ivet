<!--<link rel="stylesheet" href="assets/css/index.css"> -->
<title>Login</title>
</head>
<body>
<?php require('includes/componentes/header.php') ?>
<main>
<h1> Login </h1>
    <section>
      <form action="includes/logica/logica_usuario.php" method="post">
        <p><label for="email">Email: </label><input type="text" name="email" id="email"></p>
        <p><label for="senha">Senha: </label><input type="password" name="senha" id="senha"></p>
        <p><button type="submit" id='entrar' name='entrar' value="Entrar"> Entrar </button></p>      
        <button type="button"> <a href="cadastrarUsuario.php">Criar Conta</a></button>
      </form>
    </section>
  
</body>
</html>