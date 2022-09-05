<?php

class InstituicaosController extends AppController {

    public $name = "Instituicaos";
    public $components = array('Auth', 'Paginator', 'Flash');

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'lista', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'lista', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('add', 'edit', 'addassociacao', 'deleteassociacao', 'index', 'lista', 'view', 'busca', 'seleciona_supervisor');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index/');
        }
    }

    public function index() {

        $parametros = $this->params['named'];
        // print_r($parametros);
        $area_id = isset($parametros['area_id']) ? $parametros['area_id'] : NULL;
        $natureza_id = isset($parametros['natureza_id']) ? $parametros['natureza_id'] : NULL;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $limite = isset($parametros['limite']) ? $parametros['limite'] : 10;

        if (!$area_id) {
            $area_id = $this->request->query('area_id');
        }

        if (!$natureza_id) {
            $natureza_id = $this->request->query('natureza_id');
        }

        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }

        if (!$limite) {
            $limite = $this->request->query('limite');
        }

        if (is_null($periodo)) {
            $periodo = $this->Session->read('periodo');
        }
        if ($periodo === 0) {
            $this->Session->delete('periodo');
        } else {
            $this->Session->write('periodo', $periodo);
        }

        if (is_null($area_id)) {
            $area_id = $this->Session->read('area_id');
        }
        if ($area_id === 0) {
            $this->Session->delete('area_id');
        } else {
            $this->Session->write('area_id', $area_id);
        }

        if (is_null($natureza_id)) {
            $natureza_id = $this->Session->read('natureza_id');
        }
        if ($natureza_id === 0) {
            $this->Session->delete('natureza_id');
        } else {
            $this->Session->write('natureza_id', $natureza_id);
        }


        $todosPeriodos = $this->Instituicao->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));

        /* Capturo as areas para o option do select */
        $areas_instituicao = $this->Instituicao->Areainstituicao->find('list', array(
            'order' => 'Areainstituicao.area'));

        /* Capturo as naturezas para o option do select */
        $this->Instituicao->contain();
        $q_natureza = $this->Instituicao->find('all',
                ['fields' => ['DISTINCT natureza'],
                    'conditions' => ['natureza IS NOT NULL'],
                    'order' => 'natureza']);
        foreach ($q_natureza as $c_natureza) {
            $naturezas[$c_natureza['Instituicao']['natureza']] = $c_natureza['Instituicao']['natureza'];
        };

        // if (!$periodo) $periodo = end($todosPeriodos);

        $this->Instituicao->virtualFields['Periodo'] = 'max(Estagiario.periodo)';
        $this->Instituicao->virtualFields['Estudantes'] = 'count(Distinct Estagiario.registro)';
        $this->Instituicao->virtualFields['Supervisores'] = 'count(Distinct Estagiario.id_supervisor)';

        // pr($periodo);
        // die();

        if ($periodo):
            if ($area_id):
                $this->paginate = array(
                    'limit' => $limite,
                    // 'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'Areainstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('area_instituicoes_id' => $area_id, 'periodo' => $periodo),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            elseif ($natureza_id):
                $this->paginate = array(
                    'limit' => $limite,
                    // 'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'Areainstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('natureza LIKE' => $natureza_id, 'periodo' => $periodo),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            else:
                $this->paginate = array(
                    'limit' => $limite,
                    // 'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'Areainstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'conditions' => array('periodo' => $periodo),
                    'group' => array('Estagiario.id_instituicao'),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            endif;
        else:
            if ($area_id):
                $this->paginate = array(
                    'limit' => $limite,
                    // 'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'Areainstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('area_instituicoes_id' => $area_id),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            elseif ($natureza_id):
                $this->paginate = array(
                    'limit' => $limite,
                    // 'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'Areainstituicao.area', 'max(Estagiario.periodo) as Instituicao__virtualMaxPeriodo', 'count(Distinct Estagiario.registro) as Instituicao__virtualEstudantes', 'count(Distinct Estagiario.id_supervisor) as Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'conditions' => array('natureza LIKE' => $natureza_id),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            else:
                $this->paginate = array(
                    'limit' => $limite,
                    // 'fields' => array('Instituicao.id', 'Instituicao.instituicao', 'Instituicao.convenio', 'Instituicao.expira', 'Instituicao.natureza', 'Areainstituicao.area', 'Instituicao__virtualPeriodo', 'Instituicao__virtualEstudantes', 'Instituicao__virtualSupervisores'),
                    'joins' => array(
                        array('alias' => 'Estagiario',
                            'table' => 'estagiarios',
                            'type' => 'RIGHT',
                            'conditions' => 'Instituicao.id = Estagiario.id_instituicao')
                    ),
                    'group' => array('Estagiario.id_instituicao'),
                    'order' => array(
                        'Instituicao.instituicao' => 'asc')
                );
            endif;
        endif;

        $this->set('natureza_id', $natureza_id);
        $this->set('naturezas', $naturezas);
        $this->set('area_id', $area_id);
        $this->set('areas', $areas_instituicao);
        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        $this->set('limite', $limite);
        $this->set('instituicoes', $this->Paginate('Instituicao'));
    }

    public function add() {

        $area_instituicao = $this->Instituicao->Areainstituicao->find('list', array(
            'order' => 'Areainstituicao.area'));
        // pr($area_instituicao);
        // die();
        // Capturo a natureza dos instituições para o Datalist
        $this->Instituicao->recursive = -1;
        $q_natureza = $this->Instituicao->find('all',
                ['fields' => ['DISTINCT natureza'],
                    'conditions' => ['natureza IS NOT NULL'],
                    'order' => 'natureza']);
        foreach ($q_natureza as $c_natureza) {
            $natureza[] = $c_natureza['Instituicao']['natureza'];
        };
        $this->set('naturezas', $natureza);

        // Capturo as instituicoes das instituições para o Datalist
        $this->Instituicao->recursive = -1;
        $q_instituicao = $this->Instituicao->find('all',
                ['fields' => ['DISTINCT instituicao'],
                    'conditions' => ['instituicao IS NOT NULL'],
                    'order' => 'instituicao']);
        foreach ($q_instituicao as $c_instituicao) {
            $instituicoes[] = $c_instituicao['Instituicao']['instituicao'];
        };

        // Capturo os bairros das instituições para o Datalist
        $this->Instituicao->recursive = -1;
        $q_bairro = $this->Instituicao->find('all',
                ['fields' => ['DISTINCT bairro'],
                    'conditions' => ['bairro IS NOT NULL'],
                    'order' => 'bairro']);
        foreach ($q_bairro as $c_bairro) {
            $bairros[] = $c_bairro['Instituicao']['bairro'];
        };

        // pr($instituicoes);
        // die();
        $this->set('bairros', $bairros);
        $this->set('instituicoes', $instituicoes);
        $this->set('naturezas', $natureza);

        $this->set('id_area_instituicao', $area_instituicao);
        // $this->set('meses', $this->meses());

        if ($this->data) {
            if ($this->Instituicao->save($this->data)) {
                $this->Session->setFlash('Dados da instituição inseridos!');
                $this->Instituicao->getLastInsertId();
                $this->redirect('/Instituicaos/view/' . $this->Instituicao->getLastInsertId());
            }
        }
    }

    public function view($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
            'conditions' => array('Instituicao.id' => $id),
            'order' => 'Instituicao.instituicao'));
        // pr($instituicao);

        /* Para acrescentar um supervisor */
        $this->loadModel('Supervisor');
        $supervisores = $this->Supervisor->find('list', array(
            'order' => array('Supervisor.nome')));

        $this->set('supervisores', $supervisores);

        $proximo = $this->Instituicao->find('neighbors', array(
            'field' => 'instituicao', 'value' => $instituicao['Instituicao']['instituicao']));

        $this->set('registro_next', $proximo['next']['Instituicao']['id']);
        $this->set('registro_prev', $proximo['prev']['Instituicao']['id']);

        $this->set('instituicao', $instituicao);
    }

    public function edit($id = NULL) {

        $this->Instituicao->id = $id;

        // Capturo a natureza dos instituições para o Datalist
        $this->Instituicao->recursive = -1;
        $q_natureza = $this->Instituicao->find('all',
                ['fields' => ['DISTINCT natureza'],
                    'conditions' => ['natureza IS NOT NULL'],
                    'order' => 'natureza']);
        foreach ($q_natureza as $c_natureza) {
            $naturezas[] = $c_natureza['Instituicao']['natureza'];
        };
        $this->set('naturezas', $naturezas);

        // Capturo as instituicoes das instituições para o Datalist
        $this->Instituicao->recursive = -1;
        $q_instituicao = $this->Instituicao->find('all',
                ['fields' => ['DISTINCT instituicao'],
                    'conditions' => ['instituicao IS NOT NULL'],
                    'order' => 'instituicao']);
        foreach ($q_instituicao as $c_instituicao) {
            $instituicoes[] = $c_instituicao['Instituicao']['instituicao'];
        };

        // Capturo os bairros das instituições para o Datalist
        $this->Instituicao->recursive = -1;
        $q_bairro = $this->Instituicao->find('all',
                ['fields' => ['DISTINCT bairro'],
                    'conditions' => ['bairro IS NOT NULL'],
                    'order' => 'bairro']);
        foreach ($q_bairro as $c_bairro) {
            $bairros[] = $c_bairro['Instituicao']['bairro'];
        };

        // pr($instituicoes);
        // die();
        $this->set('bairros', $bairros);
        $this->set('instituicoes', $instituicoes);
        $this->set('naturezas', $naturezas);

        $area_instituicao = $this->Instituicao->Areainstituicao->find('list', array(
            'order' => 'Areainstituicao.area'
        ));

        $this->set('area_instituicao', $area_instituicao);

        // Capturo os dados da instituicao para enviar para o formulário
        $e_instituicao = $this->Instituicao->find('first', ['conditions' => ['id' => $id]]);
        $this->set('e_instituicao', $e_instituicao);

        // pr($this->data);
        // die();

        if (empty($this->data)) {
            $this->data = $this->Instituicao->read();
        } else {
            if ($this->Instituicao->save($this->data)) {
                // print_r($this->data);
                // die();
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Instituicaos/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        $instituicao = $this->Instituicao->find('first', array(
            'conditions' => array('Instituicao.id' => $id)
        ));

        $murais = $instituicao['Mural'];
        $supervisores = $instituicao['Supervisor'];
        $alunos = $instituicao['Estagiario'];

        if ($murais) {
            // die(pr($murais[0]['id']));

            $this->Session->setFlash('Há murais vinculados com esta instituição');
            $this->redirect('/Murals/view/' . $murais[0]['id']);
        } elseif ($supervisores) {

            $this->Session->setFlash('Há supervisores vinculados com esta instituição');
            $this->redirect('/Instituicaos/view/' . $id);
        } elseif ($alunos) {

            $this->Session->setFlash('Há alunos estagiários vinculados com esta instituição');
            $this->redirect('/Instituicaos/view/' . $id);
        } else {
            $this->Instituicao->delete($id);
            $this->Session->setFlash('Registro excluído');
            $this->redirect('/Instituicaos/index/');
        }
    }

    public function deleteassociacao($id = NULL) {

        $id_superinstituicao = $this->Instituicao->InstSuper->find('first',
                ['conditions' => ['InstSuper.id' => $id]]);
        // pr($id_superinstituicao);
        // die();

        $this->Instituicao->InstSuper->delete($id);

        $this->Flash->success(__("Supervisor excluido da instituição"));
        $this->redirect('/Instituicaos/view/' . $id_superinstituicao['InstSuper']['id_instituicao']);
    }

    public function addassociacao() {

        if ($this->data) {
            /* Busco se o supervisor já está cadastrado para não cadastrar duas vezes */
            $supervisor = $this->Instituicao->InstSuper->find('first', [
                'conditions' => ['id_supervisor' => $this->data['InstSuper']['id_supervisor'], 'id_instituicao' => $this->data['InstSuper']['id_instituicao']]
            ]);
            if ($supervisor) {
                $this->Flash->error(__('Supervisor(a) já está cadastrado(a) na instituição'));
                $this->redirect('/Instituicaos/view/' . $this->data['InstSuper']['id_instituicao']);
            } else {
                if ($this->Instituicao->InstSuper->save($this->data)) {
                    $this->Flash->success(__('Dados inseridos'));
                    $this->redirect('/Instituicaos/view/' . $this->data['InstSuper']['id_instituicao']);
                }
            }
        }
    }

    public function busca($id = NULL) {

        if ($id) {
            $this->request->data['Instituicao']['instituicao'] = $id;
        }
        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Instituicao.instituicao' => 'asc')
        );

        if (isset($this->request->data['Instituicao']['instituicao'])) {

            $condicao = array('Instituicao.instituicao like' => '%' . $this->data['Instituicao']['instituicao'] . '%');
            $instituicoes = $this->Instituicao->find('all', array('conditions' => $condicao));

            // Nenhum resultado
            if (empty($instituicoes)) {
                $this->Session->setFlash("Não foram encontrados registros");
            } else {
                $this->set('instituicoes', $this->Paginate($condicao));
                $this->set('busca', $this->data['Instituicao']['instituicao']);
            }
        }
    }

    /*
     * Seleciona supervisor em funcao da selecao da instituicao
     */

    public function seleciona_supervisor($id = NULL) {

        // $id = 1108;
        // pr($id);
        // die("id");
        // Configure::write('debug', 2);
        if ($id != 0) {
            $supervisores = $this->Instituicao->find('all', array(
                'conditions' => ['Instituicao.id' => $id],
                    )
            );
            // pr($supervisores);
            // die('supervisores');
            if ($supervisores) {
                $i = 0;
                foreach ($supervisores as $c_supervisor) {
                    // pr($c_supervisor['Supervisor']);
                    $super[0] = "Seleciona";
                    foreach ($c_supervisor['Supervisor'] as $cada_supervisor) {
                        // pr($cada_supervisor['id']);
                        $super[$cada_supervisor['id']] = $cada_supervisor['id'];
                        $super[$cada_supervisor['id']] = $cada_supervisor['nome'];
                        // pr($super);
                        $i++;
                    }
                }
            }
            // pr($super);
            // die('super');
            $this->set('supervisores', $super);
            $this->layout = 'ajax';
        }
    }

    public function natureza() {

        $parametros = $this->params['named'];
        // pr($parametros);
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : NULL;

        if (!$natureza) {
            $natureza = $this->request->query('natureza');
        }

        $this->Instituicao->recursive = -1;
        $natureza = $this->Instituicao->find('all', array(
            'fields' => array('Instituicao.natureza', "count('Instituicao.natureza') as qnatureza"),
            'order' => array('Instituicao.natureza'),
            'group' => 'Instituicao.natureza'
                )
        );
        // die();
        $this->set('natureza', $natureza);
    }

    public function listainstituicao() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.instituicao'),
                'conditions' => array('Instituicao.instituicao LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.instituicao')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['instituicao'] . "\n";
            }
        }
    }

    public function listanatureza() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.natureza'),
                'conditions' => array('Instituicao.natureza LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.natureza')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['natureza'] . "\n";
            }
        }
    }

    public function listabairro() {

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $resultado = $this->Instituicao->find('all', array(
                'fields' => array('Instituicao.bairro'),
                'conditions' => array('Instituicao.bairro LIKE ' => '%' . $this->request->query['q'] . '%'),
                'group' => array('Instituicao.bairro')
            ));
            foreach ($resultado as $q_resultado) {
                echo $q_resultado['Instituicao']['bairro'] . "\n";
            }
        }
    }

    public function lista() {

        $parametros = $this->params['named'];
        // pr($parametros);
        $linhas = isset($parametros['linhas']) ? $parametros['linhas'] : NULL;
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'instituicao';
        $pagina = isset($parametros['pagina']) ? $parametros['pagina'] : NULL;
        $direcao = isset($parametros['direcao']) ? $parametros['direcao'] : NULL;
        $mudadirecao = isset($parametros['mudadirecao']) ? $parametros['mudadirecao'] : NULL;
        $natureza = isset($parametros['natureza']) ? $parametros['natureza'] : NULL;
        // Para ordenar por periodos //
        // Nao implementado //
        // pr($ordem);
        // die();

        if (!$linhas) {
            $linhas = $this->request->query('linhas');
        }

        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }

        if (!$ordem) {
            $ordem = $this->request->query('ordem');
        }

        if (!$pagina) {
            $pagina = $this->request->query('pagina');
        }

        if (!$direcao) {
            $direcao = $this->request->query('direcao');
        }

        if (!$mudadirecao) {
            $mudadirecao = $this->request->query('mudadirecao');
        }

        if (!$natureza) {
            $natureza = $this->request->query('natureza');
        }

        $todosperiodos = $this->Instituicao->Estagiario->find('all', array(
            'fields' => array('DISTINCT Estagiario.periodo'),
                )
        );
        foreach ($todosperiodos as $c_periodo) {
            $periodos[$c_periodo['Estagiario']['periodo']] = $c_periodo['Estagiario']['periodo'];
        }

        if ($periodo == NULL):
            $periodoatual = end($todosperiodos);
            $periodo = $periodoatual['Estagiario']['periodo'];
        endif;

        // pr($paginas);
        // Matriz com os dados para ordenar e paginar //

        $g_instituicoes = $this->Instituicao->find('all', array(
            /* 'order' => 'Instituicao.' . $ordem, */
            'limit' => $linhas
                )
        );

