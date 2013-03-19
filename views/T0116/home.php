<?php 

//Instancia Classe
$obj    =   new models_T0116();
 
if (!empty($_POST))
{
    $codigoArea     =   $_POST['T114_codigo']   ;
    $userPrincipal  =   $_POST['T004_principal'];
    $userSuplente   =   $_POST['T004_suplente'] ;
    $nomeArea       =   $_POST['T114_nome'];
        
    $dados  =   $obj->retornaAreas($codigoArea, $userPrincipal, $userSuplente, $nomeArea);
}else
    $dados  =   $obj->retornaAreas();

?>
<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">        
        <li><a href="#"                     class="abrirFiltros botao-padrao"><span class="ui-icon ui-icon-filter"  ></span>Filtros </a></li>
        <li><a href="?router=T0116/novo"    class="             botao-padrao"><span class="ui-icon ui-icon-plus"    ></span>Novo    </a></li>
    </ul>
</div>

<!-- Divs com filtros -->
<div class="div-primaria div-filtro">
    <form action="" method="post">
        
        <div class="conteudo_16">
            
            <div class="grid_3">
                <label class="label">Código Área</label>
                <input  type="text" name="T114_codigo" value="<?php echo $codigoArea;?>"/>
            </div>
            
            <div class="grid_3">
                <label class="label">Usuário Principal</label>
                <input  type="text" name="T004_principal" value="<?php echo $userPrincipal;?>"/>                
            </div>
            
            <div class="grid_3">
                <label class="label">Usuário Suplente</label>
                <input  type="text" name="T004_suplente" value="<?php echo $userSuplente;?>"/>                
            </div>
               
            <div class="grid_3">
                <label class="label">Nome da Área</label>
                <input  type="text" name="T114_nome" value="<?php echo $nomeArea;?>"/>                
            </div>
            
            
            <div class="grid_2">
                <input type="submit" value="Filtrar" class="botao-padrao" />                          
            </div>
            
            <div class="clear10"></div>
            
            <table class="tablesorter tDados">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Código Área             </th>
                        <th>Nome                    </th>
                        <th>Colaborador Principal   </th>
                        <th>Colaborador Suplente    </th>
                        <th>Ações                   </th>
                    </tr>
                </thead>
                <tbody class="campos">
                    <?php foreach($dados    as  $campos =>  $valores){?>
                    <tr class="linha_<?php echo $valores['CodigoArea'];?>">
                        <td><?php echo $valores['CodigoArea']   ;?></td>
                        <td><?php echo $valores['NomeArea']     ;?></td>
                        <td><?php echo $valores['PrincipalArea'];?></td>
                        <td><?php echo $valores['SuplenteArea'] ;?></td>
                        <td class="acoes">
                            <span class="lista_acoes">
                                <ul>
                                    <li class="ui-state-default ui-corner-all" title="Alterar">
                                        <a href="?router=T0116/alterar&codAN=<?php echo $valores['CodigoArea'];?>" class="ui-icon ui-icon-pencil"></a> 
                                    </li>
                                    <li class="ui-state-default ui-corner-all" title="Excluir">
                                        <a href="#" onclick="excluirLinha(<?php echo $valores['CodigoArea'];?>)" class="ui-icon ui-icon-closethick"></a> 
                                    </li>
                                </ul>
                           </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>            
            
            
        </div>
        
    </form>        
</div>