<?php
/*********************************************************************************
 * opensim.mysql.basicsearch.php v0.9 for OpenSim     by Fumi.Iseki  2016 8/11
 *
 *          Copyright (c) 2009,2010,2011,2013,2016   http://www.nsl.tuis.ac.jp/
 *
 *          supported versions of OpenSim are 0.7.x - 0.9.x
 *          tools.func.php is needed
 *          mysql.func.php is needed
 *
 *********************************************************************************/


/*********************************************************************************
 * Function List

 function  opensim_new_search_db($timeout=60)

 function  opensim_get_events_num($pg_only=false, $tm=0, &$db=null)
 function  opensim_get_events($start=0, $limit=25, $pg_only=false, $tm=0, &$db=null)
 function  opensim_get_event($id, &$db=null)

 function  opensim_set_event($event, $ovwrite=true, &$db=null)

 function  opensim_delete_event($id, &$db=null)

**********************************************************************************/


if (!defined('ENV_HELPER_PATH')) exit();


///////////////////////////////////////////////////////////////////////////////////////
//
// Search (Event) 
//

function  opensim_get_events_num($pg_only=false, $tm=0, &$db=null)
{
//  if (!is_object($db)) $db = opensim_new_db();

    return 0;
}


function  opensim_get_events($start=0, $limit=25, $pg_only=false, $tm=0, &$db=null)
{
//  if (!is_object($db)) $db = opensim_new_db();

    return null;
}


function  opensim_get_event($id, &$db=null)
{
//  if (!is_object($db)) $db = opensim_new_db();

    return null;
}


function  opensim_set_event($event, $ovwrite=true, &$db=null)
{
//  if (!is_object($db)) $db = opensim_new_db();

    return false;
}


function  opensim_delete_event($id, &$db=null)
{
//  if (!is_object($db)) $db = opensim_new_db();

    return;
}
