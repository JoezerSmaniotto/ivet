let flagCadastro = 0


function inserir(formulario) { // ???
    event.preventDefault();
    fetch('insere.php', {
        method: 'POST',
        body: new FormData(formulario),
        mode: 'no-cors'
    })
        .then(response => {
            return response.text();
        }).then(data => {
            console.log('Recebendo dados!');
            // console.log(data);
            if (data) {
                let texto = document.getElementById('texto');
                alert(data);
                texto.innerHTML = data;
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
}

function valida_sessao(formulario) { // OK

    event.preventDefault();
    fetch('valida_sessao.php', {
        method: 'POST',
        body: new FormData(formulario),
        mode: 'no-cors'
    })
        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!');
            console.log(dados);
            if (dados) {
                if (dados.sucesso == true) {
                    window.location = 'home.html'
                }
                else {
                    let texto = document.getElementById('texto');
                    texto.innerHTML = dados.mensagem;
                };
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });

}

function trocaMenu() { // OK

    fetch('autentica.php', {
        method: 'POST',
        mode: 'no-cors'
    })
        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados Menu!');
            console.log(dados);
            if (dados) {
                if (dados.sucesso == false) {
                    menuDeslogado();
                } else {
                    // window.location="home.html"
                    menuLogado()
                    return dados.sucesso;
                }
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });


}

function trocaMenu2() { // OK

    fetch('autentica.php', {
        method: 'POST',
        mode: 'no-cors'
    })
        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados Menu!');
            console.log(dados);
            if (dados) {
                if ((dados.sucesso != false)) {
                    window.location="home.html"
                } else {
                    // window.location="home.html"
                }
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });


}





function listar(formulario) { //

    event.preventDefault();
    fetch('listagem.php', {
        method: 'POST',
        body: new FormData(formulario),
        mode: 'no-cors'
    })
        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!');
            // console.log(data);
            if (dados) {
                let texto = document.getElementById('texto');
                let table = '<table border=1>'
                dados.forEach(obj => {
                    console.log(obj)
                    table += '<tr>'
                    Object.entries(obj).map(([key, value]) => {
                        table += `<td>${value}</td>`
                    });
                    table += '</tr>'
                });
                texto.innerHTML += table + '</table>';
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
}


function menuDeslogado() {
    

    document.querySelector('#colocamenu').innerHTML = `
        <nav class="navbar navbar-expand-lg navbar-light bg-primary" >
            <a class="navbar-brand fontLogo" href="home.html">Ivet</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto d-flex align-items-center">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contato.html">Contato</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="cadastroUsuario.html">Cadastra-se<span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"><button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Login</button></a>
                    </li>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="acesso" id="formulario" method="post" onsubmit="valida_sessao(this)"> 
                                <div class="form-group">
                                    <label for="email" class="col-form-label">E-mail:</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="senha" class="col-form-label">Senha:</label>
                                    <input type="password" class="form-control" id="senha" name="senha">
                                </div>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" value="Logar"></input>
                                
                                <div class="form-group pt-3">
                                     <a href="cadastroUsuario.html">Cadastre-se !!</a>
                                </div>
                                
                            </form>
                            <div id='texto'></div>
                        </div>
                    
                    </div>
                    </div>
                </div>
                    
                </ul>
            </div>
        </nav> `;
}


let saldacao2 = function () {
    return new Promise(function (resolve, reject) {
        let saldacao = "Bom dia"
        let apresentarUser = true
        let obj = { apresentarUser }
        fetch('includes/logica/logica_usuario.php', {
            method: 'post',
            mode: 'cors',
            body: JSON.stringify(obj)
        })

            .then(response => response.json())
            .then(function result(dados) {
                // document.querySelector('#welcome').innerHTML = `Olá ${dados.nome} `;
                let data = new Date();
                let hora = data.getHours();

                if (hora >= 6 && hora < 12) {
                    saldacao = "Bom dia"
                    let result = saldacao + " " +dados.nome
                    resolve(result)
                } else if (hora >= 12 && hora < 19) {
                    saldacao = "Boa tarde"
                    let result = saldacao + " " +dados.nome
                    resolve(result)
                } else {
                    saldacao = "Boa Noite"
                    let result = saldacao + " " +dados.nome
                    resolve(result)
                }

            });
       

    })
}




function menuLogado() {

    saldacao2()
    .then(function (response) {
        let boasvi = response;
        document.querySelector('#colocamenu').innerHTML = `
        <nav class="navbar navbar-expand-lg navbar-light bg-primary" >
            <a class="navbar-brand fontLogo" href="home.html">Ivet</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto d-flex">
                
                <li class="nav-item  active">
                    <a class="nav-link" href="home.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="solicitacoesAdot.html">SolicitaçõesAdo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adicionaPet.html">AdiconaPet</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listaPet.html">ListaPets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="editarPerfil.html">Edita Perfil</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="sair()">Sair</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-danger" href="#">${boasvi}</a> 
                </li>
              
            </ul>
            </div>
        </nav> `;

        
    })

 
}


function autentica() { // OK

    fetch('autentica.php', {
        method: 'POST',
        mode: 'no-cors'
    })
        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!');
            console.log(dados);
            if (dados) {
                if (dados.sucesso == false) {
                    window.location='home.html';
                    // menuDeslogado();
                } else {
                    // menuLogado()
                    return dados.sucesso;
                }
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });

}


