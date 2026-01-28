var resposta, dados, latitude, longitude, velocidade, altitude, motoristas, retorno_avaliacao, dados_inicio, resposta_dados_cliente, retorno_categorias, index, retorno_cupon, status_inserir, resultado_retorno, resposta_saldo, dados_status_pix, dados_status, dados_retorno_pix, menu_aberto, dados_cidade, latitude_usuario, endereco_inicial, endereco_texto, iniciar_listagem, id_categori_escolhida, forma_pagamento, TextoRespostaAss, ErroRespostaAss, tamanho_msg, largura_menu, comentario, temp_verifica_pix, nota, longitude_usuario, endereco_final, endereco, motorista_id, qnt_passageiros, contador, valor_corrida, cliente_id, id_corrida, tempo_timer, categorias_minimizado, altura_tela_categorias, status_minimizado, largura_da_tela, latitude_inicial, lat_motorista, id_corrida_avaliar, latitude_final, url_principal, nome_categoria, forma_de_pagamento, busca_login, minutos, temporizador_busca_motoristas, status_anterior, altura_tela_status, nome_cliente, lonngitude_inicial, senha, lng_motorista, longitude_final, telefone, transacao_id, lista_de_categorias, km, temporizador_relogio, status_texto, ref_user, lat_resposta_1, long_resposta_2, dados_viagem, cidade_id, msg, url_imagem_pix, nota_cliente, Item, polilinha, em_pergunta, lat_motorista_selecionado, pix_copia_cola, token, temporizador_busca_status, lng_motorista_selecionado, url_imagem;

// Descreva esta função...
function problema_viagem() {
  window.location.href = "historico.php";
}

// Descreva esta função...
function problema_aplicativo() {
  window.location.href = "ajuda_app.php";
}

// Descreva esta função...
function fechar_menu() {
  menu_aberto = false;
  largura_menu = largura_da_tela - largura_da_tela * 2;
  $("#tela_menu").css("left", largura_menu + "px");
  $("#tela_menu").css("top", "0px");
  $("#tela_menu").css("z-index", "25");
  $("#tela_menu").css("position", "fixed");
  $("#tela_menu").css("display", "block");
}

// Descreva esta função...
function abrir_menu() {
  menu_aberto = true;
  $("#" + 'tela_menu').show();
  $("#" + 'tela_menu').css("position", "relative");
  $("#" + 'tela_menu').animate({ left: 0 + "px" }, 300);
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
function enviar_avaliacao() {
  if (nota == 0) {
    Swal.fire('Selecione uma nota!');
  } else {
    comentario = document.getElementById('avaliacao_txt').value;
    ajax_post_async((String(url_principal) + 'insere_avaliacao.php'), { corrida_id: id_corrida_avaliar, telefone: telefone, senha: senha, comentario: comentario, nota: nota }, retorno_avaliacao_fechar);
    $("#modal_avaliar").modal("hide");
  }
}

// Descreva esta função...
function alterar_senha() {
  if (!document.getElementById('dados_senha_1').value.length || !document.getElementById('dados_senha_2').value.length) {
    Swal.fire({
      icon: 'error',
      title: 'Campo vazio',
      text: 'Preencha os campos de senha'
    });
  } else {
    if (document.getElementById('dados_senha_1').value == document.getElementById('dados_senha_2').value) {
      if (!localStorage.getItem('senha_cliente') || ''.length) {
        Swal.fire({
          icon: 'error',
          title: 'Não Logado',
          text: 'Faça login novamente'
        });
      } else {
        ajax_post_async((String(url_principal) + 'redefinir_senha_logado.php'), { cliente_id: cliente_id, nova_senha: document.getElementById('dados_senha_1').value, senha_atual: senha, token: token }, finaliza_redefinir_senha);
      }
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Senha inválida',
        text: 'Senhas não conferem'
      });
    }
  }
}

// Descreva esta função...
function retorno_avaliacao_fechar(resposta) {
  if (resposta) {
    Swal.fire(JSON.parse(resposta)['mensagem']);
  }
  temp_verifica_pix = setInterval(function () {
    clearInterval(temp_verifica_pix);
    window.location.href = "home.php";
  }, 1000);
}

//quando clicar no botão tela_locacao_veiculos redireciona para https://wustoki.top/_/locacao/veiculos.php
document.getElementById('tela_locacao_veiculos').addEventListener('click', function () {
  window.location.href = "https://movfacil.com.br/_/locacao/veiculos.php";
});



// Descreva esta função...
function gerar_dados_cidade(dados) {
  dados_cidade = JSON.parse(dados);
  if (localStorage.getItem('latitude') || '') {
    latitude_usuario = localStorage.getItem('latitude') || '';
  } else {
    latitude_usuario = dados_cidade['latitude'];
  }
  if (localStorage.getItem('longitude') || '') {
    longitude_usuario = localStorage.getItem('longitude') || '';
  } else {
    longitude_usuario = dados_cidade['longitude'];
  }
  localStorage.setItem('token_mp', dados_cidade['token']);
  $("#txt_contato").html((['Telefone: ', dados_cidade['telefone'], '<br> Email: ', dados_cidade['email']].join('')));
  $("#txt_nome_telefone_dados").html((['Nome: ', localStorage.getItem('nome_cliente') || '', '<br> Telefone: ', localStorage.getItem('telefone_cliente') || ''].join('')));
  map.panTo(new google.maps.LatLng((txt_to_number(latitude_usuario)), (txt_to_number(longitude_usuario))));
}

// Descreva esta função...
function verificar_saudacao() {
  if ((new Date().getHours()) >= 0) {
    $("#lbl_boas_vindas").html(('Bom dia, ' + String(nome_cliente)));
  }
  if ((new Date().getHours()) >= 12) {
    $("#lbl_boas_vindas").html(('Boa Tarde, ' + String(nome_cliente)));
  }
  if ((new Date().getHours()) >= 18) {
    $("#lbl_boas_vindas").html(('Boa Noite, ' + String(nome_cliente)));
  }
}

// Descreva esta função...
function fechar_modal() {
  $("#modal_contato").modal("hide");
}

// Descreva esta função...
function enviar_whats_contato() {
  let msg_uri_encoded = window.encodeURIComponent('Preciso de suporte');
  window.open("https://api.whatsapp.com/send?phone=" + ('+55' + String(dados_cidade['telefone'])) + "&text=" + msg_uri_encoded, "_blank");
}

// Descreva esta função...
function fechar_modal_dados() {
  $("#modal_dados").modal("hide");
}

// Descreva esta função...
function finaliza_redefinir_senha(resposta) {
  Swal.fire(JSON.parse(resposta)['mensagem']);
  $("#modal_dados").modal("hide");
  if (JSON.parse(resposta)['status'] == 'sucesso') {
    senha = document.getElementById('dados_senha_1').value;
    localStorage.setItem('senha_cliente', senha);
  }
  $("#dados_senha_1").val('');
  $("#dados_senha_2").val('');
}

// Descreva esta função...
function obter_endereco_usuario() {
  if (latitude_usuario && longitude_usuario) {
    function geocodeLatLng() {
      var geocoder = new google.maps.Geocoder();
      var latlng = { lat: (txt_to_number(latitude_usuario)), lng: (txt_to_number(longitude_usuario)) };
      geocoder.geocode({ 'location': latlng }, function (results, status) {
        if (status === 'OK') {
          if (results[0]) {
            endereco = results[0].formatted_address;
            latitude_inicial = latitude_usuario;
            lonngitude_inicial = longitude_usuario;
            $("#box_origem").val(endereco);
          } else {
            window.alert('Nenhum Resultado Encontrado');
          }
        } else {
          window.alert('Geocoder falhou: ' + status);
        }
      });
    }
    geocodeLatLng();
  }
}

function mathRandomInt(a, b) {
  if (a > b) {
    // Swap a and b to ensure a is smaller.
    var c = a;
    a = b;
    b = c;
  }
  return Math.floor(Math.random() * (b - a + 1) + a);
}

