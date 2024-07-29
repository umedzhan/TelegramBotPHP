<?php

$TOKEN = '7268684551:AAEtY4jT5KtH97hZyf5-bQu___fIZZ7Wvz8';

$channel_info = '-1002163517396';
$br = "\n";

function bot($method, $data = []) {
	global $TOKEN;
    $url = "https://api.telegram.org/bot$TOKEN/$method";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$update = json_decode(file_get_contents('php://input'), true);

//save logs
$data = (file_get_contents('php://input'));
$log = fopen('log.json', "a");
fwrite($log, "\n\n".$data);
fclose($log);

if (isset($update['message'])) {

	$message = $update['message'];
	$ccid = $message['chat']['id'];
	$text = isset($message['text']) ? $message['text'] : '';
	$text_id = $message['message_id'];
	
	$firstname = $message['chat']['first_name'];
	$lastname = $message['chat']['last_name'] ? $message['chat']['last_name'] : "null";
	$username = $message['from']['username'] ? $message['from']['username'] : 'null';
	$language_code = $message['from']['language_code'] ? $message['from']['language_code'] : 'null';
	$is_premium = $message['from']['is_premium'] ? $message['from']['is_premium'] : '0';

	bot('deleteMessage',[
		'chat_id' => $ccid,
		'message_id' => $text_id
	]);
	
	if ($text == '/start' && !file_exists('data/'.$ccid)) {
		$userphoto = bot('getUserProfilePhotos', [
    		'user_id' => $ccid,
		]);
		
		if ($userphoto['ok'] && $userphoto['result']['total_count'] > 0) {
        	// Get the file_id of the first photo
        	$file_id = $userphoto['result']['photos'][0][0]['file_id'];

        	// Send the first profile photo to the user
        	bot('sendPhoto', [
    			'chat_id' => $channel_info,
        		'photo' => $file_id,
        		'caption' => "FirstName: $firstname".$br.
					"LastName: $lastname".$br.
					"Username: @$username".$br.
					"Language: $language_code".$br.
					"Premium: $is_premium"
    		]);
    	} else {
    		bot('sendMessage', [
    			'chat_id' => $channel_info,
        		'text' => "No Profile Pic".$br.
					"FirstName: $firstname".$br.
					"LastName: $lastname".$br.
					"Username: @$username".$br.
					"Language: $language_code".$br.
					"Premium: $is_premium"
    		]);
    	}
    	//file_put_contents('data/'.$ccid); //keyinchalik
	}
	if ($text == '/start') {
		$delmessage = file_get_contents('message_id/'.$ccid.'id.txt');
		bot('deleteMessage', [
			'chat_id' => $ccid,
			'message_id' => $delmessage
		]);
		$response = bot('sendMessage', [
			'chat_id' => $ccid,
			'text' => 'Loading...'
		]);
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'id.txt', $message_id);
		Main();
	}
  	elseif ($text == '/sendMessage') {
  		bot('sendMessage' , [
  			'chat_id' => $ccid,
  			'text' => 'MessageText',
  			'reply_markup' => json_encode([
  				'inline_keyboard' => [
  					[['text' => 'View Code', 'callback_data' => 'sendMessage']]
  				]
  			])
  		]);
		$response = bot('sendMessage' , [
  			'chat_id' => $ccid,
  			'text' => 'MessageText Parse Mode With HTML'.$br.$br.
				'<b>Bold</b>'.$br.
				'<i>Italic</i>'.$br.
				'<u>Underline</u>'.$br.
				'<s>Strike</s>'.$br.
				'<a href="google.com">Google link</a>'.$br.
				'<code>Code</code>'.$br.
				'<pre language="copy">Copy</pre>',
  			'parse_mode' => 'html',
  			'reply_markup' => json_encode([
  				'inline_keyboard' => [
  					[['text' => 'View Code', 'callback_data' => 'sendMessageParseMode']]
  				]
  			])
  		]);
  		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
  	}
  	elseif ($text == '/sendPhoto') {
  		$response = bot('sendPhoto' , [
  			'chat_id' => $ccid,
  			'photo' => "https://www.php.net/images/meta-image.png",
  			'caption' => "Caption for photo..",
  			'reply_markup' => json_encode([
  				'inline_keyboard' => [
  					[
  						['text' => 'View Code', 'callback_data' => 'sendPhoto']
					]
  				]
  			])
  		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
  	}
  	elseif ($text == '/sendVideo') {
  		$response = bot('sendVideo' , [
  			'chat_id' => $ccid,
  			'video' => "https://t.me/TelegramTips/454",
  			'caption' => "Caption for video..",
  			'reply_markup' => json_encode([
  				'inline_keyboard' => [
  					[
  						['text' => 'View Code', 'callback_data' => 'sendVideo']
  					]
  				]
  			])
  		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
  	}
	elseif ($text == '/function_bot') {
		$code = file_get_contents('codes/function_bot.markdown');
		MainDelete();
		sendCode();
	}
	elseif ($text == '/message') {
		$code = file_get_contents('codes/message.markdown');
		MainDelete();
		sendCode();
	}
	elseif ($text == '/if') {
		$code = file_get_contents('codes/if.markdown');
		MainDelete();
		sendCode();
	}
	elseif ($text == '/callback_query') {
		$code = file_get_contents('codes/callback_query.markdown');
		MainDelete();
		sendCode();
	}
	elseif ($text == '/sendAudio') {
		$response = bot('sendAudio' , [
			'chat_id' => $ccid,
			'audio' => 'https://t.me/lovelyhit/1122',
			'reply_markup' => json_encode([
				'inline_keyboard' => [
					[['text' => 'View Code', 'callback_data' => 'sendAudio']]
				]
			])
		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
	}
	elseif ($text == '/sendDocument') {
		$response = bot('sendDocument', [
			'chat_id' => $ccid,
			'document' => 'https://t.me/kitapcan/43',
			'reply_markup' => json_encode([
				'inline_keyboard' => [
					[['text' => 'View Code', 'callback_data' => 'sendDocument']]
				]
			])
		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
	}
	elseif ($text == '/sendLocation') {
		$response = bot('sendLocation', [
			'chat_id' => $ccid,
			'latitude' => 37.248561,
			'longitude' => 67.290522,
			'reply_markup' => json_encode([
				'inline_keyboard' => [
					[['text' => 'View Code', 'callback_data' => 'sendLocation']]
				]
			])
		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
	}
	elseif ($text == '/sendContact') {
		$response = bot('sendContact', [
			'chat_id' => $ccid,
			'phone_number' => '+123456789',
			'first_name' => 'Durov',
			'last_name' => 'Code',
			'reply_markup' => json_encode([
				'inline_keyboard' => [
					[['text' => 'View Code', 'callback_data' => 'sendContact']]
				]
			])
		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
	}
	elseif ($text == '/sendPoll') {
		$response = bot('sendPoll', [
			'chat_id' => $ccid,
			'question' => 'Are you Okay?',
			'options' => json_encode([
				['text' => 'Yes Okay'],
				['text' => 'No Im not']
			]),
			'type' => 'regular',
			'correct_option_id' => 0,
			'reply_markup' => json_encode([
				'inline_keyboard' => [
					[['text' => 'View Code', 'callback_data' => 'sendPoll']]
				]
			])
		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
	}
	elseif ($text == '/sendChatAction') {
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'typing'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'upload_photo'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'record_video'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'upload_video'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'record_voice'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'upload_voice'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'upload_document'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'choose_sticker'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'find_location'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'record_video_note'
		]);
		bot('sendChatAction', [
			'chat_id' => $ccid,
			'action' => 'upload_video_note'
		]);
		$response = bot('sendMessage', [
			'chat_id' => $ccid,
			'text' => 'sendChatAction',
			'reply_markup' => json_encode([
				'inline_keyboard' => [
					[['text' => 'View Code', 'callback_data' => 'sendChatAction']]
				]
			])
		]);
		MainDelete();
		$message_id = $response['result']['message_id'];
		file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
	}
	elseif ($text == '/getChatMember') {
		$member = bot('getChatMember', [
			'chat_id' => $channel_info,
			'user_id' => $ccid
		]);
		if ($member['ok'] == true) {
			bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'true'
			]);
		} else {
			bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'false'
			]);
		}
	}

	//keyboard
	switch ($text) {
		case '/keyboard':
			bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'Keyboard',
				'reply_markup' => json_encode([
					'resize_keyboard' => true,
					'keyboard' => [
						[
							['text' => 'Button 1', 'callback_data' => "#"],
							['text' => 'Button 2', 'callback_data' => "#"]
						],
						[
							['text' => 'Button 3', 'callback_data' => "#"]
						],
						[
							['text' => 'Button 4', 'callback_data' => "#"],
							['text' => 'Button 5', 'callback_data' => "#"],
							['text' => 'Button 6', 'callback_data' => "#"]
						]
					]
				])
			]);
			$response = bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'Code',
				'reply_markup' => json_encode([
					'inline_keyboard' => [
						[['text' => 'View Code', 'callback_data' => 'keyboard']]
					]
				])
			]);
			MainDelete();
			$message_id = $response['result']['message_id'];
			file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
			break;
		case '/inline_keyboard':
			bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'Keyboard',
				'reply_markup' => json_encode([
					'inline_keyboard' => [
						[
							['text' => 'Button 1', 'callback_data' => "1"],
							['text' => 'Button 2', 'callback_data' => "2"]
						],
						[
							['text' => 'Button 3', 'callback_data' => "3"]
						],
						[
							['text' => 'Button 4', 'callback_data' => "4"],
							['text' => 'Button 5', 'callback_data' => "5"],
							['text' => 'Button 6', 'callback_data' => "6"]
						]
					]
				])
			]);
			$response = bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'Code',
				'reply_markup' => json_encode([
					'inline_keyboard' => [
						[['text' => 'View Code', 'callback_data' => 'inline_keyboard']]
					]
				])
			]);
			MainDelete();
			$message_id = $response['result']['message_id'];
			file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
			break;
		case '/remove_keyboard':
			bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'Remove Keyboard',
				'reply_markup' => json_encode([
					'remove_keyboard' => true
				])
			]);
			$response = bot('sendMessage', [
				'chat_id' => $ccid,
				'text' => 'Code',
				'reply_markup' => json_encode([
					'inline_keyboard' => [
						[['text' => 'View Code', 'callback_data' => 'remove_keyboard']]
					]
				])
			]);
			MainDelete();
			$message_id = $response['result']['message_id'];
			file_put_contents('message_id/'.$ccid.'code.txt', $message_id);
			break;
	}
}

