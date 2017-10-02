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

class TableJobSearch extends JTable {

    /** @var int Primary key */

    var $id = null;
    var $uid = null;
    var $searchname = null;
    var $searchparams = null;
    var $params = null;
    var $created = null;
    var $status = null;

    function __construct(&$db) {
        parent::__construct('#__js_job_jobsearches', 'id', $db);
    }

    /**
     * Validation
     * 
     * @return boolean True if buffer is valid
     * 
     */
    function check() {
        if (trim( $this->searchname) == '') {
          return false;
        }
        return true;
    }
}
?>