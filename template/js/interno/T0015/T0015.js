//FUNÇÃO PARA BOTÃO (-) DELETAR LINHA
$(".removerLinha").live("click",function(){
    $(this).parents("tr").remove();    
});

//Grupos de Workflow
$(".grupos").live("focus", function(){
    var CodigoProcesso  =   $("#processo").val();
    var $this           =   $(this);
    //Limpa Combo antes de adicionar novos itens após o clique
    //$(this).find("option").remove();
    $this.append("<option value=''>Selecione...</option>");
    $.getJSON("?router=T0015/js.grupos", {CodigoProcesso:CodigoProcesso}, function(dados){
       $.each(dados, function(i,itm){               
           $this.append(itm);               
       }) 
    });  
});

$(".adicionaLinha").live("click", function () {
var Etapa       =   eval($(this).parents("tr").find(".etapa").val())+eval(1);
var ProxEtapa   =   $(this).parents("tr").find(".etapa").val();
var input   ='<tr>';
    input  +='   <td><input type="text" name="numEtapa[]" value="'+Etapa+'"                 class="etapa"   size="3"   readonly="true" /></td>';
    input  +='   <td>';
    input  +='       <select name="T059_codigo[]"                       class="grupos">';
    input  +='       </select>';
    input  +='   </td>';
    input  +='   <td><input type="text" name="T060_proxima_etapa[]"     class="proximaEtapa"    size="3"   maxlength="3" value="'+ProxEtapa+'"  /></td>'; 
    input  +='   <td><input type="text" name="T060_ordem[]"             class="ordem"           size="3"   maxlength="3"                    /></td>';
    input  +='   <td><input type="text" name="T060_num_dias[]"          class="numDias"         size="3"   maxlength="3"                    /></td>';
    input  +='   <td>';
    input  +='       <select class="obrigatorio" name="T060_obriga_aprovacao[]">';
    input  +='           <option value="S">Sim</option>';
    input  +='           <option value="N">Não</option>';
    input  +='       </select>';
    input  +='   </td>';
    input  +='   <td><input type="button" href="#" class="adicionaLinha" value="+"/><input type="button" href="#" class="removerLinha" value="-"/></td>';
    input  +='</tr>';

    $(".form-inpu-tab").find("tbody").append(input);
    
    $(this).parents("tr").find(".removerLinha").attr("style","display:none");
    
});
