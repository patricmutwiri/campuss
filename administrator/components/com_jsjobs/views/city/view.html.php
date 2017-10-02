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

class JSJobsViewCity extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        $session = JFactory::getSession();
        if ($layoutName == 'formcity') {          // cities
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            $var = $session->get('js_countrycode');
            if(!empty($var))
                $countrycode = $var;
            else
                $countrycode = null;
            $var = $session->get('js_countryid');
            if(!empty($var))
                $countryid = $var;
            else
                $countryid = null;
            $var = $session->get('js_statecode');
            if(!empty($var))
                $statecode = $var;
            else
                $statecode = null;
            $var = $session->get('js_stateid');
            if(!empty($var))
                $stateid = $var;
            else
                $stateid = null;

            if (!$countryid)
                $countryid = $session->get('countryid');
            if (!$stateid)
                $stateid = $session->get('stateid');

            $result = $this->getJSModel('city')->getCitybyId($c_id, $countryid, $stateid);
            $city = $result[0];
            if (isset($city->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('City') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('city', $city);
            $this->assignRef('countrycode', $countrycode);
            $this->assignRef('countryid', $countryid);
            $this->assignRef('statecode', $statecode);
            $this->assignRef('stateid', $stateid);
            if (isset($result[1]))
                $this->assignRef('list', $result[1]);
            JToolBarHelper::save('city.savecity');
            if ($isNew)
                JToolBarHelper::cancel('city.cancel');
            else
                JToolBarHelper::cancel('city.cancel', 'Close');
        }elseif ($layoutName == 'cities') {          // cities
            $stateid = JRequest::getVar('sd');
            $countryid = JRequest::getVar('ct');
            $session = JFactory::getSession();
            $session->set('countryid', $countryid);
            $session->set('stateid', $stateid);

            JToolBarHelper::title(JText::_('Cities'));

            $form = 'com_jsjobs.city.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');

            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');



            $result = $this->getJSModel('city')->getAllStatesCities($searchname, $searchstatus, $stateid, $countryid,  $sortby, $js_sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            $this->assignRef('sd', $stateid);
            $this->assignRef('ct', $countryid);

            $this->assignRef('js_sortby', $js_sortby);
            $this->assignRef('sort', $sortby);
            

            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            JToolBarHelper::addNew('city.editjobcity');
            JToolBarHelper::editList('city.editjobcity');
            JToolBarHelper::publishList('city.publishcities');
            JToolBarHelper::unpublishList('city.unpublishcities');
            JToolBarHelper::deleteList(JText::_("Are You Sure?"), 'city.deletecity');
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
