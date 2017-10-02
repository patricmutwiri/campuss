<?php

/**
 * @Copyright Copyright (C) 2012 ... Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	April 05, 2012
  ^
  + Project: 		JS Autoz
  ^
 */
 
defined('_JEXEC') or die('Restricted access');
if (!defined('JVERSION')) {
    $version = new JVersion;
    $joomla = $version->getShortVersion();
    $jversion = substr($joomla, 0, 3);
    define('JVERSION', $jversion);
}
if (JVERSION < 3) {
    jimport('joomla.application.component.model');
    jimport('joomla.application.component.view');
    jimport('joomla.application.component.controller');

    if (!class_exists('JSModel', false)) {

        abstract class JSModel extends JModel {

            function __construct() {
                parent::__construct();
            }

            Static function getJSModel($model) {
                require_once JPATH_SITE . '/components/com_jsjobs/models/' . strtolower($model) . '.php';
                $modelclass = 'JSJobsModel' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }

            static function getSharingAdminModel($model){
                require_once JPATH_SITE . '/administrator/components/com_jsjobs/models/sharing/' . strtolower($model) . '.php';
                $modelclass = 'JSJobsModelSharing' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }

        }

    }
    if (!class_exists('JSView', false)) {

        abstract class JSView extends JView {

            function __construct() {
                parent::__construct();
            }

            Static function getJSModel($model) {
                require_once JPATH_SITE . '/components/com_jsjobs/models/' . strtolower($model) . '.php';
                $modelclass = 'JSJobsModel' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }

        }

    }
    if (!class_exists('JSController', false)) {

        abstract class JSController extends JController {

            function __construct() {
                parent::__construct();
            }

        }

    }
} else {

    if (!class_exists('JSModel', false)) {

        abstract class JSModel extends JModelLegacy {

            function __construct() {
                parent::__construct();
            }

            static function getJSModel($model) {
                require_once JPATH_SITE . '/components/com_jsjobs/models/' . strtolower($model) . '.php';
                $modelclass = 'JSJobsModel' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }
            
            static function getSharingAdminModel($model){
                require_once JPATH_SITE . '/administrator/components/com_jsjobs/models/sharing/' . strtolower($model) . '.php';
                $modelclass = 'JSJobsModelSharing' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }

        }

    }
    if (!class_exists('JSView', false)) {

        abstract class JSView extends JViewLegacy {

            function __construct() {
                parent::__construct();
            }

            Static function getJSModel($model) {
                require_once JPATH_SITE . '/components/com_jsjobs/models/' . strtolower($model) . '.php';
                $modelclass = 'JSJobsModel' . $model;
                $model_object = new $modelclass;
                return $model_object;
            }

        }

    }
    if (!class_exists('JSController', false)) {

        abstract class JSController extends JControllerLegacy {

            function __construct() {
                parent::__construct();
            }

        }

    }
}
?>
