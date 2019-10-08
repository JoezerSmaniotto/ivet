<?php
 //include_once('includes/componentes/cabecalho.php');
?>
    <!--<link rel="stylesheet" href="assets/css/index.css">-->
    <title>Cadastrar Usuário</title>
</head>
<body>
<?php require('includes/componentes/header.php') ?>
<main>
    <section>
   
      <p><label for="nome">Nome: </label><input type="text" name="nome" id="nome"></p>
      <p><label for="cpf">CPF: </label><input type="text" name="cpf" id="cpf" size="11"></p>
      <p><label for="email">email: </label><input type="email" name="email" id="email"></p>
      <p><label for="cep">CEP: </label><input type="text" name="cep" id="cep"></p>
      <p><label for="rua">Rua: </label><input type="text" name="rua" id="rua"></p>
      <p><label for="Numero">Numero: </label><input type="number" name="numero" id="numero"></p>
      <p><label for="Cidade">Cidade: </label><input type="text" name="cidade" id="cidade"></p>
      <p><label for="Estado">Estado: </label><input type="text" name="estado" id="estado"></p>
      <p><label for="Complemento">Complemento: </label><input type="text" name="complemento" id="complemento"></p>
      <p><label for="telefone">Telefone: </label> <input type="text" name="telefone" id="telefone"></p>
      <p><label for="senha">Senha: </label><input type="password" name="senha" id="senha"></p>
      <p><button type="submit" id='cadastrar' name='cadastrar' value="Cadastrar" onclick="cadastrarUsuario()"> Cadastrar </button>  </p>      
      <button type="button"> <a href="login.php"> Voltar </a> </button>
  
    </section>
</main>
<?php //require('includes/componentes/footer.php');?>
  
  <script>

  
    function gerarObjetoUsuario(){
      const nome = ObterValor('nome');
      const cpf = ObterValor('cpf');
      const email = ObterValor('email');
      const cep = ObterValor('cep');
      const rua = ObterValor('rua');
      const numero = ObterValor('numero');
      const cidade = ObterValor('cidade');
      const estado = ObterValor('estado');
      const complemento = ObterValor('complemento');
      const telefone = ObterValor('telefone');
      const senha = ObterValor('senha');
      const status = 1;
      //const dt_nascimento = ObterValor('dt_nascimento');
      const cadastrar = true;
      return { // Cria o objeto 
        nome,cpf,email,cep,rua,numero,cidade,estado,complemento,status,senha,telefone,cadastrar
      }

    }
  
    function ObterValor(id){
      const campo = document.getElementById(id);
      if(campo === null){
        return ''; // retorna uma string em branco
      }else {
        return campo.value;
      }
    }
    
    function cadastrarUsuario(){

      const dadosUsuario = gerarObjetoUsuario();
      
      if( formularioValido(dadosUsuario)){
        fetch('includes/logica/logica_usuario.php',{
          method: 'post',
          body: JSON.stringify(dadosUsuario)// converte para JSON o JSON.stringify // body apenas quando quero fazer um post
        }).then((response)=> {
            console.log(response);
            //window.location.href = "./login.php"
        });
      }else{
        alert("Verifique os Campos, Existe  Campos Não Preenchidos");
      }
    }

    function formularioValido(dadosUsuario){
      let campoVazio = false; 
      const arrayDadosUser = Object.values(dadosUsuario);
      arrayDadosUser.forEach(cont=>{
        if(cont === ''){
           campoVazio = true;
        }
      });

      return !campoVazio;  
    }

  </script>

</body>
</html>