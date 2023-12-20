<?php
/*********************************************************************************
 * opensim.mysql.ossearch.php v0.9 for OpenSim     by Fumi.Iseki  2016 7/26
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

//
// for DB
//
function  opensim_new_search_db($timeout=60)
{
    global $SRCH_DB_HOST, $SRCH_DB_NAME, $SRCH_DB_USER, $SRCH_DB_PASS, $SRCH_DB_MYSQLI;

    $db = new DB($SRCH_DB_HOST, $SRCH_DB_NAME, $SRCH_DB_USER, $SRCH_DB_PASS, $SRCH_DB_MYSQLI, $timeout);

    return $db;
}


///////////////////////////////////////////////////////
//

function  opensim_get_events_num($pg_only=false, $tm=0, &$db=null)
{
    if (!is_object($db)) $db = opensim_new_search_db();
 
    if ($tm==0) $tm = time() - 3600;    // - 1hour
    $select = "dateutc > '$tm'";
    if ($pg_only) $select .= " AND eventflags='0'";

    $db->query("SELECT COUNT(*) FROM ".SEARCH_EVENTS_TBL.' WHERE '.$select);
    list($events_num) = $db->next_record();

    return $events_num;
}


function  opensim_get_events($start=0, $limit=25, $pg_only=false, $tm=0, &$db=null)
{
    if (!is_object($db)) $db = opensim_new_search_db();

    $events = array();
    if ($tm==0) $tm = time() - 3600;    // - 1hour
    $select = "dateutc > '$tm'";
    if ($pg_only) $select .= " AND eventflags='0'";

    $sql_str = "SELECT * FROM ".SEARCH_EVENTS_TBL.' WHERE '.$select.' LIMIT '.$start.','.$limit;
    $db->query($sql_str);
    if ($db->Errno!=0) return null;

    $num = 0;
    while (list($owneruuid, $name, $eventid, $creatoruuid, $category, $description, $dateutc,
                    $duration, $covercharge, $coveramount, $simname, $globalpos, $eventflags) = $db->next_record()) {
        $events[$num]['OwnerUUID']   = $owneruuid;
        $events[$num]['Name']        = $name;
        $events[$num]['EventID']     = $eventid;        // Key
        $events[$num]['CreatorUUID'] = $creatoruuid;
        $events[$num]['Category']    = $category;
        $events[$num]['Description'] = $description;
        $events[$num]['DateUTC']     = $dateutc;
        $events[$num]['Duration']    = $duration;
        $events[$num]['CoverCharge'] = $covercharge;
        $events[$num]['CoverAmount'] = $coveramount;
        $events[$num]['SimName']     = $simname;
        $events[$num]['GlobalPos']   = $globalpos;
        $events[$num]['EventFlags']  = $eventflags;
        $num++;
    }

    return $events;
}


function  opensim_get_event($id, &$db=null)
{
    if (!is_object($db)) $db = opensim_new_search_db();

    $db->query("SELECT * FROM ".SEARCH_EVENTS_TBL." WHERE eventid='".$id."'");
    if ($db->Errno!=0) return null;

    list($owneruuid, $name, $eventid, $creatoruuid, $category, $description, $dateutc,
                    $duration, $covercharge, $coveramount, $simname, $globalpos, $eventflags) = $db->next_record();
    if ($eventid=='') return null;

    $event = array();
    $event['OwnerUUID']   = $owneruuid;
    $event['Name']        = $name;
    $event['EventID']     = $eventid;        // Key
    $event['CreatorUUID'] = $creatoruuid;
    $event['Category']    = $category;
    $event['Description'] = $description;
    $event['DateUTC']     = $dateutc;
    $event['Duration']    = $duration;
    $event['CoverCharge'] = $covercharge;
    $event['CoverAmount'] = $coveramount;
    $event['SimName']     = $simname;
    $event['GlobalPos']   = $globalpos;
    $event['EventFlags']  = $eventflags;

    return $event;
}


function  opensim_set_event($event, $ovwrite=true, &$db=null)
{
    if (!is_object($db)) $db = opensim_new_search_db();

    $insert = false;
    $obj = opensim_get_event($event['EventID'], $db);
    if ($obj==null) $insert = true;

    $srchobj = array();
    $srchobj['eventid'] = $event['EventID'];
    if (array_key_exists('OwnerUUID',   $event)) $srchobj['owneruuid']   = $event['OwnerUUID'];
    if (array_key_exists('Name',        $event)) $srchobj['name']        = $event['Name'];
    if (array_key_exists('CreatorUUID', $event)) $srchobj['creatoruuid'] = $event['CreatorUUID'];
    if (array_key_exists('Category',    $event)) $srchobj['category']    = $event['Category'];
    if (array_key_exists('Description', $event)) $srchobj['description'] = $event['Description'];
    if (array_key_exists('DateUTC',     $event)) $srchobj['dateutc']     = $event['DateUTC'];
    if (array_key_exists('Duration',    $event)) $srchobj['duration']    = $event['Duration'];
    if (array_key_exists('CoverCharge', $event)) $srchobj['covercharge'] = $event['CoverCharge'];
    if (array_key_exists('CoverAmount', $event)) $srchobj['coveramount'] = $event['CoverAmount'];
    if (array_key_exists('SimName',     $event)) $srchobj['simname']     = $event['SimName'];
    if (array_key_exists('GlobalPos',   $event)) $srchobj['globalpos']   = $event['GlobalPos'];
    if (array_key_exists('EventFlags',  $event)) $srchobj['eventflags']  = $event['EventFlags'];

    $rslt = false;
    if ($insert) {
        $rslt = $db->insert_record(SEARCH_EVENTS_TBL, $srchobj);
    }
    else if ($ovwrite) {
        $rslt = $db->update_record(SEARCH_EVENTS_TBL, $srchobj);
    }

    return $rslt;
}


function  opensim_delete_event($id, &$db=null)
{
    if (!is_object($db)) $db = opensim_new_search_db();

    $db->query('DELETE FROM '.SEARCH_EVENTS_TBL. " WHERE eventid='$id'");

    return;
}
