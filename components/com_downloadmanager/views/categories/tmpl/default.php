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
    ->from($db->quoteName('#__dm_categories'))
    ->order('cid desc');
$db->setQuery($query);
$result = $db->loadObjectList();


?>

<div class="w3eden">

    <div class="clear"></div>

    <div class="row wpdm-categories">

        <?php foreach ($result as $category) {


            $query = $db->getQuery(true);
            $query
                ->select('count(*) as package_count')
                ->from($db->quoteName('#__dm_packages'))
                ->where('category = '.$category->cid);
            $db->setQuery($query);
            $count = $db->loadObject();

            ?>
            <div class="col-md-4" id="post-<?php echo $category->cid; ?>">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><a href="<?php echo JRoute::_(array('option' => 'com_downloadmanager', 'view' => 'category', 'id' => $category->cid)); ?>"><?php echo $category->name; ?></a></h3>
                        <?php echo $category->description; ?>
                    </div>
                    <div class="panel-footer">
                        <?php echo $count->package_count; ?> Packages
                    </div>
                </div>

            </div>
        <?php } ?>

    </div>


</div>
