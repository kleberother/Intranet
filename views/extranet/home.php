<?php 

//echo "Bem vindo(a) Extranet! [home]<br>";

if ($_POST['action']=="logout")
{
    $autentica  =   new models;
    $autentica->autentica();
    header('Location:index.php');
}

?>


<div id="saudacao" class="padding-padrao-vertical">
    <p class="negrito">Seja bem-vindo à <span class="destaque-01">Extranet D´avó</span></p>
    <p>Utilize o menu de navegação acima para acessar as diferentes funcionalidades do sistema.</p>
</div>
    
<div id="dicas" class="padding-padrao-vertical">
    <div class="margim-padrao-horizontal">
	<p class="alinhado-esquerda margin-direita-05px"><span class='ui-icon ui-icon-lightbulb'></span></p>
	<p class="titulo-02">Dicas</p>
        <ul class="lista-dica">
            <li><p class="alinhado-esquerda margin-direita-05px"><span class='ui-icon ui-icon-arrow-4'></span></p>Utilize a tecla F11 do seu Internet Explorer para aumentar a área de visualização enquanto estiver utilizando o sistema. Isto possibilita que mais informações sejam vistas na tela de uma vez, diminuindo a necessidade da barra de rolagem lateral.<br/>Pressione uma vez a tecla F11 para ampliar e pressione novamente para voltar ao normal.</li>
            <li><p class="alinhado-esquerda margin-direita-05px"><span class='ui-icon ui-icon-clock'></span></p>Após realizar login no sistema, caso você não faça nenhuma operação por 20 minutos ou mais, será necessário realizar login novamente. Isto é uma medida de segurança presente em muitas aplicações Web/Internet.</li>
            <li><p class="alinhado-esquerda margin-direita-05px"><span class='ui-icon ui-icon-disk'></span></p>Nas telas de inclusão e alteração, sempre utilize o botão "salvar" para que as suas alterações não sejam perdidas.</li>                   
        </ul>
    </div>
</div>