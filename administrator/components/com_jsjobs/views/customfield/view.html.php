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

class JSJobsViewCustomfield extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formuserfield') {      // user fields
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('customfield')->getUserFieldbyId($c_id);
            $fieldfor = JRequest::getVar('fieldfor');
            if (empty($fieldfor))
                $fieldfor = JRequest::getVar('ff');
            if (empty($fieldfor))
                $fieldfor = $session->get('ff');
            if ($fieldfor == 3)
                $section = $this->getJSModel('fieldordering')->getResumeSections($c_id);
            if (isset($section))
                $this->assignRef('resumesection', $section);
            $this->assignRef('userfield', $result[0]);
            $this->assignRef('fieldvalues', $result[1]);
            $this->assignRef('fieldfor', $fieldfor);
            $isNew = true;
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('User Field') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::save('customfield.saveuserfield');
            if ($isNew)
                JToolBarHelper::cancel('customfield.cancel');
            else
                JToolBarHelper::cancel('customfield.cancel', 'Close');
        }elseif ($layoutName == 'userfields') {
            $ff = JRequest::getVar('ff');
            $session->set('ff',$ff);
            JToolBarHelper::addNew('customfield.add');
            JToolBarHelper::editList('customfield.add');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'customfield.remove');
            JToolBarHelper::cancel('customfield.cancel');

            if ($ff == 11 || $ff == 12 || $ff == 13)
                JToolBarHelper::title(JText::_('Visitor User Fields'));
            else
                JToolBarHelper::title(JText::_('User Fields'));
            $form = 'com_jsjobs.customfield.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchtype = $mainframe->getUserStateFromRequest($form . 'searchtype', 'searchtype', '', 'string');
            $searchrequired = $mainframe->getUserStateFromRequest($form . 'searchrequired', 'searchrequired', '', 'string');

            $result = $this->getJSModel('customfield')->getUserFields($ff, $searchtitle, $searchtype , $searchrequired, $limitstart, $limit); // 1 for company
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('fieldfor', $ff);
            $this->assignRef('pagination', $pagination);
        }
//        layout end

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
