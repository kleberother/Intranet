$(function() {

        $( "#dialog:ui-dialog" ).dialog( "destroy" );

        var name = $( "#name" ),
                //email = $( "#email" ),
                password = $( "#password" ),
                allFields = $( [] ).add( name ).add( password ),
                tips = $( ".validateTips" );

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
                height: 250,
                width: 270,
                modal: true,
                buttons: {
                        "Login": function() {
                                var bValid = true;
                                allFields.removeClass( "ui-state-error" );

                                bValid = bValid && checkLength( name, "Usuário", 3, 16 );
                                bValid = bValid && checkLength( password, "Senha", 5, 16 );
                                bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "O Campo usuário pode ter somente letras (a-z), números (0-9), underscores e inicia por uma letra." );
                                //bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

                                if ( bValid ) {
                                        $( "#frm" ).append( "<input type='hidden' id='dados' name='usuario' value='"+name.val()+"'/>" +
                                                            "<input type='hidden' id='dados' name='senha' value='"+password.val()+"'/>" +
                                                            "<input type='hidden' name='action'  value='login' />");
                                        $( "#frm" ).submit();
                                        $( this ).dialog( "close" );
                                }
                        },
                        Cancel: function() {
                                $( this ).dialog( "close" );
                        }
                },
                close: function() {
                        allFields.val( "" ).removeClass( "ui-state-error" );
                }
        });

        $( "#cx_login" )
                .click(function() {
                        $( "#dialog-form" ).dialog( "open" );
                });
});