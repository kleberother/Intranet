function status(cod)
{
    document.cod   =   cod;
    $("#dialog-confirm").dialog
    ({
        resizable: false,
        height:250,
        width:330,
        modal: true,
        draggable: false,
        buttons:
        {
                "Alterar": function()
                {
                    $("#form-status").append("<input type='hidden' name='T008_codigo' value='"+document.cod+"'</input>");
                    $("#form-status").submit();
                }
                ,
                Cancelar: function()
                {
                    $(this).dialog("close");
                }
        }
    });
}
