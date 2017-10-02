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

class JSJobsViewCountry extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formcountry') {          // countries
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true AND $c_id != 0)
                $country = $this->getJSModel('country')->getCountrybyId($c_id);
            if (isset($country->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Country') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('country', $country);
            JToolBarHelper::save('country.savecountry');
            if ($isNew)
                JToolBarHelper::cancel('country.cancel');
            else
                JToolBarHelper::cancel('country.cancel', 'Close');
        }elseif ($layoutName == 'countries') {          // countries
            JToolBarHelper::title(JText::_('Countries'));
            JToolBarHelper::addNew('country.editjobcountry');
            JToolBarHelper::editList('country.editjobcountry');
            JToolBarHelper::publishlist('country.publishcountries');
            JToolBarHelper::unpublishlist('country.unpublishcountries');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'country.deletecountry');
            $form = 'com_jsjobs.countries.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');
            $hasstates = $mainframe->getUserStateFromRequest($form . 'hasstates', 'hasstates');
            $hascities = $mainframe->getUserStateFromRequest($form . 'hascities', 'hascities');

            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');

            $result = $this->getJSModel('country')->getAllCountries($searchname, $searchstatus , $hasstates, $hascities, $sortby, $js_sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            $this->assignRef('js_sortby', $js_sortby);
            $this->assignRef('sort', $sortby);
            
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }

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
