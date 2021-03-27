<?php

App::uses('AppController', 'Controller');

/**
 * Complementos Controller
 *
 * @property Complemento $Complemento
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */

class ComplementosController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Flash', 'Auth');

    public function beforeFilter() {
        
        parent::beforeFilter();

        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
        } else {
            $this->Flash->error(__("Não autorizado"));
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        
        $this->Complemento->recursive = 0;
        $this->set('complementos', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Complemento->exists($id)) {
            throw new NotFoundException(__('Invalid complemento'));
        }
        $options = array('conditions' => array('Complemento.' . $this->Complemento->primaryKey => $id));
        $this->set('complemento', $this->Complemento->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Complemento->create();
            if ($this->Complemento->save($this->request->data)) {
                $this->Flash->success(__('Inserido!'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('Não foi possível completar a ação. Tente novamente.'));
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
        
        if (!$this->Complemento->exists($id)) {
            throw new NotFoundException(__('Invalid complemento'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Complemento->save($this->request->data)) {
                $this->Flash->success(__('Actualizado!'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('Não foi possível concluir a ação. Tente novamente.'));
            }
        } else {
            $options = array('conditions' => array('Complemento.' . $this->Complemento->primaryKey => $id));
            $this->request->data = $this->Complemento->find('first', $options);
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
        if (!$this->Complemento->exists($id)) {
            throw new NotFoundException(__('Informação inválida'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Complemento->delete($id)) {
            $this->Flash->success(__('Excluído!'));
        } else {
            $this->Flash->error(__('Ação não foi completada. Tente novamente.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
