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
});

function pegaValor(){
  var elemento = document.getElementsByName('item');
  // elemento;
 console.log(elemento)
  for(i=0;i<elemento.length;i++){
     var e = elemento[i];
     console.log(e.value)
    //  if(e.value == '' || e.value == null){
    //     alert("Eu sou um alert!");
    //     e.focus();
    //  }
  }
}

function deletarItens(itens){
  var itemDeletar = document.getElementById(itens);
  if(itens == 'itens'){
    itemDeletar.setAttribute('style','display:none;');
  }else{
    itemDeletar.remove();
  }
  var elemento = document.getElementsByName('item').length;
  var itemPaiEscondido = document.getElementById('itens').attributes.style.value == 'display:show;' ? false : true;
  if(elemento == 1 && itemPaiEscondido){
    document.getElementById('tituloItens').setAttribute('style','display:none');
  }
}


//   $.ajax({
//      url:'myAjax.php',
//      complete: function (response) {
//          $('#output').html(response.responseText);
//      },
//      error: function () {
//          $('#output').html('Bummer: there was an error!');
//      }
//  });
//  return false;

function getOutput() {
  $.ajax({
    // http://localhost/Plataforma/public/fornecedor/FornecedorController.php/cardapio
    url: '/Plataforma/public/fornecedor/FornecedorController.php/cardapio',
    type: 'POST',
    // data: JSON.stringify(requestData),
    data: JSON.stringify(),
    dataType: 'json',
    contentType: 'application/json; charset=utf-8',
    error: function (xhr) {
      alert('Error: ' + xhr.statusText);
      console.log('VAI TOMA NO CU');
    },
    success: function (result) {
      // CheckIfInvoiceFound(result);
      console.log('aii');
    },
    async: true,
    processData: false
  });
}
// // handles the click event for link 1, sends the query
// function getOutput() {
//   getRequest(
//       'FornecedorController.php', // URL for the PHP file
//        drawOutput,  // handle successful request
//        drawError    // handle error
//   );
//   return false;
// }  
// // handles drawing an error message
// function drawError() {
//     // var container = document.getElementById('output');
//     // container.innerHTML = 'Bummer: there was an error!';
//     console.log('deu erro');
// }
// // handles the response, adds the html
// function drawOutput(responseText) {
//     // var container = document.getElementById('output');
//     // container.innerHTML = responseText;
//     console.log(responseText)
// }
// // helper function for cross-browser request object
// function getRequest(url, success, error) {
//     var req = false;
//     try{
//         // most browsers
//         req = new XMLHttpRequest();
//     } catch (e){
//         // IE
//         try{
//             req = new ActiveXObject("Msxml2.XMLHTTP");
//         } catch(e) {
//             // try an older version
//             try{
//                 req = new ActiveXObject("Microsoft.XMLHTTP");
//             } catch(e) {
//                 return false;
//             }
//         }
//     }
//     if (!req) return false;
//     if (typeof success != 'function') success = function () {};
//     if (typeof error!= 'function') error = function () {};
 
//     req.onreadystatechange = function(){
//         if(req.readyState == 4) {
//             return req.status === 200 ? 
//                 success(req.responseText) : error(req.status);
//         }
//     }
//     req.open("GET", url, true);
//     req.send();
//     return req;
// }