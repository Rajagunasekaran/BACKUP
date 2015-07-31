<?php
$fpdffile = $_SERVER["DOCUMENT_ROOT"] .'/fpdf/fpdf.php';
require($fpdffile);

//require('mpdf57/mpdf.php');
//class InvoicePDF extends \applib\mpdf57\mPDF {
class InvoicePDF extends FPDF {
	private $PG_W = 290;
        private $leftMargin = 3;
        private $topMargin = 0;
        private $rightMargin = 0;
        private $orientaion = 'L';
        
        public $config;
        public $compTitle = 'Not Set';
        public $compAddr = 'Not Set';
        
        public $pdfforinv = true;
        public $ofWhom = 'List';
        public $invType;
        public $invNO;
        public $invAmount;
        public $partyName;
        public $partyAddress;
        public $orders;
        public $enableordrtasks;
        public $ordertasks;
        public $purchases;
        public $scamount;
        
        public $header;
        public $headercount;
        
	public function __construct($config, $myData = NULL, $ispdfforinv = true, $orientation = 'P') 
        {
            parent::__construct();
            $this->SetMargins($this->leftMargin,$this->topMargin);
            $this->orientaion = $orientation;
            if($orientation === 'P')
            {
                $this->PG_W = 190;
            }
            else
            {
                $this->PG_W = 290;
            }
            $this->prepareInvoice($config, $myData, $ispdfforinv);
	}
	public function Header()
        {
            $this->SetFont('Arial', 'B', 16);
            $this->Cell($this->PG_W, 8, $this->compTitle, 0, 0, 'C');
            $this->Ln();
            if(!$this->pdfforinv)
            {
                $this->SetFont('Arial', 'B', 12);
                $this->Cell($this->PG_W, 8, 'Jobs List', 0, 0, 'C');
                $this->Ln();
                return;
            }
            $this->Cell($this->PG_W, 5, "INVOICE", 0, 0, 'L');
            $this->Ln(10);

            $this->SetFont('Arial', 'B', 12);

            $this->Cell($this->PG_W / 4, 5, "Invoice Number:", 0, 0, 'L');
            $this->Cell($this->PG_W / 4, 5, $this->invNO, 0, 0, 'L');
            $this->Cell($this->PG_W / 4, 5, (($this->invType === 'Receivables')?"To:":"From"), 0, 0, 'L');
            $this->Cell($this->PG_W / 4, 5, $this->partyName, 0, 0, 'L');

            $this->Ln();

            $this->Cell($this->PG_W / 4, 5, "Invoice Date:", 0, 0, 'L');
            $this->Cell($this->PG_W / 4, 5, date("d/m/Y", time()), 0, 0, 'L');		
            $this->Cell($this->PG_W / 4, 5, "Address:", 0, 0, 'L');
            //$tmpaddr = "1 Some Road\nSome Town\nPost Code";
            if(!empty($this->partyAddress))
            {
                $tmpaddr = $this->partyAddress->street . "\n" . $this->partyAddress->pincode;    
            }
            else
            {
                $tmpaddr = 'N/A';
            }
            $this->MultiCell($this->PG_W / 4, 5, $tmpaddr, 0, 'L');		

            $this->Ln(10);
	}
        public function Footer() {
                if(!$this->pdfforinv) return;
		$this->Ln();
		$this->Cell($this->PG_W, 5, "Payment Terms: " . "On Receipt", 0, 0, 'L');
		$this->Ln(10);
		$this->Cell($this->PG_W, 5, "Please make cheques payable to $this->compTitle.", 0, 0, 'L');
		$this->Ln(10);		
		$this->setTextFont(true);

		$this->Cell($this->PG_W, 5, "Payment Details:", 0, 0, 'L');
		$this->setTextFont(false);
		$this->Ln();
		$this->Cell($this->PG_W, 5, "Bank A/C No: 000000000", 0, 0, 'L');
		$this->Ln();
		
		// Footer address
		
		$compAddr = $this->compAddr;
		
		$this->SetY(-(($this->getAddressLength($compAddr) * 5) + 20));

		$this->SetFont('Arial', '', 7);
		
		$this->Ln();
		$this->writeAddress($compAddr);
	}
	private function prepareInvoice($config, $myData, $ispdfforinv)
        {
            if(!isset($myData))
            {
                return;
            }
            if(!isset($config))
            {
                $config = array($config);
            }
            if(!is_array($config))
            {
                $config = array("config" => $config);
            }
            $this->config = $config;
            $this->pdfforinv = isset($ispdfforinv)?$ispdfforinv:$this->pdfforinv;
            $this->compTitle = Yii::app()->user->company->name;
            $this->compAddr = Yii::app()->user->company->address;
            
            if($this->pdfforinv)
            {
                $this->invType = $myData->accounttype;
                $this->invNO = $myData->acnt_no;
                $this->invAmount = $myData->amount;
                $this->partyName = $myData->party->name;
                if(!empty($myData->party->myaddresses))
                {
                    $this->partyAddress = $myData->party->myaddresses[0];
                }
                else
                {
                   $this->partyAddress = null;
                }
                $this->orders = $myData->orders;
                $this->ordertasks = $myData->ordertasks;
                //$this->purchases = $myData->purchases;
                $this->scamount = $myData->scamount;
                if(Yii::app()->controller->getMoperinvoice())
                {
                    $this->MultiordersLineItems();
                }
                else
                {
                    if($this->orders[0]->enableordrprd)
                    {
                        $this->OrderproductsLineItems();
                    }
                    else if($this->orders[0]->enableordrtasks)
                    {
                        if(strtolower($this->invType) === strtolower(Helper::CONST_Payables))
                        {
                            $this->OrdertasksLineItems();
                        }else{
                            $this->MultiordersLineItemsII();
                        }
                    }
                }
            }else
            {
                $this->orders = $myData->orders;
                $this->ofWhom = isset($myData->ofWhom)?$myData->ofWhom:$this->ofWhom;            
                $this->OrderslistLineItems();
            }
        }
	private function OrderproductsLineItems(){
		$this->header = array("No.", "Item ID", "Description", "Unit Price", "Qty.", "Amount","Discounted");
                $this->headercount = count($this->header);
                
		$data = array();
		$count = 1;
                $ttlqnty = 0;
                $ttlamnt = 0;
                $ttldisc = 0;
                foreach ($this->orders[0]->orderproducts as $li) {
                    $dtls = $li->product->name;//utf8_decode($str)
                    $dtls .= (($li->product->enableprdauxname && !empty($li->product->auxname))?'(' . iconv("UTF-8", "ISO-8859-7", $li->product->auxname) .  ')':'');
                    $dtls .= ' ' . ((!empty($li->product->desc))?$li->product->desc:'');
                    $data[] = array($count++, $li->product->code, $dtls, $li->unit_sp, $li->quantity, $li->amount, $li->disc);
                    $ttlqnty += $li->quantity;
                    $ttlamnt += $li->amount;
                    $ttldisc += $li->disc;
                }

		/* Layout */
		
		$this->SetDataFont();
		$this->AddPage($this->orientaion);

		// Headers and widths
		
		$w = array(10, 20, 85, 20, 20, 20, 20);

		for($i = 0; $i < $this->headercount; $i++) {
			$this->Cell($w[$i], $this->headercount + 1, $this->header[$i], 1, 0, 'C');
		}

                $this->Ln();
		// Mark start coords
                $h = array(12);//for three lines height
		$x = $this->GetX();
		$y = $this->GetY();
		for ($r = 0; $r < count($data); $r++) {
                    $row = $data[$r];
                    $x = $this->GetX();
                    for ($col = 0; $col < count($w); $col++) {
                        $cellvalue = $row[$col];
                        $cellwidth = $w[$col];
                        $lineheight = $h[0];
                        $borders = 'LB' . ($col + 1 == count($w) ? 'R' : ''); // Only add R for last col
                        $align ='J';
                        if($col == 2){
                           list($t1,$t2) = explode("(", $cellvalue);
                           $cellvalue = $t1 . "\n" . (empty($t2)?'':'('.$t2);
                           $this->getlineheight($cellvalue, $lineheight);
                        }
                        if($col == 3 || $col == 4 || $col == 5 || $col == 6){
                            $cellvalue = number_format($cellvalue, 2);
                            $align = 'R';
                        }
                        $yBeforeCell = $this->GetY();
                        $this->MultiCell($cellwidth, $lineheight, $cellvalue, $borders, $align);
                        $yCurrent = $this->GetY();
                        $rowHeight = $yCurrent - $yBeforeCell;
                        $this->SetXY($x + $cellwidth, $yCurrent - $rowHeight);
                        $x = $this->GetX();
                    }
                    $this->Ln($rowHeight); // Line-feed at last cell height to start a new row
		}
		$this->Ln(10);
		$this->setTextFont();
                $ttlcellwidth = 0;
                $i = 0;
                for($i = 0; $i < count($w); $i++) {
                    $ttlcellwidth += $w[$i];
		}                
		$this->Cell($ttlcellwidth - $w[4] - $w[5] - $w[6], $this->headercount, 'Total', 'TB', 0, 'L');
		$this->setDataFont(true);
                $this->Cell($w[4], $this->headercount, number_format($ttlqnty, 2), 'TB', 0, 'R');
		$this->Cell($w[5], $this->headercount, number_format($ttlamnt, 2), 'TB', 0, 'R');
                $this->Cell($w[6], $this->headercount, number_format($ttldisc, 2), 'TB', 0, 'R');
		$this->Ln();
                
                if($this->scamount > 0){
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[5], $this->headercount, 'Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[5], $this->headercount, number_format($this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                    
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[5], $this->headercount, 'NET Incl.Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[5], $this->headercount, number_format($ttlamnt + $this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                }
                
		$this->setTextFont();
		$this->Write(10, "Notes: " . "Thank you for your business.");
		$this->Ln(10);
	}
        private function OrdertasksLineItems(){
            $this->header = array("No.", "Project", "Task", "Amount");
            $this->headercount = count($this->header);
                
		$data = array();
		$count = 1;
                $ttlqnty = 0;
                $ttlamnt = 0;
                $ttldisc = 0;
                foreach ($this->ordertasks as $li) {
                    $dtls = $li->task->name;
                    $data[] = array($count++, $this->orders[0]->name, $dtls, $li->cost);
                    $ttlamnt += $li->cost;
                }

		/* Layout */
		
		$this->SetDataFont();
		$this->AddPage($this->orientaion);

		// Headers and widths
		
		$w = array(10, 75, 75, 20);

		for($i = 0; $i < $this->headercount; $i++) {
			$this->Cell($w[$i], $this->headercount + 1, $this->header[$i], 1, 0, 'C');
		}

		$this->Ln();

		// Mark start coords

		$x = $this->GetX();
		$y = $this->GetY();
		foreach($data as $row)
		{
                    $y1 = $this->GetY();
                    $this->MultiCell($w[0], $this->headercount, $row[0], 'LRB');	
                    $y2 = $this->GetY();
                    $yH = $y2 - $y1;

                    $this->SetXY($x + $w[0], $this->GetY() - $yH);

                    $this->Cell($w[1], $yH, $row[1], 'LRB');
                    $this->Cell($w[2], $yH, $row[2], 'LRB');                    
                    $this->Cell($w[3], $yH, number_format($row[3], 2), 'LRB', 0, 'R');

                    $this->Ln();			
		}
		
		$this->Ln(10);
		$this->setTextFont();
                $ttlcellwidth = 0;
                $i = 0;
                for($i = 0; $i < count($w); $i++) {
                    $ttlcellwidth += $w[$i];
		}
		$this->Cell($ttlcellwidth - $w[3], $this->headercount, 'Total', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[3], $this->headercount, number_format($ttlamnt + $ttldisc, 2), 'TB', 0, 'R');
		
                $this->Ln();
                $this->setTextFont();		
                $this->Cell($ttlcellwidth - $w[3], $this->headercount, 'Discount', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[3], $this->headercount, number_format($ttldisc, 2), 'TB', 0, 'R');
		$this->Ln();
                
                $this->setTextFont();
		$this->Cell($ttlcellwidth - $w[3], $this->headercount, 'After Discount', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[3], $this->headercount, number_format($ttlamnt, 2), 'TB', 0, 'R');
		$this->Ln();
                
                if($this->scamount > 0){
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[3], $this->headercount, 'Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[3], $this->headercount, number_format($this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                    
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[3], $this->headercount, 'NET Incl.Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[3], $this->headercount, number_format($ttlamnt + $this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                }
                
		$this->setTextFont();
		$this->Write(10, "Notes: " . "Thank you for your business.");
		$this->Ln(10);
        }
        private function MultiordersLineItems() {
                //No. consignment	DateTime	To	Amount
		$this->header = array("No.", "Consign.", "Date&Time", "To", "Amount");
                $this->headercount = count($this->header);
		
                $ttlamnt = 0;
                foreach ($this->orders as $li) {
                    $ttlamnt += $li->amount;
                }
                $ttlamnt += $this->scamount;
                $data = array();
                $count = 1;
                $ttldisc = 0;
//		if(isset($this->invAmount)  gsm ??? theriyalai
//                        && $this->invAmount > 0 
//                        && $this->invAmount != $ttlamnt){
//                    $addnlinfo = $this->orders[0]->addnlinfo;
//                    $addnlinfo1 = $this->formatAddnlinfo1($this->orders[0]->addnlinfo1, 'To');                    
//                    //$addnlinfo1 = $this->orders[0]->addnlinfo1;
//                    $to = $this->orders[0]->shpngaddresses[0]->street . "\r\n" . $this->orders[0]->shpngaddresses[0]->pincode;
//                    $amount = $this->invAmount;
//                    $data[] = array($count++, $addnlinfo, $addnlinfo1, $to, $amount);
//                    $ttlamnt = $amount;
//                }else
                {
                    $ttlamnt = 0;
                    $ttldisc = 0;
                    foreach ($this->orders as $li) {
                        $addnlinfo = $li->addnlinfo;
                        $addnlinfo1 = $this->formatAddnlinfo1($li->addnlinfo1, 'To');
                        //$addnlinfo1 = $li->addnlinfo1;
                        if(empty($li->shpngaddresses))
                        {
                            $to = $li->shpngaddresses[0]->street . "\r\n" . $li->shpngaddresses[0]->pincode;   
                        }
                        else
                        {
                            $to = 'N/A';
                        }
                        $amount = $li->amount;
                        $data[] = array($count++, $addnlinfo, $addnlinfo1, $to, $amount);
                        $ttlamnt += $amount;
                        $ttldisc += (($li->disc < 0)?0:$li->disc);
                    }
                }

		/* Layout */		
		$this->SetDataFont('B');
		$this->AddPage($this->orientaion);
		// Headers and widths		
		$w = array(10, 20, 50, 90, 20);
		for($i = 0; $i < $this->headercount; $i++) {
			$this->Cell($w[$i], $this->headercount + 1, $this->header[$i], 1, 0, 'C');
		}
		$this->Ln();
		// Mark start coords
                $h = array(12);//for three lines height
		$x = $this->GetX();
		$y = $this->GetY();                
		for ($r = 0; $r < count($data); $r++) {
                    $row = $data[$r];
                    $x = $this->GetX();
                    for ($col = 0; $col < count($w); $col++) {
                        $cellvalue = $row[$col];
                        $cellwidth = $w[$col];
                        $lineheight = $h[0];
                        $borders = 'LB' . ($col + 1 == count($w) ? 'R' : ''); // Only add R for last col
                        $align ='J';
                        if($col == 3 || $col == 2){
                            $this->getlineheight($cellvalue, $lineheight);
                        }
                        if($col == 4){
                            $cellvalue = number_format($cellvalue, 2);
                            $align = 'R';
                        }
                        $yBeforeCell = $this->GetY();
                        $this->MultiCell($cellwidth, $lineheight, $cellvalue, $borders, $align);
                        $yCurrent = $this->GetY();
                        $rowHeight = $yCurrent - $yBeforeCell;
                        $this->SetXY($x + $cellwidth, $yCurrent - $rowHeight);
                        $x = $this->GetX();
                    }
                    $this->Ln($rowHeight); // Line-feed at last cell height to start a new row
		}
		$this->Ln(10);
		$this->setTextFont();
                $ttlcellwidth = 0;
                $i = 0;
                for($i = 0; $i < count($w); $i++) {
                    $ttlcellwidth += $w[$i];
		}
		$this->Cell($ttlcellwidth - $w[4], $this->headercount, 'Total', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[4], $this->headercount, number_format($ttlamnt + $ttldisc, 2), 'TB', 0, 'R');
		$this->Ln();
                
                $this->setTextFont();
		$this->Cell($ttlcellwidth - $w[4], $this->headercount, 'Discount', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[4], $this->headercount, number_format($ttldisc, 2), 'TB', 0, 'R');
		$this->Ln();
                
                $this->setTextFont();
		$this->Cell($ttlcellwidth - $w[4], $this->headercount, 'After Discount', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[4], $this->headercount, number_format($ttlamnt, 2), 'TB', 0, 'R');
		$this->Ln();
                
                if($this->scamount > 0){
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[4], $this->headercount, 'Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[4], $this->headercount, number_format($this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                    
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[4], $this->headercount, 'NET Incl.Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[4], $this->headercount, number_format($ttlamnt + $this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                }
                
		$this->setTextFont();
		$this->Write(10, "Notes: " . "Thank you for your business.");
		$this->Ln(10);
	}
        private function MultiordersLineItemsII() {
		$this->header = array("No.", "Project", "Amount");
                $this->headercount = count($this->header);
                
                $ttlamnt = 0;
                foreach ($this->orders as $li) {
                    $ttlamnt += $li->amount;
                }
                $ttlamnt += $this->scamount;
                $data = array();
                $count = 1;
                $ttldisc = 0;
		if(isset($this->invAmount) 
                        && $this->invAmount > 0 
                        && $this->invAmount !== $ttlamnt){
                    $prjname = $this->orders[0]->name;
                    $amount = $this->invAmount;
                    $data[] = array($count++, $prjname, $amount);
                    $ttlamnt = $amount;
                }else{
                    $ttlamnt = 0;
                    $ttldisc = 0;
                    foreach ($this->orders as $li) {
                        $prjname = $li->name;
                        $amount = $li->amount;
                        $data[] = array($count++, $prjname, $amount);
                        $ttlamnt += $amount;
                        $ttldisc += $li->disc;
                    }
                }
		
		/* Layout */		
		$this->SetDataFont();
		$this->AddPage($this->orientaion);
		// Headers and widths		
		$w = array(10, 150, 30);
		for($i = 0; $i < $this->headercount; $i++) {
			$this->Cell($w[$i], $this->headercount + 1, $this->header[$i], 1, 0, 'C');
		}
		$this->Ln();
		// Mark start coords
                $h = array(12);//for three lines height
		$x = $this->GetX();
		$y = $this->GetY();                
		for ($r = 0; $r < count($data); $r++) {
                    $row = $data[$r];
                    $x = $this->GetX();
                    for ($col = 0; $col < count($w); $col++) {
                        $cellvalue = $row[$col];
                        $cellwidth = $w[$col];
                        $lineheight = $h[0];
                        $borders = 'LB' . ($col + 1 == count($w) ? 'R' : ''); // Only add R for last col
                        $align ='J';                        
                        if($col == 2){
                            $cellvalue = number_format($cellvalue, 2);
                            $align = 'R';
                        }
                        $yBeforeCell = $this->GetY();
                        $this->MultiCell($cellwidth, $lineheight, $cellvalue, $borders, $align);
                        $yCurrent = $this->GetY();
                        $rowHeight = $yCurrent - $yBeforeCell;
                        $this->SetXY($x + $cellwidth, $yCurrent - $rowHeight);
                        $x = $this->GetX();
                    }
                    $this->Ln($rowHeight); // Line-feed at last cell height to start a new row
		}
		$this->Ln(10);
		$this->setTextFont();
                $ttlcellwidth = 0;
                $i = 0;
                for($i = 0; $i < count($w); $i++) {
                    $ttlcellwidth += $w[$i];
		}
		$this->Cell($ttlcellwidth - $w[2], $this->headercount, 'Total', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[2], $this->headercount, number_format($ttlamnt + $ttldisc, 2), 'TB', 0, 'R');
		$this->Ln();
                
                $this->setTextFont();
		$this->Cell($ttlcellwidth - $w[2], $this->headercount, 'Discount', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[2], $this->headercount, number_format($ttldisc, 2), 'TB', 0, 'R');
		$this->Ln();
                
                $this->setTextFont();
		$this->Cell($ttlcellwidth - $w[2], $this->headercount, 'After Discount', 'TB', 0, 'L');
		$this->setDataFont(true);
		$this->Cell($w[2], $this->headercount, number_format($ttlamnt, 2), 'TB', 0, 'R');
		$this->Ln();
                
                if($this->scamount > 0){
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[4], $this->headercount, 'Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[4], $this->headercount, number_format($this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                    
                    $this->setTextFont();
                    $this->Cell($ttlcellwidth - $w[4], $this->headercount, 'NET Incl.Surcharge', 'TB', 0, 'L');
                    $this->setDataFont(true);
                    $this->Cell($w[4], $this->headercount, number_format($ttlamnt + $this->scamount, 2), 'TB', 0, 'R');
                    $this->Ln();
                }
                
		$this->setTextFont();
		$this->Write(10, "Notes: " . "Thank you for your business.");
		$this->Ln(10);
	}
        private function formatAddnlinfo1($addnlinfo1, $seperator = 'To')
        {
            $lines = explode('-', $addnlinfo1);
            if(count($lines) > 1)
            {
              $addnlinfo1 = $lines[0] . $seperator . "\r\n" . $lines[1];  
            }else if(count($lines) === 1)
            {
                $addnlinfo1 = $lines[0];
            }else
            {
                $addnlinfo1 = '';
            }
            return $addnlinfo1;
        }
        private function OrderslistLineItems() {
		$this->header = array("No.", "Consign.", "Date&Time", "Sender", "From", "To", "Rider");
                $this->headercount = count($this->header);
                
		$data = array();
		$count = 1;
                foreach ($this->orders as $li) {
                    $addnlinfo = $li->addnlinfo;
//                    $datetime = new \DateTime($li->addnlinfo1);
//                    $datestr = $datetime->format('Y-m-d H:i');
                    $addnlinfo1 = $this->formatAddnlinfo1($li->addnlinfo1, 'To');
                    //$addnlinfo1 = $li->addnlinfo1;
                    $sender = $li->ordrcustomers[0]->name;
                    if(empty($li->blngaddresses))
                    {
                        $from = $li->blngaddresses[0]->street . "\r\n" . $li->blngaddresses[0]->pincode;   
                    }
                    else
                    {
                        $from = 'N/A';
                    }
                    if(empty($li->shpngaddresses))
                    {
                        $to = $li->shpngaddresses[0]->street . "\r\n" . $li->shpngaddresses[0]->pincode;   
                    }
                    else
                    {
                        $to = 'N/A';
                    }
                    $rider = (!empty($li->employee)?$li->employee->name:'');
                    $data[] = array($count++, $addnlinfo, $addnlinfo1, $sender, $from, $to, $rider);
                }

		/* Layout */		
		$this->setTextFont(true);
		$this->AddPage($this->orientaion);
		// Headers and widths
		$w = array(10, 20, 50, 50, 60, 60, 40);
		for($i = 0; $i < $this->headercount; $i++) {
                    $this->Cell($w[$i], $this->headercount + 1, $this->header[$i], 1, 0, 'C');
		}
		$this->Ln();
                $this->setTextFont();
                // Mark start coords
                $h = array(12);//for three lines height
		$x = $this->GetX();
		$y = $this->GetY();                
		for ($r = 0; $r < count($data); $r++) {
                    $row = $data[$r];
                    $x = $this->GetX();
                    for ($col = 0; $col < count($w); $col++) {
                        $cellvalue = $row[$col];
                        $cellwidth = $w[$col];
                        $lineheight = $h[0];
                        $borders = 'LB' . ($col + 1 == count($w) ? 'R' : ''); // Only add R for last col
                        $align ='J';
                        if($col == 2 || $col == 3 || $col == 4 || $col == 5){
                            $this->getlineheight($cellvalue, $lineheight);                            
                        }
                        $yBeforeCell = $this->GetY();
                        $this->MultiCell($cellwidth, $lineheight, $cellvalue, $borders, $align);
                        $yCurrent = $this->GetY();
                        $rowHeight = $yCurrent - $yBeforeCell;
                        $this->SetXY($x + $cellwidth, $yCurrent - $rowHeight);
                        $x = $this->GetX();
                    }
                    $this->Ln($rowHeight); // Line-feed at last cell height to start a new row
		}
		$this->Ln(10);
	}
        private function getlineheight($multiline, &$lineheight){
            $lines = explode("\n", $multiline);
            $lc = count($lines);
            if(empty($lines[$lc-1])){
                $lc = $lc -1;
            }
            if($lc > 1){
                $lineheight = $lineheight / $lc;
            }
        }
	private function setTextFont($isBold = false) {
		$this->SetFont('Arial', $isBold ? 'B' : '', 10);
	}
	
	private function setDataFont($isBold = false) {
		$this->SetFont('Courier', $isBold ? 'B' : '', 10);
	}

	private function getAddressLength($address) {
		return count(explode("\n", $address));
	}
		
	private function writeAddress($address) {
		$lines = explode("\n", $address);
		foreach ($lines as $line) {
			$this->Cell($this->PG_W, $this->headercount, $line, 0, 0, 'C');
			$this->Ln(4);
		}
	}
        public function writeOutput($usempdf = true){
            if($usempdf){
                $this->writeByMpdf();
            }else{
                $this->Output(); 
            }
        }
        private function writeByMpdf(){
            $tmpfile = 'logs/temp_' . str_replace('/', '_', $this->invNO)  . '.pdf';
            $this->Output($tmpfile,'F');
            include_once ('mpdf/mpdf.php');
            $mpdf=new \mPDF('','','','',15,15,57,16,9,9); 

            $mpdf->SetImportUse();
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetCompression(false);
            $pagecount = $mpdf->SetSourceFile($tmpfile);
            for ($i=1; $i<=$pagecount; $i++) {
                $tplIdx = $mpdf->ImportPage($i);
                $mpdf->UseTemplate($tplIdx);
                if ($i < $pagecount)
                    $pdf->AddPage($this->orientaion);
            }
            $mpdf->Output();
            unlink($tmpfile);
//            $newfile = $this->invNO . '.pdf';
//            $mpdf->Output($newfile, 'I');
        }
}
