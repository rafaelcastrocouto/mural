<?php

// Versão 8.0
require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'autoload.inc.php');

// reference the Dompdf namespace para versão > 1.0
use Dompdf\Dompdf;
use Dompdf\Options;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled',true);
$dompdf = new Dompdf($options);

$dompdf->load_html($content_for_layout);

// (Optional) Setup the paper size and orientation
$dompdf->set_paper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("declaracao_estagio_ess_ufrj.pdf", array("Attachment" => false));
// echo $dompdf->output();

exit(0);