// Descreva esta função...
function mostrar_motoristas(motoristas) {
  if (motoristas) {
    motorista_id = 0;
    lat_motorista = 0;
    lng_motorista = 0;
    motoristas = JSON.parse(motoristas);
    for (var Item_index in motoristas) {
      Item = motoristas[Item_index];
      motorista_id = Item['id'];
      for (var i = 0; i < Makers.length; i++) {
        if (Makers[i].marker_id === motorista_id) {
          Makers[i].setMap(null);
          Makers.splice(i, 1);
        }
      }
      lng_motorista = Item['longitude'];
      lat_motorista = Item['latitude'];
      lng_motorista = (txt_to_number(lng_motorista));
      lat_motorista = (txt_to_number(lat_motorista));
      if (Item['online'] == 1) {
        if (mathRandomInt(1, 2) % 2 === 0) {
          var marker = new google.maps.Marker({
            position: { lat: lat_motorista, lng: lng_motorista },
            map: map,
            icon: "assets/car_green_a.png",
            title: "Motorista Disponível",
            marker_id: motorista_id
          });
          marker.addListener("click", function () {
            let id = this.marker_id;
          });
          Makers.push(marker);
        } else {
          var marker = new google.maps.Marker({
            position: { lat: lat_motorista, lng: lng_motorista },
            map: map,
            icon: "assets/car_green_b.png",
            title: "Motorista Disponível",
            marker_id: motorista_id
          });
          marker.addListener("click", function () {
            let id = this.marker_id;
          });
          Makers.push(marker);
        }
      } else {
        if (mathRandomInt(1, 2) % 2 === 0) {
          var marker = new google.maps.Marker({
            position: { lat: lat_motorista, lng: lng_motorista },
            map: map,
            icon: "assets/car_red_a.png",
            title: "Motorista Ocupado",
            marker_id: motorista_id
          });
          marker.addListener("click", function () {
            let id = this.marker_id;
          });
          Makers.push(marker);
        } else {
          var marker = new google.maps.Marker({
            position: { lat: lat_motorista, lng: lng_motorista },
            map: map,
            icon: "assets/car_red_b.png",
            title: "Motorista Ocupado",
            marker_id: motorista_id
          });
          marker.addListener("click", function () {
            let id = this.marker_id;
          });
          Makers.push(marker);
        }
      }
    }
  }
}

// Descreva esta função...
function exibe_avaliacao(retorno_avaliacao) {
  retorno_avaliacao = JSON.parse(retorno_avaliacao);
  if (retorno_avaliacao['status'] == 'ok') {
    id_corrida_avaliar = retorno_avaliacao['corrida_id'];
    $("#modal_avaliar").modal("show");
    // Seleciona o botão de fechar do modal
    var closeButton = document.querySelector('.close');

    // Verifica se o botão de fechar foi encontrado
    if (closeButton) {
      // Esconde o botão de fechar definindo sua propriedade display como "none"
      closeButton.style.display = "none";
    }
  }
}

// Descreva esta função...
function proximo_input() {
  function addAutocomplete() {
    var input = document.getElementById('box_destino');
    let radius = 50000;
    let center = new google.maps.LatLng(latitude_usuario, longitude_usuario);
    let circle = new google.maps.Circle({
      center: center,
      radius: radius
    });
    let options = {
      bounds: circle.getBounds()
    };
    autocomplete_box_destino = new google.maps.places.Autocomplete(input, options);
    autocomplete_box_destino.addListener("place_changed", () => {
      console.log("chamou");
      let place = autocomplete_box_destino.getPlace();

      if (place && place.geometry && place.geometry.location) {
        endereco_texto = place.formatted_address || '';
        latitude = place.geometry.location.lat();
        longitude = place.geometry.location.lng();
        endereco_final = endereco_texto;
        latitude_final = latitude;
        longitude_final = longitude;
        var marker = new google.maps.Marker({
          position: { lat: latitude, lng: longitude },
          map: map,
          icon: "assets/destino.png",
          title: "Destino",
          marker_id: 2
        });
      } else {
        console.error("Place details are not available.");
      }
      marker.addListener("click", function () {
        let id = this.marker_id;
      });
      Makers.push(marker);
      function getPolyline() {
        directionsService = new google.maps.DirectionsService();
        let request = {
          origin: new google.maps.LatLng(latitude_inicial, lonngitude_inicial),
          destination: new google.maps.LatLng(latitude, longitude),
          travelMode: google.maps.TravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.METRIC,
          durationInTraffic: true,
        };
        directionsService.route(request, function (response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            polilinha = response.routes[0].overview_polyline;
            var polyline = new google.maps.Polyline({
              strokeColor: "#545454",
              strokeOpacity: 1,
              strokeWeight: 4,
              map: map
            });
            polyline.polyline_id = 9;
            polyline.setPath(google.maps.geometry.encoding.decodePath(polilinha));
            Polylines.push(polyline);
          } else {
            alert("Erro: " + status);
          }
        });
      }
      getPolyline();
    });
  }
  addAutocomplete();
}

// Descreva esta função...
function busca_inicio(dados_inicio) {
  if (dados_inicio) {
    ajax_post_async((String(url_principal) + 'get_status_chamado.php'), { telefone: telefone, senha: senha }, verifica_status);
    $("#" + 'tela_status').show();
    $("#" + 'tela_barra_inicio').hide();
    resultado_chamado([]);
  }
}

// Descreva esta função...
function n_cancelar() {
}

// Descreva esta função...
function cancelar() {
  ajax_post_async((String(url_principal) + 'cancelar.php'), { telefone: telefone, senha: senha, transacao_id: transacao_id }, fim_cancelar);
}

// Descreva esta função...
function dados_cliente(resposta_dados_cliente) {
  resposta_dados_cliente = JSON.parse(resposta_dados_cliente);
  $("#lbl_performance").html((['<br>Performance: ', resposta_dados_cliente['performance'], '%'].join('')));
  $("#lbl_total_corridas").html(('Corridas: ' + String(resposta_dados_cliente['n_corridas'])));
  if (ref_user != resposta_dados_cliente['ref_cliente']) {
    if (!em_pergunta) {
      Swal.fire({
        title: 'Você fez login em outro dispositivo.',
        showCancelButton: false,
        confirmButtonText: 'OK',
        cancelButtonText: '',
      }).then((result) => {
        if (result.value) {
          login_novamente()
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          login_novamente()
        }
      });
    }
    em_pergunta = true;
  }
}

// Descreva esta função...
function fim_cancelar() {
  window.location.href = "home.php";
}

// Descreva esta função...
function login_novamente() {
  window.location.href = "login.php";
}

