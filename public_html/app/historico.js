var dados, id, resposta, id_usuario, ajuda_click, telefone_cliente, comentario, nota, temporizador_1, senha_cliente, Item, id_corrida_avaliar, url_principal;

// Descreva esta função...
function enviar_avaliacao() {
  if (nota == 0) {
    Swal.fire('Selecione uma nota!');
  } else {
    comentario = $("#avaliacao_txt").val();
    ajax_post_async((String(url_principal) + 'insere_avaliacao.php'), {corrida_id:id_corrida_avaliar, telefone:telefone_cliente, senha:senha_cliente, comentario:comentario, nota:nota}, retorno_avaliacao);
    $("#modal_avaliar").modal("hide");
  }
}

// Descreva esta função...
function zerar_estrelas() {
  $("#estrela_1").attr("src", "assets/" + 'estrela_cinza.png');
  $("#estrela_2").attr("src", "assets/" + 'estrela_cinza.png');
  $("#estrela_3").attr("src", "assets/" + 'estrela_cinza.png');
  $("#estrela_4").attr("src", "assets/" + 'estrela_cinza.png');
  $("#estrela_5").attr("src", "assets/" + 'estrela_cinza.png');
}

// Descreva esta função...
function lista_historico(dados) {
  if (dados) {
    dados = JSON.parse(dados);
    for (var Item_index in dados) {
      Item = dados[Item_index];
      document.getElementById('tela_historico').innerHTML += '<div class='+'item_historico'+' id='+Item['id']+' onclick="avaliar('+Item['id']+')" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);">'+(['<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">'+'Corrida ID: #'+' </span>','<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">'+Item['id']+' </span>','<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">'+'<br> Status:'+' </span>',Item['status'] == 'Cancelada' ? '<span style="font-size:16px; color:#ff0000; font-weight:bold; font-style:normal;">'+Item['status']+' </span>' : '<span style="font-size:16px; color:#009900; font-weight:bold; font-style:normal;">'+Item['status']+' </span>','<br>','<span style="font-size:18px; color:#ff0000; font-weight:bold; font-style:normal;">'+(['<a onclick="openAjudal(',Item['id'],')" >'].join(''))+' </span>','<span style="font-size:18px; color:#ff0000; font-weight:bold; font-style:normal;">'+'🆘 AJUDA  </a>'+' </span>','<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">'+'<br> 📍 Origem: <br>'+' </span>','<span style="font-size:15px; color:#333333; font-weight:normal; font-style:normal;">'+Item['endereco_ini_txt']+' </span>','<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">'+'<br> 📌 Destino: <br>'+' </span>','<span style="font-size:15px; color:#333333; font-weight:normal; font-style:normal;">'+Item['endereco_fim_txt']+' </span>','<span style="font-size:17px; color:#333333; font-weight:bold; font-style:normal;">'+'<br><br>💲 Total: R$'+' </span>','<span style="font-size:17px; color:#333333; font-weight:bold; font-style:normal;">'+Item['taxa']+' </span>','<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">'+'<br>💰 Forma de pagamento: '+' </span>','<span style="font-size:15px; color:#333333; font-weight:normal; font-style:normal;">'+Item['f_pagamento']+' </span>','<br>','<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">'+'<br>🚗 Motorista: '+' </span>','<span style="font-size:16px; color:#333333; font-weight:normal; font-style:normal;">'+Item['motorista']+' </span>',Item['avaliacao'] == 0 ? '<span style="font-size:16px; color:#000099; font-weight:normal; font-style:italic;">'+' <br> ⭐ Avaliar Motorista⭐'+' </span>' : ['<span style="font-size:16px; color:#000000; font-weight:normal; font-style:italic;">'+' <br> Você avaliou com '+' </span>',Item['avaliacao'],'⭐'].join(''),'<br>','<br> 📅 ','<span style="font-size:14px; color:#666666; font-weight:bold; font-style:normal;">'+Item['date']+' </span>'].join(''))+'</div>';
    }
    $("."+'item_historico').css("padding-left", 10+"px");
    $("."+'item_historico').css("padding-right", 10+"px");
    $("."+'item_historico').css("padding-top", 10+"px");
    $("."+'item_historico').css("padding-bottom", 10+"px");
    $("."+'item_historico').css("margin-left", 5+"px");
    $("."+'item_historico').css("margin-right", 5+"px");
    $("."+'item_historico').css("margin-top", 0+"px");
    $("."+'item_historico').css("margin-bottom", 15+"px");
    $(".item_historico").css("border-radius", "15px");
  } else {
    document.getElementById('tela_historico').innerHTML += '<div class='+'item_historico'+' id='+'1'+' onclick="ok('+0+')" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);">'+'<span style="font-size:16px; color:#333333; font-weight:normal; font-style:normal;">'+'Nenhuma corrida realizada ainda'+' </span>'+'</div>';
    $("."+'item_historico').css("padding-left", 10+"px");
    $("."+'item_historico').css("padding-right", 10+"px");
    $("."+'item_historico').css("padding-top", 10+"px");
    $("."+'item_historico').css("padding-bottom", 10+"px");
    $("."+'item_historico').css("margin-left", 5+"px");
    $("."+'item_historico').css("margin-right", 5+"px");
    $("."+'item_historico').css("margin-top", 0+"px");
    $("."+'item_historico').css("margin-bottom", 15+"px");
    $(".item_historico").css("border-radius", "15px");
  }
}

