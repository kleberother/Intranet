<?php
//Instancia Classe
$conn           =   "ora";
$obj            =   new models_T0058($conn);

$Codigo         =   $_POST['Codigo'];

$executaProcedure   =   $obj->executaProcedureCargaScritta($Codigo);

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
            </ul>
        </span>
    </div>
</div>

<div id="tabs">
    <div id="tabs-1">
        <form action="" method="post">
        <table class="form-inpu-tab">
            <thead>
                <tr>  
                    <th width="100px"><label>N° Teclado</label></th>
                </tr>
                <tr>
                    <td width="100px"><input type="text" name="Codigo" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="form-inpu-botoes">
                            <input type="submit"  value="Gerar Teclado" />
                        </div>
                    </td>
                </tr>
            </thead>
        </table>
        </form>
    </div>
</div>