<?php

$cod    =   $_GET['cod'];

$obj    =   new models_T0016("");

$Resumo = $obj->RetornaResumo($cod);

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

                 echo "<li><a href='?router=T0016/painel' class='active'>Painel de Aprovações</a></li>";
                ?>
                <li><a href="?router=T0016/fluxo">Fluxo AP</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="tabs">
    <ul>
        <li><a href="#tabs-2">Filtro Dinâmico</a></li>
    </ul>
    <div id="tabs-2">
        <form action="#">
        <table class="form-inpu-tab">
            <thead>
                <tr>
                    <th width="155px"><label>Filtro</label></th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="search" value="" id="id_search" />
                    </td>
                    <td><span class="loading">Carregando...</span></td>
                </tr>
            </thead>
        </table>
        </form>
    </div>
</div>
<div id="conteudo">
    <span class="lista_itens">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
                            <th width="6%">AP N°                    </th>
                            <th width="9%">Nota Fiscal<br/>Série   </th>
                            <th>Fornecedor<br/>CNPJ/CPF</th>
                            <th>Elaborado<br/>por                  </th>
                            <th width="13%">Última<br/>Etapa        </th>
                            <th>Vencimento                          </th>
                            <th>Valor<br/>Líquido                   </th>
                            <th>Arquivos                            </th>
                            <th width="9%">Ações                    </th>
			</tr>
		</thead>
                <tbody class="campos"></tbody>
	</table>
    </span>
</div>


