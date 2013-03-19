<?php
class PDF extends FPDF
{
    //Current column
    var $col=0;
    //Ordinate of column start
    var $y0;

    //$cod = $_GET["cod"];

    var $cod;
    var $user;
    var $dados;
    
    
    function retornaData()
    {
        
        $dataTEms = $_REQUEST['DataInicial'];
        $dataTEms = substr($dataTEms,6,4)."-".substr($dataTEms,3,2)."-".substr($dataTEms,0,2);
        
        return $dataTEms;
    }


    function select()
    {
          $conn             =   "mssql";
          $verificaConexao    =   "";
          $db                 =   "DBO_CRE";
          $objMSSQL = new models_T0075($conn,$verificaConexao,$db);
          
          $data = $this->retornaData();
          
          $dados = $objMSSQL->retornaTotaisEMSVendas($data);
          
          return $dados;
          
    }
    
    function selectParc($loja)
    {
            
            $data = $this->retornaData();
            
            $connEMP            =  "emporium"                                   ;               
            $verificaConexao    =  1                                            ; 
            $objEMP             =  new models_T0075($connEMP,$verificaConexao)  ;
        
            $dados = $objEMP->retornaParceladoEmp($data, $loja);
     
            return $dados;
    }
    
    function selectRec($loja)
    {
          $data = $this->retornaData();
          $conn             =   "mssql";
          $verificaConexao    =   "";
          $db                 =   "DBO_CRE";
          $objMSSQL = new models_T0075($conn,$verificaConexao,$db);
          
          $dados = $objMSSQL->retornaTotaisPagEms($data, $loja);
          
          return $dados;
    }
    
    function table_temp_pag()
    {
      $data = $this->retornaData();
         
      $conn             =   "mssql";
          $verificaConexao    =   "";
          $db                 =   "DBO_CRE";
          
          $objMSSQL = new models_T0075($conn,$verificaConexao,$db);
          
          $dados = $objMSSQL->insereDadosPagTemp($data);
          
          return $dados;
        
    }
    
    function cabecalhoDados()
    {
        $this->AddPage('L');
     
       $this->Ln(3);

                $this->SetFont('arial','B',10);
                
        $dataTEms = $this->retornaData();
        
        $datainiShow = substr($dataTEms,8,2)."/".substr($dataTEms,5,2)."/".substr($dataTEms,0,4);
        $datafimShow = substr($dataTEms,8,2)."/".substr($dataTEms,5,2)."/".substr($dataTEms,0,4);
        
         $this->Cell(269,5,"DATA: $datainiShow "       ,"TLRB",1,"L");
        
        $this->Cell(13,5,""     ,"TLRB",0,"L");
        $this->Cell(38,5,"ROTATIVO"   ,"TLRB",0,"L");
        $this->Cell(38,5,"PARCELADO"                ,"TLRB",0,"L");
        $this->Cell(38,5,"AJUSTES"       ,"TLRB",0,"L");
        $this->Cell(38,5,"VOUCHER","TLRB",0,"L");
        $this->Cell(38,5,"CONVENIO","TLRB",0,"L");
        $this->Cell(66,5,"RECEBIMENTO"       ,"TLRB",1,"L");
        
        $this->Cell(13,5,"LOJA"     ,"TLRB",0,"L");
        $this->Cell(18,5,"VENDAS"   ,"TLRB",0,"L");
        $this->Cell(20,5,"C.VENDAS"                ,"TLRB",0,"L");
        $this->Cell(18,5,"VENDAS"       ,"TLRB",0,"L");
        $this->Cell(20,5,"C.VENDAS","TLRB",0,"L");
        $this->Cell(18,5,"VENDAS"       ,"TLRB",0,"L");
        $this->Cell(20,5,"C.VENDAS","TLRB",0,"L");
        $this->Cell(18,5,"VENDAS"       ,"TLRB",0,"L");
        $this->Cell(20,5,"C.VENDAS","TLRB",0,"L");
        $this->Cell(18,5,"VENDAS"       ,"TLRB",0,"L");
        $this->Cell(20,5,"C.VENDAS","TLRB",0,"L");
        $this->Cell(32,5,"RECEBIMENTOS"       ,"TLRB",0,"L");
        $this->Cell(34,5,"CANCELAMENTOS","TLRB",1,"L");
            
         
    }
    
    
function Header()
    {
        //Page header
        global $title;

        //$this->cod  =   $_GET['cod'];

        // Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
        $this->Image('template/img/logo_davo.jpg',10,5,20);

        // Arial Negrito 30
        $this->SetFont('Arial','B',15);

        //Move to the right
        $this->Cell(30);

        //Title
        $this->Cell(120, 15, utf8_decode("Confiança".$this->cod), 0, 1, "L");
        
        
        $this->SetFont('Arial','B',25);
        $this->Cell(30);
        $this->Cell(120, 0, utf8_decode("RELATÓRIO DE TOTAIS"), 0, 1, "L");


        //Line
        $this->Line(10, 32, 280, 32);
        //Line break
        $this->Ln(8);
        
       
    }

