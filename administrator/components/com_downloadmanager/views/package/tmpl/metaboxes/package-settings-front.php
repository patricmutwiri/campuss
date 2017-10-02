<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

?>
<div>
<ul class="nav nav-tabs">
    <li class="active"><a href="#package-settings" data-toggle="tab">Package Settings</a></li>
    <!-- li><a href="#lock-options" data-toggle="tab">Lock Options</a></li>
    <li><a href="#package-icons" data-toggle="tab">Icons</a></li -->
    <?php 
    
    $etabs = apply_filters('wpdm_package_settings_tabs',array());
    foreach($etabs as $id=>$tab){
        echo "<li><a href='#{$id}' data-toggle='tab'>{$tab['name']}</a></li>";
         
    } ?>
</ul>

<div class="tab-content">
<div id="package-settings" class="tab-pane active">
    <table cellpadding="5" id="file_settings_table" cellspacing="0" width="100%" class="frm">
        <tr id="link_label_row">
            <td width="90px">Link Label:</td>
            <td><input size="10" type="text" class="form-control" style="width: 200px" value="<?php echo isset($post->link_label)?$post->link_label:''; ?>" name="pack[link_label]" />
            </td></tr>

        <tr id="downliad_limit_row">
            <td>Stock&nbsp;Limit:</td>
            <td><input size="10" class="form-control" style="width: 80px" type="text" name="pack[quota]" value="<?php echo get_post_data($post,'quota',true); ?>" /></td>
        </tr>

        <tr id="downliad_limit_row">
            <td>Download&nbsp;Limit:</td>
            <td><input size="10" class="form-control" style="width: 80px;display:inline" type="text" name="pack[download_limit_per_user]" value="<?php echo get_post_data($post,'download_limit_per_user', true); ?>" /> / user <span class="info infoicon" title="For non-registered members IP will be taken as ID">&nbsp;</span></td>
        </tr>
        <tr id="download_count_row">
            <td>Download&nbsp;Count:</td>
            <td><input size="10" class="form-control" style="width: 80px;" type="text" name="pack[download_count]" value="<?php echo get_post_data($post,'download_count',true); ?>" /> <span class="info infoicon" title="Set/Reset Download Count for this package">&nbsp;</span></td>
        </tr>
        <tr id="package_size_row">
            <td>File&nbsp;Size:</td>
            <td><input size="10" style="width: 80px" class="form-control" type="text" name="pack[package_size]" value="<?php echo get_post_data($post,'package_size',true); ?>" /> <span class="info infoicon" title="Total size of included files with this package.">&nbsp;</span></td>
        </tr>
       <tr id="package_size_row">
            <td>Password:</td>
            <td><input size="10" style="width: 80px" class="form-control" type="text" name="pack[password]" value="<?php echo get_post_data($post,'password',true); ?>" /></td>
        </tr>
        <tr id="access_row">
            <td valign="top">Allow Access:</td>
            <td>

                    <label class="eden-radio"><input type="radio" name="pack[access][]" <?php if(!isset($post->access) || in_array('guest', unserialize($post->access))) echo 'checked=checked'; ?> value="guest"><span class="fa fa-check"></span> All Visitors</label><br/>
                    <label class="eden-radio"><input type="radio" name="pack[access][]" <?php if(isset($post->access) && in_array('members', unserialize($post->access))) echo 'checked=checked'; ?> value="members"><span class="fa fa-check"></span> Members Only</label>
                    <?php

                    $currentAccess = array();
                    $selz = '';
                    if(  $currentAccess ) $selz = (in_array('guest',$currentAccess))?'selected=selected':'';
                    if(!isset($_GET['id'])) $selz = 'selected=selected';
                    ?>


            </td></tr>

        <!--tr id="templates_row">
            <td>Individual File:</td>
            <td>


                <div id="eid">
                    <label class="eden-radio"><input type="radio" value="0" id="radio1" name="pack[individual_file_download]" <?php checked(get_post_data($post,'individual_file_download', true),0);?> /><span></span> Don't Allow Inidividual File Download</label><br/>
                    <label class="eden-radio"><input type="radio" value="1" id="radio2" name="pack[individual_file_download]" <?php checked(get_post_data($post,'individual_file_download', true),1);?> /><span></span> Allow Inidividual File Download</label>

                </div>

            </td>
        </tr>

        <tr id="templates_row">
            <td>Link Template:</td>
            <td><?php



                ?>
                <select name="pack[template]" id="lnk_tpl" onchange="jQuery('#lerr').remove();">
                    <?php
                    /*
                    $ctpls = scandir(WPDM_BASE_DIR.'/templates/');
                    array_shift($ctpls);
                    array_shift($ctpls);
                    $ptpls = $ctpls;
                    foreach($ctpls as $ctpl){
                        $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                        if(preg_match("/WPDM[\s]+Link[\s]+Template[\s]*:([^\-\->]+)/",$tmpdata, $matches)){

                            ?>
                            <option value="<?php echo $ctpl; ?>"  <?php selected(get_post_data($post,'template',true),$ctpl); ?>><?php echo $matches[1]; ?></option>
                        <?php
                        }
                    }
                    $templates = get_option("_fm_link_templates",true);
                    if($templates) $templates = maybe_unserialize($templates);
                    if(is_array($templates)){
                        foreach($templates as $id=>$template) {
                            ?>
                            <option value="<?php echo $id; ?>"  <?php selected(get_post_data($post,'page_template',true),$id); ?>><?php echo $template['title']; ?></option>
                        <?php } }  */ ?>
                </select>
            </td>
        </tr>


        <tr id="templates_row">
            <td>Page Template:</td>
            <td><?php

                //print_r(  unserialize(get_option("_fm_link_templates",true)) );
                ?>
                <select name="pack[page_template]" id="pge_tpl" onchange="jQuery('#perr').remove();">
                    <?php

    /*
                    foreach($ptpls as $ctpl){
                        $tmpdata = file_get_contents(WPDM_BASE_DIR.'/templates/'.$ctpl);
                        if(preg_match("/WPDM[\s]+Template[\s]*:([^\-\->]+)/",$tmpdata, $matches)){

                            ?>
                            <option value="<?php echo $ctpl; ?>"  <?php selected(get_post_data($post,'page_template',true),$ctpl); ?>><?php echo $matches[1]; ?></option>
                        <?php
                        }
                    }

                    $templates = get_option("_fm_page_templates",true);
                    if($templates) $templates = maybe_unserialize($templates);
                    if(is_array($templates)){
                        foreach($templates as $id=>$template) {
                            ?>
                            <option value="<?php echo $id; ?>"  <?php selected(get_post_data($post,'page_template',true),$id); ?>><?php echo $template['title']; ?></option>
                        <?php } }*/ ?>
                </select>
            </td>
        </tr --><?php /* if(isset($_GET['id'])&&$_GET['id']!=''){ ?>
            <tr>
                <td>Reset Key</td>
                <td><input type="checkbox" value="1" name="reset_key" /> Regenerate Master Key for Download <span class="info infoicon" title="This key can be used for direct download"> </span></td>
            </tr>
        <?php } */ ?>
    </table>
    <div class="clear"></div>
