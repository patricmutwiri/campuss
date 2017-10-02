<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

class DownloadManagerModelsCategory extends JModelBase{

    public $_db;
    public $_id;
    public $_input;
    public $_app;

    function __construct(){
        $this->_db = JFactory::getDBO();
        $this->_app = JFactory::getApplication();
        $this->_input = $this->_app->input;
        $this->_id = $this->_app->input->get("id",null,'INT');
    }


    function Create(){
        $data = $_POST['cat'];
        $data['url_key'] = $data['url_key']?$data['url_key']:$data['name'];
        $app = JFactory::getApplication();
        $filter = new \Joomla\Filter\InputFilter();
        $category = new stdClass();
        $category->name = $filter->clean($data['name'],'STRING');
        $category->description = $filter->clean($data['description'],'STRING');
        $category->url_key = sanitize_title($filter->clean($data['url_key'],'STRING'));
        $category->parent = $filter->clean($data['parent'],'INT');
        JFactory::getDbo()->insertObject('#__dm_categories', $category);
        $app->redirect('index.php?option=com_downloadmanager&view=categories');
        die();
    }

    function Update(){
        $data = $_POST['cat'];
        $data['url_key'] = $data['url_key']?$data['url_key']:$data['name'];
        $app = JFactory::getApplication();
        $filter = new \Joomla\Filter\InputFilter();
        $category = new stdClass();
        $category->name = $filter->clean($data['name'],'STRING');
        $category->description = $filter->clean($data['description'],'STRING');
        $category->url_key = sanitize_title($filter->clean($data['url_key'],'STRING'));
        $category->parent = $filter->clean($data['parent'],'INT');
        JFactory::getDbo()->updateObject('#__dm_categories', $category, 'cid');
        $app->redirect('index.php?option=com_downloadmanager&view=categories');
        die();
    }

    function Delete(){
        ob_clean();
        $user = JFactory::getUser();
        if(!$user->authorise('core.admin')) die('Authorization Failed!');

        $db = JFactory::getDbo();
        $id = (int)$_REQUEST['cid'];

        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('cid') . ' = '.$id
        );

        $query->delete($db->quoteName('#__dm_categories'));
        $query->where($conditions);

        $db->setQuery($query);
        $db->execute();
        die("Deleted");
    }

    function Upload(){
        ob_clean();
        $user = JFactory::getUser();
        if(!$user->authorise('core.admin')) die('Authorization Failed!');
        if(!file_exists( JPATH_DM_UPLOAD )) @mkdir( JPATH_DM_UPLOAD );
        foreach($_FILES as $id => $file){
            if(is_uploaded_file($file['tmp_name'])){
                move_uploaded_file($file['tmp_name'], JPATH_DM_UPLOAD.$file['name']);
            }
        }
        echo $file['name']; die();
    }

}