<?php
 include_once('includes/componentes/cabecalho.php');
?>
    <link rel="stylesheet" href="assets/css/listarUsuarios.css">
    <title>Pet&Health</title>
</head>
<body>
<?php require('includes/componentes/header.php') ?>
<main>
    <?php
        $email = $_SESSION['email'];
        $usuarios = listarUsuarios($conexao);
        if(empty($usuarios)){
            ?>
                <section>
                    <p>Não há usuários cadastrados.</p>
                </section>
            <?php
        }
        foreach($usuarios as $usuario){
                 
            ?>
                <section>
                    <p>Nome: <?php echo $usuario['nome']; ?></p>
                    <p>Email <?php echo $usuario['email']; ?></p>
                    <p>Telefone: <?php echo $usuario['telefone']; ?></p>
                    <p>Início do expediente: <?php echo $usuario['inicio_expediente']; ?></p>
                    <p>Final do expediente: <?php echo $usuario['fim_expediente']; ?></p>
                                        
                    
                </section>
            <?php
        }
    ?>
</main>
<?php require('includes/componentes/footer.php');?>
</body>
</html>