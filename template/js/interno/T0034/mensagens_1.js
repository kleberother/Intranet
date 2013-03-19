var stack_bottomleft = {"dir1": "right", "dir2": "up"};

function show_stack_bottomleft(err) {
        var opts = {
                pnotify_title: "Alerta",
                pnotify_text: "Inserido com Sucesso",
                pnotify_addclass: "stack-bottomleft",
                pnotify_stack: stack_bottomleft
        };
        if (err) {
                opts.pnotify_title = "Erro!";
                opts.pnotify_text = "Erro ao inserir";
                opts.pnotify_type = "error";
        }
        $.pnotify(opts);
};

function show_stack_bottomleft2(err) {
        var opts = {
                pnotify_title: "Alerta",
                pnotify_text: "Alterado com sucesso",
                pnotify_addclass: "stack-bottomleft",
                pnotify_stack: stack_bottomleft
        };
        if (err) {
                opts.pnotify_title = "Erro!";
                opts.pnotify_text = "Erro ao alterar";
                opts.pnotify_type = "error";
        }
        $.pnotify(opts);
};