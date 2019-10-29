   
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
      let raca = true;
      let obj =  { raca };
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

//  Cadastrar animal


function cadastrarPet(){
  // const formulario = document.querySelector("#cadastro") 
  // formulario.preventDefault()

  const dadosAnimal = gerarObjetoAnimalCadastro()
  
  console.log(dadosAnimal);

  if( formularioValido(dadosAnimal)){
    fetch('includes/logica/logica_animal.php',{
      method: 'post',
      body: JSON.stringify(dadosAnimal)
      }).then ((response) => { return response.json() 
      }).then( data => {
          if(data.result == 'true'){
              alert("Animal Cadastrado Com Sucesso");
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
  const cadastrar = true;
  return { // Cria o objeto 
    nome,dt_nasc,tipo,sexo,raca,localizacao,obs,cadastrar
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


function excluirAnimal(idAnimal){
 
  if(window.confirm(`Deseja Realmente Excluir o Pet?`)){
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

                document.querySelector('#listarPets').innerHTML += `Nome: ${item.nome} | Tipo: ${tipoA} | Raça: ${item.nomer} <br>`;
                document.querySelector('#listarPets').innerHTML += `Sexo: ${Sx} | Data Nasc: ${item.nascimento} | Localização: ${item.localizacao} <br>`;
                document.querySelector('#listarPets').innerHTML += `Observações: ${item.observacoes} <br>`;
                // document.querySelector('#listarPets').innerHTML += `<button onclick="editarProd(${item.id_animal})">Edita</button> <button onclick="excluirAnimal(${item.id_animal},${item.nome})">Exclui</button> <br> <hr>`;
                document.querySelector('#listarPets').innerHTML += `<button onclick="excluirAnimal(${item.id_animal})">Exclui</button>`;
                document.querySelector('#listarPets').innerHTML += `<button onclick="editarAnimal(${item.id_animal})">Edita</button>`;
                document.querySelector('#listarPets').innerHTML += `<br><hr>`;
              })

        }
    
      })    
}

function editarAnimal(){
alert("EDITA")

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
  
