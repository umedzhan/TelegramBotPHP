<?php

$conn = new mysqli('localhost', 'root', 'password', 'basename');
$TOKEN = 'BOT_TOKEN';
$channel = "CHANNEL_ID";

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


function sendMessage($text) {
	global $ccid;
	bot('sendMessage', [
		'chat_id' => $ccid,
		'text' => $text
	]);
}

function sendMusic($id) {
	global $ccid, $channel;
	bot('copyMessage', [
		'chat_id' => $ccid,
		'from_chat_id' => $channel,
		'message_id' => $id
	]);
}

if (isset($update['message']['audio'])) {
	$message = $update['message'];
	$ccid = $message['chat']['id'];
	$message_id = $message['message_id'];
	$title = $message['audio']['title'] ?? '';
	$performer = $message['audio']['performer'] ?? '';
	$file_name = $message['audio']['file_name'] ?? '';
	
	$music = bot('copyMessage', [
		'chat_id' => $channel,
		'from_chat_id' => $ccid,
		'message_id' => $message_id,
	]);
	
	$music_id = $music['result']['message_id'];
	
	sendMessage($title."\n".$performer."\n".$log['result']['message_id']);
	
	$sql = "INSERT INTO musics (id, title, performer, file_name, sender_id) VALUES (?, ?, ?, ?, ?)";
	$stmt = $conn -> prepare($sql);
	$stmt -> bind_param('sssss', $music_id, $title, $performer, $file_name, $ccid);
	
	if ($stmt -> execute()) {
		sendMessage('Saved');
	} else {
		sendMessage('Error: ' . $stmt -> error);
	}
}

if (isset($update['message']['text'])) {

	$message = $update['message'];
	$ccid = $message['chat']['id'];
	$text = isset($message['text']) ? $message['text'] : '';
	$message_id = $message['message_id'];
	
	file_put_contents('text/'.$ccid, $text);
	
	$text = $conn->real_escape_string($text);
	
	file_put_contents('offsets/'.$ccid, '0');
	
	$offset = file_get_contents('offsets/'.$ccid);
	
	$sql = "SELECT * FROM musics WHERE title LIKE '%$text%' OR performer LIKE '%$text%' LIMIT 10 OFFSET $offset";
	$result = $conn -> query($sql);
	if ($result -> num_rows > 0) {
		$i = 1;
		while ($row = $result -> fetch_assoc()) {
			$row_buttons[] = ['text' => $i, 'callback_data' => $row['id']];
			$title .= $i . ". " . $row['title'] . " - " . $row['performer'] . "\n";
			$i++;
			
			if (count($row_buttons) == 5) {
				$key[] = $row_buttons;
				$row_buttons = [];
			}
		}
		if (!empty($row_buttons)) {
			$key[] = $row_buttons;
		}
		$left_button = '⬅️';
		$right_button = '➡️';
		$delete_list = '❌';
		$key[] = [['text' => $left_button, 'callback_data' => 'left'], ['text' => $delete_list, 'callback_data' => 'delete'], ['text' => $right_button, 'callback_data' => 'right']];
		$response = bot('sendMessage', [
			'chat_id' => $ccid,
			'text' => $title,
			'reply_markup' => json_encode([
				'inline_keyboard' => $key
			]),
			'link_preview_options' => json_encode([
				'is_disabled' => true
			])
		]);
		file_put_contents('message_id/'.$ccid, $response['result']['message_id']);
	}
}

if (isset($update['callback_query'])) {
	
	$callbackQuery = $update['callback_query'];
	$text = $callbackQuery['data'];
	$ccid = $callbackQuery['message']['chat']['id'];
	$callbackMessageId = $callbackQuery['message']['message_id'];

	sendMusic($text);
	
	$get_offset_file = file_get_contents('offsets/'.$ccid);
	
	if ($text == 'right') {
		$offset_message_id = file_get_contents('message_id/'.$ccid);
		file_put_contents('offsets/'.$ccid, $get_offset_file + 10);

		$text = $conn->real_escape_string(file_get_contents('text/'.$ccid));

		$offset = file_get_contents('offsets/'.$ccid);

		$sql = "SELECT * FROM musics WHERE title LIKE '%$text%' OR performer LIKE '%$text%' LIMIT 10 OFFSET $offset";
		$result = $conn -> query($sql);
		if ($result -> num_rows > 0) {
			$i = 1;
			while ($row = $result -> fetch_assoc()) {
				$row_buttons[] = ['text' => $i, 'callback_data' => $row['id']];
				$title .= $i . ". " . $row['title'] . " - " . $row['performer'] . "\n";
				$i++;

				if (count($row_buttons) == 5) {
					$key[] = $row_buttons;
					$row_buttons = [];
				}
			}
			if (!empty($row_buttons)) {
				$key[] = $row_buttons;
			}
			$left_button = '⬅️';
			$right_button = '➡️';
			$delete_list = '❌';
			$key[] = [['text' => $left_button, 'callback_data' => 'left'], ['text' => $delete_list, 'callback_data' => 'delete'], ['text' => $right_button, 'callback_data' => 'right']];
			bot('editMessageText', [
				'chat_id' => $ccid,
				'message_id' => $offset_message_id,
				'text' => $title,
				'reply_markup' => json_encode([
					'inline_keyboard' => $key
				]),
				'link_preview_options' => json_encode([
					'is_disabled' => true
				])
			]);
		}
	}
	if ($text == 'left') {
		$offset_message_id = file_get_contents('message_id/'.$ccid);
		file_put_contents('offsets/'.$ccid, $get_offset_file - 10);

		$text = $conn->real_escape_string(file_get_contents('text/'.$ccid));

		$offset = file_get_contents('offsets/'.$ccid);

		$sql = "SELECT * FROM musics WHERE title LIKE '%$text%' OR performer LIKE '%$text%' LIMIT 10 OFFSET $offset";
		$result = $conn -> query($sql);
		if ($result -> num_rows > 0) {
			$i = 1;
			while ($row = $result -> fetch_assoc()) {
				$row_buttons[] = ['text' => $i, 'callback_data' => $row['id']];
				$title .= $i . ". " . $row['title'] . " - " . $row['performer'] . "\n";
				$i++;

				if (count($row_buttons) == 5) {
					$key[] = $row_buttons;
					$row_buttons = [];
				}
			}
			if (!empty($row_buttons)) {
				$key[] = $row_buttons;
			}
			$left_button = '⬅️';
			$right_button = '➡️';
			$delete_list = '❌';
			$key[] = [['text' => $left_button, 'callback_data' => 'left'], ['text' => $delete_list, 'callback_data' => 'delete'], ['text' => $right_button, 'callback_data' => 'right']];
			bot('editMessageText', [
				'chat_id' => $ccid,
				'message_id' => $offset_message_id,
				'text' => $title,
				'reply_markup' => json_encode([
					'inline_keyboard' => $key
				]),
				'link_preview_options' => json_encode([
					'is_disabled' => true
				])
			]);
		}
	}
	if ($text == 'delete') {
		$offset_message_id = file_get_contents('message_id/'.$ccid);
		bot('deleteMessage', [
			'chat_id' => $ccid,
			'message_id' => $offset_message_id
		]);
	}
}
