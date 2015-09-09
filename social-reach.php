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
		$fastbutton = file_get_contents('https://plusone.google.com/_/+1/fastbutton?url='.urlencode($url));
		preg_match( '/window\.__SSR = {c: ([\d]+)/', $fastbutton, $matches);
		if(isset($matches[0])) {
      return intval(str_replace('window.__SSR = {c: ', '', $matches[0]));
    }
    return 0;
	}
}

?>