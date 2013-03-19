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

function select()
{
 $objAP = new models_T0016();
 $this->cod = $_GET["cod"];
 $ap = $objAP->selecionaAPDF($this->cod);
 return $ap;
}

function selectUser()
{
 $this->user  = $_SESSION['user'];
 $objAP = new models_T0016();
 $nuser = $objAP->selecionaUser($this->user);
 return $nuser;
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
    $this->Line(10, 32, 200, 32);
    //Line break
    $this->Ln(25);

}

function Footer()
{

    //DADOS
    $dados  = $this->select();
    $dados2 = $this->selectUser();
    $data_atual        = date("d/m/Y");
    //Captura Login para inserção

foreach($dados as $campos=>$valores)
{
    //Page footer
    $this->SetY(-65);
    // CNPJ CAIXAS DE ASSINATURA
    $this->SetFont("arial","B",7);
    $this->Cell(47,35,"",1,0,"L");
    $this->Cell(47,35,"",1,0,"L");
    $this->Cell(47,35,"",1,0,"L");
    $this->Cell(48,35,"",1,1,"L");

    // NOME DO APROVADOR
    $this->SetFont("arial","",6);
    $this->Cell(47,5,"Elaborada por: ".$valores['P0016_T004_NOM'],"TLR",0,"C");
    $this->Cell(47,5,utf8_decode("Aprovação"),"TLR",0,"C");
    $this->Cell(47,5,utf8_decode("Controladoria (Lançamento)"),"TLR",0,"C");
    $this->Cell(48,5,"Financeiro","TLR",1,"C");

    foreach ($dados2 as $campos=>$valores2)
    {
    // DATA DA APROVAÇÃO
    $this->SetFont("arial","",6);
    $this->Cell(47,5,"Conferida por: ".$valores2['P0016_T004_NOM'],"LR",0,"C");
    $this->Cell(47,5,"","LR",0,"C");
    $this->Cell(47,5,"","LR",0,"C");
    $this->Cell(48,5,"","LR",1,"C");
    }
    
    // DATA DA APROVAÇÃO
    $this->SetFont("arial","",6);
    $this->Cell(47,5,"Em: ".$data_atual,"BLR",0,"C");
    $this->Cell(47,5,"","BLR",0,"C");
    $this->Cell(47,5,"","BLR",0,"C");
    $this->Cell(48,5,"","BLR",1,"C");
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
    //Title
    $this->cod = $_GET["cod"];
    $titulo   = utf8_decode("Aprovação de Pagamento");
    $num      = utf8_decode("N° ").$this->cod;
    $this->SetFont('Arial','',12);
    $this->SetFillColor(200,200,200);
    $this->Cell(0,6, $titulo,0,1,'L',true);
    $this->Cell(0,-6, $num ,0,1,'R',false);
    $this->Ln(5);
    //Save ordinate
    $this->y0=$this->GetY();
}

function ChapterBody()
{

//TITULOS COM ACENTO
$tit_for = utf8_decode("FORNECEDOR:");
$tit_cod = utf8_decode("CÓDIGO RMS:");
$tit_ser = utf8_decode("SÉRIE:");
$tit_dte = utf8_decode("DATA DE EMISSÃO:");
//$tit_vli = utf8_decode("VALOR LÍQUIDO:");
$tit_car = utf8_decode("CARACTERÍSTICA DA DESPESA:");
$tit_des = utf8_decode("DETALHES (DETALHAMENTOS DO SERVIÇO CONTRATADO, COMPETÊNCIA OU PERIODO DE EXECUÇÃO, MENCIONAR ANEXOS QUE SEGUEM, E DEMAIS CONTEÚDOS):");
$tit_jus = utf8_decode("JUSTIFICATIVAS/CONSIDERAÇÕES RELEVANTES A CONTRATAÇÃO:");
$tit_ins = utf8_decode("INSTRUÇÕES P/ CONTROLADORIA/FINANCEIRO:");
$tit_con = utf8_decode("ESPAÇO RESERVADO A CONTROLADORIA (AGENDA, NÚMERO, SÉRIE, DATA DE AGENDA, CONTA CONTABÍL, CONTROLES INTERNOS, ETC.):");

//BUSCA DADOS
$dados = $this->select();

foreach($dados as $campos=>$valores)
{

//FORMATAR DADOS

$objAP = new models_T0016();
$cgc =  $objAP->FormataCGCxCPF($valores['P0016_T026_CGC']);

$dt_emissao        = $valores['P0016_T008_DTE'];
$val_emi           = explode(" ",$dt_emissao);
$date_emi          = explode("-",$val_emi[0]);
$dt_emissao_format = $date_emi[2]."/".$date_emi[1]."/".$date_emi[0];

$dt_recebimento    = $valores['P0016_T008_DTR'];
$val_rec           = explode(" ",$dt_recebimento);
$date_rec          = explode("-",$val_rec[0]);
$dt_receb_format = $date_rec[2]."/".$date_rec[1]."/".$date_rec[0];

$dt_vencimento     = $valores['P0016_T008_DTV'];
$val_ven           = explode(" ",$dt_vencimento);
$date_ven          = explode("-",$val_ven[0]);
$dt_vencto_format  = $date_ven[2]."/".$date_ven[1]."/".$date_ven[0];

$valor_bruto       = money_format('%n', $valores['P0016_T008_VAB']);

//$valor_liquido     = money_format('%n', $valores['P0016_T008_VAL']);

$fpa               = strtoupper($valores['P0016_T008_FPA']);

$nco               = strtoupper($valores['P0016_T008_NCO']);

$tde               = $valores['P0016_T008_TDE'];

if ($tde == 1)
    {
     $tde = "EVENTUAL";
    }
else if ($tde == 2)
    {
     $tde = "POR DEMANDA";
    }
else
    {
    $tde = "REGULAR";
    }

$this->Ln(2);

//FORNECEDOR NOME E COD RMS
$this->SetFont('arial','B',10);
$this->Cell(155,5,$tit_for,"TLR",0,"L");
$this->Cell(35,5,$tit_cod,"TLR",1,"L");


//LINHAS PARA FORNECEDOR E COD RMS
$this->SetFont('arial','',10);
$this->Cell(155,5, $valores['P0016_T026_RAZ'],"BRL",0,"L");
$this->Cell(35,5, $valores['P0016_T026_COD']."-".$valores['P0016_T026_DIG'],"BLR",1,"L");

$this->Ln(2);

// CNPJ IE E IM
$this->SetFont('arial','B',10);
$this->Cell(64,5,'CNPJ / CPF:',"TLR",0,"L");
$this->Cell(63,5,'I.E.:',"TLR",0,"L");
$this->Cell(63,5,'I.M. / R.G:',"TLR",1,"L");


// LINHAS PARA CNPJ IE E IM
$this->SetFont("arial","",10);
$this->Cell(64,5, $cgc,"BLR",0,"L");
$this->Cell(63,5, $valores['P0016_T026_INE'],"BLR",0,"L");
$this->Cell(63,5, $valores['P0016_T026_INM'],"BLR",1,"L");

$this->Ln(2);

// CNPJ NOTA FISCAL, SÉRIE E DATAS
$this->SetFont("arial","B",10);
$this->Cell(27,5,"NOTA FISCAL:","TLR",0,"L");
$this->Cell(14,5,$tit_ser,"TLR",0,"L");
$this->Cell(20,5,"FATURA:","TLR",0,"L");
$this->Cell(37,5,$tit_dte,"TLR",0,"L");
$this->Cell(47,5,"DATA DE RECEBIMENTO:","TLR",0,"L");
$this->Cell(45,5,"DATA DE VENCIMENTO:","TLR",1,"L");

// LINHAS PARA NOTA FISCAL, SÉRIE E DATAS
$this->SetFont("arial","",10);
$this->Cell(27,5,$valores['P0016_T008_NNF'],"BLR",0,"L");
$this->Cell(14,5,$valores['P0016_T026_SER'],"BLR",0,"L");
$this->Cell(20,5,$valores['P0016_T008_FAT'],"BLR",0,"L");
$this->Cell(37,5,$dt_emissao_format,"BLR",0,"L");
$this->Cell(47,5,$dt_receb_format,"BLR",0,"L");
$this->Cell(45,5,$dt_vencto_format,"BLR",1,"L");

$this->Ln(2);

// VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont('arial','B',10);
$this->Cell(40,5,'VALOR:',"TLR",0,"L");
//$this->Cell(40,5,$tit_vli,"TLR",0,"L");
$this->Cell(150,5,'COND. E FORMA DE PAGAMENTO:',"TLR",1,"L");


// LINHAS PARA VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont("arial","",10);
$this->Cell(40,5,$valor_bruto,"BLR",0,"L");
//$this->Cell(40,5,$valor_liquido,"BLR",0,"L");
$this->Cell(150,5,$fpa,"BLR",1,"L");

$this->Ln(2);

// VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont("arial","B",10);
$this->Cell(80,5,"LOJA FATURADA:","TLR",0,"L");
$this->Cell(70,5,$tit_car,"TLR",0,"L");
$this->Cell(40,5,"NUM. CONTRATO","TLR",1,"L");


// LINHAS PARA VALOR BRUTO, LIQUIDO E CONDIÇÃO DO PAGAMENTO
$this->SetFont("arial","",10);
$this->Cell(80,5,$valores['P0016_T006_COD']." - ".$valores['P0016_T006_NOM'],"BLR",0,"L");
$this->Cell(70,5,$tde,"BLR",0,"L");
$this->Cell(40,5,$nco,"BLR",1,"L");

$this->Ln(5);

// TEXTOS
$this->SetFont("arial","B",8);
$this->Write(5,$tit_des);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,utf8_decode($valores['P0016_T008_DES']));
$this->Ln(8);

$this->SetFont("arial","B",8);
$this->Write(5,$tit_jus);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,utf8_decode($valores['P0016_T008_JUS']));
$this->Ln(8);

$this->SetFont("arial","B",8);
$this->Write(5,$tit_ins);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,utf8_decode($valores['P0016_T008_INS']));
$this->Ln(8);

$this->SetFont("arial","B",8);
$this->Write(5,$tit_con);
$this->Ln(8);

$this->SetFont("arial","",8);
$this->Write(5,utf8_decode($valores['P0016_T008_CON']));
$this->Ln(10);

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

$pdf      = new PDF();
$pdf->SetTitle("Aprovação de Pagamento");
$pdf->PrintChapter(1,'Aprovação de Pagamento','');
$pdf->Output();

?>