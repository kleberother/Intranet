 $(function(){
     
    $(".transferirAP").live("click",function(event){
        
        event.preventDefault();           
        
        var $pagina =   "T0016/home",
            $prog   =   "T0016",
            $this   =   $(this),
            $valor  =   $this.parents("tr").find(".ap_codigo").html(),
            $linha  =   $this.parents("tr");
                        
        $("#dialog-transferir").dialog
        ({
                resizable: false,
                height:250,
                width:330,
                modal: true,
                buttons:
                {
                        "Transferir": function() 
                        {
                            $("#dialog-transferir").dialog("close");
                            // Captura o grupo selecionado
                            var grupo = $(".grupoWF").val();
                           
                            $("#dialog-tranferindo").dialog
                            ({
                                    resizable: false,
                                    height:60,
                                    modal: true,
                                    closeOnEscape: false,
                                    draggable:false,
                                    open: function() {                                         
                                                        $(".ui-dialog-titlebar-close").hide();                                                         
                                                        } 
                            })                           

                           $.get('?router='+$prog+'/js.transferir&pagina='+$pagina+'&valor='+$valor+'&grupo='+grupo, function(dados){
                               if(dados == 1)
                               {
                                    $("#dialog-tranferindo").dialog("close");                                
                                    $linha.remove();

                               }
                               else
                               {
                                    $("#dialog-tranferindo").dialog("close");
                               }
                           });

                        }
                        ,
                        Fechar: function()
                        {
                            $(this).dialog("close");
                        }
                }
        })
    })
});