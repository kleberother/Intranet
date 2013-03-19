<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 17/10/2011 por Rodrigo Alfieri
 * Descrição: Classe para interação com banco do programa T0058 (Geração de Teclado Scritta)  
           
***************************************************************************/

class models_T0060 extends models
{

    public function __construct($conn,$verificaConexao)
    {
        parent::__construct($conn,$verificaConexao);
    }

    public function executaProcedureBaixasRedecardDEB($Data)
    {   

        $connORA  =   $this->consulta;
        
        $sql = "BEGIN 
                        SPDVFIN_BaixasRedecardDEB_int ($Data); 
                END;";
        
        //echo $sql ;
        $stid    = oci_parse($connORA, $sql);

            
            
        oci_execute($stid);
        
        return($stid);
    }
    
    public function teste()
    {
        $connORA = $this->consulta;
        $sql ="begin
                  teste;
                end;";
        $stdid = oci_parse($connORA, $sql);
        
        oci_execute($stid);
        return($stdid);
    }
    
}
?>
<?php
/* -------- Controle de versões - models/T0034.php --------------
 * 1.0.0 - 17/10/2011   --> Liberada a versão
*/
?>