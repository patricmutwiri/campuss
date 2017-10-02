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


$query = "";
$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query
    ->select('*')
    ->from($db->quoteName('#__dm_packages'))
    ->order('create_date desc');
$db->setQuery($query);
$result = $db->loadObjectList();

?>

<div class="w3eden">



    <!--form method="post" action="" id="posts-filter" -->




        <div class="clear"></div>


        <table cellspacing="0" class="table table-hover table-striped">
            <thead>
            <tr>

                <th style="" class="manage-column column-media sortable <?php echo $jinput->get('sorder')=='asc'?'asc':'desc'; ?>" id="media" scope="col"><a href='<?php echo  $burl.$sap;?>sfield=title&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Package Title</span> <?php if($jinput->get('sfield')=='title') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <!--    <th style="" class="manage-column column-media" id="media" scope="col">Embed Code</th>    -->
                <th width="120" style="" class="manage-column column-parent sortable <?php echo $jinput->get('sorder')=='asc'?'asc':'desc'; ?>" id="parent" scope="col"><a href='<?php echo  $burl.$sap;?>sfield=download_count&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Downloads</span><?php if($jinput->get('sfield')=='download_count') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <th style="" class="manage-column column-media" id="media" scope="col" align="center"><a href='<?php echo  $burl.$sap;?>sfield=publish_date&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Publish Date</span> <?php if($jinput->get('sfield')=='publish_date') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <th style="" class="manage-column column-media" id="media" scope="col" align="center">Status</th>
                <th style="width: 120px" class="manage-column column-media" id="media" scope="col" align="center">Actions</th>
            </tr>
            </thead>

            <tfoot>
            <tr>

                <th style="" class="manage-column column-media sortable <?php echo $jinput->get('sorder')=='asc'?'asc':'desc'; ?>" id="media" scope="col"><a href='<?php echo  $burl.$sap;?>sfield=title&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Package Title</span> <?php if($jinput->get('sfield')=='title') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <!--    <th style="" class="manage-column column-media" id="media" scope="col">Embed Code</th>    -->
                <th style="" class="manage-column column-parent sortable <?php echo $jinput->get('sorder')=='asc'?'asc':'desc'; ?>" id="parent" scope="col"><a href='<?php echo  $burl.$sap;?>sfield=download_count&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Downloads</span><?php if($jinput->get('sfield')=='download_count') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <th style="" class="manage-column column-media" id="media" scope="col" align="center"><a href='<?php echo  $burl.$sap;?>sfield=publish_date&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Publish Date</span> <?php if($jinput->get('sfield')=='publish_date') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <th style="" class="manage-column column-media" id="media" scope="col" align="center">Status</th>
                <th style="" class="manage-column column-media" id="media" scope="col" align="center">Actions</th>
            </tr>
            </tfoot>

            <tbody class="list:post" id="the-list">
            <?php foreach($result as $post) {

                ?>
                <tr valign="top" class="alternate author-self status-inherit" id="post-<?php echo $post->id; ?>">



                    <td class="media column-media">
                        <a title="Edit" class="post-title" href="index.php?option=com_downloadmanager&view=package&id=<?php echo $post->id; ?>"><?php echo $post->title; ?></a>
                    </td>
                    <!--                <td><input class="form-control input-xs" type="text" onclick="this.select()" size="20" title="Simply Copy and Paste in post contents" value="[wpdm_package id=--><?php //the_ID();?><!--]" /></td>-->
                    <td class="parent column-parent"><?php echo $post->download_count; ?></td>
                    <td class="parent column-parent <?php echo $post->status=='publish'?'text-success':'text-danger';?>"><?php echo $post->status=='publish'?date('Y-m-d', $post->create_date):'Not Yet';?></td>
                    <td class="parent column-parent <?php echo $post->status=='publish'?'text-success':'text-danger';?>"><?php echo $post->status?ucfirst($post->status):'Draft';?></td>
                    <td class="actions"><a class="btn btn-primary btn-xs" href="<?php echo $burl.$sap; ?>task=edit-package&id=<?php echo $post->id; ?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-xs btn-success" target="_blank" href='#'><i class="fa fa-eye"></i></a> <a href="#" class="delp btn btn-danger btn-xs" onclick="return false;" data-toggle="popover" data-content="Are You Sure? <a style='margin:0 5px' href='#' class='canceldelete btn btn-default btn-xs pull-right'>No</a> <a href='#' class='submitdelete btn btn-danger btn-xs pull-right' rel='<?php echo $post->id; ?>'>Yes</a>" title="Delete Package" ><i class="fa fa-trash-o"></i></a></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>

        <?php

        ?>

        <div id="ajax-response"></div>


    <!--/form-->
    <br class="clear">

</div>

<script language="JavaScript">
    <!--
    jQuery(function(){
        jQuery('body').on('click', '.submitdelete' ,function(){
            var id = '#post-'+this.rel;
            jQuery('#li-'+this.rel).html("<a href='#'><i class='fa fa-time'></i> Deleting...</a>");
            jQuery.post('index.php?option=com_downloadmanager&view=package&task=delete&id='+this.rel,function(){
                jQuery(id).fadeOut();
            }) ;
            return false;
        });
        jQuery('.delp').popover({placement:'left', html:true});

        jQuery('body').on('click', '.canceldelete',function(){
            jQuery('.delp').popover('hide');
            return false;
        });

    });
    //-->
</script>