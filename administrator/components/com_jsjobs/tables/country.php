<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

defined('_JEXEC') or die('Restricted access');

// our table class for the application data
class TableCountry extends JTable {

    var $id = null;
    var $name = null;
    var $shortCountry = null;
    var $continentID = null;
    var $dialCode = null;
    var $enabled = '0';

    function __construct(&$db) {
        parent::__construct('#__js_job_countries', 'id', $db);
    }

    /**
     * Validation
     * 
     * @return boolean True if buffer is valid
     * 
     */
    function check() {
        $var = trim($this->name);
        if(empty($var)){
            return false;
        }
        return true;
    }

}

?>
