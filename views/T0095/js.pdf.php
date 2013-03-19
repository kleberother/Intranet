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

    function select()
    {
    $obj = new models_T0095();
    $this->cod      =   $_GET['cod'];
    $this->dados    =   $_GET['dados'];
    
    $itens = $this->dados;
    
    return $itens;
    }
    
    function cabecalhoDados()
    {
        $this->AddPage();        
        
        $this->Ln(3);

        //FORNECEDOR NOME E COD RMS
        $this->SetFont('arial','B',10);
        $this->Cell(30,5,"EAN"                      ,"TLRB",0,"L");
        $this->Cell(78,5,utf8_decode("DESCRIÇÃO")   ,"TLRB",0,"L");
        $this->Cell(22,5,"EM OFERTA"                ,"TLRB",0,"L");
        $this->Cell(23,5,utf8_decode("PREÇO")       ,"TLRB",0,"L");
        $this->Cell(22,5,utf8_decode("Qt. Etiqueta"),"TLRB",0,"L");
        $this->Cell(15,5,utf8_decode("Imprime")     ,"TLRB",1,"L");            
    }

    function Header()
    {
        //Page header
        global $title;

        $this->cod  =   $_GET['cod'];

        // Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
        $this->Image('template/img/logo_davo.jpg',10,5,20);

        // Arial Negrito 30
        $this->SetFont('Arial','B',20);

        //Move to the right
        $this->Cell(30);

        //Title
        $this->Cell(120, 15, utf8_decode("RUPTURA "), 0, 0, "L");
        $this->Cell(0, 15, utf8_decode("AUDITORIA N° ".$this->cod), 0, 1, "R");


        //Line
        $this->Line(10, 32, 200, 32);
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
        
        $itens      =   $this->select();
                    
        $this->cabecalhoDados();

        $i  =   0;
        foreach($itens as $campos=>$valores)
        {       
            $i++;
            
            $this->SetFont('arial','',9);
            $this->Cell(30,5, $valores['EAN']                               ,"BRL",0,"L");
            $this->Cell(78,5, strtoupper($valores['Descricao'])             ,"BLR",0,"L");
            $this->Cell(22,5, strtoupper(utf8_decode($valores['Oferta']))   ,"BLR",0,"L");
            $this->Cell(23,5, money_format('%.2n', $valores['Preco'])       ,"BLR",0,"L");
            $this->Cell(22,5, $valores['QtdeEtiqueta']                      ,"BLR",0,"L");
            $this->Cell(15,5, strtoupper(utf8_decode($valores['Imprime']))  ,"BLR",1,"L");
                        
            if(($i%46)==0)
            {
                $this->cabecalhoDados();
            }

        }
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