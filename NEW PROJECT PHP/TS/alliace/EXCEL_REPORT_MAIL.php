<?php
require_once('mpdf571/mpdf571/mpdf.php');
require_once('PHPExcel/Classes/PHPExcel.php');
require "PHPMailer/PHPMailerAutoload.php";
include "CONNECTION.php";
include "CONFIG.php";
include "COMMON_FUNCTIONS.php";
$parentfolder=get_parentfolder_id();
$userfolderid=get_emp_folderid($ure_uld_id);
$currentdate=date("Y-m-d");//CURRENT DATE


$result = $con->query("CALL SP_TS_REPORT_DETAILS('$currentdate','dhandapani.sattanathan@ssomens.com',@temp_table)");
if(!$result) die("CALL failed: (" . $con->errno . ") " . $con->error);
$select = $con->query('SELECT @temp_table');
$result = $select->fetch_assoc();
$temp_table_name= $result['@temp_table'];
$query="select * from $temp_table_name";
$query1="select EMPLOYEE_NAME,REPORT_DATE,REPORT,REASON,PROJECT_NAME,ATTENDANCE,SESSION,PERMISSION from $temp_table_name";
$sql=mysqli_query($con,$query);
$row=mysqli_num_rows($sql);
$x=$row;
if($x>0){
    if ($result = mysqli_query($con,$query1) or die(mysql_error())) {
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        /** Create a new PHPExcel object 1.0 */
        $objPHPExcel->getActiveSheet()->setTitle('Data')->setCellValue('A1', 'EMPLOYEE NAME')->setCellValue('B1', 'DATE')->setCellValue('C1', 'REPORT')->setCellValue('D1', 'REASON')->setCellValue('E1', 'PROJECT')->setCellValue('F1', 'ATTENDANCE')->setCellValue('G1', 'SESSION')->setCellValue('H1', 'PERMISSION');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
    //add data
    /** Loop through the result set 1.0 */
    $rowNumber = 2; //start in cell 1
    while ($row = mysqli_fetch_row($result)) {
        $col = 'A'; // start at column A
        foreach($row as $cell) {
            $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
            $col++;
        }
        $rowNumber++;
    }
    $drop_query="DROP TABLE $temp_table_name ";
    mysqli_query($con,$drop_query);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="simple.xls"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://temp');
    $data=ob_get_contents();

//    $data = file_get_contents($path."ALLIANCE TS ENTRY REPORT.xls");
    $reportfilename='ALLIANCE TS ENTRY REPORT '.date("d-m-Y").'.xls';

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "safiyullah84@gmail.com";
    $mail->Password = "safi984151";
    $mail->SetFrom("safiyullah84@gmail.com");
    $mail->Subject = $mail_subject;
    $mail->Body = $sub.$values;
    $mail->AddAddress("raja.gunasekaran@ssomens.com");
    $mail->addAttachment($reportfilename,$data);
    if(!$mail->Send()){
        $flag=0;
    }else{
        $flag=1;
    }

//    $message1 = new Message();
//    $message1->setSender('safiyullah.mohideen@ssomens.com');
//    $message1->addTo('raja.gunasekaran@ssomens.com');
////    $message1->addCc('safiyullah.mohideen@ssomens.com');
//    $message1->setSubject('xcel');
//    $message1->setHtmlBody('excell');
//    $message1->addAttachment($reportfilename,$data);
//    $message1->send();
//    unlink($path."ALLIANCE TS ENTRY REPORT.xls");
}