<?php

function event($title,$content,$page){

	if(!file_exists(EVENT_FILE)) touch(EVENT_FILE);
	$events = json_decode(file_get_contents(EVENT_FILE));
	$event = (object) array();
	$event->title = $title;
	$event->date = date('d/m/Y H:i:s');
	$event->link = $_SERVER['HTTP_REFERER'].$page;
	$event->content =$content;
	$events[] = $event;
	file_put_contents(EVENT_FILE, json_encode($events));
}
?>