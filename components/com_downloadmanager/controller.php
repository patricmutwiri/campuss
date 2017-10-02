<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

class DownloadManagerController extends JControllerLegacy {


    protected $default_view = 'dashboard';


    public function display($cachable = false, $urlparams = false) {
        $view = $this->input->get('view', 'dashboard');
        $layout = $this->input->get('layout', 'dashboard');

        parent::display();

        return $this;
    }

}
