<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EstagiariosController extends AppController
{

    public $name = 'Estagiarios';
    public $components = ['Auth', 'Paginator', 'RequestHandler', 'Flash'];
    // var $scaffold;
    // var $helpers = array('Javascript');
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Alunonovo.nome' => 'asc'
        ]
    ];

    public function beforeFilter()
    {

        parent::beforeFilter();
        // echo $this->Session->read('id_cateogria');
        // die();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Flash->usuario(__("Administrador"));
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('declaracaoestagio', 'declaracaoestagiopdf', 'index', 'view');
            // $this->Flash->success(__("Estudante"));
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('index', 'view', 'edit', 'declaracaoestagio', 'declaracaoestagiopdf');
            // $this->Flash->success(__("Professor"));
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('index', 'view', 'declaracaoestagio', 'declaracaoestagiopdf');
            // $this->Flash->success(__("Supervisor"));
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index');
        }
        // die(pr($this->Session->read('user')));
    }

    private function periodo($periodo = null, $condicoes = null)
    {

        // Para fazer a lista para o select dos estagios anteriores
        $periodos_estagio = $this->Estagiario->find(
            'list',
            [
                'fields' => ['Estagiario.periodo', 'Estagiario.periodo'],
                'group' => ('Estagiario.periodo'),
                'order' => ['Estagiario.periodo' => 'DESC']
            ]
        );
        // pr($periodos_estagio);
        // die();
        // pr($periodo);
        // pr("Período: ", $periodo);
        // Guardo o valor do periodo (incluso quando eh 0) ate que seja selecionado outro periodo
        if ($periodo == null) {
            // echo "Período NULL";
            // die("Período NULL");
            $periodo = $this->Session->read("periodo");
            if ($periodo) {
                $condicoes['periodo'] = $periodo;
            } else {
                $condicoes['periodo'] = reset($periodos_estagio); // periodo atual (primeiro da lista)
                $this->Session->write("periodo", reset($periodos_estagio));
                $periodo = $this->Session->read("periodo");
            }
        } elseif ($periodo == '0') { // Periodo 0 quer dizer todos os períodos
            /* Todos os periodos */
            // echo "Período 0";
            // die("Período 0");
            $this->Session->delete("periodo");
        } else {
            // $periodoatual = reset($periodos_total);
            //pr($periodoatual);
            //die("Período atual");
            $this->Session->write("periodo", $periodo);
            $condicoes['periodo'] = $periodo;
        }
        // pr($periodo);
        // pr($condicoes);
        // die();
        $this->set('periodo', $periodo);
        $this->set('periodos_total', $periodos_estagio);

        return [$periodo, $condicoes];
    }

    public function index()
    {

        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;
        $complemento_periodo_especial = isset($parametros['complemento_periodo_especial']) ? $parametros['complemento_periodo_especial'] : null;
        $id_area = isset($parametros['id_area']) ? $parametros['id_area'] : null;
        # $id_aluno = isset($parametros['id_aluno']) ? $parametros['id_aluno'] : null;
        $id_professor = isset($parametros['id_professor']) ? $parametros['id_professor'] : null;
        $id_instituicao = isset($parametros['id_instituicao']) ? $parametros['id_instituicao'] : null;
        $id_supervisor = isset($parametros['id_supervisor']) ? $parametros['id_supervisor'] : null;
        $nivel = isset($parametros['nivel']) ? $parametros['nivel'] : null;
        $turno = isset($parametros['turno']) ? $parametros['turno'] : null;

        // pr($periodo);
        // die();
        /* Professor tem como número o siape */
        $siape = $this->request->query('siape');
        if ($siape) {
            $this->loadModel('Professor');
            $professor = $this->Professor->find('first', [
                'conditions' => ['Professor.siape' => $siape]
            ]);
            if ($professor) {
                $id_professor = $professor['Professor']['id'];
            }
        }
        // pr($siape);
        // pr($id_professor);

        /* Supervisor tem como número o cress */
        $cress = $this->request->query('cress');
        if ($cress) {
            $this->loadModel('Supervisor');
            $supervisor = $this->Supervisor->find('first', [
                'conditions' => ['Supervisor.cress' => $cress]
            ]);
            if ($supervisor) {
                $id_supervisor = $supervisor['Supervisor']['id'];
            }
        }
        // pr($cress);
        // echo "id_supervisor1 " . $id_supervisor;
        if (is_null($id_supervisor)) {
            // die('empty');
            $id_supervisor = $this->request->query('id_supervisor');
        }
        // echo "id_supervisor2 " . $id_supervisor;
        // die();
        // pr($registro);
        //  pr($alunonovoId);

        if (!(isset($nivel))) {
            // die('nivel empty');
            $nivel = $this->request->query('nivel');
        }
        // pr($nivel);
        // die('nivel');

        $condicoes = null;

        /* Função periodo */
        $periodos = $this->periodo($periodo, $condicoes);
        // pr($periodos);
        $periodo = $periodos[0];
        $condicoes = $periodos[1];
        // die();

        /* Complemento periodo especial */
        // Capturo o complemento do periodo_especial. Construido por causa da pandemia de 2020
        $complemento_periodo_especial_total = $this->Estagiario->Complemento->find('list');
        // Guardo o valor do periodo_especial ate que seja selecionado outro
        if ($complemento_periodo_especial == null) {
            $complemento_periodo_especial = $this->Session->read("complemento_periodo_especial");
            if ($complemento_periodo_especial) {
                $condicoes['Estagiario.complemento_id'] = $complemento_periodo_especial;
            }
        } elseif ($complemento_periodo_especial == 0) {
            $this->Session->delete("complemento_periodo_especial");
        } else {
            $this->Session->write("complemento_periodo_especial", $complemento_periodo_especial);
            $condicoes['Estagiario.complemento_id'] = $complemento_periodo_especial;
        }
        $this->set('complemento_periodo_especial', $complemento_periodo_especial);
        $this->set('complemento_periodo_especial_total', $complemento_periodo_especial_total);

        /* Áreas */
        $areas = $this->Estagiario->Area->find(
            'list',
            [
                'fields' => ['Area.area'],
                'order' => 'Area.area'
            ]
        );
        // Guardo o valor do id_area ate que seja selecionada outra
        if ($id_area == null) {
            $id_area = $this->Session->read("estagiario_id_area");
            if ($id_area) {
                $condicoes['Estagiario.id_area'] = $id_area;
            }
        } elseif ($id_area == 0) {
            $this->Session->delete("estagiario_id_area");
        } else {
            $this->Session->write("estagiario_id_area", $id_area);
            $condicoes['Estagiario.id_area'] = $id_area;
        }
        $this->set('id_area', $id_area);
        $this->set('areas', $areas);

        /* Professores que orientaram estagiarios */
        $options['joins'] = [
            [
                'table' => 'estagiarios',
                'alias' => 'Estagiario',
                'type' => 'RIGHT',
                'conditions' => ['Professor.id = Estagiario.id_professor']
            ]
        ];
        $options['order'] = ['Professor.nome'];
        $professores = $this->Estagiario->Professor->find(
            'list',
            $options
        );
        // Guardo o valor do id_professor ate que seja selecionado outro
        if ($id_professor == null) {
            $id_professor = $this->Session->read("estagiario_id_professor");
            if ($id_professor) {
                $condicoes['Estagiario.id_professor'] = $id_professor;
            }
        } elseif ($id_professor == 0) {
            $this->Session->delete("estagiario_id_professor");
        } else {
            $this->Session->write("estagiario_id_professor", $id_professor);
            $condicoes['Estagiario.id_professor'] = $id_professor;
        }
        $this->set('id_professor', $id_professor);
        $this->set('professores', $professores);

        /* Instituicoes */
        $instituicoes = $this->Estagiario->Instituicao->find(
            'list',
            [
                'fields' => ['Instituicao.instituicao'],
                'order' => ['Instituicao.instituicao']
            ]
        );
        // Guardo o valor do id_instituicao ate que seja selecionado outro
        if ($id_instituicao == null) {
            $id_instituicao = $this->Session->read("estagiario_id_instituicao");
            if ($id_instituicao) {
                $condicoes['Estagiario.id_instituicao'] = $id_instituicao;
            }
        } elseif ($id_instituicao == 0) {
            $id_instituicao = $this->Session->delete("estagiario_id_instituicao");
        } else {
            $this->Session->write("estagiario_id_instituicao", $id_instituicao);
            $condicoes['Estagiario.id_instituicao'] = $id_instituicao;
        }
        $this->set('id_instituicao', $id_instituicao);
        $this->set('instituicoes', $instituicoes);

        /* Supervisores */
        $supervisores = $this->Estagiario->Supervisor->find(
            'list',
            [
                'fields' => ['Supervisor.nome'],
                'order' => ['Supervisor.nome']
            ]
        );
        // Guardo o valor do id_supervisor ate que seja selecionado outro
        if ($id_supervisor === null) {
            $id_supervisor = $this->Session->read("estagiario_id_supervisor");
            if ($id_supervisor) {
                $condicoes['Estagiario.id_supervisor'] = $id_supervisor;
            }
        } elseif ($id_supervisor == 0) {
            $this->Session->delete("estagiario_id_supervisor");
        } else {
            $this->Session->write("estagiario_id_supervisor", $id_supervisor);
            $condicoes['Estagiario.id_supervisor'] = $id_supervisor;
        }
        // pr($id_supervisor);
        // die();
        $this->set('id_supervisor', $id_supervisor);
        $this->set('supervisores', $supervisores);

        /* Nivel */
        // Guardo o valor do nivel de estágio ate que seja selecionado outro
        if ($nivel == null) {
            $nivel = $this->Session->read("estagiario_nivel");
            if ($nivel) {
                $condicoes['Estagiario.nivel'] = $nivel;
            }
        } elseif ($nivel == 0) {
            $this->Session->delete("estagiario_nivel");
        } else {
            $this->Session->write("estagiario_nivel", $nivel);
            $condicoes['Estagiario.nivel'] = $nivel;
        }
        $this->set('nivel', $nivel);
        $this->set('nivels', array('niveis' => '1', '2', '3', '4', '9'));

        /* Turno */
        // Guardo o turno do estágio ate que seja selecionado outro
        if ($turno == null) {
            $turno = $this->Session->read("estagiario_turno");
            if ($turno) {
                $condicoes['Estagiario.turno'] = $turno;
            }
        } elseif ($turno == '0') {
            $this->Session->delete("estagiario_turno");
        } else {
            $this->Session->write("estagiario_turno", $turno);
            $condicoes['Estagiario.turno'] = $turno;
        }
        $this->set('turno', $turno);
        $this->set('turnos', array('turnos' => 'D', 'N'));

        if (isset($condicoes)) {
            // pr($condicoes);
            // die();
        }
        if (isset($condicoes)) {
            $this->set('estagiarios', $this->Paginate($condicoes));
        } else {
            $this->set('estagiarios', $this->Paginate('Estagiario'));
        }
    }

    public function email()
    {
        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;

        // Para fazer a lista para o select dos estagios anteriores
        $this->Estagiario->contain();
        $periodos_estagio = $this->Estagiario->find(
            'list',
            [
                'fields' => ['Estagiario.periodo', 'Estagiario.periodo'],
                'group' => ('Estagiario.periodo'),
                'order' => ['Estagiario.periodo' => 'DESC']
            ]
        );

        if (empty($periodo)) {
            $periodo = reset($periodos_estagio);
        }

        $this->set('periodos', $periodos_estagio);
        $this->set('periodo', $periodo);
        $this->Paginator->settings = [
            'conditions' => ['Estagiario.periodo' => $periodo],
            'order' => ['Alunonovo.nome']
        ];
        $this->set('email', $this->Paginator->paginate('Estagiario'));
        // pr($emails);
        // die();
    }

    public function emailsupervisor()
    {
        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : null;

        // Para fazer a lista para o select dos estagios anteriores
        $this->Estagiario->contain();
        $periodos_estagio = $this->Estagiario->find(
            'list',
            [
                'fields' => ['Estagiario.periodo', 'Estagiario.periodo'],
                'group' => ('Estagiario.periodo'),
                'order' => ['Estagiario.periodo' => 'DESC']
            ]
        );

        if (empty($periodo)) {
            $periodo = reset($periodos_estagio);
        }

        $this->set('periodos', $periodos_estagio);
        $this->set('periodo', $periodo);
        $this->Paginator->settings = [
            'conditions' => ['Estagiario.periodo' => $periodo],
            'group' => ['Estagiario.id_supervisor'],
            'order' => ['Supervisor.nome']
        ];
        $this->set('email', $this->Paginator->paginate('Estagiario'));
        // pr($emails);
        // die();
    }


    public function lista()
    {

        $parametros = $this->params['named'];
        // pr($parametros);
        $sort = isset($parametros['sort']) ? $parametros['sort'] : null;
        $direcao = isset($parametros['direction']) ? $parametros['direction'] : null;

        if (is_null($sort)) {
            $sort = 'nome';
            $direcao = 'asc';
        }

        $periodo = $this->request->query('periodo');
        if (is_null($periodo)) {
            $periodo = $this->request->query('periodo');
        }
        // die();
        /* Função periodo */
        $condicoes = null;
        $periodos = $this->periodo($periodo, $condicoes);
        $periodo = $periodos[0];
        // $condicoes = $periodos[1];

        if ($periodo == 0) {
            $this->loadModel('Configuracao');
            $configuracoes = $this->Configuracao->find('first');
            $periodo = $configuracoes['Configuracao']['mural_periodo_atual'];
        }
        $periodo_atual = $periodo;
        $ano_semestre = explode('-', $periodo_atual);
        if ($ano_semestre[1] == 1) {
            $ano = intval($ano_semestre[0]) - 1;
            $semestre = intval($ano_semestre[1]) + 1;
            $periodo_anterior = $ano . '-' . $semestre;
        } elseif ($ano_semestre[1] == 2) {
            $ano = intval($ano_semestre[0]);
            $semestre = intval($ano_semestre[1]) - 1;
            $periodo_anterior = $ano . '-' . $semestre;
        }
        // $anosemestre = $ano_semestre[0] . $ano_semestre[1];
        // pr($anosemestre);

        $ultimo_nivel = 4;
        $this->Estagiario->contain(['Alunonovo']);
        $estagiario = $this->Estagiario->find('all', [
            'conditions' => ['periodo' => $periodo_anterior, ['NOT' => ['nivel >=' => $ultimo_nivel]]],
            'order' => [$sort => $direcao]
        ]);
        foreach ($estagiario as $c_estagiario) {
            // pr($c_estagiario);
            $this->Estagiario->contain(['Alunonovo']);
            $q_estagiario = $this->Estagiario->find('first', [
                'conditions' => ['Estagiario.registro' => $c_estagiario['Estagiario']['registro'], 'Estagiario.periodo >' => $periodo_anterior]
            ]);
            // pr($q_estagiario);
            if (empty($q_estagiario)) {
                /* Com o ajuste 2020 o último nível é 3 */
                if ($c_estagiario['Estagiario']['ajuste2020'] == 1 && $c_estagiario['Estagiario']['nivel'] >= 3) {
                    // pr($c_estagiario);
                } else {
                    // pr($c_estagiario);
                    $sem_estagio[] = $c_estagiario;
                }
                // pr($c_estagiario);
            }
        }
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($sem_estagio);
        $this->set('direcao', $direcao);
        $this->set('estagiarios', isset($sem_estagio) ? $sem_estagio : null);
    }

    public function view($id = NULL)
    {
        /*
          if (!$this->Estagiario->exists($id)) {
          throw new NotFoundException(__('Invalid Estagiário'));
          }
         */
        if (is_numeric($id)) {
            $estagio = $this->Estagiario->find(
                'first',
                [
                    'conditions' => ['Estagiario.id' => $id]
                ]
            );
        } elseif (!empty($this->request->query('registro'))) {
            $registro = $this->request->query('registro');
            $estagio = $this->Estagiario->find(
                'first',
                [
                    'conditions' => ['Estagiario.registro' => $registro]
                ]
            );
        }
        // pr($estagio);
        // die();
        if (empty($estagio)) {
            $this->Flash->error(__('Estudante sem estágio'));
            if ($registro) {
                $this->redirect(['controller' => 'alunos', 'action' => 'view', '?' => 'registro', $registro]);
            } elseif ($id) {
                $this->redirect(['controller' => 'alunos', 'action' => 'view', $id]);
            }
        }
        // pr($estagio);
        // die();
        $this->set('estagio', $estagio);
    }

    public function alunorfao()
    {

        $this->loadModel('Aluno');
        $this->Aluno->contain();
        $orfao = $this->Aluno->find(
            'all',
            [
                'order' => ['Aluno.nome']
            ]
        );
        foreach ($orfao as $c_orfao) {
            if (empty($c_orfao['Estagiario'])) {
                // pr($c_orfao['Aluno']);
                $orfaos[] = $c_orfao['Aluno'];
            }
        }
        if (empty($orfaos)) {
            $this->Flash->success(__('Não há erros no cadastramento dos estudantes de estágio'));
            $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        } else {
            $this->set('orfaos', $orfaos);
        }
    }

    public function edit($id = NULL)
    {

        if (empty($this->data)) {

            $this->Estagiario->contain(['Aluno', 'Instituicao', 'Supervisor', 'Professor', 'Area']);
            $estagiario = $this->Estagiario->find(
                'first',
                [
                    'conditions' => ['Estagiario.id' => $id],
                    'fields' => ['Estagiario.periodo', 'Estagiario.complemento_id', 'Estagiario.nivel', 'Estagiario.id_professor', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_area', 'Estagiario.nota', 'Estagiario.ch', 'Aluno.id', 'Aluno.nome', 'Instituicao.id', 'Instituicao.instituicao', 'Supervisor.id', 'Supervisor.nome', 'Professor.id', 'Professor.nome', 'Area.id', 'Area.area']
                ]
            );
            // $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($estagiario);
            // die();

            $aluno = $estagiario['Aluno']['nome'];
            // pr($aluno);
            // die('aluno');
            $this->set('aluno', $aluno);

            // Periodos para o select
            $periodos_total = $this->Estagiario->find(
                'list',
                [
                    'fields' => ['Estagiario.periodo', 'Estagiario.periodo'],
                    'group' => ('Estagiario.periodo'),
                    'order' => ('Estagiario.periodo')
                ]
            );
            // pr($periodos_total);
            // die('periodos');
            // Para acrescenter os próximos periodos carrego a configuracao do planejamento
            $this->loadModel('Configuraplanejamento');
            $periodo_planejamento = $this->Configuraplanejamento->find('all');
            // pr($periodo_planejamento);
            foreach ($periodo_planejamento as $c_periodoplanejamento) {
                // pr($c_periodoplanejamento['Configuraplanejamento']['semestre']);
                $periodos_novo[$c_periodoplanejamento['Configuraplanejamento']['semestre']] = $c_periodoplanejamento['Configuraplanejamento']['semestre'];
            }
            // pr($periodos_novo);
            // die('periodos novos');
            $semestres = array_unique(array_merge($periodos_total, $periodos_novo));
            // pr($semestres);
            // die();
            $this->set('periodos', $semestres);

            /* Instituicoes para o select. Nao colocar a opcao 0 */
            $this->loadModel('Instituicao');
            $instituicoes = $this->Instituicao->find(
                'list',
                [
                    'order' => 'Instituicao.instituicao'
                ]
            );
            asort($instituicoes);
            // pr($instituicoes);
            $this->set('instituicoes', $instituicoes);
            // die('Instituicoes');

            /* Supervisores da instituicao para o select */
            $supervisores = $this->Instituicao->find(
                'first',
                [
                    'conditions' => ['Instituicao.id' => $estagiario['Estagiario']['id_instituicao']]
                ]
            );
            // pr($supervisores);
            // die('Supervisores');

            /* Crio a lista de supervisores da instituicao para o select */
            if (isset($supervisores['Supervisor']) || !(empty($supervisores['Supervisor']))) {
                foreach ($supervisores['Supervisor'] as $cada_super) {
                    $ordemsuper[$cada_super['id']] = $cada_super['nome'];
                }
            }
            asort($ordemsuper);
            $this->set('supervisores', $ordemsuper);

            /* Professores para o select */
            $this->loadModel('Professor');
            $professores = $this->Professor->find(
                'list',
                [
                    'order' => 'Professor.nome'
                ]
            );
            asort($professores);
            $this->set('professores', $professores);
            // pr($professores);
            // die('Professores');

            /* Areas para o select */
            $this->loadModel('Area');
            $areas = $this->Area->find(
                'list',
                [
                    'order' => 'area'
                ]
            );
            asort($areas);
            $this->set('areas', $areas);
            // pr($areas);
            // die('Area');
            /* Complemento período especial  */
            /* $this->loadModel('Area'); */
            $complemento_periodo_especial_total = $this->Estagiario->Complemento->find(
                'list',
                [
                    'order' => 'periodo_especial'
                ]
            );
            // pr($complemento_periodo_especial_total);
            // die('complemento_periodo_especial_total');
            $this->set('complemento_periodo_especial_total', $complemento_periodo_especial_total);

            $this->set('id', $id);

            $this->Estagiario->id = $id;

            $this->data = $this->Estagiario->read();
            // pr($this->data);
            // die();
        } else {
            if ($this->request->data['Estagiario']['complemento_id'] == '0') {
                $this->request->data['Estagiario']['complemento_id'] = null;
            }
            // pr($this->data);
            $this->request->data['Estagiario']['nota'] = floatval($this->data['Estagiario']['nota']);
            // pr($this->data);
            // die('Alteração da pontuação da nota');
            $this->Estagiario->set($this->data);
            // die('set->this->data');
            if ($this->Estagiario->save($this->data)) {
                $this->Flash->success(__("Atualizado!"));
                $this->redirect(['controller' => 'Estagiarios', 'action' => 'view', $this->data['Estagiario']['id']]);
            } else {
                $this->Flash->error(__("Erros de validação! Preencha corretamente todos os campos."));
                $errors = $this->Estagiario->validationErrors;
                pr($errors);
                // die();
                $this->redirect(['controller' => 'Estagiarios', 'action' => 'view', $this->data['Estagiario']['id']]);
                die('errors');
            }
        }
    }

    public function delete($id = NULL)
    {

        // pr($id);
        $estagiario = $this->Estagiario->find(
            'first',
            [
                'conditions' => ['Estagiario.id' => $id],
                'fields' => ['Estagiario.id', 'Estagiario.id_aluno', 'Estagiario.alunonovo_id', 'Estagiario.registro']
            ]
        );
        // pr($estagiario['Estagiario']['id_aluno']);
        $alunonovoId = $estagiario['Estagiario']['alunonovo_id'];
        // pr($id_aluno);
        // die();

        if ($this->Estagiario->delete($id)) {
            $this->Flash->success(__('O registro ' . $id . ' do estagiário foi excluido.'));
            $this->redirect(['controller' => 'alunonovos', 'action' => 'view', $alunonovoId]);
        } else {
            $this->Flash->error(__('O registro ' . $id . ' do estagiário NÃO foi excluido.'));
            $this->redirect(['controller' => 'alunonovos', 'action' => 'view', $alunonovoId]);
        }
    }

    /*
     * O id eh o id do Aluno e não o DRE
     */

    public function add($id = NULL)
    {

        // Para fazer a lista dos estagios anteriores
        $periodos_total = $this->Estagiario->find(
            'list',
            [
                'fields' => ['Estagiario.periodo', 'Estagiario.periodo'],
                'group' => ('Estagiario.periodo'),
                'order' => ('Estagiario.periodo')
            ]
        );
        // die();
        // Para acrescenter os próximos periodos carrego a configuracao do planejamento
        $this->loadModel('Configuraplanejamento');
        $periodo_planejamento = $this->Configuraplanejamento->find('all');
        // pr($periodo_planejamento);
        foreach ($periodo_planejamento as $c_periodoplanejamento) {
            // pr($c_periodoplanejamento['Configuraplanejamento']['semestre']);
            $periodos_novo[$c_periodoplanejamento['Configuraplanejamento']['semestre']] = $c_periodoplanejamento['Configuraplanejamento']['semestre'];
        }
        // pr($periodos_novo);
        $semestres = array_unique(array_merge($periodos_total, $periodos_novo));
        // pr($semestres);
        // die();
        // $this->set('periodos', $semestres);
        // Captura o periodo de estagio atual
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo_atual = $configuracao['Configuracao']['termo_compromisso_periodo'];
        // pr($periodo_atual);
        $periodos_total[$periodo_atual] = $periodo_atual;
        // pr($periodos_total);

        $parametros = $this->params['named'];
        // pr($parametros);
        $registro = isset($parametros['registro']) ? $parametros['registro'] : NULL;
        if (!isset($registro)):
            $registro = $this->request->query('registro');
        endif;
        // pr($registro);
        // die('registro');
        if ($registro) {
            $this->Estagiario->contain(['Alunonovo', 'Instituicao', 'Supervisor', 'Professor', 'Area']);
            $estagiarios = $this->Estagiario->find('all', [
                'conditions' => ['Estagiario.registro' => $registro],
                'order' => ['Estagiario.nivel' => 'asc']
            ]);
            // pr($estagiario);
            // die('estagiario_registro');
        } elseif ($id) {
            $this->Estagiario->contain(['Alunonovo', 'Instituicao', 'Supervisor', 'Professor', 'Area']);
            $estagiarios = $this->Estagiario->find('all', [
                'conditions' => ['Estagiario.id_aluno' => $id],
                'order' => ['Estagiario.nivel' => 'asc']
            ]);
            // pr($estagiarios);
            // die('estagiario_id');
        } else {
            // echo "Sem parámetros para identificaro o estudante";
            $this->Flash->error(__('Digite o DRE do estudante.'));
            $this->redirect(['controller' => 'alunonovos', 'action' => 'busca']);
            die();
        }
        // pr($estagiarios);
        // die("estagiarios");
        $proximo_nivel = null;

        if ($estagiarios) {
            $estagiario = end($estagiarios);
            // Calculo o nivel de estagio para o proximo periodo
            if ($estagiario['Estagiario']['periodo'] == $periodo_atual) {
                // echo "Nivel do periodo atual";
                $proximo_nivel = $estagiario['Estagiario']['nivel'];
                // die("nivel_periodo_atual");
            } else {
                if ($estagiario['Estagiario']['ajuste2020'] == 0) {
                    $ultimo_nivel = 4;
                } else {
                    $ultimo_nivel = 3;
                }
                if ($estagiario['Estagiario']['nivel'] < $ultimo_nivel) {
                    $proximo_nivel = $estagiario['Estagiario']['nivel'] + 1;
                    // die('nivel estagio atual');
                } else {
                    $proximo_nivel = 9; // Estagio não obrigatorio
                }
            }
            // echo "Próximo nível " . $proximo_nivel . "<br>";
            // die();
        } else {
            /* Se não é estagiario então nivel de estagio é 1 */
            $proximo_nivel = 1;
        }

        $this->set('estagiarios', $estagiarios);
        $this->set('proximo_nivel', $proximo_nivel);

        /* Para fazer o select dos alunos. Não é mais necessário */
        $this->loadModel('Aluno');
        $alunos = $this->Aluno->find('list', ['order' => 'Aluno.nome']);
        // pr($alunos);
        // die('alunos');
        $this->set('alunos', $alunos);

        /* Select das instituicoes. Nao colocar a opcao zero */
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', ['order' => 'Instituicao.instituicao']);
        $this->set('instituicoes', $instituicoes);

        /* Select dos supervisores */
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', ['order' => 'Supervisor.nome']);
        $this->set('supervisores', $supervisores);

        /* Select dos professores */
        $this->loadModel('Professor');
        $professores = $this->Professor->find(
            'list',
            [
                'order' => ['Professor.nome'],
                'conditions' => ['motivoegresso' => '']
            ]
        );
        // $professores[0] = '- Seleciona -';
        // asort($professores);
        $this->set('professores', $professores);

        /* Select das areas tematicas */
        $this->loadModel('Area');
        $areas = $this->Area->find(
            'list',
            [
                'order' => 'area'
            ]
        );
        $this->set('areas', $areas);

        /* Select complemento periodo especical */
        $complemento_periodo_especial_total = $this->Estagiario->Complemento->find('list');
        $this->set('complemento_periodo_especial_total', $complemento_periodo_especial_total);

        $this->set('periodos', $semestres);
        $this->set('periodo_atual', $periodo_atual);

        if ($this->data) {
            /*
              $aluno = $this->Aluno->findById($this->data['Estagiario']['id_aluno']);
              $this->data['Estagiario']['registro'] = $aluno['Aluno']['registro'];
             */
            if ($this->Estagiario->save($this->data, array('validates' => true))) {

                $this->Flash->success(__('Registro de estágio inserido!'));
                $this->redirect(['controller' => 'Alunos', 'action' => 'view', $this->data['Estagiario']['id_aluno']]);
            } else {
                $this->Flash->error(__("Erro de validação! Preencha corretamente todos os campos."));
                // $errors = $this->Estagiario->validationErrors;
                // pr($errors);
                $this->redirect(['controller' => 'Alunos', 'action' => 'view', $this->data['Estagiario']['id_aluno']]);
                die('error');
            }
        }
    }

    public function add_estagiario()
    {

        if (!empty($this->data)) {

            // Tiro os carateres de sublinhado
            $sanitarize_registro = (int) trim($this->data['Estagiario']['registro']);
            // pr(strlen($sanitarize_registro));
            if (strlen($sanitarize_registro) != 9) {
                $this->Flash->error(__('Registro inválido'));
                $this->redirect(['controller' => 'Estagiarios', 'action' => 'add_estagiario']);
            }

            $registro = $this->data['Estagiario']['registro'];
            // pr($registro);
            // Captura o periodo de estagio
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

            // Com o registro consulto a tabela de estagiarios
            $periodo_estagio = $this->Estagiario->find(
                'first',
                [
                    'conditions' => ['Estagiario.registro' => $registro],
                    'fields' => ['Estagiario.id', 'Estagiario.id_aluno', 'Estagiario.registro']
                ]
            );

            if (empty($periodo_estagio)) {
                // echo "Aluno novo sem estágio";
                $this->Flash->error(__("Aluno novo sem cadastro"));
                $this->redirect(['controller' => 'alunos', 'action' => 'add?registro=' . $registro]);
            } else {
                $this->redirect(['controller' => 'alunos', 'action' => 'view', $periodo_estagio['Estagiario']['id_aluno']]);
            }
        }
    }

    public function declaracaoestagio($id = NULL)
    {

        $estagiorealizado = $this->Estagiario->find('first', [
            'conditions' => ['Estagiario.id' => $id]
        ]);
        // pr($estagiorealizado);
        // die('estagiorealizado');

        if (empty($estagiorealizado['Aluno']['identidade'])) {
            $this->Flash->error(__("Estudante sem RG"));
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }

        if (empty($estagiorealizado['Aluno']['orgao'])) {
            $this->Flash->error(__("Estudante não especifica o orgão emisor do documento"));
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }
        if (empty($estagiorealizado['Aluno']['cpf'])) {
            $this->Flash->error(__("Estudante sem CPF"));
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }

        if (empty($estagiorealizado['Supervisor']['id'])) {
            $this->Flash->error(__("Falta o supervisor de estágio"));
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }

        // pr($estagiorealizado['Aluno']['cpf']);
        // die('estagiario');
        $this->set('estagiorealizado', $estagiorealizado);
    }

    public function declaracaoestagiopdf($id)
    {

        $estagiorealizado = $this->Estagiario->find('first', [
            'conditions' => ['Estagiario.id' => $id]
        ]);
        // pr($estagiorealizado);
        // die('estagiorealizado');

        if (empty($estagiorealizado['Alunonovo']['identidade'])) {
            $this->Flash->error(__("Estudante sem RG"));
            $this->redirect('/Alunonovos/view/' . $estagiorealizado['Alunonovo']['id']);
        }

        if (empty($estagiorealizado['Alunonovo']['orgao'])) {
            $this->Flash->error(__("Estudante não especifica o orgão emisor do documento"));
            $this->redirect('/Alunonovos/view/' . $estagiorealizado['Alunonovo']['id']);
        }

        if (empty($estagiorealizado['Alunonovo']['cpf'])) {
            $this->Flash->error(__("Estudante sem CPF"));
            $this->redirect('/Alunonovos/view/' . $estagiorealizado['Alunonovo']['id']);
        }

        if (empty($estagiorealizado['Supervisor']['id'])) {
            $this->Flash->error(__("Falta o supervisor de estágio"));
            $this->redirect('/Estagiarios/view/' . $estagiorealizado['Estagiario']['id']);
        }

        if (empty($estagiorealizado['Estagiario']['ch'])) {
            $this->Flash->error(__("Falta a carga horária de estágio"));
            $this->redirect('/Estagiarios/view/' . $estagiorealizado['Estagiario']['id']);
        }

        $this->set('estagiorealizado', $estagiorealizado);
    }

    public function estudante()
    {

        $this->loadModel('Alunonovo');
        $this->Alunonovo->contain();
        $estudantes = $this->Alunonovo->find('all', [
            'fields' => ['id', 'registro']
        ]);
        // pr($estudantes);
        // die();

        foreach ($estudantes as $c_estudante) {
            // pr($c_estudante);
            $this->Estagiario->contain();
            $estagiario = $this->Estagiario->find('first', [
                'conditions' => ['Estagiario.registro' => $c_estudante['Alunonovo']['registro']],
                'fields' => ['id', 'registro']
            ]);
            // pr($estagiario);
            if ($estagiario) {
                if (
                    $this->Estagiario->updateAll(
                        ['Estagiario.alunonovo_id' => $c_estudante['Alunonovo']['id']],
                        ['Estagiario.registro' => $estagiario['Estagiario']['registro']]
                    )
                )
                    ;
            } else {
                echo "Estudante sem estágio";
            }
            // $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($estagiario);
            // die();
        }
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        die("Tarefa finalizada!");
    }

    public function atualiza()
    {

        $this->loadModel('Alunonovo');
        $this->Alunonovo->contain(['Inscricao']);
        $estudantes = $this->Alunonovo->find('all', [
            'order' => 'Alunonovo.id'
        ]);

        foreach ($estudantes as $c_estudante) {
            // pr($c_estudante);
            // die();
            $this->Estagiario->contain();
            $alunonovoq = $this->Estagiario->find('count', [
                'conditions' => ['Estagiario.registro' => $c_estudante['Alunonovo']['registro']],
            ]);
            $c_estudante['Alunonovo']['estagiario_count'] = $alunonovoq;
            // pr($c_estudante);
            $log = $this->Alunonovo->getDataSource()->getLog(false, false);
            // debug($log);
            // die();

            $this->Estagiario->set($c_estudante);
            // die('set->this->data');
            if ($this->Estagiario->save($c_estudante, ['validates' => false])) {
                // $this->Flash->success(__("Atualizado!"));
            } else {
                // $this->Flash->error(__("Erros na atualização!."));
                // $errors = $this->Estagiario->validationErrors;
                // pr($errors);
                // die();
            }
            // $log = $this->Alunonovo->getDataSource()->getLog(false, false);
            // debug($log);
        }
        die("Tarefa finalizada!");
    }

}