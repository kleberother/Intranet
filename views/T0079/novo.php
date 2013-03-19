<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/01/2012 por Jorge Nova
 * Descrição: Programa para incluir os locais de atendimento
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/



//Instancia Classe
$obj                =   new models_T0079();

$entidades          =   $obj->retornaEntidadesSelectBox();

// Verifica se o POST é vazio, caso não, executa o INSERT
if (!empty($_POST))
{       
    
    $tabela                 =   "T050_local_atendimento";
    
    $insere                 =   $obj->inserir($tabela, $_POST);
        
    header('location:?router=T0079/home');    
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0079/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0079/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    <form action="" method="post" id="formCad">
        
        <label class="label">Entidade Prestadora</label>
        <select name="T049_codigo">
            <option value="">Selecione...</option>
        <?php
            foreach($entidades  as $campos=>$valores)
            {
        ?>
            <option value="<?php echo $valores['Codigo']; ?>"><?php echo $valores['Codigo']." - ".$valores['Nome']; ?></option>
        <?php
            }
        ?>
        </select>
                     
        <label class="label">Nome</label>
        <input type="text" name="T050_nome"     />
                     
        <div class="rodape-formulario-botao padding-5px-vertical margin-padrao-vertical">
            <input type="submit" value="Salvar" class="botao-padrao" >
        </div>
        
    </form>
</div>





