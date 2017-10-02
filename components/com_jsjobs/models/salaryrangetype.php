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
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelSalaryRangeType extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_jobsalaryrangetype = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getSalaryRangeTypes($title) {
        $db = JFactory::getDBO();
        $query = "SELECT id, title FROM `#__js_job_salaryrangetypes` WHERE status = 1";
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.=" ORDER BY ordering ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $types = array();
        if ($title)
            $types[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($rows as $row) {
            $types[] = array('value' => $row->id, 'text' => JText::_($row->title));
        }
        return $types;
    }

    function getJobSalaryRangeType($title) {
        $db = JFactory::getDBO();
        if (!$this->_jobsalaryrangetype) {
            $query = "SELECT id, title FROM `#__js_job_salaryrangetypes`";
            if ($this->_client_auth_key != "")
                $query.=" WHERE serverid!='' AND serverid!=0";
            $query.=" ORDER BY ordering ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }
            $this->_jobsalaryrangetype = $rows;
        }
        $jobsalaryrangetype = array();
        if ($title)
            $jobsalaryrangetype[] = array('value' => JText::_(''), 'text' => $title);

        foreach ($this->_jobsalaryrangetype as $row) {
            $jobsalaryrangetype[] = array('value' => $row->id, 'text' => $row->title);
        }
        return $jobsalaryrangetype;
    }

}
?>
    
