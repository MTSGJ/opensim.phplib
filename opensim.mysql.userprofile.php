<?php
/*********************************************************************************
 * opensim.mysql.userprofile.php v0.9 for OpenSim     by Fumi.Iseki  2016 7/26
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

 function  opensim_get_profile($uuid, &$db=null)
 function  opensim_get_prof_setting($uuid, &$db=null)
 function  opensim_get_prof_classified($uuid, &$db=null)
 function  opensim_get_prof_note($uuid, &$db=null)
 function  opensim_get_prof_pick($uuid, &$db=null)
 
 function  opensim_set_profiles($profs, $ovwrite=true, &$db=null)
 
 function  opensim_delete_profiles($uuid, &$db=null)

**********************************************************************************/


if (!defined('ENV_HELPER_PATH')) exit();



///////////////////////////////////////////////////////////////////////////////////////
//
// Profile
//

function  opensim_get_profile($uuid, &$db=null)
{
    if (!isGUID($uuid)) return null;
    if (!is_object($db)) $db = opensim_new_db();
    $prof = null;

    $db->query('SELECT * FROM '.PROFILE_USERPROFILE_TBL." WHERE useruuid='$uuid'");

    if ($db->Errno==0) {
        $prof = array();
        list($useruuid, $partner, $allowpublish, $maturepublish, $url, $wanttomask, $wanttotext, 
                        $skillsmask, $skillstext, $languagestext, $image, $abouttext, $firstimage, $firsttext) = $db->next_record();

        $prof['UUID']           = $useruuid;
        $prof['Partnar']        = $partner;
        $prof['AllowPublish']   = $allowpublish;
        $prof['MaturePublish']  = $maturepublish;
        $prof['URL']            = $url;
        $prof['WantToMask']     = $wanttomask;
        $prof['WantToText']     = $wanttotext;
        $prof['SkillsMask']     = $skillsmask;
        $prof['SkillsText']     = $skillstext;
        $prof['LanguagesText']  = $languagestext;
        $prof['Image']          = $image;
        $prof['AboutText']      = $abouttext;
        $prof['FirstImage']     = $firstimage;
        $prof['FirstAboutText'] = $firsttext;
    }

    return $prof;
}


function  opensim_get_prof_setting($uuid, &$db=null)
{
    if (!isGUID($uuid)) return null;
    if (!is_object($db)) $db = opensim_new_db();
    $prof = null;

    $db->query('SELECT * FROM '.PROFILE_USERSETTINGS_TBL." WHERE useruuid='$uuid'");

    if ($db->Errno==0) {
        $prof = array();
        list($useruuid, $imviaemail, $visible, $email) = $db->next_record();

        $prof['UUID']       = $useruuid;
        $prof['ImviaEmail'] = $imviaemail;
        $prof['Visible']    = $visible;
        $prof['Email']      = $email;
    }

    return $prof;
}


function  opensim_get_prof_classified($uuid, &$db=null)
{
    if (!isGUID($uuid)) return null;
    if (!is_object($db)) $db = opensim_new_db();
    $prof = null;

    $db->query('SELECT * FROM '.PROFILE_CLASSIFIEDS_TBL." WHERE classifieduuid='$uuid'");

    if ($db->Errno==0) {
        $prof = array();
        list($classifieduuid, $creatoruuid, $creationdate, $expirationdate, $category, $name, $description, $parceluuid, 
                $parentestate, $snapshotuuid, $simname, $posglobal, $parcelname, $classifiedflags, $priceforlisting) = $db->next_record();

        $prof['UUID']            = $classifieduuid;
        $prof['CreatorUUID']     = $creatoruuid;
        $prof['CreationDate']    = $creationdate;
        $prof['ExpirationDate']  = $expirationdate;
        $prof['Category']        = $category;
        $prof['Name']            = $name;
        $prof['Description']     = $description;
        $prof['ParcelUUID']      = $parceluuid;
        $prof['ParenteEtate']    = $parentestate;
        $prof['SnapshotUUID']    = $snapshotuuid;
        $prof['SimName']         = $simname;
        $prof['PosGlobal']       = $posglobal;
        $prof['ParcelName']      = $parcelname;
        $prof['ClassifiedFlags'] = $classifiedflags;
        $prof['PriceForListing'] = $priceforlisting;
    }

    return $prof;
}


function  opensim_get_prof_note($uuid, &$db=null)
{
    if (!isGUID($uuid)) return null;
    if (!is_object($db)) $db = opensim_new_db();
    $prof = null;

    $db->query('SELECT * FROM '.PROFILE_USERNOTES_TBL." WHERE useruuid='$uuid'");

    if ($db->Errno==0) {
        $prof = array();
        list($useruuid, $targetuuid, $notes) = $db->next_record();

        $prof['UUID']       = $useruuid;
        $prof['TargetUUID'] = $targetuuid;
        $prof['Notes']      = $notes;
    }

    return $prof;
}


