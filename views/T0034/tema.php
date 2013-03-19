<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/09/2011 por Rodrigo Alfieri
 * Descrição: Programa para cadastro de tema para TV Digital  
 * Entradas:   
 * Origens:   Menu Sistema
           
***************************************************************************/

$obj = new models_T0034();



?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0034/home"                >Painéis</a></li>
                <li><a href="?router=T0034/novo"                >Novo   </a></li>
                <li><a href="?router=T0034/tema" class="active" >Temas  </a></li>                
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-2">Novo Tema</a></li>
    </ul>
    <div id="tabs-2">
        <form action="" method="post">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th width="155px"><label>Nome</label></th>
                    <th><label>Descrição</label></th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="T076_nome" value=""/>                        
                    </td>
                    <td>
                        <input type="text" name="T076_desc" value=""/>                        
                    </td>
                </tr>                
            </thead>
        </table>
        <div class="form-inpu-botoes">
            <input type="submit"            value="Criar" />
        </div>            
        </form>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                            <th width="8%">Código   </th>
                            <th>Nome                </th>
                            <th>Descrição           </th>
			</tr>
		</thead>
		<tbody>
                        <?php foreach($Dados as $campos=>$valores){?>
			<tr class="dados">
				<td><?php echo ($valores['']);?></td>				
				<td><?php echo ($valores['']);?></td>				
				<td><?php echo ($valores['']);?></td>				
			</tr>
                        <?php }?>
		</tbody>
	</table>
    </span>
</div>
<?php
/* -------- Controle de versões - tema.php --------------
 * 1.0.0 - 14/09/2011   --> Liberada a versão
*/
?>