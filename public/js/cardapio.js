window.addEventListener("load", function () {
  var count = 0;
  document.getElementById("adicionarItens").addEventListener("click", function (event) {
    var container = document.getElementById('container');
    var itensKey = document.getElementById('itens');
    var itensCopia = itensKey.cloneNode(true);
    var elemento = document.getElementsByName('ST_NOME_ITM').length;
    var itensAparecendo = itensKey.attributes.style.value == 'display:show;' ? false : true;
    if(elemento == 1 && itensAparecendo){
      document.getElementById('tituloItens').setAttribute('style','display:show; margin-top: 1%;');
      itensKey.setAttribute('style','display:show;');
    }else{
      itensCopia.setAttribute('id','itens'+count);
      itensCopia.setAttribute('style','margin-top: 1%');
      itensCopia.children[1].children.item(0).value = '';
      itensCopia.children[0].children.item(0).value = '';
      itensCopia.children[2].children.item(0).value = '';
      itensCopia.children[3].children.item(0).setAttribute('onclick',"deletarItens('itens"+count+"')");  
      container.appendChild(itensCopia);
    }
    count += 1;
  });

  document.getElementById("salvar").addEventListener("click", function (event) {

    dados = pegaValor();
    if(dados != false){
      $.ajax({
          type: 'POST',
          url: 'adicionar',
          dataType: 'JSON',
          data: {
            data: dados
          },
          success: function (data) {
            $.each(data, function(i, resp){
              if(i == 'erro')
                alert(resp);
              else{
                alert(resp);
                window.location.reload();
              }
           })
          }
      });
    }
  });
});

function pegaValor(){
  var itens = document.getElementsByName('ST_NOME_ITM');
  var valores = document.getElementsByName('VL_ITEM_ITM');
  var titulo = document.getElementsByName('ST_TITULO_TIT');
  var descricao = document.getElementsByName('ST_DESCRICAO_ITM');
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  var dados = {};
  var vlItem = [];
  var stItem = [];
  var stDescricao = [];

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

  for(i=0;i<descricao.length;i++){
    var desc = descricao[i];
    if((desc.value == '' || desc.value == null) && itemPaiEscondido == false){
      alert("Preencha todos os campos!");
      desc.focus();
      return false;
    }else{
      stDescricao.push( desc.value);
    } 
  }

  for(i=0;i<valores.length;i++){
    var valor = valores[i];
    if((valor.value == '' || valor.value == null) && itemPaiEscondido == false){
      alert("Preencha todos os campos!");
      valor.focus();
      return false;
    }
    else if(!parseFloat(valor.value) && itemPaiEscondido == false){
      alert("Digite apenas números!");
      valor.focus();
      return false;
    }else if (parseFloat(valor.value) < 0){
      alert("Digite apenas valores positivos!");
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
    dados['ST_TITULO_TIT'] = titulo[0].value;
  }

  vlItem.forEach(function(campo,key){
    if(campo)
      dados[key] = [stItem[key],stDescricao[key],campo];
  });
  return dados;
  
}

function deletarItens(itens){
  var itemDeletar = document.getElementById(itens);
  if(itens == 'itens'){
    itemDeletar.setAttribute('style','display:none;');
    itemDeletar.children[1].children.item(0).value = '';
    itemDeletar.children[0].children.item(0).value = '';
    itemDeletar.children[2].children.item(0).value = '';
  }else{
    itemDeletar.remove();
  }
  var elemento = document.getElementsByName('ST_NOME_ITM').length;
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  if(elemento == 1 && itemPaiEscondido){
    document.getElementById('tituloItens').setAttribute('style','display:none');
  }
}

function deletarMenu(idTitulo){
  if(confirm("Deseja excluir esse menu?")){
    $.ajax({
      type: 'POST',
      url: 'deletarmenu',
      dataType: 'JSON',
      data: {
        data: idTitulo
    },
      success: function (data) {
        alert('Deletado com sucesso!');
        window.location.reload();
      }
    });
  }
}
