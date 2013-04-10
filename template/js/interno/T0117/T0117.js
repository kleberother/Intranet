/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 14/02/2013 Rodrigo Alfieri
           
***************************************************************************/
$(function(){    
    
    $("#btnAddExeInt").click(function(){
        var user    =    $("#txtExeInt").val().split('- ');
        var codRM   =    $("#codRM").val();
        $('#cmbExeInt').append('<option value="'+user[1]+'" selected="selected">'+$("#txtExeInt").val()+'</option>');
        
        $("#txtExeInt").val("");
        $("#txtExeInt").focus();
        
         $.post("?router=T0117/js.IncluirExec", {login:user[1], cod:1, codRM:codRM})
         
         
        
    });
    
    $("#btnAddExeExt").click(function(){
        
        var nome        =   $("#txtNomeExt").val();
        var telefone    =   $("#txtFoneExt").val();
        var notificado  =   $("input:checked").val();
        var email       =   $("#txtEmailExt").val();
        var codRM       =   $("#codRM").val();
        
        var str         =   nome+"|"+telefone+"|"+email+"|"+notificado;

        $('#cmbExeExt').append('<option value="'+str+'" selected="selected">'+str+'</option>');
        
        $("#txtNomeExt").val("");
        $("#txtFoneExt").val("");
        $("#txtEmailExt").val(""); 
        $("#txtNomeExt").focus();
        
        $.post("?router=T0117/js.IncluirExec", {nome:nome, tel:telefone, notif:notificado, email:email, cod:3, codRM:codRM});
        
    });
    
    
    $("#btnAddComite").click(function(){
        
        var user        =   $("#txtComite").val().split('- ');
        var nome        =   $("#txtComite").val();
        var aprovado    =   $("input[name=T113_aprovado]:checked").val();
        var parecer     =   $("#txtJustComite").val();
        var codRM       =   $("#codRM").val();
        
        var str         =   nome+" | "+aprovado+" | "+parecer;

        $('#cmbComite').append('<option value="'+str+'" selected="selected">'+str+'</option>');
        
        $("#txtJustComite").val("");
        $("#txtComite").focus();
        
      $.post("?router=T0117/js.IncluirExec", {login:user[1], aprovar:aprovado,  parecer:parecer, cod:4, codRM:codRM, });
        
    });
    
        
   
    
    $("#btnAddCont").click(function(){
        var user    =    $("#txtExeCont").val().split('- ');
        var codRM   =    $("#codRM").val();
        $('#cmbExeCont').append('<option value="'+user[1]+'" selected="selected">'+$("#txtExeCont").val()+'</option>');
        $("#txtExeCont").val("");
        $("#txtExeCont").focus();
       
        $.post("?router=T0117/js.IncluirExec", {login:user[1], cod:2, codRM:codRM});
        
    });     
    
    
     $("#cmbExeExt").click(function(){
       var str      =   $(this).val();
       var dado     =   $("#cmbExeExt option[value='"+str+"']").val().split('|');
       var codRM    =   $("#codRM").val();
       
       
        $("#dialog-mensagem").html("<p style='padding-top:10px;'>Essa ação Excluirá o Executor Externo <br><br>"+str+" <br><br> Tem certeza que deseja fazer isso ?</p>");
        $("#dialog-mensagem").dialog
        ({
            resizable: false,
            height:180,
            width:250,
            modal: true,
            draggable: false,
            title:  "Mensagem",
            buttons:
            {
                    "Ok": function(){
                        
                           $("#cmbExeExt option[value='"+str+"']").remove();
        
                            alert("Executor Externo: "+str+" removido!");
        
                            $.post("?router=T0117/js.ExcluirExec", {nome:dado[0], tel:dado[1], email:dado[2], notif:dado[3], cod:3, codRM:codRM});
                        $(this).dialog("close");
                
            } 
                    ,
                    Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        });  
  
       
    
        
    });
    
    
        $("#cmbExeCont").click(function(){
       var str      =   $(this).val();
       var codRM    =   $("#codRM").val();
       
       
       $("#dialog-mensagem").html("<p style='padding-top:10px;'>Essa ação Excluirá o Executor Contingência <br><br>"+str+" <br><br> Tem certeza que deseja fazer isso ?</p>");
        $("#dialog-mensagem").dialog
        ({
            resizable: false,
            height:180,
            width:250,
            modal: true,
            draggable: false,
            title:  "Mensagem",
            buttons:
            {
                    "Ok": function(){
                        
                              $("#cmbExeCont option[value='"+str+"']").remove();
        
                            $.post("?router=T0117/js.ExcluirExec", {login:str[0], cod:2, codRM:codRM})
                            $(this).dialog("close");
                
            } 
                    ,
                    Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        });  
  
    });
    
      $("#cmbExeInt").click(function(){
       var str      =   $(this).val();
       var codRM    =   $("#codRM").val();
  
  
   $("#dialog-mensagem").html("<p style='padding-top:10px;'>Essa ação Excluirá o Executor Interno <br><br>"+str+" <br><br> Tem certeza que deseja fazer isso ?</p>");
        $("#dialog-mensagem").dialog
        ({
            resizable: false,
            height:180,
            width:250,
            modal: true,
            draggable: false,
            title:  "Mensagem",
            buttons:
            {
                    "Ok": function(){
                        
                           $("#cmbExeInt option[value='"+str+"']").remove();
        
                             alert("Executor Interno: "+str+" removido!");
        
                            $.post("?router=T0117/js.ExcluirExec", {login:str[0], cod:1, codRM:codRM})
                            $(this).dialog("close");
                
            } 
                    ,
                    Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        });  
       
     });
     
     
      $("#cmbComite").click(function(){
       var str      =   $(this).val();
       var codRM    =   $("#codRM").val();
  
  
   $("#dialog-mensagem").html("<p style='padding-top:10px;'>Essa ação Excluirá o Integrante do Comitê <br><br>"+str+" <br><br> Tem certeza que deseja fazer isso ?</p>");
        $("#dialog-mensagem").dialog
        ({
            resizable: false,
            height:180,
            width:250,
            modal: true,
            draggable: false,
            title:  "Mensagem",
            buttons:
            {
                    "Ok": function(){
                        
                           $("#cmbComite option[value='"+str+"']").remove();
        
                            $.post("?router=T0117/js.ExcluirExec", {login:str[0], cod:4, codRM:codRM})
                            $(this).dialog("close");
                
            } 
                    ,
                    Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        });  
       
     });
     
     $("#dateCmp2").datepicker({
        onClose: function(){
         var data1  = $("#dateCmp1").val();
         var data2  = $("#dateCmp2").val();
         
         if (data1 > data2){
             alert("Data inicial maior que data final!");
             $("#dateCmp1").val("");
             $("#dateCmp2").val("");
         }
         
        }
     });
     
     $("#dateCmp1").datepicker({
        onClose: function(){
            
            var data1   =   $("#dateCmp1").val();
            var dataHoje = $("#dataHoje").val();
            
            if(data1 < dataHoje){
                
                alert("Data Inicial menor que data atual!");
                $("#dateCmp1").val("");
            }
        } 
     });
     
     $(".rmCmp").mask("999.999");
     
     $("#radioC").buttonset();
     $("#revisado").button();

       
 $("#hr_fim").change(function(){
         
         MIN = 1000 * 60 
         DAY = 1000 * 60 * 60  
         
         var dataIni    =   $("#dateCmp1").val()+" "+$("#hr_ini").val();
         var dataFim    =   $("#dateCmp2").val()+" "+$("#hr_fim").val();
         
        var nova1 = dataIni.toString().split('/');
        Nova1 = nova1[1]+"/"+nova1[0]+"/"+nova1[2];

        var nova2 = dataFim.toString().split('/');
        Nova2 = nova2[1]+"/"+nova2[0]+"/"+nova2[2];
        
        d1 = new Date(Nova1)
        d2 = new Date(Nova2)

        mins_passed = ((d2.getTime() - d1.getTime()) / MIN)
        days_passed = ((d2.getTime() - d1.getTime()) / DAY)  
         
       // var tempoTotal  =   ((horaFim[0]) - (horaIni[0]));       
        
       $("#tempoTotal").val(mins_passed+" Min");
       $("#horasTotal").val(days_passed+" Hrs");
         
     });
     
     
     $("#tempoPrev").focusout(function(){
         
        var min = $("#tempoPrev").val();
        
        var horas = parseFloat(min/60);
        
        $("#horaPrev").val(horas.toFixed(2)+" Hrs");
     
     });
     
       $("#tempoDisp").focusout(function(){
         
        var min = $("#tempoDisp").val();
        
        var horas = parseFloat(min/60);
        
        $("#horaDisp").val(horas.toFixed(2)+" Hrs");
     
     });
     
     $(".revisar").click(function(){
         
         var status    =   3;
         var codRM    =   $("#codRM").val();
     
        $.post("?router=T0117/js.alteraStatus", {status:status, codRM:codRM});
        
        $.post("?router=T0117/js.EnviaEmailComite", {codRM:codRM});
       
         location.reload();
     });
     
         $(".concluir").click(function(){
         
         var status    =   2;
         var codRM    =   $("#codRM").val();
     
        $.post("?router=T0117/js.alteraStatus", {status:status, codRM:codRM});
        location.reload();
        
     });
     
     
     
});



    function excluirLinha(cod){
        
   $.get("?router=T0117/js.excluir", {codRM:cod},
    function(){
       $(".linha_"+cod).remove(); 
    });
}


    
