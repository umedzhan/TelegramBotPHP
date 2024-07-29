_Callback query_
```php
if (isset($update['callback_query'])) {
	
	$callbackQuery = $update['callback_query'];
	$text = $callbackQuery['data'];
	$ccid = $callbackQuery['message']['chat']['id'];
	$callbackMessageId = $callbackQuery['message']['message_id'];

	//code
}
```

_Example_
```php
<?php

$TOKEN = 'BOT_TOKEN';

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

if (isset($update['message'])) {

	$message = $update['message'];
	$ccid = $message['chat']['id'];
	$text = isset($message['text']) ? $message['text'] : '';

	//code...
	bot('sendMessage', [
		'chat_id' => $ccid,
		'text' => 'Hi',
		'reply_markup' => json_encode([
			'inline_keyboard' => [
				[['text' => 'Callback_query', 'callback_data' => 'test']]
			]
		])
	]);
}

if (isset($update['callback_query'])) {
	
	$callbackQuery = $update['callback_query'];
	$text = $callbackQuery['data'];
	$ccid = $callbackQuery['message']['chat']['id'];
	$callbackMessageId = $callbackQuery['message']['message_id'];

	//code
	if ($text == 'test') {
		bot('sendMessage', [
		'chat_id' => $ccid,
		'text' => 'Test working',
	]);
}
	}
}
```