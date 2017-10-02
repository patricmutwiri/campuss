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

class JSJobsViewCareerlevel extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//layout start
        if ($layoutName == 'formcareerlevels') {          // jobtypes
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true AND $c_id != 0)
                $application = $this->getJSModel('careerlevel')->getJobCareerLevelbyId($c_id);
            if (isset($application->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Job Career Levels') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::apply('careerlevel.savejobcareerlevelsave', 'Save');
            JToolBarHelper::save2new('careerlevel.savejobcareerlevelandnew');
            JToolBarHelper::save('careerlevel.savejobcareerlevel');
            if ($isNew)
                JToolBarHelper::cancel('careerlevel.cancel');
            else
                JToolBarHelper::cancel('careerlevel.cancel', 'Close');
        }elseif ($layoutName == 'careerlevels') {        //job types
            JToolBarHelper::title(JText::_('Career Levels'));
            JToolBarHelper::addNew('careerlevel.editcareerlevels');
            JToolBarHelper::editList('careerlevel.editcareerlevels');
            JToolBarHelper::deleteList(JText::_("Are You Sure?"), 'careerlevel.remove');
            $form = 'com_jsjobs.careerlevel.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');            
            $result = $this->getJSModel('careerlevel')->getAllCareerLevels($searchtitle, $searchstatus, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
//layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
