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
$document = JFactory::getDocument();

$document->addStyleSheet(JURI::root() . 'components/com_jsjobs/css/token-input-jsjobs.css');
$document->addStyleSheet(JURI::root() . '/components/com_jsjobs/css/style.css');
require_once(JPATH_ROOT . '/components/com_jsjobs/css/style_color.php');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('../components/com_jsjobs/js/jquery.tokeninput.js');
$document->addScript(JURI::root() . 'components/com_jsjobs/js/multi-files-selector.js');

global $mainframe;
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=<?php echo $this->callfrom?>"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Form Resume'); ?></span></div>
    <?php 
        require_once(JPATH_ROOT . '/components/com_jsjobs/views/resume/tmpl/formresume.php');
    ?>
    <form action="index.php" method="post" name="adminForm" id="adminForm">
        <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="oi" value="<?php echo $this->jobid; ?>" />
        <input type="hidden" name="fd" value="<?php echo $this->fd; ?>" />
        <input type="hidden" name="boxchecked" value="0" />
    </form>
    </div>
</div>
<div id="jsjobs-footer">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>