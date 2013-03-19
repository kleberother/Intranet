//Busca em tabelas dinamicamente
$(document).ready(function () {
        $("#id_search").quicksearch(".dados", {
                noResults: '#semresultado',
                stripeRows: ['odd', 'even'],
                loader: 'span.loading'
        });
});

$(function() {
        $( "button, input:submit, input:button, a", ".form-input" ).button();
        $( "a", ".form-input" ).click(function() {return false;});
        $( "button, input:submit, a", ".form-inpu-tab" ).button();
        $( "a", ".form-inpu-tab" ).click(function() {return false;});
        // Botões do Sistema   
        
        //ACCORDION PARA PAGINA UTILIDADES.PHP, MOSTRAR WIDGETS

	$(function() {
		$( "#cont-widg-conteudo" ).accordion({
			fillSpace: true
		});
	});

	$(function() {
		$( "#accordionResizer" ).resizable({
			minHeight: 200,
			resize: function() {
				$( "#cont-widg-conteudo" ).accordion( "resize" );
			}
		});
	});

        //CLASSE HOVER PARA BOTÃO DE AÇÃO
        $('.lista_acoes li').hover(
                function() {$(this).addClass('ui-state-hover');},
                function() {$(this).removeClass('ui-state-hover');}
        );
         


        //CLASSE PARA RADIO BUTTONS
        $( "#radio" ).buttonset();
        $( ".radio" ).buttonset();

        //CLASSES PARA CHECKBOX
        $( "#check" ).button();
        $( "#format" ).buttonset();

        //CLASSE PARA DATEPICKER
        $( "#dt_emissao" ).datepicker();
        $( "#dt_recebimento" ).datepicker();
        $( "#dt_vencto" ).datepicker();
        $( "#dt_inicial" ).datepicker();
        $( "#dt_final" ).datepicker();
        $( ".dt_inicial" ).datepicker();
        $( ".dt_final" ).datepicker();
        $( "#data" ).datepicker();
        $( ".data" ).datepicker();
        $( "#tabs" ).tabs();

    
        //Date picker para todos inputs com classe="data"
        //Date picker para todos inputs com classe="data"
        $('input.data').live('click', function() {
            $(this).datepicker({showOn:'focus'}).focus();
        });   
    
});


//DIVS ESCONDIDAS NA PÁGINA DE CRIAÇÃO DE AP
function alternarDocumento(tpDoc)
{
 var d1 = document.getElementById('pessoa_fisica');
 var d2 = document.getElementById('pessoa_juridica');
 if(tpDoc == 'CPF' )
 {
     d1.style.display = 'block';
     d2.style.display = 'none';
 }else
    {
         d2.style.display = 'block';
         d1.style.display = 'none';
    }
}

//divs escondidas na página de lançamento de ajustes

function alternarForm(tpDoc)
{
 var d1 = document.getElementById('avista');
 var d2 = document.getElementById('parcelado');
 if(tpDoc == 'avista' )
 {
     d1.style.display = 'block';
     d2.style.display = 'none';
 }else
    {
         d2.style.display = 'block';
         d1.style.display = 'none';
    }
}
         

/* ----======================== MASCARAS DE FORMULARIOS =========================------- */

