<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EstagiariosController extends AppController {

    public $name = 'Estagiarios';
    public $components = array('Auth', 'Paginator', 'RequestHandler', 'Flash');
    // var $scaffold;
    // var $helpers = array('Javascript');
    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Aluno.nome' => 'asc')
    );

    public function beforeFilter() {

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

    private function periodo($periodo = NULL, $condicoes = NULL) {

        // Para fazer a lista para o select dos estagios anteriores
        $periodos_estagio = $this->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => ('Estagiario.periodo'),
            'order' => array('Estagiario.periodo' => 'DESC')
        ));
        // pr($periodos_estagio);
        // die();
        // pr($periodo);
        // pr("Período: ", $periodo);
        // Guardo o valor do periodo (incluso quando eh 0) ate que seja selecionado outro periodo
        if ($periodo == NULL) {
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

    public function index() {

        $parametros = $this->params['named'];
        // pr($parametros);
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $complemento_periodo_especial = isset($parametros['complemento_periodo_especial']) ? $parametros['complemento_periodo_especial'] : NULL;
        $id_area = isset($parametros['id_area']) ? $parametros['id_area'] : NULL;
        $id_aluno = isset($parametros['id_aluno']) ? $parametros['id_aluno'] : NULL;
        $id_professor = isset($parametros['id_professor']) ? $parametros['id_professor'] : NULL;
        $id_instituicao = isset($parametros['id_instituicao']) ? $parametros['id_instituicao'] : NULL;
        $id_supervisor = isset($parametros['id_supervisor']) ? $parametros['id_supervisor'] : NULL;
        $nivel = isset($parametros['nivel']) ? $parametros['nivel'] : NULL;
        $turno = isset($parametros['turno']) ? $parametros['turno'] : NULL;

        // pr($periodo);

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

        $registro = $this->request->query('registro');
        if ($registro) {
            $this->loadModel('Aluno');
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro]
            ]);
            if ($registro) {
                $id_aluno = $aluno['Aluno']['id'];
            }
        }
        // pr($registros);
        // pr($id_aluno);

        if (!(isset($nivel))) {
            // die('nivel empty');
            $nivel = $this->request->query('nivel');
        }
        // pr($nivel);
        // die('nivel');

        $condicoes = NULL;

        /* Função periodo */
        $periodos = $this->periodo($periodo, $condicoes);
        // pr($periodos);
        $periodo = $periodos[0];
        $condicoes = $periodos[1];
        // die();

        /* Complemento periodo especial */
        // Capturo o complemento do periodo_especial. Construido por causa da pandemia de 2020
        $complemento_periodo_especial_total = $this->Estagiario->Complemento->find('list');
        // pr($complemento_periodo_especial_total);
        // die('complemento_periodo_especial_total');
        // Guardo o valor do periodo_especial ate que seja selecionado outro
        if ($complemento_periodo_especial == NULL) {
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
        $areas = $this->Estagiario->Area->find('list', array(
            'fields' => array('Area.area'),
            'order' => 'Area.area'));
        // Guardo o valor do id_area ate que seja selecionada outra
        if ($id_area == NULL) {
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

        /* Professores */
        $professores = $this->Estagiario->Professor->find('list', array(
            'fields' => array('Professor.nome'),
            'order' => array('Professor.nome'))
        );
        // Guardo o valor do id_professor ate que seja selecionado outro
        if ($id_professor == NULL) {
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
        $instituicoes = $this->Estagiario->Instituicao->find('list', array(
            'fields' => array('Instituicao.instituicao'),
            'order' => array('Instituicao.instituicao'))
        );
        // Guardo o valor do id_instituicao ate que seja selecionado outro
        if ($id_instituicao == NULL) {
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
        $supervisores = $this->Estagiario->Supervisor->find('list', array(
            'fields' => array('Supervisor.nome'),
            'order' => array('Supervisor.nome')
                )
        );
        // echo 'supervisor_id ' . $id_supervisor;
        // Guardo o valor do id_supervisor ate que seja selecionado outro
        if ($id_supervisor === NULL) {
            // echo 'Null' . "<br>";
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
        if ($nivel == NULL) {
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
        if ($turno == NULL) {
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

        $this->Estagiario->contain = -1;
        if (isset($condicoes)) {
            $this->set('estagiarios', $this->Paginate($condicoes));
        } else {
            $this->set('estagiarios', $this->Paginate('Estagiario'));
        }
    }

    public function view($id = NULL) {
        /*
          if (!$this->Estagiario->exists($id)) {
          throw new NotFoundException(__('Invalid Estagiário'));
          }
         */
        if (is_numeric($id)) {
            $estagio = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.id' => $id)));
        } elseif (!empty($this->request->query('registro'))) {
            $registro = $this->request->query('registro');
            $estagio = $this->Estagiario->find('first', array(
                'conditions' => ['Estagiario.registro' => $registro]
            ));
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
        // die();
        $this->set('estagio', $estagio);
    }

    public function alunorfao() {

        $this->set('orfaos', $this->Estagiario->alunorfao());
    }

    public function edit($id = NULL) {

        if (empty($this->data)) {

            $this->Estagiario->recursive = 2;
            $estagiario = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.id' => $id),
                'fields' => array('Estagiario.periodo', 'Estagiario.complemento_id', 'Estagiario.nivel', 'Estagiario.id_professor', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_area', 'Estagiario.nota', 'Estagiario.ch', 'Aluno.id', 'Aluno.nome', 'Instituicao.id', 'Instituicao.instituicao', 'Supervisor.id', 'Supervisor.nome', 'Professor.id', 'Professor.nome', 'Area.id', 'Area.area')
            ));
            $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($estagiario);
            // die();

            $aluno = $estagiario['Aluno']['nome'];
            $this->set('aluno', $aluno);

            // Periodos para o select
            $periodos_total = $this->Estagiario->find('list', array(
                'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
                'group' => ('Estagiario.periodo'),
                'order' => ('Estagiario.periodo')
            ));

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
            $this->set('periodos', $semestres);

            /* Instituicoes para o select. Nao colocar a opcao 0 */
            $this->loadModel('Instituicao');
            $instituicoes = $this->Instituicao->find('list', array(
                'order' => 'Instituicao.instituicao'));
            asort($instituicoes);
            // pr($instituicoes);
            $this->set('instituicoes', $instituicoes);
            // die();

            /* Supervisores da instituicao para o select */
            $supervisores = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id' => $estagiario['Estagiario']['id_instituicao'])
            ));
            // pr($supervisores);
            // die();

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
            $professores = $this->Professor->find('list', array(
                'order' => 'Professor.nome'));
            asort($professores);
            $this->set('professores', $professores);

            /* Areas para o select */
            $this->loadModel('Area');
            $areas = $this->Area->find('list', array(
                'order' => 'area'));
            asort($areas);
            $this->set('areas', $areas);

            /* Complemento período especial  */
            /* $this->loadModel('Area'); */
            $complemento_periodo_especial_total = $this->Estagiario->Complemento->find('list', array(
                'order' => 'periodo_especial'));
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
                $this->request->data['Estagiario']['complemento_id'] = NULL;
            }
            // pr($this->data);
            // die();
            $this->request->data['Estagiario']['nota'] = str_replace(",", ".", $this->data['Estagiario']['nota']);
            // pr($this->request->data);
            // die();
            $this->Estagiario->set($this->data);
            if ($this->Estagiario->validates(['fieldList' => ['note', 'ch']])) {
                // $this->Flash->success(__("Está tudo ok!"));
            } else {
                $this->Flash->error(__("Erros de validação!"));
                $errors = $this->ModelName->validationErrors;
                // pr($errors);
                $this->redirect('/Estagiarios/view/ ' . $this->data['Estagiario']['id']);
            }
            if ($this->Estagiario->save($this->request->data)) {
                ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> Indicates a successful or positive action.
                </div>
                <?php
                $this->Flash->success(__("Atualizado"));
                $this->redirect('/Estagiarios/view/ ' . $this->data['Estagiario']['id']);
            }
        }
    }

    public function delete($id = NULL) {

// pr($id);
        $estagiario = $this->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id),
            'fields' => array('Estagiario.id', 'Estagiario.id_aluno', 'Estagiario.registro')
        ));
// pr($estagiario['Estagiario']['id_aluno']);
        $id_aluno = $estagiario['Estagiario']['id_aluno'];
// pr($id_aluno);
// die();

        $this->Estagiario->delete($id);
        $this->Session->setFlash('O registro ' . $id . ' foi excluido.');

        $this->redirect('/Alunos/view/' . $id_aluno);
    }

    /*
     * O id eh o id do Aluno e não o DRE
     */

    public function add($id = NULL) {

// Para fazer a lista dos estagios anteriores
        $periodos_total = $this->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => ('Estagiario.periodo'),
            'order' => ('Estagiario.periodo')
        ));

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
// pr($registro);
// die('registro');
        if ($registro) {
            $estagiarios = $this->Estagiario->find('all', array(
                'conditions' => array('Estagiario.registro' => $registro)
            ));
// pr($estagiario);
// die('estagiario_registro');
        } elseif ($id) {
            $estagiarios = $this->Estagiario->find('all', array(
                'conditions' => array('Estagiario.id_aluno' => $id)
            ));
// pr($estagiarios);
// die('estagiario_id');
        } else {
            echo "Sem parámetros para identificaro o estudante";
            $this->Session->setFlash('Digite o DRE do estudante.');
            $this->redirect('/Alunos/busca');
            die();
        }
