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

class JSJobsModelFieldordering extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getResumeSections($cid) {
        if (is_numeric($cid) === false)
            return false;
        $db = JFactory::getDBO();
        $section = array();
        $query = " SELECT section  
					FROM `#__js_job_fieldsordering`	
					WHERE fieldfor = 3 AND field=" . $cid;
        $db->setQuery($query);
        $sid = $db->loadResult();
        $section[] = array('value' => '', 'text' => JText::_('Select Section'));
        $query = " SELECT field,section  
					FROM `#__js_job_fieldsordering`	
					WHERE fieldfor = 3  GROUP BY section asc ";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        foreach ($result AS $res) {
            $section[] = array('value' => $res->section, 'text' => $res->field);
        }
        if ($cid)
            $list = JHTML::_('select.genericList', $section, 'section', 'class="inputbox required" ' . '', 'value', 'text', $sid);
        else
            $list = JHTML::_('select.genericList', $section, 'section', 'class="inputbox required" ' . '', 'value', 'text', '');
        return $list;
    }

    function fieldRequired($cids, $value) {
        $db = JFactory::getDBO();
        foreach ($cids AS $cid) {
            if(!$this->isUsercheckBox($cid)){
                $query = " UPDATE #__js_job_fieldsordering  SET required = " . $value . " WHERE id = " . $cid . " AND sys=0 ";
                $db->setQuery($query);
                if (!$db->query())
                    return false;
            }else{
                return false;
            }
        }
        return true;
    }

    function isUsercheckBox($id){
        if(!is_numeric($id)) return false;
        $db = JFactory::getdbo();
        $query = "SELECT userfieldtype FROM `#__js_job_fieldsordering` WHERE id = ".$id." AND isuserfield = 1";
        $db->setQuery($query); 
        $result = $db->loadResult();
        if($result == 'checkbox'){
            return true;
        }else{
            return false;
        }

    }

    function fieldNotRequired($cids, $value) {
        $db = JFactory::getDBO();
        foreach ($cids AS $cid) {
            if(!$this->isUsercheckBox($cid)){
                $query = " UPDATE #__js_job_fieldsordering	SET required = " . $value . " WHERE id = " . $cid . " AND sys=0";
                $db->setQuery($query);
                if (!$db->query())
                    return false;
            }else{
                return false;
            }
        }
        return true;
    }

    function getFieldsOrdering($fieldfor, $fieldtitle, $userpublish , $visitorpublish , $fieldrequired, $limitstart, $limit) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = JFactory::getDBO();
        $fquery = " WHERE field.fieldfor = ".$fieldfor;
        if($fieldtitle){
            $fquery .= " AND field.fieldtitle LIKE ".$db->Quote('%'.$fieldtitle.'%');
        }
        if(is_numeric($userpublish))
            $fquery .= " AND field.published =".$userpublish;
        if(is_numeric($visitorpublish))
            $fquery .= " AND field.isvisitorpublished =".$visitorpublish;
        if(is_numeric($fieldrequired))
            $fquery .= " AND  field.required =".$fieldrequired;
        
        $required = array(
            '0' => array('value' => '', 'text' => JText::_('Select Status')),
            '1' => array('value' => 1, 'text' => JText::_('Required')),
            '2' => array('value' => 0, 'text' => JText::_('Not Required')),);

        $lists = array();
        $lists['fieldtitle'] = $fieldtitle;
        $lists['userpublish'] = JHTML::_('select.genericList',$this->getJSModel('common')->getStatus(JText::_('Select User Publish')), 'userpublish', 'class="inputbox" ', 'value', 'text', $userpublish);        
        $lists['visitorpublish'] = JHTML::_('select.genericList',$this->getJSModel('common')->getStatus(JText::_('Select Visitor Publish')) , 'visitorpublish', 'class="inputbox" ', 'value', 'text', $visitorpublish);
        $lists['fieldrequired'] = JHTML::_('select.genericList', $required , 'fieldrequired', 'class="inputbox" ', 'value', 'text', $fieldrequired);

        $result = array();
        $query = "SELECT COUNT(id) FROM `#__js_job_fieldsordering` As field";
        $query .= $fquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT field.* FROM `#__js_job_fieldsordering` AS field";
        $query .= $fquery;
        $query .= ' ORDER BY ';
        if ($fieldfor == 3)
            $query .=' field.section,';
        $query .= ' field.ordering';
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function getFieldsOrderingforForm($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = $this->getDBO();

        if (JFactory::getUser()->guest) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $query = "SELECT  * FROM `#__js_job_fieldsordering`
					WHERE ".$published." AND fieldfor =  " . $fieldfor . " ORDER BY";
        if ($fieldfor == 3)
            $query.=" section ,";
        $query.=" ordering";
        $db->setQuery($query);
        $fieldordering = $db->loadObjectList();

        return $fieldordering;
    }

    function getFieldsOrderingForResumeView($fieldfor) { // created and used by muhiaudin for resume layout 'view_resume'
        $user = JFactory::getUser();
        if (is_numeric($fieldfor) === false)
            return false;
        $db = $this->getDBO();
        if ($fieldfor == 16) { // resume visitor case 
            $fieldfor = 3;
            $query = "SELECT  id,field,fieldtitle,ordering,section,fieldfor,isvisitorpublished AS published,sys,cannotunpublish,required 
                        FROM `#__js_job_fieldsordering` 
                        WHERE isvisitorpublished = 1 AND fieldfor =  " . $fieldfor
                    . " ORDER BY section,ordering";
        } else {
            $published_field = "published = 1";
            if ($user->guest) {
                $published_field = "isvisitorpublished = 1";
            }
            $query = "SELECT  * FROM `#__js_job_fieldsordering` 
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

    function getResumeUserFields($ff) {
        if($ff)
            if(!is_numeric($ff)) return false;

        $result = array();
        $db = JFactory::getDBO();
        $query = "SELECT * FROM `#__js_job_fieldsordering`
					WHERE fieldfor = " . $ff . " 
					AND (field = 'section_userfields' OR field = 'userfield1' OR field = 'userfield2'
					OR field = 'userfield3' OR field = 'userfield4' OR field = 'userfield5' OR field = 'userfield6'
					OR field = 'userfield7' OR field = 'userfield8' OR field = 'userfield9' )";

        $db->setQuery($query);
        $result = $db->loadObjectList();

        return $result;
    }

    function fieldPublished($cid, $value) {
        $return = true;
        foreach ($cid as $field_id) {
            if (!is_numeric($field_id))
				return false;
            if(!is_numeric($value)) 
				return false;
            $db = JFactory::getDBO();
            $query = " UPDATE #__js_job_fieldsordering
                                            SET published = " . $value . "
                                            WHERE cannotunpublish = 0 AND id = " . $field_id;
            $db->setQuery($query);
            if (!$db->query()) {
                $return = false;
            }
        }
        return $return;
    }

    function visitorFieldPublished($cids, $value) {
        if(!is_numeric($value)) return false;
        $db = JFactory::getDBO();
        foreach ($cids AS $cid) {
            $query = " UPDATE #__js_job_fieldsordering	SET isvisitorpublished = " . $value . "	WHERE cannotunpublish = 0 AND id = " . $cid;
            $db->setQuery($query);
            if (!$db->query()) {
                return false;
            }
        }
        return true;
    }

    function fieldOrderingUp($field_id) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "UPDATE #__js_job_fieldsordering AS f1, #__js_job_fieldsordering AS f2
					SET f1.ordering = f1.ordering - 1
					WHERE f1.ordering = f2.ordering + 1
					AND f1.fieldfor = f2.fieldfor
					AND f2.id = " . $field_id . " ; ";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }

        $query = " UPDATE #__js_job_fieldsordering
					SET ordering = ordering + 1
					WHERE id = " . $field_id . ";"
        ;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function fieldOrderingDown($field_id) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "UPDATE #__js_job_fieldsordering AS f1, #__js_job_fieldsordering AS f2
					SET f1.ordering = f1.ordering + 1
					WHERE f1.ordering = f2.ordering - 1
					AND f1.fieldfor = f2.fieldfor
					AND f2.id = " . $field_id . " ; ";

        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }

        $query = " UPDATE #__js_job_fieldsordering
					SET ordering = ordering - 1
					WHERE id = " . $field_id . ";";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function publishunpublishfields($call) {
        ($call == 1) ? $publishunpublish = 1 : $publishunpublish = 0;
        $cids = JRequest::getVar('cid');
        $db = $this->getDbo();
        foreach ($cids AS $cid) {
            $query = "UPDATE `#__js_job_fieldsordering` SET published = " . $publishunpublish . " WHERE cannotunpublish = 0 AND id = " . $cid;
            $db->setQuery($query);
            if (!$db->query())
                return false;
        }
        return true;
    }

    // new
    function getFieldsOrderingforSearch($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = JFactory::getDBO();
        if (JFactory::getUser()->guest) {
            $published = ' AND search_visitor = 1 ';
        } else {
            $published = ' AND search_user = 1 ';
        }
        $query = "SELECT * FROM `#__js_job_fieldsordering`
                 WHERE cannotsearch = 0 AND  fieldfor = " . $fieldfor . $published . " ORDER BY ordering";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return $rows;
    }

    function getFieldsOrderingforView($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = JFactory::getDBO();
        $published = (JFactory::getUser()->guest) ? "isvisitorpublished" : "published";
        $query = "SELECT field,fieldtitle FROM `#__js_job_fieldsordering`
                WHERE $published = 1 AND fieldfor =  " . $fieldfor . " ORDER BY";
        if ($fieldfor == 3) // fields for resume
            $query.=" section ,";
        $query.=" ordering";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $return = array();

        //had make changes impliment fieldtitle in view compnay
        // if($fieldfor == 3){
        //     foreach ($rows AS $row) {
        //         $return[$row->field] = $row->required;
        //     }
        // }else{
            foreach ($rows AS $row) {
                $return[$row->field] = $row->fieldtitle;
            }
        // }

        return $return;
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

    function getUserFieldbyId($id , $fieldfor) {
        $results = array();
        $db = JFactory::getDBO();
        if ($id) {
            $db = JFactory::getDBO();
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT * FROM `#__js_job_fieldsordering` WHERE id = " . $id;
            $db->setQuery($query);
            $results['userfield'] = $db->loadObject();
            $params = $results['userfield']->userfieldparams;
            $results['userfieldparams'] = !empty($params) ? json_decode($params, True) : '';

            if($fieldfor == 3){
                //New code
                $field = $results['userfield']->field;
                $section = $results['userfield']->section;
                switch ($section) {
                    case '1': $table_name = 'resume'; break;
                    case '2': $table_name = 'resumeaddresses'; break;
                    case '3': $table_name = 'resumeinstitutes'; break;
                    case '4': $table_name = 'resumeemployers'; break;
                    case '5': $table_name = 'resume'; break;
                    case '6': $table_name = 'resume'; break;
                    case '7': $table_name = 'resumereferences'; break;
                    case '8': $table_name = 'resumelanguages'; break;
                }

                $query = "SELECT count(id) FROM `#__js_job_$table_name` WHERE params LIKE '%\"$field\":%'";
                $db->setQuery($query);
                $total = $db->loadResult();

                if($total > 0)
                    $results['hide'] = true;
                else
                    $results['hide'] = false;
            }
        }

        return $results;
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

    function storeUserField() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $data = JRequest::get('post');
        $db = JFactory::getDBO();
        //$data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        
        if (empty($data)) {
            return false;
        }
        
        $row = $this->getTable('fieldsordering');
        if ($data['isuserfield'] == 1) {
            // value to add as field ordering
            if ($data['id'] == '') { // only for new
                $query = "SELECT max(ordering) FROM `#__js_job_fieldsordering` WHERE fieldfor = " . $data['fieldfor'];
                $db->setQuery($query);
                $var = $db->loadResult();
                $var = $var + 1;
                $data['ordering'] = $var;

                $query = "SELECT (max(id) + 1) FROM `#__js_job_fieldsordering`";
                $db->setQuery($query);
                $var = $db->loadResult();
                $data['field'] = 'ufield'.$var;
            }
            $params = '';
            //code for depandetn field
            if (isset($data['userfieldtype']) && $data['userfieldtype'] == 'depandant_field') {
                if ($data['id'] != '') {
                    //to handle edit case of depandat field
                    $data['arraynames'] = $data['arraynames2'];
                }
                $flagvar = $this->updateParentField($data['parentfield'], $data['field'], $data['fieldfor']);
                if ($flagvar == false) {
                    return 3;
                }
                if (!empty($data['arraynames'])) {
                    $valarrays = explode(',', $data['arraynames']);
                    foreach ($valarrays as $key => $value) {
                        $keyvalue = $value;
                        $value = str_replace(' ','_',$value);
                        if ($data[$value] != null) {
                            $params[$keyvalue] = array_filter($data[$value]);
                        }
                    }
                }
            }
            if (!empty($data['values'])) {
                foreach ($data['values'] as $key => $value) {
                    if ($value != null) {
                        $params[] = trim($value);
                    }
                }
            }
            if(!empty($params)){
                $params = json_encode($params);
                $data['userfieldparams'] = $params;
            }
        }
        if (!$row->bind($data)) {
            return 3;
        }
        if (!$row->store()) {
            return 3;
        }

        $stored_id = $row->id;
        $result = array();
        $result[0] = $stored_id;

        return $result;
    }

    function updateParentField($parentfield, $field, $fieldfor) {  

        if(!is_numeric($parentfield)) return false;
        $db = JFactory::getDBO();
        $query = "UPDATE `#__js_job_fieldsordering` SET depandant_field = '' WHERE fieldfor = ".$fieldfor." AND depandant_field = '".$parentfield."'";
        $db->setQuery($query);
        $db->query();
        $query = "UPDATE `#__js_job_fieldsordering` SET depandant_field = '".$field."' WHERE id = ".$parentfield;
        $db->setQuery($query);
        $db->query();
        return true;
    }

    function getFieldsForComboByFieldFor($fieldfor, $parentfield) {
        $db = JFactory::getDBO();
        $query = "SELECT fieldtitle AS text ,id FROM `#__js_job_fieldsordering` WHERE fieldfor = $fieldfor AND (userfieldtype = 'radio' OR userfieldtype = 'combo') ";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        if($parentfield){
            $query = "SELECT id FROM `#__js_job_fieldsordering` WHERE fieldfor = $fieldfor AND (userfieldtype = 'radio' OR userfieldtype = 'combo') AND depandant_field = '" . $parentfield . "' ";
            $db->setQuery($query);
            $parent = $db->loadResult();
        }else{
            $parent = '';
        }
        $jsFunction = 'getDataOfSelectedField();';
        $html = customfields::select('parentfield', $data, $parent, JText::_('Select') .'&nbsp;'. JText::_('Parent Field'), array('onchange' => $jsFunction, 'class' => 'inputbox required'));
        $data = json_encode($html);
        return $data;
    }

    function getSectionToFillValues($pfield) {
        if(! is_numeric($pfield))
            return;

        $db = JFactory::getDBO();
        $query = "SELECT userfieldparams FROM `#__js_job_fieldsordering` WHERE id = $pfield";
        $db->setQuery($query);
        $data = $db->loadResult();
        $data = json_decode($data);
        $html = '';
        $fieldsvar = '';
        $comma = '';
        for ($i = 0; $i < count($data); $i++) {
            $fieldsvar .= $comma . "$data[$i]";
            $textvar = $data[$i];
            $textvar .='[]';
            $html .= "<div class='js-field-wrapper'>";
            $html .= "<div class='js-field-title'>" . $data[$i] . "</div>";
            $html .= "<div class='combo-options-fields' id='" . $data[$i] . "'>
                            <span class='input-field-wrapper'>
                                " . customfields::text($textvar, '', array('class' => 'inputbox one user-field')) . "
                                <img class='input-field-remove-img' src='components/com_jsjobs/include/images/remove.png' />
                            </span>
                            <input type='button' id='depandant-field-button' onClick='getNextField(\"" . $data[$i] . "\",this);'  value='Add More' />
                        </div>";
            $html .= "</div>";
            $comma = ',';
        }
        $html .= " <input type='hidden' name='arraynames' value='" . $fieldsvar . "' />";
        $html = json_encode($html);
        return $html;
    }

    function getOptionsForFieldEdit($field) {

        if( ! is_numeric($field))
            return;

        $db = JFactory::getDBO();
        $yesno = array(
            (object) array('id' => 1, 'text' => JText::_('Yes')),
            (object) array('id' => 0, 'text' => JText::_('No')));

        $query = "SELECT * FROM `#__js_job_fieldsordering` WHERE id = $field";
        $db->setQuery($query);
        $data = $db->loadObject();

        $html = '<span class="popup-top">
                    <span id="popup_title" >
                    ' . JText::_("Edit Field", "js-jobs") . '
                    </span>
                    <img id="popup_cross" onClick="closePopup();" src="components/com_jsjobs/include/images/popup-close.png">
                </span>';
        $html .= '<form action="index.php" method="POST" class="popup-field-from" name="adminForm" id="adminForm">';
        $html .= '<div class="popup-field-wrapper">
                    <div class="popup-field-title">' . JText::_('Field Title') . '<font class="required-notifier">*</font></div>
                    <div class="popup-field-obj">' . customfields::text('fieldtitle', isset($data->fieldtitle) ? $data->fieldtitle : 'text', '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                </div>';
        if ($data->cannotunpublish == 0) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . JText::_('User Published') . '</div>
                        <div class="popup-field-obj">' . customfields::select('published', $yesno, isset($data->published) ? $data->published : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . JText::_('Visitor published') . '</div>
                        <div class="popup-field-obj">' . customfields::select('isvisitorpublished', $yesno, isset($data->isvisitorpublished) ? $data->isvisitorpublished : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            if($data->userfieldtype != 'checkbox'){
                $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . JText::_('Required') . '</div>
                        <div class="popup-field-obj">' . customfields::select('required', $yesno, isset($data->required) ? $data->required : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            }
        }

        if ($data->cannotsearch == 0) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . JText::_('User Search') . '</div>
                        <div class="popup-field-obj">' . customfields::select('search_user', $yesno, isset($data->search_user) ? $data->search_user : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . JText::_('Visitor Search') . '</div>
                        <div class="popup-field-obj">' . customfields::select('search_visitor', $yesno, isset($data->search_visitor) ? $data->search_visitor : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
        }
        $showonlisting = true;
        if($data->fieldfor == 3 && $data->section != 1 ){
            $showonlisting = false;
        }
        if (($data->isuserfield == 1 || $data->cannotshowonlisting == 0) && $showonlisting == true) {
            $html .= '<div class="popup-field-wrapper">
                        <div class="popup-field-title">' . JText::_('Show On Listing') . '</div>
                        <div class="popup-field-obj">' . customfields::select('showonlisting', $yesno, isset($data->showonlisting) ? $data->showonlisting : 0, '', array('class' => 'inputbox one', 'data-validation' => 'required')) . '</div>
                    </div>';
        }
        $html .= customfields::hidden('id', $data->id);
        $html .= customfields::hidden('isuserfield', $data->isuserfield);
        $html .= customfields::hidden('fieldfor', $data->fieldfor);
        $html .= customfields::hidden('task', 'fieldordering.savejobuserfield');
        $html .= customfields::hidden('option', 'com_jsjobs');
        $html .= JHTML::_( 'form.token' );
        
        $html .='<div class="js-submit-container js-col-lg-10 js-col-md-10 js-col-md-offset-1 js-col-md-offset-1">
                    <input type="submit" name="save" id="save" class="savebutton" value="'.JText::_('Save').'">';
        if ($data->isuserfield == 1) {
            $edit_link = JFilterOutput::ampReplace('index.php?option=com_jsjobs&task=fieldordering.editjobuserfield&cid[]=' . $data->id);
            $html .= '<a id="user-field-anchor" href="'.$edit_link.'"> ' . JText::_('Advanced') . ' </a>';
        }

        $html .='</div>
            </form>';
        return json_encode($html);
    }


    function enforceDeleteUserField($id){
        if (is_numeric($id) == false)
           return false;
        $db = JFactory::getDBO();
        $query = "SELECT field,fieldfor FROM `#__js_job_fieldsordering` WHERE id = $id";
        $db->setQuery($query);
        $result = $db->loadObject();
        $row = $this->getTable('fieldsordering');
        if ($this->userFieldCanDelete($result) == true) {
            if (!$row->delete($id)) {
                return DELETE_ERROR;        
            }else{
                return DELETED;
            }
        }
        return IN_USE;
    }

    function deleteUserField($id){
        if (is_numeric($id) == false)
           return false;
        $db = JFactory::getDBO();
        $query = "SELECT field,fieldfor FROM `#__js_job_fieldsordering` WHERE id = $id";
        $db->setQuery($query);
        $result = $db->loadObject();
        $row = $this->getTable('fieldsordering'); 
        if ($this->userFieldCanDelete($result) == true) {
            if (!$row->delete($id)) {
                return DELETE_ERROR;        
            }else{
                return 1;
            }
        }
        return IN_USE;
    }

    function userFieldCanDelete($field) {
        $fieldname = $field->field;
        $fieldfor = $field->fieldfor; 
        $db = JFactory::getDBO();
        $table = '';
        if($fieldfor == 1){//for deleting a company field
            $table = "companies";
        }elseif($fieldfor == 2){//for deleting a job field
            $table = "jobs";
        }elseif($fieldfor == 3){//for deleting a resume field
            $table = "resume";
        }
        if($table == ''){
            return false;
        }
        $query = ' SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_'.$table.'` WHERE 
                        params LIKE \'%"' . $fieldname . '":%\' 
                    )
                    AS total';
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getFieldRequiredByNameAndFor($fieldname,$fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $query = "SELECT required FROM `#__js_job_fieldsordering` WHERE fieldfor = ".$fieldfor." and field = '".$fieldname."'";
        $db = $this->getDbo();
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getUnpublishedFieldsFor($fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $user = JFactory::getUser();
        if($user->guest){
            $publihsed = ' isvisitorpublished = 0 ';
        }else{
            $publihsed = ' published = 0 ';
        }
        $db = JFactory::getDbo();
        $query = "SELECT field FROM `#__js_job_fieldsordering` WHERE fieldfor = ".$fieldfor." AND ".$publihsed;
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }
}
?>
