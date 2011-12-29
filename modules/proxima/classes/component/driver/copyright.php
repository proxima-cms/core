<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Copyright extends Component_Component {

	protected $_default_config = array(
	);

	public function render()
	{
		return 'Copyright Richard Willis';
	}
}
