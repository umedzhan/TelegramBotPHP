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
		<th>Description</th>
	</tr>
	<tr>
		<td>business_connection_id</td>
		<td>String</td>
		<td>Optional</td>
		<td>Unique identifier of the business connection on behalf of which the message will be sent</td>
	</tr>
	<tr>
		<td>chat_id</td>
		<td>Integer or String</td>
		<td>Yes</td>
		<td>Unique identifier for the target chat or username of the target channel (in the format @channelusername)</td>
	</tr>
	<tr>
		<td>message_thread_id</td>
		<td>Integer</td>
		<td>Optional</td>
		<td>Unique identifier for the target message thread (topic) of the forum; for forum supergroups only</td>
	</tr>
	<tr>
		<td>text</td>
		<td>String</td>
		<td>Yes</td>
		<td>Text of the message to be sent, 1-4096 characters after entities parsing</td>
	</tr>
	<tr>
		<td>parse_mode</td>
		<td>String</td>
		<td>Optional</td>
		<td>Mode for parsing entities in the message text. See <a href="https://core.telegram.org/bots/api#formatting-options">formatting options</a> for more details.</td>
	</tr>
	<tr>
		<td>entities</td>
		<td>Array of <a href="https://core.telegram.org/bots/api#messageentity">MessageEntity</a></td>
		<td>Optional</td>
		<td>A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode</td>
	</tr>
	<tr>
		<td>link_preview_options</td>
		<td><a href="https://core.telegram.org/bots/api#linkpreviewoptions">LinkPreviewOptions</a></td>
		<td>Optional</td>
		<td>Link preview generation options for the message</td>
	</tr>
	<tr>
		<td>disable_notification</td>
		<td>Boolean</td>
		<td>Optional</td>
		<td>Sends the message <a href="https://telegram.org/blog/channels-2-0#silent-messages">silently</a>. Users will receive a notification with no sound.</td>
	</tr>
	<tr>
		<td>protect_content</td>
		<td>Boolean</td>
		<td>Optional</td>
		<td>Protects the contents of the sent message from forwarding and saving</td>
	</tr>
	<tr>
		<td>message_effect_id</td>
		<td>String</td>
		<td>Optional</td>
		<td>Unique identifier of the message effect to be added to the message; for private chats only</td>
	</tr>
	<tr>
		<td>reply_parameters</td>
		<td><a href="https://core.telegram.org/bots/api#replyparameters">ReplyParameters</a></td>
		<td>Optional</td>
		<td>Description of the message to reply to</td>
	</tr>
	<tr>
		<td>reply_markup</td>
		<td><a href="https://core.telegram.org/bots/api#inlinekeyboardmarkup">InlineKeyboardMarkup</a> or <br>
		<a href="https://core.telegram.org/bots/api#replykeyboardmarkup">ReplyKeyboardMarkup</a> or <br>
		<a href="https://core.telegram.org/bots/api#replykeyboardremove">ReplyKeyboardRemove</a> or <br>
		<a href="https://core.telegram.org/bots/api#forcereply">ForceReply</a></td> <br>
		<td>Optional</td>
		<td>Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove a reply keyboard or to force a reply from the user</td>
	</tr>
</table>
Other info <a href="https://core.telegram.org/bots/api#available-methods">Telegram Bot API</a>
<br><br>

- use sendMessage

```php
bot('sendMessage', [
	'chat_id' => $ccid,
	'sendMessage' => 'Hello World!'
]);
```
