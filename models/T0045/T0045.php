<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri  e Jorge Nova                */
/* Descrição: Classe para executar as Querys do Programa T0044            */
/**************************************************************************/

class models_T0045 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function retornaLojas()
    {
        return $this->query("   SELECT T06.T006_codigo  Codigo
                                     , T06.T006_nome    Nome
                                  FROM T006_loja T06");
    }

    public function retornaItem($cod, $tipo, $loja)
    {
        $connORA  =   $this->consulta;
        /*Tipo:
         *  1 - EAN
         *  2 - DUN
         *  3 - Interno RMS
         */
        if ($tipo == 1)
        {
            $sql = "SELECT DISTINCT EAN.EAN_COD_PRO_ALT                CODIGO
                         , ITM.GIT_DESCRICAO                  DESCRICAO
                         , ITM.GIT_EMB_VENDA                  EMBALAGEM
                         , ITM.GIT_TPO_EMB_VENDA              TPEMB
                         , CES.GET_VEND_ACUM_ANO              SAIDA_MEDIA
                      FROM RMS.AA3CCEAN EAN
                      JOIN RMS.AA3CITEM ITM ON (    ITM.GIT_COD_ITEM = trunc(EAN.EAN_COD_PRO_ALT/10,0)
                                                    AND ITM.GIT_DIGITO   = mod(EAN.EAN_COD_PRO_ALT,10)
                                               )
                      JOIN RMS.AA2CESTQ CES ON (CES.GET_COD_PRODUTO = EAN.EAN_COD_PRO_ALT)
                     WHERE EAN.EAN_FLAG_PRINC        <> 'D'
                       AND EAN.EAN_COD_EAN           = $cod
                       AND CES.GET_COD_LOCAL         = $loja";
        }
        else if($tipo==2)
        {
            $sql = "SELECT DISTINCT EAN.EAN_COD_PRO_ALT                CODIGO
                         , ITM.GIT_DESCRICAO                  DESCRICAO
                         , ITM.GIT_EMB_FOR                    EMBALAGEM
                         , ITM.GIT_TPO_EMB_FOR                TPEMB
                         , CES.GET_VEND_ACUM_ANO              SAIDA_MEDIA
                      FROM RMS.AA3CCEAN EAN
                      JOIN RMS.AA3CITEM ITM ON (    ITM.GIT_COD_ITEM = trunc(EAN.EAN_COD_PRO_ALT/10,0)
                                                    AND ITM.GIT_DIGITO   = mod(EAN.EAN_COD_PRO_ALT,10)
                                               )
                      JOIN RMS.AA2CESTQ CES ON (CES.GET_COD_PRODUTO = EAN.EAN_COD_PRO_ALT)
                     WHERE EAN.EAN_FLAG_PRINC        = 'D'
                       AND EAN.EAN_COD_EAN           = $cod
                       AND CES.GET_COD_LOCAL         = $loja";
        }
        else
        {
            $sql = "SELECT DISTINCT EAN.EAN_COD_PRO_ALT                CODIGO
                         , ITM.GIT_DESCRICAO                  DESCRICAO
                         , ITM.GIT_EMB_VENDA                  EMBALAGEM
                         , ITM.GIT_TPO_EMB_VENDA              TPEMB
                         , CES.GET_VEND_ACUM_ANO              SAIDA_MEDIA
                      FROM RMS.AA3CCEAN EAN
                      JOIN RMS.AA3CITEM ITM ON (    ITM.GIT_COD_ITEM = trunc(EAN.EAN_COD_PRO_ALT/10,0)
                                                    AND ITM.GIT_DIGITO   = mod(EAN.EAN_COD_PRO_ALT,10)
                                               )
                      JOIN RMS.AA2CESTQ CES ON (CES.GET_COD_PRODUTO = EAN.EAN_COD_PRO_ALT)
                     WHERE EAN.EAN_FLAG_PRINC        <> 'D'
                       AND EAN.EAN_COD_PRO_ALT       = $cod
                       AND CES.GET_COD_LOCAL         = $loja";
        }
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    }

    public function retornaLojaUsuario($user)
    {
        return $this->query("   SELECT T04.T004_login       Login
                                     , T06.T006_codigo      Codigo
                                  FROM T004_usuario T04
                                  JOIN T006_loja T06 ON (T06.T006_codigo	=	T04.T006_codigo)
                                 WHERE T04.T004_login	=	'$user'");
    }

    public function retornaMotivo()
    {
        return $this->query("  SELECT T69.T069_codigo      Codigo
                                    , T69.T069_nome        Nome
                                    , T69.T069_descricao   Descricao
                                 FROM T069_mata_burro_motivos T69;");
    }

    public function retornaUsuarios()
    {
        return $this->query("   SELECT T04.T004_login       Login
                                     , T04.T004_nome        Nome
                                  FROM T004_usuario T04");
    }

    public function inserir($tabela,$campos)
    {
        $insere =  $this->exec($this->insere($tabela, $campos));
        if($insere)
             $this->alerts('false', 'Alerta!', 'Incluído com Sucesso!');
        else
             $this->alerts('true', 'Erro!', 'Não foi possível Incluir!');         
        
        return $insere;
    } 

    public function excluir($tabela, $delim)
    {
        $exclui = $this->exec($this->exclui($tabela, $delim));

       	if($exclui)
		$this->alerts('false', 'Alerta!', 'Excluído com Sucesso!');
       	else
		$this->alerts('true', 'Erro!', 'Não foi possível Excluir!'); 

	return $exclui;
    }

    public function alterar($tabela,$campos,$delim)
    {
       $conn = "";
       $altera = $this->exec($this->atualiza($tabela, $campos, $delim));

       if($altera)
            $this->alerts('false', 'Alerta!', 'Alterado com Sucesso!');
       else
            $this->alerts('true', 'Erro!', 'Não foi possível Alterar!');   

	return $altera;
    } 

}
?>