   
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
   
    document.getElementById('cep').value=("");
 
}

function meu_callback(conteudo) {
  if (!("erro" in conteudo)) {

  } //end if.
  else {
    //CEP não Encontrado.
    limpa_formulário_cep();
    alert("CEP não encontrado.");
  }
}

function pesquisacep(valor) {

  //Nova variável "cep" somente com dígitos.
  var cep = valor.replace(/\D/g, '');

  //Verifica se campo cep possui valor informado.
  if (cep != "") {

    //Expressão regular para validar o CEP.
    var validacep = /^[0-9]{8}$/;

    //Valida o formato do CEP.
    if(validacep.test(cep)) {

        //Cria um elemento javascript.
        var script = document.createElement('script');

        //Sincroniza com o callback.
        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

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
}


function retornaRaca (){
      let esc = document.querySelector("#raca");
      let racass = true;
      let obj =  { racass };
      console.log(obj);
      fetch('includes/logica/logica_animal.php',{
          method:'post',
          body: JSON.stringify(obj) // Converte para JSON
      }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
      }).then( data => {
          data.forEach((ind)=>{
            document.getElementById('raca').options.add(new Option(ind.nomer,ind.id))

          })

      });
}

function cadastrarPet(event){
 
  event.preventDefault()
  const formulario = document.querySelector("#cadastro")
  const dadosAnimal = gerarObjetoAnimalCadastro()
  
  console.log(dadosAnimal);
  let formData = new FormData();
  if( formularioValido(dadosAnimal)){
    
    Object.entries(dadosAnimal).forEach(([key, value]) => {
      // console.log(key + " = " + value)
      formData.append(key, value)
    });
    // console.log(formData)
    fetch('includes/logica/logica_animal.php',{ // 
      method: 'POST',
      body: formData,
      }).then (response => { return response.json() 
      }).then( data => {
        // console.log(data)
          if(data == 'true'){
              console.log(data)
              alert("Animal Cadastrado Com Sucesso");
              formulario.reset()
          }else if(data.result == 'Arquivo ja existe'){
            alert("Arquivo já existe !!");
            console.log(`${data}`)
          }else if(data.result == 'Arquivo deve ter o no maximo 20000000 bytes'){
            alert("Arquivo deve ter o no máximo 20000000 bytes !!");
            console.log(data)
          }else if(data.result == 'Extensao de arquivo invalida para upload'){
            alert("Extensão de arquivo invalida para upload");
            console.log(data)
          }else if(data.result == 'Arquivo nao pode ser copiado para o servidor'){
              alert("Arquivo nao pode ser copiado para o servidor");
              console.log(data)
          }else if(data.result == 'Selecione o arquivo a ser enviado'){
            alert("Selecione o arquivo a ser enviado");
            console.log(data)
          }  

      });
  
  }else{
    alert("Verifique os Campos, Existe  Campos Não Preenchidos");
  }


}

function escondeForm(){
  document.querySelector("#editaPet").style.display = 'none';
  // document.querySelector("#editar").style.display = 'inline';
}


function gerarObjetoAnimalCadastro(){
  const nome = document.querySelector('#nome').value;
  const dt_nasc = document.querySelector('#dt_nasc').value;
  const tipo = document.querySelector('#SeletorTipo').value;
  const sexo = document.querySelector('#SeletorSexo').value;
  const raca = document.querySelector('#raca').value;
  const localizacao = document.querySelector('#cep').value;
  const obs = document.querySelector('#obs').value;
  const img = document.querySelector('#imgPet').files[0];
  const cadastrar = true;
  return { // Cria o objeto
    nome,dt_nasc,tipo,sexo,raca,localizacao,obs,img,cadastrar
  }

}


function formularioValido(dadosAnimal){ // OK 
  let campoVazio = false; 
  const arrayDadosUser = Object.values(dadosAnimal);
  arrayDadosUser.forEach(cont=>{
    if(cont === ''){
       campoVazio = true;
    }
  });

  return !campoVazio;  
}


function excluirAnimal(idAnimal,nome){
  
  if(window.confirm(`Deseja Realmente Excluir o ${nome} Pet?`)){
    let excluirPet = true; 
    let obj =  { excluirPet,idAnimal };
    console.log(obj);
    fetch('includes/logica/logica_animal.php',{
        method:'delete',
        body: JSON.stringify(obj) // Converte para JSON
    }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
    }).then( data => {
        // console.log(data)
        if(data.result == 'Animal Exluído'){
          alert(`O Pet foi exluído com Sucesso`)
          showPets();
        }
    });
  }  
}

