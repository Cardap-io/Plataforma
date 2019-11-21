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
      itensCopia.children[0].children.item(0).value = '';
      itensCopia.children[2].children.item(0).value = '';
      itensCopia.children[1].children.item(0).value = '';
      itensCopia.children[3].children.item(0).value = '';
      itensCopia.children[4].children.item(0).setAttribute('onclick',"deletarItens('itens"+count+"')");  
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
$('#modal-default').on('hidden.bs.modal', function(){
  var itensApaga = document.getElementsByName('itensDelete');
  for(i=0;i<itensApaga.length;i++){
    var iten = itensApaga[i];
    if(iten.getAttribute('id') == 'itens' || iten.getAttribute('id')=='itensEditar'){
      iten.setAttribute('style','display:none;');
      iten.children[2].children.item(0).value = '';
      iten.children[1].children.item(0).value = '';
      iten.children[3].children.item(0).value = '';
      iten.children[0].children.item(0).value = '';
    }else{
      iten.remove();
    }
  }

  var elemento = document.getElementsByName('ST_NOME_ITM').length;
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  if(elemento == 1 && itemPaiEscondido){
    document.getElementById('tituloItens').setAttribute('style','display:none');
  }
  });
});

function pegaValor(){
  var itens = document.getElementsByName('ST_NOME_ITM');
  var valores = document.getElementsByName('VL_ITEM_ITM');
  var titulo = document.getElementsByName('ST_TITULO_TIT');
  var descricao = document.getElementsByName('ST_DESCRICAO_ITM');
  var idsItem = document.getElementsByName('ID_ITEM_ITM');
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  var dados = {};
  var vlItem = [];
  var stItem = [];
  var stDescricao = [];
  var idItem = [];

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

  for(i=0;i<idsItem.length;i++){
    var id = idsItem[i];
    idItem.push( id.value);
  }

  vlItem.forEach(function(campo,key){
    if(campo)
      dados[key] = [stItem[key],stDescricao[key],campo,idItem[key]];
  });
  return dados;
  
}

function deletarItens(itens){
  var itemDeletar = document.getElementById(itens);
  if(itens == 'itens' || itens=='itensEditar'){
    itemDeletar.setAttribute('style','display:none;');
    itemDeletar.children[2].children.item(0).value = '';
    itemDeletar.children[1].children.item(0).value = '';
    itemDeletar.children[3].children.item(0).value = '';
    itemDeletar.children[0].children.item(0).value = '';
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
function editarMenu (idTitulo){
  $('#modal-default').modal('show');
  var titulo = document.getElementById('titulo');
  var btnSalvar = document.getElementById('salvar');
  var containerFooter = document.getElementById('footer');
  if(btnSalvar){
    var btnClone =  btnSalvar.cloneNode(true);
    btnClone.setAttribute('id','editar')
    btnSalvar.remove();
    containerFooter.appendChild(btnClone);
  }

  var container = document.getElementById('container');
  var itensKey = document.getElementById('itens');
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  var elemento;
  var count = 0;
  $.ajax({
    type: 'POST',
    url: 'getitensdotitulo',
    dataType: 'JSON',
    data: {
      data: idTitulo
    },
    success: function (data) {
      $.each(data, function(i, resp){
        elemento = document.getElementsByName('ST_NOME_ITM').length;
        if(resp['stTitulo'])  titulo.value = resp['stTitulo'];
        if(resp['nome']){
          if(elemento == 1 && itemPaiEscondido){
            document.getElementById('tituloItens').setAttribute('style','display:show; margin-top: 1%;');
            itensKey.setAttribute('style','display:show;');
            itemPaiEscondido = false;
            itensKey.children[0].children.item(0).value = resp['id'];
            itensKey.children[2].children.item(0).value = resp['descricao'];
            itensKey.children[1].children.item(0).value = resp['nome'];
            itensKey.children[3].children.item(0).value = resp['valor'];
            itensKey.children[4].children.item(0).setAttribute('onclick',"deletarItens('itens')"); 
          }else{
            var itensCopia = itensKey.cloneNode(true);
            itensCopia.setAttribute('id','itensEditar'+count);
            itensCopia.setAttribute('style','margin-top: 1%');
            itensCopia.children[0].children.item(0).value = resp['id'];
            itensCopia.children[2].children.item(0).value = resp['descricao'];
            itensCopia.children[1].children.item(0).value = resp['nome'];
            itensCopia.children[3].children.item(0).value = resp['valor'];
            itensCopia.children[4].children.item(0).setAttribute('onclick',"deletarItens('itensEditar"+count+"')");  
            container.appendChild(itensCopia);
          }
        }
        count += 1;
      });

      document.getElementById("editar").addEventListener("click", function (event) {
        dados =  pegaValor();
        if(dados != false){
          $.ajax({
              type: 'POST',
              url: 'editar',
              dataType: 'JSON',
              data: {
                data: dados,
                titulo: idTitulo
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

    }
});
}
