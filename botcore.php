<?
#############################################################################
#This is simple php telegram bot for beginners - by R00f from UZB. 2020 Juni#
#############################################################################
####       See example methods in - example.php file          ###############
date_default_timezone_set('Asia/Tashkent');
require_once ("db.php");
//////////////////////////////// Token and Telegram API URL
$bot_token = "xxxxxxxxxxx"; // add your bots token
$bot_url = 'https://api.telegram.org/bot' . $bot_token; // Telegram bot api request url
$stt = new sendtoteleg();   // object from send to telegram class
$dbconn = new Database();   // object for MySql Connect class
///////////////////////////////////////////////////////////// All incoming things from telegram api/////////////////
        $admin_id = 'XXXXXXXX';//  bot's admin id
        $channel_id = 'XXXXXXXX'; // chanel id if subscribe needs. important: write it without '@' symbol.(mychannel)
        $input = json_decode(file_get_contents('php://input'), TRUE);
        $chat_id = $input['message']['chat']['id'];
        $user_id = $input['message']['from']['id'];
        $username = $input['message']['from']['username'];
        $first_name =$input['message']['from']['first_name'];
        $last_name  =$input['message']['from']['last_name'];
        $message = $input['message']['text'];
        $document = $input['message']['document'];
        $file_id = $document['file_id'];
        $file_name = $document['file_name'];
        $reply_to_message = $input['message']['reply_to_message'];
        $reply_to_message_text = $input['message']['reply_to_message']['text'];
        $reply_to_message_phone = $input['message']['contact']['phone_number'];
        $reply_to_message_id = $input['message']['reply_to_message']['from']['id'];
        $message_id = $input['message']['message_id'];
        $pollupdate = $input['poll_answer'];
        $poll_id = $pollupdate['poll_id'];
        $poll_user_id = $pollupdate['user']['id'];
        $poll_userfirst_name = $pollupdate['user']['first_name'];
        $poll_answer_id = $pollupdate['option_ids'];
        $call_query = $input['callback_query'];
        $callback_query_id = $input['callback_query']['id'];
        $call_query_data = $call_query['data'];
        $reply_to_message_call = $call_query['message']['reply_to_message'];
        $reply_to_message_text_call = $call_query['message']['reply_to_message']['text'];
        $message_id_call = $call_query['message']['message_id'];
        $chat_id_call = $call_query['message']['chat']['id'];
        $user_id_call = $call_query['from']['id'];
        $first_name_call = $call_query['from']['first_name'];
        $last_name_call = $call_query['from']['last_name'];
        $username_call = $call_query['from']['username'];
        $user_id_poll = $input['poll_answer']['user']['id'];
        $first_name_poll = $input['poll_answer']['user']['first_name'];
        $last_name_poll = $input['poll_answer']['user']['last_name'];
        $username_poll = $input['poll_answer']['user']['username'];

###################### Here we can register any user that write to bot anything #########################
if (isset($user_id)){
  if (!$dbconn->isRegistered($user_id)){
    $dbconn->register($user_id,$username,$first_name,$last_name);}};
if (isset($user_id_call)){ 
  if(!$dbconn->isRegistered($user_id_call)){
    $dbconn->register($user_id_call,$username_call,$first_name_call,$last_name_call);}}
if (isset($user_id_poll)){
  if (!$dbconn->isRegistered($user_id_poll)){
    $dbconn->register($user_id_poll,$username_poll,$first_name_poll,$last_name_poll);}};

######################### admin test - here you can see what telegram API send to your bot - uncomment it for test##########
## if($input){ $stt->sendteleg($dataSend = ['text' => json_encode($input,JSON_PRETTY_PRINT)], $admin_id, "SendMessage");} ##
############################################################################################################################
################################### here you cann pass any inline keyboards ################################################
$button_back = ['text' => "\xE2\xAC\x85 Back", 'callback_data' => '/back'];
$button_channel = ['text' => "\xF0\x9F\x93\xA2 Go to channel", 'url' => 'https://t.me/'.$channel_id];
$keyboard_buttons = [[$button_channel][$button_back]]; 
$replyMarkup = json_encode(["inline_keyboard" => $keyboard_buttons]);
######################################## keyboards end #####################################################################
############################# switch for incoming messages by user - you can add here cases for your bot commands ########## 
switch ($message){
        // case start - if user starts bot      
        case '/start': 
        $dataSend = [
                'text' => "Hi, i am new bot!",
                'reply_markup' => $replyMarkup,
                'parse_mode' => "HTML",
                ];
                $stt->sendteleg($dataSend, $chat_id, "SendMessage");            	        
        break;
        //default case - use it for any user action and send answer to him        
        default:
         $dataSend = [
                'text' => "Hi, You entered: ".$message, // only for text messages
                'parse_mode' => "HTML",
                ];
                $stt->sendteleg($dataSend, $chat_id, "SendMessage");           
        break;
}
####################################### switch $message end ####################################################
####################################### switch callback data - you can answer to callback data of buttons ######
switch ($call_query_data) {
            case '/back':       //<-----------------------------------Back button 
                static $count = 1;
                $dataSend = [
                    'text' => "<b>You pressed button: </b>".$count++." times!",
                    'message_id' => $message_id_call,
                    'reply_markup' => $replyMarkup,
                    'parse_mode' => "HTML",
                ];
                $stt->sendteleg($dataSend, $chat_id_call, "editMessageText"); // edit message method
                $dataSend = [
                'text' => "Button pressed!",
                'callback_query_id' => $callback_query_id,
                'show_alert' => false
                ];
                $stt->sendteleg($dataSend, $chat_id_call, "answerCallbackQuery"); // show alert info
                break;
}
####################################### switch callback end ###########################################
class sendtoteleg {

            public function sendteleg($data, $chat_id, $type) {
                $result = null;
                $data['chat_id'] = $chat_id;
                if (is_array($data)) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $GLOBALS['bot_url'] . '/' . $type);
                    curl_setopt($ch, CURLOPT_POST, count($data));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    $result = curl_exec($ch);
                    curl_close($ch);
                }
              
                return $result;
            }

        }
