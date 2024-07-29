```php
bot('sendMessage', [
	'chat_id' => $ccid,
	'text' => 'Remove Keyboard',
	'reply_markup' => json_encode([
		'remove_keyboard' => true
	])
]);
```