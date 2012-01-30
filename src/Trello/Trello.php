<?php

namespace Trello;

/**
 * 
 */
class Trello
{
	protected $apiKey;
	protected $user;
	
	/**
	 * @param string $user
	 * @param string $apiKey
	 */
	public function __construct($user, $apiKey)
	{
		$this->user = $user;
		$this->apiKey = $apiKey;
	}
	
	/**
	 * Build the request URL for the Trello API call.
	 * @param string $path
	 * @param string $query
	 * @return string
	 */
	protected function buildURL($path, $query = '')
	{
		$apiURL = 'https://api.trello.com/1' . $path; 
		$apiURL .= '?key=' . $this->apiKey;
		
		if(strlen($query) > 0)
		{
			$apiURL .= '&' . urlencode($query);
		}
		
		return $apiURL;
	}
	
	/**
	 * Lists all boards associated with the requested user.
	 * @return Board[]
	 * @throws Exception
	 */
	public function listBoards()
	{
		$url = $this->buildURL('/members/'.$this->user.'/boards/all');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = json_decode(curl_exec($ch));
		$httpResponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if($httpResponse !== 200)
		{
			throw new Exception('Resource unavailable.');
		}
		
		curl_close($ch);
		
		$results = array();
		
		foreach($data as $b)
		{
			$board = new Board($b->id);
			$results[] = $board;
		}
		
		return $results;
	}
}