    function Footer()
    {
        //DADOS
        $this->Line(10, 275, 200, 275);
        //Captura Login para inserção
        $this->Ln(225);
        
        $this->Cell(185, 15, utf8_decode("Pagina ".$this->page), 0, 0, "R");

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
        
         $conn = "";
         $obj = new models_T0075($conn);

            $this->cabecalhoDados();
       
            $this->SetFont('arial','',8);
            
            $this->table_temp_pag();
            
            $dados = $this->select();
            
            while ($row = mssql_fetch_array($dados)) 
                
            {
                  $valorRot = $obj->retornaSomaEms($row["valRotativo"]);
                  $sValorRot += $valorRot;
                  if ($sValorRot == "") { $sValorRot = "000";}
                  $valorCrot = $obj->retornaSomaEms($row["canRotativo"]);
                  $sValorCrot +=$valorCrot;
                  if ($sValorCrot == "") { $sValorCrot = "000";}
                  $valorParc = $obj->retornaSomaEms($row["valParcelado"]);
                  $sValorParc += $valorParc;
                  if($sValorParc == "") {$sValorParc = "000";}
                  $valorVoucher = $obj->retornaSomaEms($row["valVoucher"]);
                  $sValorVoucher += $valorVoucher;
                  if ($sValorVoucher == "") { $sValorVoucher = "000";}
                  $valorCvoucher = $obj->retornaSomaEms($row["canVoucher"]);
                  $sValorCvoucher += $valorCvoucher;
                  if ($sValorCvoucher == "") { $sValorCvoucher = "000";}
                  $valorConvenio = $obj->retornaSomaEms($row["valConvenio"]);
                  $sValorConvenio += $valorConvenio;
                  if ($sValorConvenio == "") { $sValorConvenio = "000";}
                  $valorCconvenio = $obj->retornaSomaEms($row["canConvenio"]);
                  $sValorCconvenio += $valorCconvenio;
                  if ($sValorCconvenio == "") { $sValorCconvenio = "000";}
                  $valorAjuste = $obj->retornaSomaEms($row["valAjuste"]);
                  $sValorAjuste += $valorAjuste;
                  if ($sValorAjuste == "") { $sValorAjuste = "000";}
                  $valorCajuste = $obj->retornaSomaEms($row["canAjuste"]);
                  $sValorCAjuste += $valorCajuste;
                  if ($sValorCAjuste == "") { $sValorCAjuste = "000";}
                  
                  
                   
                  
                
                  $dadosEmp = $this->selectParc($row["LOJA"]);
            
                foreach($dadosEmp as $key => $value) 
                {
                    $valParc = $value["valor"];
                    $valParc = str_replace(".", "", $valParc);
                    $realParc = substr($valParc, 0, -3);
                    $centParc = substr($valParc, -3, 2);
                    $valParc = $realParc.$centParc;
                    $valParcEmp = $obj->retornaSomaEmp($valParc);
                    $sValorParc += $valParcEmp;
                    if ($sValorParc == "") { $sValorParc = "000";}
                    $valCparc = $value ["valor_canc"];
                    $valCparc = str_replace(".", "", $valCparc);
                    $realCParc = substr($valCparc, 0, -3);
                    $centCParc = substr($valCparc, -3, 2);
                    $valCparc = $realCParc.$centCParc;
                    $valcParcEmp = $obj->retornaSomaEmp($valCparc);
                    $sValorCparc += $valcParcEmp;
                    if ($sValorCparc == "") { $sValorCparc = "000";}
                }
                
                $lojaIn = $obj->formataNumero($row["LOJA"]);
                
                $dadosPag = $this->selectRec($lojaIn);
                $rowPag = mssql_fetch_array($dadosPag);
              
                $valorRece = $obj->retornaSomaEms($rowPag["valPagamento"]);
                 $sValorRec += $valorRece;
                 if ($sValorRec == "") { $sValorRec = "0,00";}
                 $valorCrec = $obj->retornaSomaEms($rowPag["valCanPagamento"]);
                 $sValorCrec += $valorCrec;
                 if ($sValorCrec == "") { $sValorCrec = "0,00";}
                
            $this->Cell(13,5,$row["LOJA"],"BRL",0,"L");
            $this->Cell(18,5,  number_format($row["valRotativo"],2,",","."),"BLR",0,"R");
            $this->Cell(20,5,number_format($row["canRotativo"],2,",","."),"BLR",0,"R");
            $this->Cell(18,5,number_format($row["valParcelado"],2,",","."),"BLR",0,"R");
            $this->Cell(20,5,$obj->totalValoresRelatorio($valCparc),"BLR",0,"R");
            $this->Cell(18,5,  number_format($row["valAjuste"],2,",","."),"BLR",0,"R");
            $this->Cell(20,5,number_format($row["canAjuste"],2,",","."),"BLR",0,"R");
            $this->Cell(18,5,number_format($row["valVoucher"],2,",","."),"BLR",0,"R");
            $this->Cell(20,5,number_format($row["canVoucher"],2,",","."),"BLR",0,"R");
            $this->Cell(18,5,number_format($row["valConvenio"],2,",","."),"BLR",0,"R");
            $this->Cell(20,5,number_format($row["canConvenio"],2,",","."),"BLR",0,"R");
            $this->Cell(32,5,number_format($rowPag["valPagamento"],2,",","."),"BLR",0,"R");
            $this->Cell(34,5,number_format($rowPag["valCanPagamento"],2,",","."),"BLR",1,"R");
            }
            
            $this->Cell(13,5,"TOTAL:","BRL",0,"L");
            $this->Cell(18,5,$obj->totalValoresRelatorio($sValorRot),"BLR",0,"R");
            $this->Cell(20,5,$obj->totalValoresRelatorio($sValorCrot),"BLR",0,"R");
            $this->Cell(18,5,$obj->totalValoresRelatorio($sValorParc),"BLR",0,"R");
            $this->Cell(20,5,$obj->totalValoresRelatorio($sValorCparc),"BLR",0,"R");
            $this->Cell(18,5,$obj->totalValoresRelatorio($sValorAjuste),"BLR",0,"R");
            $this->Cell(20,5,$obj->totalValoresRelatorio($sValorCAjuste),"BLR",0,"R");
            $this->Cell(18,5,$obj->totalValoresRelatorio($sValorVoucher),"BLR",0,"R");
            $this->Cell(20,5,$obj->totalValoresRelatorio($sValorCvoucher),"BLR",0,"R");
            $this->Cell(18,5,$obj->totalValoresRelatorio($sValorConvenio),"BLR",0,"R");
            $this->Cell(20,5,$obj->totalValoresRelatorio($sValorCconvenio),"BLR",0,"R");
            $this->Cell(32,5,$obj->totalValoresRelatorio($sValorRec),"BLR",0,"R");
            $this->Cell(34,5,$obj->totalValoresRelatorio($sValorCrec),"BLR",1,"R");
            
            
   }

    function PrintChapter()
    {
        //Add chapter
        $this->ChapterBody();

    }
}

$pdf      = new PDF();
$pdf->SetTitle("Aprovação de Pagamento");
$pdf->PrintChapter(1,'Auditoria de Preço','');
$pdf->Output();

?>