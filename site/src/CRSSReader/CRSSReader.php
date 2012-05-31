<?php
/**
* RSS Extractor and Displayer
*
* @package LydiaCore
*/
class CRSSReader{
	/**
	* Members
	*/
	public $RSS_Content = array();
	
	/**
	* Constructor
	*/
	public function __construct(){
		;
	}
	
	/**
	* Pick up the interesting information from the RSS feed.
	*
	* @return array with information gathered from the RSS feed.
	*/
	private function RSS_Tags($item, $type = null){
		$y = array();
		$tnl = $item->getElementsByTagName("title");
		$tnl = $tnl->item(0);
		$title = $tnl->firstChild->textContent;

		$tnl = $item->getElementsByTagName("link");
		$tnl = $tnl->item(0);
		$link = $tnl->firstChild->textContent;
		
		if($type == 'all'){
			$tnl = $item->getElementsByTagName("pubDate");
			$tnl = $tnl->item(0);
			$date = $tnl->firstChild->textContent;		

			$tnl = $item->getElementsByTagName("description");
			$tnl = $tnl->item(0);
			$description = $tnl->firstChild->textContent;
			
			$y["date"] = $date;
			$y["description"] = $description;
		}
		$y["link"] = $link;
		$y["title"] = $title;

		return $y;
	}

	/**
	* Creates an array for the RSS feed and loops through each hit.
	*/
	private function RSS_Retrieve($url, $type){
		$doc  = new DOMDocument();
		$doc->load($url);

		$channels = $doc->getElementsByTagName("channel");

		$this->RSS_Content = array();

		foreach($channels as $channel){
			$items = $channel->getElementsByTagName("item");
			foreach($items as $item){
				$y = $this->RSS_Tags($item, $type);
				array_push($this->RSS_Content, $y);
			}
		}
	}

	/**
	* Read RSS feed and extract links and titles and combine them to a link.
	*
	* @return list of links.
	*/
	public function RSS_Links($url, $size = 15){
		$page = "<div class='rss-list'>";

		$this->RSS_Retrieve($url, 'links');
		if($size > 0)
			$recents = array_slice($this->RSS_Content, 0, $size);

		foreach($recents as $article){
			$title = $article["title"];
			$link = $article["link"];
			$page .= "<a href=\"$link\">$title</a><br />";			
		}

		return $page."</div>";
	}
	
	/**
	* Read RSS feed and extract information
	*
	* Displays a "complete" table of the important information from a RSS feed.
	*/
	public function RSS_Display($url, $size = 15, $site = 0, $withdate = 0){
		$opened = false;
		$page = "";
		$site = (intval($site) == 0) ? 1 : 0;

		$this->RSS_Retrieve($url, 'all');
		if($size > 0){
			$recents = array_slice($this->RSS_Content, $site, $size + 1 - $site);
		}
		
		foreach($recents as $article){
			$title = $article["title"];
			$link = $article["link"];
			
			$page .= "<div class='rss-feed'>";
			$page .= "<h6><a href=\"$link\">$title</a></h6>";
			if($withdate){
				$date = $article["date"];
				$page .= "<p class='smaller-text'><em>".$date.'</em></span>';
			}
			$description = $article["description"];
			if($description != false){
				$page .= "<p>$description</p>";
			}
			$page .= "</div>";
		}
		return $page;
	}
}