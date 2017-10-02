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

class JSJOBSlayout {

    static function getNoRecordFound() {
        $link = "index.php?option=com_jsjobs";
        $html = '
				<div class="js_job_error_messages_wrapper">
                    <div class="message1">
                    	<span>
                    		'.JText::_("Opss").'...
                    	</span>
                    </div>    
                    <div class="message2">
                     	 <span class="img">
                     	<img class="js_job_messages_image" src="components/com_jsjobs/include/images/norecordfound.png"/>
                     	 </span> 
                     	 <span class="message-text">
                     	 	'. JText::_('Record Not Found') .'
                     	 </span>
                    </div>
                    <div class="footer">
                        <a href="'.$link.'">'.JText::_('Back To Control Panel').'</a>
                    </div>
				</div>
		';
        echo $html;
    }
}
?>