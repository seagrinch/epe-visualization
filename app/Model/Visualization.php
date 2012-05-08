<?php
App::uses('AppModel', 'Model');
/**
 * Visualization Model
 *
 * @property VisTool $VisTool
 * @property User $User
 * @property Provenance $Provenance
 */
class Visualization extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'vis_tool_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'VisTool' => array(
			'className' => 'VisTool',
			'foreignKey' => 'vis_tool_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Provenance' => array(
			'className' => 'Visualization',
			'foreignKey' => 'provenance_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