if (isset($update['callback_query'])) {
	
	$callbackQuery = $update['callback_query'];
    $text = $callbackQuery['data'];
    $ccid = $callbackQuery['message']['chat']['id'];
    $callbackMessageId = $callbackQuery['message']['message_id'];
    
	//Available types
	switch ($text) {
		case '':
	}

	//send...
	switch ($text) {
		case 'sendMessage':
			$code = file_get_contents('codes/sendMessage_code.markdown');
			sendCode();
			break;
		case 'sendMessageParseMode':
			$code = file_get_contents('codes/sendMessageParseMode_code.markdown');
			sendCode();
			break;
		case 'sendPhoto':
			$code = file_get_contents('codes/sendPhoto_code.markdown');
			sendCode();
			break;
		case 'sendVideo':
			$code = file_get_contents('codes/sendVideo.markdown');
			sendCode();
			break;
		case 'sendAudio':
			$code = file_get_contents('codes/sendAudio.markdown');
			sendCode();
			break;
		case 'sendDocument':
			$code = file_get_contents('codes/sendDocument.markdown');
			sendCode();
			break;
		case 'sendLocation':
			$code = file_get_contents('codes/sendLocation.markdown');
			sendCode();
			break;
		case 'sendContact':
			$code = file_get_contents('codes/sendContact.markdown');
			sendCode();
			break;
		case 'sendPoll':
			$code = file_get_contents('codes/sendPoll.markdown');
			sendCode();
			break;
		case 'sendChatAction':
			$code = file_get_contents('codes/sendChatAction.markdown');
			sendCode();
			break;
	}

	//keyboard
	switch ($text) {
		case 'keyboard':
			$code = file_get_contents('codes/keyboard.markdown');
			sendCode();
			break;
		case 'inline_keyboard':
			$code = file_get_contents('codes/inline_keyboard.markdown');
			sendCode();
			break;
		case 'remove_keyboard':
			$code = file_get_contents('codes/remove_keyboard.markdown');
			sendCode();
			break;
	}

	switch ($text) {
		case 'func':
			Func();
			break;
		case 'send...':
			sendMethod();
			break;
		case 'Available_types':
			sendAvailable_types();
			break;
		case 'get_Updates':
			getUpdates();
			break;
		case 'keyboards':
			Keyboards();
			break;
		case 'help':
			Help();
			break;
		case 'backmain':
			Main();
			break;
		case 'delCode':
			$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
			Main();			
			break;
	}
}

