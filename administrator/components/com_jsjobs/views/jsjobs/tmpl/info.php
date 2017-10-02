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

?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Information'); ?></span></div>
<!--  -->
        <div id="top_bluebar"><label><?php echo JText::_('Component Details'); ?></label></div><!--Top Blue Bar closed-->
        <div id="info_main_content">
            <div id="info_det">
                <label></label>
                <span class="left_info"><?php echo JText::_('Created By'); ?></span>
                <span class="right_info"><?php echo 'Ahmed Bilal'; ?></span>

                <span class="left_info"><?php echo JText::_('Company'); ?></span>
                <span class="right_info"><?php echo JText::_('Joom Sky'); ?></span>


                <span class="left_info"><?php echo JText::_('Version'); ?></span>
                <span class="right_info"><?php echo JText::_('1.1.5 - r'); ?></span>
            </div><!--info det closed-->
            <div id="info_desc">
                    <img class="info_img_logo" src="components/com_jsjobs/include/images/logo-new.png">
                    <span class="info_line"></span>
                    <label><?php echo JText::_('About Joomsky'); ?></label>
                    <span class="info_text"><?php echo JText::_('Our philosophy on project development is quite simple. We deliver exactly what you need to ensure the growth and effective running of your business. To do this we undertake a complete analysis of your business needs with you, then conduct thorough research and use our knowledge and expertise of software development programs to identify the products that are most beneficial to your business projects.'); ?></span>
                    <a class="info_link" href="http://Www.joomsky.com" target="_blank" ><?php echo 'www.joomsky.com'; ?></a>
            </div><!--info desc closed-->  
            
            <div id="info_datablock">
                <div class="info_block2">
                 <div class="info_block1_img">
                    <img class="img1" src="components/com_jsjobs/include/images/joomla-new.png">
                    <span class="title"><?php echo JText::_('JS Jobs'); ?></span>
                    <span class="type"><?php echo JText::_('Joomla'); ?></span>
                    <span class="detail"><?php echo JText::_('JS Jobs for any business, industry body or staffing company wishing to establish a presence on the internet where job seekers can come to view the latest jobs and apply to them.JS Jobs allows you to run your own, unique jobs classifieds service where you or employer can advertise their jobs and jobseekers can upload their Resumes.'); ?></span>
                    <span class="detail">
                        <a class="bottom_links_info pro_color1" href="http://www.joomsky.com/products/js-jobs-pro.html" target="_blank"><?php echo JText::_('Pro Download'); ?></a>
                        <a class="bottom_links_info" href="http://www.joomsky.com/products/js-jobs.html" target="_blank"><?php echo JText::_('Free Download'); ?></a>
                    </span> 
                 </div>
                </div>   
            </div> <!--data block closed-->

              <div id="info_datablock">
                <div class="info_block4">
                 <div class="info_block7_img">
                    <img class="img1" src="components/com_jsjobs/include/images/wordpress-new.png">
                    <span class="title"><?php echo JText::_('JS JOBS'); ?></span>
                    <span class="type"><?php echo JText::_('Wordpress'); ?></span>
                    <span class="detail"><?php echo JText::_('JS Jobs for any business, industry body or staffing company wishing to establish a presence on the internet where job seekers can come to view the latest jobs and apply to them.JS Jobs allows you to run your own, unique jobs classifieds service where you or employer can advertise their jobs and jobseekers can upload their Resumes.'); ?></span>
                    <span class="detail">
                        <a class="bottom_links_info pro_color4" href="http://www.joomsky.com/products/js-jobs-pro-wp.html" target="_blank"><?php echo JText::_('Pro Download'); ?></a>
                        <a class="bottom_links_info" href="http://www.joomsky.com/products/js-jobs-wp.html" target="_blank"><?php echo JText::_('Free Download'); ?></a>
                    </span> 
                 </div>
                </div>   
            </div> <!--data block closed-->
              

            <div id="info_datablock">
                <div class="info_block6">
                 <div class="info_block6_img">
                    <img class="img1" src="components/com_jsjobs/include/images/joomla-new.png">
                    <span class="title"><?php echo JText::_('JS Support Ticket'); ?></span>
                    <span class="type"><?php echo JText::_('Joomla'); ?></span>
                    <span class="detail"><?php echo JText::_('JS Support Ticket is a trusted open source ticket system. JS Support ticket is a simple, easy to use, web-based customer support system. User can create ticket from front-end. JS support ticket comes packed with lot features than most of the expensive(and complex) support ticket system on market.'); ?></span>
                    <span class="detail">
                        <a class="bottom_links_info pro_color3" href="http://www.joomsky.com/products/js-supprot-ticket-pro-joomla.html" target="_blank"><?php echo JText::_('Pro Download'); ?></a>
                        <a class="bottom_links_info" href="http://www.joomsky.com/products/js-supprot-ticket-joomla.html" target="_blank"><?php echo JText::_('Free Download'); ?></a>
                    </span> 
                 </div>
                </div>   
            </div> <!--data block closed-->
              
              <div id="info_datablock">
                <div class="info_block4">
                 <div class="info_block4_img">
                    <img class="img1" src="components/com_jsjobs/include/images/wordpress-new.png">
                    <span class="title"><?php echo JText::_('JS Support Ticket'); ?></span>
                    <span class="type"><?php echo JText::_('Wordpress'); ?></span>
                    <span class="detail"><?php echo JText::_('JS Support Ticket is a trusted open source ticket system. JS Support ticket is a simple, easy to use, web-based customer support system. User can create ticket from front-end. JS support ticket comes packed with lot features than most of the expensive(and complex) support ticket system on market.'); ?></span>
                    <span class="detail">
                        <a class="bottom_links_info pro_color4" href="http://www.joomsky.com/products/js-supprot-ticket-pro-wp.html" target="_blank"><?php echo JText::_('Pro Download'); ?></a>
                        <a class="bottom_links_info" href="http://www.joomsky.com/products/js-supprot-ticket-wp.html" target="_blank"><?php echo JText::_('Free Download'); ?></a>
                    </span> 
                 </div>
                </div>   
            </div> <!--data block closed-->

            <div id="info_datablock">
                <div class="info_block5">
                 <div class="info_block5_img">
                    <img class="img1" src="components/com_jsjobs/include/images/joomla-new.png">
                    <span class="title"><?php echo JText::_('JS Autoz'); ?></span>
                    <span class="type"><?php echo JText::_('Joomla'); ?></span>
                    <span class="detail"><?php echo JText::_('JS Autoz is robust and powerful vehicles show room componet for Joomla. JS Autoz help you build online show room with clicks. With admin power you can esily manage makes, models, types etc in admin area.'); ?></span>
                    <span class="detail">
                        <a class="bottom_links_info pro_color5" href="http://www.joomsky.com/products/js-autoz-pro.html" target="_blank"><?php echo JText::_('Pro Download'); ?></a>
                        <a class="bottom_links_info" href="http://www.joomsky.com/products/js-autoz.html" target="_blank"><?php echo JText::_('Free Download'); ?></a>
                    </span> 
                 </div>
                </div>   
            </div> <!--data block closed-->
              
           
          
        </div><!--info main content closed-->
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