<?php
namespace application\helpers\tdcashe;
/**
 * Description of tdCashe
 *
 * @author admin
 */
class tdCashe {
    private static  $inst =false;
    
    public static function getCasheObj(){
        if(self::$inst===false){
            self::$inst = new self;
        }
        return self::$inst;
    }
    
    // Length of time to cache a file (in seconds)
    public $cache_time = 3600;
	// Cache file extension
	public $cache_extension = '.cache';
	    /**
     * This is just a functionality wrapper function
     * @param type $label
     * @param type $url
     * @return type
     */
    public function get_data($label, $url)
	{
		if($data = $this->get_cache($label)){
			return $data;
		} else {
			$data = $this->do_curl($url);
			$this->set_cache($label, $data);
			return $data;
		}
	}

    /**
     *
     * @param type $label
     * @param type $data
     */
    public function set_cache($label, $data)
	{
        if(is_array($data)){
        file_put_contents(CASHE_PATH . $this->safe_filename($label) . $this->cache_extension, serialize($data));
                }else{
		file_put_contents(CASHE_PATH . $this->safe_filename($label) . $this->cache_extension, $data);
        }
    }

    /**
     *
     * @param type $label
     * @return boolean
     */
    public function get_cache($label)
	{
		if($this->is_cached($label)){
			$filename = CASHE_PATH . $this->safe_filename($label) . $this->cache_extension;
                  $data = file_get_contents($filename);


            if ($this->is_serialized($data) == TRUE) {
                return unserialize($data);
            } else {
                return $data;
            }
        }
		return false;
	}

    /**
     *
     * @param type $label
     * @return boolean
     */
    public function is_cached($label)
	{
		$filename = CASHE_PATH . $this->safe_filename($label) . $this->cache_extension;
        if(file_exists($filename) && (filemtime($filename) + $this->cache_time >= time())) return true;
		return false;
	}

    /**
     * Helper function for retrieving data from url
     * @param type $url
     * @return type
     */
    public function do_curl($url)
	{
		if(function_exists("curl_init")){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			$content = curl_exec($ch);
			curl_close($ch);
			return $content;
		} else {
			return file_get_contents($url);
		}
	}
	/**
     * Helper function to validate filenames
     * @param type $filename
     * @return type
     */
    private function safe_filename($filename)
	{
		return preg_replace('/[^0-9a-z\.\_\-]/i','', strtolower($filename));
	}
        /**
         * 
         * @param type $value
         * @param type $result
         * @return boolean
         */
        private function is_serialized($value, &$result = null)
{
	// Bit of a give away this one
	if (!is_string($value))
	{
		return false;
	}

	// Serialized false, return true. unserialize() returns false on an
	// invalid string or it could return false if the string is serialized
	// false, eliminate that possibility.
	if ($value === 'b:0;')
	{
		$result = false;
		return true;
	}

	$length	= strlen($value);
	$end	= '';

	switch ($value[0])
	{
		case 's':
			if ($value[$length - 2] !== '"')
			{
				return false;
			}
		case 'b':
		case 'i':
		case 'd':
			// This looks odd but it is quicker than isset()ing
			$end .= ';';
		case 'a':
		case 'O':
			$end .= '}';

			if ($value[1] !== ':')
			{
				return false;
			}

			switch ($value[2])
			{
				case 0:
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				break;

				default:
					return false;
			}
		case 'N':
			$end .= ';';

			if ($value[$length - 1] !== $end[0])
			{
				return false;
			}
		break;

		default:
			return false;
	}

	if (($result = @unserialize($value)) === false)
	{
		$result = null;
		return false;
	}
	return true;
}
}