// Descreva esta função...
function exibir_categorias(retorno_categorias) {
  iniciar_listagem = true;
  contador = 0;
  id_categori_escolhida = 0;
  lista_de_categorias = JSON.parse(retorno_categorias)['categorias'];
  dados_viagem = JSON.parse(retorno_categorias)['dados'];
  km = dados_viagem['km'];
  minutos = dados_viagem['minutos'];
  for (var Item_index2 in lista_de_categorias) {
    Item = lista_de_categorias[Item_index2];
    contador = contador + 1;
    var card = '<div onclick="mudar_categoria(' + contador + ')" class="meus_cards" id="' + contador + '" style="width:98%; margin:2px; padding: 5px; border-radius: 5px; box-shadow: 7px 7px 13px 0px rgba(50, 50, 50, 0.22);">'
    card += '<div class="row">'
    card += '<div class="col-4">'
    card += '<img class="imagem_meus_cards" id="imagem_meus_cards" style="width:50px; height:50px;" src="' + (String(url_imagem) + String(Item['img'])) + '" alt="imagem">'
    card += '</div>'
    card += '<div class="col-8">'
    card += '<span class="titulo_meus_cards" id="titulo_meus_cards" style="font-weight: bold; font-size: 16px">' + (['<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + Item['nome'] + ' </span>', '&nbsp', String('<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + 'R$ ' + ' </span>') + String('<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + Item['taxa'] + ' </span>')].join('')) + '</span><br>'
    card += '<span class="subtitulo_meus_cards" id="subtitulo_meus_cards" style="font-size: 13px">' + '<span style="font-size:14px; color:#000000; font-weight:normal; font-style:normal;">' + Item['descricao'] + ' </span>' + '</span><br>'
    card += '<span class="texto_adicional_meus_cards" id="texto_adicional_meus_cards" style="font-size: 13px">' + '<span style="font-size:12px; color:#666666; font-weight:normal; font-style:normal;">' + 'Clique para selecionar' + ' </span>' + '</span>'
    card += '</div>'
    card += '</div>'
    card += ' </div>'
    document.getElementById("tela_lista_categorias").innerHTML += card;
    if (iniciar_listagem) {
      iniciar_listagem = false;
      id_categori_escolhida = Item['id'];
      valor_corrida = Item['taxa'];
      $("#txt_card_chamado").html((['Confirmar ', Item['nome'], ' R$ ', Item['taxa']].join('')));
      document.getElementById(contador).style.border = 1 + "px solid " + "#009900";
    } else {
      document.getElementById(contador).style.border = 1 + "px solid " + "#c0c0c0";
    }
  }
  $("." + 'meus_cards').css("margin-left", 2 + "px");
  $("." + 'meus_cards').css("margin-right", 2 + "px");
  $("." + 'meus_cards').css("margin-top", 8 + "px");
  $("." + 'meus_cards').css("margin-bottom", 8 + "px");
  $("." + 'imagem_meus_cards').css("padding-left", 20 + "px");
  $("." + 'imagem_meus_cards').css("padding-right", 0 + "px");
  $("." + 'imagem_meus_cards').css("padding-top", 5 + "px");
  $("." + 'imagem_meus_cards').css("padding-bottom", 0 + "px");
  $(".imagem_meus_cards").css("height", '80' + "px");
  $(".imagem_meus_cards").css("width", '80' + "px");
  $("#" + 'tela_destinos').hide();
  $("#" + 'tela_barra_inicio').hide();
  $("#" + 'tela_btn_avancar').hide();
  document.getElementById('tela_categorias').style.position = "fixed";
  document.getElementById('tela_categorias').style.bottom = "0px";
  document.getElementById('tela_categorias').style.left = "0";
  document.getElementById('tela_categorias').style.right = "0";
  document.getElementById('tela_categorias').style.zIndex = "20";
  $("#" + 'tela_categorias').show();
}

// Descreva esta função...
function mudar_categoria(index) {
  id_categori_escolhida = (lista_de_categorias[(index - 1)])['id'];
  valor_corrida = (lista_de_categorias[(index - 1)])['taxa'];
  nome_categoria = (lista_de_categorias[(index - 1)])['nome'];
  $("#txt_card_chamado").html((['Confirmar ', (lista_de_categorias[(index - 1)])['nome'], ' R$ ', (lista_de_categorias[(index - 1)])['taxa']].join('')));
  $(".meus_cards").css("border", 1 + "px solid #cccccc");
  document.getElementById(index).style.border = 1 + "px solid " + "#009900";
}

// Descreva esta função...
function verifica_cupon(retorno_cupon) {
  retorno_cupon = JSON.parse(retorno_cupon);
  if (retorno_cupon['status'] == 'Cupom aplicado!') {
    $("#box_cupon").prop("disabled", true);
    $("#" + 'valida_cupon').hide();
    $("#" + 'v_l').show();
    valor_corrida = retorno_cupon['desconto'];
    $("#txt_card_chamado").html((['Confirmar ', nome_categoria, ' R$ ', retorno_cupon['desconto']].join('')));
  }
  Swal.fire(retorno_cupon['status']);
}

// Descreva esta função...
function validar_cupon() {
  ajax_post_async((String(url_principal) + 'valida_cupon.php'), { cupom: document.getElementById('box_cupon').value, cidade_id: cidade_id, valor: valor_corrida, user_id: cliente_id }, verifica_cupon);
}

// Descreva esta função...
function v_l() {
  Swal.fire('Cupon ja foi aplicado!');
}

// Descreva esta função...
function enviar_solicitacao_chamado() {
  document.getElementById("loading").style.display = "block";
  if (!endereco_inicial) {
    endereco_inicial = document.getElementById('box_origem').value;
  }
  $("#" + 'tela_categorias').hide();
  forma_de_pagamento = document.getElementById('forma_pagamento').value;
  if (forma_de_pagamento == 'Pix') {
    insere_chamado(6);
  } else {
    insere_chamado(0);
  }
}

// Descreva esta função...
function insere_chamado(status_inserir) {
  salvar_historico();
  ajax_post_async((String(url_principal) + 'insere_chamado.php'), {
    senha: senha,
    telefone: telefone,
    valor: valor_corrida,
    forma_pagamento: forma_pagamento,
    endereco_ini: endereco_inicial,
    endereco_fim: endereco_final,
    categoria_id: id_categori_escolhida,
    lat_ini: latitude_inicial,
    lng_ini: longitude_final,
    lat_fim: latitude_final,
    lng_fim: longitude_final,
    km: km,
    tempo: minutos,
    taxa: valor_corrida,
    cupon: document.getElementById('box_cupon').value,
    qnt_usuarios: qnt_passageiros,
    status: status_inserir
  },
    resultado_chamado);
}

function salvar_historico() {
  let historico = JSON.parse(localStorage.getItem('historico')) || [];
  
  // Verifica se o endereço já existe no histórico
  const enderecoExiste = historico.some(item => 
    item.endereco_final === endereco_final && 
    item.latitude_final === latitude_final && 
    item.longitude_final === longitude_final
  );

  // Se não existir, adiciona ao histórico
  if (!enderecoExiste) {
    // Remove o item mais antigo se já tiver 5 items
    if (historico.length >= 5) {
      historico.shift(); // Remove o primeiro item (mais antigo)
    }

    // Adiciona o novo endereço
    historico.push({
      endereco_inicial: endereco_inicial,
      endereco_final: endereco_final, 
      latitude_final: latitude_final,
      longitude_final: longitude_final,
      categoria: nome_categoria,
      valor: valor_corrida,
      data: new Date().toLocaleString()
    });

    localStorage.setItem('historico', JSON.stringify(historico));
  }
}
//28
//quando ícone icone_favorito_origem for clicado abre o modal de favoritos
document.getElementById('icone_favorito_origem').addEventListener('click', function () {
  let favorito = JSON.parse(localStorage.getItem('favorito')) || [];
  //se não tem um endereco favorito salvo, verifica se tem latitude e longitude inicial se não não é possivel salvar um favorito
  if (favorito.length === 0 && !latitude_inicial && !lonngitude_inicial) {
    Swal.fire('Selecione um endereço de origem para salvar como favorito');
    return;
  }
  $("#modal_favorito").modal("show");
  preencher_favorito();
});
//sera apenas um favorito!
var favorito = [];
function preencher_favorito() {
  favorito = JSON.parse(localStorage.getItem('favorito')) || [
    {
      endereco: document.getElementById('box_origem').value,
      latitude: latitude_inicial,
      longitude: lonngitude_inicial
    }
  ];
  let txt_favorito = document.getElementById('txt_favorito');
  //altera o texto txt_favorito para o endereço favorito
  if (favorito.length > 0) {
    txt_favorito.innerHTML = favorito[0].endereco;
  }
}
function usar_favorito() {
  document.getElementById('box_origem').value = document.getElementById('txt_favorito').innerHTML;
  endereco_inicial = document.getElementById('txt_favorito').innerHTML;
  latitude_inicial = favorito[0].latitude;
  lonngitude_inicial = favorito[0].longitude;
  $("#modal_favorito").modal("hide");
}

function deletar_favorito() {
  localStorage.removeItem('favorito');
  document.getElementById('txt_favorito').innerHTML = '';
  Swal.fire('Endereço favorito deletado!');
  //fecha o modal
  $("#modal_favorito").modal("hide");
}

function salvar_favorito() {
  // Cria um array com apenas o novo favorito
  let favorito = [{
    endereco: document.getElementById('box_origem').value,
    latitude: latitude_inicial, 
    longitude: lonngitude_inicial
  }];

  // Salva o favorito no localStorage
  localStorage.setItem('favorito', JSON.stringify(favorito));
  preencher_favorito();

  //salvar também no histórico cuidado para não salvar o mesmo endereço e não ultrapassar 5 endereços
  let historico = JSON.parse(localStorage.getItem('historico')) || [];
  // Verifica se o endereço já existe no histórico
  const enderecoExiste = historico.some(item => 
    item.endereco_final === document.getElementById('box_origem').value
  );

  // Se não existir, adiciona ao histórico
  if (!enderecoExiste) {
    // Remove o item mais antigo se já tiver 5 items
    if (historico.length >= 5) {
      historico.shift(); // Remove o primeiro item (mais antigo)
    }

    // Adiciona o novo endereço
    historico.push({
      endereco_inicial: "",
      endereco_final: document.getElementById('box_origem').value,
      latitude_final: latitude_inicial,
      longitude_final: lonngitude_inicial,
      categoria: "Favorito",
      valor: "0,00",
      data: new Date().toLocaleString()
    });

    localStorage.setItem('historico', JSON.stringify(historico));

    console.log(historico);

  }



  //fecha o modal
  $("#modal_favorito").modal("hide");
  //exibe mensagem de sucesso
  Swal.fire('Endereço salvo como favorito!');
}


function preencher_historico() {
  let historico = JSON.parse(localStorage.getItem('historico')) || [];
  let select_historico = document.getElementById('historico_destinos');
  //preencher o select com os endereços de destino
  if (historico.length > 0) {
        //mostra div_historico
        document.getElementById('div_historico').style.display = 'block';
    for (let i = 0; i < historico.length; i++) {
      let option = document.createElement('option');
      option.text = historico[i].endereco_final;
      option.value = historico[i].endereco_final;
      select_historico.add(option);
    }
  }
}

//historico_destinos quando o usuário selecionar um endereço de destino preenche box_destino
//27
document.getElementById('historico_destinos').addEventListener('change', function (e) {
  document.getElementById('box_destino').value = e.target.value;
  //percorrer o historico para pegar os dados do endereço selecionado
  let historico = JSON.parse(localStorage.getItem('historico')) || [];
  for (let i = 0; i < historico.length; i++) {

    if (historico[i].endereco_final === e.target.value) {
      endereco_final = historico[i].endereco_final;
      latitude_final = historico[i].latitude_final;
      longitude_final = historico[i].longitude_final;
    }
  }
});




preencher_historico();

// Descreva esta função...
function resultado_chamado(resultado_retorno) {
  resultado_retorno = JSON.parse(resultado_retorno);
  id_corrida = resultado_retorno['id'];
  forma_de_pagamento = document.getElementById('forma_pagamento').value;
  if (forma_de_pagamento == 'Pix') {
    ajax_post_async((String(url_principal) + 'get_pix.php'), { user_id: cliente_id, valor: valor_corrida, corrida_id: id_corrida }, retorno_pix);
  } else {
    inicia_status_corrida();
    document.getElementById("loading").style.display = "none";
  }
}

// Descreva esta função...
function verifica_saldo(resposta_saldo) {
  resposta_saldo = JSON.parse(resposta_saldo);
  if (resposta_saldo['status'] == 'erro') {
    Swal.fire('Saldo insuficiente na carteira de crédito! Escolha outra forma de pagamento');
  } else {
    enviar_solicitacao_chamado();
  }
}

// Descreva esta função...
function copiar_pix() {
  function copyText() {
    var copyText = document.getElementById('pix_copia_cola');
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(copyText.value);
    } else {
      document.execCommand("copy");
    }
  }
  copyText();
}

// Descreva esta função...
function cancelar_pix() {
  $.ajax({
    url: (String(url_principal) + 'cancelar_pix.php'),
    type: "POST",
    data: { transacao_id: transacao_id, chave: 'valor' },
    async: true,
    success: function (data) {
      TextoRespostaAss = data;
      Swal.fire('Pagamento cancelado!');
      busca_login = setInterval(function () {
        window.location.href = "home.php";
      }, 1000);

    },
    error: function (data) {
      ErroRespostaAss = data;
      Swal.fire('Pagamento cancelado!');
      busca_login = setInterval(function () {
        window.location.href = "home.php";
      }, 1000);

    }
  });
}

// Descreva esta função...
function inicia_status_corrida() {
  $("#" + 'loading').hide();
  tempo_timer = 0;
  minutos = 0;
  temporizador_relogio = setInterval(function () {
    tempo_timer = tempo_timer + 1;
    if (tempo_timer > 59) {
      tempo_timer = 0;
      minutos = minutos + 1;
    }
    if (tempo_timer < 10) {
      $("#txt_timer").html(([minutos, ':', '0', tempo_timer].join('')));
    } else {
      $("#txt_timer").html(([minutos, ':', tempo_timer].join('')));
    }
  }, 1000);
  $("#" + 'tela_status').show();
  document.getElementById('tela_status').style.position = "fixed";
  document.getElementById('tela_status').style.bottom = "0px";
  document.getElementById('tela_status').style.left = "0";
  document.getElementById('tela_status').style.right = "0";
  document.getElementById('tela_status').style.zIndex = "29";
  temporizador_busca_status = setInterval(function () {
    ajax_post_async((String(url_principal) + 'get_status_chamado.php'), { telefone: telefone, senha: senha }, verifica_status);
  }, 5000);
  clearInterval(temporizador_busca_motoristas);
  $("#" + 'reprodutor_lottie_1').show();
  $("#" + 'tela_timer').show();
  deletar_itens_mapa();
}

// Descreva esta função...
function verifica_status_pix(dados_status_pix) {
  dados_status_pix = JSON.parse(dados_status_pix);
  if ('approved' == dados_status_pix['status_pagamento']) {
    clearInterval(temp_verifica_pix);
    $("#modal_pix").modal("hide");
    Swal.fire('Pagamento Recebido');
    inicia_status_corrida();
  }
}

// Descreva esta função...
function deletar_itens_mapa() {
  for (var i = 0; i < Makers.length; i++) {
    Makers[i].setMap(null);
  }
  Makers = [];
  for (var i = 0; i < Polylines.length; i++) {
    Polylines[i].setMap(null);
  }
  Polylines = [];
}

// Descreva esta função...
function verifica_status(dados_status) {
  deletar_itens_mapa();
  clearInterval(temporizador_busca_motoristas);
  dados_status = JSON.parse(dados_status);
  status_texto = dados_status['status_string'];
  msg = dados_status['msg'];
  lat_motorista_selecionado = (txt_to_number(dados_status['latitude']));
  lng_motorista_selecionado = (txt_to_number(dados_status['longitude']));
  if (status_texto == 'Aguardando Pagamento') {
    $("#" + 'tela_status').hide();
    $("#" + 'tela_barra_inicio').hide();
    $("#" + 'tela_img_motorista').hide();
    $("#" + 'tela_dados_motorista').hide();
    $("#" + 'reprodutor_lottie_1').hide();
    $("#" + 'reprodutor_lottie_2').hide();
    $("#" + 'reprodutor_lottie_3').hide();
    $("#" + 'reprodutor_lottie_4').hide();
    $("#" + 'tela_timer').hide();
    $("#" + 'card_cancelar').hide();
    clearInterval(temporizador_busca_status);
    url_imagem_pix = 'data:image/png;base64,' + String(dados_status['qr_code_base64']);
    transacao_id = dados_status['transacao_id'];
    pix_copia_cola = dados_status['qr_code'];
    $("#pix_copia_cola").val(pix_copia_cola);
    $("#" + 'img_pix').attr("src", url_imagem_pix);
    $("#modal_pix").modal("show");
    temp_verifica_pix = setInterval(function () {
      ajax_post_async((String(url_principal) + 'get_status_pix.php'), { transacao_id: transacao_id, chave: 'valor' }, verifica_status_pix);
    }, 2000);
  }
  if (msg) {
    if (msg.length > tamanho_msg) {
      tamanho_msg = msg.length;
      $("#icone_chat").html('mark_unread_chat_alt');
      $("#icone_chat").css("color", "#ff6600");
      $("#icone_chat").css("font-size", "28px");
      $("#icone_chat").css("font-style", "normal");
      $("#icone_chat").css("font-weight", "normal");
      function rotateElement(element, angle) {
        let el = document.getElementById(element);
        el.style.transition = "transform " + 1000 + "ms";
        el.style.transform = "rotate(" + angle + "deg)";
      }
      rotateElement('icone_chat', 360);
      document.getElementById('audio_message').play();
    }
  }
  if (status_texto != status_anterior) {
    document.getElementById('audio').play();
    status_anterior = status_texto;
  }
  if (status_texto == 'Procurando Motorista') {
    $("#" + 'tela_barra_inicio').hide();
    $("#" + 'tela_img_motorista').hide();
    $("#" + 'tela_dados_motorista').hide();
    $("#" + 'reprodutor_lottie_1').show();
    $("#" + 'tela_timer').show();
    ajax_post_async((String(url_principal) + 'get_all_motoristas.php'), { senha: senha, telefone: telefone }, mostrar_motoristas);
  }
  if (status_texto == 'Motorista a Caminho') {
    $("#" + 'tela_barra_inicio').hide();
    $("#" + 'reprodutor_lottie_1').hide();
    $("#" + 'tela_timer').hide();
    $("#" + 'img_motorista').attr("src", (String(url_imagem) + String(dados_status['motorista_img'])));
    $("#" + 'tela_img_motorista').show();
    $("#dados_motorista").html((['<span style="font-size:18px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['motorista_nome'] + ' </span>', '<br>', '<span style="font-size:15px; color:#000000; font-weight:normal; font-style:normal;">' + (dados_status['avaliacao'] > 0 && dados_status['avaliacao'] <= 1 ? '⭐' : (dados_status['avaliacao'] > 1 && dados_status['avaliacao'] <= 2 ? '⭐⭐' : (dados_status['avaliacao'] > 2 && dados_status['avaliacao'] <= 3 ? '⭐⭐⭐' : (dados_status['avaliacao'] > 3 && dados_status['avaliacao'] <= 4 ? '⭐⭐⭐⭐' : (dados_status['avaliacao'] > 4 && dados_status['avaliacao'] < 5 ? '⭐⭐⭐⭐⭐' : '⭐⭐⭐⭐⭐'))))) + ' </span>', '<br>Avaliação: ', dados_status['avaliacao'], ' / 5 •  Viagens ', dados_status['total_corridas'], '<br>Nível: ', '<span style="font-size:15px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['nivel'] + ' </span>', '<br>', '<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['veiculo'] + ' </span>', '<br>', '<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['placa'] + ' </span>'].join('')));
    var marker = new google.maps.Marker({
      position: { lat: lat_motorista_selecionado, lng: lng_motorista_selecionado },
      map: map,
      icon: "assets/car_green_a.png",
      title: "dados_status[motorista]",
      marker_id: 3
    });
    marker.addListener("click", function () {
      let id = this.marker_id;
    });
    Makers.push(marker);
    $("#dados_motorista").css("text-align", "center");
    $("#" + 'tela_dados_motorista').show();
  }
  if (status_texto == 'Motorista Chegou') {
    $("#" + 'tela_barra_inicio').hide();
    $("#" + 'reprodutor_lottie_1').hide();
    $("#" + 'tela_timer').hide();
    $("#" + 'img_motorista').attr("src", (String(url_imagem) + String(dados_status['motorista_img'])));
    $("#" + 'tela_img_motorista').show();
    $("#dados_motorista").html((['<span style="font-size:18px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['motorista_nome'] + ' </span>', '<br>', '<span style="font-size:15px; color:#000000; font-weight:normal; font-style:normal;">' + (dados_status['avaliacao'] > 0 && dados_status['avaliacao'] <= 1 ? '⭐' : (dados_status['avaliacao'] > 1 && dados_status['avaliacao'] <= 2 ? '⭐⭐' : (dados_status['avaliacao'] > 2 && dados_status['avaliacao'] <= 3 ? '⭐⭐⭐' : (dados_status['avaliacao'] > 3 && dados_status['avaliacao'] <= 4 ? '⭐⭐⭐⭐' : (dados_status['avaliacao'] > 4 && dados_status['avaliacao'] < 5 ? '⭐⭐⭐⭐⭐' : '⭐⭐⭐⭐⭐'))))) + ' </span>', '<br>Avaliação: ', dados_status['avaliacao'], ' / 5  • Viagens ', dados_status['total_corridas'], '<br>Nível: ', '<span style="font-size:15px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['nivel'] + ' </span>', '<br>', '<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['veiculo'] + ' </span>', '<br>', '<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['placa'] + ' </span>'].join('')));
    $("#dados_motorista").css("text-align", "center");
    $("#" + 'tela_dados_motorista').show();
    var marker = new google.maps.Marker({
      position: { lat: lat_motorista_selecionado, lng: lng_motorista_selecionado },
      map: map,
      icon: "assets/car_green_a.png",
      title: "dados_status[motorista]",
      marker_id: 3
    });
    marker.addListener("click", function () {
      let id = this.marker_id;
    });
    Makers.push(marker);
  }
  if (status_texto == 'Em Viagem') {
    $("#" + 'reprodutor_lottie_1').hide();
    $("#" + 'tela_barra_inicio').hide();
    $("#" + 'tela_img_motorista').hide();
    $("#" + 'tela_dados_motorista').hide();
    $("#" + 'reprodutor_lottie_2').show();
    $("#" + 'tela_timer').hide();
    $("#" + 'card_cancelar').hide();
    var marker = new google.maps.Marker({
      position: { lat: lat_motorista_selecionado, lng: lng_motorista_selecionado },
      map: map,
      icon: "assets/car_green_a.png",
      title: "dados_status[motorista]",
      marker_id: 3
    });
    marker.addListener("click", function () {
      let id = this.marker_id;
    });
    Makers.push(marker);
  }
  if (status_texto == 'Finalizada') {
    $("#" + 'tela_barra_inicio').hide();
    $("#" + 'tela_img_motorista').hide();
    $("#" + 'tela_dados_motorista').hide();
    $("#" + 'reprodutor_lottie_1').hide();
    $("#" + 'reprodutor_lottie_2').hide();
    $("#" + 'reprodutor_lottie_3').show();
    $("#" + 'tela_timer').hide();
    $("#" + 'card_cancelar').hide();
    $("#" + 'card_finalizar').show();
    $("#" + 'tela_txt_finalizar').show();
    $("#txt_total_fim").html((String('<span style="font-size:16px; color:#333333; font-weight:bold; font-style:normal;">' + 'Total R$ ' + ' </span>') + String('<span style="font-size:16px; color:#000000; font-weight:bold; font-style:normal;">' + dados_status['taxa'] + ' </span>')));
    clearInterval(temporizador_busca_status);
  }
  if (status_texto == 'Cancelada') {
    $("#" + 'tela_barra_inicio').hide();
    $("#" + 'tela_img_motorista').hide();
    $("#" + 'tela_dados_motorista').hide();
    $("#" + 'reprodutor_lottie_1').hide();
    $("#" + 'reprodutor_lottie_2').hide();
    $("#" + 'reprodutor_lottie_3').hide();
    $("#" + 'reprodutor_lottie_4').show();
    $("#" + 'tela_timer').hide();
    $("#" + 'card_cancelar').hide();
    $("#" + 'card_finalizar').show();
    clearInterval(temporizador_busca_status);
  }
  $("#txt_status").html(status_texto);
}

// Descreva esta função...
function retorno_pix(dados_retorno_pix) {
  dados_retorno_pix = JSON.parse(dados_retorno_pix);
  if (dados_retorno_pix['status'] == 'sucesso') {
    transacao_id = dados_retorno_pix['transacao_id'];
    url_imagem_pix = 'data:image/png;base64,' + String(dados_retorno_pix['qr_code_base64']);
    pix_copia_cola = dados_retorno_pix['qr_code'];
    $("#" + 'img_pix').attr("src", url_imagem_pix);
    $("#pix_copia_cola").val(pix_copia_cola);
    $("#modal_pix").modal("show");
    temp_verifica_pix = setInterval(function () {
      ajax_post_async((String(url_principal) + 'get_status_pix.php'), { transacao_id: transacao_id, chave: 'valor' }, verifica_status_pix);
    }, 2000);
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Houve um erro ao gerar o Pix',
      text: 'Tente novamente mais tarde'
    });
  }
  document.getElementById("loading").style.display = "none";
}


//feito com bootblocks.com.br
$("body").css("height", "100%");
$("html").css("height", "100%");
var map;
var Circles = [];
var Polylines = [];
var Polygons = [];
var Makers = [];
function initMap() {
  map = new google.maps.Map(document.getElementById('tela_mapa'), {
    center: { lat: (txt_to_number(latitude_usuario)), lng: (txt_to_number(longitude_usuario)) },
    zoom: 15
  });
  if (typeof onMapInitilize === "function") {
    onMapInitilize();
  }
  google.maps.event.addListener(map, 'click', function (event) {
    if (typeof onMapClick === "function") {
      onMapClick(event);
    }
  });
}
var script = document.createElement("script");
script.src = "https://maps.googleapis.com/maps/api/js?key=" + ' AIzaSyB8DXMpRNHPiqKsDK225wEROupDxVg0s_o' + "&libraries=places&callback=initMap";
script.async = true;
document.head.appendChild(script);


(function () {
  let elementoClick = document.getElementById('icone_menu');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      if (menu_aberto) {
        menu_aberto = false;
        largura_menu = largura_da_tela - largura_da_tela * 2;
        $("#" + 'tela_menu').css("position", "relative");
        $("#" + 'tela_menu').animate({ left: largura_menu + "px" }, 300);
        $("#icone_menu").html('menu');
        fechar_menu();
      } else {
        $("#icone_menu").html('menu_open');
        abrir_menu();
      }

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('tela_ajuda');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      $("#modal_ajuda").modal("show");

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('tela_carteira_credito');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.location.href = "carteira.php";
    });
  }
})();

(function () {
  let elementoClick = document.getElementById('tela_entregas');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.location.href = "entregas.php";
    });
  }
})();


