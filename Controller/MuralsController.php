<?php

class MuralsController extends AppController {

    public $name = "Murals";
    public $components = array('Email', 'Auth', 'Paginator', 'Flash');

    // var $scaffold;

    public function beforeFilter() {

        parent::beforeFilter();

        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Flash->success(__('Administrador'));
            // Estudantes podem somente fazer inscricao
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'view');
            // $this->Flash->sucess(__('Estudante'));
            // Professores podem atualizar murais
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('edit', 'index', 'view');
            // $this->Flash->sucess(__('Professor'));
            // No futuro os supervisores poderao lançar murals
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('add', 'edit', 'index', 'view');
            // $this->Flash->sucess(__('Supervisor'));
            // Todos
        } else {
            $this->Auth->allow('index', 'view');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;

        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }

        /* Se o periodo não veio como parametro */
        if (!$periodo) {
            // Capturo o periodo atual de estagio para o mural
            $periodo = $this->Session->read('mural_periodo');
            // Se não está na variavel da session entao pega da configuracao
            if (!$periodo) {
                $this->loadModel("Configuracao");
                $configuracao = $this->Configuracao->findById('1');
                $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
            }
        }
        // pr($periodo);
        // die();

        $this->Session->write('mural_periodo', $periodo);

        /* Capturo todos os periodos para fazer o select */
        $this->Mural->contain();
        $todos_periodos = $this->Mural->find('list', array(
            'fields' => array('Mural.periodo', 'Mural.periodo'),
            'group' => array('Mural.periodo'),
            'order' => array('Mural.periodo DESC')));
        // pr($todos_periodos);
        // die();

        /* Capturo todos os inscritos no mural */
        $mural = $this->Mural->find('all', [
            'contain' => ['Inscricao' => ['Alunonovo' => ['Estagiario']], 'Instituicao' => ['Estagiario.periodo = ' . "'" . $periodo . "'"]],
            'conditions' => ['Mural.periodo' => $periodo],
            'order' => ['Mural.dataInscricao' => 'DESC']
                ]
        );
        // pr($mural);
        // die('mural');

        /* Capturo as vagas e discrimino os inscritos e estagiários para cada oferta de vaga de estágio */
        $total_vagas = 0;
        $total_inscricao = 0;
        $atual = 0;
        foreach ($mural as $c_mural) {

            $total_vagas = $total_vagas + $c_mural['Mural']['vagas'];

            if (isset($c_mural['Inscricao'])):
                $c_inscricao = sizeof($c_mural['Inscricao']);
                $total_inscricao = $total_inscricao + $c_inscricao;
            endif;
            // die();

            /* Captura os alunos inscritos estagiarios e não estagiarios */
            if (isset($c_mural['Instituicao']['Estagiario'])):
                $c_inscricao = sizeof($c_mural['Instituicao']['Estagiario']);
                $atual = $atual + $c_inscricao;
            endif;
            // die();

            foreach ($c_mural['Inscricao'] as $inscricao) {
                // pr($inscricao);

                if (isset($inscricao['Alunonovo']) && !empty($inscricao['Alunonovo'])):
                    if (isset($inscricao['Alunonovo']['Estagiario']) && sizeof($inscricao['Alunonovo']['Estagiario']) > 0):
                        // pr($inscricao);
                        // pr('Estagiario ' . $inscricao['Alunonovo']['registro']);
                        $alunoestagiario[] = $inscricao['Alunonovo']['registro'];
                    else:
                        // pr($inscricao);
                        // pr('Não estagiário ' . $inscricao['Alunonovo']['registro']);
                        $alunonaoestagiario[] = $inscricao['Alunonovo']['registro'];
                    endif;
                else:
                    // pr($inscricao);
                    // pr('Não cadastrado ' . $inscricao['id_aluno']);
                    // pr('Inscrição sem Alunonovo');
                    $alunosnaocadastrados[] = $inscricao['id_aluno'];
                endif;
            }
        };
        $q_alunoestagiario = isset($alunoestagiario) ? count(array_unique($alunoestagiario)) : NULL;
        $q_alunonaoestagiario = isset($alunonaoestagiario) ? count(array_unique($alunonaoestagiario)) : NULL;
        $q_alunosnaocadastrados = isset($alunosnaocadastrados) ? count(array_unique($alunosnaocadastrados)) : NULL;
        // pr($q_alunoestagiario);
        // pr($q_alunonaoestagiario);
        // pr($q_alunosnaocadastrados);

        $this->set('todos_periodos', $todos_periodos);
        $this->set('periodo', $periodo);
        $this->set('total_vagas', $total_vagas);
        $this->set('total_alunos', $q_alunonaoestagiario + $q_alunoestagiario);
        $this->set('alunos_novos', $q_alunonaoestagiario);
        $this->set('alunos_estagiarios', $q_alunoestagiario);
        $this->set('alunosnaocadastrados', isset($alunosnaocadastrados) ? array_unique($alunosnaocadastrados) : NULL);
        $this->set('atual', $atual);
        $this->set('inscricao', $total_inscricao);
        $this->Paginator->settings = [
            'contain' => ['Inscricao' => 'Alunonovo', 'Instituicao' => ['Estagiario.periodo = ' . "'" . $periodo . "'"]],
            'conditions' => ['Mural.periodo' => $periodo],
            'limit' => 10,
            'order' => ['Mural.dataInscricao' => 'DESC']
        ];
        $this->set('mural', $this->Paginator->paginate('Mural'));
    }

    public function inscricaosemaluno() {

        /* Capturo todos os inscritos no mural */
        $this->loadModel('Inscricao');
        $mural = $this->Inscricao->find('all', [
            'contain' => ['Alunonovo'],
            'group' => ['Inscricao.id_aluno'],
            'order' => ['Inscricao.periodo' => 'asc']
                ]
        );
        // pr($mural);
        // die('mural');

        /* Capturo os inscritos sem cadastro em alunonovos */
        $i = 0;
        if (is_array($mural) || is_object($mural)) {
            foreach ($mural as $c_mural) {
                //pr($c_mural['Alunonovo']);
                if (isset($c_mural['Alunonovo']) && empty($c_mural['Alunonovo']['registro'])):
                    $this->Inscricao->contain(['Estagiario' => ['Aluno', 'Alunonovo']]);
                    $estagiario = $this->Inscricao->find('all', [
                        'conditions' => ['Inscricao.id_aluno' => $c_mural['Inscricao']['id_aluno']]
                    ]);
                    $estagiarios[$i] = $estagiario;
                endif;

                $i++;
            }
        }
        $this->set('alunosnaocadastrados', $estagiarios);
    }

    public function add() {

        // pr($this->data);

        if (!empty($this->data)) {

            /* Verifica que o mural esteja cadastrada como Instituicao */
            $this->loadModel('Instituicao');
            $instituicao = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id' => $this->data['Mural']['id_estagio']),
                'fields' => 'Instituicao.instituicao'
            ));
            // pr($instituicao['Instituicao']);
            if ($instituicao):
                // pr($instituicao['Instituicao']['instituicao']);
                if (strlen($instituicao['Instituicao']['instituicao']) > 99):
                    $instituicao['Instituicao']['instituicao'] = substr($instituicao['Instituicao']['instituicao'], 0, 99);
                endif;

                $this->request->data['Mural']['instituicao'] = $instituicao['Instituicao']['instituicao'];

                if ($this->Mural->save($this->data)):
                    $this->Flash->success(__('Mural inserido'));
                    $id_estagio = $this->Mural->getLastInsertId();
                    $this->redirect('/Murals/view/' . $id_estagio);
                endif;
            endif;
        } else {

            // Capturo o periodo atual de estagio para o mural
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
            // die(pr($periodo));
            // Select Instituicoes
            $this->loadModel('Instituicao');
            $instituicoes = $this->Instituicao->find('list', array(
                'fields' => array('id', 'instituicao'),
                'order' => array('instituicao')
            ));
            // Inserir no topo do array
            $instituicoes[0] = '- Seleciona instituicao -';
            asort($instituicoes);
            // pr($instituicoes);
            // Select Areas
            $this->loadModel('Area');
            $areas = $this->Area->find('list', array(
                'fields' => array('id', 'area'),
                'order' => array('area')
            ));
            $areas[0] = '- Selecionar área';
            asort($areas);
            // pr($areas);
            // Select Professores
            // TODO: selecionar apenas professores de OTP
            $this->loadModel('Professor');
            $professores = $this->Professor->find('list', array(
                'fields' => array('id', 'nome'),
                'order' => array('nome')
            ));
            $professores[0] = '- Selecionar professor -';
            asort($professores);
            // pr($professores);
            // $this->set('meses', $this->meses());

            $this->set('instituicoes', $instituicoes);
            $this->set('areas', $areas);
            $this->set('professores', $professores);
            $this->set('periodo', $periodo);
        }
    }

    public function view($id = null) {

        $this->Mural->id = $id;
        $this->set('mural', $this->Mural->read());
    }

    public function edit($id = NULL) {

        $this->Mural->id = $id;

        // Instituicoes para selecionar
        $instituicoes = $this->Mural->Instituicao->find('list', array(
            'fields' => array('id', 'instituicao'),
            'order' => array('instituicao')
        ));
        // pr($instituicoes);
        $this->set('instituicoes', $instituicoes);

        // A lista de professores para selecionar
        $this->loadModel('Professor');
        $professores = $this->Professor->find('list', array(
            'fidelds' => array('id', 'nome'), 'order' => 'nome'));
        $professores[0] = "Selecione";
        $this->set('professores', $professores);

        // A lista das areas para selecionar
        $this->loadModel('Area');
        $areas = $this->Area->find('list', array(
            'fields' => array('id', 'area')));
        $areas[0] = "Selecione";
        $this->set('areas', $areas);

        // $this->set('meses', $this->meses());

        if (empty($this->data)) {

            $this->data = $this->Mural->read();
        } else {

            /* Coloquei para ignorar as validações. Eh ruin mas senao nao funcionava */
            if ($this->Mural->save($this->data, ['validade' => TRUE])) {
                $this->Flash->success(__("Dados atualizados"));
                $this->redirect('/Murals/view/' . $id);
            } else {
                $errors = $this->Mural->invalidFields();
                $this->Session->setFlash(implode(', ', $errors));
                // pr($this->validationErrors);
                $this->Flash->error("Error: Dados não atualizados. Tente novamente.");
                // $this->redirect('/Murals/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        // Busco se ha inscricoes nesse mural
        $inscricoes = $this->Mural->find(' first', array(
            'conditions' => array('Mural.id' => $id)
        ));
        // print_r($id);
        // die();
        // Se ha inscricoes entao primeiro tem que ser excluidas
        if ($inscricoes['Inscricao']) {

            $this->Flash->error(__('Tem que excluir primeiro todos os alunos inscritos para este estágio'));
            $this->redirect('/Inscricaos/index/' . $id);
        } else {

            $this->Mural->delete($id);
            $this->Flash->success(__('Registro excluído'));
            $this->redirect('/Murals/index/');
        }
    }

    public function publicagoogle($id = NULL) {

        $this->Mural->id = $id;
        $mural = $this->Mural->findAllById($id);
        // pr($mural);
        $this->Email->smtpOptions = array(
            'port' => '465',
            'timeout' => '30',
            'host' => 'ssl://smtp.gmail.com',
            'username' => 'estagio.ess@gmail.com',
            'password' => 'e$tagi0ess',
        );
        /* Set delivery method */
        $this->Email->delivery = 'smtp';
        //$this->Email->to = $user['email'];
        $this->Email->to = 'estagio_ess@googlegroups.com';
        $this->Email->subject = $mural[0]['Mural']['instituicao'];
        $this->Email->replyTo = '"ESS/UFRJ - Estágio" <estagio@ess.ufrj.br>';
        $this->Email->from = '"ESS/UFRJ - Estágio" <estagio@ess.ufrj.br>';
        $this->Email->template = 'google'; // note no '.ctp'
        //Send as 'html', 'text' or 'both' (default is 'text')
        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        /* Do not pass any args to send() */
        $this->set('mural', $mural);
        $this->Email->send();
        /* Check for SMTP errors. */
        $this->set('smtp-errors', $this->Email->smtpError);

        $this->redirect('https://groups.google.com/forum/?fromgroups&pli=1#!forum/estagio_ess');
    }

    public function publicacartaz($id = NULL) {

        $this->Mural->id = $id;
        $mural = $this->Mural->findAllById($id);
        // pr($mural);
        $this->set('mural', $mural);

        $this->response->header(array("Content-type: application/pdf"));
        $this->response->type("pdf");
        $this->layout = "pdf";
        $this->render();
    }

}

?>
