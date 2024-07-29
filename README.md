# TelegramBot

**PHP telegram bot**
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

```

**Message**
```php
if (isset($update['message'])) {

	$message = $update['message'];
	$ccid = $message['chat']['id'];
	$text = isset($message['text']) ? $message['text'] : '';

	//code...
}
```

**Callback Query**
```php
if (isset($update['callback_query'])) {
	
	$callbackQuery = $update['callback_query'];
	$text = $callbackQuery['data'];
	$ccid = $callbackQuery['message']['chat']['id'];
	$callbackMessageId = $callbackQuery['message']['message_id'];

	//code
}
```
<table>
<th>
	<td>1</td>
 	<td>2</td>
</th>
	<tr>
		<td>1</td>
		<td>2</td>
	</tr>
</table>
