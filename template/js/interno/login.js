$(function() {
    
        $("#logout").live("click",function(){
            var action  =   "logout";
            var evento  =   1;  
            
            $.get("?router=home/js.usuario", {action:action, evento:evento}, function(){
                location.reload();
            }) 
            
        })
        
        $( "#dialog:ui-dialog" ).dialog( "destroy" );

            var name            = $( "#name" )          ,
                password        = $( "#password" )      ,
                nome            = $( "#nome" )          ,
                nome_display    = $( "#nome_display" )  ,
                matricula       = $( "#matricula" )     ,
                funcao          = $( "#funcao" )        ,
                departamento    = $( "#departamento" )  ,
                ramal           = $( "#ramal" )         ,
                celular         = $( "#celular" )       ,
                loja            = $( "#loja" )          ,
                allFields       = $( [] ).add( name )
                                         .add( password )
                                         .add( nome )
                                         .add( nome_display )
                                         .add( matricula )
                                         .add( funcao )
                                         .add( departamento )
                                         .add( ramal )
                                         .add( celular )
                                         .add( loja )   ,
                tips            = $( ".validateTips" );

        function verificaPendencias()
        {
            
            var existePendente  =   false;
            $.getJSON("?router=home/js.caixaAprovacoes", function(dados){                
                if(dados!="0")
                    {
                        $.each(dados, function(i, item){
                            if (i    ==  "QtdeApPendente"){
                                if(item!=0)
                                    existePendente = true;
                                    $("#ApPendente").text(item);
                            }else if (i    ==  "QtdeApAnteriores"){
                                $("#ApAbaixo").text(item);
                            }else if (i    ==  "QtdeApForaPrazo"){
                                $("#ApForaPrazo").text(item);
                            }else if (i    ==  "QtdeApDentroPrazo"){
                                $("#ApDentroPrazo").text(item);
                            }else if (i    ==  "QtdeDespesaPendente"){
                                if(item!=0)
                                    existePendente = true;
                                    $("#DespesaPendente").text(item);
                            }else if (i    ==  "QtdeDespesaAnteriores"){
                                $("#DespesaAbaixo").text(item);
                            }
                        });                        
                    
                        if(existePendente)
                            {
                                $("#dialog-form3").dialog
                                ({
                                        resizable: false,
                                        height:300,
                                        width:270,
                                        draggable: false,
                                        modal: true,
                                        open: function(){                                         
                                                            $(".ui-dialog-titlebar-close").hide();                                                         
                                                        },                                        
                                        buttons:
                                        {
                                            Fechar: function()
                                            {
                                                $(this).dialog("close");
                                                location.reload();
                                            }
                                        }                     
                                });                                  
                            }
                            else
                                {
                                    location.reload();
                                }
                    }
                    else
                        {
                            location.reload();
                        }
            });               
        }
                

        function login()
        {
            var usuario =   $("#name").val();
            var senha   =   $("#password").val();
            var action  =   "login";
            var evento  =   1;

            //Faz Login
            $.getJSON("?router=home/js.usuario",{usuario:usuario, senha:senha, action:action, evento:evento}, function(dados){
                if(dados!=0)
                    {              
                        $.each(dados, function(i, item){
                            if (i    ==  "UsuarioNome"){
                                $("#nome").val(item);
                            }else if (i    ==  "UsuarioNomeDisplay"){
                                $("#nome_display").val(item);
                            }else if (i    ==  "UsuarioFuncao"){
                                $("#funcao").val(item);
                            }else if (i    ==  "UsuarioDepartamento"){
                                $("#departamento").val(item);
                            }
                            else if (i    ==  "UsuarioRamal"){
                                $("#ramal").val(item);
                            }
                            else if (i    ==  "UsuarioCelular"){
                                $("#celular").val(item);
                            }
                            else if (i    ==  "UsuarioMatricula"){
                                $("#matricula").val(item);
                            }
                            else if (i    ==  "UsuarioLoja"){                                
                                var evento  =   2;
                                var opt     =   1;
                                
                                $.getJSON("?router=home/js.usuario", {evento:evento}, function(dadosloja){                                    
                                    $.each(dadosloja, function(i, itm){
                                         var option;
                                         if (item==itm[0])
                                             option =   "<option value='"+itm[0]+"' selected>"+itm[0]+" - "+itm[1]+"</option>";
                                         else if((item!=itm[0]) && (opt==1))
                                             {
                                                 option =   "<option value='' selected  >Selecione...</option>";                                
                                                 opt++;
                                             }
                                         else
                                             option =   "<option value='"+itm[0]+"'         >"+itm[0]+" - "+itm[1]+"</option>";
                                         //Preenche Multibox
                                         $("#loja").append(option);                                                                                                                         
                                    })      
                                })
                            }                    
                        })
                        
                        // RETIRADO FORMULÁRIO DE CONFIRMAÇÃO DE DADOS
                        //$( "#dialog-form2" ).dialog( "open" );
                        
                        // RELOAD NA PÁGINA APÓS LOGIN SEM CONFIRMAÇÃO DE DADOS
                        verificaPendencias();
                        
                        
                        $(".ui-dialog-titlebar-close").hide();   
                        
                    }else
                        {
                            verificaPendencias()
                            location.reload();
                        }                  
            })
                                                 
        } 


        function updateTips( t ) {
                tips
                        .text( t )
                        .addClass( "ui-state-highlight" );
                setTimeout(function() {
                        tips.removeClass( "ui-state-highlight", 1500 );
                }, 500 );
        }

        function checkLength( o, n, min, max ) {
                if ( o.val().length > max || o.val().length < min ) {
                        o.addClass( "ui-state-error" );
                        updateTips( "O tamanho do campo " + n + " não é válido ou está em branco!");

                        return false;
                } else {
                        return true;
                }
        }

        function checkRegexp( o, regexp, n ) {
                if ( !( regexp.test( o.val() ) ) ) {
                        o.addClass( "ui-state-error" );
                        updateTips( n );
                        return false;
                } else {
                        return true;
                }
        }

        $( "#dialog-form" ).dialog({ 
                autoOpen: false,
                height: 260,
                width: 230,
                draggable: false,
                resizable: false,
                modal: true,
                buttons: {
                        Login: function(event) {
                                event.preventDefault();
                                var bValid = true;
                                allFields.removeClass( "ui-state-error" );

                                bValid = bValid && checkLength( name, "Usuário", 3, 16 );
                                bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "O Campo usuário pode ter somente letras (a-z), números (0-9), underscores e inicia por uma letra." );

                                if ( bValid ) 
                                {
                                        login();                                                                                                                       
                                        $( this ).dialog( "close" );
                                }
                        },
                        Cancelar: function() {
                                $( this ).dialog( "close" );
                        }
                },
                close: function() {
                        allFields.val( "" ).removeClass( "ui-state-error" );
                }
        })
        
        .find("#name").focus();        
        //Ao pressionar Enter
        $( "#dialog-form" ).keydown(function(event) {
            if (event.keyCode == '13')
                {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    bValid = bValid && checkLength( name, "Usuário", 3, 16 );
                    bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "O Campo usuário pode ter somente letras (a-z), números (0-9), underscores e inicia por uma letra." );
                    if ( bValid ) {

                        login();
                        
                        $( this ).dialog( "close" );
                        
                    }                    
                }
        });
        
        $( "#cx_login" ).click(function() {
                        $( "#dialog-form" ).dialog( "open" );
                });
                
        $( "#dialog-form2" ).dialog({ 
                    autoOpen: false,
                    height: 530,
                    width: 350,
                    draggable: false,
                    resizable: false,
                    closeOnEscape: false,
                    modal: true,
                    buttons: {
                            Salvar: function() {
                                var bValid = true;
                                    allFields.removeClass( "ui-state-error" );                                
//                                    bValid = bValid && checkLength( nome, "Nome", 3, 16 );
//                                    bValid = bValid && checkLength( matricula, "Matricula", 3, 16 );
//                                    bValid = bValid && checkLength( funcao, "Função", 3, 16 );
//                                    bValid = bValid && checkLength( departamento, "Departamento", 3, 16 );
//                                    bValid = bValid && checkLength( ramal, "Ramal", 3, 16 );
//                                    bValid = bValid && checkLength( celular, "Celular", 3, 16 );
//                                    bValid = bValid && checkLength( loja, "Loja", 3, 16 );                                
                                
                                var evento          = 3                             ; //evento para inserir na tabela
                                    nome            = $( "#nome" ).val()            ;
                                    nome_display    = $( "#nome_display" ).val()    ;
                                    matricula       = $( "#matricula" ).val()       ;
                                    funcao          = $( "#funcao" ).val()          ;
                                    departamento    = $( "#departamento" ).val()    ;
                                    ramal           = $( "#ramal" ).val()           ;
                                    celular         = $( "#celular" ).val()         ;
                                    loja            = $( "#loja" ).val()            ;                                 
                                   
                                if ( bValid ) 
                                {
                                    //executa php para inserir dados digitados
                                    $.get("?router=home/js.usuario", {evento:evento
                                                                     , nome:nome
                                                                     , matricula:matricula
                                                                     , funcao:funcao
                                                                     , departamento:departamento
                                                                     , ramal:ramal
                                                                     , celular:celular
                                                                     , loja:loja}, function(){
                                                                     
                                                                     success: location.reload();
                                                                     });
                                    
                                    //Fecha caixa de dialogo
                                    $( this ).dialog( "close" );
                                }                                                                
                            },
                        Cancelar: function() {
                                location.reload();
                                $( this ).dialog( "close" );
                        }
                    },
                    close: function() {
                            allFields.val( "" ).removeClass( "ui-state-error" );
                    }
        })                 
});



