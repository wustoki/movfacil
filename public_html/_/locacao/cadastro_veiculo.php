<!DOCTYPE html>
<!doctype html>
<html lang="pt-br">
<?php include("head.php"); ?>

<body>
    <div id="cabecalho_msg" class="classe_da_tela" style="height: 50px; width: 100%; background-color: #000; display: flex; align-items: center; justify-content: center;">
        <div id="tela_icon_cabecalho" class="classe_da_tela" style=" height: auto; width: 25%; display: flex; align-items: center; justify-content: center;">
            <i id="voltar_btn" class="bi bi-arrow-left" style="font-size:24px; color: #ffffff;"></i>
        </div>
        <div id="txt_cabecalho" class="classe_da_tela" style=" height: auto; width: 75%;">
            <span class="meu_texto" id="lbl_tela" style="font-size: 18px; color: #ffffff; font-weight: bold; ">Cadastro de Veículo</span>
        </div>
    </div>
    <div class="container mt-2">
        <form method="POST" action="cad_veiculo.php" enctype="multipart/form-data">
            <span>Cadastre um veículo para locação:</span>
            <div class="form-row mt-3">
                <div class="form-group col-md-6">
                    <label for="placa">Placa</label>
                    <input type="text" class="form-control" id="placa" name="placa" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" placeholder="Ex: Onix, HB20, etc" name="modelo" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" placeholder="Ex: Chevrolet, Hyundai, etc." id="marca" name="marca" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="ano">Ano</label>
                    <input type="text" class="form-control" placeholder="Ex: 2024" id="ano" name="ano" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cor">Cor</label>
                    <input type="text" class="form-control" id="cor" placeholder="Ex: Branco" name="cor" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" class="form-control" required>
                        <option value="Carro">Carro</option>
                        <option value="Moto">Moto</option>
                        <option value="Van">Van</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tipo_combustivel">Tipo de Combustível</label>
                    <select id="tipo_combustivel" name="tipo_combustivel" class="form-control" required>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Flex">Flex</option>
                        <option value="Híbrido">Híbrido</option>
                        <option value="Diesel">Diesel</option>
                        <option value="GNV">GNV</option>
                        <option value="Elétrico">Elétrico</option>
                    </select>
                </div>
            </div>
            <!-- campos de imagens -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="foto1">Imagem Frente Veículo</label>
                    <input type="file" class="form-control" id="img_frente" name="img_frente" required>
                </div>
                <div class="form-group
                col-md-6">
                    <label for="foto2">Imagem Traseira Veículo</label>
                    <input type="file" class="form-control" id="img_traseira" name="img_traseira" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="foto3">Imagem Lateral Direita</label>
                    <input type="file" class="form-control" id="img_lateral_direita" name="img_lateral_direita" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="foto4">Imagem Lateral Esquerda</label>
                    <input type="file" class="form-control" id="img_lateral_esquerda" name="img_lateral_esquerda" required>
                </div>
            </div>
            <!-- img_documento -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="foto5">Imagem Documento Veículo</label>
                    <input type="file" class="form-control" id="img_documento" name="img_documento" required>
                </div>
            </div>

            <!-- inputs type hidden com telefone e senha vindos do local storage -->
            <input type="hidden" id="telefone_hidden" name="telefone" value="">
            <input type="hidden" id="senha_hidden" name="senha" value="">
            <script>
                document.getElementById('telefone_hidden').value = localStorage.getItem('telefone_cliente');
                document.getElementById('senha_hidden').value = localStorage.getItem('senha_cliente');
            </script>
            <button type="submit" class="btn btn-primary w-100 mb-3">
                Cadastrar <i class="bi bi-save"></i>
            </button>
        </form>
    </div>
</body>

</html>

<script>
    document.getElementById('voltar_btn').addEventListener('click', () => {
        location.href = 'veiculos.php';
    });
</script>