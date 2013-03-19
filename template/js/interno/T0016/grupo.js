// Após inserção da AP verifica se existe grupo
$(function() {
    $( "#dialog-grp" ).dialog( "open" );

    $( "#dialog-grp" ).dialog
    ({
            autoOpen: true,
            resizable: true,
            height: 400,
            width: 500,
            modal: true,
            draggable: false,
            buttons: {
                    "Associar": function() {

                    },
                    Cancel: function() {
                                $( this ).dialog( "close" );
                    }
            },
            close: function() {
                    allFields.val( "" ).removeClass( "ui-state-error" );
            }
    })
});