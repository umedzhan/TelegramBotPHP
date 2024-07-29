```php
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
```
