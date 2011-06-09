<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * googlesearch
 * 
 * Google Weather API for CodeIgniter
 * 
 * This library for CodeIgniter uses Google Weather that is a unofficial API provided
 * by Google.  
 * 
 * @package googlesearch
 * @author Julian Magnone (julianmagnone@gmail.com)
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class googleweather
{
    private $ci;
    
    private $_api_url = "http://www.google.com/ig/api";
    private $_image_base_url = "http://www.google.com"; // base url used for images

    public function __construct($params = null)
    {
        // do something with params
        $this->ci =& get_instance();

        // config values
        //$this->ci->config->item('');
    }
    
    /**
     * googleweather::query()
     * 
     * $location can be a zip code, city, country, etc.
     * 
     * @return
     */
    public function query($location, $hl = 'en')
    {
        $url = $this->_api_url.'?weather='.urlencode($location).'&oe=utf-8'; // oe parameter fix for Spanish chars

        $xml = simplexml_load_file($url);
        
        $information = $xml->xpath("/xml_api_reply/weather/forecast_information");
		$current = $xml->xpath("/xml_api_reply/weather/current_conditions");
		$forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");
        
        /* Example how you can use this: 
        
		$current[0]->temp_f['data']; 
        $current[0]->temp_c['data'];
		$current[0]->condition['data'];
        $current[0]->icon['data'];
        $information[0]->city['data'];

        foreach ($forecast_list as $forecast) :
            $forecast->icon['data'];
            $forecast->day_of_week['data'];
            $forecast->low['data']; 
            $forecast->high['data'];
	        $forecast->condition['data'];
        endforeach;
        
        */
        
        $result = array(
                    'information' => $information,
                    'current' => $current,
                    'forecast_list' => $forecast_list
                );
        
        return $result;
    }
    
}

/* End of file googleweather.php */