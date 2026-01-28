var retorno_otp, resposta, ret_otp, latitude, longitude, velocidade, altitude, retorno, telefone_recuperar, telefone, token, senha, url_principal, ref_user;

// Descreva esta função...
function enviar_otp() {
  ajax_post_async((String(url_principal) + 'envia_otp_recuperar.php'), {numero_telefone:document.getElementById('telefone_recuperar').value}, retorno_envia_otp);
  $("#btn_enviar_codigo").html('Enviando Aguarde ...');
}

// Descreva esta função...
function recuperar() {
  telefone_recuperar = document.getElementById('telefone_recuperar').value;
  if (!telefone_recuperar.length) {
    Swal.fire('Preencha com seu Telefone');
  } else {
    $("#modal_recuperar").modal("hide");
    $("#modal_tipo_verificacao").modal("show");
  }
}

// Descreva esta função...
function salvar_senha() {
  if (document.getElementById('senha_1').value == document.getElementById('senha_2').value) {
    ajax_post_async((String(url_principal) + 'reset_senha.php'), {telefone:document.getElementById('telefone_recuperar').value, senha:document.getElementById('senha_2').value, otp:document.getElementById('box_otp').value}, fim_recuperar);
  } else {
    Swal.fire('Senhas Diferentes!');
  }
}

// Descreva esta função...
function finalizar_verificao_otp(retorno_otp) {
  console.log(retorno_otp);
  if (JSON.parse(retorno_otp)['status'] == 'ok') {
    $("#modal_otp_verificacao").modal("hide");
    $("#modal_nova_senha").modal("show");
  } else {
    Swal.fire({
    icon: 'error',
    title: 'Erro',
    text: JSON.parse(retorno_otp)['msg']
    });
    $("#btn_verificar_otp").html('Verificar');
  }
}

// Descreva esta função...
function fim_recuperar(resposta) {
  console.log(resposta);
  Swal.fire('Salvo com sucesso!');
  window.location.href = "login.php";}

// Descreva esta função...
function verificar_otp() {
  $("#btn_verificar_otp").html('Verificando...');
  ajax_post_async((String(url_principal) + 'verificar_otp.php'), {otp:document.getElementById('box_otp').value, numero_telefone:document.getElementById('telefone_recuperar').value}, finalizar_verificao_otp);
}

// Descreva esta função...
function retorno_envia_otp(ret_otp) {
  console.log(ret_otp);
  ret_otp = JSON.parse(ret_otp);
  if (ret_otp['status'] == 'erro') {
    Swal.fire(ret_otp['msg']);
    $("#modal_tipo_verificacao").modal("hide");
    $("#modal_recuperar").modal("show");
  } else {
    $("#modal_tipo_verificacao").modal("hide");
    $("#modal_otp_verificacao").modal("show");
  }
}

// Descreva esta função...
function login() {
  telefone = document.getElementById('telefone_box').value;
  senha = document.getElementById('senha_box').value;
  if (!telefone.length) {
    Swal.fire('Preencha com o Telefone!');
  } else {
    if (!senha.length) {
      Swal.fire('Preencha com a Senha!');
    } else {
      document.getElementById('loading').style.position = "fixed";
      document.getElementById('loading').style.top = "50%";
      document.getElementById('loading').style.transform = "translateY(-50%)";
      document.getElementById('loading').style.left = "0";
      document.getElementById('loading').style.right = "0";
      document.getElementById('loading').style.zIndex = "20";
      $("#"+'loading').show();
      ajax_post_async((String(url_principal) + 'login_user.php'), {token:token, telefone:telefone, senha:senha, ref_cliente:ref_user}, finaliza_login);
    }
  }
}

// Descreva esta função...
function finaliza_login(retorno) {
  $("#"+'loading').hide();
  retorno = JSON.parse(retorno);
  if (retorno['status'] == 'sucesso') {
    if (retorno['ativo'] != 1) {
      Swal.fire({
      icon: 'error',
      title: 'Conta Bloqueada!',
      text: 'Erro'
      });
    } else {
      if (ref_user != retorno['ref_cliente']) {
        Swal.fire({
        title: 'Você fez login em outro dispositivo. Entrar aqui?',
        showCancelButton: false,
        confirmButtonText: 'Sim',
        cancelButtonText: '',
        }).then((result) => {
        if (result.value) {
        login_novamente()
        } else if (result.dismiss === Swal.DismissReason.cancel) {
        login_novamente()
        }
        });
      } else {
        localStorage.setItem('telefone_cliente',document.getElementById('telefone_box').value);
        localStorage.setItem('senha_cliente',document.getElementById('senha_box').value);
        localStorage.setItem('cidade_id',retorno['cidade_id']);
        localStorage.setItem('cliente_id',retorno['id']);
        localStorage.setItem('nome_cliente',retorno['nome']);
        localStorage.setItem('nota',retorno['nota']);
        window.location.href = "home.php";}
    }
  } else {
    Swal.fire({
    icon: 'error',
    title: retorno['erro'],
    text: 'Erro'
    });
  }
}

// Descreva esta função...
function login_novamente() {
  ajax_post_async((String(url_principal) + 'login_user.php'), {token:token, telefone:telefone, senha:senha, ref_cliente:ref_user}, finaliza_login);
}



        (function() {
            let elementoClick = document.getElementById('recuperar_lbl');
            if (elementoClick) {
                elementoClick.addEventListener("click", function () {
                      $("#modal_recuperar").modal("show");
  console.log('modal_recuperar');

                });
            }
        })();


        (function() {
            let elementoClick = document.getElementById('cadastrar_lbl');
            if (elementoClick) {
                elementoClick.addEventListener("click", function () {
                      window.location.href = "cadastro.php";
                });
            }
        })();

//feito com bootblocks.com.br
  if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
  } , function(error) {
    Swal.fire({
    icon: 'error',
    title: 'Localização negada',
    text: 'Alguns recursos podem não funcionar corretamente!'
    });
  });
  } else {
  alert("Seu navegador não suporta Geolocalização!");
  }

//feito com bootblocks.com.br
  token = localStorage.getItem('token') || '';
  url_principal = localStorage.getItem('url_principal') || '';
  ref_user = localStorage.getItem('ref_user') || '';

if (navigator.geolocation) {
navigator.geolocation.watchPosition(function(position) {
latitude = position.coords.latitude;
longitude = position.coords.longitude;
velocidade = position.coords.speed;
altitude = position.coords.altitude;
  localStorage.setItem('latitude',latitude);
  localStorage.setItem('longitude',longitude);
}, function() {
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
  $("#"+'loading').hide();

//feito com bootblocks.com.br
  $("#telefone_box").css("border-radius", "15px");
  $("#senha_box").css("border-radius", "15px");
  $("#logar_btn").css("border-radius", "15px");
  $("#tela_logo").css("display", "flex");
  $("#tela_logo").css("justify-content", "center");
  $("#tela_text_box").css("display", "flex");
  $("#tela_text_box").css("justify-content", "center");
  $("#logar_btn").css("height", "40px");
  $("#logar_btn").css("width", "100%");
  $("#tela_cadastrar").css("display", "flex");
  $("#tela_cadastrar").css("justify-content", "center");
  $("#tela_recuperar").css("text-align", "right");
  $("#tela_logo").css("background-color", "#000000FF");
  $("#tela_text_box").css("background-color", "#000000FF");
  $("#tela_recuperar").css("background-color", "#000000FF");
  $("#tela_cadastrar").css("background-color", "#000000FF");
  $("body").css("background-color", "#000000FF");
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