<?php
/**
 * ownCloud - extendedapi
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Steffen Lindner <mail@steffen-lindner.de>
 * @copyright Steffen Lindner 2014
 */

use \OC_OCS_Result;

/**
* @brief The class to handle the filesystem hooks
*/
class OC_Extended_API_Users {

    /**
     * gets user info
     */
    public static function getUser($parameters){
        $userid = $parameters['userid'];
        $return = array();
        // Check if they are viewing information on themself
        if($userid === OC_User::getUser()){
            // Self lookup
            $return['email'] = OC_Preferences::getValue($userid, 'settings', 'email', '');
            // Todo add quota info
        } else {
            // Looking up someone else
            if(OC_User::isAdminUser(OC_User::getUser())
                || OC_SubAdmin::isUserAccessible(OC_User::getUser(), $userid)) {
                // Check the user exists
                if(!OC_User::userExists($parameters['userid'])){
                    return new OC_OCS_Result(null, 101);
                }
                // If an admin, return if the user is enabled or not
                if(OC_User::isAdminUser($userid)){
                    $return['enabled'] = OC_Preferences::getValue($userid, 'core', 'enabled', 'true');
                }
            } else {
                // No permission to view this user data
                return new OC_OCS_Result(null, 997);
            }
        }
        $return['displayname'] = OC_User::getDisplayName($userid);
        return new OC_OCS_Result($return);
    }

    /**
     * edit users
     */
    public static function editUser($parameters){
        $userid = $parameters['userid'];
        if($userid === OC_User::getUser()) {
            // Editing self (diaply, email)
            $permittedfields[] = 'display';
            $permittedfields[] = 'email';
            $permittedfields[] = 'password';
        } else {
            // No rights
            return new OC_OCS_Result(null, 997);
        }
        // Check if admin / subadmin
        if(OC_SubAdmin::isUserAccessible(OC_User::getUser(), $userid)
            || OC_User::isAdminUser(OC_User::getUser())) {
            // They have permissions over the user
            $permittedfields[] = 'display';
            $permittedfields[] = 'quota';
            $permittedfields[] = 'password';
        } else {
            // No rights
            return new OC_OCS_Result(null, 997);
        }
        // Check if permitted to edit this field
        $param_key = array_keys($parameters['_put'])[0];
        $param_value = $parameters['_put'][$param_key];
        if(!in_array($param_key, $permittedfields)) {
            return new OC_OCS_Result(null, 997);
        }
        // Process the edit
        switch($param_key){
            case 'display':
                OC_User::setDisplayName($userid, $param_value);
                break;
            case 'quota':
                if(!is_numeric($param_value)) {
                    return new OC_OCS_Result(null, 101);
                }
                $quota = $param_value;
                if($quota !== 'none' and $quota !== 'default') {
                    $quota = OC_Helper::computerFileSize($quota);
                    if($quota == 0) {
                        $quota = 'default';
                    }else if($quota == -1){
                        $quota = 'none';
                    } else {
                        $quota = OC_Helper::humanFileSize($quota);
                    }
                }
                OC_Preferences::setValue($userid, 'files', 'quota', $quota);
                break;
            case 'password':
                OC_User::setPassword($userid, $param_value);
                break;
            case 'email':
                if(filter_var($param_value, FILTER_VALIDATE_EMAIL)) {
                    OC_Preferences::setValue(OC_User::getUser(), 'settings', 'email', $param_value);
                } else {
                    return new OC_OCS_Result(null, 102);
                }
                break;
            default:
                return new OC_OCS_Result(null, 103);
                break;
        }
        return new OC_OCS_Result(null, 100);
    }


}

