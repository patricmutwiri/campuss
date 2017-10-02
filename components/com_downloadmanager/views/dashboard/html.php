<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');
 
class DownloadManagerViewsDashboardHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
      //$app->set('title','Download Manager');
    $type = $app->input->get('type');
    $id = $app->input->get('id');
    $view = $app->input->get('view');
 
    //retrieve task list from model
    //$model = new DownloadManagerModelsDashboard();

      //$this->downloadmanager = $model->getDashboard($id,$view,FALSE);

    $this->addToolbar();


    //display
    return parent::render();
  }


    protected function addToolbar()
    {

        //require_once JPATH_COMPONENT . '/helpers/downloadmanager.php';

        JToolbarHelper::title(JText::_('Download Manager', 'download.png'));
        //JToolBarHelper::custom('downloadmanager.addnew', '', '', 'Add New', true);
        //DownloadManagerHelper::addSubmenu('addnew');

    }
}