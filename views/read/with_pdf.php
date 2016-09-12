<?php

require 'tcpdf/tcpdf.php';
	class MYPDF extends TCPDF {
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
		public function finished($finished) {
		    $this->finished = $finished;
		}

		protected function _finished() {
		    return $this->finished;
		}
		public function Header() {
			if ($this->page == 1) {
				$this->SetY(50);
				$this->Cell(0,0,'Great nonsens',0,'','C',false,false,0,true,'C');

				$this->SetY(150);
				$this->SetFontSize(40);
				$this->Cell(0,0,$this->_getstoryTitle(),0,'','C',false,false,0,true,'C');
				$this->Ln(20);
				$this->SetFontSize(20);
				$this->Cell(0,0,$this->_finished(),0,'','C',false,false,0,true,'C');
				$this->SetFontSize(20);
				$this->Ln(30);
				$this->Cell(0,0,count($this->_getstoryWriters()) . ' skribenter',0,'','C',false,false,0,true,'C');
			}
			else {
				$this->SetFont('courier');
				$this->SetFontSize(20);
				$this->setCellMargins(0,10,0,0);
				$this->setCellPaddings(0,0,0,5);
				// $this->Cell(20, 0, 'GN','B', 0, 'L', false, 'L', 0, '', 0, false, 'T', 'M');
				// $this->Cell(0, 15, $this->_getstoryTitle(),'B', 0, 'L', false, 'R', 0, '', 0, false, 'T', 'M');
				$this->writeHTMLCell(0, 0, 10, 0, '<img src="assets/images/g.png" width="15"> | ' . $this->_getstoryTitle(), 'B', 0, false, false, 'L', true);
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
	$pdf->finished($finished[0]['date']);
	$pdf->setstoryWriters($writers);
	$pdf->setHeaderFont(array('times', '', 25));
	$pdf->setFooterData(array(0,64,0), array(0,64,128));
	$pdf->setMargins(10,30,10,30);
	$pdf->AddPage();
	$pdf->AddPage();
	$text = '';
	foreach($words as $word) {
		$text .= ' ' . $word['words'];
	}
	$pdf->Text(9,35,$text,0);
	$pdf->SetFont('courier');
	$pdf->setCellHeightRatio(3);
	// $pdf->MultiCell(0, 0, 0, 0, 'L', false, 1, 10, 30, true, 2, false, true, 0, 'T', true);
	$pdf->Output('GN_' . $title[0]['title'] . '.pdf', 'I');

?>