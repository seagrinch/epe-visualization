<?php
App::uses('AppModel', 'Model');
/**
 * VisTool Model
 *
 * @property Visualization $Visualization
 */
class VisTool extends AppModel {
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be empty',
				//'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'function_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'This field cannot be empty',
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'This function name is already in use.',
			),
		),
    'file_source' => array(
      'checkSize' => array(
        'rule' => array('checkSize',false),
        'message' => 'Invalid File size',
      ),
      'checkUpload' =>array(
        'rule' => array('checkUpload', false),
        'message' => 'Invalid file',
      ),
    ),
    'file_css' => array(
      'checkSize' => array(
        'rule' => array('checkSize',false),
        'message' => 'Invalid File size',
      ),
      'checkUpload' =>array(
        'rule' => array('checkUpload', false),
        'message' => 'Invalid file',
      ),
    ),
    'file_thumbnail' => array(
      'checkSize' => array(
        'rule' => array('checkSize',false),
        'message' => 'Invalid File size',
      ),
      'checkUpload' =>array(
        'rule' => array('checkUpload', false),
        'message' => 'Invalid file',
      ),
    ),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Visualization' => array(
			'className' => 'Visualization',
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
  
  // The following functions are adapted from
  // http://stackoverflow.com/questions/4836606/cakephps-file-upload-validator
  function checkUpload($data, $required = false){
        $data = array_shift($data);
        if(!$required && $data['error'] == 4){
            return true;
        }
        //debug($data);
        if($required && $data['error'] !== 0){
            return false;
        }
        if($data['size'] == 0){
            return false;
        }
        return true;

        //if($required and $data)
    }

    function checkType($data, $required = false,$allowedMime = null){
        $data = array_shift($data);
        if(!$required && $data['error'] == 4){
            return true;
        }
        if(empty($allowedMime)){
            $allowedMime = array('image/gif','image/jpeg','image/pjpeg','image/png');
        }

        if(!in_array($data['type'], $allowedMime)){
            return false;
        }
        return true;
    }

    function checkSize($data, $required = false){
        $data = array_shift($data);
        if(!$required && $data['error'] == 4){
            return true;
        }
        if($data['size'] == 0||$data['size']/1024 > 2050){
            return false;
        }
        return true;
    }

}