</div>

<?php //include("lock-options.php"); ?>
<?php //include("icons.php"); ?>
<?php foreach($etabs as $id=>$tab){
     echo "<div class='tab-pane' id='{$id}'>";
     call_user_func($tab['callback']);
     echo "</div>";
} ?>

</div>
</div>








<!-- all js  -->

<script type="text/javascript">
jQuery.noConflict();
    jQuery(document).ready(function() {

        // Uploading files
        var file_frame;




        jQuery('body').on('click', '#wpdm-featured-image', function( event ){

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if ( file_frame ) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery( this ).data( 'uploader_title' ),
                button: {
                    text: jQuery( this ).data( 'uploader_button_text' )
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                // We set multiple to false so only get one image from the uploader
                console.log(file_frame);
                attachment = file_frame.state().get('selection').first().toJSON();
                jQuery('#fpvw').val(attachment.url);
                jQuery('#rmvp').remove();
                jQuery('#img').html("<p><img src='"+attachment.url+"' style='max-width:100%'/><input type='hidden' name='pack[preview]' value='"+attachment.url+"' ></p>");
                jQuery('#img').after('<a href="#"  id="rmvp" class="text-danger">Remove Featured Image</a>');
                file_frame.close();
                // Do something with attachment.id and/or attachment.url here
            });

            // Finally, open the modal
            file_frame.open();
        });


        jQuery('body').on('click', ".cb-enable",function(){
            var parent = jQuery(this).parents('.switch');
            jQuery('.cb-disable',parent).removeClass('selected');
            jQuery(this).addClass('selected');
            jQuery('.checkbox',parent).attr('checked', true);
        });
        jQuery('body').on('click', ".cb-disable",function(){
            var parent = jQuery(this).parents('.switch');
            jQuery('.cb-enable',parent).removeClass('selected');
            jQuery(this).addClass('selected');
            jQuery('.checkbox',parent).attr('checked', false);
        });

        var n = 0;
        jQuery(".wpdmlock").each(function(i) {
            n++;
            jQuery(this).attr('id','wpdmlock-'+n).css('opacity',0).css('position','absolute').css('z-index',-100);
            if(jQuery(this).attr('checked'))
                jQuery(this).after('<label class="wpdm-label wpdm-checked" for="wpdmlock-'+n+'" ></label> ');
            else
                jQuery(this).after('<label class="wpdm-label wpdm-unchecked" for="wpdmlock-'+n+'" ></label> ');

        });

        jQuery('body').on('click', '#rmvp',function(){
            jQuery('#fpvw').val('');
            jQuery('#mpim').slideUp().remove();
            jQuery(this).fadeOut();
            jQuery('#img').html('<a href="#" id="wpdm-featured-image">Add Featured Image</a> <input type="hidden" name="pack[preview]" value="" id="fpvw" />');
            return false;
        });
        jQuery('body').on('click', '.wpdm-label',function(){
            //alert(jQuery(this).attr('class'));
            if(jQuery(this).hasClass('wpdm-checked')) jQuery(this).addClass('wpdm-unchecked').removeClass('wpdm-checked');
            else jQuery(this).addClass('wpdm-checked').removeClass('wpdm-unchecked');

        });


        jQuery(window).scroll(function(){
            if(jQuery(window).scrollTop()>100)
                jQuery('#action').addClass('action-float').removeClass('action');
            else
                jQuery('#action').removeClass('action-float').addClass('action');
        })

        //jQuery("#wpdm-settings select").chosen({no_results_text: ""});

        jQuery('.handlediv').click(function(){
            jQuery(this).parent().find('.inside').slideToggle();
        });

        jQuery('.handle').click(function(){
            alert(2);
            jQuery(this).parent().find('.inside').slideToggle();
        });


        jQuery('.nopro').click(function(){
            if(this.checked) jQuery('.wpdmlock').removeAttr('checked');
        });

        jQuery('.wpdmlock').click(function(){
            if(this.checked) {
                jQuery('#'+jQuery(this).attr('rel')).slideDown();
                jQuery('.nopro').removeAttr('checked');
            } else {
                jQuery('#'+jQuery(this).attr('rel')).slideUp();
            }
        });




    });


    function generatepass(id){
        tb_show('Generate Password',ajaxurl+'?action=wpdm_generate_password&w=300&h=500&id='+id);
    }

    function wpdm_view_package(){

    }




    <?php /* if(is_array($file)&&get_post_data($pack['id'],'lock',true)!='') { ?>
    jQuery('#<?php echo get_post_data($pack['id'],'lock',true); ?>').show();
    <?php } */ ?>
</script>

