<?php
if (!empty($_POST))
{
    $objWkf = new models_T0016();
    
    $tabela = "T008_T060";
    $Etapa  = $objWkf->retornaEtapaGrupo($_POST['Grupo']);
    $codAp  = $_POST['Ap'];
    foreach($Etapa as $campos=>$valores)
    {
        $array = array ( "T060_codigo"          =>  $valores['EtapaCodigo']
                       , "T008_codigo"          =>  $codAp
                       , "T008_T060_ordem"      =>  1
                       , "T008_T060_status"     =>  0
                       , "T004_login"           =>  $user);
        //inserirFluxoAp($valores['ProxEtapaCodigo'],1);
        $insere2 = $objWkf->inserir($tabela, $array);
        $insere3 = $objWkf->inserirFluxoAp($codAp, $valores['ProxEtapaCodigo'],2);
    }
}
?>

<div style="margin: 10px;">
<form action="" method="post">
    <label>Codigo Ap</label>
    <input type="text" name="Ap" />
    <label>Grupo</label>
    <input type="text" name="Grupo" />
    <br/>
    <input type="submit" value="Enviar" />
</form>
</div>