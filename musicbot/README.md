# Music Bot

## Kiritilishi kerak bo'lgan maydonlar!!!
```php
$conn -> mysqli('localhost', 'username', 'password', 'basename');
$TOKEN = "YOUR_BOT_TOKEN";
$channel = "YOUR_CHANNEL_ID";
```

## MySQL bazasini yaratib olish
```sql
CREATE DATABASE musicbot;

USE musicbot;

CREATE TABLE `musics` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `performer` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `sender_id` varchar(50) DEFAULT NULL
);
```
