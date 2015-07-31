<?php
error_reporting(0);
$dir=dirname(__FILE__).DIRECTORY_SEPARATOR;
include "CONNECTION.php";
include "GET_USERSTAMP.php";
include "COMMON.php";
date_default_timezone_set('Asia/Singapore');
$USERSTAMP=$UserStamp;
$parentfolder=get_parentfolder_id();
if($_REQUEST["option"]=="DATE")
{
    $date=$_REQUEST['date_change'];
    $ure_date=date('Y-m-d',strtotime($date));
    $uld_id=mysqli_query($con,"select ULD_ID from USER_LOGIN_DETAILS where ULD_LOGINID='$USERSTAMP'");
    while($row=mysqli_fetch_array($uld_id)){
        $ure_uld_id=$row["ULD_ID"];
    }
    $sql="SELECT * FROM USER_ADMIN_REPORT_DETAILS WHERE ULD_ID='$ure_uld_id' AND UARD_DATE='$ure_date'";
    $sql_result= mysqli_query($con,$sql);
    $row=mysqli_num_rows($sql_result);
    $x=$row;
    if($x > 0)
    {
        $flag=1;
    }
    else{
        $flag=0;
    }
    echo $flag;
}
if($_POST["option"]=="SINGLE DAY ENTRY")
{
    if(isset($_POST["option"])){
        $date = $_POST['URE_tb_date'];
        $seconddate="null";
        $attendance=$_POST['URE_lb_attendance'];
        $per_checbx=$_POST['permission'];
        $perm_time=$_POST['URE_lb_timing'];
        $session=$_POST['URE_lbl_session'];
        $project=$_POST['URE_selproject'];
        $reason=$_POST['URE_ta_reason'];
        $report=$_POST['URE_ta_report'];
        $bandwidth=$_POST['URE_tb_band'];
        $ampm=$_POST['URE_lb_ampm'];
        $project=$_POST['checkbox'];
        $finaldate = date('Y-m-d',strtotime($date));
    }
    $imagedata=$_POST['string'];
    $uploadcount=$_POST['upload_count'];
    $doc_folder=$dir.'ATS_DOCUMENT'.DIRECTORY_SEPARATOR;
    $upload_file_array=array();
    for($x=0;$x<$uploadcount;$x++)
    {
        move_uploaded_file($_FILES['upload_filename'.$x]['tmp_name'],$doc_folder.$_FILES['upload_filename'.$x]['name']);
        $upload_file_array[]=$_FILES['upload_filename'.$x]['name'];
    }
    $upload_filename='';
    for($y=0;$y<count($upload_file_array);$y++)
    {
        if($upload_file_array[$y]!='')
        {
            if($y==0)
            {
                $upload_filename=$upload_file_array[$y];
            }
            else{
                $upload_filename=$upload_filename.'/'.$upload_file_array[$y];
            }
        }
    }
    if(($attendance=="1") || (($attendance=="0") && (($ampm=="AM") || ($ampm=="PM"))) || (($attendance=="OD") && (($ampm=="AM") || ($ampm=="PM")))){
        $logname=mysqli_query($con,"SELECT ULD_ID FROM VW_TS_ALL_EMPLOYEE_DETAILS WHERE ULD_LOGINID='$USERSTAMP'");
        while($row=mysqli_fetch_array($logname)){
            $loginid=$row["ULD_ID"];
        }
        $userfolderid=get_emp_folderid($loginid);
        $daterep=str_replace('-','',$date);
        $filename=$loginid.'_'.$daterep.'_'.date('His');
        $upload_dir = $dir.$parentfolder.DIRECTORY_SEPARATOR.$userfolderid.DIRECTORY_SEPARATOR;
        $file = $upload_dir.$filename.".png";
        try{
            $data=str_replace('data:image/png;base64,','',$imagedata);
            $data = str_replace(' ','+',$data);
            $data = base64_decode($data);
            $success = file_put_contents($file, $data);
            $fileflg=1;
        }
        catch(Exception $e){
            print $e->getMessage();
            $fileflg=0;
        }
    }
    elseif((($attendance=="0") && ($ampm=="FULLDAY")) || (($attendance=="OD") && ($ampm=="FULLDAY"))){
        $fileflg=1;
    }
    if($perm_time=='SELECT')
    {
        $perm_time='';
    }
    else
    {
        $perm_time=$perm_time;
    }
    $length=count($project);
    $projectid;
    for($i=0;$i<$length;$i++){
        if($i==0){
            $projectid=$project[$i];
        }
        else{
            $projectid=$projectid .",".$project[$i];
        }
    }
    $projectid;
    $urc_id=mysqli_query($con,"SELECT URC_ID FROM VW_ACCESS_RIGHTS_TERMINATE_LOGINID WHERE ULD_LOGINID='$USERSTAMP'");
    while($row=mysqli_fetch_array($urc_id)){
        $ure_urc_id=$row["URC_ID"];
    }
    $uld_id=mysqli_query($con,"select ULD_ID from USER_LOGIN_DETAILS where ULD_LOGINID='$USERSTAMP'");
    while($row=mysqli_fetch_array($uld_id)){
        $ure_uld_id=$row["ULD_ID"];
    }
    $present=mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID='1'");
    while($row=mysqli_fetch_array($present)){
        $ure_present_data=$row["AC_DATA"];
    }
    $absent=mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID='2'");
    while($row=mysqli_fetch_array($absent)){
        $ure_absent_data=$row["AC_DATA"];
    }
    $onduty=mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID='3'");
    while($row=mysqli_fetch_array($onduty)){
        $ure_onduty_data=$row["AC_DATA"];
    }
// for present radio button
    if($attendance=="1")
    {
        $report;
        $uard_morning_session=$ure_present_data;
        $uard_afternoon_session =$ure_present_data;
        $projectid;
        $reason='';
        $filename;
    }
//  for onduty radio button
    if($attendance=="OD")
    {
        if($ampm=="AM")
        {
            $uard_morning_session =$ure_onduty_data;
            $uard_afternoon_session =$ure_present_data;
            $reason;
            $projectid;
            $report;
            $filename;
        }
        elseif($ampm=="PM")
        {
            $uard_morning_session =$ure_present_data;
            $uard_afternoon_session =$ure_onduty_data;
            $reason;
            $projectid;
            $report;
            $filename;
        }
        elseif($ampm=="FULLDAY")
        {

            $reason;
            $uard_morning_session=$ure_onduty_data;
            $uard_afternoon_session =$ure_onduty_data;
            $report='';
            $filename='';
            $projectid='';
        }
    }
// for absent radio button
    if($attendance=="0")
    {
        if($ampm=="AM")
        {
            $uard_morning_session =$ure_absent_data;
            $uard_afternoon_session =$ure_present_data;
            $reason;
            $projectid;
            $report;
            $filename;
        }
        elseif($ampm=="PM")
        {
            $uard_morning_session =$ure_present_data;
            $uard_afternoon_session =$ure_absent_data;
            $reason;
            $projectid;
            $report;
            $filename;
        }
        elseif($ampm=="FULLDAY")
        {

            $reason;
            $uard_morning_session=$ure_absent_data;
            $uard_afternoon_session =$ure_absent_data;
            $report='';
            $filename='';
            $projectid='';
        }
    }
    if($attendance=="1")
    {
        $attend= mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID =5 AND CGN_ID='3'");
        while($row=mysqli_fetch_array($attend)){
            $ure_attendance=$row["AC_DATA"];
        }
    }
    if(($attendance=="0") && (($ampm=="AM") || ($ampm=="PM")))
    {
        $attend= mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID =4 AND CGN_ID='3'");
        while($row=mysqli_fetch_array($attend)){
            $ure_attendance=$row["AC_DATA"];
        }
    }
    elseif(($attendance=="0") && ($ampm=="FULLDAY"))
    {
        $attend= mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID =6 AND CGN_ID='3'");
        while($row=mysqli_fetch_array($attend)){
            $ure_attendance=$row["AC_DATA"];
        }
    }
    if(($attendance=="OD") && (($ampm=="AM") || ($ampm=="PM")))
    {
        $attend= mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID =8 AND CGN_ID='3'");
        while($row=mysqli_fetch_array($attend)){
            $ure_attendance=$row["AC_DATA"];
        }
    }
    elseif(($attendance=="OD") && ($ampm=="FULLDAY"))
    {
        $attend= mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID =7 AND CGN_ID='3'");
        while($row=mysqli_fetch_array($attend)){
            $ure_attendance=$row["AC_DATA"];
        }
    }
    $report= $con->real_escape_string($report);
    $reason= $con->real_escape_string($reason);
    if($fileflg!=0){
        $result = $con->query("CALL SP_TS_DAILY_REPORT_INSERT('$report','$reason','$finaldate',$seconddate,$ure_urc_id,'$USERSTAMP','$perm_time','$ure_attendance','$projectid','$uard_morning_session','$uard_afternoon_session','$filename','$upload_filename','$USERSTAMP',@success_flag)");
        if(!$result){
            unlink($file);
            die("CALL failed: (" . $con->errno . ") " . $con->error);
        }
        $select = $con->query('SELECT @success_flag');
        $result = $select->fetch_assoc();
        $flag= $result['@success_flag'];
        if($flag!=1 && $file!='')
        {
            unlink($file);
        }
    }
    echo $flag;
}
if($_POST["option"]=="MULTIPLE DAY ENTRY")
{
    $firstdate = $_POST['URE_ta_fromdate'];
    $seconddate=$_POST['URE_ta_todate'];
    $attendance=$_POST['URE_lb_attdnce'];
    $perm_time='';
    $project='';
    $reason=$_POST['URE_ta_reason'];
    $report='';
    $filename='';
    $project='';
    $fdate = date('Y-m-d',strtotime($firstdate));
    $tdate = date('Y-m-d',strtotime($seconddate));
    $urc_id=mysqli_query($con,"SELECT URC_ID FROM VW_ACCESS_RIGHTS_TERMINATE_LOGINID WHERE ULD_LOGINID='$USERSTAMP'");
    while($row=mysqli_fetch_array($urc_id)){
        $ure_urc_id=$row["URC_ID"];
    }
    $uld_id=mysqli_query($con,"select ULD_ID from USER_LOGIN_DETAILS where ULD_LOGINID='$USERSTAMP'");
    while($row=mysqli_fetch_array($uld_id)){
        $ure_uld_id=$row["ULD_ID"];
    }
    $absent=mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID='2'");
    while($row=mysqli_fetch_array($absent)){
        $ure_absent_data=$row["AC_DATA"];
    }
    $onduty=mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID='3'");
    while($row=mysqli_fetch_array($onduty)){
        $ure_onduty_data=$row["AC_DATA"];
    }
    if($attendance=="OD")
    {
        $reason;
        $uard_morning_session=$ure_onduty_data;
        $uard_afternoon_session =$ure_onduty_data;
        $report='';
        $filename='';
        $projectid='';

    }
    if($attendance=="0")
    {
        $reason;
        $uard_morning_session=$ure_absent_data;
        $uard_afternoon_session =$ure_absent_data;
        $report='';
        $filename='';
        $projectid='';
    }
    if($attendance=="0")
    {
        $attend= mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID =6 AND CGN_ID='3'");
        while($row=mysqli_fetch_array($attend)){
            $ure_attendance=$row["AC_DATA"];
        }
    }
    if($attendance=="OD")
    {
        $attend= mysqli_query($con,"select AC_DATA from ATTENDANCE_CONFIGURATION where AC_ID =7 AND CGN_ID='3'");
        while($row=mysqli_fetch_array($attend)){
            $ure_attendance=$row["AC_DATA"];
        }
    }


    $report= $con->real_escape_string($report);
    $reason= $con->real_escape_string($reason);
    $result = $con->query("CALL SP_TS_DAILY_REPORT_INSERT('$report','$reason','$fdate','$tdate',$ure_urc_id,'$USERSTAMP','$perm_time','$ure_attendance','$projectid','$uard_morning_session','$uard_afternoon_session','$filename','$upload_filename','$USERSTAMP',@success_flag)");
    if(!$result) die("CALL failed: (" . $con->errno . ") " . $con->error);
    $select = $con->query('SELECT @success_flag');
    $result = $select->fetch_assoc();
    $flag= $result['@success_flag'];

    echo $flag;
}
if($_REQUEST['option']=='BETWEEN DATE')
{
    $fdate=$_REQUEST['fromdate'];
    $tdate=$_REQUEST['todate'];
    $uld_id=mysqli_query($con,"select ULD_ID from USER_LOGIN_DETAILS where ULD_LOGINID='$USERSTAMP'");
    while($row=mysqli_fetch_array($uld_id)){
        $ure_uld_id=$row["ULD_ID"];
    }

    $fromdate = date('Y-m-d',strtotime($fdate));
    $todate = date('Y-m-d',strtotime($tdate));
    $ure_date_array=array();
    $sql= mysqli_query($con,"SELECT DISTINCT DATE_FORMAT(UARD_DATE,'%d-%m-%Y') AS UARD_DATE FROM USER_ADMIN_REPORT_DETAILS WHERE UARD_DATE BETWEEN '$fromdate' AND '$todate' and ULD_ID='$ure_uld_id'");
    while($row=mysqli_fetch_array($sql)){
        $ure_date_array[]=$row["UARD_DATE"];
    }
    echo json_encode($ure_date_array);
}
if($_REQUEST['option']=='PRESENT')
{
    $row=get_projectentry();
    if(count($row)!=0)
    {
        $flag=1;
    }
    else
    {
        $flag=0;
    }
    echo $flag;
}
if($_REQUEST['option']=='HALFDAYABSENT')
{
    $row=get_projectentry();
    if(count($row)!=0)
    {
        $flag=1;
    }
    else
    {
        $flag=0;
    }
    echo $flag;
}

?>