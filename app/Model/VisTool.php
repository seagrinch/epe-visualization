<?php
App::uses('AppModel', 'Model');
/**
 * VisTool Model
 *
 * @property VisInstance $VisInstance
 */
class VisTool extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'VisInstance' => array(
			'className' => 'VisInstance',
			'foreignKey' => 'vis_tool_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
