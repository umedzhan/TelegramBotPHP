```php
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'typing'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'upload_photo'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'record_video'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'upload_video'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'record_voice'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'upload_voice'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'upload_document'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'choose_sticker'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'find_location'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'record_video_note'
]);
bot('sendChatAction', [
	'chat_id' => $ccid,
	'action' => 'upload_video_note'
]);
bot('sendMessage', [
	'chat_id' => $ccid,
	'text' => 'sendChatAction'
]);
```