<?php
/**************************************************************************
                Intranet - DAVÓ SUPERMERCADOS
 * Criado em: 04/01/2012 por Alexandre Alves
 * Descrição: Classe para interação com banco do programa T0073 (Conciliacoes Redecard Crédito)  
           
***************************************************************************/

class models_T0073 extends models
{

    public function __construct($conn,$verificaConexao)
    {
        parent::__construct($conn,$verificaConexao);
    }

    public function executaProcedureBaixasRedecardCRE($Data , $Metodo , $Tipo)
    {   
        $connORA  =   $this->consulta;
        
//        $sql = "BEGIN 
//                        SPDVFIN_BaixasRedecardDEB_int ($Data); 
//                END;";
        // Procedure sendo chamada tres vezes para suprir um problema na execucao da mesma, o qual nao esta marcando
        // todos os titulos no RMS apenas na primeira execucao
        $sql = "BEGIN 
        
                        SPFIN_BaixasRedecardCRE_int ('$Data','$Metodo','$Tipo' ,1); 
                        SPFIN_BaixasRedecardCRE_int ('$Data','$Metodo','$Tipo' ,2); 
                        SPFIN_BaixasRedecardCRE_int ('$Data','$Metodo','$Tipo', 3);     
                END;";
        
        
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