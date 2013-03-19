<?php
$user = $_SESSION['user'];
//Chama classes

//Classe para APS
$objAp      =   new models_T0016();

$cod = $_POST['busca_ap'];
//echo $nf  = $_POST['busca_nf'];

if (!empty($cod))
{
$buscaFluxo = $objAp->BuscaFluxo($cod);
$BuscaAP    = $objAp->BuscaAP($cod);
}
?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0016/home">Listar</a></li>
                <li><a href="?router=T0016/novo">Novo</a></li>
                <?php
                if (($user == 'jnova') || ($user == 'msasanto') || ($user == 'cmlima') || ($user == 'aribeiro') || ($user == 'gssilva'))
                 echo "<li><a href='?router=T0016/monitora'>Visualizar Antigas</a></li>";

                 echo "<li><a href='?router=T0016/painel'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo" class="active">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Filtro</a></li>
    </ul>
    <div id="tabs-1">
        <form action="" method="post">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th width="100px"><label>N° AP</label></th>
<!--                    <th><label>N° Nota Fiscal</label></th>-->
                </tr>
                <tr>
                    <td width="100px"><input type="text" name="busca_ap" /></td>
<!--                    <td>              <input type="text" name="busca_nf"  /></td>-->
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="form-inpu-botoes">
                            <input type="submit"  value="Buscar" />
                        </div>
                    </td>
                </tr>
            </thead>
        </table>
        </form>
    </div>
</div>
<div id="conteudo">
    <span class="form-titulo">
        <?php
            foreach($BuscaAP as $cmpap=>$vlrap)
            {
            $title = "Fornecedor: ".$vlrap['CodigoFor']."-".$vlrap['DigitoFor']." - ".$vlrap['RazaoSocial'];
            ?>
            <span class="form-titulo">
            <p title="<?php echo $title; ?>">AP <?php echo $vlrap['CodigoAP']." - Elaborado por: ".$vlrap['Login']." - ".$vlrap['Nome']." - Data de Elaboração: ".$vlrap['DtElaboracao']; ?></p>
            </span>
            <a href="?router=T0016/detalhe&cod=<?php echo $vlrap['CodigoAP']; ?>&orig=fluxo">Visualizar AP</a>
    
            <?php
            }
        ?>
    </span>

    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
                    <tr class="ui-widget-header ">
                        <th width="5%">Seq</th>
                        <th>Grupo</th>
                        <th width="18%">Aprovação</th>
                        <th>Usuários do Grupo</th>
                    </tr>
		</thead>
                <tbody>
                    <?php
                    foreach($buscaFluxo as $campos=>$valores)
                    {
                    ?>
                    <tr>
                        <td><?php echo $valores["Ordem"]; ?></td>
                        <?php
                        $BuscaGrupo = $objAp->BuscaGruposNomes($valores["Codigo59"]);
                        foreach ($BuscaGrupo as $cgrp=>$vlrgrp)
                        {                         
                        ?>
                        <td><?php echo $vlrgrp["Codigo"] = $objAp->preencheZero("E", 3, $vlrgrp["Codigo"]). " - " .$vlrgrp["Nome"] ?></td>
                        <?php
                        }
                        ?>
                        <td>
                            <p>
                                <?php
                                    if ($valores["Status"] == 1)
                                        echo "<b>Em:</b> ".$valores["DtAprovacao"]."<br/><b>Por:</b> ".strtolower($valores["Login"]);
                                    else
                                        echo "Ainda não houve aprovação";
                                ?>
                            </p>
                        </td>
                        <?php
                        $BuscaUsuario = $objAp->BuscaUsuarioGrupo($valores["Codigo59"]);
                        ?>
                        <td>
                            <table style="border: 1px solid transparent;">
                             <?php
                                foreach($BuscaUsuario as $cusu=>$vlrusu)
                                {
                             ?>
                                <tr>
                                    <td style="border: 1px solid transparent; padding: 1px; font-weight: bolder;" width="50px" ><?php echo $vlrusu["Login"]; ?></td>
                                    <td style="border: 1px solid transparent; padding: 1px;" width="5px">-</td>
                                    <td style="border: 1px solid transparent; padding: 1px;"><?php echo $vlrusu["Nome"];  ?></td>
                                </tr>
                             <?php
                                }
                             ?>
                            </table>
                        </td>

                    </tr>
                    <?php
                    }
                    ?>
<!--                    <tr>
                        <td colspan="3" align="center">Sem dados</td>
                    </tr>-->
                </tbody>
	</table>
    </span>
</div>