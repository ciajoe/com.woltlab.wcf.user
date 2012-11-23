<?php
namespace wcf\data;

/**
 * Default interface for watched objects.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.user
 * @subpackage	data
 * @category 	Community Framework
 */
interface IWatchedObject {
	/**
	 * Returns application abbreviation.
	 * 
	 * @return	string
	 */
	public function getApplication();
	
	/**
	 * Returns time of last update.
	 * 
	 * @return	integer
	 */
	public function getLastUpdateTime();
	
	/**
	 * Returns template name.
	 * 
	 * @return	string
	 */
	public function getTemplateName();
}
