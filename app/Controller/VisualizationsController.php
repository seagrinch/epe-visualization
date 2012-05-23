<?php
App::uses('AppController', 'Controller');
/**
 * Visualizations Controller
 *
 * @property Visualization $Visualization
 */
class VisualizationsController extends AppController {
  public $helpers = array('Geography','Time');

/**
 * beforeFilter
 */
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('index','view');
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
		$this->paginate = array_merge($this->paginate,array('conditions'=>array('Visualization.is_public'=>1)));
		$this->set('visualizations', $this->paginate());
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
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		$this->set('visualization', $this->Visualization->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Visualization->create();
			if ($this->Visualization->save($this->request->data)) {
				$this->Session->setFlash('Your custom visualization was created.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
				$this->redirect(array('action' => 'view', $this->Visualization->id));
			} else {
				$this->Session->setFlash('Your custom visualization could not be saved. Please, try again.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
			}
		}
		$visTools = $this->Visualization->VisTool->find('list');
		$users = $this->Visualization->User->find('list');
		$provenances = $this->Visualization->Provenance->find('list');
		$this->set(compact('visTools', 'users', 'provenances'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
	
	// Check that user is owner on access and save
	
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Visualization->save($this->request->data)) {
				$this->Session->setFlash('Changes to your custom visualization have been saved.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash('Your custom visualization could not be saved. Please, try again.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
			}
		} else {
			$this->request->data = $this->Visualization->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {

	// Check that user is owner

		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		if ($this->Visualization->delete()) {
  		$this->Session->setFlash('Your custom visualization was deleted.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
			$this->redirect(array('action' => 'index'));
		}
	  	$this->Session->setFlash('Your custom visualization could not be deleted.','alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * settings method
 *
 * @param string $id
 * @return void
 */
	public function settings($id = null) {
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		$this->set('visualization', $this->Visualization->read(null, $id));
	  $this->layout = 'ajax';
	  $this->response->type('text/javascript');
	}  
  
}