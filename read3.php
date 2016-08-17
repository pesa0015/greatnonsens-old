<?php
$story = (int)$_GET['story'];
$script = 'js/index.new_story.js';
$words = array(
			0 => array(
					'word' => 'Has closed eyes but still sees you knock dish off table'
					),
			1 => array(
					'word' => 'head butt cant eat out of my own dish yet eat grass,'
					),
			2 => array(
					'word' => 'throw it back up spot something, big eyes,'
					),
			3 => array(
					'word' => 'big eyes, crouch, shake butt, prepare to pounce attack dog, run away'
					),
			4 => array(
					'word' => 'and pretend to be victim but always hungry, stare at ceiling.'
					),
			5 => array(
					'word' => 'Lick yarn hanging out of own butt lick'
					),
			6 => array(
					'word' => 'the other cats sweet beast then cats take over the world. Caticus cuteicus lick the'
					),
			7 => array(
					'word' => 'plastic bag if it fits, i sits so eat owner\'s food,'
					),
			8 => array(
					'word' => 'chew foot sleep on keyboard, yet all of a sudden cat goes crazy.'
					),
			9 => array(
					'word' => 'Under the bed. Kick up litter put toy mouse in food bowl run'
					),
			10 => array(
					'word' => 'out of litter box at full speed fall over dead'
					),
			11 => array(
					'word' => '(not really but gets sypathy) yet rub face on everything'
					),
			12 => array(
					'word' => 'chase imaginary bugs why must they do that, or stand in front of the computer screen.'
					),
			);
// $title = sqlSelect("SELECT title FROM story WHERE story_id = {$story} AND status = 3;");
$title = array(0 => array('title' => 'Cat'));
// $words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story};");
// $writers = sqlSelect("SELECT type, username FROM users INNER JOIN story_writers ON users.user_id = story_writers.user_id WHERE story_id = {$story};");
function pre($a) {
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}
if (isset($_GET['pdf'])) {
	require 'tcpdf/tcpdf.php';
	// $storyTitle = $title[0]['title'];
	// 		echo $storyTitle;
	// 		die;
	class MYPDF extends TCPDF {
		// public function setHtmlHeader() {
		// 	echo $title[0]['title'];
		// 	die;
  //       	$this->htmlHeader = $htmlHeader;
  //   	}
		// pre($this);
		// die;
		protected $storyTitle = null;
		protected $storyWriters = array();

		public function setStoryTitle($storyTitle) {
		    $this->storyTitle = $storyTitle;
		}

		protected function _getStoryTitle() {
		    return $this->storyTitle;
		}
		public function setstoryWriters($storyWriters) {
		    $this->storyWriters = $storyWriters;
		}

		protected function _getstoryWriters() {
		    return $this->storyWriters;
		}
		public function Header() {
			if ($this->page == 1) {
				// $this->SetMargins(100,100,true,true);
				$this->SetY(50);
				$this->Cell(0,0,'Great nonsens',0,'','C',false,false,0,true,'C');

				$this->SetY(150);
				// $this->SetX(50);
				// $this->Cell(193,0,'Test',0,'','C',false,false,0,true,'C');

				$this->SetFontSize(40);
				$this->Cell(0,0,$this->_getstoryTitle(),0,'','C',false,false,0,true,'C');
				$this->Ln(20);
				$this->SetFontSize(20);
				$this->Cell(0,0,'2016-03-26',0,'','C',false,false,0,true,'C');
				$this->SetFontSize(20);
				$this->Ln(30);
				$this->Cell(0,0,count($this->_getstoryWriters()) . ' skribenter',0,'','C',false,false,0,true,'C');
				// pre($this->_getstoryWriters());
				// echo count($this->_getstoryWriters());
				// die;
				// echo $this->_getstoryWriters
				// $this->SetFontSize(50,false);
				// pre($this);
				// die;
				// echo $this->GetPageHeight();
				// die;
			}
			else {
				$this->SetFontSize(15);
				$this->setCellMargins(0,10,0,0);
				$this->setCellPaddings(0,0,0,5);
				$this->Cell(20, 0, 'GN','B', 0, 'L', false, 'L', 0, '', 0, false, 'T', 'M');
				$this->Cell(0, 0, $this->_getstoryTitle(),'B', 0, 'R', false, 'R', 0, '', 0, false, 'T', 'M');
			}
		}
		public function Footer() {
			if ($this->page != 1) {
	            // Position at 15 mm from bottom
	            $this->SetY(-15);
	            // Set font
	            $this->SetFont('times', '', 11);
	            // Page number
	          	$this->Cell(0, 0, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	        }     
        }    
	}
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, 'test');
	$pdf->setStoryTitle($title[0]['title']);
	$pdf->setstoryWriters($writers);
	$pdf->setHeaderFont(array('times', '', 25));
	$pdf->setFooterData(array(0,64,0), array(0,64,128));
	$pdf->setMargins(10,30,10,30);
// $pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='<table cellspacing="0" cellpadding="1" border="1"><tr><td rowspan="3">test</td><td>test</td></tr></table>', $tc=array(0,0,0), $lc=array(0,0,0));
	$pdf->AddPage();
	$pdf->AddPage();
	$text = '';
	foreach($words as $word) {
		$text .= $word['words'];
	}
	// $pdf->Text(9,35,$text,0);
	$pdf->SetFont('courier');
	$pdf->setCellHeightRatio(3);
	$pdf->MultiCell(0, 0, $z, 0, 'L', false, 1, 10, 30, true, 2, false, true, 0, 'T', true);
	$pdf->Output('example_003.pdf', 'I');
}
require 'header.php';
?>
	<h1><?=$title[0]['title']; ?></h1>
	<p>
		<?php foreach($words as $word): ?>
			<span><?=$word['word']; ?></span>
		<?php endforeach; ?>
	</p>
<?php require 'footer.php'; ?>