<?php 
//other user
//Instancia Classe
$obj    =   new models_T0117();



         
         

?>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="?router=T0117/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
    </ul>
</div>

<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo_16">
            
            <div class="grid_3">
                <label class="label">Título</label>
                <input  type="text" name="T113_titulo"/>
            </div>
            
            <div class="grid_3">
                <label class="label">Descrição</label>
                <input  type="text" name="T113_descricao"/>                
            </div>
            
            <div class="grid_3">
                <label class="label">Solicitante</label>
                <input  type="text" name="T004_solicitante"/>                
            </div>
            
            <div class="grid_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div>
            
            <div class="clear10"></div>
            
            <table class="tablesorter tDados">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Solicitação </th>
                        <th>Data Hora   </th>
                        <th>Título      </th>
                        <th>Solicitante </th>
                        <th>Status      </th>
                        <th>Ações       </th>
                    </tr>
                </thead>
                <tbody class="campos">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>   
                    </tr>
                </tbody>
            </table>            
            
            
        </div>
        
    </form>        
</div>