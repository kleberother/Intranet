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