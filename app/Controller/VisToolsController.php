<?php
App::uses('AppController', 'Controller');
/**
 * VisTools Controller
 *
 * @property VisTool $VisTool
 */
class VisToolsController extends AppController {

    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'VisTool.id' => 'asc'
        )
    );

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->VisTool->recursive = 0;
		$this->set('visTools', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->VisTool->id = $id;
		if (!$this->VisTool->exists()) {
			throw new NotFoundException(__('Invalid vis tool'));
		}
		$this->set('visTool', $this->VisTool->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->VisTool->create();
			if ($this->VisTool->save($this->request->data)) {
				$this->Session->setFlash('The new Visualization Tool was created','default',array('class'=>'alert alert-success'));
				$this->redirect(array('action' => 'edit', $this->VisTool->id));
			} else {
				$this->Session->setFlash('Your new Visualization Tool could not be saved. Please, try again.','default',array('class'=>'alert alert-error'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->VisTool->id = $id;
		if (!$this->VisTool->exists()) {
			throw new NotFoundException(__('Invalid vis tool'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->VisTool->save($this->request->data)) {		
				$this->Session->setFlash(__('The vis tool has been saved'));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The vis tool could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->VisTool->read(null, $id);
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
		$this->VisTool->id = $id;
		if (!$this->VisTool->exists()) {
			throw new NotFoundException(__('Invalid vis tool'));
		}
		if ($this->VisTool->delete()) {
			$this->Session->setFlash(__('Vis tool deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vis tool was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * settings method
 *
 * @param string $id
 * @return void
 */
	public function settings($id = null) {
		$this->VisTool->id = $id;
		if (!$this->VisTool->exists()) {
			throw new NotFoundException(__('Invalid vis tool'));
		}
		$this->set('visTool', $this->VisTool->read(null, $id));
	  $this->layout = 'ajax';
	}

}
