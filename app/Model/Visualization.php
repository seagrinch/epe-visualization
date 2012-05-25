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
				'message' => 'Error: A vis_tool_id must be specified',
				//'allowEmpty' => false,
				'required' => 'create',
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Error: A user_id must be specified',
				//'allowEmpty' => false,
				'required' => 'create',
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please specify a name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a short description of this tool',
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

  public function isOwnedBy($id, $user) {
    return $this->field('id', array('id' => $id, 'user_id' => $user)) === $id;
  }

}
