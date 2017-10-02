<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

if (!is_array($files)) $files = array();


?>
<div id="ftabs">
<!-- ul class="nav nav-tabs">
    <li class="active"><a href="#upload">Upload</a></li>

    <li><a href="#browse">Browse</a></li>

    <li><a href="#remote">URL</a></li>
</ul -->
<!-- div class="tab-content" -->
<div class="tab-pane active" id="upload">

    <?php DownloadManagerHelper::FileInput(); ?>

    <div class="clear"></div>
</div>

<!-- div class="tab-pane" id="browse">
    <?php //if(current_user_can('access_server_browser')) wpdm_file_browser(); ?>
</div>
<div class="tab-pane" id="remote">
<input type="url" id="rurl" style="width: 170px;border-radius: 3px;height: 29px" placeholder="Insert URL"> <button type="button" style="padding: 3px 6px 0px 6px;margin-top:1px" id="rmta" class="button"><img src="<?php echo WPDM_BASE_URL.'images/plus.png'; ?>"/></button>
</div>
</div -->
</div>

<script type="text/html" id="wpdm-file-entry">
    <div class="cfile">
        <input class="faz" type="hidden" value="##filepath##" name="pack[files][file_##fileindex##][path]">
        <div class="panel panel-default">
            <div class="panel-heading"><button type="button" class="btn btn-xs btn-default pull-right" rel="del"><i class="fa fa-times text-danger"></i></button> <span title="##filepath##">##filepath##</span></div>
            <div class="panel-body">
                <div class="media">
                    <div class="pull-left">

                        <img class="file-ico"  onerror="this.src='<?php echo JUri::root().'components/com_downloadmanager/assets/file-type-icons/_blank.png';?>';" src="##preview##" />
                    </div>
                    <div class="media-body">
                        <input placeholder="File Title" title="File Title" class="form-control" type="text" name='pack[files][file_##fileindex##][title]' value="##filepath##" /><br/>
                        <div class="input-group">
                            <input placeholder="File Password"  title="File Password" class="form-control inline" type="text" id="indpass_##fileindex##" name='pack[files][file_##fileindex##][password]' value="">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" class="genpass" title='Generate Password' onclick="return generatepass('indpass_##fileindex##')"><i class="fa fa-ellipsis-h"></i></button>
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script>
jQuery(function(){

        jQuery('#rmta').click(function(){
        var ID = 'file_' + parseInt(Math.random()*1000000);
        var file = jQuery('#rurl').val();
        var filename = file;
            jQuery('#rurl').val('');
            if(/^(ftp:\/\/|http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(file)==false){
                alert("Invalid url");
            return false;
            }

            var html = jQuery('#wpdm-file-entry').html();
            var ext = file.split('.');
            ext = ext[ext.length-1];
            if(ext.indexOf('://')) ext = 'url';
            else
            if(ext.length==1 || ext==filename || ext.length>4 || ext=='') ext = '_blank';

            var icon = "<?php echo JUri::base('components/assets/file-type-icons/');?>"+ext.toLowerCase()+".png";
            html = html.replace(/##filepath##/g, file);
            html = html.replace(/##fileindex##/g, ID);
            html = html.replace(/##preview##/g, icon);
            jQuery('#currentfiles').prepend(html);


    });

});

</script>

<?php

do_action("wpdm_attach_file_metabox");