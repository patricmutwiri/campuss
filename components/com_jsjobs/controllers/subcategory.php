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

class JSJobsControllerSubCategory extends JSController {

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

    function listsubcategoriesforresume() {
        $val = JRequest::getVar('categoryid');
        if(!$val) $val = JRequest::getVar('val');
        $subcategory = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory->listSubCategoriesForResume($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function listsubcategories() {
        $val = JRequest::getVar('categoryid');
        if(!$val) $val = JRequest::getVar('val');
        $subcategory = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory->listSubCategories($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function listfiltersubcategories() {
        $val = JRequest::getVar('val');
        $subcategory = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory->listFilterSubCategories($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function listsubcategoriesforsearch() {
        $val = JRequest::getVar('val');
        $modulecall = JRequest::getVar('md');
        $subcategory = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory->listSubCategoriesForSearch($val);
        if ($modulecall) {
            if ($modulecall == 1) {
                //$return = JText::_('Sub Category') . "<br>" . $returnvalue;
                //$returnvalue = $return;
            }
        }
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function subcategoriesforsearch() {
        $val = JRequest::getVar('val');
        $modulecall = JRequest::getVar('md');
        $subcategory = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory->SubCategoriesForSearch($val);
        if ($modulecall) {
            if ($modulecall == 1) {
                $return = JText::_('Sub Category') . "<br>" . $returnvalue;
                $returnvalue = $return;
            }
        }
        echo $returnvalue;
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
    