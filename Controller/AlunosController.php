<?php

App::uses('AppController', 'Controller');

/**
 * Alunos Controller
 *
 * @property Aluno $Folhadeatividade
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 * @property RequestHandlerComponent $RequestHandler
 * @property AuthComponent $Auth
 */
class AlunosController extends AppController {

    public $name = 'Alunos';
    public $components = array('Auth', 'Paginator', 'RequestHandler', 'Flash');
    public $paginate = array(
        'limit' => 15,
        'contain' => array('Estagiario')
    );

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit', 'avaliacaosolicita', 'avaliacaoverifica', 'avaliacaoedita', 'avaliacaoimprime', 'avaliacaoimprimepdf', 'folhasolicita', 'folhadeatividades', 'folhadeatividadespdf');
            // $this->Session->setFlash("Estudante");
            // Professor
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit', 'avaliacaosolicita', 'avaliacaoedita', 'avaliacaoimprimepdf', 'folhasolicita', 'folhadeatividadespdf');
            // $this->Session->setFlash("Professor");
            // Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'avaliacaosolicita', 'avaliacaoverifica', 'avaliacaoedita', 'avaliacaoimprime', 'avaliacaoimprimepdf', 'folhasolicita', 'folhadeatividades', 'folhadeatividadespdf');
            // $this->Flash->success(__("Supervisor"));
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->Paginator->settings = [
            'Aluno' => [
                'limit' => 10,
                'order' => [
                    'Aluno.nome' => 'asc']
            ]
        ];

