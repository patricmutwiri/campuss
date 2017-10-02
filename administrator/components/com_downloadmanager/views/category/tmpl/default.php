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
$cid = isset($_GET['cid'])?(int)$_GET['cid']:0;
if($cid > 0)
{
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query
        ->select('*')
        ->from($db->quoteName('#__dm_categories'))
        ->where('cid = '.$cid);
    $db->setQuery($query);
    $category = $db->loadObject();
    $category->meta_data = unserialize($category->meta_data);
}

?>



<div class="wpdm-front w3eden"><br>
    <form id="wpdm-pf" action="index.php?option=com_downloadmanager&view=category&task=<?php echo $this->task; ?>" method="post">
        <div class="row">

            <div class="col-md-7">



                <input type="hidden" name="id" id="cid" value="<?php echo $jinput->get('cid', 'INT'); ?>" />
                <div class="form-group">
                    <label>Name</label>
                    <input id="title" class="form-control input-lg"  placeholder="Category Name" type="text" value="<?php echo isset($category->name)?$category->name:''; ?>" name="cat[name]" /><br/>
                </div>
                <div class="form-group">
                    <label>URL Key</label>
                    <input id="title" class="form-control input-lg"  placeholder="category-url-key" type="text" value="<?php echo isset($category->url_key)?$category->url_key:''; ?>" name="cat[url_key]" /><br/>
                </div>
                <div  class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" cols="7" name="cat[description]"><?php echo isset($category->description)?$category->description:''; ?></textarea>
                </div>



            </div>
            <div class="col-md-5">



                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>Meta Info</b></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Meta Title</label>
                            <input id="title" class="form-control"  placeholder="Enter title here" type="text" value="<?php echo isset($category->meta_data['title'])?$category->meta_data['title']:''; ?>" name="cat[meta_data][title]" /><br/>
                        </div>
                        <div  class="form-group">
                            <label>Meta Description</label>
                            <textarea class="form-control"  name="cat[meta_data][description]"><?php echo isset($category->meta_data['description'])?$category->meta_data['description']:''; ?></textarea>
                        </div>
                    </div>
                </div>















                <div class="panel panel-primary " id="form-action">
                    <div class="panel-heading">
                        <b>Actions</b>
                    </div>
                    <div class="panel-body">



                        <button type="submit" accesskey="p" tabindex="5" id="publish" class="btn btn-success btn-lg" name="publish"><i class="fa fa-save" id="psp"></i> &nbsp; <?php echo $this->task=='edit'?'Update Category':'Create Category'; ?></button>

                    </div>
                </div>

            </div>
        </div>

    </form>

</div>
