//A ABA CONCORRENCIA INICIA BLOQUEADA, ELA VAI SER LIBERADA APÓS O USUÁRIO CLICAR E SALVAR A PRIMEIRA
//PARTE DA PESQUISA
$(function() {
    $('#tabs').tabs("disable", 1);
})

//-- FUNÇÕES DE CALCULOS DE MÉDIA E AGREGAR LINHA DINÂMICAMENTE -----------------------------------------//
 $(function(){

    //FUNÇÃO PARA BOTÃO IMPORTAR VALORES DA ULTIMA PESQUISA DE ACORDO COM A LOJA SELECIONADA
    $(".btn_importar").live("click",function(){

        var Tipo       =   3;
        var loja    =   $("#loja").val();
        if (loja != "")
        {
         $("#loja").removeClass("ui-state-error");
         $.getJSON("?router=T0022/js.busca&loja="+loja+"&Tipo="+Tipo, function(dados){
            if(dados != "1")
            {
            $.each(dados, function(i, item){
                if (i == "CustoGC")
                {
                 $("#custo_gc").val(item);
                }
                else if (i == "VendaGC")
                {
                 $("#venda_gc").val(item);
                }
                else if (i == "MargemGC")
                {
                 $("#margem_gc").val(item);
                }
                else if (i == "CustoGA")
                {
                 $("#custo_ga").val(item);
                }
                else if (i == "VendaGA")
                {
                 $("#venda_ga").val(item);
                }
                else if (i == "MargemGA")
                {
                 $("#margem_ga").val(item);
                }
                else if (i == "CustoEC")
                {
                 $("#custo_ec").val(item);
                }
                else if (i == "VendaEC")
                {
                 $("#venda_ec").val(item);
                }
                else if (i == "MargemEC")
                {
                 $("#margem_ec").val(item);
                }
                else if (i == "CustoEA")
                {
                 $("#custo_ea").val(item);
                }
                else if (i == "VendaEA")
                {
                 $("#venda_ea").val(item);
                }
                else if (i == "MargemEA")
                {
                 $("#margem_ea").val(item);
                }
                else if (i == "CustoDI")
                {
                 $("#custo_di").val(item);
                }
                else if (i == "VendaDI")
                {
                 $("#venda_di").val(item);
                }
                else if (i == "MargemDI")
                {
                 $("#margem_di").val(item);
                }
                else if (i == "CustoGN")
                {
                 $("#custo_gn").val(item);
                }
                else if (i == "VendaGN")
                {
                 $("#venda_gn").val(item);
                }
                else if (i == "MargemGN")
                {
                 $("#margem_gn").val(item);
                }
            })
            }
            else
            {
             alert("Não há nenhuma pesquisa para essa loja");
            }
         });
        }
        else
        {
         alert("Escolha uma loja antes de importar os dados.");
         $("#loja").addClass("ui-state-error");
         $("#loja").focus()
        }
    })

    //FUNÇÃO PARA CARREGAR SELECT BOX DE POSTOS REFERENTE A LOJA ESCOLHIDA NA PRIMEIRA FASE;
    $("#loja").live("change",function(){
        var loja       =   $("#loja").val();
        var Tipo       =   2;

        $.getJSON("?router=T0022/js.busca&loja="+loja+"&Tipo="+Tipo, function(dados){
           $('.posto').html(dados);
        });
    })

    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA GASOLINA COMUM INICIO -------------------------------
    $("#venda_gc").live("change",function(){
        var custo_gc    =   parseFloat($("#custo_gc").val());
        var venda_gc    =   parseFloat($("#venda_gc").val());
        //EXECUTA CALCULO
        var margem_gc = (((venda_gc - custo_gc)/venda_gc)*100);
        if (isNaN(margem_gc))
            margem_gc = 0;
        $("#margem_gc").val(margem_gc.toFixed(1));
    })

    $("#custo_gc").live("change",function(){
        var custo_gc    =   parseFloat($("#custo_gc").val());
        var venda_gc    =   parseFloat($("#venda_gc").val());
        //EXECUTA CALCULO
        var margem_gc = (((venda_gc - custo_gc)/venda_gc)*100);
        if (isNaN(margem_gc))
            margem_gc = 0;
        $("#margem_gc").val(margem_gc.toFixed(1));
    })
    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA GASOLINA COMUM FINAL --------------------------------

    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA GASOLINA ADITIVADA INICIO -------------------------------
    $("#venda_ga").live("change",function(){
        var custo_ga    =   parseFloat($("#custo_ga").val());
        var venda_ga    =   parseFloat($("#venda_ga").val());
        //EXECUTA CALCULO
        var margem_ga = (((venda_ga - custo_ga)/venda_ga)*100);
        if (isNaN(margem_ga))
            margem_ga = 0;
        $("#margem_ga").val(margem_ga.toFixed(1));
    })

    $("#custo_ga").live("change",function(){
        var custo_ga    =   parseFloat($("#custo_ga").val());
        var venda_ga    =   parseFloat($("#venda_ga").val());
        //EXECUTA CALCULO
        var margem_ga = (((venda_ga - custo_ga)/venda_ga)*100);
        if (isNaN(margem_ga))
            margem_ga = 0;
        $("#margem_ga").val(margem_ga.toFixed(1));
    })
    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA GASOLINA ADITIVADA FINAL --------------------------------

    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA ETANOL COMUM INICIO -------------------------------
    $("#venda_ec").live("change",function(){
        var custo_ec    =   parseFloat($("#custo_ec").val());
        var venda_ec    =   parseFloat($("#venda_ec").val());
        //EXECUTA CALCULO
        var margem_ec = (((venda_ec - custo_ec)/venda_ec)*100);
        if (isNaN(margem_ec))
            margem_ec = 0;
        $("#margem_ec").val(margem_ec.toFixed(1));
    })

    $("#custo_ec").live("change",function(){
        var custo_ec    =   parseFloat($("#custo_ec").val());
        var venda_ec    =   parseFloat($("#venda_ec").val());
        //EXECUTA CALCULO
        var margem_ec = (((venda_ec - custo_ec)/venda_ec)*100);
        if (isNaN(margem_ec))
            margem_ec = 0;
        $("#margem_ec").val(margem_ec.toFixed(1));
    })
    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA ETANOL COMUM FINAL --------------------------------

    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA ADITIVADO COMUM INICIO -------------------------------
    $("#venda_ea").live("change",function(){
        var custo_ea    =   parseFloat($("#custo_ea").val());
        var venda_ea    =   parseFloat($("#venda_ea").val());
        //EXeaUTA CALCULO
        var margem_ea = (((venda_ea - custo_ea)/venda_ea)*100);
        if (isNaN(margem_ea))
            margem_ea = 0;
        $("#margem_ea").val(margem_ea.toFixed(1));
    })

    $("#custo_ea").live("change",function(){
        var custo_ea    =   parseFloat($("#custo_ea").val());
        var venda_ea    =   parseFloat($("#venda_ea").val());
        //EXECUTA CALCULO
        var margem_ea = (((venda_ea - custo_ea)/venda_ea)*100);
        if (isNaN(margem_ea))
            margem_ea = 0;
        $("#margem_ea").val(margem_ea.toFixed(1));
    })
    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA ETANOL ADITIVADO FINAL --------------------------------

    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA DIESEL INICIO -------------------------------
    $("#venda_di").live("change",function(){
        var custo_di    =   parseFloat($("#custo_di").val());
        var venda_di    =   parseFloat($("#venda_di").val());
        //EXdiUTA CALCULO
        var margem_di = (((venda_di - custo_di)/venda_di)*100);
        if (isNaN(margem_di))
            margem_di = 0;
        $("#margem_di").val(margem_di.toFixed(1));
    })

    $("#custo_di").live("change",function(){
        var custo_di    =   parseFloat($("#custo_di").val());
        var venda_di    =   parseFloat($("#venda_di").val());
        //EXECUTA CALCULO
        var margem_di = (((venda_di - custo_di)/venda_di)*100);
        if (isNaN(margem_di))
            margem_di = 0;
        $("#margem_di").val(margem_di.toFixed(1));
    })
    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA DIESEL FINAL --------------------------------

    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA GNV INICIO -------------------------------
    $("#venda_gn").live("change",function(){
        var custo_gn    =   parseFloat($("#custo_gn").val());
        var venda_gn    =   parseFloat($("#venda_gn").val());
        //EXgnUTA CALCULO
        var margem_gn = (((eval(venda_gn) - eval(custo_gn))/eval(venda_gn))*100);
        if (isNaN(margem_gn))
            margem_gn = 0;
        $("#margem_gn").val(margem_gn.toFixed(1));
    })

    $("#custo_gn").live("change",function(){
        var custo_gn    =   parseFloat($("#custo_gn").val());
        var venda_gn    =   parseFloat($("#venda_gn").val());
        //EXECUTA CALCULO
        var margem_gn = (((venda_gn - custo_gn)/venda_gn)*100);
        if (isNaN(margem_gn))
            margem_gn = 0;
        $("#margem_gn").val(margem_gn.toFixed(1));
    })
    //FUNÇÃO PARA CALCULAR MARGEM DE LUCRO DA GNV FINAL --------------------------------
    
    //FUNÇÃO PARA INSERIR A PRIMEIRA PARTE DA PESQUISA, CARREGAR A PROXIMA ABA,
    //E LISTAR SOMENTE OS POSTOS REFERENTE AO POSTO ESCOLHIDO NA PRIMEIRA PARTE
    $(".btn_proximo").live("click",function(){

        var $this       =   $("#mestre");
        var PostoId     =   $this.find("#mest-quadrado-left").find("tbody").find("#loja").val();
        if (PostoId != "")
        {
         var Usuario     =   $this.find("#mest-quadrado-left").find("tbody").find("#usuario").val();
         var Data        =   $this.find("#mest-quadrado-left").find("tbody").find("#data").val();

         var CustoGC     =   $this.find("#mest-quadrado-right").find("tbody").find("#custo_gc").val();
         if (CustoGC == "")
             CustoGC = 0;
         var VendaGC     =   $this.find("#mest-quadrado-right").find("tbody").find("#venda_gc").val();
         if (VendaGC == "")
             VendaGC = 0;
         var MargemGC    =   $this.find("#mest-quadrado-right").find("tbody").find("#margem_gc").val();
         if (MargemGC == "")
             MargemGC = 0;

         var CustoGA     =   $this.find("#mest-quadrado-right").find("tbody").find("#custo_ga").val();
         if (CustoGA == "")
             CustoGA = 0;
         var VendaGA     =   $this.find("#mest-quadrado-right").find("tbody").find("#venda_ga").val();
         if (VendaGA == "")
             VendaGA = 0;
         var MargemGA    =   $this.find("#mest-quadrado-right").find("tbody").find("#margem_ga").val();
         if (MargemGA == "")
             MargemGA = 0;

         var CustoEC     =   $this.find("#mest-quadrado-right").find("tbody").find("#custo_ec").val();
         if (CustoEC == "")
             CustoEC = 0;
         var VendaEC     =   $this.find("#mest-quadrado-right").find("tbody").find("#venda_ec").val();
         if (VendaEC == "")
             VendaEC = 0;
         var MargemEC    =   $this.find("#mest-quadrado-right").find("tbody").find("#margem_ec").val();
         if (MargemEC == "")
             MargemEC = 0;

         var CustoEA     =   $this.find("#mest-quadrado-right").find("tbody").find("#custo_ea").val();
         if (CustoEA == "")
             CustoEA = 0;
         var VendaEA     =   $this.find("#mest-quadrado-right").find("tbody").find("#venda_ea").val();
         if (VendaEA == "")
             VendaEA = 0;
         var MargemEA    =   $this.find("#mest-quadrado-right").find("tbody").find("#margem_ea").val();
         if (MargemEA == "")
             MargemEA = 0;

         var CustoDI     =   $this.find("#mest-quadrado-right").find("tbody").find("#custo_di").val();
         if (CustoDI == "")
             CustoDI = 0;
         var VendaDI     =   $this.find("#mest-quadrado-right").find("tbody").find("#venda_di").val();
         if (VendaDI == "")
             VendaDI = 0;
         var MargemDI    =   $this.find("#mest-quadrado-right").find("tbody").find("#margem_di").val();
         if (MargemDI == "")
             MargemDI = 0;

         var CustoGN     =   $this.find("#mest-quadrado-right").find("tbody").find("#custo_gn").val();
         if (CustoGN == "")
             CustoGN = 0;

         var VendaGN     =   $this.find("#mest-quadrado-right").find("tbody").find("#venda_gn").val();
         if (VendaGN == "")
             VendaGN = 0;
         
         var MargemGN    =   $this.find("#mest-quadrado-right").find("tbody").find("#margem_gn").val();
         if (MargemGN == "")
             MargemGN = 0;

         var Tipo        =   1;

         $.get("?router=T0022/js.insere&PostoId="+PostoId+"&Usuario="+Usuario+"&Data="+Data+"&CustoGC="+CustoGC+"&VendaGC="+VendaGC+"&MargemGC="+MargemGC+"&CustoGA="+CustoGA+"&VendaGA="+VendaGA+"&MargemGA="+MargemGA+"&CustoEC="+CustoEC+"&VendaEC="+VendaEC+"&MargemEC="+MargemEC+"&CustoEA="+CustoEA+"&VendaEA="+VendaEA+"&MargemEA="+MargemEA+"&CustoDI="+CustoDI+"&VendaDI="+VendaDI+"&MargemDI="+MargemDI+"&CustoGN="+CustoGN+"&VendaGN="+VendaGN+"&MargemGN="+MargemGN+"&Tipo="+Tipo, function(dados){
           $('.pesquisa').val(dados);
         });

         // ABA DE CONCORRÊNCIA SERÁ LIBERADA E SELECIONADA AUTOMATICAMENTE PARA O USUÁRIO
         // E A PRIMEIRA ABA FICARA DESATIVADA
         $('#tabs').tabs("enable", 1);
         $('#tabs').tabs({selected: 1});
         //$('#tabs').tabs("disable", 0);

         //BLOQUEIA INPUTS DA PRIMEIRA ABA
         $(".btn_proximo").attr("disabled","disabled");
         $("#data").attr("disabled","disabled");
         $("#usuario").attr("disabled","disabled");
         $("#loja").attr("disabled","disabled");

         $("#custo_gc").attr("disabled","disabled");
         $("#custo_ga").attr("disabled","disabled");
         $("#custo_ec").attr("disabled","disabled");
         $("#custo_ea").attr("disabled","disabled");
         $("#custo_di").attr("disabled","disabled");
         $("#custo_gn").attr("disabled","disabled");

         $("#venda_gc").attr("disabled","disabled");
         $("#venda_ga").attr("disabled","disabled");
         $("#venda_ec").attr("disabled","disabled");
         $("#venda_ea").attr("disabled","disabled");
         $("#venda_di").attr("disabled","disabled");
         $("#venda_gn").attr("disabled","disabled");

         $("#margem_gc").attr("disabled","disabled");
         $("#margem_ga").attr("disabled","disabled");
         $("#margem_ec").attr("disabled","disabled");
         $("#margem_ea").attr("disabled","disabled");
         $("#margem_di").attr("disabled","disabled");
         $("#margem_gn").attr("disabled","disabled");
        }
        else
        {
         alert("Escolha uma loja antes de continuar com a pesquisa.");
         $this.find("#mest-quadrado-left").find("tbody").find("#loja").addClass("ui-state-error");
         $this.find("#mest-quadrado-left").find("tbody").find("#loja").focus()
        }

    });

    //FUNÇÃO PARA CALCULAR MÉDIA
    $(".btn_calc").live("click",function(){
        var $this   =   $(".tab_row").find("tbody");
        //VARIAVEL GASOLINA COMUM
        var gc      =   $this.find("tr").find(".gc").average();
        $("#media_gc").val(gc);
        
        //VARIAVEL GASOLINA ADITIVADA
        var ga      =   $this.find("tr").find(".ga").average();
        $("#media_ga").val(ga);
        
        //VARIAVEL ETANOL COMUM
        var ec      =   $this.find("tr").find(".ec").average();
        $("#media_ec").val(ec);

        //VARIAVEL ETANOL ADITIVADO
        var ea      =   $this.find("tr").find(".ea").average();
        $("#media_ea").val(ea);
        
        //VARIAVEL DIESEL
        var di      =   $this.find("tr").find(".di").average();
        $("#media_di").val(di);
        
        //VARIAVEL GAS NATURAL VEICULAR
        var gn      =   $this.find("tr").find(".gn").average();
        $("#media_gn").val(gn);
        
        //VARIAVEL DE DIVISOR
        //var divisor =   $this.find("tr").find("td").find(".contador").val();
    });

    
    //FUNÇÃO PARA BOTÃO (-) DELETAR LINHA
    $(".btn_del").live("click",function(){
        var $this   =   $(this);
        var ItemId  =   $this.parents("tr").find(".ItemId").val();

        $.get("?router=T0022/js.exclui&ItemId="+ItemId, function(dados){
            $this.parents("tr").remove();
        });
        
        //SUBTRAI DO CONTADOR (CONTADOR) - 1
        //var cont = parseInt($(".tab_row").find("tbody").find("tr").find("td").find(".contador").val()) - 1;
        //INSERE O VALOR SUBTRAIDO NO VALUE NOVAMENTE
        //$(".tab_row").find("tbody").find("tr").find("td").find(".contador").val(cont);           
    });

    //EXECUTA ESSA FUNÇÃO QUANDO CLICAR NO BOTÃO (+)
    $(".btn_add").live("click", function () {

        //ATRIBUI O THIS A FUNÇÃO, CLASSE TAB_ROW, TBODY
        var $this   =   $(".tab_row").find("tbody");
        var Tipo    =   2;
        
        //INSERE CONTEUDO DA LINHA NA TABELA T073
        //CAPTURA VALORES DOS INPUTS
        var PesquisaId =   $this.find(".pesquisa").val();
        var PostoId    =   $this.find("tr:last").find(".posto").val();
        var ValGC      =   $this.find("tr:last").find(".gc").val();
        var ValGA      =   $this.find("tr:last").find(".ga").val();
        var ValEC      =   $this.find("tr:last").find(".ec").val();
        var ValEA      =   $this.find("tr:last").find(".ea").val();
        var ValDI      =   $this.find("tr:last").find(".di").val();
        var ValGN      =   $this.find("tr:last").find(".gn").val();
        
        //PASSA NA URL OS PARAMETROS E ABRE O PHP PARA INSERIR NO BANCO
        $.get("?router=T0022/js.insere&PesquisaId="+PesquisaId+"&PostoId="+PostoId+"&ValGC="+ValGC+"&ValGA="+ValGA+"&ValEC="+ValEC+"&ValEA="+ValEA+"&ValDI="+ValDI+"&ValGN="+ValGN+"&Tipo="+Tipo, function(dados){
            $this.find("tr:last").find(".ItemId").val(dados);

            var input   =   '<tr class="mest-quad-list-tabl-tr-input">';
                input  +=   '<input type="hidden" name="ItemId[]"        class="ItemId"  />';
                input  +=   '<td>';
                input  +=   '<select  name="posto[]" class="posto" style="width: 450px;">';
                //input  +=   '<option value="" selected>Selecione</option>';
                input  +=   '</select>';
                input  +=   '</td>';
                input  +=   '<td><input type="text" name="gc[]"         class="gc"         size="1"  /></td>';
                input  +=   '<td><input type="text" name="ga[]"         class="ga"         size="1"  /></td>';
                input  +=   '<td><input type="text" name="ec[]"         class="ec"         size="1"  /></td>';
                input  +=   '<td><input type="text" name="ea[]"         class="ea"         size="1"  /></td>';
                input  +=   '<td><input type="text" name="di[]"         class="di"         size="1"  /></td>';
                input  +=   '<td><input type="text" name="gn[]"         class="gn"         size="1"  /></td>';
                input  +=   '<td><span class="lista_acoes"><ul><li class="ui-state-default ui-corner-all" title="Deletar"   ><a class="ui-icon ui-icon-minus btn_del"></a></li></ul></span></td>';
                input  +=   '</tr>';
                $this.append(input);

            var loja    =   $("#mestre").find("#mest-quadrado-left").find("tbody").find("#loja").val();

            $.getJSON("?router=T0022/js.busca&loja="+loja+"&Tipo="+Tipo, function(dados){
               $this.find("tr:last").find("td").find(".posto").html(dados);
            });
        });

        //BLOQUEIA INPUTS
        $(".posto").attr("disabled","disabled");
        $(".gc").attr("readonly","readonly");
        $(".ga").attr("readonly","readonly");
        $(".ec").attr("readonly","readonly");
        $(".ea").attr("readonly","readonly");
        $(".di").attr("readonly","readonly");
        $(".gn").attr("readonly","readonly");
        //CONTADOR
        //var cont    =   parseFloat($this.find("tr").find("td").find(".contador").val());//
        //cont++;
        //$this.find("tr").find("td").find(".contador").val(cont);
        
    });

//    $(".btn_finalizar").live("click",function(){
//        window.location="http://10.2.1.141/?router=T0022/home";
//    });

    //Cancelar Coleta
    $(".btn_finalizar").live("click",function(){
        $("#dialog-finalizar").dialog({
                resizable: false,
                height:200,
                modal: true,
                buttons:
                {
                        "Sim": function()
                        {
                            location.href='?router=T0022/home';
                        }
                        ,
                        Não: function()
                        {
                            $(this).dialog("close");
                        }
                }
        })
    })
 })

