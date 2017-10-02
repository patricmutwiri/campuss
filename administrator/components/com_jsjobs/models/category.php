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

class JSJobsModelCategory extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getCategorybyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT id,isactive,cat_title,isdefault,ordering FROM #__js_job_categories WHERE id = " . $c_id;
        $db->setQuery($query);
        $category = $db->loadObject();
        return $category;
    }

    function getAllCategories($searchname, $searchstatus, $sortby, $js_sortby, $limitstart, $limit) {
        $db = JFactory::getDBO();
        if($js_sortby==1){
            $sortby = "ordering $sortby ";
        }elseif($js_sortby==2){
            $sortby = "cat_title $sortby ";
        }else{
            $sortby = "ordering asc";
        }
        $fquery="";
        $clause=" WHERE ";
        if($searchname){
            $fquery = $clause."cat_title LIKE ".$db->Quote('%'.$searchname.'%');
            $clause = " AND ";
        }
        if($searchstatus || $searchstatus == 0){
            if(is_numeric($searchstatus))
                $fquery .= $clause."isactive =".$searchstatus;
        }
        $lists = array();
        $lists['searchname'] = $searchname;
        $lists['searchstatus'] = JHTML::_('select.genericList', $this->getJSModel('common')->getStatus('Select Status'), 'searchstatus', 'class="inputbox" ', 'value', 'text', $searchstatus);
        $result = array();
        $query = "SELECT COUNT(id) FROM #__js_job_categories";
        $query .= $fquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT id,cat_title,isdefault,isactive,ordering FROM #__js_job_categories";
        $query .= $fquery." ORDER BY $sortby";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function storeCategory() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('category');
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        if (!empty($data['alias']))
            $cat_title_alias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $cat_title_alias = $this->getJSModel('common')->removeSpecialCharacter($data['cat_title']);

        $cat_title_alias = strtolower(str_replace(' ', '-', $cat_title_alias));
        $cat_title_alias = strtolower(str_replace('/', '-', $cat_title_alias));
        $data['alias'] = $cat_title_alias;

        if ($data['id'] == '') { // only for new
            $result = $this->isCategoryExist($data['cat_title']);
            if ($result == true) {
                return 3;
            } else {
                $db = JFactory::getDBO();
                $query = "SELECT max(ordering)+1 AS maxordering FROM #__js_job_categories";
                $db->setQuery($query);
                $ordering = $db->loadResult();
                $data['ordering'] = $ordering;
                $data['isdefault'] = 0;
            }
        }else{
            if(!(isset($data['isactive']))){
                $return_var = $this->getJSModel('common')->canUnpublishRecord($data['id'],'categories');
                if($return_var=='no'){
                    $data['isactive'] = 1;
                }
            }
        }


        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        $server_category_data = array();
        if ($this->_client_auth_key != "") {
            $server_category_data['id'] = $row->id;
            $server_category_data['cat_title'] = $row->cat_title;
            $server_category_data['alias'] = $row->alias;
            $server_category_data['isactive'] = $row->isactive;
            $server_category_data['serverid'] = $row->serverid;
            $server_category_data['authkey'] = $this->_client_auth_key;
            $table = "categories";
            $jobsharing = $this->getJSModel('jobsharing');

            $return_value = $jobsharing->storeDefaultTables($server_category_data, $table);
            return $return_value;
        } else {
            return true;
        }
    }

    function categoryChangeStatus($id, $status) {
        if (is_numeric($id) == false)
            return false;
        if (is_numeric($status) == false)
            return false;

        $db = $this->getDBO();
        if($status == 0){
            $query = "SELECT isdefault FROM `#__js_job_categories` WHERE id = ".$id;
            $db->setQuery($query);
            $result = $db->loadObject();
            if($result->isdefault == 1){
                return false;
            }
        }else{
            $row = $this->getTable('category');
            $row->id = $id;
            $row->isactive = $status;
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        }            
        return true;
    }

    function deleteCategory() {
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('category');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->categoryCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function deleteCategoryAndSubcategory() {

        $db = $this->getDBO();
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('category');
        $row1 = $this->getTable('subcategory');
        $deleteall = 1;
        foreach ($cids as $cid) {
            if ($this->checkCategoryCanDelete($cid) == true) {
                $query = "SELECT id FROM `#__js_job_subcategories` WHERE categoryid  = " . $cid;

                $db->setQuery($query);
                $subcategory = $db->loadObjectList();
                foreach ($subcategory as $subcat) {
                    if ($this->getJSModel('subcategory')->subCategoryCanDelete($subcat->id) == true) {
                        if (!$row1->delete($subcat->id)) {
                            $this->setError($row1->getErrorMsg());
                            return false;
                        }
                    }
                }
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function checkCategoryCanDelete($categoryid) {  // for delete category and subcategory
        if (is_numeric($categoryid) == false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_companies` WHERE category = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE jobcategory = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_resume` WHERE job_category = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_categories` WHERE id = " . $categoryid . " AND isdefault = 1)
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function categoryCanDelete($categoryid) {
        if (is_numeric($categoryid) == false)
            return false;
        $db = $this->getDBO();

        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_companies` WHERE category = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_jobs` WHERE jobcategory = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_resume` WHERE job_category = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_subcategories` WHERE categoryid = " . $categoryid . ")
                    + ( SELECT COUNT(id) FROM `#__js_job_categories` WHERE id = " . $categoryid . " AND isdefault = 1)
                    AS total ";

        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function isCategoryExist($cat_title) {
        $db = JFactory::getDBO();

        $query = "SELECT COUNT(id) FROM #__js_job_categories WHERE cat_title = " . $db->Quote($cat_title);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return false;
        else
            return true;
    }

    function getCategories($title, $value = "") {
        $db = JFactory::getDBO();

        $query = "SELECT id, cat_title FROM `#__js_job_categories` WHERE isactive = 1";
        if ($this->_client_auth_key != "")
            $query.=" AND serverid!='' AND serverid!=0";
        $query.= " ORDER BY ordering ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $jobcategories = array();
        if ($title)
            $jobcategories[] = array('value' => JText::_($value), 'text' => JText::_($title));
        foreach ($rows as $row) {
            $jobcategories[] = array('value' => JText::_($row->id),'text' => JText::_($row->cat_title));
        }
        return $jobcategories;
    }
}
?>