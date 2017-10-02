<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

define('JPATH_DM_MEDIA', JPATH_SITE.'/media/com_downloadmanager/');
define('JURL_DM_MEDIA', JUri::root().'/media/com_downloadmanager/');
define('JPATH_DM_CACHE', JPATH_SITE.'/media/com_downloadmanager/cache/');
define('JPATH_DM_UPLOAD', JPATH_SITE.'/media/com_downloadmanager/protected/');
define('JPATH_DM_COM', JPATH_SITE.'/components/com_downloadmanager/');
define('JPATH_DM_COM_ADMIN', JPATH_SITE.'/administrator/components/com_downloadmanager/');
define('JURL_DM_COM', JUri::root().'/com_downloadmanager/');
define('JURL_DM_COM_ADMIN', JUri::root().'/administrator/com_downloadmanager/');
define('JURL_DM_CACHE', JUri::root().'/media/com_downloadmanager/cache/');

include_once dirname(__FILE__).'/error.php';
include_once dirname(__FILE__).'/hooks.php';
include_once dirname(__FILE__).'/misc.php';
include_once dirname(__FILE__).'/formatting.php';
include_once dirname(__FILE__).'/media.php';





/**
 * @usage Generate thumbnail dynamically
 * @param $path
 * @param $size
 * @return mixed
 */

function dm_dynamic_thumb($path, $size)
{
    //$path = str_replace(JURL_DM_MEDIA, JPATH_DM_MEDIA, $path);
    $path = str_replace(JUri::root(), JPATH_SITE.'/', $path);
    //$thumbpath = str_replace(JPATH_DM_MEDIA, JPATH_DM_CACHE, $path);
    $thumbpath = JPATH_DM_CACHE . basename($path);
    if (!file_exists($path)) return;
    $name_p = explode(".", $path);
    $ext = "." . end($name_p);
    $thumbpath = str_replace($ext, "-" . implode("x", $size) . $ext, $thumbpath);
    $thumbpath = str_replace('protected/','', $thumbpath);
    if (file_exists($thumbpath)) {
        $thumbpath = str_replace(JPATH_DM_CACHE, JURL_DM_CACHE, $thumbpath);
        return $thumbpath;
    }
    $image = wp_get_image_editor($path);

    if (!is_wp_error($image)) {
        $image->resize($size[0], $size[1], true);
        $image->save($thumbpath);
    }
    $thumbpath = str_replace(JPATH_DM_CACHE, JURL_DM_CACHE, $thumbpath);
    return $thumbpath;
}


/**
 * Download contents as a file
 * @param $filename
 * @param $content
 */
function dm_download_data($filename, $content)
{
    @ob_end_clean();
    header("Content-Description: File Transfer");
    header("Content-Type: text/plain");
    header("Content-disposition: attachment;filename=\"$filename\"");
    header("Content-Transfer-Encoding: text/plain");
    header("Content-Length: " . strlen($content));
    echo $content;
}


/**
 * Cache remote file to local directory and return local file path
 * @param mixed $url
 * @param mixed $filename
 * @return string $path
 */
function dm_cache_remote_file($url, $filename = '')
{
    $filename = $filename ? $filename : end($tmp = explode('/', $url));
    $path = WPDM_CACHE_DIR . $filename;
    $fp = fopen($path, 'w');
    if(!function_exists('curl_init')) WPDM_Messages::Error('<b>cURL</b> is not active or installed or not functioning properly in your server',1);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    $data = curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    return $path;
}

function dm_package_size($files){
    $files = maybe_unserialize($files);
    $size = 0;
    foreach($files as $file){
        $size += filesize(JPATH_DM_UPLOAD.$file['path']);
    }
    if($size > 1024){
        $size = $size / 1024;
        $unit = ' KB';
    }
    if($size > 1024){
        $size = $size / 1024;
        $unit = ' MB';
    }
    return number_format($size,2).$unit;
}

/**
 * @usage Download Given File
 * @param $filepath
 * @param $filename
 * @param int $speed
 * @param int $resume_support
 * @param array $extras
 */

