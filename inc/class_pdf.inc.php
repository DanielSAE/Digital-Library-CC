<?php
  require_once("fpdf/fpdf.php");
  class pdf extends FPDF
  {
      private $Seitentitel;
      public function header()
      {
          $this->SetFont("Arial", "B", 15);
          $this->Cell(80);
          $this->Cell(30, 10, $this->Seitentitel, 0, 0, "C");
          $this->Line(5, 23, 205, 23);
          $this->Ln(20);
      }
      public function setText($text)
      {
          $this->SetLeftMargin(30);
          $this->Write(5, iconv('UTF-8', 'ISO-8859-15', $text));
          $this->ln();
      }
      public function setTitel($text)
      {
          $this->Seitentitel = $text;
      }
  }
?>