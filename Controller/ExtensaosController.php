<?php

App::uses('AppController', 'Controller');

/**
 * Extensaos Controller
 *
 * @property Extensao $Extensao
 * @property PaginatorComponent $Paginator
 */
class ExtensaosController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash', 'Auth');

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('add', 'index', 'view', 'edit');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('add', 'index', 'view', 'edit');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('add', 'index', 'view', 'edit');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/extensaos/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $this->Paginator->settings = [
            'Extensao' => [
                'order' => ['titulo'],
                'limit' => 10
            ]
        ];

        $this->Extensao->contain(['Essextensoes']);
        $this->set('extensaos', $this->Paginator->paginate('Extensao'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {

        if (!$this->Extensao->exists($id)) {
            throw new NotFoundException(__('Invalid extensao'));
        }
        $options = array('conditions' => array('Extensao.' . $this->Extensao->primaryKey => $id));
        $this->set('extensao', $this->Extensao->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {

        if ($this->request->is('post')) {
            $this->Extensao->create();
            // pr($this->request->data);
            if ($this->request->data['Extensao']['tae_id']) {
                $this->request->data['Extensao']['segmento_id'] = $this->request->data['Extensao']['tae_id'];
                $this->request->data['Extensao']['segmento'] = 'tae';
                $nometae = $this->Extensao->Tae->find('first', ['conditions' => ['Tae.id' => $this->request->data['Extensao']['tae_id']]]);
                $this->request->data['Extensao']['nome'] = $nometae['Tae']['nome'];
            } elseif ($this->request->data['Extensao']['docente_id']) {
                $this->request->data['Extensao']['segmento_id'] = $this->request->data['Extensao']['docente_id'];
                $this->request->data['Extensao']['segmento'] = 'docente';
                $nomedocente = $this->Extensao->Professor->find('first', ['conditions' => ['Professor.id' => $this->request->data['Extensao']['docente_id']]]);
                $this->request->data['Extensao']['nome'] = $nomedocente['Professor']['nome'];
            }
            // pr($this->request->data);
            // die();
            if ($this->Extensao->save($this->request->data)) {
                $this->Session->setFlash("Cadastro realizado!");
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('Não foi possível realizar a ação. Tente novamente.'));
            }
        }
        $docentes = $this->Extensao->Professor->find('list', ['order' => 'nome']);
        $taes = $this->Extensao->Tae->find('list', ['order' => 'nome']);
        $situacaopr5 = $this->Extensao->Situacaopr5->find('list', ['order' => 'situacao']);
        // pr($situacaopr5);
        // die();
        $this->set(compact('docentes', 'taes', 'situacaopr5'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        if (!$this->Extensao->exists($id)) {
            throw new NotFoundException(__('Invalid extensao'));
        }
        if ($this->request->is(array('post', 'put'))) {
            // pr($this->request->data);
            if ($this->request->data['Extensao']['tae_id']) {
                $this->request->data['Extensao']['segmento_id'] = $this->request->data['Extensao']['tae_id'];
                $this->request->data['Extensao']['segmento'] = 'tae';
                $nometae = $this->Extensao->Tae->find('first', ['conditions' => ['Tae.id' => $this->request->data['Extensao']['tae_id']]]);
                $this->request->data['Extensao']['nome'] = $nometae['Tae']['nome'];
            } elseif ($this->request->data['Extensao']['docente_id']) {
                $this->request->data['Extensao']['segmento_id'] = $this->request->data['Extensao']['docente_id'];
                $this->request->data['Extensao']['segmento'] = 'docente';
                $nomedocente = $this->Extensao->Professor->find('first', ['conditions' => ['Professor.id' => $this->request->data['Extensao']['docente_id']]]);
                $this->request->data['Extensao']['nome'] = $nomedocente['Professor']['nome'];
            }
            // pr($this->request->data);
            // die();
            if ($this->Extensao->save($this->request->data)) {
                $this->Session->setFlash(__('Atualizado!'));
                return $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Session->setFlash(__('Não foi possível completar a operação. Tente novamente.'));
            }
        } else {
            $options = array('conditions' => array('Extensao.' . $this->Extensao->primaryKey => $id));
            $this->request->data = $this->Extensao->find('first', $options);
        }
        $docentes = $this->Extensao->Professor->find('list', ['order' => 'nome']);
        $taes = $this->Extensao->Tae->find('list', ['order' => 'nome']);
        $situacaopr5 = $this->Extensao->Situacaopr5->find('list', ['order' => 'situacao']);
        $this->set(compact('docentes', 'taes', 'situacaopr5'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->Extensao->exists($id)) {
            throw new NotFoundException(__('Invalid extensao'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Extensao->delete($id)) {
            $this->Session->setFlash(__('The extensao has been deleted.'));
        } else {
            $this->Session->setFlash(__('The extensao could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function coordenadores() {

        $ordem = $this->request->query('ordem');
        pr($ordem);

        $coordenadores = $this->Extensao->find('all');
        $i = NULL;
        foreach ($coordenadores as $c_coordenador) {

            $lista[$i]['extensao_id'] = $c_coordenador['Extensao']['id'];
            $lista[$i]['titulo'] = $c_coordenador['Extensao']['titulo'];
            $lista[$i]['datacongregacao'] = $c_coordenador['Extensao']['datacongregacao'];
            $lista[$i]['observacoes'] = $c_coordenador['Extensao']['observacoes'];
            if ($c_coordenador['Professor']['nome']):
                $lista[$i]['nome'] = $c_coordenador['Professor']['nome'];
                $lista[$i]['segmento'] = 'docente';
                $lista[$i]['docente_id'] = $c_coordenador['Professor']['id'];
            else:
                $lista[$i]['nome'] = $c_coordenador['Tae']['nome'];
                $lista[$i]['segmento'] = 'tae';
                $lista[$i]['tae_id'] = $c_coordenador['Tae']['id'];
            endif;
            $i++;
        }
        // pr($lista);
        $this->set(compact('lista'));
    }

}
