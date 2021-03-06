<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

class DownloadManagerViewsCategoryHtml extends JViewHtml
{
    public $task;

    function render()
    {
        $app = JFactory::getApplication();
        //$app->set('title','Download Manager');
        $type = $app->input->get('type');
        $id = $app->input->get('id');
        $view = $app->input->get('view');
        $task = $app->input->get('task');

        //retrieve task list from model
        $model = new DownloadManagerModelsCategory();


        if (isset($task) && method_exists($model, $task))
            $model->$task();

        $this->addToolbar();

        $this->task = !$id ? 'create' : 'update';


        return parent::render();
    }


    protected function addToolbar()
    {


        JToolbarHelper::title(JText::_('Download Manager / New Package', 'icon-download'));


    }
}