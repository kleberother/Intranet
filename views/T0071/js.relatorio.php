<?php
class PDF extends FPDF
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;

//$cod = $_GET["cod"];

var $codFornedor;
var $nomeFornecedor;
var $data_inicial;
var $data_final;
var $total;
var $loja;
var $totalLoja;

function select($loja)
{
 $obj                   = new models_T0071();
 $this->codFornecedor   = $obj->retornaCodigoFornecedorAutoComplete($_POST["fornecedor"]);
 $this->data_inicial    = $_POST["dt_inicial"];    
 $this->data_final      = $_POST["dt_final"];
 $this->loja            = $loja;
 $ap                   = $obj->retornaNotasFornecedor($this->codFornecedor,$this->data_inicial,$this->data_final,$this->loja);
 return $ap;
}

function selectLoja()
{
 $obj   =   new models_T0071();
 $loja  =   $obj->retornaLojas();
 
 return $loja;
}

function Header()
{
    //Page header
    global $title;
//    $endereco = utf8_decode("[Endereço da loja]");
//    $loja     = utf8_decode("[Nome da Loja]");
//    $telefone = utf8_decode("[Telefone da Loja]");
    
    //Logo -> variaveis (CAMINHO,POSIÇÃO X, POSIÇÃO Y, TAMANHO)
    $this->Image('template/img/logo_davo.jpg',10,5,20);
    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Move to the right
    $this->Cell(150);
    //Title
    $this->Cell(0, 0, $loja , 0, "R", 0);
    $this->SetFont('Arial','',12);
    $this->Cell(0, 15, $endereco , 0, "R", 0);
    $this->SetFont('Arial','',10);
    $this->Cell(0, 30, $telefone , 0, "R", 0);

    //Line
    $this->Line(10, 32, 287, 32);
    //Line break
    $this->Ln(25);

}

function Footer()
{


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
    //Title
    $titulo   = strtoupper(utf8_decode("Relatório de Notas por Fornecedor e Período"));
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,200,200);
    $this->Cell(0,6, $titulo,0,1,'L',true);
    $this->Ln(5);
    //Save ordinate
    $this->y0=$this->GetY();
}

function ChapterBody()
{

     $this->nomeFornecedor  = $_POST["fornecedor"];    
     $this->data_inicial    = $_POST["dt_inicial"];    
     $this->data_final      = $_POST["dt_final"];    
     $i                     = 1;
     $this->total           =  money_format('%n', $_POST['total']);

    $this->SetFont('arial','',10);

    // HEADER DO RELATÓRIO
    $this->Cell(156,10, $this->nomeFornecedor,"B",0,"L");
    $this->Cell(40,10, "DE: ".$this->data_inicial,"B",0,"L");
    $this->Cell(40,10, "ATE: ".$this->data_final,"B",0,"L");
    $this->Cell(40,10, "TOTAL: ".$this->total,"B",1,"L");

    $this->Ln(5);

    // TITULO DA TABELA
    $this->Cell(20, 10,  utf8_decode("EMISSÃO"),1,0,"C");
    $this->Cell(20, 10,  "NF.",1,0,"C");
    $this->Cell(30, 10,  "VALOR",1,0,"C");
    $this->Cell(206,10, utf8_decode("DESCRIÇÃO"),1,1,"C");

    //BUSCA DADOS
    $dadosLoja  = $this->selectLoja();


    foreach($dados2 as $campos2=>$valores2)
    {

        // Contador para listar nome da loja ou não
        //$i = 0;
        
        // Código da loja
        $this->loja    =   $valores2['Codigo'];
        
        $dados      = $this->select($this->loja);
        
        foreach($dados as $campos=>$valores)
        {

        $obj           = new models_T0071();

        //FORMATAR DADOS
        $valor_bruto   = money_format('%n', $valores['ValorBruto']);
        $descricao     = substr(utf8_decode($valores['Descricao']),0,105); 
        //$this->SetFont('arial','',10);

        $this->Cell(20,8, $valores['DataEmissao'],1,0,"L");
        $this->Cell(20,8, $valores['NotaFiscal'],1,0,"R");
        $this->Cell(30,8, $valor_bruto,1,0,"R");
        $this->Cell(206,8,$descricao,1,1,"L");

        //$this->Ln(5);
        //
        //$this->SetFont("arial","B",8);
        //$this->Write(5,utf8_decode($valores['Descricao']));
        //$this->Ln(10);
        //
            if ($i == 14) 
            {
                $this->AddPage();
                $i = 0;
            }

            $i++; 
        }

    }

}

function PrintChapter($num,$title,$file)
{
    //Add chapter
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody();

}
}

$pdf      = new PDF('L');
$pdf->SetTitle("Relatório de Fornecedor por Período");
$pdf->PrintChapter(1,'Relatório de Fornecedor por Período','');
$pdf->Output();

?>