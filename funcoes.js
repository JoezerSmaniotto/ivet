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
                let texto=document.getElementById('texto');
                alert(data);
                texto.innerHTML=data;
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
}
    
function valida_sessao(formulario){ // OK

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
                   window.location='home.html'
                }
                else{
                    let texto=document.getElementById('texto');
                    texto.innerHTML = dados.mensagem;
                };
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
    
}
    
    
function listar(formulario) { // ??
        
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
                let texto=document.getElementById('texto');
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
    
function autentica(){ // OK
    
        fetch('autentica.php', {
        method: 'POST',
        mode: 'no-cors'
        })
        .then(response => {
                return response.json();
            }).then(dados => {
                console.log('Recebendo dados!');
                //console.log(dados);
                if (dados) {
                    if (dados.sucesso==false) {
                        window.location='login.html'
                    }else{
                       return dados.sucesso;
                    }
                }
            })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
    
}
 
// function recuperaDados(){ // OK
//     fetch('./dados.php', {
//         method: 'get',
//         mode: 'cors'
//         })
//         .then(response => response.json())
//         .then(function result (dados){
//             //console.log(dados);
//             boasvindas(dados);
            
//         })
//     .catch(error => {
//         console.log(`Erro ao conectar:\n\n${error.message}`)
//     });
// }


function boasvindas(){ // OK
    let apresentarUser = true
    let obj =  { apresentarUser }
    fetch('includes/logica/logica_usuario.php', {
        method: 'post',
        mode: 'cors',
        body: JSON.stringify(obj)
    })
        .then(response => response.json())
        .then(function result (dados){
            document.querySelector('#welcome').innerHTML = `Olá ${dados.nome} `;
            
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
    body:formData,
    mode: 'no-cors'
    })
    .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!');
            console.log(dados);
            if (dados.sair==true) {
              window.location='login.html'
            }
        
    })
    .catch(error => {
        console.log(`Erro ao conectar:\n\n${error.message}`)
    });
    
}
    
function listaUsuario(){ // ???
    
    fetch('listagem.php', {
        method: 'POST',
        mode: 'no-cors'
    })
    .then(response => {
            return response.json();
         }).then(dados => {
            console.log('Recebendo dados!')
            if (dados) {
                let usuario=document.getElementById('usuario')
                let tamanho = dados.length 
                for(let i=0; i < tamanho; i++)
                {
                    let opt = document.createElement("option")
                    opt.value = dados[i].id
                    opt.text = dados[i].nome
    
                    usuario.add(opt, usuario.options[i+1])
                }
                
            }
        })
        .catch(error => {
            console.log(`Erro ao conectar:\n\n${error.message}`)
        });
}   
    

function recuperarDadosEdita(){ // OK 

    var formData = new FormData();
    formData.append('editar','editarrr')              
    fetch('includes/logica/logica_usuario.php', {
        method: 'POST',
        body:formData,
        mode: 'no-cors'
    })

    .then(response => {
            return response.json();
        }).then(dados => {
            console.log('Recebendo dados!')
            console.log(dados);
            if(dados.result == 'true') {
                document.querySelector("#nome").value = dados.nome;
                document.querySelector("#cpf").value = dados.cpf;
                document.querySelector("#email").value = dados.e_mail;
                document.querySelector("#cep").value = dados.cep
                document.querySelector("#rua").value = dados.rua;
                document.querySelector("#numero").value = dados.numero;
                document.querySelector("#cidade").value = dados.cidade;
                document.querySelector("#estado").value = dados.estado;
                document.querySelector("#complemento").value = dados.complemento;
                document.querySelector("#telefone").value = dados.telefone;
                document.querySelector("#salvar").style.display = 'none';
                let  inp = document.querySelectorAll("input")
                inp.forEach( (inpt) => {
                    inpt.setAttribute('disabled','true')
                })
                                              
            }else {
                console.log(dados.result);
                alert('Usuario Não Encontrado ')
            }
        })
       
    .catch(error => {
        console.log(`Erro ao conectar:\n\n${error.message}`)
    });
}
    

function habilitaEdicao(){  // OK
    document.querySelector("#salvar").style.display = 'inline';
    document.querySelector("#editar").style.display = 'none';

    let  inp = document.querySelectorAll("input")
    inp.forEach( (inpt) => {
        inpt.removeAttribute('disabled','true')
    }) 

}


// Começo Edita

function gerarObjetoUsuario(){ // OK

    let nome = document.querySelector("#nome").value;
    let cpf = document.querySelector("#cpf").value;
    let email = document.querySelector("#email").value;
    let cep = document.querySelector("#cep").value;
    let rua = document.querySelector("#rua").value;
    let numero = document.querySelector("#numero").value;
    let cidade = document.querySelector("#cidade").value;
    let estado = document.querySelector("#estado").value;
    let complemento = document.querySelector("#complemento").value;
    let telefone = document.querySelector("#telefone").value;
    let alterar = true;

    return { // Cria o objeto 
      nome,cpf,email,cep,rua,numero,cidade,estado,complemento,telefone,alterar
    }

}

function formularioValido(dadosUsuario){ // OK 
    let campoVazio = false; 
    const arrayDadosUser = Object.values(dadosUsuario);
    arrayDadosUser.forEach(cont=>{
      if(cont === ''){
         campoVazio = true;
      }
    });

    return !campoVazio;  
}


function salvaEdicao(){ // OK
    document.querySelector("#salvar").style.display = 'none';
    document.querySelector("#editar").style.display = 'inline';

    let dadosUsuario = gerarObjetoUsuario();
    if(formularioValido(dadosUsuario)){
        fetch('includes/logica/logica_usuario.php',{
            method:'put',
            body: JSON.stringify(dadosUsuario) // Converte para JSON
        }).then ((response) => { return response.text() // esse .text poderia ser json() se sim o que mudaria ??  ???
        }).then( data => {
            let result = JSON.parse(data)
            console.log(result)
            alert("Dados Atualizados Com Sucesso")
            boasvindas()
        });
        
    }else {
        alert("Verifique os Campos, Existem Campos Não Preenchidos")
    }

    recuperarDadosEdita();
}

// Fim Edita


function excluirConta(){
    if(window.confirm("Deseja Realmente Excluir Sua Conta ?")){
        let excluirConta = true;
        let obj =  { excluirConta };
        console.log(obj);
        fetch('includes/logica/logica_usuario.php',{
            method:'delete',
            body: JSON.stringify(obj) // Converte para JSON
        }).then ((response) => { return response.text() // esse .text poderia ser json() se sim o que mudaria ??  ???
        }).then( data => {
            //let result = JSON.parse(data)
            //console.log(result)
            alert("USUARIO EXCLUIDO !!! ")
            window.location='login.html'
        });
    }
}


