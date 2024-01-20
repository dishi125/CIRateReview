<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


function createPDF($fileName, $html, $logo)
{
    ob_start();
    $CI = &get_instance();

    $CI->load->library('mypdf');
    // Include the main TCPDF library (search for installation path).
    $CI->load->library('Pdf');
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('TcPdf');
    $pdf->SetTitle('TcPdf');
    $pdf->SetSubject('TcPdf');
    $pdf->SetKeywords('TcPdf');

	// set default header data
//	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '', array(0, 64, 0), array(0, 64, 128));
	$pdf->setFooterData(array(0, 64, 128), array(0, 64, 128));
//	echo $logo; die();
//    $pdf->SetHeaderData($logo, 30, '', '');

    // set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//    $pdf->SetPrintHeader(true);
//    $pdf->SetPrintFooter(false);

    // set default monospaced font
//    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT);
//    $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(2);
    $pdf->SetFooterMargin(12);

    // set auto page breaks
//    $pdf->SetAutoPageBreak(TRUE, 0);
    $pdf->SetAutoPageBreak(TRUE, 15);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // set font
//    $pdf->SetFont('dejavusans', '', 10);

    // add a page
    $pdf->AddPage();

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();
    ob_end_clean();
    //Close and output PDF document
    $pdf->Output($fileName, 'F'); //for save
//    $pdf->Output($fileName, 'I'); //for view
}
