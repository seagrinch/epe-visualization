<?php
App::uses('AppController', 'Controller');
/**
 * Visualizations Controller
 *
 * @property Visualization $Visualization
 */
class VisualizationsController extends AppController {

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Visualization.id' => 'asc'
        )
    );

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Visualization->recursive = 0;
		$this->set('visualizations', $this->paginate());
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
				$this->Session->setFlash('Your custom visualization was created.','default',array('class'=>'alert alert-success'));
				$this->redirect(array('action' => 'view', $this->Visualization->id));
			} else {
				$this->Session->setFlash('Your custom visualization could not be saved. Please, try again.','default',array('class'=>'alert alert-error'));
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
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Visualization->save($this->request->data)) {
				$this->Session->setFlash('Changes to your custom visualization have been saved.','default',array('class'=>'alert alert-success'));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash('Your custom visualization could not be saved. Please, try again.','default',array('class'=>'alert alert-error'));
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
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Visualization->id = $id;
		if (!$this->Visualization->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		if ($this->Visualization->delete()) {
			$this->Session->setFlash(__('Vis instance deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vis instance was not deleted'));
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