function sair() { // OK 
    var formData = new FormData();
    formData.append('acao', 'sair')
    fetch('valida_sessao.php', {
        method: 'POST',
        body: formData,
        mode: 'no-cors'
    })
        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!');
            console.log(dados);
            if (dados.sair == true) {
                window.location = 'home.html'
            }

        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });

}

function listaUsuario() { // ???

    fetch('listagem.php', {
        method: 'POST',
        mode: 'no-cors'
    })
        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!')
            if (dados) {
                let usuario = document.getElementById('usuario')
                let tamanho = dados.length
                for (let i = 0; i < tamanho; i++) {
                    let opt = document.createElement("option")
                    opt.value = dados[i].id
                    opt.text = dados[i].nome

                    usuario.add(opt, usuario.options[i + 1])
                }

            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
}


function recuperarDadosEdita() { // OK 

    var formData = new FormData();
    formData.append('editar', 'editarrr')
    fetch('includes/logica/logica_usuario.php', {
        method: 'POST',
        body: formData,
        mode: 'no-cors'
    })

        .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!')
            console.log(dados);
            if (dados.result == 'true') {
                document.querySelector("#nome").value = dados.nome;
                document.querySelector("#cpf").value = dados.cpf;
                document.querySelector("#email").value = dados.e_mail;
                document.querySelector("#cep").value = dados.cep
                document.querySelector("#rua").value = dados.rua;
                document.querySelector("#numero").value = dados.numero;
                document.querySelector("#bairro").value = dados.bairro;
                document.querySelector("#cidade").value = dados.cidade;
                document.querySelector("#estado").value = dados.estado;
                document.querySelector("#complemento").value = dados.complemento;
                document.querySelector("#telefone").value = dados.telefone;
                document.querySelector("#salvar").style.display = 'none';
                let inp = document.querySelectorAll(".editar")
                inp.forEach((inpt) => {
                    inpt.setAttribute('disabled', 'true')
                })

            } else {
                console.log(dados.result);
                alert('Usuario Não Encontrado ')
            }
        })

        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
}


function habilitaEdicao() {  // OK
    document.querySelector("#salvar").style.display = 'inline';
    document.querySelector("#editar").style.display = 'none';

    let inp = document.querySelectorAll(".editar")
    inp.forEach((inpt) => {
        inpt.removeAttribute('disabled', 'true')
    })

}


// Começo Edita

function gerarObjetoUsuario() { // OK

    let nome = document.querySelector("#nome").value;
    let cpf = document.querySelector("#cpf").value;
    let email = document.querySelector("#email").value;
    let cep = document.querySelector("#cep").value;
    let rua = document.querySelector("#rua").value;
    let numero = document.querySelector("#numero").value;
    let bairro = document.querySelector("#bairro").value;
    let cidade = document.querySelector("#cidade").value;
    let estado = document.querySelector("#estado").value;
    let complemento = document.querySelector("#complemento").value;
    let telefone = document.querySelector("#telefone").value;
    let alterar = true;

    return { // Cria o objeto 
        nome, cpf, email, cep, rua, numero, bairro, cidade, estado, complemento, telefone, alterar
    }

}

function formularioValido(dadosUsuario) { // OK 
    let campoVazio = false;
    const arrayDadosUser = Object.values(dadosUsuario);
    arrayDadosUser.forEach(cont => {
        if (cont === '') {
            campoVazio = true;
        }
    });

    return !campoVazio;
}


function salvaEdicao() { // OK
    document.querySelector("#salvar").style.display = 'none';
    document.querySelector("#editar").style.display = 'inline';

    let dadosUsuario = gerarObjetoUsuario();
    if (formularioValido(dadosUsuario)) {
        fetch('includes/logica/logica_usuario.php', {
            method: 'put',
            body: JSON.stringify(dadosUsuario) // Converte para JSON
        }).then((response) => {
            return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
        }).then(data => {
            let result = JSON.parse(data)
            //console.log(result)
            alert("Dados Atualizados Com Sucesso")
            // boasvindas()
        });

    } else {
        alert("Verifique os Campos, Existem Campos Não Preenchidos")
    }

    recuperarDadosEdita();
}