// pr($estagiarios);
// die("estagiarios");
        if (!$estagiarios) {
            echo "Estudante sem estágio. Vai para estágio I.";
            die('Estudante sem estágio');
        }
// die("estagiarios");
// Não sei se isto eh necessario aqui
        $nivel_periodo_atual = NULL;

        if ($estagiarios) {
// Calculo o nivel de estagio para o proximo periodo
            foreach ($estagiarios as $c_estagio) {
// pr($c_estagio['Estagiario']['periodo']);
                if ($c_estagio['Estagiario']['periodo'] == $periodo_atual) {
// echo "Nivel do periodo atual";
                    $nivel_periodo_atual = $c_estagio['Estagiario']['nivel'];
// die("nivel_periodo_atual");
                } else {
                    $nivel[$c_estagio['Estagiario']['nivel']] = $c_estagio['Estagiario']['nivel'];
// die('nivel estagio atual');
                }
            }
// echo "Nível período atual " . $nivel_periodo_atual . "<br>";
// echo "Nível " . $nivel[$c_estagio['Estagiario']['nivel']] . "<br>";
// die();
// Não deveria acontecer, mas se acontecer ...
        } else {
// echo "Estudante sem estágio: " . $id;
            $this->loadModel('Aluno');
            if ($id) {
                $estagiario_sem_estagio = $this->Aluno->find('first', array(
                    'conditions' => array('Aluno.id' => $id))
                );
            } elseif ($registro) {
                $estagiario_sem_estagio = $this->Aluno->find('first', array(
                    'conditions' => array('Aluno.registro' => $registro))
                );
            }
// pr($estagiario_sem_estagio);
// die('estagiario_sem_estagio');
            if (!$estagiario_sem_estagio) {
                echo "Estudante sem estágio";
                $this->Session->setFlash('Estagiário cadastrado sem nível de estágio definido.');
                $this->redirect('/Alunos/busca_dre/');
                die('Estudante estagiário sem nível definido');
            }
        }

