<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri  e Jorge Nova                */
/* Descrição: Classe para executar as Querys do Programa T0021            */
/**************************************************************************/

class models_T0024 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
        return $this->query("Select * From T004_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listaT002()
    {
        return $this->query("SELECT T.T002_codigo   P0024_T002_COD
                                  , T.T002_valor    P0024_T002_VAL
                                  , T.T002_desc     P0024_T002_DES
                               FROM T002_datatype   T;");
    }

    public function buscaT002($cod)
    {
        return $this->query("SELECT T.T002_codigo   P0024_T002_COD
                                  , T.T002_valor    P0024_T002_VAL
                                  , T.T002_desc     P0024_T002_DES
                               FROM T002_datatype   T
                              WHERE T.T002_codigo = $cod;");
    }

    public function insereT002($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
        
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
    }

    public function alteraT002($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));
       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   
    }

        public function excluiT002($tabela,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }


}
?>