(function () {
  let elementoClick = document.getElementById('estrela_4');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      zerar_estrelas();
      nota = 4;
      $("#estrela_1").attr("src", "assets/" + 'estrela.png');
      $("#estrela_2").attr("src", "assets/" + 'estrela.png');
      $("#estrela_3").attr("src", "assets/" + 'estrela.png');
      $("#estrela_4").attr("src", "assets/" + 'estrela.png');

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('lbl_ajuda');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      $("#modal_ajuda").modal("show");

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('tela_download_app_motorista');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.location.href = "instrucoes.php";
    });
  }
})();


(function () {
  let elementoClick = document.getElementById('tela_fale_conosco');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      $("#modal_contato").modal("show");

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('estrela_2');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      zerar_estrelas();
      nota = 2;
      $("#estrela_1").attr("src", "assets/" + 'estrela.png');
      $("#estrela_2").attr("src", "assets/" + 'estrela.png');

    });
  }
})();

//feito com bootblocks.com.br
document.getElementById('cabecalho').style.position = "fixed";
document.getElementById('cabecalho').style.top = "0px";
document.getElementById('cabecalho').style.left = "0";
document.getElementById('cabecalho').style.right = "0";
document.getElementById('cabecalho').style.zIndex = "26";
nota = 5;
largura_da_tela = (window.innerWidth * (100 / 100));
fechar_menu();
ref_user = localStorage.getItem('ref_user') || '';
nota_cliente = localStorage.getItem('nota') || '0.00';
nome_cliente = localStorage.getItem('nome_cliente') || '';
nome_cliente = nome_cliente.split(' ')[0];
latitude_usuario = localStorage.getItem('latitude') || '';
longitude_usuario = localStorage.getItem('longitude') || '';
token = localStorage.getItem('token') || '';
url_principal = localStorage.getItem('url_principal') || '';
url_imagem = localStorage.getItem('url_imagem') || '';
cidade_id = localStorage.getItem('cidade_id') || '';
cliente_id = localStorage.getItem('cliente_id') || '';
senha = localStorage.getItem('senha_cliente') || '';
telefone = localStorage.getItem('telefone_cliente') || '';
ajax_post_async((String(url_principal) + 'get_dados_cidade.php'), { token: token, cidade_id: cidade_id }, gerar_dados_cidade);
ajax_post_async((String(url_principal) + 'busca_inicio.php'), { senha: senha, telefone: telefone }, busca_inicio);
ajax_post_async((String(url_principal) + 'busca_avaliacoes_abertas.php'), { user_id: cliente_id, telefone: telefone }, exibe_avaliacao);
ajax_post_async((String(url_principal) + 'busca_dados_cliente.php'), { senha: senha, telefone: telefone }, dados_cliente);
$("#lbl_nome_cliente_menu").html(('Usuário wustoki,' + String(localStorage.getItem('nome_cliente') || '')));
$("#lbl_avaliacao").html((String(nota_cliente) + '⭐'));
qnt_passageiros = 0;
busca_login = setInterval(function () {
  ajax_post_async((String(url_principal) + 'busca_dados_cliente.php'), { senha: senha, telefone: telefone }, dados_cliente);
}, 5000);
em_pergunta = false;