//       if ($natureza):
//           $g_instituicoes = $this->Instituicao->find('all', array(
//                'conditions' => array('Instituicao.natureza' => $natureza),
//                'order' => 'Instituicao.' . $ordem,
//                'limit' => $linhas
//                    )
//            );
//        else:
//            $g_instituicoes = $this->Instituicao->find('all', array(
//                /* 'order' => 'Instituicao.' . $ordem, */
//                'limit' => $linhas
//                    )
//            );
//        endif;
        // $log = $this->Instituicao->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($g_instituicoes);
        // die();

        $i = 0;
        foreach ($g_instituicoes as $c_instituicao):
            // pr($c_instituicao);
            // pr($c_instituicao['Instituicao']['id']);
            $ultimoperiodo = NULL;

            $z = 0;
            $instituicao_periodo = NULL;
            foreach ($c_instituicao['Estagiario'] as $c_periodo):
                $instituicao_periodo[$z] = $c_periodo['periodo'];
                // pr($c_periodo['periodo']);
                $z++;
            endforeach;
            // pr($instituicao_periodo);
            if ($instituicao_periodo) {
                $ultimoperiodo = max($instituicao_periodo);
                // pr($ultimoperiodo);
            }

            $visitas = sizeof($c_instituicao['Visita']);
            if ($visitas > 0):
                $ultimavisita = max($c_instituicao['Visita']);
            elseif (sizeof($c_instituicao['Visita']) == 0):
                $ultimavisita = NULL;
            endif;
            // pr($ultimavisita);

            $estagiarios = sizeof($c_instituicao['Estagiario']);
            $supervisores = sizeof($c_instituicao['Supervisor']);

            $m_instituicao[$i]['instituicao_id'] = $c_instituicao['Instituicao']['id'];
            $m_instituicao[$i]['instituicao'] = $c_instituicao['Instituicao']['instituicao'];
            $m_instituicao[$i]['expira'] = $c_instituicao['Instituicao']['expira'];
            $m_instituicao[$i]['visita_id'] = isset($ultimavisita['id']) ? $ultimavisita['id'] : NULL;
            $m_instituicao[$i]['visita'] = isset($ultimavisita['data']) ? $ultimavisita['data'] : NULL;
            $m_instituicao[$i]['ultimoperiodo'] = $ultimoperiodo;
            $m_instituicao[$i]['estagiarios'] = $estagiarios;
            $m_instituicao[$i]['supervisores'] = $supervisores;
            $m_instituicao[$i]['area'] = $c_instituicao['Areainstituicao']['area'];
            $m_instituicao[$i]['natureza'] = $c_instituicao['Instituicao']['natureza'];
            $criterio[] = $m_instituicao[$i][$ordem];

            $i++;
        endforeach;

        // Ordeno o array por diferentes criterios ou chaves
        // pr($ordem);
        // pr('muda ' . $mudadirecao);
        // pr('1 ' . $direcao);
        if ($mudadirecao) {
            $direcao = $mudadirecao;
            // pr('2 ' . $direcao);
            if ($direcao == 'ascendente'):
                $direcao = 'descendente';
                array_multisort($criterio, SORT_DESC, $m_instituicao);
            elseif ($direcao == 'descendente'):
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            endif;
        } else {
            if ($direcao == 'ascendente'):
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            elseif ($direcao == 'descendente'):
                array_multisort($criterio, SORT_DESC, $m_instituicao);
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $m_instituicao);
            endif;
            // die();
        }
        // pr('Direcao: ' . $direcao);
        // Paginação //
        if ($pagina) {
            $this->Session->write('pagina', $pagina);
        } else {
            $pagina = $this->Session->read('pagina');
            if (!$pagina) {
                $pagina = 1;
            }
        }
        // pr($pagina);

        if ($linhas == NULL) {
            $linhas = $this->Session->read('linhas');
            if (!$linhas) {
                $linhas = 15;
                $this->Session->write('linhas', $linhas);
            }
        }
        // pr($linhas);
        // die();
        if ($linhas == 0) { // Sem paginação
            $q_paginas = 1;
        } else {
            $registros = sizeof($m_instituicao);
            // echo "Calculo quantos registros: " . $registros . "<br>";
            $q_paginas = $registros / $linhas;
            // echo "Quantas páginas " . ceil($q_paginas) . "<br>";
            // die();
            $c_pagina[] = NULL;
            $pagina_inicial = 0;
            $pagina_final = 0;
            for ($i = 0; $i < ceil($q_paginas); $i++):
                $pagina_inicial = $pagina_inicial + $pagina_final;
                $pagina_final = $linhas;
                $c_pagina[] = array_slice($m_instituicao, $pagina_inicial, $pagina_final);
            endfor;
        }
        // die();
        // $this->set('periodoatual', reset($periodos));
        // $this->set('periodos', $periodos);
        $this->set('linhas', $linhas);
        $this->set('direcao', $direcao);
        $this->set('ordem', $ordem);
        $this->set('pagina', $pagina);
        // echo $linhas . " " .  $pagina . '<br>';
        if ($linhas == 0) {
            $this->set('instituicoes', $m_instituicao);
        } else {
            $this->set('q_paginas', ceil($q_paginas));
            $this->set('paginas', $c_pagina);
            $this->set('instituicoes', $c_pagina[$pagina]);
        }
        // die();
    }

}

?>