function editarAnimal(id){
  if(window.confirm(`Deseja Realmente Editar o Pet?`)){
    let recuperaDadosPet = true,idAnimal=id; 
    let obj =  { recuperaDadosPet,idAnimal };
    console.log(obj);
    fetch('includes/logica/logica_animal.php',{
        method:'post',
        body: JSON.stringify(obj) // Converte para JSON
    }).then ((response) => { return response.json() // 
    }).then( dados => {
        console.log(dados)
        document.querySelector("#nome").value = dados.nome;
        document.querySelector("#dt_nasc").value = dados.nascimento;
        document.querySelector("#SeletorTipo").value = dados.tipo;
        document.querySelector("#SeletorSexo").value = dados.sexo;
        document.querySelector("#raca").value = dados.fk_raca_id;
        document.querySelector("#cep").value = dados.localizacao;
        document.querySelector("#obs").value = dados.observacoes;
        document.querySelector("#idpet").value = dados.id_animal;
        document.querySelector("#imgAnt").value = dados.imagem;
        document.querySelector("#editaPet").style.display = 'inline';
        window.scrollTo( 0, 0 ); // Manda para o formulário

    });
  }  
 

}

// Começo Edita

function gerarObjetoPetEdita(){ // OK
  const nome = document.querySelector('#nome').value;
  const dt_nasc = document.querySelector('#dt_nasc').value;
  const tipo = document.querySelector('#SeletorTipo').value;
  const sexo = document.querySelector('#SeletorSexo').value;
  const raca = document.querySelector('#raca').value;
  const localizacao = document.querySelector('#cep').value;
  const obs = document.querySelector('#obs').value;
  const id_Animal = document.querySelector("#idpet").value;
  const imgAnt = document.querySelector("#imgAnt").value;
  const img = document.querySelector('#imgPet').files[0];
  const editaPet = true;
  return { // Cria o objeto 
    nome,dt_nasc,tipo,sexo,raca,localizacao,obs,id_Animal,img,imgAnt,editaPet
  }

}

function formularioValidoEdita(dadosAnimal){ // OK 
  let campoVazio = false; 
  // const arrayDadosUser = Object.values(dadosAnimal);
  const arrayDadosUser = Object.entries(dadosAnimal);
  // console.log(Object.entries(dadosAnimal));

  arrayDadosUser.forEach(cont=>{
    if(cont[0]!='img' && cont[1] === ''){ // ??
       campoVazio = true;
    }
  });

  return !campoVazio;  
}