(function () {
  let elementoClick = document.getElementById('estrela_5');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      zerar_estrelas();
      nota = 5;
      $("#estrela_1").attr("src", "assets/" + 'estrela.png');
      $("#estrela_2").attr("src", "assets/" + 'estrela.png');
      $("#estrela_3").attr("src", "assets/" + 'estrela.png');
      $("#estrela_4").attr("src", "assets/" + 'estrela.png');
      $("#estrela_5").attr("src", "assets/" + 'estrela.png');

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('estrela_3');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      zerar_estrelas();
      nota = 3;
      $("#estrela_1").attr("src", "assets/" + 'estrela.png');
      $("#estrela_2").attr("src", "assets/" + 'estrela.png');
      $("#estrela_3").attr("src", "assets/" + 'estrela.png');

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('estrela_1');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      zerar_estrelas();
      nota = 1;
      $("#estrela_1").attr("src", "assets/" + 'estrela.png');

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('tela_meus_dados');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      $("#modal_dados").modal("show");

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('lbl_download_motorista');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.location.href = "instrucoes.php";
    });
  }
})();

//feito com bootblocks.com.br
$("#tela_label_cabecalho").css("background-color", "#000000FF");
$("#tela_icone_menu").css("background-color", "#000000FF");
$("#tela_icone_chat").css("background-color", "#000000FF");
$("#card_iniciar").css("background-color", "#000000FF");
$("#cabecalho").css("display", "flex");
$("#cabecalho").css("justify-content", "center");
$("#tela_label_cabecalho").css("display", "flex");
$("#tela_label_cabecalho").css("justify-content", "center");
$("#tela_label_cabecalho").css("display", "flex");
$("#tela_label_cabecalho").css("align-items", "center");
$("#tela_icone_menu").css("display", "flex");
$("#tela_icone_menu").css("justify-content", "center");
$("#tela_icone_menu").css("display", "flex");
$("#tela_icone_menu").css("align-items", "center");
$("#tela_icone_chat").css("display", "flex");
$("#tela_icone_chat").css("justify-content", "center");
$("#tela_icone_chat").css("display", "flex");
$("#tela_icone_chat").css("align-items", "center");
$("#" + 'icone_menu').css("padding-left", 5 + "px");
$("#" + 'icone_menu').css("padding-right", 0 + "px");
$("#" + 'icone_menu').css("padding-top", 5 + "px");
$("#" + 'icone_menu').css("padding-bottom", 0 + "px");
$("#" + 'icone_chat').css("padding-left", 0 + "px");
$("#" + 'icone_chat').css("padding-right", 5 + "px");
$("#" + 'icone_chat').css("padding-top", 5 + "px");
$("#" + 'icone_chat').css("padding-bottom", 0 + "px");
document.getElementById('cabecalho').style['border-bottom-right-radius'] = '15px';
document.getElementById('cabecalho').style['border-bottom-left-radius'] = '15px';
document.getElementById('tela_icone_menu').style['border-bottom-left-radius'] = '15px';
document.getElementById('tela_icone_chat').style['border-bottom-right-radius'] = '15px';

