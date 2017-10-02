<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

$jinput = JFactory::getApplication()->input;
$id = isset($_GET['id'])?(int)$_GET['id']:0;
if( $id > 0 ) {
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query
        ->select('*')
        ->from($db->quoteName('#__dm_packages'))
        ->where('id = ' . $id);
    $db->setQuery($query);
    $post = $db->loadObject();

} else{
    $post = new stdClass();
}


?>


<style>
    .cat-panel ul,
    .cat-panel label,
    .cat-panel li{
        padding: 0;
        margin: 0;
    }
    .cat-panel li label{
        height: 25px;
    }
    .cat-panel ul{
        margin-left: 20px;
        list-style: none;
    }
    .cat-panel > ul{
        padding-top: 10px;
    }
</style>
<div class="wpdm-front w3eden"><br>
    <form id="wpdm-pf" action="index.php?option=com_downloadmanager&view=package&task=<?php echo $this->task; ?>" method="post">
        <div class="row">

            <div class="col-md-9">



                <input type="hidden" name="id" id="id" value="<?php echo $jinput->get('id', 'INT'); ?>" />
                <div class="form-group">
                    <input id="title" class="form-control input-lg"  placeholder="Enter title here" type="text" value="<?php echo isset($post->title)?$post->title:''; ?>" name="pack[title]" /><br/>
                </div>
                <div  class="form-group">
                    <textarea class="form-control" name="pack[description]"><?php echo isset($post->description)?$post->description:''; ?></textarea>
                </div>

                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>Attached Files</b></div>
                    <div class="panel-body">
                        <?php
                        require_once dirname(__FILE__)."/metaboxes/attached-files.php";
                        ?>
                    </div>
                </div>

                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>Package Settings</b></div>
                    <div class="panel-body">
                        <?php
                        require_once dirname(__FILE__)."/metaboxes/package-settings-front.php";
                        ?>
                    </div>
                </div>


            </div>
            <div class="col-md-3">

                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>SEF Settings</b></div>
                    <div class="panel-body">
                         URL Key:<br/>
                        <input type="text" id="urlkey" class="form-control input-block" placeholder="URL Key" name="pack[url_key]" value="<?php if(isset($post->url_key)) echo $post->url_key; ?>" />
                        Meta Title:<br/>
                        <input type="text" class="form-control input-block" placeholder="Meta Title ( 80 Chars Max )" name="pack[meta_title]" value="<?php if(isset($post->meta_title)) echo $post->meta_title; ?>" />
                        Meta Description:<br/>
                        <textarea class="form-control input-block" placeholder="Meta Description ( 160 Chars Max )" name="pack[meta_desc]"><?php if(isset($post->meta_title)) echo $post->meta_title; ?></textarea>

                    </div>
                </div>

                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>Attach Files</b></div>
                    <div class="panel-body">
                        <?php require_once dirname(__FILE__).'/metaboxes/attach-file.php'; ?>
                    </div>
                </div>

                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>Categories</b></div>
                    <div class="panel-body cat-panel">
                        <?php
                        $selected = isset($post->category)?$post->category:0;
                        dm_categories_checkboxes(array('name' => 'pack[category]', 'selected' => $selected, 'echo' => 1, 'parent' => 0));

                        ?>
                    </div>
                </div>

                <div class="panel panel-default" id="main-preview-image">
                    <div class="panel-heading"><b>Main Preview Image</b></div>
                    <div class="panel-body">
                        <input type="hidden" name="pack[preview]" value="<?php echo isset($post->preview)?$post->preview:''; ?>" id="fpvw" />
                        <div id="img"><?php
                                $thumbnail_url = isset($post->preview)?$post->preview:'';
                            if($thumbnail_url!=''):
                                ?>

                                <img src="<?php  echo $thumbnail_url; ?>" alt="preview" /><input type="hidden" name="pack[preview]" value="<?php  echo $thumbnail_url; ?>" id="fpvw" />
                                <a href="#"  id="rmvp" class="text-danger">Remove Featured Image</a>
                            <?php else: ?>

                            <?php endif; ?>
                        </div>
                        <?php DownloadManagerHelper::getModalButtonObject('preview','Preview Image', 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name=jform_articletext&amp;asset=com_content&amp;author='); ?>

                        <div id="ipreview">

                        </div>
                        <script>
                            function jInsertEditorText(data){
                                data = data.replace('src="','src="<?php echo JUri::root(); ?>')
                                jQuery('#ipreview').html(data+'<a href="#"  id="rmvp" class="text-danger">Remove Featured Image</a>');
                                jQuery('#fpvw').val(jQuery('#ipreview img').attr('src'));
                            }
                        </script>
                        <div class="clear"></div>
                    </div>
                </div>

                <!-- div class="panel panel-default">
                    <div class="panel-heading"><b>Additional Preview Images</b></div>
                    <div class="inside">

                        <?php //wpdm_additional_preview_images($post); ?>


                        <div class="clear"></div>
                    </div>
                </div -->














                <div class="panel panel-primary " id="form-action">
                    <div class="panel-heading">
                        <b>Actions</b>
                    </div>
                    <div class="panel-body">

                        <!--label class="eden-radio" style="margin-right: 20px"><input type="radio" <?php if(isset($post->post_status)) checked($post->post_status,'draft'); ?> value="draft" name="pack[status]"><span class="fa fa-check"></span> Save as Draft</label -->
                        <label class="eden-radio"><input type="radio" <?php if(isset($post->post_status)) checked($post->post_status,'publish'); ?> value="publish" checked="checked" name="pack[status]"><span class="fa fa-check"></span> Publish</label>
                        <br/><br/>


                        <button type="submit" accesskey="p" tabindex="5" id="publish" class="btn btn-success btn-block btn-lg" name="publish"><i class="fa fa-save" id="psp"></i> &nbsp; <?php echo $this->task=='update'?'Update Package':'Create Package'; ?></button>

                    </div>
                </div>

            </div>
        </div>

    </form>

</div>

<script>
    jQuery(function($){
        $('#title').on('blur', function(){
            if($('#urlkey').val()=='')
            $('#urlkey').val($(this).val().replace(/[^a-zA-Z0-9_]+/ig,'-').toLowerCase());
        });

        $('#urlkey').on('blur', function(){
            $(this).val($(this).val().replace(/[^a-zA-Z0-9_]+/ig,'-').toLowerCase());
        });
    });
</script>

