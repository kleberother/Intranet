<?php
//Chama classes
$obj = new models_T0033();

// Verifica se o POST está vazio, caso não faz os inserts nas tabelas T077_departamento
if (!empty($_POST))
{
    // Tebela para inserir
    $tabela = "T077_departamento";
      
    // Monta primeiro array para inserção
    
  
    // Insere dados
    $insert = $obj->inserir($tabela, $_POST);
    
    // Verifica se o primeiro insert deu certo
    if ($insert)
    {    
        header('location:?router=T0033/home');            
    }
    else
    { // Erro ao inserir na tabela T077_departamento
        echo "<script>window.location='?router=T0033/home';</script>";   
    }
} 

$user  = $_SESSION['user'];

$FilDepartamento    =   $_POST['T077_pai'];

?>
<script type="text/javascript" src="template/js/interno/T0033/T0033.js"></script>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0033/home">Listar</a></li>
                <li><a href="?router=T0033/novo" class="active">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
        <label class="label">Nome*</label>
        <input type="text" name="T077_nome"  id="nome" class="validate[required,maxSize[20]] form-input-text" />
        <label class="label">Descrição</label>
        <textarea name="T077_desc" id="desc"></textarea> 
        <label class="label">Pai*</label>
        <select name="T077_pai" style="font-family: 'Lucida Sans Typewriter';font-size:11px;" class="validate[required]">
            <option value="">Selecione...</option>
            <option value="null">Sem Pai</option>
            <?php
            function verificaDeptos($CodigoPai, $FilDepartamento)
            {
                global $nivel; $nivel ++;
                $obj    =   new models_T0033();
                $DptosPai  =   $obj->retornaDepartamentosPai($CodigoPai);                                        
                foreach($DptosPai   as  $campos =>  $valores)
                {       
                    if (!empty($valores['PaiDpto']))
                        $Cascata .= str_repeat("&nbsp",($nivel*4)-4)   ;
                    else
                        $Cascata  = "" ;  // Raiz pai = NULL

                    if ($FilDepartamento == $valores['CodigoDpto'])
                        $selected   =   "selected"  ;
                    else
                        $selected   =   ""          ;

                    echo "<option value='".$valores['CodigoDpto']."'".$selected.">".$Cascata.$obj->preencheZero("E", 3, $valores['CodigoDpto'])."-".$valores['NomeDpto']."</option>";
                    $Cascata  = ""                  ;

                    verificaDeptos($valores['CodigoDpto'], $FilDepartamento);
                }
                $nivel --;
            }
            $CodigoPai      =   NULL    ;
            $Retorno    =   verificaDeptos($CodigoPai, $FilDepartamento);
            ?>
        </select>
        <div class="form-inpu-botoes">
            <input type="submit" value="Criar" />
        </div>
    </form>
    </span>
</div>