// Descreva esta função...
function avaliar(id) {
  if (!ajuda_click) {
    $("#modal_avaliar").modal("show");
    id_corrida_avaliar = id;
  }
}

// Descreva esta função...
function retorno_avaliacao(resposta) {
  if (resposta) {
    Swal.fire(JSON.parse(resposta)['mensagem']);
  }
  temporizador_1 = setInterval(function(){
    clearInterval(temporizador_1);
    window.location.href = "historico.php";}, 1000);
}

// Descreva esta função...
function openAjudal(id) {
  ajuda_click = true;
  document.getElementById("loading").style.display = "block";
  $("#modal_avaliar").modal("hide");
  window.location.href = "ajuda_corrida.php?id="+id+"";
}

// Descreva esta função...
function ok() {
  window.location.href = "home.php";}


//feito com bootblocks.com.br
   function makeLoading(){
  let loading = '<div id="loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0); z-index: 9999;"><img id="loading-image" src="assets/loading.gif" alt="Carregando..." style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>'
  document.body.innerHTML += loading;
  }
   makeLoading();

//feito com bootblocks.com.br
  $("body").css("width", "100%");
  $("html").css("width", "100%");
  document.getElementById('cabecalho_msg').style.position = "fixed";
  document.getElementById('cabecalho_msg').style.top = "0px";
  document.getElementById('cabecalho_msg').style.left = "0";
  document.getElementById('cabecalho_msg').style.right = "0";
  document.getElementById('cabecalho_msg').style.zIndex = "20";
  $("#"+'cabecalho_msg').css("padding-left", 10+ "px");
  $("#"+'cabecalho_msg').css("padding-right", 0+ "px");
  $("#"+'cabecalho_msg').css("padding-top", 10+ "px");
  $("#"+'cabecalho_msg').css("padding-bottom", 0+ "px");
  $("#cabecalho_msg").css("display", "flex");
  $("#cabecalho_msg").css("justify-content", "center");
  $("#tela_icon_cabecalho").css("background-color", "#000000FF");
  $("#cabecalho_msg").css("background-color", "#000000FF");
  $("#txt_cabecalho").css("background-color", "#000000FF");

//feito com bootblocks.com.br
  id_usuario = localStorage.getItem('cliente_id') || '';
  telefone_cliente = localStorage.getItem('telefone_cliente') || '';
  senha_cliente = localStorage.getItem('senha_cliente') || '';
  url_principal = localStorage.getItem('url_principal') || '';
  ajax_post_async((String(url_principal) + 'get_historico.php'), {telefone:telefone_cliente, senha:senha_cliente}, lista_historico);

$(document).on("click", "#estrela_4", function(){
  zerar_estrelas();
  nota = 4;
  $("#estrela_1").attr("src", "assets/" + 'estrela.png');
  $("#estrela_2").attr("src", "assets/" + 'estrela.png');
  $("#estrela_3").attr("src", "assets/" + 'estrela.png');
  $("#estrela_4").attr("src", "assets/" + 'estrela.png');
});

$(document).on("click", "#estrela_2", function(){
  zerar_estrelas();
  nota = 2;
  $("#estrela_1").attr("src", "assets/" + 'estrela.png');
  $("#estrela_2").attr("src", "assets/" + 'estrela.png');
});

$(document).on("click", "#estrela_5", function(){
  zerar_estrelas();
  nota = 5;
  $("#estrela_1").attr("src", "assets/" + 'estrela.png');
  $("#estrela_2").attr("src", "assets/" + 'estrela.png');
  $("#estrela_3").attr("src", "assets/" + 'estrela.png');
  $("#estrela_4").attr("src", "assets/" + 'estrela.png');
  $("#estrela_5").attr("src", "assets/" + 'estrela.png');
});

//feito com bootblocks.com.br
  ajuda_click = false;

$(document).on("click", "#estrela_1", function(){
  zerar_estrelas();
  nota = 1;
  $("#estrela_1").attr("src", "assets/" + 'estrela.png');
});

$(document).on("click", "#estrela_3", function(){
  zerar_estrelas();
  nota = 3;
  $("#estrela_1").attr("src", "assets/" + 'estrela.png');
  $("#estrela_2").attr("src", "assets/" + 'estrela.png');
  $("#estrela_3").attr("src", "assets/" + 'estrela.png');
});

$(document).on("click", "#icone_voltar", function(){
  window.location.href = "home.php";});
function ajax_post(url, dados){
                let retorno;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: dados,
                    async: false,
                    success: function(data){
                        retorno = data;
                    },
                    error: function(data){
                        retorno = data;
                    }
                });
                return retorno;
            }function ajax_post_async(url, dados, funcao_chamar){
                $.ajax({
                    url: url,
                    type: "POST",
                    data: dados,
                    async: true,
                    success: function(data){
                        funcao_chamar(data);
                    },
                    error: function(data){
                        funcao_chamar(data);
                    }
                });
            }
            
        $(document).ready(function(){
            $("#loading-page-bb").css("opacity", "1");
        });