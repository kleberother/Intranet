<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 12/04/2011 por Rodrigo Alfieri e Jorge Nova                 */
/* Descrição: Classe para executar as Querys do Programa T0012            */
/**************************************************************************/

class models_T0012 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    function converte_data($data)
    { 
        $dta = explode("/",$data);
        $nData = $dta[2]."-".$dta[1]."-".$dta[0];
        return $nData;
    }

    public function string_data($data) //
        {
        $sem = date('D', strtotime($data));
        $mes = date('M', strtotime($data));
        $dia = date('d', strtotime($data));
        $ano = date('Y', strtotime($data));

            $semana = array(
                                "Sun" => "Domingo"
                              , "Mon" => "Segunda-Feira"
                              , "Tue" => "Terca-Feira"
                              , "Wed" => "Quarta-Feira"
                              , "Thu" => "Quinta-Feira"
                              , "Fri" => "Sexta-Feira"
                              , "Sat" => "Sábado"
                            );

            $mess   = array(
                                "Jan" => "Janeiro"
                              , "Feb" => "Fevereiro"
                              , "Mar" => "Marco"
                              , "Apr" => "Abril"
                              , "May" => "Maio"
                              , "Jun" => "Junho"
                              , "Jul" => "Julho"
                              , "Aug" => "Agosto"
                              , "Nov" => "Novembro"
                              , "Sep" => "Setembro"
                              , "Oct" => "Outubro"
                              , "Dec" => "Dezembro"
                            );
            $string_data = $semana["$sem"].", ".$dia." de ".$mess["$mes"]." de ".$ano;
            return $string_data;
        }


    public function selecionaFornRMS($cnpj,$cod)
    {
        $connORA  =   $this->consulta;
        $sql = "SELECT T1.TIP_CODIGO
                    || T1.TIP_DIGITO            COD
                     , T1.TIP_RAZAO_SOCIAL      RAZ
                     , T1.TIP_CGC_CPF           CGC
                     , T1.TIP_INSC_EST_IDENT    IES
                     , T1.TIP_INSC_MUN          IMN
                  FROM RMS.AA2CTIPO             T1";
        if($cod == 0)
            $sql = $sql . " WHERE T1.TIP_CGC_CPF  =   '$cnpj'";
        else
            $sql = $sql . " WHERE T1.TIP_CODIGO
                               || T1.TIP_DIGITO   =   $cod";
        $stid    = oci_parse($connORA, $sql);
        oci_execute($stid);
        return($stid);
    }

    public function selecionaTitulos($cod,$titulo,$desd,$serie)
    {
        $conn   =   $this->consulta;
        $sql = "SELECT
                       A.DUP_COD_FIL                                LOJ
                     , A.DUP_AGENDA                                 AGE
                     , trim( B.TAB_CONTEUDO )                       DSA
                     , to_char(C.DRDATE,'DD/MM/YYYY')               DAG
                     , to_char(D.DRDATE,'DD/MM/YYYY')               DVE
                     , A.DUP_VALOR                                  BRT
                     ,( A.DUP_VALOR- A.DUP_ABATIMENTO- A.DUP_DESC ) LIQ
                 FROM RMS.AA1RTITU A
                 INNER JOIN RMS.AA2CTABE B ON
                    ( B.TAB_CODIGO             = 14     AND
                     to_number( trim( B.TAB_ACESSO ) ) = A.DUP_AGENDA )
                 INNER JOIN RROCHA.DATA_RMS C ON ( C.DRDATER6       = A.DUP_DT_AGENDA )
                 INNER JOIN RROCHA.DATA_RMS D ON ( D.DRDATER7       = A.DUP_VENC )
                 WHERE A.DUP_COD_CLI          = trunc($cod/10,0)
                 AND A.DUP_TITULO             = $titulo
                 AND A.DUP_DESD               = $desd
                 AND trim(A.DUP_SERIE)        = '$serie'";
                // AND A.DUP_DT_PAG             = 0   -- Aberto";
       $stid    = oci_parse($conn, $sql);
       oci_execute($stid);
       return($stid);
    }

}
?>