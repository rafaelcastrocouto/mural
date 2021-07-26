<?php

App::uses('AppController', 'Controller');

/**
 * Situacaopr5s Controller
 *
 * @property Situacaopr5 $Situacaopr5
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class Situacaopr5sController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Flash');

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('add', 'index', 'view', 'edit');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('index', 'view');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/situacaopr5s/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Situacaopr5->recursive = 0;
        $this->set('situacaopr5s', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Situacaopr5->exists($id)) {
            throw new NotFoundException(__('Invalid situacaopr5'));
        }
        $options = array('conditions' => array('Situacaopr5.' . $this->Situacaopr5->primaryKey => $id));
        $this->set('situacaopr5', $this->Situacaopr5->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Situacaopr5->create();
            if ($this->Situacaopr5->save($this->request->data)) {
                $this->Flash->success(__('The situacaopr5 has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The situacaopr5 could not be saved. Please, try again.'));
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
        if (!$this->Situacaopr5->exists($id)) {
            throw new NotFoundException(__('Invalid situacaopr5'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Situacaopr5->save($this->request->data)) {
                $this->Flash->success(__('The situacaopr5 has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The situacaopr5 could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Situacaopr5.' . $this->Situacaopr5->primaryKey => $id));
            $this->request->data = $this->Situacaopr5->find('first', $options);
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
        if (!$this->Situacaopr5->exists($id)) {
            throw new NotFoundException(__('Invalid situacaopr5'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Situacaopr5->delete($id)) {
            $this->Flash->success(__('The situacaopr5 has been deleted.'));
        } else {
            $this->Flash->error(__('The situacaopr5 could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
