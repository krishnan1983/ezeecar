<?php
/**
 * Systemwide Logger.
 * Writes to an app.log file - used for debugging
 * @author nitin.ahuja
 *
 */
class Pp_Logger 
{
	/**
	 * Setup the systemwide Logger instance 
	 * @param $config
	 * @return null
	 */
	public static function setup(Zend_Config_Ini $config)
	{
		$filename = $config->log->filename;
		$logLevel = (int)$config->log->level;
		
		$writer = new Zend_Log_Writer_Stream($filename);
		$writer->addFilter(new Zend_Log_Filter_Priority($logLevel));
		
		$logger = new Zend_Log($writer);
		
		Zend_Registry::set('logger', $logger);

		//Set the default timezone
		date_default_timezone_set('America/Los_Angeles');
	}
	
	/**
	 * Get the logger
	 * @return Th_Logger
	 */
	public static function getInstance()
	{
		return(Zend_Registry::get('logger'));
	}
	
	/**
	 * Short version (less typing). Use strictly for debugging
	 * Usage: Logger::debug(<debug message>)
	 * 
	 * @param $aString
	 * @return unknown_type
	 */
	public static function debug($aString)
	{
	  Logger::getInstance()->debug($aString);  
	}
	
	/**
	 * Log back trace calling methods
	 * 
	 * @param $aDeep - how deep to trace in the stack
	 * @param $aArgDetail - bool: show all or brief details
	 */
	public static function trace($aDeep = 1, $aArgDetail = false)
	{
        $output = "";
        $raw = debug_backtrace();
       
        foreach ($raw as $key => $entry) {
        	if ($key == 0 ||
        		($aDeep < 0 && $key == 1)) {
        		continue;
        	}
        	if ($aDeep >= 0 && $key > $aDeep+1) {
        		break;
        	}
        	
        	$idx = $key-1;
        	$output .= "\n#{$idx} ";
        	if ($aArgDetail) {
        		$arg = print_r($entry['args'], 1);
        	} else {
        		$arg = implode(', ', $entry['args']);
        	}
        	
        	if (isset($entry['class'])) {
        		$output .= "{$entry['class']}{$entry['type']}{$entry['function']}({$arg}) ";
        	} else {
        		$output .= "{$entry['function']}({$arg}) ";
        		if (isset($entry['file'])) {
        			$output .= "{$entry['file']}:{$entry['line']}";
        		}
        	}
        }

        self::debug($output);		
	}

	/**
	 * Dump all the trace log
	 * 
	 * @param $aArgDetail - bool: show all or brief details
	 */
	public static function traceAll($aArgDetail = false)
	{
		self::trace(-1, $aArgDetail);	
	}
	
}
