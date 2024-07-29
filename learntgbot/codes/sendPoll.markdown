```php
bot('sendPoll', [
	'chat_id' => $ccid,
	'question' => 'Are you Okay?',
	'options' => json_encode([
		['text' => 'Yes Okay'],
		['text' => 'No Im not']
	]),
	'type' => 'regular',
	'correct_option_id' => 0
]);
```