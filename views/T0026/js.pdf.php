<?php
class PDF extends FPDF
{
    //Current column
    var $col=0;
    //Ordinate of column start
    var $y0;
    var $Codigo;
    var $user;

    function LinhaCorte()
    {
            // Linha de corte
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",0,"L");
            $this->Cell(2,1,"",0,0,"L");
            $this->Cell(2,1,"","T",1,"L");    
    }

    function Header()
    {

        //Page header
        global $title;

        $this->DespesaCodigo  =   $_GET['DespesaCodigo'];

        // Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
        $this->Image('template/img/logo_davo.jpg',10,5,20);

        // Arial Negrito 30
        $this->SetFont('Arial','B',20);

        //Move to the right
        $this->Cell(30);

        //Title
        $this->Cell(120, 15, utf8_decode("REEMBOLSO DE DESPESAS "), 0, 0, "L");
        $this->Cell(0  , 15, utf8_decode("N° ".$this->DespesaCodigo) , 0, 1, "R");


        //Line
        $this->Line(10, 32, 200, 32);
        //Line break
        $this->Ln(8);    

    }

    function Footer()
    {
        $obj           =   new models_T0026();
        
        $DespesaCodigo  =   $this->DespesaCodigo                ;
        
        $DadosDespesa   =   $obj->retornaDespesa($DespesaCodigo);
        foreach($DadosDespesa   as  $campos =>  $valores)
        {
            $UsuarioNome            =   $valores['UsuarioNome'] ;
        }        
        // Data atual
        $data_atual     =   date("d/m/Y");

        //Page footer
        $this->SetY(-48);

        //$this->LinhaCorte();

        // CNPJ CAIXAS DE ASSINATURA
        $this->SetFont("arial","B",7);
        $this->Cell(63,20,"",1,0,"L");
        $this->Cell(63,20,"",1,0,"L");
        $this->Cell(64,20,"",1,1,"L");

        // DATA DA APROVAÇÃO
        $this->SetFont("arial","",6);
        $this->Cell(63,5,utf8_decode("Elaborado por: ".$UsuarioNome),"LR",0,"L");
        $this->Cell(63,5,utf8_decode("Pré-Aprovado por: ")          ,"LR",0,"L");
        $this->Cell(64,5,utf8_decode("Aprovado  por: ")             ,"LR",1,"L");

        // DATA DA APROVAÇÃO
        $this->SetFont("arial","",6);
        $this->Cell(63,5,utf8_decode("Em: ".$data_atual),"BLR",0,"L");
        $this->Cell(63,5,utf8_decode("Em: ")            ,"BLR",0,"L");
        $this->Cell(64,5,utf8_decode("Em: ")            ,"BLR",1,"L");

    }

    function Bloco01($Nome, $Contratado, $DataInicio, $DataFim, $CentroCusto)
    {
        // Primeira Linha
        $this->SetFont('arial','B',8);    

        $this->Cell(20,5,utf8_decode("NOME")  ,"TL",0,"L"); 

        $this->SetFont('arial','',7);
        $this->Cell(70,5,utf8_decode($Nome)  ,"T" ,0,"L"); 

        $this->SetFont('arial','B',8);
        $this->Cell(30,5,utf8_decode("CONTRATADO")  ,"T",0,"L"); 

        $this->SetFont('arial','',7);
        $this->Cell(70,5,utf8_decode($Contratado),"TR",1,"L");

        // Segunda Linha
        $this->SetFont('arial','B',8);
        $this->Cell(20,5,utf8_decode("PERÍODO")  ,"BL",0,"L"); 

        $this->SetFont('arial','',7);
        $this->Cell(70,5,utf8_decode($DataInicio." até ".$DataFim)  ,"B",0,"L"); 

        $this->SetFont('arial','B',8);
        $this->Cell(30,5,utf8_decode("C. CUSTO")  ,"B",0,"L"); 

        $this->SetFont('arial','',7);
        $this->Cell(70,5,utf8_decode($CentroCusto),"RB",1,"L"); 

        $this->Ln(2);
    }

