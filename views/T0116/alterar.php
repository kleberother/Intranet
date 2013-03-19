<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/02/2013 Rodrigo Alfieri    
 * Descrição: Nova RM
 * Entradas:   
 * Origens:   
           
**************************************************************************
*/

//Instancia Classe
$obj                =   new models_T0116();


$codAN  =   $_REQUEST["codAN"];

if (!empty($_POST))
{       
    
    $tabela =   "T114_areas_negocio";
    
    $usuarioPrincipal   =   $_POST['T004_principal']                                    ;
    $usuarioSuplente    =   $_POST['T004_suplente']                                     ;
    $descricao          =   $_POST['T114_descricao']                                    ;
    $nome               =   $_POST['T114_nome']                                         ;
    
    $campos =   array( 
                        "T004_principal"    =>  $usuarioPrincipal
                      , "T004_suplente"     =>  $usuarioSuplente
                      , "T114_descricao"    =>  $descricao
                      , "T114_nome"         =>  $nome
                     );
    
    $delim  =   "T114_codigo = ".$codAN;
    
    $altera     =   $obj->altera($tabela, $campos, $delim);
    
    if($altera)
        header('location:?router=T0116/home');  
    
   
}

$retornaArea    =    $obj->retornaAreas($codAN, $userPrincipal, $userSuplente);

foreach ($retornaArea as $campos => $valores) {
    
?>

<!-- Divs com a barra de ferramentas -->
<div class="div-primaria caixa-de-ferramentas padding-padrao-vertical">
    <ul class="lista-horizontal">
        <li><a href="?router=T0116/home" class="botao-padrao"><span class="ui-icon ui-icon-arrowthick-1-w"  ></span>Voltar  </a></li>
    </ul>
</div>

<div class="conteudo_16">
    
    <form action="" method="post" id="formCad">

        <div class="grid_4">
            <label class="label">Nome*</label>
            <input type="text" name="T114_nome"         class="validate[required]"  value="<?php echo $valores["NomeArea"];?>"          />            
        </div>
        
        <div class="grid_4">
            <label class="label">Colaborador Principal da Área*</label>
            <input type="text" name="T004_principal"    class="validate[required] buscaUsuario"   value="<?php echo $valores["PrincipalArea"];?>"       />  
        </div>

        <div class="grid_4">
            <label class="label">Colaborador Suplente da Área*</label>
            <input type="text" name="T004_suplente"    class="validate[required] buscaUsuario"  value="<?php echo $valores["SuplenteArea"];?>"      />            
        </div>
        
        <div class="clear"></div>

        <div class="grid_5">
            <label class="label">Descrição</label>
            <textarea name="T114_descricao"             class="textarea-table" cols="85" rows="3"    ><?php echo $valores["DescricaoArea"];?></textarea>            
        </div>
        
        <div class="clear"></div>
        

        
        <div class="clear"></div>

        <div class="grid_2">
            <input type="submit" value="Atualizar" class="botao-padrao" >
        </div>        
        
    </form>
<?php }?>
</div>





