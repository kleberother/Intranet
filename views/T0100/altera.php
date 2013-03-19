<?php
//Chama classes
$codigoMeta =       $_REQUEST['codigoMeta'] ;
$tabela     =       "T100_meta_ge"          ;


//Classe para Alterar usuario
$obj        =    new models_T0100();
$meta       =   $obj->retornaMetas($codigoMeta);    

//Combo Loja
$loja           =  $obj->retornaLoja(); 


if(!empty($_POST))
{
    $delim         =        "T100_codigo = ".$codigoMeta;
    $obj->alterar($tabela,$_POST,$delim);
    
    header('location:?router=T0100/home');
}

$user   =   $_SESSION['user'];

?>
<div id="ferramenta">
    <div id="ferr-conteudo">
        <span class="ferr-cont-menu">
            <ul>
                <li class="selecione">Selecione</li>
                <li><a href="?router=T0100/home">Listar</a></li>
                <li><a href="?router=T0100/novo">Novo</a></li>
            </ul>
        </span>
    </div>
</div>
<div id="formulario">
    <?php foreach($meta as $campos=>$valores){?>
    <span class="form-titulo">
        <p>Os campos com asterisco (*) são obrigatórios o preechimento</p>
    </span>
    <span class="form-input">
    <form action="" method="post" id="formCad">
         <label class="label">Loja*</label>
        
        <select name="T006_codigo"  id="pai" disabled>
            <option value="">Selecione..</option>
        <?php foreach($loja as $campos=>$vls){?>
            <option value="<?php echo $vls['LojaCodigo']?>" <?php echo $vls['LojaCodigo']==$valores['CodigoLoja']?"selected":"";?>><?php echo $obj->preencheZero("E", 3, $vls['LojaCodigo'])."-".$vls['LojaNome']?></option>
        <?php }?>
        </select>
        
        <label class="label">Mês referência</label>
        <input type="text"      name="T100_mes"          id="nome"   class="data"                  value="<?php echo $valores['MesMeta'];?>" disabled/>
        
        <label class="label">Quantidade Meta</label>
        <input type="text"      name="T100_quantidade"   id="titulo" class=""       value="<?php echo $valores['QtdeMeta'];?>" />
        
        <label class="label">Valor Meta*</label>
        <input type="text"      name="T100_meta"         id="nome"   class="valor" value="<?php echo $valores['ValorMeta'];?>" />
        
        <input type="hidden"    name="T004_login"   value="<?php echo $user;?>"                    />
        
        </div>
        <div class="form-inpu-botoes">
            <input type="submit" value="Alterar" />
        </div>
    </form>
    </span>
<?php } ?>
</div>