// Ordeno os niveis (estagios anteriores ao periodo atual)
        $ultimo_nivel = NULL;
        if (isset($nivel)) {
            asort($nivel);
// Passo o valor do ultimo
            $ultimo_nivel = end($nivel);
// Incremento em 1 para o próximo estágio
            $ultimo_nivel = $ultimo_nivel + 1;
// Se eh maior de 4 coloco 0 (estágio não obrigatório)
            if ($ultimo_nivel > 4) {
                $ultimo_nivel = 9;
            }
// Se nao existe o nivel entao eh 1
        } else {
            $ultimo_nivel = 1;
        }

// Se o nivel eh do periodo atual entao nao muda
        if ($nivel_periodo_atual)
            $ultimo_nivel = $nivel_periodo_atual;
// pr($ultimo_nivel);

        $this->set('estagiarios', $estagiarios);
        $this->set('proximo_nivel', $ultimo_nivel);

        /* Para fazer o select dos alunos */
        $this->loadModel('Aluno');
        $alunos = $this->Aluno->find('list', array('order' => 'Aluno.nome'));
// pr($alunos);
// die('alunos');
        $this->set('alunos', $alunos);

        /* Select das instituicoes. Nao colocar a opcao zero */
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', array('order' => 'Instituicao.instituicao'));
        $this->set('instituicoes', $instituicoes);

        /* Select dos supervisores */
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', array('order' => 'Supervisor.nome'));
// $supervisores[0] = '- Seleciona -';
// asort($supervisores);
        $this->set('supervisores', $supervisores);

        /* Select dos professores */
        $this->loadModel('Professor');
        $professores = $this->Professor->find('list', array(
            'order' => array('Professor.nome'),
            'conditions' => array('motivoegresso' => '')));