function sendCode() {
	global $ccid, $code;
	$message_id = file_get_contents('message_id/'.$ccid.'code.txt');
	bot('deleteMessage', [
		'chat_id' => $ccid,
		'message_id' => $message_id
	]);
	bot('deleteMessage', [
		'chat_id' => $ccid,
		'message_id' => $message_id-1
	]);
	
	$response = bot('sendMessage' , [
		'chat_id' => $ccid,
		'text' => $code,
		'parse_mode' => 'markdown',
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Back Main', 'callback_data' => 'delCode']]
			]
		])
	]);
	$message_id = $response['result']['message_id'];
	file_put_contents('message_id/'.$ccid.'id.txt', $message_id);
}

function Main() {
	global $ccid, $br;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('editMessageText', [
		'chat_id' => $ccid,
		'message_id' => $message_id,
		'text' => "Hello there!".$br.
			"Learn how to make a bot easily!",
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Functions Bot', 'callback_data' => 'func']],
				[['text' => 'Available types', 'callback_data' => 'Available_types']],
				[['text' => 'Get Updates', 'callback_data' => 'get_Updates']],
				[['text' => 'sendMethod', 'callback_data' => 'send...']],
				[['text' => 'Keyboard', 'callback_data' => 'keyboards']],
				[['text' => 'Help & Info', 'callback_data' => 'help']]
			]
		])
	]);
}

