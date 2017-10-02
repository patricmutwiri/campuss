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
 
$commonpath = "index.php?option=com_jsjobs";
$pathway = $mainframe->getPathway();
if ($config['cur_location'] == 1) {
    switch ($layout) {
        case 'mydepartments':
            $pathway->addItem(JText::_('My Departments'), '');
            break;
        case 'formdepartment':
            if (isset($result)) {
                $pathway->addItem(JText::_('My Departments'), $commonpath . '&c=department&view=department&layout=mydepartments&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Edit Department Information'), '');
            } else {
                $pathway->addItem(JText::_(' Department'), '');
            }
            break;
        case 'view_department':
            $pathway->addItem(JText::_('My Departments'), $commonpath . '&c=department&view=department&layout=mydepartments&Itemid=' . $itemid);
            $pathway->addItem(JText::_('View Department'), '');
            break;
    }
}
?>