function salvaEditaPet(event){
  event.preventDefault()
  let dadosAnimal = gerarObjetoPetEdita();
  let formData = new FormData();
  if(formularioValidoEdita(dadosAnimal)){
      Object.entries(dadosAnimal).forEach(([key, value]) => {
        // console.log(key + " = " + value)
        formData.append(key, value)
      });
      console.log(dadosAnimal)
      // console.log(`Dados Envia Alteração: ${dadosAnimal}`)
      fetch('includes/logica/logica_animal.php',{
          method: 'POST',
          body: formData,
      }).then ((response) => { return response.json() 
      }).then( dados => {
        console.log(dados)
        if(dados.result == 'true'){
          console.log(dados)
          escondeForm()
          alert("Dados Atualizados Com Sucesso")
          function gerarObjetoPetEdita(){ // OK
            const nome = document.querySelector('#nome').value;
            const dt_nasc = document.querySelector('#dt_nasc').value;
            const tipo = document.querySelector('#SeletorTipo').value;
            const sexo = document.querySelector('#SeletorSexo').value;
            const raca = document.querySelector('#raca').value;
            const localizacao = document.querySelector('#cep').value;
            const obs = document.querySelector('#obs').value;
            const id_Animal = document.querySelector("#idpet").value;
            const imgAnt = document.querySelector("#imgAnt").value;
            const img = document.querySelector('#imgPet').files[0];
            const editaPet = true;
            return { // Cria o objeto 
              nome,dt_nasc,tipo,sexo,raca,localizacao,obs,id_Animal,img,imgAnt,editaPet
            }
          
          }
          
          function formularioValidoEdita(dadosAnimal){ // OK 
            let campoVazio = false; 
            // const arrayDadosUser = Object.values(dadosAnimal);
            const arrayDadosUser = Object.entries(dadosAnimal);
            // console.log(Object.entries(dadosAnimal));
          
            arrayDadosUser.forEach(cont=>{
              if(cont[0]!='img' && cont[1] === ''){ // ??
                 campoVazio = true;
              }
            });
          
            return !campoVazio;  
          }
          
          
          function salvaEditaPet(event){
            event.preventDefault()
            let dadosAnimal = gerarObjetoPetEdita();
            let formData = new FormData();
            if(formularioValidoEdita(dadosAnimal)){
                Object.entries(dadosAnimal).forEach(([key, value]) => {
                  // console.log(key + " = " + value)
                  formData.append(key, value)
                });
                console.log(dadosAnimal)
                // console.log(`Dados Envia Alteração: ${dadosAnimal}`)
                fetch('includes/logica/logica_animal.php',{
                    method: 'POST',
                    body: formData,
                }).then ((response) => { return response.json() 
                }).then( dados => {
                  console.log(dados)
                  if(dados.result == 'true'){
                    console.log(dados)
                    escondeForm()
                    alert("Dados Atualizados Com Sucesso")
                    showPets()
                  // }else {
                  //   alert("Dados Não Atualizados")
                  // }
                  } if(dados.result == 'Arquivo ja existe'){
                    alert("Arquivo já existe !!");
                    // console.log(`${dados}`)
                  }else if(dados.result == 'Arquivo deve ter o no maximo 20000000 bytes'){
                    alert("Arquivo deve ter o no máximo 20000000 bytes !!");
                    // console.log(dados)
                  }else if(dados.result == 'Extensao de arquivo invalida para upload'){
                    alert("Extensão de arquivo invalida para upload");
                    // console.log(dados)
                  }else if(dados.result == 'Arquivo nao pode ser copiado para o servidor'){
                      alert("Arquivo nao pode ser copiado para o servidor");
                      // console.log(dados)
                  }else if(dados.result == 'Selecione o arquivo a ser enviado'){
                    alert("Selecione o arquivo a ser enviado");
                    // console.log(dados)
                  }
          
                    
                });
                
            }else {
                alert("Verifique os Campos, Existem Campos Não Preenchidos")
            }
          
            // recuperarDadosEdita();
          
          
          }
          
          showPets()
        // }else {
        //   alert("Dados Não Atualizados")
        // }
        } if(dados.result == 'Arquivo ja existe'){
          alert("Arquivo já existe !!");
          // console.log(`${dados}`)
        }else if(dados.result == 'Arquivo deve ter o no maximo 20000000 bytes'){
          alert("Arquivo deve ter o no máximo 20000000 bytes !!");
          // console.log(dados)
        }else if(dados.result == 'Extensao de arquivo invalida para upload'){
          alert("Extensão de arquivo invalida para upload");
          // console.log(dados)
        }else if(dados.result == 'Arquivo nao pode ser copiado para o servidor'){
            alert("Arquivo nao pode ser copiado para o servidor");
            // console.log(dados)
        }else if(dados.result == 'Selecione o arquivo a ser enviado'){
          alert("Selecione o arquivo a ser enviado");
          // console.log(dados)
        }

          
      });
      
  }else {
      alert("Verifique os Campos, Existem Campos Não Preenchidos")
  }

  // recuperarDadosEdita();


}


