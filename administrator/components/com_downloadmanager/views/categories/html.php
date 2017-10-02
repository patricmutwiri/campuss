<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');



class DownloadManagerViewsCategoriesHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();


    $this->addToolbar();


    //display
    return parent::render();
  }


    protected function addToolbar()
    {

        JToolbarHelper::title(JText::_('Download Manager / Categories', 'icon-download'));


    }
}