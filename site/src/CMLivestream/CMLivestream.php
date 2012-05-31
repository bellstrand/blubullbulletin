<?php
/**
* A model for controller CCLivestream
*/
class CMLivestream{
	/**
	* Members
	*/
	public $streams=array(
		array('site'=>'own3d', 'channel'=>'LINKDotA', 'id'=>'117967'),
		array('site'=>'own3d', 'channel'=>'AnnyungPrime', 'id'=>'250231'),
		array('site'=>'own3d', 'channel'=>'MarineKingPrime', 'id'=>'195167'),
		array('site'=>'own3d', 'channel'=>'Na`Vi.Dendi', 'id'=>'106735'),
		array('site'=>'own3d', 'channel'=>'EmpireKas', 'id'=>'78800'),
		array('site'=>'own3d', 'channel'=>'Loda', 'id'=>'73096'),
		
		array('site'=>'twitch', 'channel'=>'comewithme'),
		array('site'=>'twitch', 'channel'=>'benjisc2'),
		array('site'=>'twitch', 'channel'=>'crs_saintvicious'),
		array('site'=>'twitch', 'channel'=>'beyondthesummit'),
		array('site'=>'twitch', 'channel'=>'othersense'),
		array('site'=>'twitch', 'channel'=>'moonmeander'),
		array('site'=>'twitch', 'channel'=>'millfeast'),
		array('site'=>'twitch', 'channel'=>'lucifron7'),
		array('site'=>'twitch', 'channel'=>'dignitasapollo'),
		array('site'=>'twitch', 'channel'=>'ignproleague'),
		array('site'=>'twitch', 'channel'=>'TeamLiquidNet'),
		array('site'=>'twitch', 'channel'=>'aafcat'),
		array('site'=>'twitch', 'channel'=>'atncloud'),
		array('site'=>'twitch', 'channel'=>'tslrevival'),
		array('site'=>'twitch', 'channel'=>'whitera'),
		array('site'=>'twitch', 'channel'=>'esvision'),
		array('site'=>'twitch', 'channel'=>'orbtl'),
		array('site'=>'twitch', 'channel'=>'ggnetpurge'),
		array('site'=>'twitch', 'channel'=>'onemoregametv'),
		array('site'=>'twitch', 'channel'=>'thaticicle'),
		array('site'=>'twitch', 'channel'=>'kaostv'),
		array('site'=>'twitch', 'channel'=>'kungentv'),
		array('site'=>'twitch', 'channel'=>'starladder1'),
		array('site'=>'twitch', 'channel'=>'sheever'),
	);
	
	/**
	* Constructor
	*/
	public function __construct(){
		;
	}
	
	/**
	* Gathers information about streams from own3d and twitch
	*
	* @return array with stream information.
	*/
	private function getStream($channel_type, $channel, $id=null){
		$result = array();
		switch($channel_type){
			case 'twitch':
				$json_file = @file_get_contents("http://api.justin.tv/api/stream/list.json?channel={$channel}", 0, null, null);
				$json_array = json_decode($json_file, true);
				$result['channel'] = $channel;
				$result['link'] = "http://www.twitch.tv/".$channel;
				if(isset($json_array[0]['name']) && $json_array[0]['name'] == "live_user_{$channel}"){
					$result['isLive'] = true;
					$result['viewers'] = $json_array[0]['channel_count'];
				}
				else{
					$result['isLive'] = false;
					$result['viewers'] = 0;
				}
			break;
			case 'own3d':
				$own3d = "http://api.own3d.tv/liveCheck.php?live_id=$id";
				$xml = simplexml_load_file($own3d);
				$result['channel'] = $channel;
				$result['link'] = "http://www.own3d.tv/live/$id";
				$result['isLive'] = (string)$xml->liveEvent->isLive;
				$result['viewers'] = (string)$xml->liveEvent->liveViewers;
			break;
		}
		return $result;
	}
	
	/**
	* uses getStream function to gather information about the streams and sorts the array.
	*
	* @return array with sorted stream information
	*/
	public function getStreamSorted(){
		$arr=array();
		foreach($this->streams as $val){
			$arr[]=($this->getStream($val['site'], $val['channel'], isset($val['id']) ? $val['id'] : 0));
		}
		$sort_col = array();
		foreach($arr as $key => $val){
		    $sort_col[$key] = $val['viewers'];
		}
		array_multisort($sort_col, SORT_DESC, $arr);

		$result = '';
		foreach($arr as $val){
			if($val['isLive']){
				$result.="<a href='{$val['link']}'>{$val['channel']} [{$val['viewers']}]</a><br />";
			}
		}
		return $result;
	}
}