//feito com bootblocks.com.br
$("#" + 'container_menu').css("padding-left", 30 + "px");
$("#" + 'container_menu').css("padding-right", 0 + "px");
$("#" + 'container_menu').css("padding-top", 0 + "px");
$("#" + 'container_menu').css("padding-bottom", 0 + "px");
$("#tela_carteira_credito").css("display", "flex");
$("#tela_carteira_credito").css("align-items", "center");
$("#tela_entregas").css("display", "flex");
$("#tela_entregas").css("align-items", "center");
$("#tela_meus_dados").css("display", "flex");
$("#tela_meus_dados").css("align-items", "center");
$("#tela_historico_corridas").css("display", "flex");
$("#tela_historico_corridas").css("align-items", "center");
$("#tela_download_app_motorista").css("display", "flex");
$("#tela_download_app_motorista").css("align-items", "center");
$("#tela_fale_conosco").css("display", "flex");
$("#tela_fale_conosco").css("align-items", "center");
$("#tela_ajuda").css("display", "flex");
$("#tela_ajuda").css("align-items", "center");
$("#tela_sair").css("display", "flex");
$("#tela_sair").css("align-items", "center");
$("#tela_site").css("display", "flex");
$("#tela_site").css("align-items", "center");
document.getElementById('tela_menu').style.border = 1 + "px solid " + "#333333";
$("#tela_menu").css("border-radius", "10px");

if (navigator.geolocation) {
  navigator.geolocation.watchPosition(function (position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
    velocidade = position.coords.speed;
    altitude = position.coords.altitude;
    latitude_usuario = latitude;
    longitude_usuario = longitude;
    localStorage.setItem('latitude', latitude);
    localStorage.setItem('longitude', longitude);
  }, function () {
    handleLocationError(true, infoWindow, map.getCenter());
  });
} else {
  // Browser doesn't support Geolocation
  handleLocationError(false, infoWindow, map.getCenter());
}

//feito com bootblocks.com.br
$("#loading").css("background-color", "rgba(0, 0, 0, 0)");
$("#loading").css("display", "flex");
$("#loading").css("justify-content", "center");
$("#" + 'loading').hide();

function onMapInitilize() {
  map.setOptions({ zoomControl: false });
  map.setOptions({ mapTypeControl: false });
  map.setOptions({ scaleControl: false });
  map.setOptions({ streetViewControl: false });
  function addAutocomplete() {
    var input = document.getElementById('box_origem');
    let radius = 10000;
    let center = new google.maps.LatLng(latitude_usuario, longitude_usuario);
    let circle = new google.maps.Circle({
      center: center,
      radius: radius
    });
    let options = {
      bounds: circle.getBounds()
    };
    autocomplete_box_origem = new google.maps.places.Autocomplete(input, options);
    autocomplete_box_origem.addListener("place_changed", () => {
      let place = autocomplete_box_origem.getPlace();
      endereco_texto = place.formatted_address;
      lat_resposta_1 = place.geometry.location.lat();
      long_resposta_2 = place.geometry.location.lng();
      endereco_inicial = endereco_texto;
      latitude_inicial = lat_resposta_1;
      lonngitude_inicial = long_resposta_2;
      var marker = new google.maps.Marker({
        position: { lat: lat_resposta_1, lng: long_resposta_2 },
        map: map,
        icon: "assets/marcador.png",
        title: "Origem",
        marker_id: 1
      });
      marker.addListener("click", function () {
        let id = this.marker_id;
      });
      Makers.push(marker);
    });
  }
  addAutocomplete();
  proximo_input();
  ajax_post_async((String(url_principal) + 'get_all_motoristas.php'), { senha: senha, telefone: telefone }, mostrar_motoristas);
  temporizador_busca_motoristas = setInterval(function () {
    ajax_post_async((String(url_principal) + 'get_all_motoristas.php'), { senha: senha, telefone: telefone }, mostrar_motoristas);
  }, 10000);
};

//feito com bootblocks.com.br
$("#" + 'reprodutor_lottie_1').hide();
$("#" + 'reprodutor_lottie_2').hide();
$("#" + 'reprodutor_lottie_3').hide();
$("#" + 'tela_status').hide();
$("#" + 'tela_categorias').hide();

//feito com bootblocks.com.br
endereco_inicial = '';
endereco_final = '';
latitude_inicial = '';
lonngitude_inicial = '';
latitude_final = '';
longitude_final = '';


(function () {
  let elementoClick = document.getElementById('tela_site');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.open('https://wustoki.com.br/', "_blank");

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('tela_sair');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      localStorage.clear();
      window.location.href = "index.php";
    });
  }
})();


