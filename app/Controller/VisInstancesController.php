<?php
App::uses('AppController', 'Controller');
/**
 * VisInstances Controller
 *
 * @property VisInstance $VisInstance
 */
class VisInstancesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->VisInstance->recursive = 0;
		$this->set('visInstances', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->VisInstance->id = $id;
		if (!$this->VisInstance->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		$this->set('visInstance', $this->VisInstance->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->VisInstance->create();
			if ($this->VisInstance->save($this->request->data)) {
				$this->Session->setFlash(__('The vis instance has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vis instance could not be saved. Please, try again.'));
			}
		}
		$visTools = $this->VisInstance->VisTool->find('list');
		$users = $this->VisInstance->User->find('list');
		$provenances = $this->VisInstance->Provenance->find('list');
		$this->set(compact('visTools', 'users', 'provenances'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->VisInstance->id = $id;
		if (!$this->VisInstance->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
		  $this->request->data['VisInstance']['config_settings'] = json_encode(array(
		    'color'=>$this->request->data['VisInstance']['color'],
		    'data'=>$this->request->data['VisInstance']['data']
		    ));
			if ($this->VisInstance->save($this->request->data)) {
				$this->Session->setFlash(__('The vis instance has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vis instance could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->VisInstance->read(null, $id);
			$settings = json_decode($this->request->data['VisInstance']['config_settings'],1);
		  $this->request->data['VisInstance']['color'] = $settings['color'];
		  $this->request->data['VisInstance']['data'] = $settings['data'];
		}
		$visTools = $this->VisInstance->VisTool->find('list');
		$users = $this->VisInstance->User->find('list');
		$provenances = $this->VisInstance->Provenance->find('list');
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
		$this->VisInstance->id = $id;
		if (!$this->VisInstance->exists()) {
			throw new NotFoundException(__('Invalid vis instance'));
		}
		if ($this->VisInstance->delete()) {
			$this->Session->setFlash(__('Vis instance deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vis instance was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
