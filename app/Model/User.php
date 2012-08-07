<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Wizard $Wizard
 */
class User extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'minlength' => array(
				'rule' => array('minlength',4),
				'message' => 'Your username must be at least 4 characters in length',
			),
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Usernames may only contain letters and numbers',
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'This username is already in use',
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a password',
			),
			'minlength' => array(
				'rule' => array('minlength',6),
				'message' => 'Your password must be at least 6 characters in length',
			),
			'match' => array(
				'rule' => array('passwordCompare','password2'),
				'message' => 'Please make sure the entered passwords match',
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please enter a valid email address',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter an email address',
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'This email address is already registered',
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your name',
			),
		),
		'is_admin' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Visualizations' => array(
			'className' => 'Visualization',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => array('is_public'=>2),
			'fields' => '',
			'order' => 'modified DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * beforeSave
 *
 * @var array
 */
  public function beforeSave() {
    if (isset($this->data[$this->alias]['password'])) {
      $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
    return true;
  }

/** 
* Password comparison check
*
* Auth password checking and hashing adapted from
* http://teknoid.wordpress.com/2008/10/06/introduction-to-cakephp-features-build-an-app-in-less-than-15-minutes/
* @param data the full array of form data
* @param fieldTwo the confirmaiton field to check the password against
* @return boolean
*/
	function passwordCompare($data, $fieldTwo) {   
		if($data['password'] != $this->data[$this->alias][$fieldTwo]) {
			//$this->invalidate($fieldTwo, 'Passwords must match');
			return false;
		} 
		return true;
	}
  
}