(function () {
  let elementoClick = document.getElementById('btn_avancar');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      if (qnt_passageiros == 0) {
        Swal.fire('Informe quantos passageiros!');
      } else {
        if (document.getElementById('box_origem').value && document.getElementById('box_destino').value) {
          $("#" + 'loading').show();
          ajax_post_async((String(url_principal) + 'calcular_custos.php'), { cidade_id: cidade_id, lat_ini: latitude_inicial, lng_ini: lonngitude_inicial, lat_fim: latitude_final, lng_fim: longitude_final, qnt_usuarios: qnt_passageiros }, exibir_categorias);
        } else {
          Swal.fire('Preencha origem e destino!');
        }
      }

    });
  }
})();

//feito com bootblocks.com.br
$("#box_origem").css("border-radius", "15px");
$("#box_destino").css("border-radius", "15px");


(function () {
  let elementoClick = document.getElementById('card_cancelar');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      Swal.fire({
        title: 'Deseja realmente cancelar a corrida?',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
      }).then((result) => {
        if (result.value) {
          cancelar()
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          n_cancelar()
        }
      });

    });
  }
})();

//feito com bootblocks.com.br
$("#card_iniciar_chamado").css("background-color", "#000000FF");
$("#btn_avancar").css("background-color", "#000000FF");
$("#destinos_cabecalho").css("display", "flex");
$("#destinos_cabecalho").css("justify-content", "center");
$("#tela_lbl_destino").css("display", "flex");
$("#tela_lbl_destino").css("justify-content", "center");
$("#destinos_cabecalho").css("display", "flex");
$("#destinos_cabecalho").css("align-items", "center");
document.getElementById('card_iniciar_chamado').style.height = '80' + "px";
document.getElementById('card_iniciar_chamado').style.width = '90' + "%";
document.getElementById('card_iniciar_chamado').style.height = "auto";
document.getElementById('btn_avancar').style.height = '80' + "px";
document.getElementById('btn_avancar').style.width = '90' + "%";
document.getElementById('btn_avancar').style.height = "auto";
$("#btn_avancar").css("display", "flex");
$("#btn_avancar").css("justify-content", "center");
$("#card_iniciar_chamado").css("display", "flex");
$("#card_iniciar_chamado").css("justify-content", "center");
$("#btn_avancar").css("border-radius", "30px");
$("#card_iniciar_chamado").css("border-radius", "30px");
$("#btn_avancar").css("display", "flex");
$("#btn_avancar").css("align-items", "center");
$("#card_iniciar_chamado").css("display", "flex");
$("#card_iniciar_chamado").css("justify-content", "center");
$("#tela_lbl_categoria").css("display", "flex");
$("#tela_lbl_categoria").css("justify-content", "center");
$("#tela_btn_avancar").css("display", "flex");
$("#tela_btn_avancar").css("justify-content", "center");
$("#tela_card_iniciar_chamado").css("display", "flex");
$("#tela_card_iniciar_chamado").css("justify-content", "center");
$("#" + 'tela_lbl_categoria').css("padding-left", 0 + "px");
$("#" + 'tela_lbl_categoria').css("padding-right", 0 + "px");
$("#" + 'tela_lbl_categoria').css("padding-top", 10 + "px");
$("#" + 'tela_lbl_categoria').css("padding-bottom", 2 + "px");
$("#txt_tela_categorias").css("display", "flex");
$("#txt_tela_categorias").css("justify-content", "center");
$("#" + 'lbl_avancar').css("margin-left", 0 + "px");
$("#" + 'lbl_avancar').css("margin-right", 0 + "px");
$("#" + 'lbl_avancar').css("margin-top", 2 + "px");
$("#" + 'lbl_avancar').css("margin-bottom", 2 + "px");
$("#" + 'btn_avancar').css("margin-left", 0 + "px");
$("#" + 'btn_avancar').css("margin-right", 0 + "px");
$("#" + 'btn_avancar').css("margin-top", 0 + "px");
$("#" + 'btn_avancar').css("margin-bottom", 10 + "px");
$("#" + 'tela_destinos').hide();
$("#" + 'tela_btn_avancar').hide();
$("#" + 'tela_categorias').hide();
$("#box_qnt_passageiros").html('0');
$("#tela_qnt_usuarios").css("display", "flex");
$("#tela_qnt_usuarios").css("justify-content", "center");
document.getElementById('box_qnt_passageiros').style.height = '50' + "px";
document.getElementById('box_qnt_passageiros').style.width = '20' + "%";
document.getElementById('box_qnt_passageiros').style.height = "auto";
$("#icone_remove").css("border-radius", "10px");
$("#icone_add").css("border-radius", "10px");
document.getElementById('icone_add').style.border = 1 + "px solid " + "#333333";
document.getElementById('icone_remove').style.border = 1 + "px solid " + "#333333";
document.getElementById('box_qnt_passageiros').style.border = 2 + "px solid " + "#333333";
$("#icone_remove").css("display", "flex");
$("#icone_remove").css("align-items", "center");
$("#icone_add").css("display", "flex");
$("#icone_add").css("align-items", "center");
$("#" + 'icone_remove').css("margin-left", 20 + "px");
$("#" + 'icone_remove').css("margin-right", 20 + "px");
$("#" + 'icone_remove').css("margin-top", 0 + "px");
$("#" + 'icone_remove').css("margin-bottom", 0 + "px");
$("#" + 'icone_add').css("margin-left", 20 + "px");
$("#" + 'icone_add').css("margin-right", 20 + "px");
$("#" + 'icone_add').css("margin-top", 0 + "px");
$("#" + 'icone_add').css("margin-bottom", 0 + "px");


(function () {
  let elementoClick = document.getElementById('card_iniciar');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      $("#" + 'tela_barra_inicio').hide();
      document.getElementById('tela_destinos').style.position = "fixed";
      document.getElementById('tela_destinos').style.top = "0px";
      document.getElementById('tela_destinos').style.left = "0";
      document.getElementById('tela_destinos').style.right = "0";
      document.getElementById('tela_destinos').style.zIndex = "27";
      $("#" + 'tela_destinos').show();
      document.getElementById('tela_btn_avancar').style.position = "fixed";
      document.getElementById('tela_btn_avancar').style.bottom = "0px";
      document.getElementById('tela_btn_avancar').style.left = "0";
      document.getElementById('tela_btn_avancar').style.right = "0";
      document.getElementById('tela_btn_avancar').style.zIndex = "28";
      $("#" + 'tela_btn_avancar').show();
      obter_endereco_usuario();

    });
  }
})();

//feito com bootblocks.com.br
$("#" + 'tela_barra_inicio').animate({ height: (window.innerHeight * (20 / 100)) + "px", width: (window.innerWidth * (100 / 100)) + "px" }, 800);
document.getElementById('tela_barra_inicio').style.position = "fixed";
document.getElementById('tela_barra_inicio').style.bottom = "0px";
document.getElementById('tela_barra_inicio').style.left = "0";
document.getElementById('tela_barra_inicio').style.right = "0";
document.getElementById('tela_barra_inicio').style.zIndex = "21";
$("#tela_boas_vindas").css("display", "flex");
$("#tela_boas_vindas").css("justify-content", "center");
$("#tela_onde_vamos").css("display", "flex");
$("#tela_onde_vamos").css("justify-content", "center");
$("#tela_card_iniciar").css("display", "flex");
$("#tela_card_iniciar").css("justify-content", "center");
verificar_saudacao();
$("#" + 'lbl_boas_vindas').css("margin-left", 0 + "px");
$("#" + 'lbl_boas_vindas').css("margin-right", 0 + "px");
$("#" + 'lbl_boas_vindas').css("margin-top", 10 + "px");
$("#" + 'lbl_boas_vindas').css("margin-bottom", 0 + "px");
$("#card_iniciar").css("display", "flex");
$("#card_iniciar").css("justify-content", "center");
document.getElementById('card_iniciar').style.height = '80' + "px";
document.getElementById('card_iniciar').style.width = '80' + "%";
document.getElementById('card_iniciar').style.height = "auto";
$("#card_iniciar").css("border-radius", "30px");
$("#card_iniciar").css("display", "flex");
$("#card_iniciar").css("align-items", "center");
$("#" + 'lbl_onde_card_iniciar').css("margin-left", 0 + "px");
$("#" + 'lbl_onde_card_iniciar').css("margin-right", 0 + "px");
$("#" + 'lbl_onde_card_iniciar').css("margin-top", 2 + "px");
$("#" + 'lbl_onde_card_iniciar').css("margin-bottom", 2 + "px");


(function () {
  let elementoClick = document.getElementById('icone_add');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      if (qnt_passageiros == 4) {
        Swal.fire('Máximo 4 passageiros!');
      } else {
        qnt_passageiros = qnt_passageiros + 1;
        $("#box_qnt_passageiros").val(qnt_passageiros);
      }

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('icone_remove');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      if (qnt_passageiros <= 1) {
        Swal.fire('Mínimo 1 passageiro!');
      } else {
        qnt_passageiros = qnt_passageiros - 1;
        $("#box_qnt_passageiros").val(qnt_passageiros);
      }

    });
  }
})();

