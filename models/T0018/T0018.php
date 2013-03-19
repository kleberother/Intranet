<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição:                                                             */
/**************************************************************************/

class models_T0018 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
        return $this->query("Select * From T004_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listaT045()
    {
       return $this->query("SELECT T045_codigo  P0018_T045_COD
                                 , T045_nome    P0018_T045_NOM
                                 , T045_desc    P0018_T045_DES
                              FROM T045_categoria_artigos");
    }

    public function buscaT045($cod)
    {
       return $this->query("SELECT T045_codigo  P0018_T045_COD
                                 , T045_nome    P0018_T045_NOM
                                 , T045_desc    P0018_T045_DES
                              FROM T045_categoria_artigos
                             WHERE T045_codigo = $cod");
    }

    public function insereT045($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }

    public function excluiT045($tabela,$campos,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $campos, $delim));
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }

    public function alteraT045($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!'); 
       }

    
}
?>