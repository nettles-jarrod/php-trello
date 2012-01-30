<?php

namespace Trello;

class Client
{
	protected $apiKey;
	protected $authToken;
	protected $authTokenKey;
	protected $authConsumerKey;
	protected $authConsumer;
	
	/**
	 * 
	 * @param unknown_type $apiKey
	 * @param unknown_type $apiToken
	 * @param unknown_type $apiSecret
	 * @param unknown_type $tokenSecret
	 */
	public function __construct($apiKey, $apiToken, $apiSecret = null, $tokenSecret = null)
	{
		
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
		
		if(!empty($this->authTokenKey))
		{
			$apiURL .= '?key=' . $this->authTokenKey;
			$apiURL .= '&token='.$this->authConsumerKey;
		}
		else
		{
			$apiURL .= '?key=' . $this->apiKey;
			$apiURL .= '&token=' . $this->authToken;
		}
		
		if(strlen($query) > 0)
		{
			$apiURL .= '&' . urlencode($query);
		}
		
		return $apiURL;
	}
	
	public function listBoards()
	{
		$url = $this->buildURL('/members/me/boards/all');
		
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
			$board = new Board($b['id']);
			$board->name = $b['name'];
			$board->description  = $b['desc'];
			$board->closed  = $b['closed'];
			$board->url  = $b['url'];
		}
		
		return $results;
	}	
}









