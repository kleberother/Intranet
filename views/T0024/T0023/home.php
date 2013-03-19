<?php
//Chama classes

//Classe para Artigos
//$objArtigo = new models_T0014();
//$Artigo    = $objArtigo->selecionaArtigo();

$user = $_SESSION['user'];

?>

<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0023/home" class="active">Listar</a></li>
                <li><a href="?router=T0023/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="conteudo">
   <span id="dados">
   <table cellspacing="1">
        <tr>
            <th>Código</th>
            <th>Código RMS</th>
            <th>Razão Social</th>
            <th>CNPJ / CPF</th>
            <th>Ações</th>
        </tr>
       <tr>
<tr>
<td align='center' style='background: #FFF;'></td>
<td align='center' style='background: #FFF;'></td>
<td style='background: #FFF;'></td>
<td align='center' style='background: #FFF;'></td>
<td align='center' width='50px' style='background: #FFF;'>
<ul class='acoes'>
<li><a href='ver_fornecedor.php?usuario=".($login)."' title='Ver'><img src='../../../css/img/ver.jpg' alt='Ver' /></a></li>
<li><a href='#' title='Alterar'><img src='../../../css/img/alterar.jpg' alt='Alterar' /></a></li>
<li><a href='lista_fornec_contato.php?fornecedor=$codigo' title='Contato'><img src='../../../css/img/contato.jpg' alt='Ver' /></a></li>
</ul>
</td>
</tr>
      </tr>
    </table>
</span>
</div>