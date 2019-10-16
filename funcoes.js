function inserir(formulario) {
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
    
function valida_sessao(formulario){

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
    
    
function listar(formulario) {
        
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
    
function autentica(){
    
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
 
function recuperaDados(){
    fetch('./dados.php', {
        method: 'get',
        mode: 'cors'
        })
        .then(response => response.json())
        .then(function result (dados){
            //console.log(dados);
            boasvindas(dados);
            
        })
    .catch(error => {
        console.log(`Erro ao conectar:\n\n${error.message}`)
    });
}

function boasvindas(dado){
    document.querySelector('#welcome').innerHTML = `Olá ${dado.nome} `;    
}


function sair() {
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
    
function listaUsuario(){
    
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
    

function recuperarDadosEdita(){

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
            //console.log(dados);
            if (dados.status == 'true') {
                console.log(dados.status);
                console.log(dados);
            }else {
                console.log(dados.status);
                alert('Usuario Não Encontrado ')
            }
        })
       
    .catch(error => {
        console.log(`Erro ao conectar:\n\n${error.message}`)
    });
}
    

