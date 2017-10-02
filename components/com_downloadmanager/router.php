<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

require_once  dirname(__FILE__) . '/helpers/functions.php';

/**
 * Routing class from com_downloadmanager
 *
 * @since  3.3
 */
class DownloadManagerRouter extends JComponentRouterBase
{
    /**
     * Build the route for the com_content component
     *
     * @param   array  &$query  An array of URL arguments
     *
     * @return  array  The URL arguments to use to assemble the subsequent URL.
     *
     * @since   3.3
     */
    public function build(&$query)
    {
        $segments = array();

        // Get a menu item based on Itemid or currently active
        $params = JComponentHelper::getParams('com_downloadmanager');

        $advanced = $params->get('sef_advanced_link', 0);

        //if(isset($_REQUEST['task'])) return $params;

        // We need a menu item.  Either the one specified in the query, or the current active one if none specified
        if (empty($query['Itemid']))
        {
            $menuItem = $this->menu->getActive();
            $menuItemGiven = false;
        }
        else
        {
            $menuItem = $this->menu->getItem($query['Itemid']);
            $menuItemGiven = true;
        }

        // Check again
        if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_downloadmanager')
        {
            $menuItemGiven = false;
            unset($query['Itemid']);
        }

        if (isset($query['view']))
        {
            $view = $query['view'];
        }
        else
        {
            // We need to have a view in the query or it is an invalid URL
            return $segments;
        }

        // Are we dealing with an article or category that is attached to a menu item?
        if (($menuItem instanceof stdClass)
            && $menuItem->query['view'] == $query['view']
            && isset($query['id'])
            && $menuItem->query['id'] == (int) $query['id'])
        {
            unset($query['view']);

            if (isset($query['catid']))
            {
                unset($query['catid']);
            }

            if (isset($query['layout']))
            {
                unset($query['layout']);
            }

            unset($query['id']);

            return $segments;
        }

        if ($view == 'category' || $view == 'categories' || $view == 'package')
        {
            if (!$menuItemGiven)
            {
                $segments[] = $view;
            }

            unset($query['view']);
            if ($view == 'category'){

                $db = JFactory::getDbo();
                $dbQuery = $db->getQuery(true)
                    ->select('url_key')
                    ->from('#__dm_categories')
                    ->where('cid=' . (int) $query['id']);
                $db->setQuery($dbQuery);
                $alias = $db->loadResult();
                $id = $query['id'];
                unset($query['id']);
                return array(dm_get_option('curl_base','file-category'), $id."-".$alias);
            }
            else if ($view == 'package')
            {


                    // We should have these two set for this view.  If we don't, it is an error
                    $db = JFactory::getDbo();
                    $dbQuery = $db->getQuery(true)
                        ->select('url_key')
                        ->from('#__dm_packages')
                        ->where('id=' . (int) $query['id']);
                    $db->setQuery($dbQuery);
                    $alias = $db->loadResult();
                    $id = $query['id'];
                    unset($query['id']);

                    return array(dm_get_option('furl_base','download'), $id."-".$alias);
                    //return $segments;


            }
            else
            {
                if (isset($query['id']))
                {
                    $catid = $query['id'];
                }
                else
                {
                    // We should have id set for this view.  If we don't, it is an error

                    return $segments;
                }
            }

            if ($menuItemGiven && isset($menuItem->query['id']))
            {
                $mCatid = $menuItem->query['id'];
            }
            else
            {
                $mCatid = 0;
            }

            $catid = 0;
            $categories = JCategories::getInstance('DownloadManager');
            $category = $categories->get($catid);

            if (!$category)
            {
                // We couldn't find the category we were given.  Bail.
                return $segments;
            }

            $path = array_reverse($category->getPath());

            $array = array();

            foreach ($path as $id)
            {
                if ((int) $id == (int) $mCatid)
                {
                    break;
                }

                list($tmp, $id) = explode(':', $id, 2);

                $array[] = $id;
            }

            $array = array_reverse($array);

            if (!$advanced && count($array))
            {
                $array[0] = (int) $catid . ':' . $array[0];
            }

            $segments = array_merge($segments, $array);

            if ($view == 'article')
            {
                if ($advanced)
                {
                    list($tmp, $id) = explode(':', $query['id'], 2);
                }
                else
                {
                    $id = $query['id'];
                }

                $segments[] = $id;
            }

            unset($query['id']);
            unset($query['catid']);
        }




        $total = count($segments);

        for ($i = 0; $i < $total; $i++)
        {
            $segments[$i] = str_replace(':', '-', $segments[$i]);
        }

        return $segments;
    }

