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

class JSJobsModelSharingservicelog extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getAllSharingServiceLog($searchuid, $searchusername, $searchrefnumber, $searchstartdate, $searchenddate, $limitstart, $limit) {
        $db = $this->getDbo();
        $wherequery = '';
        $clause = " WHERE ";
        if ($searchuid)
            if (is_numeric($searchuid)) {
                $wherequery .= $clause . " sharelog.uid = " . (int) $searchuid;
                $clause = " AND ";
            }
        if ($searchrefnumber)
            if (is_numeric($searchrefnumber)) {
                $wherequery .= $clause . " sharelog.referenceid = " . (int) $searchrefnumber;
                $clause = " AND ";
            }
        if ($searchusername) {
            $wherequery .= $clause . " user.name LIKE '%" . str_replace("'", '', $db->quote($searchusername)) . "%'";
            $clause = " AND ";
        }
        if ($searchstartdate) {
            $wherequery .= $clause . " DATE(sharelog.datetime) >= DATE(" . $db->quote(date('Y-m-d', strtotime($searchstartdate))) . ")";
            $clause = " AND ";
        }
        if ($searchenddate) {
            $wherequery .= $clause . " DATE(sharelog.datetime) <= DATE(" . $db->quote(date('Y-m-d', strtotime($searchenddate))) . ")";
            $clause = " AND ";
        }

        //total query
        $query = "SELECT COUNT(sharelog.id) AS total 
                        FROM `#__js_job_sharing_service_log` AS sharelog
                        LEFT JOIN `#__users` AS user ON user.id = sharelog.uid";
        $query .= $wherequery;
        $db->setQuery($query);
        $total = $db->loadResult();

        $query = "SELECT sharelog.*, user.name AS username
                        FROM `#__js_job_sharing_service_log` AS sharelog
                        LEFT JOIN `#__users` AS user ON user.id = sharelog.uid";
        $query .= $wherequery . " ORDER BY sharelog.datetime DESC";

        $db->setQuery($query, $limitstart, $limit);
        $sharelog = $db->loadObjectList();

        $lists['uid'] = $searchuid;
        $lists['username'] = $searchusername;
        $lists['refnumber'] = $searchrefnumber;
        $lists['startdate'] = $searchstartdate;
        $lists['enddate'] = $searchenddate;

        $return[0] = $sharelog;
        $return[1] = $total;
        $return[2] = $lists;

        return $return;
    }

}

?>