    function Bloco02($DespesaDetalhe, $ValorKm, $TotalKm)
    {
        $obj    =   new models_T0026();
        
        $this->SetFont('arial', 'B', 8);
        $this->SetFillColor(210, 210, 210);        
        $this->Cell(190,5,  utf8_decode("DESPESAS COM QUILOMETRAGEM"),0,1,"C",true);

        $this->SetFillColor(245, 245, 245);
        $this->SetFont('arial', 'B', 8);
        $this->Cell(14  ,5,utf8_decode("DATA......") ,0   ,0,"L",true);
        $this->Cell(176 ,5,utf8_decode("DESCRIÇÃO.........................................................................................................................................................................................................")  ,0   ,1,"L",true);

        $this->SetFont('arial', 'B', 8);              
        $this->Cell(82  ,5,utf8_decode("ORIGEM..........................................................................................")  ,0   ,0,"L",true);
        $this->Cell(12  ,5,utf8_decode("HORA.....")                                                                                         ,0   ,0,"L",true);
        $this->Cell(76  ,5,utf8_decode("DESTINO......................................................................................")     ,0   ,0,"L",true);
        $this->Cell(12  ,5,utf8_decode("HORA....")                                                                                          ,0   ,0,"L",true);
        $this->Cell(8   ,5,utf8_decode("KM....")                                                                                            ,0   ,1,"L",true);           
        
        $QtdeKm =   0;              
        $i      =   0;
        foreach($DespesaDetalhe as  $campos =>  $valores)
        {
            // Muda cor das celulas
            if ($i % 2)
                $this->SetFillColor(245, 245, 245);
            else
                $this->SetFillColor(255, 255, 255);        

            $this->SetFont('arial', '', 7);
            $this->Cell(14  ,5,utf8_decode($valores['DespesaData'])         ,0   ,0,"L",true);
            $this->SetFont('arial', '', 6);
            $this->Cell(176 ,5,utf8_decode($valores['DespesaDescricao'])    ,0   ,1,"L",true);

            $this->SetFont('arial', '', 7);        
            $this->Cell(82 ,5,utf8_decode($valores['DespesaDescOrigem'])    ,"B"   ,0,"L",true);
            $this->Cell(12 ,5,utf8_decode($valores['DespesaSaida'])         ,"B"   ,0,"L",true);
            $this->Cell(76 ,5,utf8_decode($valores['DespesaDescDestino'])   ,"B"   ,0,"L",true);
            $this->Cell(12 ,5,utf8_decode($valores['DespesaChegada'])       ,"B"   ,0,"L",true);
            $this->Cell(8  ,5,utf8_decode($valores['DespesaKm'])            ,"B"   ,1,"L",true);  

            $this->Ln(1); 
            
            $QtdeKm +=  $valores['DespesaKm'];
            $i++;
        }

        $this->Ln(1);            
        $this->SetFillColor(210, 210, 210); 

        $this->SetFont('arial', 'B', 7);    
        $this->Cell(20,5,utf8_decode("VALOR DO KM:")            ,0  ,0 ,"L",true);

        $this->SetFont('arial', '', 7);    
        $this->Cell(20,5,utf8_decode($ValorKm)                  ,0  ,0 ,"L",true);    

        $this->SetFont('arial', 'B', 7);    
        $this->Cell(45,5,utf8_decode("TOTAL DA QUILOMETRAGEM:") ,0  ,0 ,"R",true); 

        $this->SetFont('arial', '', 7);    
        $this->Cell(30,5,utf8_decode("R$ ".$TotalKm)            ,0  ,0 ,"L",true); 

        $this->SetFont('arial', 'B', 7);       
        $this->Cell(67,5,utf8_decode("TOTAL DE KM:")            ,0  ,0 ,"R",true);

        $this->SetFont('arial', '', 7);
        $this->Cell(8,5,utf8_decode($QtdeKm)                    ,0  ,1 ,"L",true);    

        $this->Ln(2);
    }

