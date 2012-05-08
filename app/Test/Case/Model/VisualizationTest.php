<?php
App::uses('Visualization', 'Model');

/**
 * Visualization Test Case
 *
 */
class VisualizationTestCase extends CakeTestCase {
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
		$this->Visualization = ClassRegistry::init('Visualization');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Visualization);

		parent::tearDown();
	}

}
