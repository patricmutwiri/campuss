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
$id = $jinput->get('id');
if( $id > 0 )
{
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query
        ->select('*')
        ->from($db->quoteName('#__dm_packages'))
        ->where('id = '.$id);
    $db->setQuery($query);
    $post = $db->loadObject();

    if(!$post->package_size){
        $package = new stdClass();

        $package->id = (int)$id;
        $post->package_size = $package->package_size = dm_package_size($post->files);
        JFactory::getDbo()->updateObject('#__dm_packages', $package, 'id');
    }

}


?>


<div class="wpdm-front w3eden">

    <h1><?php echo $post->title; ?></h1>
    <div class="row">
    <?php if($post->preview!=''){ ?>
    <div class="col-md-7">
        <img src="<?php echo $post->preview; ?>" class="img-rounded" alt="<?php echo $post->title; ?>" />
    </div>
    <?php } ?>
    <div class="col-md-<?php echo ($post->preview!='')?5:12; ?>">
        <p><em><?php echo $post->excerpt; ?></em></p>
        <ul class="list-group" style="margin-bottom: 10px">

                <li class="list-group-item">Total Downloads<span class="label label-primary pull-right"><?php echo $post->download_count; ?></span></li>
                <li class="list-group-item">File Size<span class="label label-primary pull-right"><?php echo $post->package_size; ?></span></li>
                <li class="list-group-item">Create Date<span class="label label-primary pull-right"><?php echo date("M d, Y",$post->create_date); ?></span></li>
                <li class="list-group-item">Update Date<span class="label label-primary pull-right"><?php echo date("M d, Y",$post->update_date); ?></span></li>
        </ul>
        <form id="dlform" method="post" action="<?php echo JUri::root(); ?>index.php?option=com_downloadmanager&view=package&task=download&id=<?php echo $post->id ?>">
            <?php if($post->password != ''){ ?>
            <input type="password" id="password" name="password" class="form-control" style="width: 109px;display: inline-block;margin: 0">
            <?php } ?>
            <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> <?php echo $post->link_label?$post->link_label:'Download'; ?></button>
        </form>
    </div>
        <div class="col-md-12"><br/>
            <p><?php echo $post->description;  ?></p>
        </div>
    </div>

</div>

<script>
    jQuery(function($){
        $('#dlform').submit(function(){
            $.post($(this).attr('action'),{password: $('#password').val()}, function(response, status, xhr){

                if(response.search('://')!=-1){
                    location.href = response;
                } else
                alert(response);

            });
            return false;
        });
    })
</script>


