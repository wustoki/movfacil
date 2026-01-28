var latitude, longitude, velocidade, altitude, dados_retorno, ret_otp, retorno_otp, retorno, cpf, lista_de_cidades, nome, aceitou_termos, token, telefone, url_principal, senha, senha_2, Item, cpf_verificado, cidade_id, email;

// Descreva esta função...
function enviar_otp() {
  ajax_post_async((String(url_principal) + 'envia_otp_cadastro.php'), {numero_telefone:telefone}, retorno_envia_otp);
  $("#btn_enviar_codigo").html('Enviando Aguarde ...');
}

// Descreva esta função...
function cadastro_ok() {
  Swal.fire('Cadastrado com sucesso!');
  var temp = setInterval(nova_tela, 1000);
}

// Descreva esta função...
function nova_tela() {
  window.location.href = "principal.php";}

// Descreva esta função...
function verificar_otp() {
  $("#btn_verificar_otp").html('Verificando...');
  ajax_post_async((String(url_principal) + 'verificar_otp.php'), {otp:document.getElementById('box_otp').value, numero_telefone:telefone}, finalizar_verificao_otp);
}

// Descreva esta função...
function cadastrar() {
  nome = document.getElementById('nome_box').value;
  telefone = document.getElementById('telefone_box').value;
  senha = document.getElementById('senha_box').value;
  senha_2 = document.getElementById('senha_box_2').value;
  cidade_id = document.getElementById('cidades').value;
  cpf = document.getElementById('cpf_box').value;
  email = document.getElementById('email_box').value;
  if (!telefone.length) {
    Swal.fire('Preencha com seu Telefone');
  } else {
    if (!email.length || !(email.includes('@'))) {
      Swal.fire('Email Inválido');
    } else {
      if (!cpf.length) {
        Swal.fire('Preencha com seu CPF');
      } else {
        if (!senha.length) {
          Swal.fire('Preencha com sua Senha');
        } else {
          if (senha != senha_2) {
            Swal.fire('Senhas são diferentes!');
          } else {
            if (!aceitou_termos) {
              Swal.fire('Aceite os Termos de Uso');
            } else {
              if (cidade_id == 0) {
                Swal.fire('Selecione uma Cidade!');
              } else {
                if (cpf_verificado) {
                  envia_cadastro();
                } else {
                  $("#modal_tipo_verificacao").modal("show");
                }
              }
            }
          }
        }
      }
    }
  }
}

// Descreva esta função...
function listar_cidades(dados_retorno) {
  $("#cidades").empty();
  $("#cidades").append("<option value="+0+" selected >"+'Cidade'+"</option>");
  lista_de_cidades = JSON.parse(dados_retorno);
  for (var Item_index in lista_de_cidades) {
    Item = lista_de_cidades[Item_index];
    $("#cidades").append("<option value="+Item['id']+">"+Item['nome']+"</option>");
  }
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
function finalizar_verificao_otp(retorno_otp) {
  console.log(retorno_otp);
  if (JSON.parse(retorno_otp)['status'] == 'ok') {
    $("#modal_otp_verificacao").modal("hide");
    cpf_verificado = true;
    envia_cadastro();
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
function envia_cadastro() {
  document.getElementById('loading').style.position = "fixed";
  document.getElementById('loading').style.top = "50%";
  document.getElementById('loading').style.transform = "translateY(-50%)";
  document.getElementById('loading').style.left = "0";
  document.getElementById('loading').style.right = "0";
  document.getElementById('loading').style.zIndex = "20";
  $("#"+'loading').show();
  ajax_post_async((String(url_principal) + 'cadastra_user.php'), {token:token, nome:nome, telefone:telefone, senha:senha, cidade_id:cidade_id, latitude:latitude, longitude:longitude, cpf:cpf, email:email}, finaliza_cadastro);
}

// Descreva esta função...
function ok_termos() {
  aceitou_termos = true;
}

// Descreva esta função...
function finaliza_cadastro(retorno) {
  $("#"+'loading').hide();
  retorno = JSON.parse(retorno);
  if (retorno['status'] == 'sucesso') {
    Swal.fire('Cadastrado com sucesso!');
    var fechar = setInterval(salvar_local, 1000);
  } else {
    Swal.fire({
    icon: 'error',
    title: retorno['status'],
    text: 'Erro'
    });
  }
}

// Descreva esta função...
function salvar_local() {
  localStorage.setItem('nome_cliente',nome);
  localStorage.setItem('telefone_cliente',telefone);
  localStorage.setItem('senha',senha);
  localStorage.setItem('cidade_id',cidade_id);
  window.location.href = "login.php";}


//feito com bootblocks.com.br
  $("#nome_box").css("border-radius", "15px");
  $("#telefone_box").css("border-radius", "15px");
  $("#senha_box").css("border-radius", "15px");
  $("#senha_box_2").css("border-radius", "15px");
  $("#logar_btn").css("border-radius", "15px");
  $("#cidades").css("border-radius", "15px");
  $("#cpf_box").css("border-radius", "15px");
  $("#email_box").css("border-radius", "15px");
  input = document.getElementById('telefone_box');
  input.addEventListener("keyup", function (e) {
  numero = input.value
  numero = numero.replace(/\D/g,"")
  numero = numero.replace(/(\d{2})(\d)/,"($1) $2")
  numero = numero.replace(/(\d)(\d{4})$/,"$1-$2")
   input.value = numero;
  console.log(numero);
  });
  let entrada = document.getElementById('cpf_box');
  entrada.addEventListener("input", function(e) {
    let v = this.value.replace(/\D/g,"");
    this.value = v.replace(/(\d{3})(\d)/,"$1.$2")
               .replace(/(\d{3})(\d)/,"$1.$2")
               .replace(/(\d{3})(\d{1,2})$/,"$1-$2");
  });
  cpf_verificado = false;
  $(".center").css("display", "flex");
  $(".center").css("justify-content", "center");

//feito com bootblocks.com.br
  if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
  } , function(error) {
  });
  } else {
  alert("Seu navegador não suporta Geolocalização!");
  }

