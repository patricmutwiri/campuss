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

class JSJobsControllerFieldordering extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    // new
    function editjobuserfield() {
        JRequest::setVar('layout', 'formuserfield');
        JRequest::setVar('view', 'fieldordering');
        JRequest::setVar('c', 'fieldordering');
        $this->display();
    }

    function savejobuserfield() {
        $redirect = $this->saveuserfield('saveclose');
    }

    function savejobuserfieldsave() {
        $redirect = $this->saveuserfield('save');
    }

    function savejobuserfieldandnew() {
        $redirect = $this->saveuserfield('saveandnew');
    }

    function saveuserfield($callfrom) { 
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->storeUserField();

        $fieldfor = JRequest::getVar('fieldfor');

        if(is_array($return_value)){
            if ($callfrom == 'saveclose') {
                $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff='.$fieldfor;
            } elseif ($callfrom == 'save') {
                $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=formuserfield&ff='.$fieldfor.'&cid[]='.$return_value[0];
            } elseif ($callfrom == 'saveandnew') {
                $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=formuserfield&ff='.$fieldfor;
            }

            JSJOBSActionMessages::setMessage(SAVED, 'customfield','message');
            $this->setRedirect($link);
        }else{
            $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=formuserfield&ff='.$fieldfor;
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'customfield','error');
            $this->setRedirect($link);
        }
    }

    // end new

    function fieldrequired() {
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldRequired($cid, 1); //required
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(SET_AS_REQUIRED, 'field','message');
        $this->setRedirect($link);
    }

    function fieldnotrequired() {
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldNotRequired($cid, 0); // notrequired
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(SET_AS_NOT_REQUIRED, 'field','message');
        $this->setRedirect($link);
    }

    function fieldpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldPublished($cid, 1); //published
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(PUBLISHED, 'field','message');
        $this->setRedirect($link);
    }

    function visitorfieldpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->visitorFieldPublished($cid, 1); // unpublished
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(PUBLISHED, 'field','message');
        $this->setRedirect($link);
    }

    function fieldunpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldPublished($cid, 0); // unpublished
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(UN_PUBLISHED, 'field','message');
        $this->setRedirect($link);
    }

    function visitorfieldunpublished() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $input = JFactory::getApplication()->input;
        $cid = $input->post->get('cid', array(), 'array');
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->visitorFieldPublished($cid, 0); // unpublished
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(UN_PUBLISHED, 'field','message');
        $this->setRedirect($link);
    }

    function fieldorderingup() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldid = $cid[0];
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldOrderingUp($fieldid);
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(ORDERING_DOWN, 'field','message');
        $this->setRedirect($link);
    }

    function fieldorderingdown() {
        $session = JFactory::getSession();
        $fieldfor = $session->get('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldid = $cid[0];
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->fieldOrderingDown($fieldid);
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        JSJOBSActionMessages::setMessage(ORDERING_UP, 'field','message');
        $this->setRedirect($link);
    }

    function publishunpublishfields($call) {
        $ff = JRequest::getVar('ff');
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->publishunpublishfields($call);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(PUBLISHED, 'field','message');            
        } else {
            JSJOBSActionMessages::setMessage(PUBLISH_ERROR, 'field','error');
        }
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $ff;
        $this->setRedirect($link);
    }

    function deleteuserfield() {
        $fieldfor = JRequest::getVar('fieldfor');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $fieldid = $cid[0];        
        $fieldordering_model = $this->getmodel('fieldordering', 'JSJobsModel');
        $return_value = $fieldordering_model->deleteUserField($fieldid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'customfield','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'customfield','error');
        }
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $fieldfor;
        $this->setRedirect($link);
    }

    function cancel() {
        $ff = JRequest::getVar('ff');
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'customfield','notice');
        $link = 'index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=' . $ff;
        $this->setRedirect($link);
    }

    function getfieldsforcombobyfieldfor(){
        $fieldfor = JRequest::getVar('fieldfor');
        $parentfield = JRequest::getVar('parentfield');

        $job_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_data = $job_model->getFieldsForComboByFieldFor($fieldfor , $parentfield);
        echo $return_data;
        JFactory::getApplication()->close();        
    }

    function getsectiontofillvalues(){
        $pfield = JRequest::getVar('pfield');
        $job_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_data = $job_model->getSectionToFillValues($pfield );
        echo $return_data;
        JFactory::getApplication()->close();        
    }
    
    function getoptionsforfieldedit(){
        $field = JRequest::getVar('field');
        $job_model = $this->getmodel('Fieldordering', 'JSJobsModel');
        $return_data = $job_model->getOptionsForFieldEdit($field );
        echo $return_data;
        JFactory::getApplication()->close();        
    }

    function datafordepandantfield() {
        $val = JRequest::getVar('fvalue'); 
        $childfield = JRequest::getVar('child'); 
        $result = $this->getmodel('Fieldordering', 'JSJobsModel')->dataForDepandantField( $val , $childfield);
        $result = json_encode($result);
        echo $result;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'fieldordering');
        $layoutName = JRequest::getVar('layout', 'fieldordering');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $fieldordering_model = $this->getModel('fieldordering', 'JSJobsModel');

        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($fieldordering_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($fieldordering_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }
}
?>