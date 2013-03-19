<?php 

// Instancia conexão com a models do programa 67
$obj    =  new models_T0067($conn);

// Define na variavel usuário com o session user
$user   = $_SESSION['user'];

?>

<!-- Div para capturar o valor de usuário e preecher no formulário de upload -->
<div id="usuario" style="display: none;">
<?php echo $user; ?>
</div>

<?php

// Retorna o Grantor do arquivo para upload como Owner
$buscaGrantor   =   $obj->retornaGrantor($user);

foreach($buscaGrantor as $campos=>$valores)
{
    $grantor    =   $valores['Grantor'];
}
?>

<!-- Div para capturar o valor de grantor e preecher no formulário de upload -->
<div id="grantor" style="display: none;">
<?php echo $grantor; ?>
</div>

<?php


$Arquivos           = $obj->retornaArquivos($user);
$ArquivosPermissao  = $obj->retornaArquivosComPermissao($user);

?>


<!-- Div onde inicia o programa -->
<div id="abas">
    <ul>
        <li><a href="#aba-1">Adicionados por mim</a></li>
        <li><a href="#aba-2">Adicionados para mim</a></li>
    </ul>
    <div id="aba-1">
        <div class="caixa-de-ferramentas padding-padrao-vertical">
            <ul class="lista-horizontal">
                <li><a href="#" class="addArquivo           botao-padrao"><span class="ui-icon ui-icon-plus"  ></span>Adicionar Arquivo                  </a></li>
            </ul>
        </div>
        <div class="padding-padrao-vertical">

            <ul class="lista-arquivos">
                <?php
                // Faz a mesma ação para todos os arquivos encontrados
                foreach($Arquivos as $campos=>$valores)
                {
                    // Preenche o código do arquivo com 8 caracteres
                    $arquivo    = $obj->preencheZero("E", 8,$valores['Codigo']);
                    
                    // Preenche o código da categoria com 4 caracteres
                    $categoria  = $obj->preencheZero("E", 4, $valores['CodCategoria']);
                    
                    // Nome da extensão do arquivo
                    $extensao   = $valores['NomeExtensao'];
                    
                    // Gera o link do arquivo para abrir
                    $link    = CAMINHO_ARQUIVOS."CAT".$categoria."/".$arquivo;
                ?>
                <li>
                    <div class="padding-padrao-vertical celula conteudo-visivel">
                                              
                        <!-- Div com o nome e link do arquivo para download -->
                        <div class="coluna c03_tipo_a_01 margim-5px-horizontal">
                            <p class="negrito"><a href="?router=T0067/js.file&file=<?php echo $arquivo; ?>&categoria=<?php echo $categoria; ?>&extensao=<?php echo $extensao; ?>" target="_blank"><?php echo $valores['Nome'].".".$valores['NomeExtensao']; ?></a></p>
                        </div>
                        
                        <!-- Div com a descrição do arquivo -->
                        <div class="coluna c03_tipo_a_02 margim-5px-horizontal">
                            <p class="texto-alinhado-justificado"><?php echo $valores['Descricao']; ?></p>
                        </div>
                        
                        <!-- Div com o data de upload do arquivo -->
                        <div class="coluna c03_tipo_a_03 margim-5px-horizontal">
                            <p class="texto-alinhado-meio"><?php echo $valores['DataUp']; ?></p>
                        </div>
                        
                    </div>
                </li> 
                <?php
                }
                ?>
            </ul>                         
        </div>
    </div>

    <div id="aba-2">
        <div class="caixa-de-ferramentas padding-padrao-vertical">
            <ul class="lista-horizontal">
                <li><a href="#" class="marcarArquivos       botao-padrao"><span class="ui-icon ui-icon-check" ></span>Marcar\Desmarcar todos os Arquivos </a></li>
                <li><a href="#" class="excluirPermissao     botao-padrao"><span class="ui-icon ui-icon-trash" ></span>Excluir                            </a></li>
            </ul>
        </div>        
        <div class="padding-padrao-vertical">
            <ul class="lista-arquivos">
                <?php
                foreach($ArquivosPermissao as $campos=>$valores)
                {
                 
                    $arquivo    = $obj->preencheZero("E", 8,$valores['Codigo']);
                    $categoria  = $obj->preencheZero("E", 4, $valores['CodCategoria']);
                    $extensao   = $valores['NomeExtensao'];
                    $link    = CAMINHO_ARQUIVOS."CAT".$categoria."/".$arquivo;
                ?>
                <li>
                    <div class="padding-padrao-vertical celula conteudo-visivel">
                        
                        <!-- Div com o checkbox para seleção de arquivos -->
                        <div class="coluna c05_tipo_a_01 margim-5px-horizontal">
                            <input type="checkbox" value="<?php echo $valores['Codigo']; ?>" name="marcar[]" class="marcarArquivo"/>
                        </div>
                        
                        <!-- Div com o nome e link do arquivo para download -->
                        <div class="coluna c05_tipo_a_02 margim-5px-horizontal">
                            <p class="negrito"><a href="?router=T0067/js.file&file=<?php echo $arquivo; ?>&categoria=<?php echo $categoria; ?>&extensao=<?php echo $extensao; ?>" target="_blank"><?php echo $valores['Nome'].".".$valores['NomeExtensao']; ?></a></p>
                        </div>
                        
                        <!-- Div com a descrição do arquivo -->
                        <div class="coluna c05_tipo_a_03 margim-5px-horizontal">
                            <p class="texto-alinhado-justificado"><?php echo $valores['Descricao']; ?></p>
                        </div>
                        
                        <!-- Div com o data de upload do arquivo -->
                        <div class="coluna c05_tipo_a_04 margim-5px-horizontal">
                            <p class="texto-alinhado-meio"><?php echo $valores['DataUp']; ?></p>
                        </div>
                        
                        <!-- nome do usuário dono do arquivo -->
                        <div class="coluna c05_tipo_a_05 margim-5px-horizontal">
                            <p><?php echo $valores['NomeUsuario']; ?></p>
                        </div>
                    </div>
                </li> 
                <?php
                }
                ?>
            </ul>                         
        </div>        
    </div>              
</div>

