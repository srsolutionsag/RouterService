<?php
require_once('./Services/UIComponent/classes/class.ilUIHookProcessor.php');

/**
 * Service ilRouterGUI
 *
 * @author  Fabian Schmid <fs@studer-raimann.ch>
 * @version $Id:
 *
 * @ingroup ServicesRouter
 */
class ilRouterGUI {

	public function __construct() {
		global $lng, $tpl, $ilCtrl;
		/**
		 * @var $tpl    ilTemplate
		 * @var $ilCtrl ilCtrl
		 * @var $ilLog  ilLog
		 */
		$this->lng =& $lng;
		$this->tpl =& $tpl;
		$this->ctrl =& $ilCtrl;
		$this->tpl->getStandardTemplate();
		new ilUIHookProcessor('Services/Router', 'router', array( 'router' => $this ));
	}


	function executeCommand() {
		$next_class = $this->ctrl->getNextClass($this);
		switch ($next_class) {
			default:
				$class_file = $this->ctrl->lookupClassPath($next_class);
				if (is_file($class_file)) {
					include_once($class_file);
					$gui = new $next_class();
					$this->ctrl->forwardCommand($gui);
				} else {
					ilUtil::sendFailure('Plugin GUI-Class not found! (' . $next_class . ')');
				}
				break;
		}
		$this->tpl->show();
	}
}

?>