function Func() {
	global $ccid;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('editMessageText', [
		'chat_id' => $ccid,
		'message_id' => $message_id,
		'text' => file_get_contents('BotTexts/func.html'),
		'parse_mode' => 'html',
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Back', 'callback_data' => 'backmain']]
			]
		])
	]);
}

function sendMethod() {
	global $ccid;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('editMessageText', [
		'chat_id' => $ccid,
		'message_id' => $message_id,
		'text' => file_get_contents('BotTexts/sendMethod.txt'),
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Back', 'callback_data' => 'backmain']]
			]
		])
	]);
}

function sendAvailable_types() {
	global $ccid;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('editMessageText', [
		'chat_id' => $ccid,
		'message_id' => $message_id,
		'text' => file_get_contents('BotTexts/Available_types.html'),
		'parse_mode' => 'html',
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Back', 'callback_data' => 'backmain']]
			]
		])
	]);
}

function getUpdates() {
	global $ccid;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('editMessageText', [
		'chat_id' => $ccid,
		'message_id' => $message_id,
		'text' => file_get_contents('BotTexts/getUpdates.html'),
		'parse_mode' => 'html',
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Back', 'callback_data' => 'backmain']]
			]
		])
	]);
}

function Keyboards() {
	global $ccid;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('editMessageText', [
		'chat_id' => $ccid,
		'message_id' => $message_id,
		'text' => file_get_contents('BotTexts/Keyboard.html'),
		'parse_mode' => 'html',
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Back', 'callback_data' => 'backmain']]
			]
		])
	]);
}

function Help() {
	global $ccid;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('editMessageText', [
		'chat_id' => $ccid,
		'message_id' => $message_id,
		'text' => file_get_contents('BotTexts/help.html'),
		'parse_mode' => 'html',
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Back', 'callback_data' => 'backmain']]
			]
		])
	]);
}

function MainDelete() {
	global $ccid, $message_id;
	$message_id = file_get_contents('message_id/'.$ccid.'id.txt');
	bot('deleteMessage', [
		'chat_id' => $ccid,
		'message_id' => $message_id
	]);
}
