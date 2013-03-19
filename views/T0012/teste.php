<script type="text/javascript" src="template/js/msgs/jquery.pnotify.js"></script>
<link href="template/css/-msgs/jquery.pnotify.default.css" rel="stylesheet" type="text/css" />
<link href="template/css/-msgs/jquery.pnotify.default.icons.css" rel="stylesheet" type="text/css" />
<style type="text/css">
        .ui-pnotify.stack-bottomleft {
                bottom: 15px;
                left: 15px;
                top: auto;
                right: auto;
        }

</style>
<script type="text/javascript">
        var stack_bottomleft = {"dir1": "right", "dir2": "up"};

        function show_stack_bottomleft(err) {
                var opts = {
                        pnotify_title: "Alerta",
                        pnotify_text: "Inserido com Sucesso!",
                        pnotify_addclass: "stack-bottomleft",
                        pnotify_stack: stack_bottomleft
                };
                if (err) {
                        opts.pnotify_title = "Erro!";
                        opts.pnotify_text = "Não foi possível excluir o usuário!";
                        opts.pnotify_type = "error";
                }
                $.pnotify(opts);
        };
</script>


<input value="Notice" onclick="show_stack_bottomleft();" type="button" />
<input value="Error" onclick="show_stack_bottomleft(true);" type="button" />
