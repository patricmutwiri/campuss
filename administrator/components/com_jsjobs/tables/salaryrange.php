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
class TableSalaryRange extends JTable {

    /** @var int Primary key */
    var $id = null;

    /** @var string */
    var $rangevalue = null;

    /** @var string */
    var $rangestart = null;

    /** @var string */
    var $rangeend = null;
    var $status = 0;
    var $ordering = null;
    var $isdefault = null;

    function __construct(&$db) {
        parent::__construct('#__js_job_salaryrange', 'id', $db);
    }

    /**
     * Validation
     * 
     * @return boolean True if buffer is valid
     * 
     */
    function check() {
        return true;
    }

}

?>
