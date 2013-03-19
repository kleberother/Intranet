<?php 
class PDF extends FPDF
{
    //Current column
    var $col=0;
    //Ordinate of column start
    var $y0;
    var $cod;
    var $user;
    var $loja;

    function select()
    {

    $obj       =   new models_T0084();

    $this->cod  =   $_GET["nota"];
    $this->loja =   $_GET['loja'];  

    $nota      =   $obj->retornaNota($this->cod,$this->loja);

    return $nota;
    }

    function selectDesc()
    {

    $obj       =   new models_T0084();

    $this->cod  =   $_GET["nota"];
    $this->loja =   $_GET['loja'];

    $notaDesc      =   $obj->retornaNotaDesc($this->cod,$this->loja);

    return $notaDesc;
    }

    function selectDadosFornecedor($codigo)
    {

    //Instancia Classe
    $connORA            =   "ora";               

    $objORA             =   new models_T0084($connORA);

    $dadosFornecedor    =   $objORA->retornaDadosFornecedor($codigo);

    return $dadosFornecedor;

    }

    function Header()
    {

        //Page header
        global $title;

        $this->cod  =   $_GET['nota'];

        // Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
        $this->Image('template/img/logo_davo.jpg',10,5,20);

        // Arial Negrito 30
        $this->SetFont('Arial','B',20);

        //Move to the right
        $this->Cell(30);

        //Title
        $this->Cell(120, 15, utf8_decode("NOTA DE DÉBITO "), 0, 0, "L");
        $this->Cell(0  , 15, utf8_decode("N° ".$this->cod) , 0, 1, "R");


        //Line
        $this->Line(10, 32, 200, 32);
        //Line break
        $this->Ln(8);    

    }

    function Footer()
    {
        // Dados 
        $dados          =   $this->select();
        $data_atual     =   date("d/m/Y");

        //Page footer
        $this->SetY(-65);

        $this->Ln(5);

        foreach ($dados as $campos=>$valores)
        {                        

            $CodRMSLoja     =   strtoupper($valores['CodRMSLoja']);
            $RazSocLoja     =   strtoupper($valores['RazaoSocialLoja']);
            $CodFornecedor  =   strtoupper($valores['CodRMSFornecedor']);
            $RazaoSocial    =   strtoupper($valores['RazaoSocial']);
            
            // CNPJ CAIXAS DE ASSINATURA
            $this->SetFont('arial','B',10); 
            
            $this->SetXY(10, 228);
            $this->Cell(95,35,utf8_decode($CodRMSLoja." - ".$RazSocLoja),0,0,"C");
            $this->Cell(95,35,utf8_decode($CodFornecedor." - ".$RazaoSocial),0,1,"C");            
            
            $this->SetXY(10, 242);
            $this->Cell(95,35,"",1,0,"C");
            $this->Cell(95,35,"",1,1,"C");
            
            // DATA DE ELABORAÇÃO
            $this->SetFont("arial","",6);
            $this->SetXY(10, 280);
            $this->Cell(95,5,"Elaborado por: ".$valores['NomeElaborador'].", Em: ".$data_atual,"",0,"L");
        }

    }

    function SetCol($col)
    {
        //Set position at a given column
        $this->col=$col;
        $x=10+$col*65;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        //Method accepting or not automatic page break
        if($this->col<2)
        {
            //Go to next column
            $this->SetCol($this->col+1);
            //Set ordinate to top
            $this->SetY($this->y0);
            //Keep on page
            return false;
        }
        else
        {
            //Go back to first column
            $this->SetCol(0);
            //Page break
            return true;
        }
    }

    function ChapterTitle()
    {


    }

