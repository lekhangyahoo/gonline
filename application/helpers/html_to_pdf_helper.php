<?php
function convert2pdf($content,$file_name){
	if($file_name == '')$file_name = date('y_m_d_h_m_s').'.pdf';
	require_once(dirname(__FILE__).'/html2pdf.class.php');

    // get the HTML
    //ob_start();
    //include(dirname(__FILE__).'/about_1.php');
    //$content = ob_get_clean();
    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));

		$html2pdf->setDefaultFont('dejavusans'); //add this line
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');

        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        // add the automatic index
        //$html2pdf->createIndex('Sommaire', 30, 12, false, true, 2);

        // send the PDF
        $html2pdf->Output($file_name);
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}