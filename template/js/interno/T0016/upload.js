function upload(cod)
{
    document.cod   =   cod;
    $("#dialog-upload").dialog
    ({
        resizable: false,
        height:250,
        width:330,
        modal: true,
        draggable: false,
        buttons:
        {
                "Upload": function()
                {
                    $("#form-upload").append("<input type='hidden' name='T008_codigo' value='"+cod+"'</input>");
                    $("#form-upload").submit();
                } 
                ,
                Cancelar: function()
                {
                    $(this).dialog("close");
                }
        }
    });
}
