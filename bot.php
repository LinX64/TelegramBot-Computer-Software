<?php

$botToken = 'botToken';
$website = 'https://api.telegram.org/bot' . $botToken;

$update = file_get_contents( 'php://input' );
$update = json_decode( $update, TRUE );

$targetIndex = count( $update[ 'result' ] ) - 1;

$chatId = $update[ 'message' ][ 'chat' ][ 'id' ];

$botMode = 'notSet';
$command = 'notSet';
$user_first_name = 'notSet';
$user_last_name = 'notSet';

if ( isset( $update[ 'message' ][ 'text' ] )
	&& $update[ 'message' ][ 'text' ] != '' ) {

	$botMode = 'command';
	$command = $update[ 'message' ][ 'text' ];
	$user_first_name = $update[ 'message' ][ 'from' ][ 'first_name' ];
}
elseif ( isset( $update[ 'message' ][ 'new_chat_participant' ][ 'first_name' ] )
		&& $update[ 'message' ][ 'new_chat_participant' ][ 'first_name' ] != '' ) {
	
	$botMode = 'welcome';
	$user_first_name = $update[ 'message' ][ 'new_chat_participant' ][ 'first_name' ];

	if ( isset( $update[ 'message' ][ 'new_chat_participant' ][ 'last_name' ] )
		&& $update[ 'message' ][ 'new_chat_participant' ][ 'last_name' ] != '' ) {

		$user_last_name = $update[ 'message' ][ 'new_chat_participant' ][ 'last_name' ];
	}

}
elseif ( isset( $update[ 'message' ][ 'left_chat_participant' ][ 'first_name' ] )
		&& $update[ 'message' ][ 'left_chat_participant' ][ 'first_name' ] != '' ) {
	
	$botMode = 'goodbye';
	$user_first_name = $update[ 'message' ][ 'left_chat_participant' ][ 'first_name' ];

	if ( isset( $update[ 'message' ][ 'left_chat_participant' ][ 'last_name' ] )
		&& $update[ 'message' ][ 'left_chat_participant' ][ 'last_name' ] != '' ) {

		$user_last_name = $update[ 'message' ][ 'left_chat_participant' ][ 'last_name' ];
	}
}

$message = 'notSet';
$group_rules = '
	Please read the rules first and don\'t be shy to ask anything about this Bot or about the Group!

	Rules :

	1. Before asking anything, make sure you\'ve searched the question already!
	2. We don\'t talk too much here and this group is not a \'ChatRoom\'.
	** The new rules will be added soon
';

if ( $botMode == 'command' ) {

	switch ( $command ) {

		case '/about':

			$message = '
				This bot has been created for:

				`Computer Software & IOS-Android - Question/Answers`
				And it will help the others to find what they were looking for.

				You can invite your friends via : http://telegram.me/joinchat/Cd6oNT4fdIk1DqI5Hi3mXA
			';
		break;

		case '/contact':
		
			$message = '
				Contact me via:

				Ash.wxrz@hotmail.com
				Or you can find me in Telegram with: `LinX64` Username ...
			';
		break;

		case '/github':
			
			$message = '
				Here is the Github link of this Bot,
				if you\'d like to change or making this Bot Better than before ...

				Github:

				github.com/LinX64/TelegramBot-Computer-Software
			';
		break;

		default:

			$message = '
				I didn\'t understand your command !!
			';
		break;
	}
}
elseif ( $botMode == 'welcome' ) {
	
	if ( $user_last_name == 'notSet' ) {

		$message = '
			Welcome " ' . $user_first_name . ' " to our group !!
			' . $group_rules . '
		';
	}
	else {

		$message = '
			Welcome " ' . $user_first_name . ' ' . $user_last_name ' " to our group !!
			' . $group_rules . '
		';
	}
}
elseif ( $botMode == 'goodbye' ) {
	
	if ( $user_last_name == 'notSet' ) {

		$message = '
			Goodbye " ' . $user_first_name . ' " !!
			Hope we see you again in our group :)
		';
	}
	else {

		$message = '
			Goodbye " ' . $user_first_name . ' ' . $user_last_name ' " !!
			Hope we see you again in our group :)
		';
	}
}

sendMessage( $message );

function sendMessage( $message ) {

	global $website, $chatId;

	$url = $website . '/sendMessage?chat_id=' . $chatId . '&text=' . urlencode( $message );
	file_get_contents( $url );
}