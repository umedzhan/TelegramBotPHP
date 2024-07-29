```php
if ($text == '/sendphoto') {
    bot('sendPhoto' , [
        'chat_id' => $ccid,
        'photo' => "https://www.php.net/images/meta-image.png",
        'caption' => "Caption for photo.."
    ]);
}
```

```
business_connection_id : String,
chat_id : require : Integer or String,
message_thread_id : Integer,
photo : require,
caption : String,
parse_mode : String,
caption_entities : String,
show_caption_above_media : optional,
has_spoiler : optional : Boolean,
disable_notification : Boolean,
protect_content : Boolean,
message_effect_id : String,
reply_parameters : Coming soon,
reply_markup : /reply_markup
```