<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Path to PHPTAL library, i used 1.2.0
include 'phptal/PHPTAL.php';


/**
* Wrapper for PHPTAL tempalte engine
*/

class Tal extends PHPTAL{


    function __construct()
    {

        //Call PHPTAL constructor (because we can)

        parent::__construct();


        /**
        * Use CI config to set encoding, templates and compiled templates path
        */

        $CI = &get_instance(); //BUGGGGGG!!!! CI FORUM BUG, REMOVE the ; SYNTAX ERROR!


        /**
        * You can change paths if you need to
        */

        $cache_path = $CI->config->item('cache_path');

        if(empty($cache_path))
        {
            $cache_path = APPPATH.'cache/';
        }


        $this->setEncoding($CI->config->item('charset'));
        $this->setTemplateRepository(APPPATH.'views/');
        $this->setPhpCodeDestination($cache_path);


    }


    /**
    * @param string  (template name or path)
    * @param boolean (set TRUE to return page content)
    * @result mixed (depends on second parameter)
    *
    * This method returns or echoes parsed tempalte content
    */

    function display($tpl, $return=true)
    {

        $this->setTemplate($tpl);

        if($return){

            $retval = $this->execute();
            
            $path = dirname($tpl);
		    $dir = base_url().'views/'.$path;
		    
            $retval = preg_replace("/(<link rel=\"stylesheet\" href=)\"([^\/][\w\/\.\-\_\?]*)\"/i", "\\1\"{$dir}/\\2\"", $retval);
            $retval = preg_replace("/(<link href=)\"([^\/][\w\/\.\-\_\?]*)\"/i", "\\1\"{$dir}/\\2\"", $retval);
		    $retval = preg_replace("/(src=)\"([^\/][\w\/\.\-\_]*)\"/i", "\\1\"{$dir}/\\2\"", $retval);	
            
            echo $retval; 
            exit;

        }

        $this->echoExecute();

    }



}


?>  
