<?php
namespace wcf\system\package\plugin;
use wcf\system\cache\CacheHandler;
use wcf\system\exception\SystemException;
use wcf\system\WCF;

/**
 * This PIP installs, updates or deletes dashboard boxes.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.user
 * @subpackage	system.package.plugin
 * @category 	Community Framework
 */
class DashboardBoxPackageInstallationPlugin extends AbstractXMLPackageInstallationPlugin {
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::$className
	 */
	public $className = 'wcf\data\dashboard\box\DashboardBoxEditor';
	
	/**
	 * @see	wcf\system\package\plugin\AbstractPackageInstallationPlugin::$tableName
	 */
	public $tableName = 'dashboard_box';
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::$tagName
	 */	
	public $tagName = 'dashboardbox';
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::handleDelete()
	 */
	protected function handleDelete(array $items) {
		$sql = "DELETE FROM	wcf".WCF_N."_".$this->tableName."
			WHERE		boxName = ?
					AND packageID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		foreach ($items as $item) {
			$statement->execute(array(
				$item['attributes']['name'],
				$this->installation->getPackageID()
			));
		}
	}
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::prepareImport()
	 */
	protected function prepareImport(array $data) {
		return array(
			'boxName' => $data['attributes']['name'],
			'boxType' => ($data['elements']['boxtype'] == 'content') ? 'content' : 'sidebar',
			'className' => $data['elements']['classname']
		);
	}
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::findExistingItem()
	 */
	protected function findExistingItem(array $data) {
		$sql = "SELECT	*
			FROM	wcf".WCF_N."_".$this->tableName."
			WHERE	boxName = ?
				AND packageID = ?";
		$parameters = array(
			$data['boxName'],
			$this->installation->getPackageID()
		);
		
		return array(
			'sql' => $sql,
			'parameters' => $parameters
		);
	}
	
	/**
	 * @see	wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::cleanup()
	 */	
	protected function cleanup() {
		CacheHandler::getInstance()->clear(WCF_DIR.'cache', 'cache.dashboardBoxes-*.php');
	}
	
	/**
	 * @see	wcf\system\package\plugin\IPackageInstallationPlugin::uninstall()
	 */
	public function uninstall() {
		parent::uninstall();
		
		// clear cache immediately
		CacheHandler::getInstance()->clear(WCF_DIR.'cache', 'cache.dashboardBoxes-*.php');
	}
}