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

class JSJOBSActionMessages {
    /*
     * setLayoutMessage
     * @params $message = Your message to display
     * @params $type = Messages types => 'error','notice','warning','message'
     */

    public static function setMessage($result, $entity, $msgtype = 'message') {

        $application = JFactory::getApplication(); // Joomla main application object

        $entity_name = JSJOBSActionMessages::getEntityName($entity); // Entity name should be returned

        switch ($result) {
            case WAITING_FOR_APPROVAL:
                $msg = $entity_name . ' ' . JText::_('is waiting for approval');
                break;
            case SAVED:
                $msg = $entity_name . ' ' . JText::_('has been successfully saved');
                break;
            case SAVE_ERROR:
                $msg = $entity_name . ' ' . JText::_('has not been saved');
                break;
            case DELETED:
                $msg = $entity_name . ' ' . JText::_('has been deleted');
                break;
            case DELETE_ERROR:
                $msg = $entity_name . ' ' . JText::_('has not been deleted');
                break;
            case PUBLISHED:
                $msg = $entity_name . ' '. JText::_('has been published');
                break;
            case PUBLISH_ERROR:
                $msg = $entity_name . ' '. JText::_('has not been published');
                break;
            case UN_PUBLISHED:
                $msg = $entity_name . ' '.  JText::_('has been unpublished');
                break;
            case UN_PUBLISH_ERROR:
                $msg = $entity_name . ' '. JText::_('has not been unpublished');
                break;
            case DEFAULT_UN_PUBLISH_ERROR:
                $msg = $entity_name . ' '. JText::_('has been set as default cannot unpublished');
                break;
            case REJECTED:
                $msg = $entity_name . ' ' . JText::_('has been rejected');
                break;
            case REJECT_ERROR:
                $msg = $entity_name . ' ' . JText::_('has not been rejected');
                break;
            case APPROVED:
                $msg = $entity_name . ' ' . JText::_('has been approved');
                break;
            case APPROVE_ERROR:
                $msg = $entity_name . ' ' . JText::_('has not been approved');
                break;
            case SET_DEFAULT:
                $msg = $entity_name . ' ' . JText::_('has been set as default');
                break;
            case UNPUBLISH_DEFAULT_ERROR:
                $msg = JText::_('Unpublished field cannot set default');
                break;
            case SET_DEFAULT_ERROR:
                $msg = $entity_name . ' ' . JText::_('has not been set as default');
                break;
            case STATUS_CHANGED:
                $msg = $entity_name . ' ' . JText::_('status has been updated');
                break;
            case STATUS_CHANGED_ERROR:
                $msg = $entity_name . ' ' . JText::_('status has not been updated');
                break;
            case IN_USE:
                $msg = $entity_name . ' ' . JText::_('in use cannot deleted');
                break;
            case ALREADY_EXIST:
                $msg = $entity_name . ' ' . JText::_('already exist');
                break;
            case FILE_TYPE_ERROR:
                $msg = JText::_('Error in file type');
                break;
            case OPERATION_CANCELLED:
                $msg = JText::_('Operation Cancelled');
                break;
            case SHARING_IMPROPER_NAME:
                $msg = JText::_('Sharing server not accept because of the improper name');
                break;
            case SHARING_AUTH_FAIL:
                $msg = JText::_('Authentication fail on sharing server');
                break;
            case SHARING_SYNCHRONIZE_ERROR:
                $msg = JText::_('Problem synchronize with sharing server');
                break;
            case REQUIRED_FIELDS:
                $msg = JText::_('All required fields must be filled');
                $msg = JText::_('Please fill all required fields');
                break;
            case NOT_YOUR:
                $msg = JText::_('This is not your') . ' ' . $entity_name;
                break;
            case FILE_SIZE_ERROR:
                $msg = JText::_('Error in uploading file').'. '.JText::_('File size is greater than allowed size');
                break;
            case NOT_APPROVED:
                $msg = $entity_name . ' ' . JText::_('Not Approved');
                break;
            case CAN_NOT_ADD_NEW:
                $msg = JText::_('Can not add new'). ' '.$entity_name;
                break;
            case SET_AS_REQUIRED:
                $msg = JText::_('Fields successfully set required field');
                break;
            case SET_AS_NOT_REQUIRED:
                $msg = JText::_('Fields successfully set not required field');
                break;
            case ORDERING_UP:
                $msg = $entity_name.' '.JText::_('Order up successfully');
                break;
            case ORDERING_DOWN:
                $msg = $entity_name.' '.JText::_('Order down successfully');
                break;
            default:
                $msg = JText::_($result);
                break;
        }
        $application->enqueueMessage($msg, $msgtype);
        return;
    }

