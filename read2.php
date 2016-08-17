<?php
error_reporting(E_ERROR | E_PARSE);
require 'mysql/query.php';
$story = (int)$_GET['story'];
$title = sqlSelect("SELECT title FROM story WHERE story_id = {$story} AND status = 3;");
$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story};");
if (isset($_GET['pdf'])) {
	// header('Content-type: application/pdf');
	require 'fpdf.php';
	// $text = array();
	// foreach($words as $word) {
	// 	array_push($text, $word['words']);
	// }
	// function Header() {
	    // $this->Write($text[0]['title']);
	// }

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output('I');
$pdf->Close();
die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1><?=$title[0]['title']; ?></h1>
	<p>
		<?php foreach($words as $word): ?>
			<span><?=$word['words']; ?></span>
		<?php endforeach; ?>
	</p>
</body>
</html>