    function Bloco03($DespesaDiversa, $Total)
    {

        $obj    =   new models_T0026();
        
        $i  =   0;
        foreach($DespesaDiversa as  $campos =>  $valores)
        {
        
            if ($i == 0 )
            {

            $this->SetFont('arial', 'B', 7);
            $this->SetFillColor(210, 210, 210);    
            $this->Cell(190 ,5,utf8_decode("DESPESAS DIVERSAS") ,0  ,1      ,"C",true);

            $this->SetFillColor(245, 245, 245);
            $this->Cell(15  ,5,utf8_decode("DATA..........")              ,0  ,0      ,"L", true );
            $this->Cell(120 ,5,utf8_decode("DESCRIÇÃO..............................................................................................................................................................")         ,0  ,0      ,"L", true );
            $this->Cell(35  ,5,utf8_decode("CONTA............................................")             ,0  ,0      ,"L", true );
            $this->Cell(20  ,5,utf8_decode("VALOR (R$).......")        ,0  ,1      ,"L", true );

            }
            // Muda cor das celulas
            if ($i % 2)
                $this->SetFillColor(245, 245, 245);
            else
                $this->SetFillColor(255, 255, 255);

            $this->SetFont('arial', '', 7);
            $this->Cell(15  ,5,utf8_decode($valores['DespesaData']),0   ,0,"L",true);
            $this->Cell(120 ,5,utf8_decode($valores['DespesaDescricao']),0   ,0,"L",true);
            $this->Cell(35  ,5,utf8_decode($obj->preencheZero("E",3,$valores['ContaCodigo'])."-".$valores['ContaNome']),0   ,0,"L",true);
            $this->Cell(20  ,5,utf8_decode($valores['DespesaValor']),0   ,1,"R",true);            
            
            $i++;
            $st =   1;
        }
        
        if ($st == 1 )
        {

            $this->Ln(1);            
            $this->SetFont('arial', 'B', 7);
            $this->SetFillColor(210, 210, 210); 

            $this->Cell(25,5,utf8_decode("")                    ,0  ,0 ,"L",true);

            $this->SetFont('arial', '', 7);
            $this->Cell(25,5,utf8_decode("")                    ,0  ,0 ,"R",true);

            $this->SetFont('arial', 'B', 7);    
            $this->Cell(45,5,utf8_decode("")                    ,0  ,0 ,"L",true);

            $this->SetFont('arial', '', 7);    
            $this->Cell(30,5,utf8_decode("")                    ,0  ,0 ,"R",true);    

            $this->SetFont('arial', 'B', 7);    
            $this->Cell(40,5,utf8_decode("TOTAL DAS DESPESAS:") ,0  ,0 ,"L",true); 

            $this->SetFont('arial', '', 7);    
            $this->Cell(25,5,utf8_decode($Total)                ,0  ,1 ,"R",true);     

            $this->Ln(2);

        }        
                
    }

    function Bloco04($Total)
    {

        $this->SetFillColor(210, 210, 210); 

        $this->Cell(125,5,utf8_decode("")           ,0  ,0 ,"L",true);

        $this->SetFont('arial', 'B', 10);    
        $this->Cell(40,5,utf8_decode("TOTAL GERAL:"),0  ,0 ,"L",true); 

        $this->SetFont('arial', '', 10);    
        $this->Cell(25,5,utf8_decode("R$ ".$Total)  ,0  ,1 ,"R",true); 

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
    $obj           =   new models_T0026();

    // Pula 5 espaços para início do PDF
    $this->Ln(5);
            
    //Dados 
    $this->DespesaCodigo    =   $_GET['DespesaCodigo']  ;
    $DespesaCodigo          =   $this->DespesaCodigo    ;
    
    $DadosDespesa   =   $obj->retornaDespesa($DespesaCodigo);
    foreach($DadosDespesa   as  $campos =>  $valores)
    {
        $DespesaCodigo          =   $valores['DespesaCodigo']       ;
        $UsuarioNome            =   $valores['UsuarioNome']         ;
        $UsuarioMatricula       =   $valores['UsuarioMatricula']    ;
        $DespesaLogin           =   $valores['DespesaLogin']        ;
        $DespesaData            =   $valores['DespesaData']         ;
        $DespesaDtInicio        =   $valores['DespesaDtInicio']     ;
        $DespesaDtFim           =   $valores['DespesaDtFim']        ;
        $DespesaTotalKm         =   $valores['DespesaTotalKm']      ;
        $DespesaTotalDiversos   =   $valores['DespesaTotalDiversos'];
        $DespesaValor           =   $valores['DespesaValor']        ;
        $CentroCusto            =   ""                              ;
    }
    
    $DespesaDetalhe =   $obj->retornaDespesaDetalhe($DespesaCodigo);
    
    $ValorKm        =   "R$ 0,42";
    
    $DespesaDiversa =   $obj->retornaDespesasDiversas($DespesaCodigo);          

    // Primeiro bloco de tabela (Cabecalho da Impressão)    
    $this->Bloco01($UsuarioNome, $UsuarioMatricula, $DespesaDtInicio, $DespesaDtFim, $CentroCusto);

    // Segundo bloco de tabela (Despesas com Quilometragem)
    $this->Bloco02($DespesaDetalhe, $ValorKm, $DespesaTotalKm);

    // Terceiro bloco de tabela (Despesas Diversas)
    $this->Bloco03($DespesaDiversa, $DespesaTotalDiversos);

    // Terceiro bloco de total)
    $this->Bloco04($DespesaValor);

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
$pdf->SetTitle("Reembolso de Despesa");
$pdf->PrintChapter(1,'Reembolso de Despesa','');
$pdf->Output();

?>