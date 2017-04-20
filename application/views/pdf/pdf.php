<?php

// initiate FPDI
$pdf = new FPDI();
// add a page

// set the source file

$pageCount = $pdf->setSourceFile('.\assets/character_sheet.pdf');
// iterate through all pages
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    // import a page
    $templateId = $pdf->importPage($pageNo);
    // get the size of the imported page
    $size = $pdf->getTemplateSize($templateId);

    // create a page (landscape or portrait depending on the imported page size)
    if ($size['w'] > $size['h']) {
        $pdf->AddPage('L', array($size['w'], $size['h']));
    } else {
        $pdf->AddPage('P', array($size['w'], $size['h']));
    }

    // use the imported page
    $pdf->useTemplate($templateId);

    $pdf->SetFont('Helvetica');
    $pdf->SetXY(40, 7);
    $pdf->Write(8, ucfirst($character['charName']));
	$pdf->SetXY(130, 6);
    $pdf->Write(8, ucfirst($character['charClass']));
	$pdf->SetXY(225, 6);
    $pdf->Write(8, $character['charLevel']);
	$pdf->SetXY(50, 14);
	$pdf->Write(8, ucfirst($player['username']));
	$pdf->SetXY(20, 39);
	
	$pdf->Write(8, $character['STR']);
	$pdf->SetXY(20, 58);
	$pdf->Write(8, $character['INT']);
	$pdf->SetXY(20, 77);
	$pdf->Write(8, $character['WIS']);
	$pdf->SetXY(20, 97);
	$pdf->Write(8, $character['DEX']);
	$pdf->SetXY(20, 115);
	$pdf->Write(8, $character['CON']);
	$pdf->SetXY(20, 134);
	$pdf->Write(8, $character['CHA']);
	$pdf->SetXY(20, 154);
}

$pdf->Output();

?>