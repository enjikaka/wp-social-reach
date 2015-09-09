<?php

class Social_Reach {
	protected $url;

	public function __construct($url) {
		$this->url = $url;
		return $this;
	}

	public function tweet_count() {
		$json = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $this->url);
		$arr = json_decode($json, true);

		return intval($arr['count']);
	}

	public function facebook_likes_count() {
		$json = file_get_contents('http://graph.facebook.com/?ids=' . $this->url);
		$arr = json_decode($json, true);

		return intval($json[$this->url]['shares']);
	}

	public function google_plus_one_count() {
		$curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
	    curl_setopt($curl, CURLOPT_POST, 1);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $this->url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	    $curl_results = curl_exec ($curl);
	    curl_close ($curl);
	 
	    $json = json_decode($curl_results, true);
	 
	    return intval($json[0]['result']['metadata']['globalCounts']['count']);
	}
}

?>