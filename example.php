##################### here you can find more methods for telegram bot-if you need enable this features,
##################### simple edit and add it to botcore.php file to needed switch cases.

############################ ///////////////////// Send message to all members //////////////// ######################################
### <-- this is default case of switch ($message) if you use this feature add one more default case to switch($reply_to_message_text) ####
           default: 
           switch($reply_to_message_text) {
             case 'Message to all users:':////// there is force_reply method
             respondOK();  // see 68~91 row for more details of respondOK() function
             	if ($user_id == $admin_id){
               	$useridsall = $dbconn->sendtoall();
               	$useridsallx = explode("\n",$useridsall);
               foreach ($useridsallx as $chat_id_allx){
                    $dataSend = [
                    'text' => $message,
                    'reply_markup' => $replyMarkup,
                    'parse_mode' => "HTML",
                                              ];
                $stt->sendteleg($dataSend, $chat_id_allx, "sendMessage");
                   } 
               		}else{
               		$dataSend = [
                    'text' => "Hi, only admin can send it!",
                    'reply_markup' => $replyMarkup,
                    'parse_mode' => "HTML", ];
                $stt->sendteleg($dataSend, $chat_id, "sendMessage");}
                break;
      ##### here method for calling $reply_to_message_text via force_reply method of telegram api ###
      ##### add it to switch $callback_query_data and set inline keyboard for it ###
      case '/sendtoall': //send message to all members - this is case of switch ($callback_query_data) ///////////////////////
               	if ($chat_id_call == $admin_id){
               	$dataSend = [
                    'text' => "Message to all users:",
                    'message_id' => $message_id_call,
                    'reply_markup' => json_encode(array('force_reply' => true)),
                    // 'disable_notification'=>'true',
                    'parse_mode' => "HTML",
                ];
                $stt->sendteleg($dataSend, $chat_id_call, "sendMessage");}
                break;
      ##### and there is function for list of user_id's from DB add it in to db.php file ###
      public function sendtoall() {
               $query ="SELECT * FROM `user`";
               $result = $this->db->query($query);
               while($row = $result->fetch_assoc()){ 
        	          $userids .="\n".$row['user_id'];
                    }
               return $userids;
               }
      ######################################## End of send to all method ####################################
      #######################################################################################################
      ############################ check if user is a member of channel and grant acces to any feature of bot
      function getmemberstatus($chat_id,$channel_id){
              $data = ['user_id'=>$chat_id];
              $isuser = $GLOBALS['stt']->sendteleg($data,"@".$channel_id,'getChatMember');
              $decoded = json_decode($isuser);
              $ismember = $decoded->result->status;
              $statuses = array('creator', 'administrator', 'member', 'restricted');
              if(in_array($ismember,$statuses)){return true;}else {return false;};
              }
      # how to call it:
      if(getmemberstatus($chat_id_call,$channel_id)){
      do some thing... grand acces etc
      }else{
      Say user - Hi, you need join my channel to acces this feature of bot...
      }
      ################################################ End of get channel member ##################################
      #############################################################################################################
      ########### There is method for protect script from "pending_update_count:XX" ###############################
      # simple paste "respondOK();" before any long executing proces or problematic function of your bot
      # and telegram API don't waiting your script and pending_update_count=0;
      function respondOK($text = null){
  if   (is_callable('fastcgi_finish_request')) { //fastcgi_finish_request()
        if ($text !== null) {echo $text;}
        session_write_close();
        fastcgi_finish_request();
        return;
        }
    ignore_user_abort(true);
    ob_start();
    if ($text !== null) {
        echo $text;
    }
    $serverProtocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
    header($serverProtocol . ' 200 OK');
    header('Content-Encoding: none');
    header('Content-Length: ' . ob_get_length());
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush();
}
      ############################################ End of respond ok###############################################
      # Sorry for my bad English and Here i add more methods if anyone need it...
      
      
      
      
      
      
      
      
      
      
      
      
