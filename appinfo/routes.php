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

// register an ocs api call
OCP\API::register('get', '/cloud/userdata/{userid}', array('OC_Extended_API_Users', 'getUser'), 'extendedapi', OC_API::USER_AUTH);
OCP\API::register('put', '/cloud/userdata/{userid}', array('OC_Extended_API_Users', 'editUser'), 'extendedapi', OC_API::USER_AUTH);


#OCP\API::register('get', '/cloud/activity', array('OCA\Activity\OCS', 'getActivities'), 'activity', OC_API::ADMIN_AUTH);
