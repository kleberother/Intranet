 //Programa P0015 combo Processo
 $(function(){
 
    //FUNÇÃO PARA BOTÃO (-) DELETAR LINHA
    $(".P0015_btn_del").live("click",function(){
        $(this).parents("tr").remove();
    });

    //TRAZ TODO O CONTEÚDO DO LIST BOX DE PROCESSOS
    $(".P0015_cmb_processo").live("focus", function(){
        var obj = $(this).parents("tr").find(".P0015_cmb_processo");
        $.post( "?router=T0015/js.processo", function(dados){
            obj.html(dados);
        });
    })

    //TRAZ TODO O CONTEÚDO DO LIST BOX DE GRUPOS
    $(".P0015_cmb_grupo").live("focus", function(){
        var processo    =   $(this).parents("tr").find(".P0015_cmb_processo").val();
        var obj         =   $(this).parents("tr").find(".P0015_cmb_grupo");
        $.post( "?router=T0015/js.grupo",{processo:processo},function(dados){
            obj.html(dados);
        });
    })

    //Vai executar essa função quando clicar em (+)
    $(".P0015_btn_add").live("click", function () {
        var obj     =   $(this);
        var tipo    =   1;
        var processo=   $(this).parents("tr").find(".P0015_cmb_processo").val();
        var grupo   =   $(this).parents("tr").find(".P0015_cmb_grupo").val();
        var proxetp =   $(this).parents("tr").find(".T060_proxima_etapa").val();
        var ordem   =   $(this).parents("tr").find(".T060_ordem").val();
        var ndias   =   $(this).parents("tr").find(".T060_num_dias").val();
        var obg     =   $(this).parents("tr").find(".T060_obriga_aprovacao").val();
        
        //Envia o que foi caputurado em uma linha e insere no banco de dados
        $.post("?router=T0015/js.grupo"    ,{  T061_codigo:processo
                                        ,   T059_codigo:grupo
                                        ,   T060_proxima_etapa:proxetp
                                        ,   T060_ordem:ordem
                                        ,   T060_num_dias:ndias
                                        ,   T060_obriga_aprovacao:obg
                                        ,   tipo:tipo
                                        },  function(dados){
                                                obj.parents("tr").find(".T060_codigo").val(dados);
                                        })

        var input   =   '<tr>';
            input  +=   '<td><input type="text"      name="T060_codigo"      class="T060_codigo"      size="1"  maxlength="2" disabled="disabled"/></td>';
            input  +=   '<td>';
            input  +=   '<select name="T061_codigo[]" class="P0015_cmb_processo">';
            input  +=   '<option value="0">Selecione...</option>';
            input  +=   '</select>';
            input  +=   '</td>';
            input  +=   '<td>';
            input  +=   '<select name="T059_codigo[]" class="P0015_cmb_grupo">';
            input  +=   '<option value="0">Selecione...</option>';
            input  +=   '</select>';
            input  +=   '</td>';
            input  +=   '<td><input type="text"      name="T060_proxima_etapa[]"      class="T060_proxima_etapa"      size="1"  maxlength="3"   /></td>';
            input  +=   '<td><input type="text"      name="T060_ordem[]"              class="T060_ordem"              size="1"  maxlength="2"   /></td>';
            input  +=   '<td><input type="text"      name="T060_num_dias[]"           class="T060_num_dias"           size="4"  maxlength="3"   /></td>';
            input  +=   '<td>';
            input  +=   '<select name="T060_obriga_aprovacao[]">';
            input  +=   '<option value="s">Sim</option>';
            input  +=   '<option value="n">Não</option>';
            input  +=   '</select>';
            input  +=   '</td>';
            input  +=   '<td><input type="button"    value="+"                        class="P0015_btn_add"                     size="8"  maxlength="10" style="text-align: right;"  /></td>';
            input  +=   '<td><input type="button"    value="-"                        class="P0015_btn_del"                     size="8"  maxlength="10" style="text-align: right;"  /></td>';
            input  +=   '</tr>';

            $(".form-inpu-tab").find("tbody").append(input);
    });
 })