    function ChapterBody()
    {

        // Instanciando Classe de conexão com as models   
        $obj           =   new models_T0084();

        // Dados da Nota Header
        $dados          =   $this->select();

        // Dados da Descrição da Nota
        $dados2         =   $this->selectDesc();

        // Recupera dados do Header da Nota
        foreach($dados as $campos=>$valores)
        {
            $Codigo         =   strtoupper($valores['Codigo']);
            $CodLoja        =   strtoupper($valores['CodLoja']);
            $CodRMSLoja     =   strtoupper($valores['CodRMSLoja']);
            $NomeLoja       =   strtoupper($valores['NomeLoja']);
            $RazSocLoja     =   strtoupper($valores['RazaoSocialLoja']);
            $cnpjLoja       =   $obj->FormataCGCxCPF(strtoupper($valores['CNPJLoja']));
            $ieLoja         =   strtoupper($valores['IELoja']);
            $CodFornecedor  =   strtoupper($valores['CodRMSFornecedor']);
            $RazaoSocial    =   strtoupper($valores['RazaoSocial']);
            $ValorTotal     =   substr(money_format('%n', $valores['ValorTotal']), 2);
            $cnpj           =   $obj->FormataCGCxCPF($valores['CNPJ']);
            $ie             =   strtoupper($valores['IE']);
        }

        // Dados dos Fornecedores

        // Recupera endereços dos fornecedores, Codigo 01 = Loja, Codigo 02 = Fornecedor
        $codigo01   = str_replace("-", "", $CodRMSLoja);
        $codigo02   = str_replace("-", "", $CodFornecedor);

        // Recupera dados da Loja Davo
        $dados3 =   $this->selectDadosFornecedor($codigo01);

        while ($row_ora = oci_fetch_assoc($dados3))
        {
            $EnderecoLoja   =   trim($row_ora['ENDERECO']);
            $BairroLoja     =   trim($row_ora['BAIRRO']);
            $CidadeLoja     =   trim($row_ora['CIDADE']);
            $EstadoLoja     =   trim($row_ora['ESTADO']);
            $CEPLoja        =   trim($row_ora['CEP']);
            $FoneDDDLoja    =   trim($row_ora['FONEDDD']);
            $FoneLoja       =   trim($row_ora['FONENUM']);
            $FaxDDDLoja     =   trim($row_ora['FAXDDD']);
            $FaxLoja        =   trim($row_ora['FAXNUM']);
        }

        // Recupera dados do Fornecedor 
        $dados4 =   $this->selectDadosFornecedor($codigo02);

        while ($row_ora = oci_fetch_assoc($dados4))
        {
            $EnderecoForn   =   trim($row_ora['ENDERECO']);
            $BairroForn     =   trim($row_ora['BAIRRO']);
            $CidadeForn     =   trim($row_ora['CIDADE']);
            $EstadoForn     =   trim($row_ora['ESTADO']);
            $CEPForn        =   trim($row_ora['CEP']);
            $FoneDDDForn    =   trim($row_ora['FONEDDD']);
            $FoneForn       =   trim($row_ora['FONENUM']);
            $FaxDDDForn     =   trim($row_ora['FAXDDD']);
            $FaxForn        =   trim($row_ora['FAXNUM']);
        }

        // --------------------------------------------------------------------------------------------- Inicia o conteúdo do PDF

        // Pula 5 espaços para início do PDF
        $this->Ln(5);

        // Início dos dados de Emissor e Recebedor da Nota

        // Seta Fonte para Nerito e tamanho 10
        $this->SetFont('arial','B',10);

        $this->Cell(95,6,utf8_decode("DATA DE EMISSÃO")   ,1,0,"L"); 
        $this->Cell(95,6,utf8_decode("DATA DE VENCIMENTO"),1,1,"L"); 

        $this->SetFont('arial','',9);

        $this->Cell(95,6,utf8_decode(date("d/m/Y",strtotime($valores['DataEmissao']))),"LB",0,"L");
        $this->Cell(95,6,utf8_decode(date("d/m/Y",strtotime($valores['DataVencimento']))),"LRB",1,"L");

        $this->Ln(5);

        $this->Cell(95,6,utf8_decode("EMISSOR")  ,1,0,"L"); // Cabecalho da Coluna 01 - Emissor      (Loja Davo)
        $this->Cell(95,6,utf8_decode("RECEBEDOR"),1,1,"L"); // Cabecalho da Coluna 02 - Recebedor    (Fornecedor)   

        // Seta Fonte para tamanho 10
        $this->SetFont('arial','',10);


        $this->Cell(95,6,utf8_decode($CodRMSLoja." - ".$RazSocLoja),"L",0,"L");
        $this->Cell(95,6,utf8_decode($CodFornecedor." - ".$RazaoSocial),"LR",1,"L");

        $this->SetFont('arial','',7);
        $this->Cell(95,5,utf8_decode($EnderecoLoja.", ".$BairroLoja),"L",0,"L");
        $this->Cell(95,5,utf8_decode($EnderecoForn.", ".$BairroForn),"LR",1,"L");

        $this->Cell(95,5,utf8_decode($CidadeLoja." - ".$EstadoLoja."      CEP ".$CEPLoja),"L",0,"L");
        $this->Cell(95,5,utf8_decode($CidadeForn." - ".$EstadoForn."      CEP ".$CEPForn),"LR",1,"L");

        // Verifica se o DDD e fone da loja é igual a zero, caso não imprimir o conteudo.
        if (($FoneDDDLoja == 0) && ($FoneLoja == 0) && ($FaxDDDLoja == 0) && ($FaxLoja == 0))
            $this->Cell(95,5,utf8_decode(""),"L",0,"L");  
        else
            $this->Cell(95,5,utf8_decode("Tel.: (".$FoneDDDLoja.") ".$FoneLoja ."  Fax.: (".$FaxDDDLoja.") ".$FaxLoja),"L",0,"L");      

        // Verifica se o DDD e fone do fornecedor é igual a zero, caso não imprimir o conteudo.
        if (($FoneDDDForn == 0) && ($FoneForn == 0) && ($FaxDDDForn == 0) && ($FaxForn == 0))
            $this->Cell(95,5,utf8_decode(""),"LR",1,"L");
        else
            $this->Cell(95,5,utf8_decode("Tel.: (".$FoneDDDForn.") ".$FoneForn ."  Fax.: (".$FaxDDDForn.") ".$FaxForn),"LR",1,"L");    

        // Colunas com CNPJ e I.E
        $this->Cell(95,5,utf8_decode("CNPJ: ".$cnpjLoja."  I.E: ".$ieLoja),"LB",0,"L"); // Loja Davo
        $this->Cell(95,5,utf8_decode("CNPJ: ".$cnpj." I.E: ".$ie),"LRB",1,"L");         // Fornecedor


        $this->Ln(5);

        $this->SetFont('arial','B',10);

        $this->Cell(10 ,6,utf8_decode("CRF")       ,"TLB"  ,0,"C");
        $this->Cell(160,6,utf8_decode("DESCRIÇÃO") ,"TLB"  ,0,"C");
        $this->Cell(20 ,6,utf8_decode("VALOR R$")     ,1      ,1,"C");


        $this->SetFont('arial','',8);
        
        $y  =   98;
        foreach ($dados2 as $campos=>$valores)
        {       
            $this->SetXY(10, $y);
            $this->MultiCell(10,22,"","LRB","C");    
            $this->SetXY(20, $y);
            $this->MultiCell(160,22,"","LRB","L");    
            $this->SetXY(180, $y);
            $this->MultiCell(20,22,"","LRB","C");      
            
            $this->SetXY(10, $y);
            $this->MultiCell(10,22,$valores['CRF'],"","C");    
            $this->SetXY(20, $y);
            $this->MultiCell(160,5.5,str_pad(utf8_decode($valores['Descricao']),500, " ", STR_PAD_RIGHT),"","L");    
            $this->SetXY(180, $y);
            $this->MultiCell(20,22,utf8_decode(substr(money_format('%n', $valores['Valor']), 2)),"","R");      

            $y += 22;
        }

        $this->SetFont('arial','B',10)                                                                      ;

        $this->Ln(2)                                                                                        ;
        $this->Cell(170 ,   6,  utf8_decode("TOTAL GERAL")      ,"TLB"  ,0,"C")                             ;
        $this->Cell(20  ,   6,  utf8_decode($ValorTotal)        ,"TRB"  ,1,"R")                             ;

        $this->Ln(2)                                                                                        ;
        $this->Cell(190,6,ucwords(utf8_decode($obj->retornaValorPorExtenso($ValorTotal))),"TRLB"  ,0,"R")   ;

        $this->SetXY(10, 237)                                                                               ;    
        $this->Cell(190,6,"Ciente:"    ,""  ,0,"C")                                                         ;

    }

    function PrintChapter($num,$title,$file)
    {
        //Add chapter
        $this->AddPage();
        $this->ChapterTitle($num,$title);
        $this->ChapterBody();
    }
}

$pdf      = new PDF();
$pdf->SetTitle("Nota de Debito");
$pdf->PrintChapter(1,'Nota de Débito','');
$pdf->Output();

?>