<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/laporan_data.php';
require_once __DIR__ . '/laporan_template.php';
checkLogin();

use Dompdf\Dompdf;
use Dompdf\Options;

$data = getLaporanData($_GET);

ob_start();
include __DIR__ . '/laporan_styles.php';
$styles = ob_get_clean();

$body = renderLaporan($data['kriteria'], $data['alternatifFiltered'], $data['aggregated'], $data['ranking']);

$html = '<!DOCTYPE html>'
    . '<html lang="id">'
    . '<head><meta charset="UTF-8">' . $styles . '</head>'
    . '<body>' . $body . '</body>'
    . '</html>';

$options = new Options();
$options->setDefaultFont('Times');
$options->setIsRemoteEnabled(false);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('laporan-bansos-' . date('Ymd') . '.pdf', ['Attachment' => 0]);
