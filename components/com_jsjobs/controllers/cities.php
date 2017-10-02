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

class JSJobsControllerCities extends JSController {

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

    function getaddressdatabycityname() {
        $cityname = JRequest::getVar('q');
        // echo " - city Name = ".$cityname." - ";
        $city = $this->getmodel('Cities', 'JSJobsModel');
        $result = $city->getAddressDataByCityName($cityname);
        $json_response = json_encode($result);
        echo $json_response;
        JFactory::getApplication()->close();
    }

    function savecity() {
        $input = JRequest::getVar('citydata');
        $citiesModel = $this->getmodel('cities', 'JSJobsModel');
        $result = $citiesModel->storeCity($input);
        if (is_array($result)) {
            $return_value = json_encode(array('id' => $result[1], 'name' => $result[2])); // send back the cityid newely created
        } elseif ($result == 2) {
            $return_value = JText::_('Error in saving records, please try again');
        } elseif ($result == 3) {
            $return_value = JText::_('Error while saving new state');
        } elseif ($result == 4) {
            $return_value = JText::_('Country not found');
        } elseif ($result == 5) {
            $return_value = JText::_('Location format is not correct, please enter data in this format city name, country name');
        }
        echo $return_value;
        JFactory::getApplication()->close();
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