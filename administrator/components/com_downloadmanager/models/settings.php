<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

class DownloadManagerModelsSettings extends JModelBase{

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


    function Save(){
        $data = $_POST['pack'];
        $app = JFactory::getApplication();
        $filter = new \Joomla\Filter\InputFilter();
        if(isset($_POST['set'])){
            foreach($_POST['set'] as $k => $v){
                dm_set_option($k, $filter->clean($v));
            }
        }

        $app->redirect('index.php?option=com_downloadmanager&view=settings');
        die();
    }


}