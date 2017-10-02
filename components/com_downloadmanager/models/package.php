<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

class DownloadManagerModelsPackage extends JModelBase{

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

    function Download(){
        ob_clean();
        $jinput = JFactory::getApplication()->input;
        $id = $jinput->get('id');
        $user = JFactory::getUser();

        if( $id > 0 )
        {
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query
                ->select('*')
                ->from($db->quoteName('#__dm_packages'))
                ->where('id = ' . $id);
            $db->setQuery($query);
            $post = $db->loadObject();

            $post->files = unserialize($post->files);
            $file = array_shift($post->files);

            if(!isset($file['path'])) die('No file attached!');

            if(!file_exists(JPATH_DM_UPLOAD.$file['path'])) die('File not found!');

            if(!isset($_SESSION['dm_key_'.$id]) || $_SESSION['dm_key_'.$id] != $_REQUEST['key']) {
                if ($user->id == 0 && in_array('members', unserialize($post->access))) {
                    die('Please login first!');
                }

                if ($post->password != '' && (!isset($_POST['password']) || $_POST['password'] != $post->password)) {
                    die('Wrong Password!');
                } else {
                    $_SESSION['dm_key_' . $id] = uniqid();
                    echo JUri::base() . 'index.php?option=com_downloadmanager&view=package&id=' . $id . '&task=download&key=' . $_SESSION['dm_key_' . $id];
                    die();
                }
            }



        } else
            die('No file found!');

        if(isset($_SESSION['dm_key_'.$id])) unset($_SESSION['dm_key_'.$id]);

        $package = new stdClass();
        $package->id = (int)$id;
        $package->download_count = (int)$post->download_count + 1;
        JFactory::getDbo()->updateObject('#__dm_packages', $package, 'id');

        dm_download_file(JPATH_DM_UPLOAD.$file['path'], basename($file['path']));
        die();
    }


    function Create(){
        $data = $_POST['pack'];
        $app = JFactory::getApplication();
        $filter = new \Joomla\Filter\InputFilter();
        $package = new stdClass();
        $package->title = $filter->clean($data['title'],'STRING');
        $package->description = $filter->clean($data['description'],'STRING');
        $package->link_label = $filter->clean($data['link_label'],'STRING');
        $package->password = $filter->clean($data['password'],'STRING');
        $package->template = $filter->clean($data['template'],'STRING');
        $package->page_template = $filter->clean($data['page_template'],'STRING');
        $package->icon = $filter->clean($data['icon'],'STRING');
        $package->access = serialize($filter->clean($data['access'],'ARRAY'));
        $package->category = serialize($filter->clean($data['category'],'ARRAY'));
        $package->files = serialize($filter->clean($data['files'],'ARRAY'));
        $package->quota = $filter->clean($data['quota'],'INT');
        $package->download_count = $filter->clean($data['download_count'],'INT');
        $package->url_key = $filter->clean($data['url_key'],'STRING');
        $package->create_date = time();
        $package->update_date = time();
        JFactory::getDbo()->insertObject('#__dm_packages', $package);
        $app->redirect('index.php?option=com_downloadmanager&view=packages');
        die();
    }

    function Update(){
        $data = $_POST['pack'];
        $app = JFactory::getApplication();
        $filter = new \Joomla\Filter\InputFilter();
        $package = new stdClass();
        $package->id = (int)$_POST['id'];
        $package->title = $filter->clean($data['title'],'STRING');
        $package->description = $filter->clean($data['description'],'STRING');
        $package->link_label = $filter->clean($data['link_label'],'STRING');
        $package->password = $filter->clean($data['password'],'STRING');
        $package->template = $filter->clean($data['template'],'STRING');
        $package->page_template = $filter->clean($data['page_template'],'STRING');
        $package->icon = $filter->clean($data['icon'],'STRING');
        $package->access = serialize($filter->clean($data['access'],'ARRAY'));
        $package->category = serialize($filter->clean($data['category'],'ARRAY'));
        $package->files = serialize($filter->clean($data['files'],'ARRAY'));
        $package->quota = $filter->clean($data['quota'],'INT');
        $package->download_count = $filter->clean($data['download_count'],'INT');
        $package->url_key = $filter->clean($data['url_key'],'STRING');
        $package->create_date = time();
        $package->update_date = time();
        JFactory::getDbo()->updateObject('#__dm_packages', $package, 'id');
        $app->redirect('index.php?option=com_downloadmanager&view=packages');
        die();
    }

    function Delete(){
        ob_clean();
        $user = JFactory::getUser();
        if(!$user->authorise('core.admin')) die('Authorization Failed!');

        $db = JFactory::getDbo();
        $id = (int)$_REQUEST['id'];

        $query = $db->getQuery(true);
        $conditions = array(
            $db->quoteName('id') . ' = '.$id
        );

        $query->delete($db->quoteName('#__dm_packages'));
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