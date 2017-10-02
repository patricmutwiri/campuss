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

class JSJobsViewCurrency extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formcurrency') {
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            //if (is_numeric($c_id) == true)
            if (is_numeric($c_id) == true AND $c_id != 0)
                $currency = $this->getJSModel('currency')->getCurrencybyId($c_id);
            $this->assignRef('currency', $currency);
            if (isset($currency->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Currency') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::apply('currency.savejobcurrencysave', 'Save');
            JToolBarHelper::save2new('currency.savejobcurrencyandnew');
            JToolBarHelper::save('currency.savejobcurrency');
            if ($isNew)
                JToolBarHelper::cancel('currency.cancel');
            else
                JToolBarHelper::cancel('currency.cancel', 'Close');
        }elseif ($layoutName == 'currency') {

            JToolBarHelper::title(JText::_('Currency'));
            JToolBarHelper::addNew('currency.editjobcurrency');
            JToolBarHelper::editList('currency.editjobcurrency');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'currency.remove');
            $form = 'com_jsjobs.currency.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');            
            $searchcode = $mainframe->getUserStateFromRequest($form . 'searchcode', 'searchcode', '', 'string');            

            $result = $this->getJSModel('currency')->getAllCurrencies($searchtitle, $searchstatus, $searchcode, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
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

}

?>
