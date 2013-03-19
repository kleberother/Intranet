<?php

$obj    = new models_T0115();

$objORA    = new models_T0115('ora');

$dadosRMS   =   $objORA->checkRMS();

while ($row_ora = oci_fetch_assoc($dadosRMS)){
    
    $dadosIntra =   $obj->dadosintra($row_ora['CODIGORMS'], $row_ora['DIGITO']);
        
    $i = 0;
    foreach ($dadosIntra as $cps => $valores) {
    
        $i++;
    }
    
       
    if($i==0)    {

        $razaoSocial        =   $row_ora['RAZAOSOCIAL'];
        $codigoRMS          =   $row_ora['CODIGORMS'];
        $Digito             =   $row_ora['DIGITO'];
        $cnpj               =   $row_ora['CNPJCPF'];
        $rg                 =   $row_ora['RGINSEST'];
        $inscMun            =   $row_ora['INSCMUN'];
        
   
    
    $tabela =   "T026_fornecedor";
    
    $campos =   array(  "T026_rms_razao_social"    =>  $razaoSocial
                       ,"T026_rms_codigo"          =>  $codigoRMS
                       ,"T026_rms_digito"          =>  $Digito
                       ,"T026_rms_cgc_cpf"         =>  $cnpj 
                       ,"T026_rms_insc_est_ident"  =>  $rg 
                       ,"T026_rms_insc_mun"        =>  $inscMun  );
    
    $obj->inserir($tabela, $campos);
    
    
    }
    
}
?>