function showPets(){
    let apresentarPets = true;
    let obj =  { apresentarPets };
    fetch('includes/logica/logica_animal.php',{
        method:'post',
        body: JSON.stringify(obj) // Converte para JSON
    }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
    }).then( data => {
       console.log(data)
        if(data.result =="Não Há Animais Cadastrados"){
            let reposta = document.querySelector("#listarPets")
            document.querySelector('#listarPets').innerText = "";
            let p4 = document.createElement('p')
            let conteudo = document.createTextNode(" Não Há Animais Cadastrados ")
            reposta.appendChild(conteudo)     
            alert("Não Há Animais Cadastrados");
        }else{
            let tipoA,Sx;
            document.querySelector('#listarPets').innerText = "";
            data.forEach((item,index)=>{
                // console.log(index);
                // console.log(item);
                if (item.tipo == 'C') {
                  tipoA = "Cão";            
                }else{
                  tipoA = "Gato"
                }

                if (item.sexo == 'F') {
                  Sx = "Fêmea";              
                }else{
                  Sx = "Macho";
                }  
                // https://media-manager.noticiasaominuto.com/1920/naom_5c43865b1e42c.jpg
                let caminhoImg = `imagens/${item.imagem}`;
                document.querySelector('#listarPets').innerHTML += `
                <div class="col-md-4 pt-2">
                 <div class="card mb-4 shadow-sm">
                  <img class="card-img-top imganimal" src="${caminhoImg}" alt="Card image cap">
                   <div class="card-body overflow-auto">
                     <p class="card-text"> Nome: ${item.nome} | Tipo: ${tipoA} | Raça: ${item.nomer} <br></p>
                     <p class="card-text"> Sexo: ${Sx} | Data Nasc: ${item.nascimento} | Localização: ${item.localizacao} <br></p>
                     <p class="card-text"> Observações: ${item.observacoes} <br></p> 
                     <div class="d-flex justify-content-between align-items-center">
                       <div class="btn-group">
                         <button type="button" class="btn btn-sm btn-outline-secondary" onclick="excluirAnimal(${item.id_animal},'${item.nome}')" >Exclui</button>
                         <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editarAnimal(${item.id_animal})">Edita</button>
                       </div>
                     
                     </div>
                   </div>
                 </div>
               </div> `;

                // document.querySelector('#listarPets').innerHTML += `Nome: ${item.nome} | Tipo: ${tipoA} | Raça: ${item.nomer} <br>`;
                // document.querySelector('#listarPets').innerHTML += `Sexo: ${Sx} | Data Nasc: ${item.nascimento} | Localização: ${item.localizacao} <br>`;
                // document.querySelector('#listarPets').innerHTML += `Observações: ${item.observacoes} <br>`;
                // document.querySelector('#listarPets').innerHTML += `<button onclick="excluirAnimal(${item.id_animal},'${item.nome}')">Exclui</button>`;
                // document.querySelector('#listarPets').innerHTML += `<button onclick="editarAnimal(${item.id_animal})">Edita</button>`;
                // document.querySelector('#listarPets').innerHTML += `<br><hr>`;

              })

        }
    
      })    
}


function solicitaAdota(id_animal){
  let solicitaAdocao = true;
  let obj =  { solicitaAdocao,id_animal};
  fetch('includes/logica/logica_animal.php',{
      method:'post',
      body: JSON.stringify(obj) // Converte para JSON
  }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
  }).then( data => {
     console.log(data)
     
  });

}


function showPetsTotal(){
  let apresentarPetsTotal = true;
  let obj =  { apresentarPetsTotal };
  fetch('includes/logica/logica_animal.php',{
      method:'post',
      body: JSON.stringify(obj) // Converte para JSON
  }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
  }).then( data => {
     console.log(data)
      // if(data.result =="Não Há Animais Cadastrados"){
      //     let reposta = document.querySelector("#listarPets")
      //     document.querySelector('#listarPets').innerText = "";
      //     let p4 = document.createElement('p')
      //     let conteudo = document.createTextNode(" Não Há Animais Cadastrados ")
      //     reposta.appendChild(conteudo)     
      //     alert("Não Há Animais Cadastrados");
      // }else{
          let tipoA,Sx;
          // document.querySelector('#listarPets').innerHTML = "";
          // document.querySelector('#listarPets').innerHTML = `
          
          // `;

          let caminhoImg ;
           data.forEach((item,index)=>{
              console.log(index);
               console.log(item);
               if (item.tipo == 'C') {
                 tipoA = "Cão";            
               }else{
                 tipoA = "Gato"
               }
               if (item.sexo == 'F') {
                 Sx = "Fêmea";              
               }else{
                 Sx = "Macho";
               } 
              
              caminhoImg = `imagens/${item.imagem}`;
              document.querySelector('#listarPets').innerHTML += `
              <div class="col-md-4">
               <div class="card mb-4 shadow-sm">
                <img class="card-img-top imganimal" src="${caminhoImg}" alt="Card image cap">
                 <div class="card-body overflow-auto">
                   <p class="card-text"> Nome: ${item.nome} | Tipo: ${tipoA} | Raça: ${item.nomer} <br></p>
                   <p class="card-text"> Sexo: ${Sx} | Data Nasc: ${item.nascimento} | Localização: ${item.localizacao} <br></p>
                   <p class="card-text"> Observações: ${item.observacoes} <br></p> 
                   <div class="d-flex justify-content-between align-items-center">
                     <div class="btn-group">
                       <button type="button" class="btn btn-sm btn-outline-secondary" onclick="solicitaAdota(${item.id_animal})" >Adote</button>
                       <button type="button" class="btn btn-sm btn-outline-secondary">Maiss</button>
                     </div>
                   </div>
                 </div>
               </div>
             </div> `;


            
            })
  
    })    
}

