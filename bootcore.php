<?
######################################################################
This is simple php telegram bot for beginners - by R00f from UZB. 2020 Juni
######################################################################
$bot_token = "xxxxxxxxxxx"; // add your bots token
$bot_url = 'https://api.telegram.org/bot' . $bot_token; 

///////////////////////////////////////////////////////////// All incoming things from telegram api/////////////////
        $admin_id = 'XXXXXXXX';//  bot's admin id
        $channel_id = '@XXXXXXXX'; // chanel id if subscribe needs
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
