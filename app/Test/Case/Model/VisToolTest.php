<?php
App::uses('VisTool', 'Model');

/**
 * VisTool Test Case
 *
 */
class VisToolTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.vis_tool', 'app.vis_instance', 'app.user', 'app.provenance');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->VisTool = ClassRegistry::init('VisTool');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->VisTool);

		parent::tearDown();
	}

}