function aceitaAdocao(id_animal,id_usu){
  if(window.confirm("Deseja Aceitar o Pedido de Adoção ?")){
    let efetivaAdocao = true;
    let obj =  { efetivaAdocao,id_animal,id_usu};
    fetch('includes/logica/logica_animal.php',{
        method:'post',
        body: JSON.stringify(obj) // Converte para JSON
    }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
    }).then( data => {
      console.log(data)
        if(data.result =="Adoção Efetivada"){
          alert("Adoção Efetivada Com Sucesso");
          showSolicitacoes()   
        }else{
          alert("Adoção Não Efetivada");
          showSolicitacoes()
        }
    
      })  

  }

}

function rejeitarAdocao(id_animal,id_usu){
  if(window.confirm("Deseja Rejeitar o Pedido de Adoção ?")){
    let rejeitarAdocao = true;
    let obj =  { rejeitarAdocao,id_animal,id_usu};
    fetch('includes/logica/logica_animal.php',{
        method:'post',
        body: JSON.stringify(obj) // Converte para JSON
    }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
    }).then( data => {
      console.log(data)
        if(data.result =="Rejeição Efetivada"){
          alert("Rejeição Efetivada Com Sucesso");
          showSolicitacoes()   
        }else{
          alert("Rejeição Não Efetivada Com Sucesso");
          showSolicitacoes()
        }
    
      })  
  }
}


function showSolicitacoes(){
  let apresentarSolicitacoesAdocao = true;
  let obj =  { apresentarSolicitacoesAdocao };
  fetch('includes/logica/logica_animal.php',{
      method:'post',
      body: JSON.stringify(obj) // Converte para JSON
  }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
  }).then( data => {
     console.log(data)
      if(data.result =="Não Há Solicitações"){
          let reposta = document.querySelector("#listarPets")
          document.querySelector('#listarPets').innerText = "";
          let p4 = document.createElement('p')
          let conteudo = document.createTextNode(" Não Há Solicitações !!")
          reposta.appendChild(conteudo)     
          alert("Não Há Solicitações");
      }else{
          let tipoA,Sx;
          document.querySelector('#listarPets').innerText = "";
          data.forEach((item)=>{
              document.querySelector('#listarPets').innerHTML += `O usuario: ${item.nome} com e-mail: ${item.e_mail} <br>`;
              document.querySelector('#listarPets').innerHTML += `Deseja Adotar o Pet ${item.nomeani}  da raça ${item.nomer} <br>`;
              document.querySelector('#listarPets').innerHTML += `<button onclick="aceitaAdocao(${item.id_animal},${item.id_usu})">Aceito !</button>`;
              document.querySelector('#listarPets').innerHTML += `<button onclick="rejeitarAdocao(${item.id_animal},${item.id_usu})">Rejeitar !</button>`;
              document.querySelector('#listarPets').innerHTML += `<br><hr>`;
            })

      }
  
    })    
}





































