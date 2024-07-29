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
	<tr>
		<td>message_thread_id</td>
		<td>Integer</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>text</td>
		<td>String</td>
		<td>Yes</td>
	</tr>
	<tr>
		<td>parse_mode</td>
		<td>String</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>entities</td>
		<td>Array of MessageEntity</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>link_preview_options</td>
		<td>LinkPreviewOptions</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>disable_notification</td>
		<td>Boolean</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>protect_content</td>
		<td>Boolean</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>message_effect_id</td>
		<td>String</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>reply_parameters</td>
		<td>ReplyParameters</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>reply_markup</td>
		<td>InlineKeyboardMarkup or ReplyKeyboardMarkup or ReplyKeyboardRemove or ForceReply</td>
		<td>Optional</td>
	</tr>
	<tr>
		<td>message_thread_id</td>
		<td>Integer</td>
		<td>Optional</td>
	</tr>
</table>

```php
bot('sendMessage', [
	'chat_id' => $ccid,
	'sendMessage' => 'Hello World!'
]);
```
