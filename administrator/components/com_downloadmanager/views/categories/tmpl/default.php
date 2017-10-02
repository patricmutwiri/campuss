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
$limit = 10;

$start = isset($paged) && $paged > 0?(($paged-1)*$limit):0;


$query = "";
$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query
    ->select('*')
    ->from($db->quoteName('#__dm_categories'))
    ->order('cid desc');
$db->setQuery($query);
$result = $db->loadObjectList();

?>

<div class="w3eden">



    <!--form method="post" action="" id="posts-filter" -->




        <div class="clear"></div>


        <table cellspacing="0" class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th align="center">Packages</th>
                <th style="width: 120px"  align="center">Actions</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>Title</th>
                <th align="center">Packages</th>
                <th style="width: 120px"  align="center">Actions</th>
            </tr>
            </tfoot>

            <tbody class="list:post" id="the-list">
            <?php foreach($result as $category) {

                ?>
                <tr valign="top"  id="post-<?php echo $category->cid; ?>">
                    <td class="media column-media">
                        <a title="Edit" class="post-title" href="index.php?option=com_downloadmanager&view=category&cid=<?php echo $category->cid; ?>"><?php echo $category->name; ?></a>
                    </td>
                    <td class="parent column-parent"><?php echo $category->package_count; ?></td>
                    <td class="actions"><a class="btn btn-primary btn-xs" href="index.php?option=com_downloadmanager&view=category&cid=<?php echo $category->cid; ?>"><i class="fa fa-pencil"></i></a> <a href="#" class="delp btn btn-danger btn-xs" onclick="return false;" data-toggle="popover" data-content="Are You Sure? &nbsp; <a style='margin:0 5px' href='#' class='canceldelete btn btn-default btn-xs pull-right'>No</a> <a href='#' class='submitdelete btn btn-danger btn-xs pull-right' rel='<?php echo $category->cid; ?>'>Yes</a>" title="Delete Category" ><i class="fa fa-trash-o"></i></a></td>

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
            jQuery.post('index.php?option=com_downloadmanager&view=category&task=delete&cid='+this.rel,function(){
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