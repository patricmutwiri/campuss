<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

require_once  JPATH_COMPONENT . '/helpers/functions.php';
JLoader::register('DownloadManagerHelper', JPATH_COMPONENT . '/helpers/downloadmanager.php');


//load classes
JLoader::registerPrefix('DownloadManager', JPATH_COMPONENT);

//Load plugins
JPluginHelper::importPlugin('downloadmanager');

//application
$app = JFactory::getApplication();

// Require specific controller if requested
$controller = $app->input->get('controller','default');

// Create the controller
$classname  = 'DownloadManagerControllers'.ucwords($controller);
$controller = new $classname();

// Perform the Request task
$controller->execute();
 