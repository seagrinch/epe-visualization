<?php
App::uses('AppController', 'Controller');
/**
 * VisTools Controller
 *
 * @property VisTool $VisTool
 */
class VisToolsController extends AppController {

  public $uses = array('VisTool','Visualization');
  public $components = array('ImageTool');

/**
 * beforeFilter
 */
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('index','view','settings');
  }


/**
 * Listing of visualization tools 
 *
 * @return void
 */
	public function index() {
		$this->paginate = array(
		  'recursive' => 0,
	  	'conditions'=>array('VisTool.status'=>'Published'),
      'limit' => 10,
      'order' => array(
          'VisTool.created' => 'desc'
      ));
		$visTools = $this->paginate();
		if ($this->request->is('requested')) {
		  return $visTools;
    } else {
      $this->set('visTools', $visTools);
    }
	}

/**
 * View the selected visualization tool 
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->VisTool->id = $id;
		if (!$this->VisTool->exists()) {
			throw new NotFoundException(__('Invalid vis tool'));
		}
    if ($this->VisTool->field('status')=='Draft' & !($this->Auth->user('is_admin'))) {
			throw new NotFoundException(__('Draft Visualization'));      
    }
    $this->VisTool->Visualization->unbindModel(
        array('belongsTo' => array('VisTool'))
    );
    $this->set('visTool', $this->VisTool->find('first',array('conditions'=>array('id'=>$id),'recursive'=>0)));
    $this->paginate = array(
	  	'conditions'=>array('Visualization.vis_tool_id'=>$id,'Visualization.is_public'=>1),
		  'recursive' => 0,
		  'fields'=>array('Visualization.id','Visualization.name','Visualization.description','User.name'),
      'limit' => 5,
      'order' => array(
          'VisTool.created' => 'asc'
      ));
		$this->set('instances', $this->paginate('Visualization'));
	}


/**
 * Admin listing of visualization tools 
 *
 * @return void
 */
	public function admin_index() {
		$this->paginate = array(
		  'recursive' => 0,
      'limit' => 25,
      'order' => array(
          'VisTool.created' => 'asc'
      ));
		$this->set('visTools', $this->paginate());
	}


/**
 * Admin add a new visualization tool 
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->VisTool->create();
			if ($this->VisTool->save($this->request->data)) {
				$this->Session->setFlash(__('A new visualization tool was created.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
				$this->redirect(array('action' => 'edit', $this->VisTool->id));
			} else {
				$this->Session->setFlash(__('The visualization tool could not be saved. Please, try again.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
			}
		}
	}

/**
 * Admin edit and existing visualization tool
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->VisTool->id = $id;
		if (!$this->VisTool->exists()) {
			throw new NotFoundException(__('Invalid vis tool'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->VisTool->save($this->request->data)) {		
        if (is_uploaded_file($this->data['VisTool']['file_source']['tmp_name'])) {
          move_uploaded_file($this->data['VisTool']['file_source']['tmp_name'], 
            WWW_ROOT . 'files/tools/vistool' . $this->data['VisTool']['id'] . '.js');
        }
        if (is_uploaded_file($this->data['VisTool']['file_css']['tmp_name'])) {
          move_uploaded_file($this->data['VisTool']['file_css']['tmp_name'], 
            WWW_ROOT . 'files/tools/vistool' . $this->data['VisTool']['id'] . '.css');
        }
        if (is_uploaded_file($this->data['VisTool']['file_thumbnail']['tmp_name'])) {
          $status = $this->ImageTool->resize(array(
            'input' => $this->data['VisTool']['file_thumbnail']['tmp_name'],
            'output' => WWW_ROOT . 'files/tools/vistool' . $this->data['VisTool']['id'] . '.jpg',
            'width' => 260,
            'height' => 180,
            'keepRatio' => true,
            'paddings' => true,
          ));
        }
				$this->Session->setFlash(__('Changes to the visualization tool has been saved.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
				$this->redirect(array('action' => 'view', $id,'admin'=>false));
			} else {
				$this->Session->setFlash(__('The visualization tool could not be saved. Please, try again.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
			}
		} else {
			$this->request->data = $this->VisTool->read(null, $id);
		}
	}

/**
 * Admin delete a visualization tool
 *
 * @param string $id
 * @return void
 * @todo Need to delete files when tool is deleted
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->VisTool->id = $id;
		if (!$this->VisTool->exists()) {
			throw new NotFoundException(__('Invalid vis tool'));
		}
		if ($this->VisTool->delete()) {
			$this->Session->setFlash(__('The visualization tool was deleted.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-success'));
			$this->redirect(array('action' => 'index','admin'=>false));
		}
		$this->Session->setFlash(__('The visualization tool could not be deleted.'),'alert',array('plugin' => 'TwitterBootstrap','class'=>'alert-error'));
		$this->redirect(array('action' => 'index','admin'=>false));
	}
	
}