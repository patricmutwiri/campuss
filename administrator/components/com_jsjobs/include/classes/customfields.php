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

class customfields {

    function formCustomFields($field , $obj_id, $obj_params ,  $resumeform = null, $section = null) { //$obj_id, $obj_params

        if ($resumeform != 1) {
            if ($field->isuserfield != 1) {
                return '';
            }
        }

        $cssclass = "";
        $html = '';
        $app = JFactory::getApplication();

        if ($resumeform == 1) {
            //had to do this so that there are minimum changes in resume code 
            $field = $this->userFieldData($field->field, 5, $section);
            if (empty($field)) {
                return '';
            }

            $div1 = '';
            $div2 = '';
            $div3 = '';

        } else {
            
            $div1 = ($app->isAdmin()) ? 'js-field-wrapper js-row no-margin' : 'js-col-md-12 js-form-wrapper';
            $div2 = ($app->isAdmin()) ? 'js-field-title js-col-lg-3 js-col-md-3 js-col-xs-12 no-padding' : 'js-col-md-12 js-form-title';
            $div3 = ($app->isAdmin()) ? 'js-field-obj js-col-lg-9 js-col-md-9 no-padding' : 'js-col-md-12 js-form-value';

        }
        
        $required = $field->required;
        $html = '<div class="' . $div1 . '">
               <div class="' . $div2 . '">';
        if ($required == 1) {
            $html .= $field->fieldtitle . '<font color="red">*</font>';
            if ($field->userfieldtype == 'email')
                $cssclass = "required validate-email";
            else
                $cssclass = "required";
        }else {
            $html .= $field->fieldtitle;
            if ($field->userfieldtype == 'email')
                $cssclass = "email";
            else
                $cssclass = "";
        }
        $html .= ' </div><div class="' . $div3 . '">';

        $resumeTitle = $field->fieldtitle;

        $size = '';
        $maxlength = '';
        if($field->size)
            $size = $field->size;
        if($field->maxlength)
            $maxlength = $field->maxlength;
        

        $fvalue = "";
        $value = "";
        $userdataid = "";
        if ($resumeform == 1) {
            
            $value = $obj_params;

            if($value){ // data has been stored
                $userfielddataarray = json_decode($value);
                $valuearray = json_decode($value,true);
            }else{
                $valuearray = array();
            }
            if(array_key_exists($field->field, $valuearray)){
                $value = $valuearray[$field->field];
            }else{
                $value = '';
            }
        } elseif (isset($obj_id)) {
            $userfielddataarray = json_decode($obj_params);
            $uffield = $field->field;
            if (isset($userfielddataarray->$uffield) || !empty($userfielddataarray->$uffield)) {
                $value = $userfielddataarray->$uffield;
            } else {
                $value = '';
            }
        }

        $user_field = '';
        switch ($field->userfieldtype) {
            case 'text':
            case 'email':
                $user_field .= $this->text($field->field, $value, array('class' => "inputbox one $cssclass", 'data-validation' => $cssclass, 'size' => $size, 'maxlength' => $maxlength));
                break;
            case 'date':            
                $user_field .= JHTML::_('calendar', $value, $field->field, $field->field, '%Y-%m-%d', array('class' => 'inputbox cal_userfield '.$cssclass, 'size' => '10', 'maxlength' => '19'));
                break;
            case 'textarea':
                $rows = '';
                $cols = '';
                if($field->rows)
                    $rows = $field->rows;
                if($field->cols)
                    $cols = $field->cols;            
                $user_field .= $this->textarea($field->field, $value, array('class' => "inputbox one $cssclass", 'data-validation' => $cssclass, 'rows' => $rows, 'cols' => $cols));
                break;
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    $i = 0;
                    $valuearray = explode(', ',$value);
                    foreach ($obj_option AS $option) {                        
                        $check = '';
                        if(in_array($option, $valuearray)){
                            $check = 'checked';
                        }
                        $user_field .= '<input type="checkbox" ' . $check . ' class="radiobutton '.$cssclass.'" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]">';
                        $user_field .= '<label class="cf_chkbox" for="' . $field->field . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $user_field .= $this->checkbox($field->field, $comboOptions, $value, array('class' => "radiobutton $cssclass"));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = "$obj_option[$i]";
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2);";
                }
                $user_field .= $this->radiobutton($field->field, $comboOptions, $value, array('class' => "cf_radio radiobutton $cssclass" , 'data-validation' => $cssclass, 'onclick' => $jsFunction));
                break;
            case 'combo':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',1);";
                }
                //end
                $user_field .= $this->select($field->field, $comboOptions, $value, JText::_('Select') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => "inputbox one $cssclass"));
                break;
            case 'depandant_field':
                $comboOptions = array();
                if ($value != null) {
                    if (!empty($field->userfieldparams)) {
                        $obj_option = $this->getDataForDepandantFieldByParentField($field->field, $userfielddataarray);
                        foreach ($obj_option as $opt) {
                            $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                        }
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "');";
                }
                //end
                $user_field .= $this->select($field->field, $comboOptions, $value, JText::_('Select') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => "inputbox one $cssclass"));
                break;
            case 'multiple':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                $array = $field->field;
                $array .= '[]';
                $valuearray = explode(', ', $value);
                $user_field .= $this->select($array, $comboOptions, $valuearray, '', array('data-validation' => $cssclass, 'multiple' => 'multiple', 'class' => "inputbox one $cssclass"));
                break;
            case 'file':
                if($value != null){ // since file already uploaded so we reglect the required 
                    $cssclass = str_replace('required', '', $cssclass);
                }
                $user_field .= '<input type="file" class="'.$cssclass.'" name="'.$field->field.'" id="'.$field->field.'"/>';
                if(JFactory::getApplication()->isAdmin()){
                    $this->_config = JSModel::getJSModel('configuration')->getConfig();
                }else{
                    $this->_config = JSModel::getJSModel('configurations')->getConfig('');
                }
                $fileext  = '';
                foreach ($this->_config as $conf) {
                    if ($conf->configname == 'image_file_type'){
                        if($fileext)
                            $fileext .= ',';
                        $fileext .= $conf->configvalue;
                    }
                    if ($conf->configname == 'document_file_type'){
                        if($fileext)
                            $fileext .= ',';
                        $fileext .= $conf->configvalue;
                    }
                    if ($conf->configname == 'document_file_size')
                        $maxFileSize = $conf->configvalue;
                }
                $fileext = explode(',', $fileext);
                $fileext = array_unique($fileext);
                $fileext = implode(',', $fileext);
                $user_field .= '<div id="js_cust_file_ext">'.JText::_('Files').'&nbsp;('.$fileext.')<br> '.JText::_('Maximum Size').' '.$maxFileSize.'(kb)</div>';
                if($value != null){
                    $user_field .= $this->hidden($field->field.'_1', 0);
                    $user_field .= $this->hidden($field->field.'_2',$value);
                    $jsFunction = "deleteCutomUploadedFile('".$field->field."','".$field->required."')";
                    $user_field .='<span class='.$field->field.'_1>'.$value.'( ';
                    $user_field .= "<a href='javascript:void(0)' onClick=".$jsFunction." >". JText::_('Delete')."</a>";
                    $user_field .= ' )</span>';
                }
                break;
        }

        $html .= $user_field;
        $html .= '</div></div>';

        if ($resumeform === 1) {
            return array('title' => $resumeTitle , 'value' => $user_field);
        }elseif($resumeform == 'admin'){
            return array('title' => $resumeTitle , 'value' => $user_field , 'lable' => $field->field);
        }elseif($resumeform == 'f_company'){
            return array('title' => $resumeTitle , 'value' => $user_field , 'lable' => $field->field);
        }else {
            echo $html;
        }
    }

    function formCustomFieldsForSearch($field, &$i, $filter_params ,  $datafor = null) { // $filter_params
        if ($field->isuserfield != 1)
            return false;
        $cssclass = "";
        $html = '';
        $i++;
        $div1 = 'js-col-md-12 js-form-wrapper';
        $div2 = 'js-col-md-12 js-form-title';
        $div3 = 'js-col-md-12 js-form-value';

        $html = '<div class="' . $div1 . '">
               <div class="' . $div2 . '">';
        $html .= $field->fieldtitle;
        $html .= ' </div><div class="' . $div3 . '">';
        
        $field_title = $field->fieldtitle;

        $readonly = '';
        $maxlength = '';
        $fvalue = "";
        $value = null;
        $userdataid = "";
        $userfielddataarray = array();
        if (isset($filter_params)) {
            $userfielddataarray = $filter_params;
            $uffield = $field->field;
            //had to user || oprator bcz of radio buttons

            if (isset($userfielddataarray[$uffield]) || !empty($userfielddataarray[$uffield])) {
                $value = $userfielddataarray[$uffield];
            } else {
                $value = '';
            }
        }
        $field_value = '';
        switch ($field->userfieldtype) {
            case 'text':
            case 'email':
            case 'file':
                $field_value .= $this->text($field->field, $value, array('class' => "inputbox one $cssclass", 'data-validation' => $cssclass,'placeholder' =>$field->fieldtitle));
                break;
            case 'date':
                $field_value .= JHTML::_('calendar', $value, $field->field, $field->field, '%Y-%m-%d', array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19'));
                break;
            case 'editor':
                break;
            case 'textarea':
                $rows = '';
                $cols = '';
                if(isset($field->rows))
                    $rows = $field->rows;
                if(isset($field->cols))
                    $cols = $field->cols;

                $field_value .= $this->textarea($field->field, $value, array('class' => "inputbox one $cssclass", 'data-validation' => $cssclass, 'rows' => $rows, 'cols' => $cols, $readonly));
                break;
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    if(empty($value))
                        $value = array();
                    foreach ($obj_option AS $option) {
                        if( in_array($option, $value)){
                            $check = 'checked="true"';
                        }else{
                            $check = '';
                        }
                        $field_value .= '<input type="checkbox" ' . $check . ' class="radiobutton cflabelcb" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]">';
                        $field_value .= '<label for="' . $field->field . '_' . $i . '" class="cflabelcb" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $field_value .= $this->checkbox($field->field, $comboOptions, $value, array('class' => 'radiobutton'));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = $obj_option[$i];
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2);";
                }
                $field_value .= $this->radiobutton($field->field, $comboOptions, $value, array('class' => 'radiobutton cflabelcb' , 'data-validation' => $cssclass, "autocomplete" => "off", 'onclick' => $jsFunction));
                break;
            case 'combo':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',1);";
                }
                //end
                $field_value .= $this->select($field->field, $comboOptions, $value, JText::_('Select') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => "inputbox one $cssclass"));
                break;
            case 'depandant_field':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = $this->getDataForDepandantFieldByParentField($field->field, $userfielddataarray);
                    if (!empty($obj_option)) {
                        foreach ($obj_option as $opt) {
                            $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                        }
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "');";
                }
                //end
                $field_value .= $this->select($field->field, $comboOptions, $value, JText::_('Select') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => "inputbox one $cssclass"));
                break;
            case 'multiple':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                $array = $field->field;
                $array .= '[]';
                $field_value .= $this->select($array, $comboOptions, $value, JText::_('Select') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'multiple' => 'multiple'));
                break;
        }

        $html .= $field_value;
        $html .= '</div></div>';
        
        if ($datafor == 1) {
            if($field_value){
                return array('title' => $field_title , 'field' => $field_value);
            }
            return '';
        } else {
            echo $html;
        }
    }

    function getUserFieldByField($field){
        $db = JFactory::getDbo();
        $query = "SELECT * FROM `#__js_job_fieldsordering` WHERE field = '".$field."' AND isuserfield = 1 ";
        $db->setQuery($query);
        $field = $db->loadObject();
        return $field;
    }


    function showCustomFields($field, $fieldfor, $object , $labelinlisting = 1) { // lableinlisting configuration for job lables
        $html = '';
        $fvalue = '';
        if($fieldfor == 11){
            $field = $this->getUserFieldByField($field);
            if(empty($field)){
                return false;
            }
        }

        $params = $object->params;
        if(isset($object->id)){
            $id = $object->id;
        }else{
            $id = $object->jobid;
        }

        if(!empty($params)){
            $data = json_decode($params,true);
            if(array_key_exists($field->field, $data)){
                $fvalue = $data[$field->field];
            }
        }
        $css1 = ''; $css2 = ''; $css3 = '';        
        $css4 = ''; $css5 = ''; $wrapperelement = '';
        $uploadcustomfilevariable = '';

        if($fieldfor == 1){ // jobs listing
            $css1 = 'js-col-xs-12 js-col-sm-6 js-col-md-4 js-fields for-rtl joblist-datafields custom-field-wrapper';
            $css2 = 'js-bold';  $css3 = 'get-text'; $css4 = 'js-bold';
            $css5 = 'get-text'; $wrapperelement = 'div';
            $uploadcustomfilevariable = 2;
        }elseif($fieldfor == 7){ // 
            $css1 = 'custom-field-wrapper';
            $css2 = 'js-bold';  $css3 = 'get-text'; $css4 = 'js-bold';
            $css5 = 'get-text'; $wrapperelement = 'div';
            $uploadcustomfilevariable = 2;
        }elseif($fieldfor == 9){ //myresume
            $css1 = 'jsjobs-categoryjob';   $css2 = 'jsjobs-titlecategory';  
            $css3 = 'jsjobs-valuecategory'; $css4 = 'jsjobs-titlecategory';
            $css5 = 'jsjobs-valuecategory'; $wrapperelement = 'span';
            $uploadcustomfilevariable = 3;
        }elseif($fieldfor == 10){ //resume listing
            $css1 = 'jsjobs-main-wrap';   $css2 = 'js_job_data_2_title';  
            $css3 = 'js_job_data_2_value'; $css4 = 'js_job_data_2_title';
            $css5 = 'js_job_data_2_value'; $wrapperelement = 'span';
            $uploadcustomfilevariable = 3;
        }elseif($fieldfor == 4){ // company listing
            $css1 = 'jsjobs-listcompany-location';   $css2 = 'jsjobs-listcompany-website';  
            $css3 = 'js-get-value'; $css4 = 'jsjobs-listcompany-website';
            $css5 = 'js-get-value'; $wrapperelement = 'span';
            $uploadcustomfilevariable = 1;
        }elseif($fieldfor == 5){ // company view
            $css1 = 'js_job_data_wrapper';   $css2 = 'js_job_data_title';  
            $css3 = 'js_job_data_value'; $css4 = 'js_job_data_title';
            $css5 = 'js_job_data_value'; $wrapperelement = 'div';
            $uploadcustomfilevariable = 1;
        }elseif($fieldfor == 8){ // mycompanies
            $css1 = 'jsjobs-data-2-wrapper';   $css2 = 'jsjobs-data-2-title';  
            $css3 = 'jsjobs-data-2-value'; $css4 = 'jsjobs-data-2-title';
            $css5 = 'jsjobs-data-2-value'; $wrapperelement = 'div';
            $uploadcustomfilevariable = 1;
        }elseif($fieldfor == 11 || $fieldfor == 6){ // view resume
            if($field->userfieldtype == 'file'){
                if($fvalue != null){
                    $path = JSModel::getJSModel('common')->getUploadedCustomFile($id , $fvalue , 3);
                    $html = '<a download="'.$fvalue.'" href="' . $path . '">' . $fvalue . '</a>';
                }
                return array('title' => $field->fieldtitle, 'value' => $html);
            }else{
                return array('title' => $field->fieldtitle, 'value' => $fvalue);
            }
        }elseif($fieldfor == 2){ // job view
            $css1 = 'js_job_data_wrapper';   $css2 = 'js_job_data_title';  
            $css3 = 'js_job_data_value'; $css4 = 'js_job_data_title';
            $css5 = 'js_job_data_value'; $wrapperelement = 'div';
            $uploadcustomfilevariable = 2;
        }elseif($fieldfor == 12){ // MY JOBS
            $css1 = 'jsjobs-data-2-wrapper js_forcat col-sm-4 col-md-4';   $css2 = 'js_job_data_2_title';  
            $css3 = 'js_job_data_2_value'; $css4 = 'js_job_data_2_title';
            $css5 = 'js_job_data_2_value'; $wrapperelement = 'div';
            $uploadcustomfilevariable = 2;
        }elseif($fieldfor == 3){ // Shortlisted jobs , myappliedjobs
            $css1 = 'jsjobs-data-2-wrapper';   $css2 = 'jsjobs-data-2-title';  
            $css3 = 'jsjobs-data-2-value'; $css4 = 'jsjobs-data-2-title';
            $css5 = 'jsjobs-data-2-value'; $wrapperelement = 'div';
        }
        $html = '<'.$wrapperelement.' class="'.$css1.'">';
        if($field->userfieldtype == 'file'){
            $html .= '<span class="'.$css2.'">' . $field->fieldtitle . ':&nbsp</span>';
            if($fvalue != null){
                $path = JSModel::getJSModel('common')->getUploadedCustomFile($id , $fvalue , $uploadcustomfilevariable);
                $html .= '
                    <span class="'.$css3.'">
                        <a download="'.$fvalue.'" href="' . $path . '">' . $fvalue . '</a>
                    </span>';
            }
        }else{
            if ($labelinlisting == 1) {
                $html .= '<span class="'.$css4.'">' . $field->fieldtitle . ':&nbsp</span>';
            }
            $html .= '<span class="'.$css5.'">' . $fvalue . '</span>';
        }
        $html .=   '</'.$wrapperelement.'>';

        return $html;
    }

    function userFieldData($field, $fieldfor, $section = null) {
        $db = JFactory::getDbo();

        if(empty($field))
            return '';
        
        $user = JFactory::getUser();
        if ($user->guest) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }

        $ff = '';
        if ($fieldfor == 2 || $fieldfor == 3) {
            $ff = " AND fieldfor = 2 ";
        } elseif ($fieldfor == 1 || $fieldfor == 4) {
            $ff = "AND fieldfor = 1 ";
        } elseif ($fieldfor == 5) {
            $ff = "AND fieldfor = 3 ";
        } elseif ($fieldfor == 6) {
            //form resume
            $ff = "AND fieldfor = 3 ";
            if(is_numeric($section)){
                $ff .= " AND section = $section ";
            }
        }
        $query = "SELECT * FROM `#__js_job_fieldsordering` WHERE isuserfield = 1 AND " . $published . " AND field ='" . $field . "'" . $ff;
        $db->setQuery($query);
        $data = $db->loadObject();
        return $data;
    }

    function userFieldsData($fieldfor, $listing = null , $getpersonal = null) {

        $db = JFactory::getDbo();
        $user = JFactory::getUser();

        if( ! is_numeric($fieldfor))
            return '';

        if ($user->guest) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }

        $inquery = '';
        if ($listing == 1) {
            $inquery .= ' AND showonlisting = 1 ';
        }

        if( $getpersonal == 1){
            $inquery .= ' AND section = 1 ';
            
        }


        $query = "SELECT * FROM `#__js_job_fieldsordering` WHERE isuserfield = 1 AND " . $published . " AND fieldfor =" . $fieldfor . $inquery . ' ORDER BY id ASC';
        
        $db->setQuery($query);
        $data = $db->loadObjectList();
        return $data;
    }

    function getDataForDepandantFieldByParentField($fieldfor, $data) {

        $db = JFactory::getDbo();
        $user = JFactory::getUser();

        if(empty($fieldfor))
            return '';

        if ($user->guest) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }

        $value = '';
        $returnarray = array();
        $query = "SELECT field FROM `#__js_job_fieldsordering` WHERE isuserfield = 1 AND " . $published . " AND depandant_field ='" . $fieldfor . "'";
        $db->setQuery($query);
        $field = $db->loadResult();
        if ($data != null) {
            foreach ($data as $key => $val) {
                if ($key == $field) {
                    $value = $val;
                }
            }
        }
        $query = "SELECT userfieldparams FROM `#__js_job_fieldsordering` WHERE isuserfield = 1 AND " . $published . " AND field ='" . $fieldfor . "'";
        $db->setQuery($query);
        $field = $db->loadResult();
        $fieldarray = json_decode($field);
        foreach ($fieldarray as $key => $val) {
            if ($value == $key)
                $returnarray = $val;
        }
        return $returnarray;
    }

    // new
    static function text($name, $value, $extraattr = array()) {
        if (strpos($name, '[]') !== false) {
            $id = str_replace('[]', '', $name);
        }else{
            $id = $name;
        }
        $textfield = '<input type="text" name="' . $name . '" id="' . $id . '" value="' . $value . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val)
                $textfield .= ' ' . $key . '="' . $val . '"';
        $textfield .= ' />';
        return $textfield;
    }
    static function textarea($name, $value, $extraattr = array()) {
        $textarea = '<textarea name="' . $name . '" id="' . $name . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val)
                $textarea .= ' ' . $key . '="' . $val . '"';
        $textarea .= ' >' . $value . '</textarea>';
        return $textarea;
    }
    static function hidden($name, $value, $extraattr = array()) {
        $textfield = '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val)
                $textfield .= ' ' . $key . '="' . $val . '"';
        $textfield .= ' />';
        return $textfield;
    }
    static function select($name, $list, $defaultvalue, $title = '', $extraattr = array() , $disabled = '') {
        if (strpos($name, '[]') !== false) {
            $id = str_replace('[]', '', $name);
        }else{
            $id = $name;
        }        
        $selectfield = '<select name="' . $name . '" id="' . $id . '" ';
        if (!empty($extraattr))
            foreach ($extraattr AS $key => $val) {
                $selectfield .= ' ' . $key . '="' . $val . '"';
            }
        if($disabled)
            $selectfield .= ' disabled>';
        else
            $selectfield .= ' >';
        if ($title != '') {
            $selectfield .= '<option value="">' . $title . '</option>';
        }
        if (!empty($list))
            foreach ($list AS $record) {
                if ((is_array($defaultvalue) && in_array($record->id, $defaultvalue)) || $defaultvalue == $record->id)
                    $selectfield .= '<option selected="selected" value="' . $record->id . '">' . JText::_($record->text) . '</option>';
                else
                    $selectfield .= '<option value="' . $record->id . '">' . JText::_($record->text) . '</option>';
            }

        $selectfield .= '</select>';
        return $selectfield;
    }
    static function radiobutton($name, $list, $defaultvalue, $extraattr = array()) {
        $radiobutton = '';
        $count = 1;
        $match = false;
        $firstvalue = '';
        foreach($list AS $value => $label){
            if($firstvalue == '')
                $firstvalue = $value;
            if($defaultvalue == $value){
                $match = true;
                break;
            }
        }
        if($match == false){
            //$defaultvalue = $firstvalue;
        }
        foreach ($list AS $value => $label) {
            $radiobutton .= '<input type="radio" name="' . $name . '" id="' . $name . $count . '" value="' . $value . '"';
            if ($defaultvalue == $value){
                $radiobutton .= ' checked="checked"';
            }
            if (!empty($extraattr))
                foreach ($extraattr AS $key => $val) {
                    $radiobutton .= ' ' . $key . '="' . $val . '"';
                }
            $radiobutton .= '/><label id="for' . $name . '" class="cf_radiobtn" for="' . $name . $count . '">' . $label . '</label>';
            $count++;
        }
        return $radiobutton;
    }
    static function checkbox($name, $list, $defaultvalue, $extraattr = array()) {
        $checkbox = '';
        $count = 1;
        foreach ($list AS $value => $label) {
            $checkbox .= '<input type="checkbox" name="' . $name . '" id="' . $name . $count . '" value="' . $value . '"';
            if ($defaultvalue == $value)
                $checkbox .= ' checked="checked"';
            if (!empty($extraattr))
                foreach ($extraattr AS $key => $val) {
                    $checkbox .= ' ' . $key . '="' . $val . '"';
                }
            $checkbox .= '/><label id="for' . $name . '" for="' . $name . $count . '">' . $label . '</label>';
            $count++;
        }
        return $checkbox;
    }
}
?>
