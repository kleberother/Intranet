//js.busca dados do Fornecedor Banco RMS

//js.busca por CNPJ ((TAB CNPJ)

$(function(){
    $("#cnpj_for").bind("change",function(){
        $(".titulo2").focus();
        var cnpj    =   $("#cnpj_for").val();
        var tipo    =   1;
        $.getJSON("?router=T0012/js.busca&cnpj="+cnpj+"&tipo="+tipo, function(dados){
            $(".titulo").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#raz_social").val(item);
                }else if (i    ==  "COD"){
                    $("#rms_codigo").val(item);
                }
            })
        });
    });
});

//js.busca por Código (TAB CNPJ)

$(function(){
    $("#rms_codigo").live("change",function(){
        $(".titulo2").focus();
        var cod     =   $("#rms_codigo").val();
        var tipo    =   2;
        $.getJSON("?router=T0012/js.busca&cod="+cod+"&tipo="+tipo, function(dados){
            $(".titulo").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#raz_social").val(item);
                }else if (i    ==  "CGC"){
                    $("#cnpj_for").val(item);
                }
            })
        });
    });
});

//js.busca por CPF (TAB CPF)

$(function(){
    $("#cpf_for").bind("change",function(){
        $(".titulo2").focus();
        var cnpj    =   $("#cpf_for").val();
        var tipo    =   1;
        $.getJSON("?router=T0012/js.busca&cnpj="+cnpj+"&tipo="+tipo, function(dados){
            $(".titulo").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#cpf_raz_social").val(item);
                }else if (i    ==  "COD"){
                    $("#cpf_rms_codigo").val(item);
                }
            })
        });
    });
});

//js.busca por código (TAB CPF)

$(function(){
    $("#cpf_rms_codigo").live("change",function(){
        $(".titulo2").focus();
        var cod     =   $("#cpf_rms_codigo").val();
        var tipo    =   2;
        $.getJSON("?router=T0012/js.busca&cod="+cod+"&tipo="+tipo, function(dados){
            $(".titulo").focus();
            $.each(dados, function(i, item){
                if (i    ==  "RAZ"){
                    $("#cpf_raz_social").val(item);
                }else if (i    ==  "CGC"){
                    $("#cpf_for").val(item);
                }
            })
        });
    });
});


$(function(){
    $(".loja").live("focus",function(){
        var $this   =   $(this);
        var cont    =   $this.parents("tr").find(".numerador").val();
        if (cont != 20)
        {
            var cod     =   $("#rms_codigo").val();
            var titulo  =   $this.parents("tr").find(".titulo2").val();
            var serie   =   $this.parents("tr").find(".serie").val();
            var desd    =   $this.parents("tr").find(".desd").val();
            var tipo    =   3;
            $.getJSON("?router=T0012/js.busca&cod="+cod+"&titulo="+titulo+"&desd="+desd+"&serie="+serie+"&tipo="+tipo, function(dados){
                $.each(dados, function(i, item){
                    if (i   ==  "LOJ"){
                        $this.parents("tr").find(".loja").val(item);
                    }else if (i ==  "AGE"){
                        $this.parents("tr").find(".agenda").val(item);
                    }else if (i ==  "DSA"){
                        $this.parents("tr").find(".desc").val(item);
                    }else if (i ==  "DAG"){
                        $this.parents("tr").find(".dt_agenda").val(item);
                    }else if (i ==  "DVE"){
                        $this.parents("tr").find(".dt_vencto").val(item);
                    }else if (i ==  "BRT"){
                        $this.parents("tr").find(".bruto").val("R$ "+item);
                    }else if (i ==  "LIQ"){
                        $this.parents("tr").find(".liquido").val("R$ "+item);
                        var total = $("#total").val();
                        //Remove 'R$ '
                        total = total.substring(3);
                        total = parseFloat(total);
                        if(isNaN(total))
                        {
                            total = 0;
                        }
                        total += parseFloat(item);
                        $("#total").val("R$ "+total);
                    }
                })

            })
            //Numerador de linhas
            cont++;
            var input   =   '<tr>';
                input  +=   '<td><input type="text" name="titulo[]"    size="3"  maxlength="10"                             class="titulo2"     /></td>';
                input  +=   '<td><input type="text" name="serie[]"     size="1"  maxlength="4"                              class="serie"       /></td>';
                input  +=   '<td><input type="text" name="desd[]"      size="1"  maxlength="2"                              class="desd"        /></td>';
                input  +=   '<td><input type="text" name="loja[]"      size="1"  maxlength="2"                              class="loja"        /></td>';
                input  +=   '<td><input type="text" name="agenda[]"    size="4"  maxlength="3"                              class="agenda"      /></td>';
                input  +=   '<td><input type="text" name="desc[]"      size="35" maxlength="60"                             class="desc"        /></td>';
                input  +=   '<td><input type="text" name="dt_agenda[]" size="8"  maxlength="10" style="text-align: right;"  class="dt_agenda"   /></td>';
                input  +=   '<td><input type="text" name="dt_vencto[]" size="8"  maxlength="10" style="text-align: right;"  class="dt_vencto"   /></td>';
                input  +=   '<td><input type="text" name="bruto[]"     size="8"  maxlength="10" style="text-align: right;"  class="bruto"       /></td>';
                input  +=   '<td><input type="text" name="liquido[]"   size="8"  maxlength="10" style="text-align: right;"  class="liquido"     /></td>';
                input  +=   '<input type="hidden" name="numerador"     value='+(cont)+' class="numerador"/>';
                input  +=   '</tr>';
            $(".form-inpu-tab").find("tbody").append(input);
            $(".titulo2").focus();

            //Soma Liquido para campo Total
            
        }
        else
        {
            alert("acima de 20");
        }
    })
})