jQuery(function($){
  $("#cnpj_for").mask("99.999.999/9999-99"); //CNPJ
  $("#cpf_for").mask("999.999.999-99");      //CPF
  $("#cpf").mask("999.999.999-99");          //CPF
  $("#cnpj").mask("99.999.999/9999-99");     //CNPJ
  $("#fone").mask("(99) 9999-9999");         //TELEFONE
  $("#rg").mask("99.999.999-9");             //RG
  $("#dt_emissao").mask("99/99/9999");       //DATA EMISSÃO
  $("#dt_recebimento").mask("99/99/9999");   //DATA EMISSÃO
  $("#periodo_ini").mask("99/99/9999");      //PERIODO INICIAL - FORMULARIO DE DESPESAS
  $("#periodo_fim").mask("99/99/9999");      //PERIODO FINAL   - FORMULARIO DE DESPESAS
  $(".hr_partida").mask("99:99");     //HORA PARTIDA
  $(".hr_chegada").mask("99:99");     //HORA CHEGADA
  $("#data").mask("99/99/9999");             //DATA   - FORMULARIO DE DESPESAS
  $("#dt_vencto").mask("99/99/9999");        //DATA VENCIMENTO
  $("#dt_inicial").mask("99/99/9999");       //DATA INICIAL
  $("#dt_final").mask("99/99/9999");         //DATA FINAL
  $(".dt_inicial").mask("99/99/9999");       //DATA INICIAL
  $(".dt_final").mask("99/99/9999");         //DATA FINAL
  $("#hr_inicial").mask("99:99:99");         //HORA INICIAL
  $("#hr_final").mask("99:99:99");           //HORA FINAL
  $("#mes_ano").mask("99/9999");             //Mes Ano

    //Mascara para Inputs classe="hora"
    $('input.hora').live('focus', function(){
        $(this).mask("99:99");             //Mascara para Campo de Horário
    });   

    //Mascara para Inputs classe="data"
    $('input.data').live('focus', function(){
        $(this).mask("99/99/9999");             //Mascara para Campo de Horário
    });   
    
    

//VALOR BRUTO
  $("#valor_bruto").priceFormat({
      prefix: 'R$ ',
      centsSeparator: ',',
      thousandsSeparator: '.'
  });

    //Mascara de Valores para Inputs classe="valor"
    $('input.valor').live("focus", function(event){
        event.preventDefault();
        $(this).priceFormat({
            prefix: '',
            centsSeparator: ',',
            thousandsSeparator: '.'
        }); 
    })
    
  //VALOR LIQUIDO
  $("#valor_liquido").priceFormat({
      prefix: 'R$ ',
      centsSeparator: ',',
      thousandsSeparator: '.'
  });
});

/* ----======================== CAIXAS DE DIALOGO ===============================------- */

//Excluir
function excluir(prog,pagina,tabela,campo,valor,campo2,valor2,tipo)
{
    document.prog   =   prog;
    document.pagina =   pagina;
    document.tabela =   tabela;
    document.campo  =   campo;
    document.valor  =   valor;
    document.valor2 =   valor2;
    document.campo2 =   campo2;
    document.tipo   =   tipo;

    $("#dialog:ui-dialog").dialog("destroy");
    $("#dialog-confirm").dialog
    ({
            resizable: false,
            height:140,
            modal: true,
            buttons:
            {
                    "Excluir": function()
                    {
                       location.href='?router='+document.prog+'/excluir&pagina='+document.pagina+'&tabela='+document.tabela+'&campo='+document.campo+'&valor='+document.valor+'&campo2='+document.campo2+'&valor2='+document.valor2+'&tipo='+document.tipo;
                    }
                    ,
                    Cancel: function()
                    {
                            $(this).dialog("close");
                    }
            }
    });
}

//Excluir
function excluirArray(prog,pagina,tabela,campo,valor,campo2,valor2,tipo)
{
    document.prog   =   prog;
    document.pagina =   pagina;
    document.tabela =   tabela;
    document.campo  =   campo;
    document.valor  =   valor;
    document.valor2 =   valor2;
    document.campo2 =   campo2;
    document.tipo   =   tipo;
    
    $("#dialog:ui-dialog").dialog("destroy");
    $("#dialog-confirm").dialog
    ({
            resizable: false,
            height:140,
            modal: true,
            buttons:
            {
                    "Excluir": function()
                    {
                       location.href='?router='+document.prog+'/excluir&pagina='+document.pagina+'&tabela='+document.tabela+'&campo='+document.campo+'&valor='+document.valor+'&campo2='+document.campo2+'&valor2='+document.valor2+'&tipo='+document.tipo;
                    }
                    ,
                    Cancel: function()
                    {
                            $(this).dialog("close");
                    }
            }
    });
}

// Fast Path

$(function(){
    $("#fastpath").focus(function(){
        $(this).val("");
    })
})

// Função para clonar objetos (TESTE)
$.fn.duplicate = function(count, cloneEvents) {
	var tmp = [];
	for ( var i = 0; i < count; i++ ) {
		$.merge( tmp, this.clone( cloneEvents ).get() );
	}
	return this.pushStack( tmp );
};

