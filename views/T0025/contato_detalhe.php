<?php
//Chama classes
$cod    = $_REQUEST['cod'];
$codcont = $_REQUEST['codcont'];

//Classe para Alterar usuario
$objT027 = new models_T0025();
$T027    = $objT027->buscaT027($cod,$codcont);

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0025/contato&cod=<?php echo $cod; ?>">Listar</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($T027 as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Detalhes do contato</p>
    </span>
    <span class="form-input">
        <table>
            <tr>
                <td colspan="2"><label class="label">Código  </label></td>
                <td>            <label class="label">Código Fornecedor </label></td>
            </tr>
            <tr>
                <td colspan="2"><p><?php echo $codcont; ?></p></td>
                <td>            <p><?php echo $cod; ?></p></td>
            </tr>
            <tr>
                <td colspan="2"><label class="label">Nome  </label></td>
                <td>            <label class="label">E-mail </label></td>
            </tr>
            <tr>
                <td colspan="2"><p><?php echo ($valores['P0025_T027_NOM']);?></p></td>
                <td>            <p><?php echo ($valores['P0025_T027_EMA']);?></p></td>
            </tr>
            <tr>
                <td><label class="label">Endereço      </label></td>
                <td><label class="label">N°</label></td>
                <td><label class="label">Cidade</label></td>
                <td><label class="label">UF</label></td>
            </tr>
            <tr>
                <td>            <p><?php echo ($valores['P0025_T027_END']);?></p></td>
                <td>            <p><?php echo ($valores['P0025_T027_NUM']);?></p></td>
                <td>            <p><?php echo ($valores['P0025_T027_CID']);?></p></td>
                <td>            <p><?php echo ($valores['P0025_T027_UF']);?></p></td>
            </tr>
            <tr>
                <td><label class="label">Observações</label></td>
            </tr>
            <tr>
                <td colspan="4"><p><?php echo ($valores['P0025_T027_OBS']);?></p></td>
            </tr>
        </table>
    </span>
    <?php } ?>
</div>

