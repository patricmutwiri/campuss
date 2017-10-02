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
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelCustomFields extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }


    function getFieldsOrdering($fieldfor, $visitor = false) {
        if (is_numeric($fieldfor) === false)
            return false;
        $db = $this->getDBO();
        if ($fieldfor == 16 ) { // resume visitor case 
            $fieldfor = 3;
            $query = "SELECT *,isvisitorpublished AS published
                        FROM `#__js_job_fieldsordering` 
                        WHERE isvisitorpublished = 1 AND fieldfor =  " . $fieldfor
                    ." ORDER BY";
        } else {
            $published_field = "published = 1";
            if ($visitor == true) {
                $published_field = "isvisitorpublished = 1";
            }
            $query = "SELECT * FROM `#__js_job_fieldsordering` 
						WHERE " . $published_field . " AND fieldfor =  " . $fieldfor
                    . " ORDER BY";
        }
        if ($fieldfor == 3) // fields for resume
            $query.=" section ,";
        $query.=" ordering";


        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }

    function getFieldsOrderingForResumeView($fieldfor) { // created and used by muhiaudin for resume layout 'view_resume'
        $user = JFactory::getUser();
        if (is_numeric($fieldfor) === false)
            return false;
        $db = $this->getDBO();
        if ($fieldfor == 16) { // resume visitor case 
            $fieldfor = 3;
            $query = "SELECT *,isvisitorpublished AS published
                        FROM `#__js_job_fieldsordering` 
                        WHERE isvisitorpublished = 1 AND fieldfor =  " . $fieldfor
                    . " ORDER BY section,ordering";
        } else {
            $published_field = "published = 1";
            if ($user->guest) {
                $published_field = "isvisitorpublished = 1";
            }
            $query = "SELECT * FROM `#__js_job_fieldsordering` 
                        WHERE " . $published_field . " AND fieldfor =  " . $fieldfor
                    . " ORDER BY section,ordering";
        }
        $db->setQuery($query);
        $fields = $db->loadObjectList();

        foreach ($fields as $field) {
            switch ($field->section) {
                case 1: $fieldsOrdering['personal'][] = $field;
                    break;
                case 2: $fieldsOrdering['address'][] = $field;
                    break;
                case 3: $fieldsOrdering['institute'][] = $field;
                    break;
                case 4: $fieldsOrdering['employer'][] = $field;
                    break;
                case 5: $fieldsOrdering['skills'][] = $field;
                    break;
                case 6: $fieldsOrdering['resume'][] = $field;
                    break;
                case 7: $fieldsOrdering['reference'][] = $field;
                    break;
                case 8: $fieldsOrdering['language'][] = $field;
                    break;
            }
        }
        return $fieldsOrdering;
    }

    function getResumeFieldsOrderingBySection($section) { // created and used by muhiaudin for resume view 'formresume'
        $user = JFactory::getUser();
        $uid = $user->id;
        if (empty($section)) return false;
        if(!is_numeric($section)) return false;
        $db = $this->getDBO();
        if ($uid != "" AND $uid != 0)
            $fieldfor = 3;
        else
            $fieldfor = 16;

        if ($fieldfor == 16) { // resume visitor case 
            $fieldfor = 3;
            $query = "SELECT  fording.*, fording.isvisitorpublished AS published
                        FROM `#__js_job_fieldsordering` AS fording 
                        WHERE isvisitorpublished = 1 AND fieldfor =  " . $fieldfor . " AND section = " . $section
                    . " ORDER BY section,ordering";
        } else {
            $published_field = "published = 1";
            if ($user->guest) {
                $published_field = "isvisitorpublished = 1";
            }
            $query = "SELECT * FROM `#__js_job_fieldsordering` 
                        WHERE " . $published_field . " AND fieldfor =  " . $fieldfor . " AND section = " . $section
                    . " ORDER BY section,ordering";
        }
        $db->setQuery($query);
        $fieldsOrdering = $db->loadObjectList();
        return $fieldsOrdering;
    }

    function parseFieldsOrderingForView($fieldsordering) {
        if (!is_array($fieldsordering))
            return false;
        $fields = array();
        $user = JFactory::getUser();
        foreach ($fieldsordering AS $field) {
            $fields[$field->field] = ($user->guest) ? $field->isvisitorpublished : $field->published;
        }
        return $fields;
    }

    function getFieldRequiredByNameAndFor($fieldname,$fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $db = $this->getDbo();
        $query = "SELECT required FROM `#__js_job_fieldsordering` WHERE fieldfor = ".$fieldfor." and field = ".$db->Quote($fieldname);
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getUserfieldsfor($fieldfor, $resumesection = null) {
        if (!is_numeric($fieldfor))
            return false;
        $db = JFactory::getDBO();

        $published = '';
        if ($resumesection != null) {
            $published .= " AND section = $resumesection ";
        }
        $query = "SELECT field,userfieldparams,userfieldtype FROM `#__js_job_fieldsordering` WHERE fieldfor = " . $fieldfor . " AND isuserfield = 1 " . $published;
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }

    function dataForDepandantField( $val , $childfield){ 
        $db = $this->getDBO();
        $query = "SELECT userfieldparams,fieldtitle FROM `#__js_job_fieldsordering` WHERE field = '".$childfield."'"; 
        $db->setQuery($query);
        $data = $db->loadObject();
        $decoded_data = json_decode($data->userfieldparams); 
        $comboOptions = array(); 
        $flag = 0; 
        foreach ($decoded_data as $key => $value) { 
            if($key == $val){ 
               for ($i=0; $i < count($value) ; $i++) {  
                if($flag == 0){
                    $comboOptions[] = array('value' => '', 'text' => JText::_('Select').' '.$data->fieldtitle); 
                }
                $comboOptions[] = array('value' => $value[$i], 'text' => $value[$i]); 
                $flag = 1; 
               } 
            } 
        }
        $html = JHTML::_('select.genericList', $comboOptions , $childfield,'class="inputbox one"', 'value' , 'text' , '');        
        return $html; 
    }
    

    function getFieldTitleByFieldAndFieldfor($field,$fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $db = JFactory::getDBO();
        $query = "SELECT fieldtitle FROM `#__js_job_fieldsordering` WHERE field = '".$field."' AND fieldfor = ".$fieldfor;
        $db->setQuery($query);
        $title = $db->loadResult();
        return $title;
    }

    function getUnpublishedFieldsFor($fieldfor,$section = null){
        if(!is_numeric($fieldfor)) return false;
        if($section != null)
            if(!is_numeric($section)) return false;
        $user = JFactory::getUser();
        if($user->guest){
            $publihsed = ' isvisitorpublished = 0 ';
        }else{
            $publihsed = ' published = 0 ';
        }

        if($section != null){
            $publihsed .= ' AND section = '.$section;
        }

        $db = JFactory::getDbo();
        $query = "SELECT field FROM `#__js_job_fieldsordering` WHERE fieldfor = ".$fieldfor." AND ".$publihsed;
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }
}
?>
