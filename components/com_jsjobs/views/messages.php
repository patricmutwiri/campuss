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

class JSJobsMessages {

    function getSystemOfflineMsg($config) {
        $html = '
                <div class="js_job_error_messages_wrapper">
                    <div class="message1">
                        <span>
                            ' . $config["title"] .' '.JText::_('Is Offline'). '
                        </span>
                    </div>    
                    <div class="message2">
                         <span class="img">
                        <img class="js_job_messages_image" src="'.JURI::root().'components/com_jsjobs/images/7.png"/>
                         </span> 
                         <span class="message-text">
                            ' . $config["offline_text"] . '
                         </span>
                    </div>
                    <div class="footer">

                    </div>
                </div>
        ';
        echo $html;
    }


    function getCPNoRecordFound() {
        $msg = '<div class="jsjobs-cp-applied-resume-not-found">
                    <div class="jsjobs-cp-not-found-data">
                       <img class="jsjobs-cp-not-found-img" src="'.JURI::root().'components/com_jsjobs/images/no record icon.png">  
                       <span class="jsjobs-not-found-title">'. JText::_('Record Not Found').'</span>
                    </div>
                </div>';
        echo $msg;
    }


    function getAccessDeniedMsg($msgTitle, $msgLang, $isVisitor = 0) {
        $html = '<div class="js_job_error_messages_wrapper">
                    <div class="message1">
                        <span>
                            ' . JText::_($msgTitle) . '
                        </span>
                    </div>    
                    <div class="message2">
                         <span class="img">
                        <img class="js_job_messages_image" src="'.JURI::root().'components/com_jsjobs/images/2.png"/>
                         </span> 
                         <span class="message-text">
                            ' . JText::_($msgLang) . '
                         </span>
                    </div>
                    <div class="footer">
                    ';

        if ($isVisitor == 1) {
            $itemid = JRequest::getVar('Itemid');
            $html.= '<a href="index.php?option=com_users&view=login" >' . JText::_("Login") . '</a>';
        }
        $html .= '
                    </div>
                </div>
        ';

        echo $html;
    }

    function getAccessDeniedMsg_return($msgTitle, $msgLang , $links = "") {
        $html = '<div class="js_job_error_messages_wrapper">
                    <div class="message1">
                        <span>
                            ' . JText::_($msgTitle) . '
                        </span>
                    </div>    
                    <div class="message2">
                         <span class="img">
                        <img class="js_job_messages_image" src="'.JURI::root().'components/com_jsjobs/images/2.png"/>
                         </span> 
                         <span class="message-text">
                            ' . JText::_($msgLang) . '
                         </span>
                    </div>
                    <div class="footer">
                        '.$links.'
                    </div>
                </div>
                ';
        return $html;
    }


    function getPackageExpireMsg($msgTitle, $msgLang, $link, $linktitle = 'Packages') {
        $html = '
                <div class="js_job_error_messages_wrapper">
                    <div class="message1">
                        <span>
                            '.JText::_($msgTitle).'
                        </span>
                    </div>    
                    <div class="message2">
                         <span class="img">
                        <img class="js_job_messages_image" src="'.JURI::root().'components/com_jsjobs/images/2.png"/>
                         </span> 
                         <span class="message-text">
                            '.JText::_($msgLang).'
                         </span>
                    </div>
                    <div class="footer">
                        <a href="'.$link.'" >'.JText::_($linktitle).'</a>
                    </div>
                </div>
        ';
        echo $html;
    }


    function getUserNotSelectedMsg($msgTitle, $msgLang, $link) {
        $html = '
                <div class="js_job_error_messages_wrapper">
                    <div class="message1">
                        <span>
                            '.JText::_($msgTitle).'
                        </span>
                    </div>    
                    <div class="message2">
                         <span class="img">
                        <img class="js_job_messages_image" src="'.JURI::root().'components/com_jsjobs/images/1.png"/>
                         </span> 
                         <span class="message-text">
                            '.JText::_($msgLang).'
                         </span>
                    </div>
                    <div class="footer">
                        <a href="'.$link.'" >'.JText::_('Please select your role').'</a>
                    </div>
                </div>
        ';
        echo $html;
    }
}

?>