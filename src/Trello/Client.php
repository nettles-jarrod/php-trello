<?php

namespace Trello;

class Client
{
	protected $apiKey;
	protected $authToken;
	protected $authTokenKey;
	protected $authConsumerKey;
	protected $authConsumer;
	
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
		
	}	
}