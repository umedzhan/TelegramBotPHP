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
	
  	if ($text == '/sendmessage') {
		bot('sendMessage' , [
  			'chat_id' => $ccid,
  			'text' => 'MessageText Parse Mode With HTML
  			
<b>Bold</b>
<i>Italic</i>
<u>Underline</u>
<s>Strike</s>
<a href="google.com">Google link</a>
<code>Code</code>
<pre language="copy">Copy</pre>',
  			'parse_mode' => 'html'
  		]);
  	}
}
```