<?php

App::uses('AppController', 'Controller');

/**
 * Folhadeatividades Controller
 *
 * @property Folhadeatividade $Folhadeatividade
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 * @property RequestHandlerComponent $RequestHandler
 * @property AuthComponent $Auth
 */
class FolhadeatividadesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Auth', 'Paginator', 'Session', 'Flash', 'RequestHandler');

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Flash->success(__("Administrador"));
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('add', 'addatividade', 'atividade', 'index', 'busca_dre', 'historico', 'imprimepdf', 'view', 'edit', 'delete');
            // $this->Flash->success(__("Estudante"));
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('index', 'view', 'busca_dre', 'atividade', 'historico', 'imprimepdf');
            // $this->Flash->success(__("Professor"));
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('index', 'view', 'busca_dre', 'historico', 'addatividade', 'atividade', 'imprimepdf');
            // $this->Flash->success(__("Supervisor"));
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index/');
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
            'Folhadeatividade' => [
                'order' => ['dia'],
                'limit' => 10
            ]
        ];
        $this->Folhadeatividade->recursive = 2;
        $this->set('folhadeatividades', $this->Paginator->paginate('Folhadeatividade'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        /*
          if (!$this->Folhadeatividade->exists($id)) {
          throw new NotFoundException(__('Invalid folhadeatividade'));
          }
         */
        $options = array('conditions' => array('Folhadeatividade.' . $this->Folhadeatividade->primaryKey => $id));
        // $options = array('conditions' => array('Folhadeatividade.estagiario_id' => $id));
        $folhadeatividades = $this->Folhadeatividade->find('first', $options);
        // pr($folhadeatividades);
        // die();
        if (empty($folhadeatividades)) {
            $this->Session->setFlash(__('Sem folha de atividades cadastrada'));
            $this->redirect('/folhadeatividades/historico?registro=' . $this->Session->read('numero'));
        }

        /* Para pegar o nome e o id do estagiario */
        $this->loadModel('Aluno');
        $this->set('estudante', $this->Aluno->find('first', ['conditions' => ['Aluno.id' => $folhadeatividades['Estagiario']['id_aluno']]]));
        $this->set('folhadeatividade', $this->Folhadeatividade->find('first', $options));
    }

    public function busca_dre($id = NULL) {

        // die('busca_dre');
        if (!empty($this->data['Aluno']['registro'])) {
            $this->loadModel('Aluno');
            $alunos = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->data['Aluno']['registro']]
            ]);
            // pr($alunos);
            // die();
            if (empty($alunos)) {
                // Teria que buscar na tabela alunos_novos
                $this->loadModel('Alunonovo');
                $alunonovos = $this->Alunonovo->findFirstByRegistro($this->data['Aluno']['registro']);
                // pr($alunonovos);
                // die();
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros do aluno"));
                    $this->redirect('/alunos/busca');
                    die();
                } else {
                    $this->Flash->error(__("Estudante sem estágio"));
                    $this->redirect('/alunonovos/view?registro=' . $this->data['Aluno']['registro']);
                    die();
                }
            } else {
                $this->set('alunos', $alunos);
                $this->redirect('/folhadeatividades/historico?registro=' . $alunos['Aluno']['registro']);
                die();
            }
        }
    }

    public function historico($id = NULL) {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (is_null($registro)) {
            $registro = $this->request->query('registro');

            $this->loadModel('Aluno');
            if (($this->Session->read('id_categoria') == '2') && ($this->Session->read('numero'))) {
                // pr($this->Session->read('numero'));
                // die();
                if ($id) {
                    $verifica = $this->Aluno->find('first', [
                        'conditions' => ['Aluno.id' => $id]
                    ]);
                } elseif ($registro) {
                    $verifica = $this->Aluno->find('first', [
                        'conditions' => ['Aluno.registro' => $this->Session->read('numero')]
                    ]);
                }
                // pr($verifica);
                // die('verifica');
                if (!$verifica) {
                    $this->Session->setFlash("Estudante não estágiario");
                    $this->redirect("/Alunonovos/view?registro=" . $this->Session->read('numero'));
                } else {
                    if ($this->Session->read('numero') != $verifica['Aluno']['registro']) {
                        $this->Session->setFlash("Acesso não autorizado");
                        $this->redirect("/Murals/index");
                        die("Não autorizado");
                    }
                }
            }

            if ($id):
                $instituicao = $this->Aluno->find('first', [
                    'conditions' => ['Aluno.id' => $id]
                ]);
            elseif ($registro):
                $instituicao = $this->Aluno->find('first', [
                    'conditions' => ['Aluno.registro' => $registro]
                ]);
            endif;
            // pr($instituicao);
            // die('instituicao');

            $aluno = $instituicao['Aluno'];
            $estagios = $instituicao['Estagiario'];

            if ($id):
                $instituicoes = $this->Aluno->Estagiario->find('all', [
                    'conditions' => ['Estagiario.id_aluno' => $id]
                ]);
            elseif ($registro):
                $instituicoes = $this->Aluno->Estagiario->find('all', [
                    'conditions' => ['Estagiario.registro' => $registro]
                ]);
            endif;
            // pr($instituicoes);
            // die('instituicoes');
            // Para ordernar o array por nivel de estágio
            $i = 0;
            $y = 0;
            foreach ($instituicoes as $c_instituicao) {

                // pr($c_instituicao);
                // die('c_instituicao');

                if ($c_instituicao['Estagiario']['nivel'] < 9):

                    $ordem = 'nivel';
                    $c_estagios[$i]['id'] = $c_instituicao['Estagiario']['id'];
                    $c_estagios[$i]['periodo'] = $c_instituicao['Estagiario']['periodo'];
                    $c_estagios[$i]['complemento_periodo_especial'] = $c_instituicao['Complemento']['periodo_especial'];
                    $c_estagios[$i]['nivel'] = $c_instituicao['Estagiario']['nivel'];
                    $c_estagios[$i]['turno'] = $c_instituicao['Estagiario']['turno'];
                    $c_estagios[$i]['tc'] = $c_instituicao['Estagiario']['tc'];
                    $c_estagios[$i]['id_instituicao'] = $c_instituicao['Instituicao']['id'];
                    $c_estagios[$i]['instituicao'] = $c_instituicao['Instituicao']['instituicao'];
                    $c_estagios[$i]['id_professor'] = $c_instituicao['Professor']['id'];
                    $c_estagios[$i]['professor'] = $c_instituicao['Professor']['nome'];
                    $c_estagios[$i]['id_supervisor'] = $c_instituicao['Supervisor']['id'];
                    $c_estagios[$i]['supervisor'] = $c_instituicao['Supervisor']['nome'];
                    $c_estagios[$i]['id_area'] = $c_instituicao['Area']['id'];
                    $c_estagios[$i]['area'] = $c_instituicao['Area']['area'];
                    $c_estagios[$i]['nota'] = $c_instituicao['Estagiario']['nota'];
                    $c_estagios[$i]['ch'] = $c_instituicao['Estagiario']['ch'];
                    $criterio[$i] = $c_estagios[$i][$ordem];

                    $i++;

                elseif ($c_instituicao['Estagiario']['nivel'] == 9):

                    $ordem = 'periodo';
                    // die('periodo');
                    $nao_estagios[$y]['id'] = $c_instituicao['Estagiario']['id'];
                    $nao_estagios[$y]['periodo'] = $c_instituicao['Estagiario']['periodo'];
                    $nao_estagios[$y]['complemento_periodo_especial'] = $c_instituicao['Complemento']['periodo_especial'];
                    $nao_estagios[$y]['nivel'] = $c_instituicao['Estagiario']['nivel'];
                    $nao_estagios[$y]['turno'] = $c_instituicao['Estagiario']['turno'];
                    $nao_estagios[$y]['tc'] = $c_instituicao['Estagiario']['tc'];
                    $nao_estagios[$y]['id_instituicao'] = $c_instituicao['Instituicao']['id'];
                    $nao_estagios[$y]['instituicao'] = $c_instituicao['Instituicao']['instituicao'];
                    $nao_estagios[$y]['id_professor'] = $c_instituicao['Professor']['id'];
                    $nao_estagios[$y]['professor'] = $c_instituicao['Professor']['nome'];
                    $nao_estagios[$y]['id_supervisor'] = $c_instituicao['Supervisor']['id'];
                    $nao_estagios[$y]['supervisor'] = $c_instituicao['Supervisor']['nome'];
                    $nao_estagios[$y]['id_area'] = $c_instituicao['Area']['id'];
                    $nao_estagios[$y]['area'] = $c_instituicao['Area']['area'];
                    $nao_estagios[$y]['nota'] = $c_instituicao['Estagiario']['nota'];
                    $nao_estagios[$y]['ch'] = $c_instituicao['Estagiario']['ch'];
                    // $nao_criterio[$y] = $nao_estagios[$y][$ordem];
                    $y++;

                endif;
            }
            // pr(array_column($c_estagios, 'nivel'));
            // die('array_column');
            array_multisort(array_column($c_estagios, 'nivel'), SORT_ASC, $c_estagios);
            // array_multisort($criterio, SORT_ASC, $c_estagios);
            if (isset($nao_estagios) && !(empty($nao_estagios))):
                array_multisort(array_column($nao_estagios, 'periodo'), SORT_ASC, $nao_estagios);
                $this->set('nao_obrigatorio', $nao_estagios);
            endif;
            // pr($c_estagios);
            // pr($nao_estagios);

            $this->set('c_estagios', $c_estagios);

            // $this->set('alunos', $this->paginate('Aluno', array('id'=>$id)));
            $this->set('alunos', $aluno);
            $this->set('estagios', $estagios);
        }
    }

    /**
     * imprimepdf method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function imprimepdf($id = null) {

        $estagiario_id = $this->request->query('estagiario_id');
        // echo 'estagiario_id ' . $estagiario_id . "<br>";
        if ($estagiario_id) {
            $this->Session->write('estagiario_id', $estagiario_id);
        } else {
            $this->Session->setFlash(__('Sem parâmetros para imprimir a folha de atividades'));
            $this->redirect(['controller' => 'folhadeatividades', 'action' => 'busca_dre']);
        }

        // $options = array('conditions' => array('Folhadeatividade.' . $this->Folhadeatividade->primaryKey => $id));
        $options = array('conditions' => array('Folhadeatividade.estagiario_id' => $estagiario_id), 'order' => 'dia');
        $folhadeatividade = $this->Folhadeatividade->find('first', $options);
        // pr($folhadeatividades);
        // die();
        if (empty($folhadeatividade)) {
            $this->Session->setFlash(__('Sem folha de atividades cadastrada'));
            $this->redirect('/folhadeatividades/addatividade?estagiario_id=' . $estagiario_id);
        }

        /* Para pegar o nome e o id do estagiario */
        $this->loadModel('Aluno');
        $this->set('estudante', $this->Aluno->find('first', ['conditions' => ['Aluno.id' => $folhadeatividade['Estagiario']['id_aluno']]]));
        $this->Folhadeatividade->recursive = 2;
        $this->set('folhadeatividades', $this->Folhadeatividade->find('all', $options));
    }

    /**
     * atividade method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function atividade($id = null) {

        $estagiario_id = $this->request->query('estagiario_id');
        if ($estagiario_id) {
            $this->Session->write('estagiario_id', $estagiario_id);
        } else {
            $this->Session->setFlash(__('Sem parâmetros para localizar a folha de atividades'));
            $this->redirect(['controller' => 'folhadeatividades', 'action' => 'busca_dre']);
        }

        // $options = array('conditions' => array('Folhadeatividade.' . $this->Folhadeatividade->primaryKey => $id));
        $options = array('conditions' => array('Folhadeatividade.estagiario_id' => $estagiario_id), 'order' => 'dia');
        $folhadeatividades = $this->Folhadeatividade->find('all', $options);
        // pr($folhadeatividades);
        // die();
        if (empty($folhadeatividades)) {
            $this->Flash->error(__('Sem folha de atividades cadastrada'));
            if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '2' || $this->Session->read('id_categoria') == '4') {
                $this->redirect('/folhadeatividades/addatividade?estagiario_id=' . $estagiario_id);
            } else {
                // die();
                $this->redirect('/estagiarios/view/' . $estagiario_id);
            }
        }

        $this->Folhadeatividade->recursive = 2;
        $this->set('folhadeatividades', $this->Folhadeatividade->find('all', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($id = NULL) {

        $estagiario_id = $this->request->query('estagiario_id');
        if ($estagiario_id) {
            $this->Session->write('estagiario_id', $estagiario_id);
        } else {
            $this->Session->setFlash(__('Sem parâmetros para preencher a folha de atividades'));
            $this->redirect(['controller' => 'folhadeatividades', 'action' => 'busca_dre']);
        }

        if ($estagiario_id) {
            // die('estagiario_id');
            $this->loadModel('Estagiario');
            $aluno = $this->Estagiario->find('first', ['conditions' => ['Estagiario.id' => $estagiario_id]]);
            $this->set('aluno_id', $aluno['Aluno']['id']);
            $this->set('aluno', $aluno['Aluno']['nome']);
            $this->set('estagiario_id', $estagiario_id);
            // die();
        }

        if ($this->Session->read('id_categoria') == '2') {

            $verifica = $this->Estagiario->find('first', ['conditions' => ['Estagiario.registro' => $this->Session->read('numero')]]);
            if ($estagiario_id != $verifica['Estagiario']['id']) {
                $this->Flash->error(__('Não autorizado'));
                $this->redirect('/Estagiarios/index');
            }
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Flash->error(__('Não autorizado'));
            $this->redirect('/Estagiarios/index');
        }

        if ($this->request->is('post')) {
            // pr($this->request->data);
            // die();
            $this->Folhadeatividade->create();
            if ($this->Folhadeatividade->save($this->request->data)) {
                $this->Flash->success(__('Atividade registrada.'));
                return $this->redirect(array('action' => 'atividade', "?" => ['estagiario_id' => $estagiario_id]));
            } else {
                $this->Flash->error(__('Atividade no foi registrada. Tente novamente.'));
            }
        }
        $estagiarios = $this->Folhadeatividade->Estagiario->find('list');
        $this->set(compact('estagiarios'));
    }

    /**
     * addatividade method
     *
     * @return void
     */
    public function addatividade($id = NULL) {

        $estagiario_id = $this->request->query('estagiario_id');
        if ($estagiario_id) {
            $this->Session->write('estagiario_id', $estagiario_id);
        } else {
            $this->Session->setFlash(__('Sem parâmetros para imprimir a folha de atividades'));
            $this->redirect(['controller' => 'folhadeatividades', 'action' => 'busca_dre']);
        }

        if ($estagiario_id) {
            $this->loadModel('Estagiario');
            $aluno = $this->Estagiario->find('first', ['conditions' => ['Estagiario.id' => $estagiario_id]]);
            // pr($aluno);
            // die();
            $this->set('estagiario', $aluno);
            $this->set('aluno_id', $aluno['Aluno']['id']);
            $this->set('aluno', $aluno['Aluno']['nome']);
            $this->set('estagiario_id', $aluno['Estagiario']['id']);
        }

        // Verifica
        if ($this->Session->read('id_categoria') == '2') {

            $verifica = $this->Estagiario->find('first', ['conditions' => ['Estagiario.registro' => $this->Session->read('numero')]]);
            if ($estagiario_id != $verifica['Estagiario']['id']) {
                $this->Flash->error(__('Não autorizado'));
                $this->redirect('/Estagiarios/index');
            }
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Flash->error(__('Não autorizado'));
            $this->redirect('/Estagiarios/index');
        }

        if ($this->request->is('post')) {
            // pr($this->request->data);
            // die();
            $this->Folhadeatividade->create();
            if ($this->Folhadeatividade->save($this->request->data)) {
                $this->Flash->success(__('Atividade inserida.'));
                return $this->redirect(array('action' => 'addatividade?estagiario_id=' . $estagiario_id));
            } else {
                $this->Flash->error(__('Processo falhou. Tente novamente.'));
            }
        }
        $this->Folhadeatividade->recursive = 2;
        $folhadeatividades = $this->Folhadeatividade->find('all', ['conditions' => ['Folhadeatividade.estagiario_id' => $estagiario_id], 'order' => 'dia']);
        $this->set(compact('folhadeatividades'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        if (!$this->Folhadeatividade->exists($id)) {
            throw new NotFoundException(__('Invalid folhadeatividade'));
        }

        // Verifica
        if ($this->Session->read('id_categoria') == '2') {

            $this->loadModel('Estagiario');
            $verifica = $this->Folhadeatividade->find('first', ['conditions' => ['Folhadeatividade.id' => $id]]);
            if ($this->Session->read('numero') != $verifica['Estagiario']['registro']) {
                $this->Flash->error(__('Não autorizado'));
                $this->redirect('/Estagiarios/index');
            }
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Flash->error(__('Não autorizado'));
            $this->redirect('/Estagiarios/index');
        }

        if ($this->request->is(array('post', 'put'))) {
            // pr($this->request->data);
            // die();
            if ($this->Folhadeatividade->save($this->request->data)) {
                $this->Flash->success(__('Folha de atividades atualizada.'));
                return $this->redirect(array('action' => 'atividade?estagiario_id=' . $this->request->data['Folhadeatividade']['estagiario_id']));
            } else {
                $this->Flash->error(__('Folha de atividades não foi atualizada. Tente outra vez.'));
                return $this->redirect(array('action' => 'atividade?estagiario_id=' . $this->request->data['Folhadeatividade']['estagiario_id']));
            }
        } else {
            $options = array('conditions' => array('Folhadeatividade.' . $this->Folhadeatividade->primaryKey => $id));
            $this->request->data = $this->Folhadeatividade->find('first', $options);
        }
        $this->Folhadeatividade->recursive = 2;
        $estagiarios = $this->Folhadeatividade->find('first', ['conditions' => ['Folhadeatividade.id' => $id]]);
        $this->set(compact('estagiarios'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {

        if (!$this->Folhadeatividade->exists($id)) {
            throw new NotFoundException(__('Invalid folhadeatividade'));
        }
        $this->request->allowMethod('post', 'delete');
        $estagiario_id = $this->Folhadeatividade->find('first', ['conditions' => ['Folhadeatividade.id' => $id]]);
        if ($this->Folhadeatividade->delete($id)) {
            $this->Flash->success(__('Atividade excluída.'));
        } else {
            $this->Flash->error(__('Atividade não foi excluída. Tente novamente.'));
        }
        return $this->redirect(array('action' => 'atividade?estagiario_id=' . $estagiario_id['Folhadeatividade']['estagiario_id']));
    }

}