    /**
     * Parse the segments of a URL.
     *
     * @param   array  &$segments  The segments of the URL to parse.
     *
     * @return  array  The URL attributes to be used by the application.
     *
     * @since   3.3
     */
    public function parse(&$segments)
    {
        $total = count($segments);
        $vars = array();


        for ($i = 0; $i < $total; $i++)
        {
            $segments[$i] = preg_replace('/-/', ':', $segments[$i], 1);
        }


        // Get the active menu item.
        $item = $this->menu->getActive();
        $params = JComponentHelper::getParams('com_downloadmanager');
        $advanced = $params->get('sef_advanced_link', 0);
        $db = JFactory::getDbo();

        // Count route segments
        $count = count($segments);


        /*
         * Standard routing for articles.  If we don't pick up an Itemid then we get the view from the segments
         * the first segment is the view and the last segment is the id of the article or category.
         */



        if(str_replace(":","-",$segments[0])== dm_get_option('curl_base', 'file-category')){
            $vars['view'] = 'category';
            $sg = explode(":", $segments[1]);
            $vars['id'] = $sg[0];
            return $vars;
        }

        if($segments[0]== dm_get_option('furl_base', 'download')){
            $vars['view'] = 'package';
            $sg = explode(":", $segments[1]);
            $vars['id'] = $sg[0];
            return $vars;
        }

        if (!isset($item))
        {
            $vars['view'] = $segments[0];
            $vars['id'] = $segments[$count - 1];

            return $vars;
        }




//        if (!$advanced)
//        {
//            $cat_id = (int) $segments[0];
//
//            $article_id = (int) $segments[$count - 1];
//
//            if ($article_id > 0)
//            {
//                $vars['view'] = 'article';
//                $vars['catid'] = $cat_id;
//                $vars['id'] = $article_id;
//            }
//            else
//            {
//                $vars['view'] = 'category';
//                $vars['id'] = $cat_id;
//            }
//
//            return $vars;
//        }

        // We get the category id from the menu item and search from there
        $id = $item->query['id'];
        $category = JCategories::getInstance('DownloadManager')->get($id);

        if (!$category)
        {
            JError::raiseError(404, JText::_('COM_CONTENT_ERROR_PARENT_CATEGORY_NOT_FOUND'));

            return $vars;
        }

        $categories = $category->getChildren();
        $vars['catid'] = $id;
        $vars['id'] = $id;
        $found = 0;

        foreach ($segments as $segment)
        {
            $segment = str_replace(':', '-', $segment);

            foreach ($categories as $category)
            {
                if ($category->alias == $segment)
                {
                    $vars['id'] = $category->id;
                    $vars['catid'] = $category->id;
                    $vars['view'] = 'category';
                    $categories = $category->getChildren();
                    $found = 1;
                    break;
                }
            }

            if ($found == 0)
            {
                if ($advanced)
                {
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true)
                        ->select($db->quoteName('id'))
                        ->from('#__content')
                        ->where($db->quoteName('catid') . ' = ' . (int) $vars['catid'])
                        ->where($db->quoteName('alias') . ' = ' . $db->quote($segment));
                    $db->setQuery($query);
                    $cid = $db->loadResult();
                }
                else
                {
                    $cid = $segment;
                }

                $vars['id'] = $cid;

                if ($item->query['view'] == 'category' && $count != 1)
                {
                    $vars['year'] = $count >= 2 ? $segments[$count - 2] : null;
                    $vars['month'] = $segments[$count - 1];
                    $vars['view'] = 'category';
                }
                else
                {
                    $vars['view'] = 'package';
                }
            }

            $found = 0;
        }

        return $vars;
    }
}

/**
 * Content router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function DownloadManagerBuildRoute(&$query)
{

    $router = new DownloadManagerRouter;

    return $router->build($query);
}

/**
 * Parse the segments of a URL.
 *
 * This function is a proxy for the new router interface
 * for old SEF extensions.
 *
 * @param   array  $segments  The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 *
 * @since   3.3
 * @deprecated  4.0  Use Class based routers instead
 */
function DownloadManagerParseRoute($segments)
{
    $router = new DownloadManagerRouter;
    return $router->parse($segments);
}


