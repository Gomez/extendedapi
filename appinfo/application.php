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


use \OCP\AppFramework\App;

use \OCA\ExtendedApi\Controller\PageController;


class Application extends App {


	public function __construct (array $urlParams=array()) {
		parent::__construct('extendedapi', $urlParams);

		$container = $this->getContainer();

		/**
		 * Controllers
		 */
		$container->registerService('PageController', function($c) {
			return new PageController(
				$c->query('AppName'), 
				$c->query('Request'),
				$c->query('UserId')
			);
		});


		/**
		 * Core
		 */
		$container->registerService('UserId', function($c) {
			return \OCP\User::getUser();
		});		
		
	}


}