//-- MÁSCARAS PARA INPUT --------------------------------------------------------------------------------//
jQuery(function($){

  //CNPJ
//   $(".cnpj").live("focus",function(){
//      $(".cnpj").mask("99.999.999/9999-99");
//   });
   
  //CUSTO E VENDA GASOLINA COMUM
  $("#custo_gc").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

  $("#venda_gc").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });


   $(".gc").live("focus",function(){
          $(".gc").priceFormat({
          prefix: '',
          centsSeparator: '.',
          //thousandsSeparator: '.',
          limit: 4,
          centsLimit: 3
      });
  })

  //CUSTO E VENDA GASOLINA ADITIVADA
  $("#custo_ga").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

  $("#venda_ga").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

   $(".ga").live("focus",function(){
          $(".ga").priceFormat({
          prefix: '',
          centsSeparator: '.',
          //thousandsSeparator: '.',
          limit: 4,
          centsLimit: 3
      });
  })

  //CUSTO E VENDA ETANOL COMUM
  $("#custo_ec").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

  $("#venda_ec").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

   $(".ec").live("focus",function(){
          $(".ec").priceFormat({
          prefix: '',
          centsSeparator: '.',
          //thousandsSeparator: '.',
          limit: 4,
          centsLimit: 3
      });
  })

  //CUSTO E VENDA ETANOL ADITIVADO
  $("#custo_ea").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

  $("#venda_ea").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

   $(".ea").live("focus",function(){
          $(".ea").priceFormat({
          prefix: '',
          centsSeparator: '.',
          //thousandsSeparator: '.',
          limit: 4,
          centsLimit: 3
      });
  })

  //CUSTO E VENDA DIESEL
  $("#custo_di").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

  $("#venda_di").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

   $(".di").live("focus",function(){
          $(".di").priceFormat({
          prefix: '',
          centsSeparator: '.',
          //thousandsSeparator: '.',
          limit: 4,
          centsLimit: 3
      });
  })

  //CUSTO E VENDA GNV
  $("#custo_gn").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

  $("#venda_gn").priceFormat({
      prefix: '',
      centsSeparator: '.',
      //thousandsSeparator: '.',
      limit: 4,
      centsLimit: 3
  });

   $(".gn").live("focus",function(){
          $(".gn").priceFormat({
          prefix: '',
          centsSeparator: '.',
          //thousandsSeparator: '.',
          limit: 4,
          centsLimit: 3
      });
  })

});
