<?php
class PDF extends FPDF
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;

//Variáveis para dados
var $data;
var $total_baixas;
var $cnpj_cpf;
var $cod_rms;
var $raz_social;
var $numerador;
var $consi;

var $titulos;
var $serie;
var $desd;
var $loja;
var $agenda;
var $desc;
var $dt_agenda;
var $dt_ven;
var $bruto;
var $liquido;



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
    $this->Line(10, 32, 200, 32);
    //Line break
    $this->Ln(25);

}

function Footer()
{

    //DADOS

    //Page footer
    $this->SetY(-20);

    // NOME DO APROVADOR
    $this->SetFont("arial","",7);
    $this->Cell(50,5, "Ger. Comercial","T",0,"L");
    $this->Cell(20,5,"",0,0,"L");
    $this->Cell(50,5,"Dir. Comercial","T",0,"L");
    $this->Cell(20,5,"",0,0,"L");
    $this->Cell(50,5,"Controladoria","T",1,"L");

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
    $titulo   = utf8_decode("AUTORIZAÇÃO DE BAIXAS COMERCIAIS");

    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,200,200);
    $this->Cell(0,6, $titulo,0,1,'L',true);

    $this->Ln(5);
    //Save ordinate
    $this->y0=$this->GetY();
}

function ChapterBody()
{

//Captura Data
 $objDT      = new models_T0012();
 $this->data = $_POST["data"];
 $this->data = $objDT->converte_data($this->data);
 $this->data = $objDT->string_data($this->data);

//TITULOS COM ACENTO

//DADOS
//$this->data         = $_POST["data"];
$this->raz_social   = $_POST["T026_rms_razao_social"];
$this->cod_rms      = $_POST["T026_rms_codigo"];
$this->cnpj_cpf     = $_POST["T026_rms_cgc_cpf"];
$array_cnpj         = str_split($this->cnpj_cpf);
$cnpj_new           = $array_cnpj[0].$array_cnpj[1].".".$array_cnpj[2].$array_cnpj[3].$array_cnpj[4]
                      .".".$array_cnpj[5].$array_cnpj[6].$array_cnpj[7]."/".$array_cnpj[8].$array_cnpj[9]
                      .$array_cnpj[10].$array_cnpj[11]."-".$array_cnpj[12].$array_cnpj[13];

$this->numerador    = $_POST["numerador"];
$this->consi        = $_POST["consi"];

$this->total_baixas = explode(" ",$_POST["total"]);
$total = sprintf("%01.2f", $this->total_baixas[1]);
$print_total = "R$ ".$total;

$this->Ln(2);

// TEXTOS
$this->SetFont("arial","B",10);
$this->Write(5,  utf8_decode("São Paulo, $this->data"));
$this->Ln(8);
$this->SetFont("arial","",10);
$this->Write(5,  utf8_decode("À Controladoria (Contas à Receber)"));
$this->Ln(8);
$this->Write(5,  utf8_decode("Conforme procedimento (CTR-FIN-CR-001/11) interno, solicito baixa(s) do(s) crédito(s) de origem comercial abaixo listado(s), a partir dessa data."));
$this->Ln(8);

//FORNECEDOR NOME E COD RMS
$this->SetFont("arial","B",10);
$this->Cell(100,5,"FORNECEDOR","TLR",0,"L");
$this->Cell(40,5, utf8_decode("CÓDIGO RMS"),"TLR",0,"L");
$this->Cell(50,5, utf8_decode("CNPJ"),"TLR",1,"L");

//FORNECEDOR NOME E COD RMS
$this->SetFont("arial","",10);
$this->Cell(100,5,utf8_decode($this->raz_social),"BLR",0,"L");
$this->Cell(40,5, utf8_decode($this->cod_rms),"BLR",0,"L");
$this->Cell(50,5, utf8_decode($cnpj_new),"BLR",1,"L");

$this->Ln(3);
//VALOR TOTAL DAS BAIXAS
$this->SetFont("arial","B",10);
$this->Cell(30,5,"VALOR TOTAL","TBL",0,"L");
$this->SetFont("arial","",10);
$this->Cell(160,5,  $print_total,"TBR",0,"L");
$this->Ln(10);

//TABELA DE BAIXAS THEAD

$this->SetFont("arial","B",6);
$this->SetFillColor(200,200,200);
$this->Cell(15,5,utf8_decode("TÍTULO"),"TRL",0,"C",true);
$this->Cell(10,5,utf8_decode("SÉRIE"),"TRL",0,"C",true);
$this->Cell(10,5,utf8_decode("DESD."),"TRL",0,"C",true);
$this->Cell(10,5,utf8_decode("LOJA"),"TRL",0,"C",true);
$this->Cell(15,5,utf8_decode("AGENDA"),"TRL",0,"C",true);
$this->Cell(44,5,utf8_decode("DESCRIÇÃO"),"TRL",0,"C",true);
$this->Cell(18,5,utf8_decode("DT. AGENDA"),"TRL",0,"C",true);
$this->Cell(18,5,utf8_decode("DT. VENC."),"TRL",0,"C",true);
$this->Cell(25,5,utf8_decode("BRUTO"),"TRL",0,"C",true);
$this->Cell(25,5,utf8_decode("LÍQUIDO"),"TRL",1,"C",true);


//TABELA DE BAIXAS - TBODY

$this->SetFont("arial","",6);

$this->titulos   = $_POST["titulo"];
$this->serie     = $_POST["serie"];
$this->desd      = $_POST["desd"];
$this->loja      = $_POST["loja"];
$this->agenda    = $_POST["agenda"];
$this->desc      = $_POST["desc"];
$this->dt_agenda = $_POST["dt_agenda"];
$this->dt_vencto = $_POST["dt_vencto"];
$this->bruto     = $_POST["bruto"];
$this->liquido   = $_POST["liquido"];

$ArrayTab = array(  "tit" => $this->titulos
                  , "ser" => $this->serie
                  , "ded" => $this->desd
                  , "loj" => $this->loja
                  , "age" => $this->agenda
                  , "dec" => $this->desc
                  , "dta" => $this->dt_agenda
                  , "dtv" => $this->dt_vencto
                  , "bru" => $this->bruto
                  , "liq" => $this->liquido
                );

$contador = count($ArrayTab["tit"]);
$contador = $contador-1;
$i = 0;
while ($i < $contador)
{
if ($ArrayTab["liq"][$i] == "R$ 0")
    $ArrayTab["liq"][$i] = "R$ 0,00";

$this->Cell(15,5,utf8_decode($ArrayTab["tit"][$i]),1,0,"R");
$this->Cell(10,5,utf8_decode($ArrayTab["ser"][$i]),1,0,"L");
$this->Cell(10,5,utf8_decode($ArrayTab["ded"][$i]),1,0,"R");
$this->Cell(10,5,utf8_decode($ArrayTab["loj"][$i]),1,0,"R");
$this->Cell(15,5,utf8_decode($ArrayTab["age"][$i]),1,0,"R");
$this->Cell(44,5,utf8_decode($ArrayTab["dec"][$i]),1,0,"L");
$this->Cell(18,5,utf8_decode($ArrayTab["dta"][$i]),1,0,"R");
$this->Cell(18,5,utf8_decode($ArrayTab["dtv"][$i]),1,0,"R");
$this->Cell(25,5,utf8_decode($ArrayTab["bru"][$i]),1,0,"R");
$this->Cell(25,5,utf8_decode($ArrayTab["liq"][$i]),1,1,"R");

$i++;

}

$this->Ln(5);
$this->SetFont("arial","B",10);
$this->Write(5,  utf8_decode("Considerações Gerais ou relevantes, justificativas, instruções para Depto. Financeiro, etc."));
$this->Ln(10);
$this->SetFont("arial","",10);
$this->Write(5, utf8_decode($this->consi));
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
$pdf->SetTitle("AUTORIZAÇÃO DE BAIXAS COMERCIAIS");
$pdf->PrintChapter(1,'AUTORIZAÇÃO DE BAIXAS COMERCIAIS','');
$pdf->Output();

?>