// function showPets(){
//     let apresentarPets = true;
//     let obj =  { apresentarPets };
//     fetch('includes/logica/logica_animal.php',{
//         method:'post',
//         body: JSON.stringify(obj) // Converte para JSON
//     }).then ((response) => { return response.json() // esse .text poderia ser json() se sim o que mudaria ??  ???
//     }).then( data => {
//        console.log(data)
//         if(data.result =="Não Há Animais Cadastrados"){
//             let reposta = document.querySelector("#listarPets")
//             document.querySelector('#listarPets').innerText = "";
//             let p4 = document.createElement('p')
//             let conteudo = document.createTextNode(" Não Há Animais Cadastrados ")
//             reposta.appendChild(conteudo)     
//             alert("Não Há Animais Cadastrados");
//         }else{
//             let tipoA,Sx;
//             document.querySelector('#listarPets').innerText = "";
//             let reposta = document.querySelector("#listarPets")
//             let ma = document.createElement('main')
//             let d = document.createElement('div')
//             let d1 = document.createElement('div')
//             let d2 = document.createElement('div')
//             let d3 = document.createElement('div')
//             let h = document.createElement('hr')
//             let b = document.createElement('br')
//             data.forEach((item,index)=>{
//                 console.log(index);
//                 console.log(item);
//                 if (item.tipo == 'C') {
//                   tipoA = "Cão";            
//                 }else{
//                   tipoA = "Gato"
//                 }

//                 if (item.sexo == 'F') {
//                   Sx = "Femea";              
//                 }else{
//                   Sx = "Macho";
//                 }  
//                 let cont = document.createTextNode(`Nome: ${item.nome} | Tipo: ${tipoA} | Raça: ${item.nomer}`)
//                 let cont1 = document.createTextNode(`Sexo: ${Sx} | Data Nasc: ${item.nascimento} | Localização: ${item.localizacao}`)
//                 let cont2 = document.createTextNode(`Observações: ${item.observacoes}`)
//                 let cont3 = '<hr>';
//                 // acoes.innerHTML=(texto_Acao); 
//                 d.appendChild(cont)
//                 d1.appendChild(cont1)
//                 d2.appendChild(cont2)   
//                 d3.innerHTML = "(cont3)"; 
                
//                 ma.appendChild(cont);
//                 ma.appendChild(cont1);
//                 ma.appendChild(cont2);
//                 ma.appendChild(cont3);

//                 reposta.appendChild(ma)   
//             })

//         }
    
//       })    
// }





        //  Object.values ​​(data).forEach((item) => {
      //   if (typeof item == "string") retorna;

      //   if (item.tipo == 'C') {
      //     tipoA = Cão;              
      //   }outro{
      //     tipoA = Gato;
      //   }

      //   if (item.sexo == 'F') {
      //     Sx = Femea;              
      //   }outro{
      //     Sx = Macho;
      //   }
      //   p.innerText (`Nome: $ {item.nome} | Tipo: $ {tipoA} | Raça: $ {item.nomer}`)
      //   p1.innerText (`Sexo: $ {Sx} | Data Nasc: $ {item.dt_nasc} | Localização: $ {item.localizacao}`)
      //   p2.innerText (`Observações: $ {item.obs}`)
      //   sel.appendChild (p)
      //   sel.appendChild (p1)
      //   sel.appendChild (p2)
      //   insere.appendChild (sel)
       
      //   }) 


      //  if(data.result == 'true'){
      //     let insere = document.getElementById('listarPets');
      //     let tipoA;
      //     let Sx;
      //     let sel = document.createElement('article')
      //     let p = document.createElement('p');
      //     let p1 = document.createElement('p');
      //     let p2 = document.createElement('p');
      //     data.forEach((item)=>{
      //       if(item.tipo =='C'){
      //         tipoA=Cão;              
      //       }else{
      //         tipoA=Gato;
      //       }

      //       if(item.sexo =='F'){
      //         Sx=Femea;              
      //       }else{
      //         Sx=Macho;
      //       }
      //       p.innerText(`Nome: ${item.nome}  | Tipo: ${tipoA} | Raça:${item.nomer}  `)
      //       p1.innerText(`Sexo: ${Sx} |Data Nasc: ${item.dt_nasc} | Localização: ${item.localizacao}`)
      //       p2.innerText(`Observações: ${item.obs}`)
      //       sel.appendChild(p)
      //       sel.appendChild(p1)
      //       sel.appendChild(p2)
      //       insere.appendChild(sel)
            
      //     })  

      //  }else{

      //  }
  