$("#box_qnt_passageiros").change(function () {
  if ($(this).val() < 1) {
    Swal.fire('Mínimo 1 passageiro!');
    $("#box_qnt_passageiros").val(qnt_passageiros);
  } else if ($(this).val() > 4) {
    Swal.fire('Máximo 4 passageiros!');
    $("#box_qnt_passageiros").val(qnt_passageiros);
  } else {
    qnt_passageiros = qnt_passageiros - 1;
  }
});


(function () {
  let elementoClick = document.getElementById('icone_chat');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.location.href = "mensagens.php";
    });
  }
})();


(function () {
  let elementoClick = document.getElementById('card_iniciar_chamado');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      forma_pagamento = document.getElementById('forma_pagamento').value;
      if (forma_pagamento != '0') {
        if (forma_pagamento == 'Carteira Crédito') {
          ajax_post_async((String(url_principal) + 'verifica_saldo.php'), { senha: senha, telefone: telefone, valor: valor_corrida }, verifica_saldo);
        } else {
          enviar_solicitacao_chamado();
        }
      } else {
        Swal.fire('Selecione a forma de Pagamento!');
      }

    });
  }
})();

//feito com bootblocks.com.br
$("#tela_cupon").css("display", "flex");
$("#tela_cupon").css("justify-content", "center");
$("#" + 'v_l').hide();

//feito com bootblocks.com.br
$("#tela_timer").css("display", "flex");
$("#tela_timer").css("justify-content", "center");
$("#card_cancelar").css("background-color", "#000000FF");
$("#tela_status_txt").css("display", "flex");
$("#tela_status_txt").css("justify-content", "center");
$("#tela_botoes_status").css("display", "flex");
$("#tela_botoes_status").css("justify-content", "center");
$("#card_cancelar").css("display", "flex");
$("#card_cancelar").css("justify-content", "center");
document.getElementById('tela_status').style.position = "fixed";
document.getElementById('tela_status').style.bottom = "0px";
document.getElementById('tela_status').style.left = "0";
document.getElementById('tela_status').style.right = "0";
document.getElementById('tela_status').style.zIndex = "28";
document.getElementById('card_cancelar').style.height = '80' + "px";
document.getElementById('card_cancelar').style.width = '80' + "%";
document.getElementById('card_cancelar').style.height = "auto";
$("#card_cancelar").css("border-radius", "30px");
$("#card_cancelar").css("display", "flex");
$("#card_cancelar").css("align-items", "center");
$("#" + 'txt_cancelar').css("margin-left", 0 + "px");
$("#" + 'txt_cancelar').css("margin-right", 0 + "px");
$("#" + 'txt_cancelar').css("margin-top", 2 + "px");
$("#" + 'txt_cancelar').css("margin-bottom", 2 + "px");
$("#" + 'tela_status').hide();
$("#tela_lottie").css("display", "flex");
$("#tela_lottie").css("justify-content", "center");
$("#" + 'tela_lottie').css("margin-left", 0 + "px");
$("#" + 'tela_lottie').css("margin-right", 0 + "px");
$("#" + 'tela_lottie').css("margin-top", 10 + "px");
$("#" + 'tela_lottie').css("margin-bottom", 5 + "px");
$("#" + 'reprodutor_lottie_2').hide();
$("#" + 'reprodutor_lottie_3').hide();
$("#" + 'reprodutor_lottie_4').hide();
$("#tela_img_motorista").css("display", "flex");
$("#tela_img_motorista").css("justify-content", "center");
$("#tela_dados_motorista").css("display", "flex");
$("#tela_dados_motorista").css("justify-content", "center");
$("#" + 'tela_img_motorista').hide();
$("#" + 'tela_dados_motorista').hide();
$("#" + 'audio').hide();
$("#tela_txt_finalizar").css("display", "flex");
$("#tela_txt_finalizar").css("justify-content", "center");
$("#" + 'tela_txt_finalizar').hide();

//feito com bootblocks.com.br
$("#card_finalizar").css("background-color", "#000000FF");
$("#card_finalizar").css("display", "flex");
$("#card_finalizar").css("justify-content", "center");
document.getElementById('card_finalizar').style.height = '80' + "px";
document.getElementById('card_finalizar').style.width = '80' + "%";
document.getElementById('card_finalizar').style.height = "auto";
$("#card_finalizar").css("border-radius", "30px");
$("#card_finalizar").css("display", "flex");
$("#card_finalizar").css("align-items", "center");
$("#" + 'card_finalizar').css("margin-left", 0 + "px");
$("#" + 'card_finalizar').css("margin-right", 0 + "px");
$("#" + 'card_finalizar').css("margin-top", 2 + "px");
$("#" + 'card_finalizar').css("margin-bottom", 2 + "px");
$("#" + 'card_finalizar').hide();


(function () {
  let elementoClick = document.getElementById('icone_voltar_destinos');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      $("#" + 'tela_destinos').hide();
      $("#" + 'tela_btn_avancar').hide();
      $("#" + 'tela_barra_inicio').show();

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('tela_historico_corridas');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.location.href = "historico.php";
    });
  }
})();

//feito com bootblocks.com.br
$("#tela_cabecalho_categorias").css("display", "flex");
$("#tela_cabecalho_categorias").css("justify-content", "center");
$("#" + 'icone_minimizar_categorias').css("margin-left", 0 + "px");
$("#" + 'icone_minimizar_categorias').css("margin-right", 10 + "px");
$("#" + 'icone_minimizar_categorias').css("margin-top", 10 + "px");
$("#" + 'icone_minimizar_categorias').css("margin-bottom", 0 + "px");
categorias_minimizado = false;

//feito com bootblocks.com.br
$("#tela_cabecalho_status").css("display", "flex");
$("#tela_cabecalho_status").css("justify-content", "center");
$("#" + 'icone_minimizar').css("margin-left", 0 + "px");
$("#" + 'icone_minimizar').css("margin-right", 10 + "px");
$("#" + 'icone_minimizar').css("margin-top", 10 + "px");
$("#" + 'icone_minimizar').css("margin-bottom", 0 + "px");
status_minimizado = false;

//feito com bootblocks.com.br
tamanho_msg = 0;
$("#" + 'audio_message').hide();
status_anterior = '';


(function () {
  let elementoClick = document.getElementById('icone_minimizar_categorias');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      if (categorias_minimizado) {
        categorias_minimizado = false;
        $("#" + 'tela_categorias').animate({ height: altura_tela_categorias + "px", width: (window.innerWidth * (100 / 100)) + "px" }, 800);
        $("#icone_minimizar_categorias").html('close_fullscreen');
      } else {
        altura_tela_categorias = document.getElementById('tela_categorias').offsetHeight;
        categorias_minimizado = true;
        $("#" + 'tela_categorias').animate({ height: 50 + "px", width: (window.innerWidth * (100 / 100)) + "px" }, 800);
        $("#icone_minimizar_categorias").html('open_in_full');
      }

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('icone_minimizar');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      if (status_minimizado) {
        status_minimizado = false;
        $("#" + 'tela_status').animate({ height: altura_tela_status + "px", width: (window.innerWidth * (100 / 100)) + "px" }, 800);
        $("#icone_minimizar").html('close_fullscreen');
      } else {
        status_minimizado = true;
        altura_tela_status = document.getElementById('tela_status').offsetHeight;
        $("#" + 'tela_status').animate({ height: 50 + "px", width: (window.innerWidth * (100 / 100)) + "px" }, 800);
        $("#icone_minimizar").html('open_in_full');
      }

    });
  }
})();


(function () {
  let elementoClick = document.getElementById('card_finalizar');
  if (elementoClick) {
    elementoClick.addEventListener("click", function () {
      window.location.href = "home.php";
    });
  }
})();
function ajax_post(url, dados) {
  let retorno;
  $.ajax({
    url: url,
    type: "POST",
    data: dados,
    async: false,
    success: function (data) {
      retorno = data;
    },
    error: function (data) {
      retorno = data;
    }
  });
  return retorno;
} function ajax_post_async(url, dados, funcao_chamar) {
  $.ajax({
    url: url,
    type: "POST",
    data: dados,
    async: true,
    success: function (data) {
      funcao_chamar(data);
    },
    error: function (data) {
      funcao_chamar(data);
    }
  });
}
function txt_to_number(txt) {
  txt = txt + "";
  if (txt.includes(",")) {
    txt = txt.replace(",", ".");
  }
  if (txt.includes(".")) {
    txt = parseFloat(txt);
  } else {
    txt = parseInt(txt);
  }
  return txt;
}
$(document).ready(function () {
  $("#loading-page-bb").css("opacity", "1");
});