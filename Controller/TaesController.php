<?php

App::uses('AppController', 'Controller');

/**
 * Taes Controller
 *
 * @property Tae $Tae
 * @property PaginatorComponent $Paginator
 */
class TaesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash', 'Auth');

    /**
     * index method
     *
     * @return void
     */
    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'view', 'add', 'edit');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('index', 'view', 'add', 'edit');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('index', 'view', 'add', 'edit');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/extensaos/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->Paginator->settings = [
            'Tae' => [
                'limit' => 10,
                'order' => ['data']
            ]
        ];
        
        $this->Tae->recursive = 0;
        $this->set('taes', $this->Paginator->paginate('Tae'));

    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Tae->exists($id)) {
            throw new NotFoundException(__('Invalid tae'));
        }
        $options = array('conditions' => array('Tae.' . $this->Tae->primaryKey => $id));
        $this->set('tae', $this->Tae->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Tae->create();
            if ($this->Tae->save($this->request->data)) {
                $this->Session->setFlash(__('The tae has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tae could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Tae->exists($id)) {
            throw new NotFoundException(__('Invalid tae'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Tae->save($this->request->data)) {
                $this->Session->setFlash(__('The tae has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tae could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Tae.' . $this->Tae->primaryKey => $id));
            $this->request->data = $this->Tae->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->Tae->exists($id)) {
            throw new NotFoundException(__('Invalid tae'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Tae->delete($id)) {
            $this->Flash->success(__('The tae has been deleted.'));
        } else {
            $this->Flash->error(__('The tae could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
