<?php
class EmailClass
{
        public function __construct()
        {

        }
        public static function SendMail($to,$from, $subject, $message)
	{
		$result = false;
		try{
		//$headers = "MIME-Version: 1.0rn";
		//$headers .= "Content-type: text/html; charset=iso-8859-1rn";
		//$headers  .= "From: ".$from."\r\n"; 
		
		 //end of message
                $headers  = "From: <".$from.">" . "\r\n";
                $headers .= "Content-type: text/html" . "\r\n";

                //options to send to cc+bcc
                //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
                //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
		$result = mail($to, $subject, $message, $headers);		
		}catch (Exception $ex){
			$result = false;
		}
		return $result;
	}	
} 
?>