    private static function getEntityName($entity) {
        $name = "";
        $entity = strtolower($entity);
        switch ($entity) {
            case 'salaryrange':$name = JText::_('Salary Range');break;
            case 'addressdata':$name = JText::_('Address Data');break;
            case 'age':$name = JText::_('Age');break;
            case 'careerlevel':$name = JText::_('Career Level');break;
			case 'filter':$name = JText::_('Filter');break;
            case 'category':$name = JText::_('Category');break;
            case 'city':$name = JText::_('City');break;
            case 'coverletter':$name = JText::_('Cover Letter');break;
            case 'company':$name = JText::_('Company');break;
            case 'featuredcompany':$name = JText::_('Featured Company');break;
            case 'goldcompany':$name = JText::_('Gold Company');break;
            case 'country':$name = JText::_('Country');break;
            case 'currency':$name = JText::_('Currency');break;
            case 'customfield':$name = JText::_('Field');break;
            case 'department':$name = JText::_('Department');break;
            case 'employerpackages':$name = JText::_('Employer Package');break;
            case 'experience':$name = JText::_('Experience');break;
            case 'fieldordering':$name = JText::_('Resume Field');break;
            case 'folder':$name = JText::_('Folder');break;
            case 'folderresume':$name = JText::_('Folder Resume');break;
            case 'highesteducation':$name = JText::_('Highest Education');break;
            case 'job':$name = JText::_('Job');break;
            case 'featuredjob':$name = JText::_('Featured Job');break;
            case 'goldjob':$name = JText::_('Gold Job');break;
            case 'jobalert':$name = JText::_('Job Alert');break;
            case 'jobseekerpackages':$name = JText::_('Job Seeker Package');break;
            case 'jobstatus':$name = JText::_('Job Status');break;
            case 'jobtype':$name = JText::_('Job Type');break;
            case 'message':$name = JText::_('Message');break;
            case 'paymenthistory':$name = JText::_('Payment History');break;
            case 'paymentmethodconfiguration':$name = JText::_('Payment Method Configuration');break;
            case 'resume':$name = JText::_('Resume');break;
            case 'featuredresume':$name = JText::_('Featured Resume');break;
            case 'goldresume':$name = JText::_('Gold Resume');break;
            case 'salaryrange':$name = JText::_('Salary Range');break;
            case 'salaryrangetype':$name = JText::_('Salary Range Type');break;
            case 'shift':$name = JText::_('Shift');break;
            case 'state':$name = JText::_('State');break;
            case 'subcategory':$name = JText::_('Sub Category');break;
            case 'user':$name = JText::_('User');break;
            case 'userrole':$name = JText::_('User Role');break;
            case 'stateandcounty':$name = JText::_('State And County');break;
            case 'stateandcity':$name = JText::_('State And City');break;
            case 'countyandcity':$name = JText::_('County And City');break;
            case 'statecountyandcity':$name = JText::_('State County And City');break;
            case 'categoryandsubcategory':$name = JText::_('Category And Sub Category');break;
            case 'configuration':$name = JText::_('Configuration');break;
            case 'email':$name = JText::_('Email');break;
            case 'search':$name = JText::_('Search');break;
            case 'shortlistedjob':$name = JText::_('Shortlisted Job');break;
            case 'package':$name = JText::_('Package');break;
            case 'emailtemplate':$name = JText::_('Email Template');break;
            case 'settings':$name = JText::_('Settings');break;
            case 'field':$name = JText::_('Field');break;
            case 'resumeuserfield':$name = JText::_('Resume User Field');break;
            case 'shortlistcandidate':$name = JText::_('Shortlist Candidate');break;
            case 'payment':$name = JText::_('Payment');break;
        }
        return $name;
    }

}

?>