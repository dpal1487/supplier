<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{


	public function imapOpen()
	{
		$hostname = '{mail.softcation.com:993/imap/ssl}INBOX';
		$username = 'anupam@softcation.com';
		$password = 'Anupam@123';

		/* try to connect */
		$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
		return  $inbox;
	}
	public function inbox1()
	{
		//return "Hello get All All method";
		$data;
		$inbox = $this->imapOpen();
		/* grab emails */
		$emails = imap_search($inbox,'ALL');

		/*Collect unread messages only*/
	    $emails_unread = imap_search($inbox, 'UNSEEN');

		/* if emails are returned, cycle through each... */
		if($emails) {
			
			/* begin output var */
			$output = '';
			
			/* put the newest emails on top */
			rsort($emails);
			$i=1;	
			/* for every email... */

/*		  foreach($emails as $email_number) {
		    $email_number=$emails[7];
		    echo "<pre>";
			print_r($emails);
			echo "</pre>";*/
			 $MC = imap_check($inbox);
			$result = imap_fetch_overview($inbox,"1:{$MC->Nmsgs}");
			foreach ($result as $overview) {
				// mail ka page to bna hua h to ek kaam krna sent wala bhi yhi lga dena layout bol rha hu inbox wali, ok
				// or na controller m hi add krna use bhi seen or unseen jaise sab kra h
				
				// email split code
				/*$emailFrom  = $overview->from;
				$email = explode("<", $emailFrom);
				$emailBy = $email[0];
				$emailName = $email[1];*/
				// email Split code end

			    $data[] = array('emailNum'=>$overview->msgno,'emailDate'=>$overview->udate,'emailFrom'=>$overview->from,'emailSubject'=>iconv_mime_decode($overview->subject));
			   // $data[] = array('emailNum'=>$overview->msgno,'emailDate'=>$overview->udate,'emailFrom'=>$overview->from,'emailSubject'=>iconv_mime_decode($overview->subject,'isRead'=>$overview->seen));
			}
			//return $data;
			//return view('email.index',array('emails'=>$data));
		    /* get information specific to this email */
		    //$overview = imap_fetch_overview($inbox,$email_number);
		    //return $structure = imap_fetchstructure($inbox, $email_number,0);
		    //$message = quoted_printable_decode(imap_fetchbody($inbox,$email_number,1.2));


		    //$preferences = ["input-charset" => "UTF-8", "output-charset" => "UTF-8"];
			//$encoded_subject = iconv_mime_encode("Subject", $overview[0]->subject, $preferences);
			//$decode = iconv_mime_decode( $overview[0]->subject, 8, "UTF-8");
			/*print($decode);
		    /* output the email header information */
		    /*$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
		    
		    $output.= '<span class="subject"><b>SUBJECT</b> : '.$overview[0]->subject.'</span></br>';
		    $output.= '<span class="from"><b>from</b> : '.$overview[0]->from.'</span> </br>';
		    $output.= '<span class="to"><b>to</b> : '.$overview[0]->to.'</span> </br>';
		    $output.= '<span class="uid"><b>uid</b> : '.$overview[0]->uid.'</span> </br>';
		    $output.= '<span class="msgno"><b>msgno</b> : '.$overview[0]->msgno.'</span> </br>';
		    $output.= '<span class="recent"><b>recent</b> : '.$overview[0]->recent.'</span> </br>';
		    $output.= '<span class="flagged"><b>flagged</b> : '.$overview[0]->flagged.'</span> </br>';
		    $output.= '<span class="answered"><b>answered</b> : '.$overview[0]->answered.'</span> </br>';
		    $output.= '<span class="deleted"><b>deleted</b> : '.$overview[0]->deleted.'</span> </br>';
		    $output.= '<span class="subject"><b>draft</b> : '.$overview[0]->draft.'</span> </br>';
		    $output.= '<span class="udate"><b>udate</b> : '.$overview[0]->udate.'</span> </br>';*/

		    //$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
		    //$output.= '<span class="from">'.$overview[0]->from.'</span>';
		    //$output.= '<span class="date">on '.$overview[0]->date.'</span>';   // showing error
		    //$output.= '</div>';

		    /* output the email body */
		    //$output.= '<div class="body">'.preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($message))) ).'</div>';
		  //}

		  //return $data;
		  return response()->json(['emails'=>$data,'success'=>true]);
		} 

		/* close the connection */
		imap_close($inbox);
	}

	public function inbox()
	{
		$data;
		$inbox = $this->imapOpen();
		$mails  = imap_search($inbox,'ALL');

		if ($mails ) {
  
                /* Mail output variable starts*/
                
                rsort($mails );
  
                /* For each email */
                foreach ($mails  as $email_number) {
  
                    /* Retrieve specific email information*/
                   $headers = imap_fetch_overview($inbox, $email_number, 0);
  
                    /*  Returns a particular section of the body*/
                    /*$message = imap_fetchbody($inbox, $email_number, '1');
                    $subMessage = substr($message, 0, 150);
                    $finalMessage = trim(quoted_printable_decode($subMessage));*/

  					$data[] = array('emailNum'=>$headers[0]->msgno,'emailDate'=>$headers[0]->udate,'emailFrom'=>$headers[0]->from,'emailSubject'=>iconv_mime_decode($headers[0]->subject));
                    
                }// End foreach
                
                return response()->json(['emails'=>$data,'success'=>true]);
            }//endif 
  
            /* imap connection is closed */
            imap_close($inbox);


	}


	public function readEmail($id)
	{
	  	$inbox = $this->imapOpen();
      	if( $inbox ) {
   
		     //Check no.of.msgs
		   $num = imap_num_msg($inbox);

		     //if there is a message in your inbox
		     if( $num > 0 ) {

		     	/*$attachments=array();
			    $attachments[$prefix]=mail_decode_part($imap,$mid,$part,$prefix);
			    if (isset($part->parts)) // multipart
			    {
			        $prefix = ($prefix == "0")?"":"$prefix.";
			        foreach ($part->parts as $number=>$subpart)
			            $attachments=array_merge($attachments, mail_get_parts($imap,$mid,$subpart,$prefix.($number+1)));
			    }
    			return $attachments;*/

    			// Get headers
			$header = imap_fetch_overview($inbox, $id,0);
			/*echo "<pre>";
			print_r($header);*/
				
				/*  Returns a particular section of the body*/
                    $message = imap_fetchbody($inbox, $id, '1');
                    $subMessage = substr($message, 0, 150);
                    $finalMessage = trim(quoted_printable_decode($subMessage));

                    /* get mail structure */
        			$structure = imap_fetchstructure($inbox, $id, FT_UID);

        			$attachments = array();

			        /* if any attachments found... */
			        if(isset($structure->parts) && count($structure->parts)) 
			        {
			            for($i = 0; $i < count($structure->parts); $i++) 
			            {
			                $attachments[$i] = array(
			                    'is_attachment' => false,
			                    'filename' => '',
			                    'name' => '',
			                    'attachment' => ''
			                );

			                if($structure->parts[$i]->ifdparameters) 
			                {
			                    foreach($structure->parts[$i]->dparameters as $object) 
			                    {
			                        if(strtolower($object->attribute) == 'filename') 
			                        {
			                            $attachments[$i]['is_attachment'] = true;
			                            $attachments[$i]['filename'] = $object->value;
			                        }
			                    }
			                }

			                if($structure->parts[$i]->ifparameters) 
			                {
			                    foreach($structure->parts[$i]->parameters as $object) 
			                    {
			                        if(strtolower($object->attribute) == 'name') 
			                        {
			                            $attachments[$i]['is_attachment'] = true;
			                            $attachments[$i]['name'] = $object->value;
			                        }
			                    }
			                }

			                if($attachments[$i]['is_attachment']) 
			                {
			                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $id, $i+1);

			                    /* 3 = BASE64 encoding */
			                    if($structure->parts[$i]->encoding == 3) 
			                    { 
			                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
			                    }
			                    /* 4 = QUOTED-PRINTABLE encoding */
			                    elseif($structure->parts[$i]->encoding == 4) 
			                    { 
			                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
			                    }
			                }
			            }
			        }
			       
			       //return $attachments = mb_convert_encoding($attachments, 'UTF-8', 'UTF-8');
			       //return response()->json(['email'=>$data,'success'=>true]);

			        /* iterate through each attachment and save it */
			       /* foreach($attachments as $attachment)
			        {
			            if($attachment['is_attachment'] == 1)
			            {
			                $filename = $attachment['name'];
			                if(empty($filename)) $filename = $attachment['filename'];

			                if(empty($filename)) $filename = time() . ".dat";
			                $folder = "attachment";
			                if(!is_dir($folder))
			                {
			                     mkdir($folder);
			                }
			                $fp = fopen("./". $folder ."/". $email_number . "-" . $filename, "w+");
			                fwrite($fp, $attachment['attachment']);
			                fclose($fp);
			            }
			        }*/







				/*// Split on \n
				$h_array=explode("\n",$header);

				foreach ( $h_array as $h ) {

				    // Check if row start with a char
				    if ( preg_match("/^[A-Z]/i", $h )) {

				        $tmp = explode(":",$h);
				    $header_name = $tmp[0];
				    $header_value = $tmp[1];
				               
				    return $headers[$header_name] = $header_value;
				       
				    } else {
				        // Append row to previous field
				    return $headers[$header_name] = $header_value . $h;
				    }
				}*/
		          //read that mail recently arrived
    			 /* $body = imap_fetchbody($inbox,$id,'1');
    			  $result = quoted_printable_decode($body);
		          $msgBody =  imap_qprint(imap_body($inbox, $id));
		         $msg =  trim( utf8_decode(quoted_printable_decode($msgBody)));*/
		         $data[] = array('emailNum'=>$header[0]->msgno,'emailDate'=>$header[0]->udate,'emailFrom'=>$header[0]->from,'emailSubject'=>iconv_mime_decode($header[0]->subject),'msgBody'=>$finalMessage,'attachments'=>mb_convert_encoding($attachments, 'UTF-8', 'UTF-8'));
		          return response()->json(['email'=>$data,'success'=>true]);
		          
		     }

		     //close the stream
		     imap_close($inbox);
		}

	}

}
