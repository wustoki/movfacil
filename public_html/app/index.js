var url_principal, user_id, url_do_app, url_imagem, ref_user;

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
function continuar() {
  user_id = localStorage.getItem('cliente_id') || '';
  if (!user_id.length) {
    window.location.href = "login.php";} else {
    window.location.href = "home.php";}
}


//feito com bootblocks.com.br
  // use verdadeiro para limpar o cache nos testes
  if (false) {
    localStorage.clear();
  }

//feito com bootblocks.com.br
  url_principal = 'https://movfacil.com.br/' + '_/app/';
  url_do_app = 'https://www.movfacil.com.br';
  url_imagem = String(url_do_app) + '/_/admin/uploads/';
  localStorage.setItem('url_principal',url_principal);
  localStorage.setItem('url_do_app',url_do_app);
  localStorage.setItem('url_imagem',url_imagem);
  $("#splash").css("display", "flex");
  $("#splash").css("justify-content", "center");
  $("#splash").css("display", "flex");
  $("#splash").css("align-items", "center");
  $("body").css("height", "100%");
  $("html").css("height", "100%");
  document.getElementById('splash').style.height = '100' + "%";
  document.getElementById('splash').style.width = '100' + "%";
  $("#splash").css("background-color", "#000000FF");
  $("#"+'img_logo').animate({height:200+"px",width:200+"px"},2000);
  ref_user = localStorage.getItem('ref_user') || '';
  if (!ref_user.length) {
    ref_user = mathRandomInt(1000, 99999);
    localStorage.setItem('ref_user',ref_user);
  }

//feito com bootblocks.com.br
  var timer_inicio = setInterval(continuar, 2000);

function rejectFunction(){
  continuar();
}

function installFunction(){
  continuar();
}

function notInstalledFunction(){
  clearInterval(timer_inicio);
}

        $(document).ready(function(){
            $("#loading-page-bb").css("opacity", "1");
        });