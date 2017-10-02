<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

global $dm_filter, $dm_actions, $merged_filters, $dm_current_filter;


if ( ! isset( $dm_filter ) )
    $dm_filter = array();

if ( ! isset( $dm_actions ) )
    $dm_actions = array();

if ( ! isset( $merged_filters ) )
    $merged_filters = array();

if ( ! isset( $dm_current_filter ) )
    $dm_current_filter = array();

function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
    global $dm_filter, $merged_filters;

    $idx = _dm_filter_build_unique_id($tag, $function_to_add, $priority);
    $dm_filter[$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
    unset( $merged_filters[ $tag ] );
    return true;
}

function has_filter($tag, $function_to_check = false) {
    // Don't reset the internal array pointer
    $dm_filter = $GLOBALS['dm_filter'];

    $has = ! empty( $dm_filter[ $tag ] );

    // Make sure at least one priority has a filter callback
    if ( $has ) {
        $exists = false;
        foreach ( $dm_filter[ $tag ] as $callbacks ) {
            if ( ! empty( $callbacks ) ) {
                $exists = true;
                break;
            }
        }

        if ( ! $exists ) {
            $has = false;
        }
    }

    if ( false === $function_to_check || false == $has )
        return $has;

    if ( !$idx = _dm_filter_build_unique_id($tag, $function_to_check, false) )
        return false;

    foreach ( (array) array_keys($dm_filter[$tag]) as $priority ) {
        if ( isset($dm_filter[$tag][$priority][$idx]) )
            return $priority;
    }

    return false;
}

function apply_filters( $tag, $value ) {
    global $dm_filter, $merged_filters, $dm_current_filter;

    $args = array();

    // Do 'all' actions first.
    if ( isset($dm_filter['all']) ) {
        $dm_current_filter[] = $tag;
        $args = func_get_args();
        _dm_call_all_hook($args);
    }

    if ( !isset($dm_filter[$tag]) ) {
        if ( isset($dm_filter['all']) )
            array_pop($dm_current_filter);
        return $value;
    }

    if ( !isset($dm_filter['all']) )
        $dm_current_filter[] = $tag;

    // Sort.
    if ( !isset( $merged_filters[ $tag ] ) ) {
        ksort($dm_filter[$tag]);
        $merged_filters[ $tag ] = true;
    }

    reset( $dm_filter[ $tag ] );

    if ( empty($args) )
        $args = func_get_args();

    do {
        foreach( (array) current($dm_filter[$tag]) as $the_ )
            if ( !is_null($the_['function']) ){
                $args[1] = $value;
                $value = call_user_func_array($the_['function'], array_slice($args, 1, (int) $the_['accepted_args']));
            }

    } while ( next($dm_filter[$tag]) !== false );

    array_pop( $dm_current_filter );

    return $value;
}

function apply_filters_ref_array($tag, $args) {
    global $dm_filter, $merged_filters, $dm_current_filter;

    // Do 'all' actions first
    if ( isset($dm_filter['all']) ) {
        $dm_current_filter[] = $tag;
        $all_args = func_get_args();
        _dm_call_all_hook($all_args);
    }

    if ( !isset($dm_filter[$tag]) ) {
        if ( isset($dm_filter['all']) )
            array_pop($dm_current_filter);
        return $args[0];
    }

    if ( !isset($dm_filter['all']) )
        $dm_current_filter[] = $tag;

    // Sort
    if ( !isset( $merged_filters[ $tag ] ) ) {
        ksort($dm_filter[$tag]);
        $merged_filters[ $tag ] = true;
    }

    reset( $dm_filter[ $tag ] );

    do {
        foreach( (array) current($dm_filter[$tag]) as $the_ )
            if ( !is_null($the_['function']) )
                $args[0] = call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

    } while ( next($dm_filter[$tag]) !== false );

    array_pop( $dm_current_filter );

    return $args[0];
}

function remove_filter( $tag, $function_to_remove, $priority = 10 ) {
    $function_to_remove = _dm_filter_build_unique_id( $tag, $function_to_remove, $priority );

    $r = isset( $GLOBALS['dm_filter'][ $tag ][ $priority ][ $function_to_remove ] );

    if ( true === $r ) {
        unset( $GLOBALS['dm_filter'][ $tag ][ $priority ][ $function_to_remove ] );
        if ( empty( $GLOBALS['dm_filter'][ $tag ][ $priority ] ) ) {
            unset( $GLOBALS['dm_filter'][ $tag ][ $priority ] );
        }
        if ( empty( $GLOBALS['dm_filter'][ $tag ] ) ) {
            $GLOBALS['dm_filter'][ $tag ] = array();
        }
        unset( $GLOBALS['merged_filters'][ $tag ] );
    }

    return $r;
}

function remove_all_filters( $tag, $priority = false ) {
    global $dm_filter, $merged_filters;

    if ( isset( $dm_filter[ $tag ]) ) {
        if ( false !== $priority && isset( $dm_filter[ $tag ][ $priority ] ) ) {
            $dm_filter[ $tag ][ $priority ] = array();
        } else {
            $dm_filter[ $tag ] = array();
        }
    }

    if ( isset( $merged_filters[ $tag ] ) ) {
        unset( $merged_filters[ $tag ] );
    }

    return true;
}

function current_filter() {
    global $dm_current_filter;
    return end( $dm_current_filter );
}

function current_action() {
    return current_filter();
}

function doing_filter( $filter = null ) {
    global $dm_current_filter;

    if ( null === $filter ) {
        return ! empty( $dm_current_filter );
    }

    return in_array( $filter, $dm_current_filter );
}

