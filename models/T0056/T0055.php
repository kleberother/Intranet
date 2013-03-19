<?php

/**************************************************************************/
/*                          DAVÓ SUPERMERCADOS                            */
/* Criado em: 15/04/2011 por Rodrigo Alfieri  e Jorge Nova                */
/* Descrição: Classe para executar as Querys do Programa T0044            */
/**************************************************************************/

class models_T0055 extends models
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function Seleciona()
    {
        $a = $this->execute( $this->prepare("SELECT  [RowNumber]
                                      ,[EventClass]
                                      ,[TextData]
                                      ,[ApplicationName]
                                      ,[NTUserName]
                                      ,[LoginName]
                                      ,[CPU]
                                      ,[Reads]
                                      ,[Writes]
                                      ,[Duration]
                                      ,[ClientProcessID]
                                      ,[SPID]
                                      ,[StartTime]
                                      ,[EndTime]
                                      ,[BinaryData]
                                  FROM [DBO_CRE].[dbo].[d]"));
        
        return $a;
    }
    


}
?>