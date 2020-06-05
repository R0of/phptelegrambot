<?

require_once ("corebot.php");

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
