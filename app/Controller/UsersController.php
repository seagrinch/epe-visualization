<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
  //public $helpers = array('Session','Number','Js','Time','Geography');
  public $helpers = array('Geography','Time');

/**
 * beforeFilter
 */
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('register', 'logout', 'password', 'reset');
    $this->set('career_stages',$this->career_stages);
  }

/**
 * Pagination defaults
 */
  public $paginate = array(
    'recursive'=>-1,
    'limit'=>25,
        'order' => array('User.created' => 'desc'),
  );

/**
 * Create a new account
 */
  public function index($clear=null) {
    // Search Results if requested   
    if($clear == 'clear') {
      $this->Session->delete($this->name.'.search'); 
    }
    if(!empty($this->data)) {
        $search = $this->data['User']['search']; 
    } elseif($this->Session->check($this->name.'.search')) {
        $search = $this->Session->read($this->name.'.search');
    } 
    if(isset($search)) {
      $this->paginate = array_merge($this->paginate,array(
        'conditions'=>array(
          'OR'=>array(
            'User.name LIKE' => '%'.$search.'%',
            'User.email LIKE' => '%'.$search.'%',
        )),
      ));
      $this->Session->write($this->name.'.search', $search);
      $this->request->data['User']['search'] = $search; 
    }
    $users = $this->paginate('User');
    $this->set(compact('users'));
  }

