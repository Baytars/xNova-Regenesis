<?php 

if(!defined("INSIDE")){ die("attemp hacking"); }

class test
{

	function testfunction($data = false)
	{
		$test = $data;
		return $test;
	}

}

$test = new test();

?>