function dm_download_file($filepath, $filename, $speed = 0, $resume_support = 1, $extras = array())
{

    if (isset($extras['package']))
        $package = $extras['package'];
    $mdata = wp_check_filetype($filename);

    $content_type = $mdata['type'];

    $buffer = $speed ? $speed : 1024;

    $buffer *= 1024; // in byte

    $bandwidth = 0;

    if( function_exists('ini_set') )
        @ini_set( 'display_errors', 0 );

    @session_write_close();

    if( function_exists('ini_set') )
        @ini_set('zlib.output_compression', 'Off');


    @set_time_limit(0);
    @session_cache_limiter('none');

    //if ( get_option( '__wpdm_support_output_buffer', 1 ) == 1 ) {
        $pcl = ob_get_level();
        do {
            @ob_end_clean();
            if(ob_get_level() == $pcl) break;
            $pcl = ob_get_level();
        } while ( ob_get_level() > 0 );
    //}

    if (strpos($filepath, '://'))
        $filepath = dm_cache_remote_file($filepath, $filename);

    if (file_exists($filepath))
        $fsize = filesize($filepath);
    else
        $fsize = 0;

    nocache_headers();
    header( "X-Robots-Tag: noindex, nofollow", true );
    header("Robots: none");
    header ('Content-Description: File Transfer') ;
    header("Content-type: $content_type");
    header("Content-disposition: attachment;filename=\"{$filename}\"");
    header("Content-Transfer-Encoding: binary");

    //if( ( isset($_REQUEST['play']) && strpos($_SERVER['HTTP_USER_AGENT'],"Safari") ) || get_option('__wpdm_download_resume',1)==2 ) {
        readfile($filepath);
        die();
   // }

    $file = @fopen($filepath, "rb");

    //check if http_range is sent by browser (or download manager)
    if (isset($_SERVER['HTTP_RANGE']) && $fsize > 0) {
        list($bytes, $http_range) = explode("=", $_SERVER['HTTP_RANGE']);
        $set_pointer = intval(array_shift($tmp = explode('-', $http_range)));

        $new_length = $fsize - $set_pointer;

        header("Accept-Ranges: bytes");
        header("HTTP/1.1 206 Partial Content");

        header("Content-Length: $new_length");
        header("Content-Range: bytes $http_range$fsize/$fsize");

        fseek($file, $set_pointer);

    } else {
        header("Content-Length: " . $fsize);
    }
    $packet = 1;

    if ($file) {
        while (!(connection_aborted() || connection_status() == 1) && $fsize > 0) {
            if ($fsize > $buffer)
                echo fread($file, $buffer);
            else
                echo fread($file, $fsize);
            ob_flush();
            flush();
            $fsize -= $buffer;
            $bandwidth += $buffer;
            if ($speed > 0 && ($bandwidth > $speed * $packet * 1024)) {
                sleep(1);
                $packet++;
            }


        }
        $package['downloaded_file_size'] = $fsize;
        //add_action('wpdm_download_completed', $package);
        @fclose($file);
    }

    die();

}



function dm_download_now(){

    $jinput = JFactory::getApplication()->input;
    $id = $jinput->get('id');
    $user = JFactory::getUser();
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
        if(      ( ( $post->password !='' && $jinput->get('password') == $post->password ) || $post->password == '' )
            &&
            ( ( isset( $user->id ) && $user->id > 0 && in_array('members', unserialize($post->access)) ) || in_array('guest', unserialize($post->access)) )
        ){

            $post->files = unserialize($post->files);
            print_r($post->files); die();
            //dm_download_file();

        }

    }
}


function dm_set_option($opt, $val){
    ob_clean();
    $user = JFactory::getUser();
    if(!$user->authorise('core.admin')) die('Authorization Failed!');

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $conditions = array(
        $db->quoteName('name') . " = '$opt'"
    );
    $query->delete($db->quoteName('#__dm_settings'));
    $query->where($conditions);
    $db->setQuery($query);
    $db->execute();

    $set = new stdClass();
    $set->name = $opt;
    $set->value = $val;
    JFactory::getDbo()->insertObject('#__dm_settings', $set);

}

function dm_get_option($opt, $default = null){
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query
        ->select('*')
        ->from($db->quoteName('#__dm_settings'))
        ->where("`name` = '$opt'");
    $db->setQuery($query);
    $set = $db->loadObject();
    return !isset($set->value) || $set->value == '' ? $default : $set->value;
}