        $this->set('alunos', $this->Paginator->paginate('Aluno'));
    }

    public function view($id = NULL) {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query('registro');
        }
        // pr($registro);
        // die('registro');
        // echo "Aluno";
        // die(pr($this->Session->read('numero')));
        // Se eh estudante somente o próprio pode ver
        // echo $this->Session->read('numero');
        // die();
        if ($this->Session->read('id_categoria') != 1) {
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
        }

        /* Calculo o id a partir do registro */
        if ($registro) {
            $aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro]
            ]);
            if ($aluno_id) {
                $id = $aluno_id['Aluno']['id'];
            } else {
                $this->Flash->error(__("Registro do estudante inexistente"));
                $this->redirect('/alunos/index');
                die();
            }
        }
        // pr($id);
        // die();
        $this->Aluno->id = $id;

        if ($id):
            $instituicao = $this->Aluno->find('first', [
                'conditions' => ['Aluno.id' => $id]
            ]);
        elseif ($registro):
            $instituicao = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro]
            ]);
        endif;

        if (!isset($instituicao) || empty($instituicao)) {
            $this->Flash->error(__('Estudante sem estágio'));
            $this->redirect('/Alunos/index');
            die();
        }

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
        if (isset($c_estagios) && !(empty($c_estagios))):
            array_multisort(array_column($c_estagios, 'nivel'), SORT_ASC, $c_estagios);
        // array_multisort($criterio, SORT_ASC, $c_estagios);
        elseif (isset($nao_estagios) && !(empty($nao_estagios))):
            array_multisort(array_column($nao_estagios, 'periodo'), SORT_ASC, $nao_estagios);
            $this->set('nao_obrigatorio', $nao_estagios);
        else:
            $this->Flash->error(__("Não há registros."));
            $this->redirect('/alunos/index');
            die();
        endif;
        // pr($c_estagios);
        // pr($nao_estagios);

        $this->set('c_estagios', $c_estagios);

        $proximo = $this->Aluno->find('neighbors', array(
            'field' => 'nome', 'value' => $aluno['nome']));
        // $this->set('alunos', $this->paginate('Aluno', array('id'=>$id)));
        $this->set('alunos', $aluno);
        $this->set('estagios', $estagios);
    }

    public function planilhacress($id = NULL) {

        $periodo = isset($this->params['named']['periodo']) ? $this->params['named']['periodo'] : NULL;
        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }
        // pr($periodo);
        // die();
        // $periodo = '2015-2';
        $ordem = 'Aluno.nome';

        $periodototal = $this->Aluno->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')));

        // pr($totalperiodo);
        // die();
        $periodosunicos = array_unique($periodototal);
        foreach ($periodosunicos as $c_periodo):
            $periodos[$c_periodo] = $c_periodo;
        endforeach;

        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $cress = $this->Aluno->Estagiario->find('all', array(
            'fields' => array('Estagiario.periodo', 'Aluno.id', 'Aluno.nome', 'Instituicao.id', 'Instituicao.instituicao', 'Instituicao.cep', 'Instituicao.endereco', 'Instituicao.bairro', 'Supervisor.nome', 'Supervisor.cress', 'Professor.nome'),
            'conditions' => array('Estagiario.periodo' => $periodo),
            'order' => array('Aluno.nome')
        ));

        // pr($cress);
        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoatual', $periodo);
        // die();
    }

    public function edit($id = NULL) {

        if (empty($id)) {
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->request->query('registro')],
                'fields' => 'id'
            ]);
            if ($aluno) {
                $id = $aluno['Aluno']['id'];
            }
        }

        if ($this->Session->read('id_categoria') != 1) {
            if ($this->Session->read('numero')) {
                $verifica = $this->Aluno->findByRegistro($this->Session->read('numero'));
                if ($id != $verifica['Aluno']['id']) {
                    $this->Flash->error(__("Acesso não autorizado"));
                    $this->redirect("/Murals/index");
                    die("Não autorizado");
                }
            }
        }

        $this->Aluno->id = $id;

        // $this->set('meses', $this->meses());

        if (empty($this->data)) {
            $this->data = $this->Aluno->read();
        } else {

            $duplicada = $this->Aluno->findByRegistro($this->data['Aluno']['registro']);
            if ($duplicada) {
                // $this->Session->setFlash("Este número de aluno já está cadastrado");
            }
            if ($this->Aluno->save($this->data)) {
                // print_r($this->data);
                $this->Flash->success(__("Atualizado"));

                // Verfico se esta fazendo inscricao para selecao de estagio
                $inscricao_selecao_estagio = $this->Session->read('id_instituicao');
                // Ainda nao posso apagar
                // $this->Session->delete('id_instituicao');
                // Verifico se foi chamado desde solicitacao do termo
                $registro_termo = $this->Session->read('termo');
                // $this->Session->delete('termo');

                if ($inscricao_selecao_estagio) {
                    $this->redirect('/Inscricaos/inscricao?registro=' . $this->data['Aluno']['registro']);
                } elseif ($registro_termo) {
                    $this->redirect('/Inscricaos/termocompromisso?registro=' . $registro_termo);
                } else {
                    $this->redirect('/Alunos/view/' . $id);
                }
            }
        }
    }

    public function delete($id = NULL) {

        // Se tem pelo menos um estagio nao excluir
        $estagiario = $this->Aluno->Estagiario->findById_aluno($id);
        if ($estagiario) {
            $this->Flash->error(__('Aluno com estágios não foi excluido. Exclua os estágios primeiro.'));
            $this->redirect(array('url' => 'view/' . $id));
        } else {
            $this->Aluno->delete($id);
            $this->Flash->success(__('O registro ' . $id . ' foi excluido.'));
            $this->redirect(array('url' => 'index'));
        }
    }

    public function busca($nome = NULL) {

        // Para paginar os resultados da busca por nome
        if (isset($nome)) {
            $this->request->data['Aluno']['nome'] = $nome;
        }

        if (!empty($this->data['Aluno']['nome'])) {

            $condicaoaluno = array('Aluno.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
            $alunos = $this->Aluno->find('all', [
                'conditions' => $condicaoaluno,
                'order' => 'nome'
            ]);
            // pr($alunos);
            // die();
            // Nenhum resultado
            if (empty($alunos)) {
                $this->loadModel('Alunonovo');
                $condicaoalunonovo = array('Alunonovo.nome like' => '%' . $this->data['Aluno']['nome'] . '%');
                $alunonovos = $this->Alunonovo->find('all', array('conditions' => $condicaoalunonovo));
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros"));
                } else {
                    $this->Paginator->settings = array('order' => array('Alunonovo.nome ASC'), 'limit' => 10, 'conditions' => $condicaoalunonovo);
                    $this->set('alunos', $this->Paginator->paginate('Alunonovo'));
                    $this->set('nome', $this->data['Aluno']['nome']);
                }
            } else {
                $this->Paginator->settings = ['order' => 'Aluno.nome ASC', 'limit' => 10, 'conditions' => $condicaoaluno];
                $this->set('alunos', $this->Paginator->paginate('Aluno'));
                $this->set('nome', $this->data['Aluno']['nome']);
            }
        }
    }

    public function busca_dre() {

        if (!empty($this->data['Aluno']['registro'])) {
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
                    $this->Flash->error(__("Não foram encontrados registros do aluno"));
                    $this->redirect('/Alunos/busca');
                } else {
                    // $this->set('alunos', $alunonovos);
                    // die('redirect');
                    $this->redirect('/Alunonovos/view/' . $alunonovos['Alunonovo']['id']);
                }
            } else {
                // pr($alunos['Aluno']['id']);
                // $this->set('alunos', $alunos);
                $this->redirect('/Alunos/view/' . $alunos['Aluno']['id']);
            }
        }
    }

    public function busca_email() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByEmail($this->data['Aluno']['email']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do email aluno"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunos/busca');
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function busca_cpf() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByCpf($this->data['Aluno']['cpf']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do CPF"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunos/busca');
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    /*
     * Aluno sem estágio não pode existir.
     * Todos os alunos são estagiários.
     * Somente os Alunonovos podem estar sem estágio (porque estão cadastrados para buscar estágio).
     */

    public function add($id = NULL) {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (empty($registro)) {
            $registro = $this->request->query('registro');
            if (empty($registro)) {
                $registro = isset($this->data['Aluno']['registro']) ? $this->data['Aluno']['registro'] : NULL;
            }
        }
        // pr($this->data);
        // pr($registro);
        // die('registro');
        if (empty($registro)) {
            $this->Flash->error(__('Informar o número de registro do estudante'));
            $this->redirect('/Alunonovos/busca_dre');
            die();
        }
        // pr($registro);
        // die('registro');

        if (!empty($this->data)) {
            // pr($this->data);

            if ($this->Aluno->save($this->data)) {
                $this->Flash->success(__('Dados do aluno inseridos!'));
                $this->Aluno->getLastInsertId();
                $this->redirect('/Alunos/view/' . $this->Aluno->getLastInsertId());
                die();
            }
        }

        if ($registro) {

            // Primeiro verifico se ja nao esta cadastrado
            $alunojacadastrado = $this->Aluno->find('first', array(
                'conditions' => array('Aluno.registro' => $registro)
            ));

            if (!empty($alunojacadastrado)) {
                $this->Flash->success(__("Aluno já cadastrado"));
                $this->redirect('/Alunos/view/' . $alunojacadastrado['Aluno']['id']);
                die();
            }

            // Logo busco entre os alunos novos
            $this->loadModel('Alunonovo');
            $alunonovo = $this->Alunonovo->find('first', array(
                'conditions' => array('Alunonovo.registro' => $id)
            ));
            // pr($alunonovo);
            // pr($alunojacadastrado);
            // die();
            // pr($alunonovo);
            // Se não está cadastrado como alunonovo tem que fazer cadastro lá
            $this->Flash->error(__("Fazer cadastro primeiro como Alunonovo"));
            $this->redirect('/Alunonovos/add/' . $alunonovo['Alunonovo']['id']);
            die();
        }
        // die();
        if ($registro) {
            $this->set('registro', $registro);
        }
    }

    /*
     * Funcao para atualizar dados do supervisor do estagiario
     */

    public function avaliacaosolicita() {

        // Verificar periodo da folha de avaliação
        // pr($this->data);
        // die('this->data');
        if ($this->data) {
            $aluno = $this->Aluno->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $this->data['Aluno']['registro']),
                'order' => array('Estagiario.nivel DESC')
            ));
            // pr($aluno['Supervisor']);
            // die("avaliacao");
            if ($aluno) {
                if (!empty($aluno['Supervisor']['id'])) {
                    $this->Flash->error(__("Verificar e completar dados do supervisor da instituicao."));
                    // die('Verificar dados do supervisor');
                    $this->redirect('/Alunos/avaliacaoedita?supervisor_id=' . $aluno['Supervisor']['id'] . '&registro=' . $this->data['Aluno']['registro']);
                } else {
                    $this->Flash->error(__("Não foi indicado supervisor da instituicao."));
                    // die('Retorna para solicitar termo de compromisso');
                    $this->redirect('/alunos/view?registro=' . $aluno['Aluno']['registro']);
                }
            } else {
                $this->Flash->error(__("Não há estágios cadastrados para este estudante"));
            }
        }
    }

    /* Administrador, professor e supervisor precisam solicitar a folha */

    public function folhasolicita() {

        $categoria = $this->Session->read('id_categoria');
        // pr($categoria);
        // die();
        if ($categoria != '2') {

            // pr($this->data);
            if (empty($this->data)) {
                $this->data = $this->Aluno->read();
            } else {
                // pr($this->data());
                // $this->Session->write('menu_aluno', 'estagiario');
                $this->Session->write('numero', $this->data['Aluno']['registro']);
                // $this->redirect('folhadeatividades');
                $this->redirect(['action' => 'folhadeatividadespdf', $this->data['Aluno']['registro'], 'ext' => 'pdf', 'folhadeatividades']);
            }
        } else {
            $this->redirect(['action' => 'folhadeatividadespdf', $this->Session->read('numero'), 'ext' => 'pdf', 'folhadeatividades']);
        }
    }

    public function folhadeatividades() {

        $dre = $this->Session->read('numero');
        if (empty($dre)) {
            $this->redirect('folhasolicita');
        } else {
            // pr($dre);
            $estagiario = $this->Aluno->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $dre),
                'order' => array('Estagiario.nivel DESC')
            ));
            // pr($estagiario);
            // die('estagiario');
            if (!$estagiario) {
                $this->Flash->error(__("Estudante sem estágio"), "flash_notification");
                $this->redirect('/Alunonovos/view?registro=' . $this->Session->read('numero'));
            }
            // $this->Session->delete('numero');
            // die('estagiario');

            $dia = strftime('%e', time());
            $mes = strftime('%B', time());
            $ano = strftime('%Y', time());

            $this->set('dia', $dia);
            $this->set('mes', $mes);
            $this->set('ano', $ano);
            $this->set('registro', $registro = $estagiario['Aluno']['registro']);
            $this->set('estudante', $estudante = $estagiario['Aluno']['nome']);
            $this->set('nivel', $nivel = $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $periodo = $estagiario['Estagiario']['periodo']);
            $this->set('supervisor', $supervisor = $estagiario['Supervisor']['nome']);
            $this->set('cress', $cress = $estagiario['Supervisor']['cress']);
            $this->set('celular', $celular = $estagiario['Supervisor']['celular']);
            $this->set('instituicao', $instituicao = $estagiario['Instituicao']['instituicao']);
            $this->set('professor', $professor = $estagiario['Professor']['nome']);

            $this->redirect(['action' => 'folhadeatividadespdf', $registro, 'ext' => 'pdf', $registro]);
            // echo $this->Html->link(__('Imprime PDF'), array('action' => 'folhadeatividadespdf', "?" => ["registro" => $registro], 'ext' => 'pdf', $registro));
        }
    }

    public function folhadeatividadespdf($id = NULL) {

        $dre = $this->Session->read('numero');
        if (empty($dre)) {
            $this->redirect('folhasolicita');
        } else {
            // pr($dre);
            $estagiario = $this->Aluno->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $dre),
                'order' => array('Estagiario.nivel DESC')
            ));
            // pr($estagiario);
            // die('estagiario');
            if (!$estagiario) {
                $this->Flash->error(__("Estudante sem estágio"), "flash_notification");
                $this->redirect('/Alunonovos/view?registro=' . $this->Session->read('numero'));
            }
            // $this->Session->delete('numero');
            // die('estagiario');

            $this->set('registro', $registro = $estagiario['Aluno']['registro']);
            $this->set('estudante', $estudante = $estagiario['Aluno']['nome']);
            $this->set('nivel', $nivel = $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $periodo = $estagiario['Estagiario']['periodo']);
            $this->set('supervisor', $supervisor = $estagiario['Supervisor']['nome']);
            $this->set('cress', $cress = $estagiario['Supervisor']['cress']);
            $this->set('celular', $celular = $estagiario['Supervisor']['celular']);
            $this->set('instituicao', $instituicao = $estagiario['Instituicao']['instituicao']);
            $this->set('professor', $professor = $estagiario['Professor']['nome']);
            // die();
        }
    }

    public function avaliacaoedita() {

        // pr($this->data);

        $supervisor_id = isset($this->params['named']['supervisor_id']) ? $this->params['named']['supervisor_id'] : NULL;
        if (!$supervisor_id) {
            $supervisor_id = $this->request->query('supervisor_id');
        }

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query('registro');
        }
        // pr($supervisor_id);
        // pr($registro);
        // die('registro');

        $estagiario = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));
        // pr($estagiario);
        // die('estagiario');

        if ($estagiario) {

            $dia = strftime('%e', time());
            $mes = strftime('%B', time());
            $ano = strftime('%Y', time());

            $this->set('dia', $dia);
            $this->set('mes', $mes);
            $this->set('ano', $ano);

            $this->set('estagiario', $estagiario);
            $this->set('aluno', $estagiario['Aluno']['nome']);
            $this->set('estudante', $estagiario['Aluno']['nome']);
            $this->set('registro', $estagiario['Aluno']['registro']);
            $this->set('professor', $estagiario['Professor']['nome']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('supervisor_id', $estagiario['Supervisor']['id']);
            $this->set('cress', $estagiario['Supervisor']['cress']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
            // die("empty");
        }
        // die("avaliacaoedita");

        $this->loadModel('Supervisor');
        $this->Supervisor->id = $supervisor_id;

        if (empty($this->data)) {
            // die("empty");
            $this->data = $this->Supervisor->read();
        } else {
            // print_r($this->data);
            // die("avaliacaoedita");

            if (!$this->data['Supervisor']['cress']) {
                $this->Flash->error("O número de CRESS é obrigatório");
                $this->redirect(__('/Alunos/avaliacaosolicita?supervisor_id=' . $supervisor_id . '&' . 'registro=' . $registro));
                die("O número de Cress é obrigatório");
            }

            if (!$this->data['Supervisor']['nome']) {
                $this->Flash->error(__("O nome do supervisor é obrigatório"));
                $this->redirect('/Alunos/avaliacaosolicita?supervisor_id=' . $supervisor_id . '&' . 'registro=' . $registro);
                die("O nome do supervisor é obrigatório");
            }

            if ((!$this->data['Supervisor']['celular']) && (!$this->data['Supervisor']['telefone'])) {
                $this->Flash->error(__("O número de telefone ou celular é obrigatório"));
                $this->redirect('/Alunos/avaliacaosolicita?supervisor_id=' . $supervisor_id . '&' . 'registro=' . $registro);
                die("O número de telefone ou celular é obrigatório");
            }

            if (!$this->data['Supervisor']['email']) {
                $this->Flash->error(__("O endereço de email é obrigatório"));
                $this->redirect('/Alunos/avaliacaosolicita?supervisor_id=' . $supervisor_id . '&' . 'registro=' . $registro);
                die("O email é obrigatório");
            }

            if ($this->Supervisor->save($this->data)) {
                // die();
                // pr($this->data);
                $this->Flash->success(__("Atualizado"));
                // $this->redirect(['action' => 'folhadeatividadespdf', $registro, 'ext' => 'pdf', $registro]);
                $this->redirect(['action' => 'avaliacaoimprimepdf', '?' => ['registro' => $registro], 'ext' => 'pdf', $registro]);
                die();
            }
        }
    }

    public function avaliacaoimprime() {

        $registro = isset($this->request->params['named']['registro']) ? $this->request->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query('registro');
        }
        // pr($registro);
        // die('registro');

        $aluno = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));
        // pr($aluno);
        // die();

        $estudante = $aluno['Aluno']['nome'];
        // $registro = $aluno['Aluno']['registro'];
        $nivel = $aluno['Estagiario']['nivel'];
        $periodo = $aluno['Estagiario']['periodo'];
        $supervisor = $aluno['Supervisor']['nome'];
        $cress = $aluno['Supervisor']['cress'];
        $telefone = $aluno['Supervisor']['telefone'];
        $celular = $aluno['Supervisor']['celular'];
        $email = $aluno['Supervisor']['email'];
        $instituicao = $aluno['Instituicao']['instituicao'];
        $endereco_inst = $aluno['Instituicao']['endereco'];
        $professor = $aluno['Professor']['nome'];

        $this->set('estudante', $estudante);
        $this->set('registro', $registro);
        $this->set('nivel', $nivel);
        $this->set('periodo', $periodo);
        $this->set('supervisor', $supervisor);
        $this->set('cress', $cress);
        $this->set('telefone', $telefone);
        $this->set('celular', $celular);
        $this->set('email', $email);
        $this->set('instituicao', $instituicao);
        $this->set('endereco_inst', $endereco_inst);
        $this->set('professor', $professor);
    }

    public function avaliacaoimprimepdf($id = NULL) {

        $registro = isset($this->request->params['named']['registro']) ? $this->request->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query('registro');
        }
        // pr($registro);
        // die('registro');

        $aluno = $this->Aluno->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'order' => array('Estagiario.nivel DESC')
        ));
        // pr($aluno);
        // die();

        $estudante = $aluno['Aluno']['nome'];
        $registro = $aluno['Aluno']['registro'];
        $nivel = $aluno['Estagiario']['nivel'];
        $periodo = $aluno['Estagiario']['periodo'];
        $supervisor = $aluno['Supervisor']['nome'];
        $cress = $aluno['Supervisor']['cress'];
        $telefone = $aluno['Supervisor']['telefone'];
        $celular = $aluno['Supervisor']['celular'];
        $email = $aluno['Supervisor']['email'];
        $instituicao = $aluno['Instituicao']['instituicao'];
        $endereco_inst = $aluno['Instituicao']['endereco'];
        $professor = $aluno['Professor']['nome'];

        $this->set('estudante', $estudante);
        $this->set('registro', $registro);
        $this->set('nivel', $nivel);
        $this->set('periodo', $periodo);
        $this->set('supervisor', $supervisor);
        $this->set('cress', $cress);
        $this->set('telefone', $telefone);
        $this->set('celular', $celular);
        $this->set('email', $email);
        $this->set('instituicao', $instituicao);
        $this->set('endereco_inst', $endereco_inst);
        $this->set('professor', $professor);
    }

    public function planilhaseguro($id = NULL) {

        $periodo = isset($this->request->params['named']['periodo']) ? $this->request->params['named']['periodo'] : NULL;
        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }
        // pr($periodo);
        // die();
        // $periodo = '2015-2';
        $ordem = 'nome';

        $periodototal = $this->Aluno->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')));

        // pr($totalperiodo);
        // die();
        $periodosunicos = array_unique($periodototal);
        foreach ($periodosunicos as $c_periodo):
            $periodos[$c_periodo] = $c_periodo;
        endforeach;

        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $seguro = $this->Aluno->Estagiario->find('all', array(
            'fields' => array('Aluno.id', 'Aluno.nome', 'Aluno.cpf', 'Aluno.nascimento', 'Aluno.registro',
                'Estagiario.nivel', 'Estagiario.periodo',
                'Instituicao.instituicao'),
            'conditions' => array('Estagiario.periodo' => $periodo),
            'order' => array('Estagiario.nivel')));

        // pr($seguro);
        // die();
        $i = 0;
        foreach ($seguro as $c_seguro) {

            if ($c_seguro['Estagiario']['nivel'] == 1) {

                // Início
                $inicio = $c_seguro['Estagiario']['periodo'];

                // Final
                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $novoindicasemestre = $indicasemestre + 1;
                    $final = $novoano . "-" . $novoindicasemestre;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 2;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 2) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $novoano = $ano - 1;
                    $inicio = $novoano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $inicio = $ano . "-" . "1";
                }

                // Final
                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . "2";
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 3) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                $novoano = $ano - 1;
                $inicio = $novoano . "-" . $indicasemestre;

                // Final
                if ($indicasemestre == 1) {
                    // $ano = $ano + 1;
                    $final = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 4) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 1;
                    $inicio = $ano . "-" . 1;
                }

                // Final
                $final = $c_seguro['Estagiario']['periodo'];

                // Estagio não obrigatório. Conto como estágio 5
            } elseif ($c_seguro['Estagiario']['nivel'] == 9) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                }

                // Final
                $final = $c_seguro['Estagiario']['periodo'];

                // echo "Nível: " . $c_seguro['Estagiario']['nivel'] . " Período: " . $c_seguro['Estagiario']['periodo'] . " Início: " . $inicio . " Final: " . $final . '<br>';
            }

            $t_seguro[$i]['id'] = $c_seguro['Aluno']['id'];
            $t_seguro[$i]['nome'] = $c_seguro['Aluno']['nome'];
            $t_seguro[$i]['cpf'] = $c_seguro['Aluno']['cpf'];
            $t_seguro[$i]['nascimento'] = $c_seguro['Aluno']['nascimento'];
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $c_seguro['Aluno']['registro'];
            $t_seguro[$i]['curso'] = "UFRJ/Serviço Social";
            if ($c_seguro['Estagiario']['nivel'] == 9):
                // pr("Não");
                $t_seguro[$i]['nivel'] = "Não obrigatório";
            else:
                // pr($c_seguro['Estagiario']['nivel']);
                $t_seguro[$i]['nivel'] = $c_seguro['Estagiario']['nivel'];
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro['Estagiario']['periodo'];
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            $t_seguro[$i]['instituicao'] = $c_seguro['Instituicao']['instituicao'];
            $criterio[$i] = $t_seguro[$i][$ordem];

            $i++;
        }
        if (!empty($t_seguro)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        // pr($t_seguro);
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
    }

    public function cargahoraria($ordem = NULL) {

        $ordem = isset($this->params['named']['ordem']) ? $this->params['named']['ordem'] : NULL;
        if (!$ordem) {
            $ordem = $this->request->query('ordem');
        }

        if (empty($ordem)):
            $ordem = 'q_semestres';
        endif;

        // pr($ordem);
        // die();

        $alunos = $this->Aluno->find('all');

        // pr($alunos);
        $i = 0;
        foreach ($alunos as $c_aluno):
            // pr($c_aluno);
            //            if (sizeof($c_aluno['Estagiario']) >= 4):
            // pr(sizeof($c_aluno['Estagiario']));
            $cargahorariatotal[$i]['id'] = $c_aluno['Aluno']['id'];
            $cargahorariatotal[$i]['registro'] = $c_aluno['Aluno']['registro'];
            $cargahorariatotal[$i]['q_semestres'] = sizeof($c_aluno['Estagiario']);
            $carga_estagio = NULL;
            $y = 0;
            foreach ($c_aluno['Estagiario'] as $c_estagio):
                // pr($c_estagio);
                if ($c_estagio['nivel'] == 1):
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['ch'];
                // $criterio[$i][$ordem] = $c_estagio['periodo'];
                else:
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['ch'];
                // $criterio[$i][$ordem] = NULL;
                endif;
                $y++;
            endforeach;
            $cargahorariatotal[$i]['ch_total'] = $carga_estagio['ch'];
            $criterio[$i] = $cargahorariatotal[$i][$ordem];
            $i++;
            //            endif;
        endforeach;

        array_multisort($criterio, SORT_ASC, $cargahorariatotal);
        // pr($cargahorariatotal);
        $this->set('cargahorariatotal', $cargahorariatotal);

        // die();
    }

    public function padroniza() {

        $alunos = $this->Aluno->find('all', array('fields' => array('id', 'nome', 'email', 'endereco', 'bairro')));
        // pr($alunos);
        // die();
        foreach ($alunos as $c_aluno):

            if ($c_aluno['Aluno']['email']):
                $email = strtolower($c_aluno['Aluno']['email']);
                $this->Aluno->query("UPDATE alunos set email = " . "\"" . $email . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno["Aluno"]['nome']):
                $nome = ucwords(strtolower($c_aluno['Aluno']['nome']));
                $this->Aluno->query("UPDATE alunos set nome = " . "\"" . $nome . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno['Aluno']['endereco']):
                $endereco = ucwords(strtolower($c_aluno['Aluno']['endereco']));
                $this->Aluno->query("UPDATE alunos set endereco = " . "\"" . $endereco . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno['Aluno']['bairro']):
                $bairro = ucwords(strtolower($c_aluno['Aluno']['bairro']));
                $this->Aluno->query("UPDATE alunos set bairro = " . "\"" . $bairro . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

        endforeach;
    }

}

?>