/**
 * Create a new account
 */
  public function register() {
    if ($this->request->is('post')) {
      $this->User->create();
      $this->request->data['User']['is_admin'] = 0;  //Prevent overrides
      if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('Your account was created successfully.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
        $id = $this->User->id;
        $this->request->data['User'] = array_merge($this->request->data["User"], array('id' => $id));
        $this->Auth->login($this->request->data['User']);
        $this->Session->write('Auth.User.id', $this->User->id);
        $this->redirect(array('controller'=>'pages','action' => 'index'));
      } else {
				$this->Session->setFlash(__('Your account could not be created. Please, try again.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
      }
    }
  }

/**
 * User Login
 */
	public function login() {
	  //$this->Auth->logout();
    if ($this->request->is('post')) {
      if ($this->Auth->login()) {
        return $this->redirect($this->Auth->redirect());
      } else {
        $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
      }
    }
  }

/**
 * User Logoff
 */
	public function logout() {
	  $this->Session->delete('wizard');
    $this->redirect($this->Auth->logout());
	}

/**
 * User Profile
 */
  public function profile($username=null) {
    if(empty($username) & $this->Auth->user('id')) {
      $username = $this->Auth->user('username');
    }
    $this->set('user',$this->User->find('first', array('conditions'=>array('username'=>$username),'recursive'=>-1)));
  }

/**
 * User Profile Update
 */
  public function profile_update() {
    if ($this->request->is('post') || $this->request->is('put')) {
      $this->request->data['User']['id'] = $this->Auth->user('id');  //Prevent overrides for security
		  if (empty($this->request->data['User']['password'])) {
		    unset($this->request->data['User']['password']); // Remove password if not set to prevent validation
		  }
      if ($this->User->save($this->request->data,true,
        array('name','email','password','institution','career_stage','research_field','state'))) {
				$this->Session->setFlash(__('Your profile was updated.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
				$this->redirect('profile');
      } else {
				$this->Session->setFlash(__('Your changes could not be saved. Please, try again'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
      }
    } else {
      $this->request->data = $this->User->read(null, $this->Auth->user('id'));
      unset($this->request->data['User']['password']);
    }
  }

/**
 * Password Reset Email
 */
  public function password($token=null) {
    App::uses('CakeEmail', 'Network/Email');
    if ($this->request->is('post')) {
      $id = $this->User->field('id',array('email'=>$this->data['User']['email']));
      $this->User->id = $id;
      if ($this->User->exists()) {
        $token = $this->generateToken(20);
        $this->User->saveField('token',$token);
        $message = 'To update your lost password on the ' . siteName . ' web site, please go to the following link.' . "\n\n" . Router::url(array('action' => 'reset', $token), true) . "\n\n" . 'If you did not make this request, or do not wish to change your password, simply ignore this email.';
        $email = new CakeEmail();
        $email->from(array(emailFromAddress => emailFromName));
        $email->to($this->data['User']['email']);
        $email->subject( siteName . ' - Reset Password');
          //->template('password_reset', 'default')
          //->viewVars($user)
        $email->send($message);
				$this->Session->setFlash('Instructions on how to reset your password were set to <strong>' . $this->data['User']['email'] . '</strong>. If you continue to have trouble, please contact <a href="mailto:' . emailFromAddress . '">' . emailFromAddress . '</a>.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
      } else {
				$this->User->invalidate('email','The email address you entered could not be found, please try again or register a new account.');
      }
    }
  }
  
/**
 * Password Reset
 */
  public function reset($token=null) {
    $id = $this->User->field('id',array('token'=>$token));
    $this->User->id = $id;
    if ($this->User->exists()) {
      if ($this->request->is('post') || $this->request->is('put')) {
        if ($this->User->save($this->request->data,true,array('password'))) {
          $this->User->saveField('token','');
  				$this->Session->setFlash(__('Your password has been changed.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
  				$this->redirect('login');
        } else {
  		    $this->Session->setFlash('Please try again.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
        }
      }
    } else {
  		$this->Session->setFlash('The entered token was not found.  Please try the URL again or request a new token.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
  		$this->redirect('password');
    }
  }

		      //check that password change is valid 
    // - if not, invalidate field (is this necessary?
    // - if so, save password, delete token, forward to login page with session note
    //check for token - render token page, or throw session error back to main

    
// ------------------------------------------------------------
// Admin Functions
// ------------------------------------------------------------
  
/**
 * Admin Login
 */
	public function admin_login() {
	  $this->redirect('/users/login');
	}


/**
 * Admin User Edit
 */
  public function admin_index($clear = null) {
    $this->set('admins',$this->User->find('all',array('conditions'=>array('is_admin'=>1))));

    // Search Results if requested   
    if($clear == 'clear') {
      $this->Session->delete($this->name.'.search'); 
    }
    if(!empty($this->data)) {
        $search = $this->data['User']['search']; 
    } elseif($this->Session->check($this->name.'.search')) {
        $search = $this->Session->read($this->name.'.search');
    } 
    if(isset($search)) {
      $this->paginate = array_merge($this->paginate,array(
        'conditions'=>array(
          'OR'=>array(
            'User.name LIKE' => '%'.$search.'%',
            'User.email LIKE' => '%'.$search.'%',
        )),
      ));
      $this->Session->write($this->name.'.search', $search);
      $this->request->data['User']['search'] = $search; 
    }
    $users = $this->paginate('User');
    $this->set(compact('users'));
  }

/**
 * Admin User Edit
 */
  public function admin_edit($id = null) {
    $this->User->id = $id;
    if (!$this->User->exists()) {
      throw new NotFoundException(__('Invalid user'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
		  if (empty($this->request->data['User']['password'])) {
		    unset($this->request->data['User']['password']);
		  }
      if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('User information updated.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
        $this->redirect(array('action' => 'index'));
      } else {
				$this->Session->setFlash(__('Your changes could not be saved. Please, try again'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
      }
    } else {
      $this->request->data = $this->User->read(null, $id);
      unset($this->request->data['User']['password']);
    }
  }

// ------------------------------------------------------------
// Extra Functions
// ------------------------------------------------------------

/**
 * Generate token used by the user registration system
 * From CakeDC Users plugin
 *
 * @param int $length Token Length
 * @return string
 */
	public function generateToken($length = 10) {
		$possible = '0123456789abcdefghijklmnopqrstuvwxyz';
		$token = "";
		$i = 0;

		while ($i < $length) {
			$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
			if (!stristr($token, $char)) {
				$token .= $char;
				$i++;
			}
		}
		return $token;
	}


/**
 * Career Stages list
 */
  public $career_stages = array(
    'ug'=>'Undergraduate Student',
    'gs'=>'Graduate Student',
    'pd'=>'Post Doctoral Researcher',
    'k12'=>'K-12 Educator',
    'professor'=>'University Professor',
    'ccf'=>'Community College Faculty',
    'res'=>'Scientist/Researcher',
    'other'=>'Other',
  );


}
