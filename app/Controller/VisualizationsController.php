<?php
App::uses('AppController', 'Controller');
/**
 * Visualizations Controller
 *
 * @property Visualization $Visualization
 */
class VisualizationsController extends AppController {
  public $helpers = array('Geography','Time');
  public $uses = array('Visualization','VisTool');

/**
 * beforeFilter
 */
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('index','view','settings');
  }

/**
 * Pagination defaults
 */
  public $paginate = array(
    'recursive'=>0,
    'limit'=>25,
    'order' => array('created' => 'desc'),
  );

/**
 * Public Visualization Index
 *
 * @return void
 */
	public function index() {
		$this->paginate = array_merge($this->paginate,array('conditions'=>array('Visualization.is_public'=>2)));
		$visualizations = $this->paginate();
		if ($this->request->is('requested')) {
		  return $visualizations;
    } else {
      $this->set('visualizations', $visualizations);
    }
	}
	
/**
 * Personal Visualization Index
 *
 * @return void
 */
	public function personal() {
		$this->paginate = array_merge($this->paginate,array('conditions'=>array('Visualization.user_id'=>$this->Auth->user('id'))));
		$this->set('visualizations', $this->paginate());
		$this->render('index');
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
	  $this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid Visualization'));
		}
    if (!($this->Visualization->field('is_public')) & ($this->Visualization->field('user_id') != $this->Auth->user('id'))) {
			throw new NotFoundException(__('Private Visualization'));      
    }
		$this->set('visualization', $this->Visualization->findvis($id));
	}

/**
 * Create method
 *
 * @return void
 */
	public function create($tid=null) {
		if ($this->request->is('post') || $this->request->is('put')) {
  		$this->request->data['Visualization']['user_id'] = $this->Auth->user('id');
  	  $this->request->data['Visualization']['vis_tool_id'] = $tid;
			if ($this->Visualization->savevis($this->request->data)) {
  		  $this->Session->setFlash('Your custom visualization was created.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
  			$this->redirect(array('action' => 'view', $this->Visualization->id));
  		} else {
  		$this->Session->setFlash('Your custom visualization could not be created. Please, try again.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
  		}
    }
  	$this->VisTool->id = $tid;
		if (!$this->VisTool->exists()) {
  		throw new NotFoundException(__('Invalid Tool'));
  	}
  	$this->VisTool->recursive = -1;
  	$this->set('vistool',$this->VisTool->find('first',array('recursive'=>0,'conditions'=>array('id'=>$tid))));
//	  $this->request->data = array_merge($this->VisTool->read(null, $tid), $this->request->data);
	}

/**
 * Copy method
 *
 * @return void
 */
	public function copy($id=null) {
		if ($this->request->is('post') || $this->request->is('put')) {
  		$this->request->data['Visualization']['user_id'] = $this->Auth->user('id');
  		$this->request->data['Visualization']['provenance_id'] = $id;
			if ($this->Visualization->savevis($this->request->data)) {
  		  $this->Session->setFlash('Your custom visualization was created.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
  			$this->redirect(array('action' => 'view', $this->Visualization->id));
  		} else {
  		$this->Session->setFlash('Your custom visualization could not be created. Please, try again.' . print_r($this->Visualization->validationErrors),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
  			$this->request->data['Visualization']['id'] = $id;	
  		}
    }
  	$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
  		throw new NotFoundException(__('Invalid Visualization'));
  	}
  	$this->set('vistool',$this->VisTool->find('first',array('recursive'=>0,'conditions'=>array('id'=>$this->Visualization->field('vis_tool_id')))));
	  $this->request->data = array_merge($this->Visualization->findvis($id), $this->request->data);
	  $this->render('create');
  }

/**
 * Edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {	
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid Visualization'));
		}
		if ($this->Visualization->field('user_id') != $this->Auth->user('id')) {
  		$this->Session->setFlash('You can not edit that visualization.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
		  $this->redirect('personal');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Visualization->isOwnedBy($this->request->data['Visualization']['id'], $this->Auth->user('id') )) {
  			if ($this->Visualization->savevis($this->request->data)) {
  				$this->Session->setFlash('Changes to your custom visualization have been saved.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
  				$this->redirect(array('action' => 'view', $id));
  			} else {
  				$this->Session->setFlash('Your custom visualization could not be saved. Please, try again.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
    			$this->request->data = array_merge($this->Visualization->findvis($id), $this->request->data);
  			}
      } else {
    		$this->Session->setFlash('You can not edit that visualization.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
  		  $this->redirect('personal');
      }  
		} else {
			$this->request->data = $this->Visualization->findvis($id);
		}
  	$this->set('vistool',$this->VisTool->find('first',array('recursive'=>0,'conditions'=>array('id'=>$this->Visualization->field('vis_tool_id')))));
	}


/**
 * Delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
    if ($this->Visualization->isOwnedBy($id, $this->Auth->user('id') )) {
  		$this->Visualization->id = $id;
  		if ($this->Visualization->delete()) {
  		  $this->Session->setFlash('Your custom visualization was deleted.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
			  $this->redirect(array('action' => 'personal'));
		  }
    }
    $this->Session->setFlash('Your custom visualization could not be deleted.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
		$this->redirect(array('action' => 'personal'));
	}

/**
 * Settings method
 *
 * @param string $id
 * @return void
 */
	public function settings($id = null) {
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid Visualization'));
		}
		$this->set('visualization', $this->Visualization->findvis($id));
	  $this->layout = 'ajax';
	  $this->response->type('text/javascript');
    $this->response->header('Access-Control-Allow-Origin: *');
	}  
  
}