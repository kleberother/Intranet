function upload(cod,TipoArquivo)
{
    document.cod   =   cod;
    document.TipoArquivo   =   TipoArquivo;
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
                    $("#form-upload").append("<input type='hidden' name='T055_codigo' value='"+cod+"'</input>");
                    $("#form-upload").append("<input type='hidden' name='T056_codigo' value='"+TipoArquivo+"'</input>");
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
