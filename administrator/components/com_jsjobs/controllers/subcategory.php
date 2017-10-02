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

class JSJobsControllerSubcategory extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function setorderingsubcategories() {
        $data = JRequest::get('post');
        $categoryid = JRequest::getVar('cd');
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory_model->setOrderingSubcategories($categoryid);
        if ($returnvalue == 1)
            JSJOBSActionMessages::setMessage('Ordering change successfully', 'subcategory','message');
        else
            JSJOBSActionMessages::setMessage('Error set ordering', 'subcategory','error');
        $for = "subcategories&cd=" . $categoryid;
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=' . $for;
        $this->setRedirect($link);
    }

    function editsubcategories() {
        JRequest::setVar('layout', 'formsubcategory');
        JRequest::setVar('view', 'subcategory');
        JRequest::setVar('c', 'subcategory');
        $this->display();
    }

    function publishsubcategories() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $return_value = $subcategory_model->subCategoryChangeStatus($id, 1);
        if ($return_value != 1)
            JSJOBSActionMessages::setMessage(PUBLISH_ERROR, 'subcategory','error');
        else
            JSJOBSActionMessages::setMessage(PUBLISHED, 'subcategory','message');
        $categoryid = JRequest::getVar('cd');
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
        $this->setRedirect($link);
    }

    function unpublishsubcategories() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $return_value = $subcategory_model->subCategoryChangeStatus($id, 0);
        if ($return_value != 1)
            JSJOBSActionMessages::setMessage(UN_PUBLISH_ERROR, 'subcategory','error');
        else
            JSJOBSActionMessages::setMessage(UN_PUBLISHED, 'subcategory','message');
        $categoryid = JRequest::getVar('cd');
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
        $this->setRedirect($link);
    }

    function removesubcategory() {
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory_model->deleteSubCategory();
        if ($returnvalue == 1)
            JSJOBSActionMessages::setMessage(DELETED, 'subcategory','message');
        else
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'subcategory','error');
        $session = JFactory::getSession();
        $categoryid = $session->get('sub_categoryid');
        $this->setRedirect('index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid);
    }

    function cancelsubcategories() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'subcategory','notice');
        $session = JFactory::getSession();
        $categoryid = $session->get('sub_categoryid');
        $this->setRedirect('index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid);
    }

    function savesubcategory() {
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $return_value = $subcategory_model->storeSubCategory();
        $session = JFactory::getSession();
        $categoryid = $session->get('sub_categoryid');
        $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
        if (is_array($return_value)) {
            if ($return_value['return_value'] == false) { // jobsharing return value 
                JSJOBSActionMessages::setMessage(SAVED, 'subcategory','message');
                if ($return_value['rejected_value'] != "")
                    JSJOBSActionMessages::setMessage(SHARING_IMPROPER_NAME, 'subcategory','warning');
                if ($return_value['authentication_value'] != "")
                    JSJOBSActionMessages::setMessage(SHARING_AUTH_FAIL, 'subcategory','warning');
                if ($return_value['server_responce'] != "")
                    JSJOBSActionMessages::setMessage(SHARING_SYNCHRONIZE_ERROR, 'subcategory','warning');
                $this->setRedirect($link);
            }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                JSJOBSActionMessages::setMessage(SAVED, 'subcategory','message');
                $this->setRedirect($link);
            }
        } else {
            if ($return_value == 1) {
                JSJOBSActionMessages::setMessage(SAVED, 'subcategory','message');
                $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
                $this->setRedirect($link);
            } else if ($return_value == 2) {
                JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'subcategory','error');
                JRequest::setVar('view', 'subcategory');
                JRequest::setVar('hidemainmenu', 1);
                JRequest::setVar('layout', 'formsubcategory');
                // Display based on the set variables
                $this->display(); //parent::display();
            } else if ($return_value == 3) {
                JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'subcategory','notice');
                JRequest::setVar('view', 'subcategory');
                JRequest::setVar('hidemainmenu', 1);
                JRequest::setVar('layout', 'formsubcategory');
                $this->display(); //parent::display();
            } else {
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'subcategory','error');
                $link = 'index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=' . $categoryid;
                $this->setRedirect($link);
            }
        }
    }

    function listsubcategories() {
        $val = JRequest::getVar('val');
        $subcategory_model = $this->getmodel('Subcategory', 'JSJobsModel');
        $returnvalue = $subcategory_model->listSubCategories($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function listsubcategoriesforsearch() {
        $val = JRequest::getVar('val');
        $model = $this->getModel('subcategory', 'JSJobsModel');
        $returnvalue = $model->listSubCategoriesForSearch($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'subcategory');
        $layoutName = JRequest::getVar('layout', 'subcategory');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $subcategory_model = $this->getModel('Subcategory', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($subcategory_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($subcategory_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>