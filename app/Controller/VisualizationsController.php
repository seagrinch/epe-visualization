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
				$this->Session->setFlash(__('The vis instance has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vis instance could not be saved. Please, try again.'));
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
		  $this->request->data['Visualization']['config_settings'] = json_encode(array(
		    'color'=>$this->request->data['Visualization']['color'],
		    'data'=>$this->request->data['Visualization']['data']
		    ));
			if ($this->Visualization->save($this->request->data)) {
				$this->Session->setFlash(__('The vis instance has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vis instance could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Visualization->read(null, $id);
			$settings = json_decode($this->request->data['Visualization']['config_settings'],1);
		  $this->request->data['Visualization']['color'] = $settings['color'];
		  $this->request->data['Visualization']['data'] = $settings['data'];
		}
		$visTools = $this->Visualization->VisTool->find('list');
		$users = $this->Visualization->User->find('list');
		$provenances = $this->Visualization->Provenance->find('list');
		$this->set(compact('visTools', 'users', 'provenances'));
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