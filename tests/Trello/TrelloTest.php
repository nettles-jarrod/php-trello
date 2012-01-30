<?php

namespace Trello;

class TrelloTest extends \PHPUnit_Framework_TestCase
{
	protected $client;
	
	protected function setUp()
	{
		$this->client = new Trello('jarrodnettles', '10ffa5a656e1d25c78df6351283df1c0');
	}
	
	public function testBuildURL()
	{
		$method = new \ReflectionMethod($this->client, 'buildURL');
		$method->setAccessible(true);
		
		$expectedResult = 'https://api.trello.com/1/members/me/boards/all?key=10ffa5a656e1d25c78df6351283df1c0';
		
		$this->assertEquals($expectedResult, $method->invokeArgs($this->client, array(	'path'	=> '/members/me/boards/all',
																						'query'	=> '')));
	}
	
	public function testListBoards()
	{
		$result = $this->client->listBoards();
		$this->assertTrue(is_array($result));
	}
}