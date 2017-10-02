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

class JSJobsViewFieldordering extends JSView { 

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        //layout start
        if ($layoutName == 'fieldsordering') {          // field ordering
            $fieldfor = JRequest::getVar('ff', 0);
            $session = JFactory::getSession();
            $session->set('fieldfor', $fieldfor);
            $fieldfor = $session->get('fieldfor');

            JToolBarHelper::addNew('fieldordering.editjobuserfield');
            JToolBarHelper::editList('fieldordering.editjobuserfield');
            
            JToolBarHelper::publishlist('fieldordering.fieldpublished');
            JToolBarHelper::unpublishlist('fieldordering.fieldunpublished');
            JToolBarHelper::custom('fieldordering.visitorfieldpublished', 'publish.png', '', 'Visitor Publish', true);
            JToolBarHelper::custom('fieldordering.visitorfieldunpublished', 'delete.png', '', 'Visitor Unpublish', true);
            JToolBarHelper::custom('fieldordering.fieldrequired', 'publish.png', '', 'Required', true);
            JToolBarHelper::custom('fieldordering.fieldnotrequired', 'delete.png', '', 'Not Required', true);

            if ($fieldfor)
                $session->set('fford',$fieldfor);
            else
                $fieldfor = $session->get('fford');

            if ($fieldfor == 11 || $fieldfor == 12 || $fieldfor == 13)
                JToolBarHelper::title(JText::_('Visitor Fields'));
            else
                JToolBarHelper::title(JText::_('Fields'));
            $form = 'com_jsjobs.fieldordering.list.';
            $fieldtitle = $mainframe->getUserStateFromRequest($form . 'fieldtitle', 'fieldtitle', '', 'string');
            $userpublish = $mainframe->getUserStateFromRequest($form . 'userpublish', 'userpublish', '', 'string');            
            $visitorpublish = $mainframe->getUserStateFromRequest($form . 'visitorpublish', 'visitorpublish', '', 'string');            
            $fieldrequired = $mainframe->getUserStateFromRequest($form . 'fieldrequired', 'fieldrequired', '', 'string');            

            $result = $this->getJSModel('fieldordering')->getFieldsOrdering($fieldfor, $fieldtitle, $userpublish , $visitorpublish , $fieldrequired, $limitstart, $limit); // 1 for company
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        
        }elseif($layoutName == 'formuserfield'){

            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }

            $session = JFactory::getSession();
            $fieldfor = $session->get('fieldfor');

            if (is_numeric($c_id) == true AND $c_id != 0)
                $application = $this->getJSModel('fieldordering')->getUserFieldbyId($c_id , $fieldfor);
            if (isset($application) && (!empty($application)))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Job UserField') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::apply('fieldordering.savejobuserfieldsave', 'Save');
            JToolBarHelper::save2new('fieldordering.savejobuserfieldandnew');
            JToolBarHelper::save('fieldordering.savejobuserfield');
            if ($isNew)
                JToolBarHelper::cancel('fieldordering.cancel');
            else
                JToolBarHelper::cancel('fieldordering.cancel', 'Close');
            $this->assignRef('ff' , $fieldfor);
            $this->assignRef('application' , $application);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('ff', $fieldfor);
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
