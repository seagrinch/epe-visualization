<?php
App::uses('VisInstance', 'Model');

/**
 * VisInstance Test Case
 *
 */
class VisInstanceTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.vis_instance', 'app.vis_tool', 'app.user', 'app.provenance');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->VisInstance = ClassRegistry::init('VisInstance');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->VisInstance);

		parent::tearDown();
	}

}