// Fim Edita


function excluirConta() {
    if (window.confirm("Deseja Realmente Excluir Sua Conta ?")) {
        let excluirConta = true;
        let obj = { excluirConta };
        console.log(obj);
        fetch('includes/logica/logica_usuario.php', {
            method: 'delete',
            body: JSON.stringify(obj) // Converte para JSON
        }).then((response) => {
            return response.text() 
        }).then(data => {
            //let result = JSON.parse(data)
            //console.log(result)
            alert("USUARIO EXCLUIDO !!! ")
            window.location = 'login.html'
        });
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    let cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        let validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('estado').value = "...";
            // document.getElementById('ibge').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};


function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('rua').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
    document.getElementById('estado').value = ("");
    // document.getElementById('ibge').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('estado').value = (conteudo.uf);
        // document.getElementById('ibge').value=(conteudo.ibge);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}



function cadastrarUsuario() {
    // const formulario = document.querySelector("#cadastro") 
    // formulario.preventDefault()

    const dadosUsuario = gerarObjetoUsuarioCadastro()
    console.log(dadosUsuario);

    if (formularioValido(dadosUsuario)) {
        fetch('includes/logica/logica_usuario.php', {
            method: 'post',
            body: JSON.stringify(dadosUsuario)// converte para JSON o JSON.stringify // body apenas quando quero fazer um post
        }).then((response) => {
            return response.json() 
        }).then(data => {
            console.log(data);
            if (data.result == "true") {
                const resetar = document.querySelector("#cadastro");
                alert("Usuario Cadastrado !!");
                document.querySelector("#cadastrarUsuario").reset()
                // Aqui redireciona o window
                window.location = 'home.html'
            }
        });
    } else {
        alert("Verifique os Campos, Existe  Campos Não Preenchidos");
    }
}


function gerarObjetoUsuarioCadastro() {
    const nome = document.querySelector('#nome').value;
    const cpf = document.querySelector('#cpf').value;
    const email = document.querySelector('#emails').value;
    const cep = document.querySelector('#cep').value;
    const rua = document.querySelector('#rua').value;
    const numero = document.querySelector('#numero').value;
    const bairro = document.querySelector('#bairro').value;
    const cidade = document.querySelector('#cidade').value;
    const estado = document.querySelector('#estado').value;
    const complemento = document.querySelector('#complemento').value;
    const telefone = document.querySelector('#telefone').value;
    const senha = document.querySelector('#senha').value;
    const status = 1;
    //const dt_nascimento = ObterValor('dt_nascimento');
    const cadastrar = true;
    return { // Cria o objeto 
        nome, cpf, email, cep, rua, numero, bairro, cidade, estado, complemento, status, senha, telefone, cadastrar
    }

}


function pesquisaemail(email) {
    let validaEmail = true
    let obj = { validaEmail, email }
    console.log(obj)
    fetch('includes/logica/logica_usuario.php', {
        method: 'POST',
        body: JSON.stringify(obj)
    }).then((response) => {
        return response.json()
    }).then(data => {
        console.log('Recebendo dados!')
        console.log(data);
        if (data.result == "true") {
            alert(`Email: ${email} já cadastrado`)
            document.querySelector("#emails").value = ' ';
            // document.querySelector("#email").reset();
                 
        }

    }).catch(error => {
        console.log(`Erro ao conectar:\n\n${error.message}`)
    });

}


function contatoForm(event){
    event.preventDefault()
    const nome = document.querySelector("#nome").value;
    const EmailRes = document.querySelector("#emailcont").value;
    const assunto = document.querySelector("#assunto").value;
    const conteudo = document.querySelector("#conteudo").value;
    // console.log(EmailRes)
    // console.log(nome)
    // console.log(assunto)
    // console.log(conteudo)
    let contato = true
    let obj = { nome , EmailRes, assunto, conteudo ,contato }
    fetch('includes/logica/logica_usuario.php', {
        method: 'POST',
        body: JSON.stringify(obj)
    }).then((response) => {
        return response.json()
    }).then(data => {
        console.log('Recebendo dados!')
        console.log(data);
        if (data.success == true) {
            document.querySelector("#contato").reset()
            alert("Contato Enviado Com Sucesso")
                        
        }else{
            alert("Falha No Envio! Tente Novamente!! ")
        }

    }).catch(error => {
        console.log(`Erro ao conectar:\n\n${error.message}`)
    });

    

}


function email(el){
    console.log(el.value)
}

function paginaAtualMenu (){
    
}