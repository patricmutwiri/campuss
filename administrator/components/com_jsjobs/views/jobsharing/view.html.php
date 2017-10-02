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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewJobsharing extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'jobshare') {        //resume search
            JToolBarHelper::title(JText::_('Job Sharing Service'));
            $session = JFactory::getSession();
            $synchronizedata = $session->get('synchronizedatamessage');
            $session->clear('synchronizedatamessage');
            $empty = 'empty';
            $this->assignRef('result', $empty);
            if ($synchronizedata != "") {
                $this->assignRef('result', $synchronizedata);
            }
        } elseif ($layoutName == 'jobsharelog') {        //resume search
            JToolBarHelper::title(JText::_('Job Share Log'));
            $searchuid = $mainframe->getUserStateFromRequest($option . 'searchuid', 'searchuid', '', 'string');
            $searchusername = $mainframe->getUserStateFromRequest($option . 'searchusername', 'searchusername', '', 'string');
            $searchrefnumber = $mainframe->getUserStateFromRequest($option . 'searchrefnumber', 'searchrefnumber', '', 'string');
            $searchstartdate = $mainframe->getUserStateFromRequest($option . 'searchstartdate', 'searchstartdate', '', 'string');
            $searchenddate = $mainframe->getUserStateFromRequest($option . 'searchenddate', 'searchenddate', '', 'string');

            $result = $this->getJSModel('sharingservicelog')->getAllSharingServiceLog($searchuid, $searchusername, $searchrefnumber, $searchstartdate, $searchenddate, $limitstart, $limit);
            $this->assignRef('servicelog', $result[0]);
            $this->assignRef('lists', $result[2]);
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
