```php
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
```
