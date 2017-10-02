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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script>
function opendiv(){
	document.getElementById('jsjob_installer_waiting_div').style.display='block';
	document.getElementById('jsjob_installer_waiting_span').style.display='block';
}
</script>

<script type="text/javascript">
function validate_form(f)
{
	opendiv();
	var domain = jQuery('input#domain').val();
	var producttype = jQuery('input#producttype').val();
	var productcode = jQuery('input#productcode').val();
	var productversion = jQuery('input#productversion').val();
	var count_config = jQuery('input#count_config').val();
	var JVERSION = jQuery('input#JVERSION').val();
	var installerversion = jQuery('input#installerversion').val();
	var transactionkey = jQuery('input#transactionkey').val();
    jQuery.post('index.php?option=com_jsjobs&c=installer&task=startinstallation',{domain:domain,producttype:producttype,productcode:productcode,productversion:productversion,count_config:count_config,JVERSION:JVERSION,installerversion:installerversion,transactionkey:transactionkey},function(data){
        if(data){
			var response=jQuery.parseJSON(data);
			if(typeof response =='object')
			{
			  if(response[0] == 1){
				jQuery("div#versiondata").html(response[2]);
				document.getElementById('jsjob_installer_waiting_div').style.display='none';
				document.getElementById('jsjob_installer_waiting_span').style.display='none';
			  }else{
				jQuery("div#versiondata").html('<span id="error_message" style="color:red">'+response[2]+'</span>');
				document.getElementById('jsjob_installer_waiting_div').style.display='none';
				document.getElementById('jsjob_installer_waiting_span').style.display='none';
			  }
			}
        }
    });
}
</script>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Update'); ?></span></div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
        <div id="jsjob_installer_waiting_div" style="display:none;"></div>
<span id="jsjob_installer_waiting_span" style="display:none;"><?php echo JText::_('Please wait installation in progress');?></span>
<div class="js_installer_wrapper">
        <div class="update-header-img step-3">
            <div class="header-parts first-part">
                <span class="text"><?php echo JText::_('Configuration'); ?></span>
                <span class="text-no">1</span>
                <img src="components/com_jsjobs/include/images/update-header-2.png" />
            </div>
            <div class="header-parts second-part">
                <span class="text"><?php echo JText::_('Permissions'); ?></span>
                <span class="text-no">2</span>
                <img src="components/com_jsjobs/include/images/update-header-2.png" />
            </div>
            <div class="header-parts third-part">
                <span class="text"><?php echo JText::_('Install'); ?></span>
                <span class="text-no">3</span>
                <img src="components/com_jsjobs/include/images/update-header-1.png" />
            </div>
            <div class="header-parts fourth-part">
                <span class="text"><?php echo JText::_('Finish'); ?></span>
                <span class="text-no">4</span>
                <img src="components/com_jsjobs/include/images/update-header-3.png" />
            </div>
        </div>
        <div class="js_header_bar"><?php echo JText::_('Please fill the form and press start');?></div>
        
        <div class="js_wrapper">
    <?php if(in_array  ('curl', get_loaded_extensions())) { ?>
            <div class="js_installer_formwrapper">
                <div id="jsjob_installer_formlabel">
                        <label id="transactionkeymsg" for="transactionkey"><?php echo JText::_('Authentication key'); ?></label>
                </div>
                <div id="jsjob_installer_forminput">
                        <input style="height:35px;" id="transactionkey" name="transactionkey" class="inputbox required" value="" />
					<div id="jsjob_installer_formsubmitbutton">
            	    	<input type="button" class="button" id="jsjob_instbutton" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('NEXT'); ?>" />
            		</div>
                </div>
            </div>
    <?php }else{ ?>
            <div id="jsjob_installer_warning"><?php echo JText::_('WARNING'); ?>!</div>
            <div id="jsjob_installer_warningmsg"><?php echo JText::_('CURL is not enabled please enable CURL'); ?></div>
    <?php } ?>
        </div>
</div>
    <div id="versiondata"></div>
<div class="js_installer_wrapper">
    <?php if(!in_array  ('curl', get_loaded_extensions())) { ?>
        <span id="jsjob_installer_arrow"><?php echo JText::_('Reference links'); ?></span>
        <span id="jsjob_installer_link"><a href="http://devilsworkshop.org/tutorial/enabling-curl-on-windowsphpapache-machine/702/"><?php echo JText::_('http://devilsworkshop.org/...'); ?></a></span>
        <span id="jsjob_installer_link"><a href="http://www.tomjepson.co.uk/enabling-curl-in-php-php-ini-wamp-xamp-ubuntu/"><?php echo JText::_('http://www.tomjepson.co.uk/...'); ?></a></span>
        <span id="jsjob_installer_link"><a href="http://www.joomlashine.com/blog/how-to-enable-curl-in-php.html"><?php echo JText::_('http://www.joomlashine.com/...'); ?></a></span>
    <?php }else{ ?>
        <span id="jsjob_installer_mintmsg"><?php echo JText::_('It may take few minutes'); ?>...</span>
    <?php } ?>
</div>
    <input type="hidden" name="check" value="" />
    <input type="hidden" name="domain" id="domain" value="<?php echo JURI::root(); ?>" />
    <input type="hidden" name="producttype" id="producttype" value="<?php echo $this->versiontype->configvalue;?>" />
    <input type="hidden" name="productcode" id="productcode" value="jsjobs" />
    <input type="hidden" name="productversion" id="productversion" value="<?php echo str_replace('.','',$this->versioncode->configvalue);?>" />
    <input type="hidden" name="count_config" id="count_config" value="<?php echo $this->count_config;?>" />
    <input type="hidden" name="JVERSION" id="JVERSION" value="<?php echo JVERSION;?>" />
    <input type="hidden" name="installerversion" id="installerversion" value="1.1" />
    <input type="hidden" name="c" value="installer" />
    <input type="hidden" name="task" value="startinstallation" />
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />

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
