<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 19/01/2012 por Jorge Nova
 * Descrição: Programa para incluir os médicos de atendimento
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/



//Instancia Classe
$obj                =   new models_T0077();

if (!empty($_POST))
{       
    
    $tabela                 =   "T085_medico";
    
    $insere                 =   $obj->inserir($tabela, $_POST);
      
    // Número do programa
//    $numprog                =   "77";

    // Nome do programa
//    $nomeprog               =   "NOVO";  
    
    // Auditoria sobre a ocorrencia de inserção
//    if ($insere)
//    {
//        $ocorrencia =   "USUARIO ".strtoupper($_POST['T004_login'])."|INSERT|INSERIU NOVO USUARIO EXTERNO NO SISTEMA NA TABELA T004_USUARIO";
//
//        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);
//    }
//    else
//    {
//        $ocorrencia =   "USUARIO ".strtoupper($_POST['T004_login'])."|INSERT|NAO CONSEGUIU INSERIR NA TABELA T004_USUARIO";
//
//        $obj->insereAuditoria($numprog, $nomeprog, $ocorrencia);        
//    }     
    
    header('location:?router=T0077/home');    
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0077/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0077/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    <form action="" method="post" id="formCad">
        
        <label class="label">Nome</label>
        <input type="text" name="T085_nome"     />
        
        <label class="label">CRM</label>
        <input type="text" name="T085_crm"    />
               
        <div class="rodape-formulario-botao padding-5px-vertical margin-padrao-vertical">
            <input type="submit" value="Salvar" class="botao-padrao" >
        </div>
        
    </form>
</div>