$("#cpf_box").change(function(){
  cpf = $(this).val();
  if (!(/^\d{3}\.\d{3}\.\d{3}-\d{2}$/).test(cpf)) {
    Swal.fire('CPF Inválido!');
  }
});

//feito com bootblocks.com.br
  $("#loading").css("background-color", "rgba(0, 0, 0, 0)");
  $("#loading").css("display", "flex");
  $("#loading").css("justify-content", "center");
  $("#"+'loading').hide();

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
  lista_de_cidades = [];
  token = localStorage.getItem('token') || '';
  url_principal = localStorage.getItem('url_principal') || '';
  ajax_post_async((String(url_principal) + 'get_cidades.php'), {token:token}, listar_cidades);


        (function() {
            let elementoClick = document.getElementById('logar_lbl');
            if (elementoClick) {
                elementoClick.addEventListener("click", function () {
                      window.location.href = "login.php";
                });
            }
        })();

//feito com bootblocks.com.br
  $("#tela_logo").css("display", "flex");
  $("#tela_logo").css("justify-content", "center");
  $("#tela_txt_cadastro").css("display", "flex");
  $("#tela_txt_cadastro").css("justify-content", "center");
  $("#logar_btn").css("height", "40px");
  $("#logar_btn").css("width", "100%");
  $("#tela_cadastrar").css("display", "flex");
  $("#tela_cadastrar").css("justify-content", "center");
  $("body").css("background-color", "#000000FF");
  $("#tela_logo").css("background-color", "#000000FF");
  $("#tela_txt_cadastro").css("background-color", "#000000FF");
  $("#tela_cadastrar").css("background-color", "#000000FF");
  $("#tela_termos").css("background-color", "#000000FF");
  aceitou_termos = false;


        (function() {
            let elementoClick = document.getElementById('termos_link');
            if (elementoClick) {
                elementoClick.addEventListener("click", function () {
                      window.open('https://wustoki.com.br/termos-de-uso-e-politica-de-privacidade/', "_blank");

                });
            }
        })();

if ('OTPCredential' in window) {
  window.addEventListener('DOMContentLoaded', e => {
    const input = document.getElementById('box_otp');
    if (!input) return;
    const ac = new AbortController();
    navigator.credentials.get({
      otp: { transport: ['sms'] },
      signal: ac.signal
    }).then(otp => {
      input.value = otp.code;
      console.log(otp.code);
      document.getElementById("btn_verificar_otp").click();
      // Em ambientes de produção é importante verificar se o otp.code é um número.
      // if (!isNaN(otp.code)) {
      //    input.value = otp.code;
      //    document.getElementById("btn_verificar_otp").click();
      // }
    }).catch(err => {
      console.log(err);
    });
  });
}
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