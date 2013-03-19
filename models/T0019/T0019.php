<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 29/04/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição:                                                             */
/**************************************************************************/

class models_T0019 extends models
{

    public function __construct()
    {
        $conn = "";
        parent::__construct($conn);
        return $this->query("Select * From T004_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listaT054()
    {
       return $this->query("SELECT A.T054_codigo    P0019_T054_COD
                                 , A.T054_texto     P0019_T054_TEX
                                 , A.T054_dt_inicio P0019_T054_DTI
                                 , A.T054_dt_fim    P0019_T054_DTF
                                 , A.T054_hr_inicio P0019_T054_HOI
                                 , A.T054_hr_fim    P0019_T054_HOF
                              FROM T054_avisos  A");
    }

    public function buscaT054($cod)
    {
       return $this->query("SELECT A.T054_codigo    P0019_T054_COD
                                 , A.T054_texto     P0019_T054_TEX
                                 , A.T054_dt_inicio P0019_T054_DTI
                                 , A.T054_dt_fim    P0019_T054_DTF
                                 , A.T054_hr_inicio P0019_T054_HOI
                                 , A.T054_hr_fim    P0019_T054_HOF
                              FROM T054_avisos  A
                             WHERE A.T054_codigo = $cod");
    }

    public function inserir($tabela,$campos)
    {
        $insere = $this->exec($this->insere($tabela, $campos));
       if($insere)
            $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');          
    }

    public function excluiT054($tabela,$campos,$delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $campos, $delim));
       if($exclui)
            $this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 
    }

    public function altera($tabela,$campos,$delim)
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