function doing_action( $action = null ) {
    return doing_filter( $action );
}

function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
    return add_filter($tag, $function_to_add, $priority, $accepted_args);
}

function do_action($tag, $arg = '') {
    global $dm_filter, $dm_actions, $merged_filters, $dm_current_filter;

    if ( ! isset($dm_actions[$tag]) )
        $dm_actions[$tag] = 1;
    else
        ++$dm_actions[$tag];

    // Do 'all' actions first
    if ( isset($dm_filter['all']) ) {
        $dm_current_filter[] = $tag;
        $all_args = func_get_args();
        _dm_call_all_hook($all_args);
    }

    if ( !isset($dm_filter[$tag]) ) {
        if ( isset($dm_filter['all']) )
            array_pop($dm_current_filter);
        return;
    }

    if ( !isset($dm_filter['all']) )
        $dm_current_filter[] = $tag;

    $args = array();
    if ( is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0]) ) // array(&$this)
        $args[] =& $arg[0];
    else
        $args[] = $arg;
    for ( $a = 2; $a < func_num_args(); $a++ )
        $args[] = func_get_arg($a);

    // Sort
    if ( !isset( $merged_filters[ $tag ] ) ) {
        ksort($dm_filter[$tag]);
        $merged_filters[ $tag ] = true;
    }

    reset( $dm_filter[ $tag ] );

    do {
        foreach ( (array) current($dm_filter[$tag]) as $the_ )
            if ( !is_null($the_['function']) )
                call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

    } while ( next($dm_filter[$tag]) !== false );

    array_pop($dm_current_filter);
}

function did_action($tag) {
    global $dm_actions;

    if ( ! isset( $dm_actions[ $tag ] ) )
        return 0;

    return $dm_actions[$tag];
}

function do_action_ref_array($tag, $args) {
    global $dm_filter, $dm_actions, $merged_filters, $dm_current_filter;

    if ( ! isset($dm_actions[$tag]) )
        $dm_actions[$tag] = 1;
    else
        ++$dm_actions[$tag];

    // Do 'all' actions first
    if ( isset($dm_filter['all']) ) {
        $dm_current_filter[] = $tag;
        $all_args = func_get_args();
        _dm_call_all_hook($all_args);
    }

    if ( !isset($dm_filter[$tag]) ) {
        if ( isset($dm_filter['all']) )
            array_pop($dm_current_filter);
        return;
    }

    if ( !isset($dm_filter['all']) )
        $dm_current_filter[] = $tag;

    // Sort
    if ( !isset( $merged_filters[ $tag ] ) ) {
        ksort($dm_filter[$tag]);
        $merged_filters[ $tag ] = true;
    }

    reset( $dm_filter[ $tag ] );

    do {
        foreach( (array) current($dm_filter[$tag]) as $the_ )
            if ( !is_null($the_['function']) )
                call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

    } while ( next($dm_filter[$tag]) !== false );

    array_pop($dm_current_filter);
}

function has_action($tag, $function_to_check = false) {
    return has_filter($tag, $function_to_check);
}

function remove_action( $tag, $function_to_remove, $priority = 10 ) {
    return remove_filter( $tag, $function_to_remove, $priority );
}

function remove_all_actions($tag, $priority = false) {
    return remove_all_filters($tag, $priority);
}



function _dm_call_all_hook($args) {
    global $dm_filter;

    reset( $dm_filter['all'] );
    do {
        foreach( (array) current($dm_filter['all']) as $the_ )
            if ( !is_null($the_['function']) )
                call_user_func_array($the_['function'], $args);

    } while ( next($dm_filter['all']) !== false );
}

function _dm_filter_build_unique_id($tag, $function, $priority) {
    global $dm_filter;
    static $filter_id_count = 0;

    if ( is_string($function) )
        return $function;

    if ( is_object($function) ) {
        // Closures are currently implemented as objects
        $function = array( $function, '' );
    } else {
        $function = (array) $function;
    }

    if (is_object($function[0]) ) {
        // Object Class Calling
        if ( function_exists('spl_object_hash') ) {
            return spl_object_hash($function[0]) . $function[1];
        } else {
            $obj_idx = get_class($function[0]).$function[1];
            if ( !isset($function[0]->dm_filter_id) ) {
                if ( false === $priority )
                    return false;
                $obj_idx .= isset($dm_filter[$tag][$priority]) ? count((array)$dm_filter[$tag][$priority]) : $filter_id_count;
                $function[0]->dm_filter_id = $filter_id_count;
                ++$filter_id_count;
            } else {
                $obj_idx .= $function[0]->dm_filter_id;
            }

            return $obj_idx;
        }
    } else if ( is_string($function[0]) ) {
        // Static Calling
        return $function[0] . '::' . $function[1];
    }
}

function get_post_data($post, $field){
    if(is_object($post) && isset($post->$field)) return $post->$field;
    else return false;
}

function checked( $checked, $current = true, $echo = true ) {
    return __checked_selected_helper( $checked, $current, $echo, 'checked' );
}

function selected( $selected, $current = true, $echo = true ) {
    return __checked_selected_helper( $selected, $current, $echo, 'selected' );
}

function disabled( $disabled, $current = true, $echo = true ) {
    return __checked_selected_helper( $disabled, $current, $echo, 'disabled' );
}

function __checked_selected_helper( $helper, $current, $echo, $type ) {
    if ( (string) $helper === (string) $current )
        $result = " $type='$type'";
    else
        $result = '';

    if ( $echo )
        echo $result;

    return $result;
}
