<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 23/01/2012 por Jorge Nova
 * Descrição: Programa para incluir novos funcionários
 * Entradas:   
 * Origens:   Menu Sistema
           
**************************************************************************
*/



//Instancia Classe
$obj                =   new models_T0083();

if (!empty($_POST))
{       
    
    $tabela                 =   "T052_colaborador";
    
    $insere                 =   $obj->inserir($tabela, $_POST);
          
    header('location:?router=T0083/home');    
}

?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0083/novo" class="botao-padrao"><span class="ui-icon ui-icon-plus"            ></span>Novo    </a></li>
        <li><a href="?router=T0083/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="div-primaria padding-padrao-vertical">
    
    <form action="" method="post">
        
        <label class="label">Matrícula</label>
        <input type="text" name="T052_matricula"     />
        
        <label class="label">Nome</label>
        <input type="text" name="T052_nome"          />
               
        <div class="rodape-formulario-botao padding-5px-vertical margin-padrao-vertical">
            <input type="submit" value="Salvar" class="botao-padrao" >
        </div>
        
    </form>
    
</div>





