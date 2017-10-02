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

class JSJobsViewState extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formstate') {          // states
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $state = $this->getJSModel('state')->getStatebyId($c_id);
            if (isset($state->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('State') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('state', $state);

            JToolBarHelper::save('state.savestate');
            if ($isNew)
                JToolBarHelper::cancel('state.cancel');
            else
                JToolBarHelper::cancel('state.cancel', 'Close');
        } elseif ($layoutName == 'states') {          // states
            $countryid = JRequest::getVar('ct');
            $session = JFactory::getSession();
            if (!$countryid)
                $countryid = $session->get('countryid');
            $session->set('countryid', $countryid);
            JToolBarHelper::title(JText::_('States'));
            JToolBarHelper::addNew('state.editjobstate');
            JToolBarHelper::editList('state.editjobstate');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'state.deletestate');

            $form = 'com_jsjobs.states.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');
            $hascities = $mainframe->getUserStateFromRequest($form . 'hascities', 'hascities');

            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');



            $result = $this->getJSModel('state')->getAllCountryStates($searchname , $searchstatus, $hascities, $countryid,  $sortby, $js_sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            $this->assignRef('ct', $countryid);
            $this->assignRef('js_sortby', $js_sortby);
            $this->assignRef('sort', $sortby);

            
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
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

    function getSortArg($sort) {
        if ($sort == 'asc')
            return "desc";
        else
            return "asc";
    }


}

?>
