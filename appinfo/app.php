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

namespace OCA\ExtendedApi\AppInfo;


\OCP\App::addNavigationEntry(array(
    // the string under which your app will be referenced in owncloud
    'id' => 'extendedapi',

    // sorting weight for the navigation. The higher the number, the higher
    // will it be listed in the navigation
    'order' => 10,

    // the route that will be shown on startup
    'href' => \OCP\Util::linkToRoute('extendedapi.page.index'),

    // the icon that will be shown in the navigation
    // this file needs to exist in img/
    'icon' => \OCP\Util::imagePath('extendedapi', 'app.svg'),

    // the title of your application. This will be used in the
    // navigation or on the settings page of your app
    'name' => \OC_L10N::get('extendedapi')->t('Extended Api')
));