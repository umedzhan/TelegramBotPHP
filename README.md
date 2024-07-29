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
**sendMessage** <br>
Use this method to send text messages. On success, the sent Message is returned.
<table>
	<tr>
		<th>Parameter</th>
		<th>Type</th>
		<th>Required</th>
	</tr>
	<tr>
		<td>business_connection_id</td>
		<td>String</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>chat_id</td>
		<td>Integer or String</td>
		<td>Yes</td>
	</tr>
</table>

```php
bot('sendMessage', [
	'chat_id' => $ccid,
	'sendMessage' => 'Hello World!'
]);
```
