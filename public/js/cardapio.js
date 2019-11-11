window.addEventListener("load", function () {
  var count = 0;
  document.getElementById("adicionarItens").addEventListener("click", function (event) {
    var container = document.getElementById('container');
    var itensKey = document.getElementById('itens');
    var itensCopia = itensKey.cloneNode(true);
    var elemento = document.getElementsByName('item').length;
    var itensAparecendo = itensKey.attributes.style.value == 'display:show;' ? false : true;
    if(elemento == 1 && itensAparecendo){
      document.getElementById('tituloItens').setAttribute('style','display:show; margin-top: 1%;');
      itensKey.setAttribute('style','display:show;');
    }else{
      itensCopia.setAttribute('id','itens'+count);
      itensCopia.setAttribute('style','margin-top: 1%');
      itensCopia.children[1].children.item(0).value = '';
      itensCopia.children[0].children.item(0).value = '';
      itensCopia.children[2].children.item(0).setAttribute('onclick',"deletarItens('itens"+count+"')");  
      container.appendChild(itensCopia);
    }
    count += 1;
  });

  document.getElementById("salvar").addEventListener("click", function (event) {
    dados = pegaValor();
    if(dados != false){
      $.ajax({
          type: 'POST',
          url: 'teste',
          dataType: 'JSON',
          data: {
            data: dados
          },
          success: function (data) {
            console.log('sucesso');
          }
      });
    }
  });
});

function pegaValor(){
  var itens = document.getElementsByName('item');
  var valores = document.getElementsByName('valor');
  var titulo = document.getElementsByName('titulo');
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  var dados = {};
  var vlItem = [];
  var stItem = [];

  for(i=0;i<itens.length;i++){
    var iten = itens[i];
    if((iten.value == '' || iten.value == null) && itemPaiEscondido == false){
      alert("Preencha todos os campos!");
      iten.focus();
      return false;
    }else{
      stItem.push( iten.value);
    } 
  }

  for(i=0;i<valores.length;i++){
    var valor = valores[i];
    if((valor.value == '' || valor.value == null) && itemPaiEscondido == false){
      alert("Preencha todos os campos!");
      console.log('aqui?2');
      valor.focus();
      return false;
    }
    else if(!parseFloat(valor.value) && itemPaiEscondido == false){
      alert("Digite apenas números!");
      valor.focus();
      return false;
    }else{
      vlItem.push(valor.value.replace(',', '.'));
    }
 }
  if(titulo[0].value == '' || titulo[0].value == null){
    alert("Digite o título!");
    titulo[0].focus();
    return false;
  }else{
    dados['TITULO'] = titulo[0].value;
  }

  vlItem.forEach(function(campo,key){
    if(campo)
      dados[key] = [stItem[key],campo];
  });

  return dados;
  
}

function deletarItens(itens){
  var itemDeletar = document.getElementById(itens);
  if(itens == 'itens'){
    itemDeletar.setAttribute('style','display:none;');
    itemDeletar.children[1].children.item(0).value = '';
    itemDeletar.children[0].children.item(0).value = '';
  }else{
    itemDeletar.remove();
  }
  var elemento = document.getElementsByName('item').length;
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  if(elemento == 1 && itemPaiEscondido){
    document.getElementById('tituloItens').setAttribute('style','display:none');
  }
}