// $professores[0] = '- Seleciona -';
// asort($professores);
        $this->set('professores', $professores);

        /* Select das areas tematicas */
        $this->loadModel('Area');
        $areas = $this->Area->find('list', array(
            'order' => 'area'));
// $areas[0] = '- Seleciona -';
// asort($areas);
        $this->set('areas', $areas);

        /* Select complemento periodo especical */
        $complemento_periodo_especial_total = $this->Estagiario->Complemento->find('list');
        $this->set('complemento_periodo_especial_total', $complemento_periodo_especial_total);

        $this->set('periodos', $semestres);
        $this->set('periodo_atual', $periodo_atual);
        if (isset($estagiario_sem_estagio)) {
            $this->set('estagiario_sem_estagio', $estagiario_sem_estagio);
        }
        if ($this->data) {
            /*
              $aluno = $this->Aluno->findById($this->data['Estagiario']['id_aluno']);
              $this->data['Estagiario']['registro'] = $aluno['Aluno']['registro'];
             */
            if ($this->Estagiario->save($this->data, array('validates' => TRUE))) {

                $this->Session->setFlash('Registro de estágio inserido!');
                $this->redirect('/Alunos/view/' . $this->data['Estagiario']['id_aluno']);
            }
        }
    }

    public function add_estagiario() {

// Configure::write('debug', '2');
        if (!empty($this->data)) {

// Tiro os carateres de sublinhado
            $sanitarize_registro = (int) trim($this->data['Estagiario']['registro']);
// pr(strlen($sanitarize_registro));
            if (strlen($sanitarize_registro) < 9) {
                $this->Session->setFlash('Número inválido');
                $this->redirect('/Estagiarios/add_estagiario');
            }

            $registro = $this->data['Estagiario']['registro'];
// pr($registro);
// Captura o periodo de estagio
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

// Com o periodo e o registro consulto a tabela de estagiarios
            $periodo_estagio = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $registro),
                'fields' => array('Estagiario.id', 'Estagiario.id_aluno', 'Estagiario.registro')));

            if (empty($periodo_estagio)) {
// echo "Aluno  novo sem estágio";
                $this->Session->setFlash("Aluno novo sem cadastro");
                $this->redirect('/alunos/add/' . $registro);
            } else {

                $this->redirect('/alunos/view/' . $periodo_estagio['Estagiario']['id_aluno']);
            }
        }
    }

    public function declaracaoestagio($id = NULL) {

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

    public function declaracaoestagiopdf($id) {

        $estagiorealizado = $this->Estagiario->find('first', [
            'conditions' => ['Estagiario.id' => $id]
        ]);
// pr($estagiorealizado);
// die('estagiorealizado');

        if (empty($estagiorealizado['Aluno']['identidade'])) {
            $this->Session->setFlash(__("Estudante sem RG"), "flash_notification");
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }

        if (empty($estagiorealizado['Aluno']['orgao'])) {
            $this->Session->setFlash(__("Estudante não especifica o orgão emisor do documento"), "flash_notification");
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }
        if (empty($estagiorealizado['Aluno']['cpf'])) {
            $this->Session->setFlash(__("Estudante sem CPF"), "flash_notification");
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }

        if (empty($estagiorealizado['Supervisor']['id'])) {
            $this->Session->setFlash(__("Falta o supervisor de estágio"), "flash_notification");
            $this->redirect('/Alunos/view/' . $estagiorealizado['Aluno']['id']);
        }

// pr($estagiorealizado['Aluno']['cpf']);
// die('estagiario');
        $this->set('estagiorealizado', $estagiorealizado);
    }

}
?>
