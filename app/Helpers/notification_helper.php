<?php
if(!function_exists('warning')){
	function warning( string $text ): string {
		return view('templates/alert', ['text' => $text, 'type' => 'warning']);
	}
}

if(!function_exists('info')){
	function info( string $text ): string {
		return view('templates/alert', ['text' => $text, 'type' => 'info']);
	}
}