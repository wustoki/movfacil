/**
 * Arquivo: instrucoes.js
 * Descrição: Contém a lógica de download do APK, ajustes de estilo do botão
 * e controle de carregamento da página.
 */

// ===============================================
// FUNÇÃO DE DOWNLOAD (CHAMADA PELO ONCLICK NO HTML)
// ===============================================

/**
 * Inicia o download do arquivo APK do motorista e notifica o usuário
 * sobre os próximos passos da instalação (Fontes Desconhecidas).
 */
function iniciar_download() {
  // 1. Inicia o download do arquivo APK
  window.location.href = 'https://movfacil.com.br/apk/motorista_movfacil.apk';

  // 2. Usa SweetAlert (Swal) para dar feedback visual ao usuário
  // Usamos um pequeno timeout para garantir que o navegador comece o download antes de mostrar o alerta
  setTimeout(function() {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: 'Download Iniciado!',
        text: 'Verifique suas notificações. O arquivo APK está sendo baixado. Após o download, toque no arquivo para instalar. Lembre-se: o Android pode exigir que você ative a permissão de "Fontes Desconhecidas" para o seu navegador!',
        icon: 'info',
        confirmButtonText: 'Entendido'
      });
    } else {
      // Fallback caso SweetAlert não carregue
      alert("O download do arquivo APK deve começar em instantes. Por favor, verifique suas notificações e, após o download, toque para instalar.");
    }
  }, 1000); 
}


// ===============================================
// AJUSTES DE ESTILO E CARREGAMENTO (EXECUÇÃO)
// ===============================================

// Certifica-se de que o código abaixo só será executado quando a página (DOM) estiver totalmente carregada.
// Isso evita erros se o script for executado antes dos elementos 'btn_download' e 'loading-page-bb' existirem.
$(document).ready(function(){
    // feito com bootblocks.com.br

    // 1. Ajusta o estilo do botão de download (btn_download)
    var btn = document.getElementById('btn_download');
    if (btn) {
        btn.style.height = '100px';
        btn.style.width = '100%';
        btn.style.height = 'auto'; // Ajuste final de altura
    }

    // 2. Define a opacidade da página de carregamento para 1 (mostrando-a)
    $("#loading-page-bb").css("opacity", "1");
});