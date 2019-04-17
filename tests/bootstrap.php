<?php

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .

if(@!include __DIR__.'/../vendor/autoload.php'){
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}

// configure environment
Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');

// create temporary directory
define('TEMP_DIR', __DIR__.'/tmp/'.getmypid());
$concurrentDirectory = dirname(TEMP_DIR);
if(!mkdir($concurrentDirectory) && !is_dir($concurrentDirectory)){
	throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
}
Tester\Helpers::purge(TEMP_DIR);

function test(\Closure $function){
	$function();
}

class Notes{
	static public $notes = [];


	public static function add($message):void{
		self::$notes[] = $message;
	}


	public static function fetch():array{
		$res = self::$notes;
		self::$notes = [];

		return $res;
	}

}