function  opensim_get_prof_pick($uuid, &$db=null)
{
    if (!isGUID($uuid)) return null;
    if (!is_object($db)) $db = opensim_new_db();
    $prof = null;

    $db->query('SELECT * FROM '.PROFILE_USERPICKS_TBL." WHERE pickuuid='$uuid'");

    if ($db->Errno==0) {
        $prof = array();
        list($pickuuid, $creatoruuid, $toppick, $parceluuid, $name, $description, $snapshotuuid, 
                    $user, $originalname, $simname, $posglobal, $sortorder, $enabled, $gatekeeper) = $db->next_record();

        $prof['UUID']         = $pickuuid;
        $prof['CreatorUUID']  = $creatoruuid;
        $prof['TopPick']      = $toppick;
        $prof['ParcelUUID']   = $parceluuid;
        $prof['Name']         = $name;
        $prof['Description']  = $description;
        $prof['SnapshotUUID'] = $snapshotuuid;
        $prof['User']         = $user;
        $prof['OriginalName'] = $originalname;
        $prof['SimName']      = $simname;
        $prof['PosGlobal']    = $posglobal;
        $prof['SortOrder']    = $sortorder;
        $prof['Enabled']      = $enabled;
        $prof['GateKeeper']   = $gatekeeper;
    }

    return $prof;
}


function  opensim_set_profiles($profs, $ovwrite=true, &$db=null)
{
    if (!is_object($db)) $db = opensim_new_profile_db();

    foreach($profs as $prof) {
        if ($prof['UUID']!='') {
            $insert = false;
            $obj = opensim_get_profile($prof['UUID'], $db);
            if ($obj==null) {
                $insert = true;
            }

            $prfobj = array();
            $prfobj['useruuid'] = $prof['UUID'];
            if (array_key_exists('Partnar',        prof)) $prfobj['profilePartner']       = $prof['Partnar'];
            if (array_key_exists('AllowPublish',   prof)) $prfobj['profileAllowPublish']  = $prof['AllowPublish'];
            if (array_key_exists('MaturePublish',  prof)) $prfobj['profileMaturePublish'] = $prof['MaturePublish'];
            if (array_key_exists('URL',            prof)) $prfobj['profileURL']           = $prof['URL'];
            if (array_key_exists('WantToMask',     prof)) $prfobj['profileWantToMask']    = $prof['WantToMask'];
            if (array_key_exists('WantToText',     prof)) $prfobj['profileWantToText']    = $prof['WantToText'];
            if (array_key_exists('SkillsMask',     prof)) $prfobj['profileSkillsMask']    = $prof['SkillsMask'];
            if (array_key_exists('SkillsText',     prof)) $prfobj['profileSkillsText']    = $prof['SkillsText'];
            if (array_key_exists('LanguagesText',  prof)) $prfobj['profileLanguagestext'] = $prof['LanguagesText'];
            if (array_key_exists('Image',          prof)) $prfobj['profileImage']         = $prof['Image'];
            if (array_key_exists('AboutText',      prof)) $prfobj['profileAboutText']     = $prof['AboutText'];
            if (array_key_exists('FirstImage',     prof)) $prfobj['profileFirstImage']    = $prof['FirstImage'];
            if (array_key_exists('FirstAboutText', prof)) $prfobj['profileFirstText']     = $prof['FirstAboutText'];
    
            if ($insert) {
                $rslt = $db->insert_record(PROFILE_USERPROFILE_TBL, $obj);
            }
            else if ($ovwrite) {
                $rslt = $db->update_record(PROFILE_USERPROFILE_TBL, $obj);
            }
        }
    }
    if (!$rslt) return $rslt;

    //
    foreach($profs as $prof) {
        if ($prof['UUID']!='') {
            $insert = false;
            $obj = opensim_get_prof_setting($prof['UUID'], $db);
            if (!$obj) {
                $insert = true;
            }

            $setobj = array();
            $setobj['useruuid'] = $prof['UUID'];
            if (array_key_exists('ImviaEmail', prof)) $setobj['imviaemail'] = $prof['ImviaEmail'];
            if (array_key_exists('Visible',    prof)) $setobj['visible']    = $prof['Visible'];
            if (array_key_exists('Email',      prof)) $setobj['email']      = $prof['Email'];

            if ($insert) {
                $rslt = $db->insert_record(PROFILE_USERSETTINGS_TBL, $setobj);
            }
            else if ($ovwrite) {
                $rslt = $db->update_record(PROFILE_USERSETTINGS_TBL, $setobj);
            }
        }
    }

    return $rslt;
}


function  opensim_delete_profiles($uuid, &$db=null)
{
    if (!isGUID($uuid)) return;
    if (!is_object($db)) $db = opensim_new_profile_db();

    $db->query('DELETE FROM '.PROFILE_USERPROFILE_TBL. " WHERE useruuid='$uuid'");
    $db->query('DELETE FROM '.PROFILE_USERSETTINGS_TBL." WHERE useruuid='$uuid'");
    $db->query('DELETE FROM '.PROFILE_USERNOTES_TB.    " WHERE useruuid='$uuid'");
    $db->query('DELETE FROM '.PROFILE_USERPICKS_TBL.   " WHERE creatoruuid='$uuid'");
    $db->query('DELETE FROM '.PROFILE_CLASSIFIEDS_TBL. " WHERE creatoruuid='$uuid'");

    return;
}

