<?php

App::uses('AppController', 'Controller');
/**
 * Avaliacoes Controller
 *
 * @property Avaliacao $Avaliacao
 * @property PaginatorComponent $Paginator
 */
class AvaliacoesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash', 'Auth', 'RequestHandler');

    public function beforeFilter()
    {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Flash->success(__("Administrador"));
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('view', 'imprimepdf', 'historico', 'busca_dre');
            // $this->Flash->success(__("Estudante"));
            // Professor
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('index', 'view', 'historico', 'view', 'busca_dre', 'imprimepdf');
            // $this->Flash->success(__("Professor"));
            // Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('add', 'historico', 'index', 'view', 'edit', 'delete', 'busca_dre', 'imprimepdf');
            // $this->Flash->success(__("Supervisor"));
            // $this->Auth->allow();
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
    public function index()
    {

        $this->Paginator->settings = [
            'Avaliacao' => [
                'order' => ['estagiario_id'],
                'limit' => 10
            ]
        ];

        $this->Avaliacao->recursive = 2;
        $this->set('avaliacoes', $this->Paginator->paginate('Avaliacao'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {

        // die('view');
        if (!is_numeric($id)) {
            $estagiario_id = $this->request->query('estagiario_id');
            // pr($estagiario_id);
            // die();
            if ($estagiario_id) {
                $avaliacao = $this->Avaliacao->find('first', [
                    'conditions' => ['Avaliacao.estagiario_id' => $estagiario_id]
                ]);
                // pr($avaliacao);
                // die();
                if ($avaliacao) {
                    $id = $avaliacao['Avaliacao']['id'];
                } else {
                    $this->Flash->error(__('Estudante sem avaliação'));
                    if ($this->Session->read('id_categoria') == '4'):
                        $this->redirect(['controller' => 'avaliacoes', 'action' => 'add?estagiario_id=' . $estagiario_id]);
                    else:
                        $this->redirect(['controller' => 'estagiarios', 'action' => 'view/' . $estagiario_id]);
                    endif;
                }
                $this->Session->write('estagiario_id', $estagiario_id);
            } else {
                $this->Flash->error(__('Sem parâmetros para localizar o período de avaliação'));
                $this->redirect(['controller' => 'avaliacoes', 'action' => 'busca_dre']);
            }
        }
        // pr($id);
        // die();

        $this->Avaliacao->recursive = 2;
        $avaliacao = $this->Avaliacao->find('first', [
            'conditions' => ['Avaliacao.id' => $id]
        ]);
        // pr($avaliacao);
        // die();

        if (empty($avaliacao)): // Sem avaliação
            // die('Estudante sem avaliacao');
            $this->Flash->error(__("Estudante sem avaliação"));
            if ($this->Session->read('id_categoria') != '2') {
                $this->redirect('/avaliacoes/add?estagiario_id=' . $estagiario_id);
            } else {
                $this->redirect('/estagiarios/view/' . $estagiario_id);
                die('estagiario');
            }
        else: // Com avaliação
            if (isset($avaliacao['Estagiario']['Supervisor']['nome'])) {
                $this->set('supervisor', $avaliacao['Estagiario']['Supervisor']['nome']);
            } else {
                $this->Flash->error(__('Completar dados da supervisora'));
            }
        endif;
        // $log = $this->Avaliacao->getDataSource()->getLog(false, false);
        // debug($log);
        $options = array('conditions' => array('Avaliacao.' . $this->Avaliacao->primaryKey => $avaliacao['Avaliacao']['id']));
        $this->set('avaliacao', $this->Avaliacao->find('first', $options));
    }

    /**
     * imprimepdf method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function imprimepdf($id = null)
    {

        if (!is_numeric($id)) {

            $estagiario_id = $this->request->query('estagiario_id');
            if ($estagiario_id) {
                $avaliacao = $this->Avaliacao->find('first', [
                    'conditions' => ['Avaliacao.estagiario_id' => $estagiario_id]
                ]);
                if ($avaliacao) {
                    $id = $avaliacao['Avaliacao']['id'];
                }
                $this->Session->write('estagiario_id', $estagiario_id);
            } else {
                $this->Flash->error(__('Sem parâmetros para localizar o período de avaliação'));
                $this->redirect(['controller' => 'avaliacoes', 'action' => 'busca_dre']);
            }
        }
        // pr($estagiario_id);
        // die();
        $this->Avaliacao->recursive = 2;
        $avaliacao = $this->Avaliacao->find('first', [
            'conditions' => ['Avaliacao.id' => $id]
        ]);
        // pr($avaliacao);
        // die();

        if (empty($avaliacao)): // Sem avaliação
            // die('Estudante sem avaliacao');
            $this->Flash->error(__("Estudante sem avaliação"));
            if ($this->Session->read('id_categoria') != '2') {
                $this->redirect('/avaliacoes/add?estagiario_id=' . $estagiario_id);
            } else {
                $this->redirect('/estagiarios/view/' . $estagiario_id);
                die('estagiario');
            }
        else: // Com avaliação
            if (isset($avaliacao['Estagiario']['Supervisor']['nome'])) {
                $this->set('supervisor', $avaliacao['Estagiario']['Supervisor']['nome']);
            } else {
                $this->Flash->error(__('Completar dados da supervisora'));
            }
        endif;
        // $log = $this->Avaliacao->getDataSource()->getLog(false, false);
        // debug($log);
        $options = array('conditions' => array('Avaliacao.' . $this->Avaliacao->primaryKey => $avaliacao['Avaliacao']['id']));
        $this->set('avaliacao', $this->Avaliacao->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {

        $estagiario_id = $this->request->query('estagiario_id');
        // pr($estagiario_id);
        // die('estagiario_id');
        // Se o periodo não veio como parametro

        $this->loadModel('Estagiario');
        // $this->contain('Aluno');
        $estagiario = $this->Estagiario->findFirstById($estagiario_id);
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($estagiario);
        // die('estagiario');
        $this->set('estagiario', $estagiario);

        $dia = strftime('%e', time());
        $mes = utf8_encode(strftime('%B', time()));
        $ano = strftime('%Y', time());

        $this->set('dia', $dia);
        $this->set('mes', $mes);
        $this->set('ano', $ano);

        if ($this->request->is('post')) {

            /* Verifico que não tenha uma avaliação já realzada */
            // pr($this->request->data);
            $avaliacao = $this->Avaliacao->find('first', [
                'conditions' => ['Avaliacao.estagiario_id' => $this->request->data['Avaliacao']['estagiario_id']]
            ]);
            // $log = $this->Avaliacao->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($avaliacao);
            // die('avaliacao');

            if ($avaliacao) {
                // pr($avaliacao);
                // echo "aluno já avaliado";
                $this->Flash->error(__('Estudante já tem avaliação para este periódo de estágio!'));
                $this->redirect(array('action' => 'view/' . $avaliacao['Avaliacao']['id']));
                die();
            }
            /* Fim da verificação */

            $this->Avaliacao->create();
            // pr($this->request->data);
            // die();
            if ($this->Avaliacao->save($this->request->data)) {
                $this->Flash->success(__('Avaliação realizada!'));
                return $this->redirect(array('action' => 'view/' . $this->Avaliacao->id));
                die();
            } else {
                $this->Flash->error(__('Não foi possível completar a oporação. Tente novamente.'));
            }
        }
        // $estagiarios = $this->Avaliacao->Estagiario->find('list');
        $this->set('estagiario_id', $estagiario_id);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {

        if (!is_numeric($id)) {
            $estagiario_id = $this->request->query('estagiario_id');
            if ($estagiario_id) {
                $estagiario = $this->Avaliacao->find('first', [
                    'conditions' => ['Avaliacao.estagiario_id' => $estagiario_id]
                ]);
                if ($estagiario) {
                    $id = $estagiario['Avaliacao']['id'];
                }
            }
        }

        if (!$this->Avaliacao->exists($id)) {
            throw new NotFoundException(__('Invalid avaliacao'));
        }

        if ($this->request->is(array('post', 'put'))) {
            // pr($this->request->data);
            // die();
            if ($this->Avaliacao->save($this->request->data, false)) {
                $this->Flash->success(__('Avaliação atualizada.'));
                return $this->redirect(array('action' => 'view/' . $id));
            } else {
                $this->Flash->error(__('Não foi possível completar a operação. Tente novamente.'));
            }
        } else {
            $options = array('conditions' => array('Avaliacao.' . $this->Avaliacao->primaryKey => $id));
            $this->request->data = $this->Avaliacao->find('first', $options);
        }
        $this->Avaliacao->recursive = 2;
        $estagiario = $this->Avaliacao->find('first', [
            'conditions' => ['Avaliacao.id' => $id],
        ]);
        // pr($estagiario);
        // die();
        $this->set(compact('estagiario'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {

        if (!$this->Avaliacao->exists($id)) {
            throw new NotFoundException(__('Registro não existe'));
        }

        // $this->request->allowMethod('post', 'delete');
        if ($this->Avaliacao->delete($id)) {
            $this->Flash->success(__('Avaliação excluída.'));
        } else {
            $this->Flash->error(__('Não foi possível completar a ação. Tente novamente.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function busca_dre()
    {

        if (!empty($this->data['Aluno']['registro'])) {
            $this->loadModel('Aluno');
            $alunos = $this->Aluno->findFirstByRegistro($this->data['Aluno']['registro']);
            // pr($alunos);
            // die();
            if (empty($alunos)) {
                // Teria que buscar na tabela alunos_novos
                $this->loadModel('Alunonovo');
                $alunonovos = $this->Alunonovo->findFirstByRegistro($this->data['Aluno']['registro']);
                // pr($alunonovos);
                // die();
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros do estudante"));
                    $this->redirect(['controller' => 'alunos', 'action' => 'busca']);
                    die();
                } else {
                    $this->Flash->error(__("Estudante sem estágios"));
                    // $this->redirect(['controller' => 'alunonovos', 'action' => 'view', '?' => 'registro', $this->Session->read('numero')]);
                    $this->redirect('/alunonovos/view?registro=' . $this->Session->read('numero'));
                    die();
                }
            } else {
                $this->set('alunos', $alunos);
                $this->redirect('/Avaliacoes/historico?registro=' . $alunos['Aluno']['registro']);
                die();
            }
        }
    }

    public function historico($id = NULL)
    {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
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
                    $this->Flash->error(__("Estudante não estágiario"));
                    $this->redirect("/Alunonovos/view?registro=" . $this->Session->read('numero'));
                } else {
                    if ($this->Session->read('numero') != $verifica['Aluno']['registro']) {
                        $this->Flash->error(__("Acesso não autorizado"));
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

}