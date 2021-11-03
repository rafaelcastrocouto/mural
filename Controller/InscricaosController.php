<?php

class InscricaosController extends AppController {

    public $name = "Inscricaos";
    public $components = array('Email', 'Auth', 'RequestHandler', 'Paginator', 'Flash');
    private $Estagiario;

    public function beforeFilter() {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'view', 'add', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita', 'imprimepdf', 'imprimepdfremoto');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('index', 'view', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita', "imprimepdf");
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('index', 'view', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita', 'imprimepdf');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index($id = NULL) {

        $ordem = isset($_REQUEST['ordem']) ? $_REQUEST['ordem'] : "nome";
        // echo "Ordem: " . $ordem;
        // die();
        // Capturo o periodo de estagio para o mural
        $periodo = $this->Session->read('mural_periodo');
        if (!$periodo) {
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
        }

        if ($id) {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.id_instituicao' => $id),
                'fields' => array('Inscricao.periodo', 'Inscricao.data', 'Inscricao.id_instituicao', 'Inscricao.id', 'Inscricao.id_aluno', 'Inscricao.aluno_id', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Estagiario.id', 'Estagiario.periodo', 'Estagiario.id_instituicao', 'Mural.id_estagio', 'Mural.vagas', 'Mural.instituicao', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email'),
                'group' => ['Inscricao.id'],
                'order' => array('Aluno.nome' => 'asc'),
                    )
            );
            // pr($inscritos);
            // die();
            if ($inscritos) {
                $vagas = $inscritos[0]['Mural']['vagas'];
                // pr($inscritos[0]['Mural']['vagas']);
                $id_instituicao = $inscritos[0]['Mural']['id_estagio'];
            }
        } else {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.periodo' => $periodo),
                'fields' => array('Inscricao.periodo', 'Inscricao.data', 'Inscricao.id_instituicao', 'Inscricao.id', 'Inscricao.id_aluno', 'Inscricao.aluno_id', 'Mural.id_estagio', 'Mural.instituicao', 'Mural.vagas', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email'),
                'group' => array('Inscricao.id'),
                'order' => array('Aluno.nome' => 'asc')
                    )
            );
            // pr($inscritos);
            // die();
            if ($inscritos) {
                $vagas = $inscritos[0]['Mural']['vagas'];
                // pr($inscritos[0]['Mural']['vagas']);
                $id_instituicao = $inscritos[0]['Mural']['id_estagio'];
            }
        }
        // pr($inscritos);
        // die();
        // Somente se há inscritos e a consulta tem origem numa instituição
        if ($inscritos) {
            // pr($inscritos);
            // die();
            // Junto todo num array para ordernar alfabeticamente
            $i = 0;
            foreach ($inscritos as $c_inscritos) {

                if (!empty($c_inscritos['Aluno']['nome'])) {
                    $inscritos_ordem[$i]['periodo'] = $c_inscritos['Inscricao']['periodo'];
                    $inscritos_ordem[$i]['data'] = $c_inscritos['Inscricao']['data'];
                    $inscritos_ordem[$i]['id_instituicao'] = $c_inscritos['Inscricao']['id_instituicao'];
                    $inscritos_ordem[$i]['mural_instituicao'] = $c_inscritos['Mural']['instituicao'];
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Aluno']['nome'];
                    $inscritos_ordem[$i]['id'] = $c_inscritos['Aluno']['id'];
                    $inscritos_ordem[$i]['id_inscricao'] = $c_inscritos['Inscricao']['id'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
                    $inscritos_ordem[$i]['nascimento'] = $c_inscritos['Aluno']['nascimento'] ? date('d-m-Y', strtotime($c_inscritos['Aluno']['nascimento'])) : '';
                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Aluno']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Aluno']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Aluno']['email'];
                    $inscritos_ordem[$i]['tipo'] = 1; // Estagiario
                    // Para ordenar o array
                    $criterio[] = $inscritos_ordem[$i][$ordem];
                    // pr($inscritos_ordem);
                    // die();
                } else {
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Alunonovo']['nome'];
                    $inscritos_ordem[$i]['id'] = $c_inscritos['Alunonovo']['id'];
                    $inscritos_ordem[$i]['id_instituicao'] = $c_inscritos['Inscricao']['id_instituicao'];
                    $inscritos_ordem[$i]['mural_instituicao'] = $c_inscritos['Mural']['instituicao'];
                    $inscritos_ordem[$i]['data'] = $c_inscritos['Inscricao']['data'];
                    $inscritos_ordem[$i]['id_inscricao'] = $c_inscritos['Inscricao']['id'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
                    $inscritos_ordem[$i]['nascimento'] = $c_inscritos['Alunonovo']['nascimento'] ? date('d-m-Y', strtotime($c_inscritos['Alunonovo']['nascimento'])) : '';
                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Alunonovo']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Alunonovo']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Alunonovo']['email'];
                    $inscritos_ordem[$i]['tipo'] = 0; // Novo
                    // Para ordenar o array
                    $criterio[] = $inscritos_ordem[$i][$ordem];
                    // pr($inscritos_ordem);
                    // die();
                }
                $i++;
            }
            // pr($inscritos_ordem);
            // die();
            if (isset($criterio))
                array_multisort($criterio, SORT_ASC, $inscritos_ordem);

            /* Conta a quantidade de alunos novos e estagiarios */
            $alunos_estagiarios = 0;
            $alunos_novos = 0;
            foreach ($inscritos as $c_inscritos) {
                // pr($c_inscritos);
                if ($c_inscritos['Aluno']['nome']) {
                    $alunos_estagiarios++;
                } else {
                    $alunos_novos++;
                }
            }
            /* Fim da conta da quantidade de alunos novos e estagiarios */
            if (isset($inscritos[0]['Mural']['instituicao'])) {
                $this->set('instituicao', $inscritos[0]['Mural']['instituicao']);
            }
            if (isset($inscritos[0]['Inscricao']['id_instituicao'])) {
                $this->set('mural_id', $inscritos[0]['Inscricao']['id_instituicao']);
            }

            if (isset($id_instituicao) && (!empty($id_instituicao))):
                $estagiarios = $this->Inscricao->Estagiario->find('all', array(
                    'fields' => array("count('Estagiario.id') as estagiarios"),
                    'conditions' => array('Estagiario.id_instituicao' => $id_instituicao,
                        'Estagiario.periodo' => $periodo)
                ));
            endif;

            $this->set('periodo', $periodo);
            if (isset($vagas)) {
                $this->set('vagas', $vagas);
            }
            if (isset($estagiarios[0][0]['estagiarios'])):
                $this->set('estagiarios', $estagiarios[0][0]['estagiarios']);
            endif;
            if (isset($id_instituicao)):
                $this->set('id_instituicao', $id_instituicao);
            endif;
            $this->set('inscritos', $inscritos_ordem);
        }
    }

    public function orfao() {

        $this->loadModel("Alunonovo");
        $this->set('orfaos', $this->Alunonovo->alunonovorfao());
    }

    public function add($id = NULL) {

        /* Id do mural de estágios */
        // Verifico se foi preenchido o numero de registro
        // O id_aluno eh o registro
        $this->set('id_instituicao', $id);

        if (isset($this->data['Inscricao']['id_aluno'])) {
            // pr($this->data);
            // die();
            /* Verificacoes */
            if ((strlen($this->request->data['Inscricao']['id_aluno'])) < 9) {
                $this->Session->setFlash(__("Registro incorreto"));
                $this->redirect('/Inscricaos/add/');
                die("Registro incorreto");
                exit;
            }

            $inscricao = $this->Inscricao->find('first', [
                'conditions' => [
                    ['Inscricao.id_aluno' => $this->data['Inscricao']['id_aluno']],
                    ['Inscricao.id_instituicao' => $id]
                ]
            ]);
            // pr($inscricao['Inscricao']['id']);
            // die('Já fez inscrição');
            if ($inscricao) {
                $this->Flash->error(__("Inscrição já realizada"));
                $this->redirect('/inscricaos/view/' . $inscricao['Inscricao']['id']);
            }

            /* Com o id_institucao (muralestagio_id) capturo o periodo para o registro de inscricao */
            $this->loadModel('Mural');
            $instituicao = $this->Mural->findById($id, array('fields' => 'periodo'));
            $periodo = $instituicao['Mural']['periodo'];
            // echo "Período: " . $periodo;
            // die();

            /* Capturo o id do Aluno */
            $this->loadModel('Aluno');
            $this->Aluno->recursive = 0;
            $aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->data['Inscricao']['id_aluno']],
                'fields' => 'Aluno.id'
            ]);
            // pr($aluno_id);

            /* Capturo o id do Alunonovo */
            $this->loadModel('Alunonovo');
            $this->Alunonovo->recursive = 0;
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $this->data['Inscricao']['id_aluno']],
                'fields' => 'Alunonovo.id'
            ]);
            // pr($alunonovo_id);
            // die();

            /* Carrego o array de inscrição com os valores */
            $data['Inscricao']['periodo'] = $periodo;
            $data['Inscricao']['id_instituicao'] = $id;
            $data['Inscricao']['data'] = date('Y-m-d');
            $data['Inscricao']['id_aluno'] = $this->data['Inscricao']['id_aluno'];
            $data['Inscricao']['aluno_id'] = isset($aluno_id['Aluno']['id']) ? $aluno_id['Aluno']['id'] : NULL;
            $data['Inscricao']['alunonovo_id'] = $alunonovo_id['Alunonovo']['id'];
            // pr($data);
            // die();

            if ($this->Inscricao->save($data)) {
                $this->Flash->success(__("Inscrição realizada"));
                $this->redirect('/Inscricaos/index/' . $id);
            }
        }
    }

    /*
     * Inscreve o aluno para seleção de estágio
     * O Id e o numero de registro
     * O método é convocado desde Alunos edit por meio do cookie id_instituicao
     * O método ficou obsoleto
     */

    public function inscricao($id = NULL) {

        $registro = $this->request->query('registro');
        // pr($registro);
        // die('registro');
        if ($registro) {
            // Capturo o id da instituicao de inscricao para selecao de estagio (vem tanto de aluno como de alunonvo)
            $id_instituicao = $this->Session->read('id_instituicao');

            if (empty($id_instituicao)) {
                $this->Flash->error(__('Falta selecionar a instituição'));
                $this->redirect('/Murals/index');
            }
            // echo "Instituicao: " . $id_instituicao;
            // die();
            // Agora sim posso apagar
            $this->Session->delete('id_instituicao');

            /* Com o id_institucao (muralestagio_id) capturo o periodo para o registro de inscricao */
            $this->loadModel('Mural');
            $instituicao = $this->Mural->findById($id_instituicao, array('fields' => 'periodo'));
            $periodo = $instituicao['Mural']['periodo'];
            // echo "Período: " . $periodo;
            // die();

            /* Capturo o id do Aluno */
            $this->loadModel('Aluno');
            $this->Aluno->recursive = 0;
            $aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro],
                'fields' => 'Aluno.id'
            ]);
            // pr($aluno_id);
            // die();

            /* Capturo o id do Alunonovo */
            $this->loadModel('Alunonovo');
            $this->Alunonovo->recursive = 0;
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro],
                'fields' => 'Alunonovo.id'
            ]);
            // pr($alunonovo_id);
            // die();

            /* Carrego o array de inscrição com os valores */
            $data['Inscricao']['periodo'] = $periodo;
            $data['Inscricao']['id_instituicao'] = $id_instituicao;
            $data['Inscricao']['data'] = date('Y-m-d');
            $data['Inscricao']['id_aluno'] = $registro;
            $data['Inscricao']['aluno_id'] = ($aluno_id['Aluno']['id']) ? $aluno_id['Aluno']['id'] : NULL;
            $data['Inscricao']['alunonovo_id'] = $alunonovo_id['Alunonovo']['id'];

            // debug($data);
            // pr($data);
            // die();

            if ($this->Inscricao->save($data)) {
                $this->Flash->success(__("Inscrição realizada"));
                $this->redirect('/Inscricaos/index/' . $id_instituicao);
            }
        }
    }

    public function view($id = NULL) {

        $inscricao = $this->Inscricao->findById($id);
        // pr($inscricao);
        $this->set('inscricao', $inscricao);
    }

    public function edit($id = NULL) {

        $this->Inscricao->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Inscricao->read();
        } else {
            if ($this->Inscricao->save($this->data)) {
                $this->Session->setFlash(__("Inscrição atualizada"));
                $this->redirect('/Inscricaos/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        $instituicao = $this->Inscricao->findById($id, array('fields' => 'id_instituicao'));
        $this->Inscricao->delete($id);
        $this->Session->setFlash(__("Inscrição excluída"));
        $this->redirect('/Inscricaos/index/' . $instituicao['Inscricao']['id_instituicao']);
    }

    public function emailparainstituicao($id = NULL) {

        if ($id) {
            $inscritos = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.id_instituicao' => $id),
                'fields' => array('Aluno.nome', 'Inscricao.id', 'Inscricao.id_aluno', 'Aluno.celular', 'Aluno.telefone', 'Aluno.email', 'Alunonovo.nome', 'Alunonovo.celular', 'Alunonovo.telefone', 'Alunonovo.email', 'Mural.id', 'Mural.instituicao', 'Mural.email', 'Inscricao.id_instituicao'),
                'order' => array('Aluno.nome' => 'asc', 'Alunonovo.nome' => 'asc')
                    )
            );
            // pr($inscritos);

            $i = 0;
            foreach ($inscritos as $c_inscritos) {

                if (!empty($c_inscritos['Aluno']['nome'])) {
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Aluno']['nome'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Aluno']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Aluno']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Aluno']['email'];
                    $criterio[$i]['nome'] = $c_inscritos['Aluno']['nome'];
                } else {
                    $inscritos_ordem[$i]['nome'] = $c_inscritos['Alunonovo']['nome'];
                    $inscritos_ordem[$i]['id_aluno'] = $c_inscritos['Inscricao']['id_aluno'];
                    $inscritos_ordem[$i]['telefone'] = $c_inscritos['Alunonovo']['telefone'];
                    $inscritos_ordem[$i]['celular'] = $c_inscritos['Alunonovo']['celular'];
                    $inscritos_ordem[$i]['email'] = $c_inscritos['Alunonovo']['email'];
                    $criterio[$i]['nome'] = $c_inscritos['Alunonovo']['nome'];
                }
                $i++;
            }

            if (isset($inscritos_ordem)) {

                asort($inscritos_ordem);

                if ($inscritos[0]['Mural']['email']) {
                    $this->Email->smtpOptions = array(
                        'port' => '465',
                        'timeout' => '30',
                        'host' => 'ssl://smtp.gmail.com',
                        'username' => 'estagio.ess',
                        'password' => 'e$tagi0ess',
                    );
                    /* Set delivery method */
                    $this->Email->delivery = 'smtp';
                    $this->Email->to = $user['email'];
                    // $this->Email->to = 'uy_luis@hotmail.com'; // $incritos[0]['Mural']['email']
                    $this->Email->to = $inscritos[0]['Mural']['email'];
                    // $this->Email->cc = array('estagio.ess@gmail.com', 'estagio@ess.ufrj.br');
                    $this->Email->subject = 'ESS/UFRJ: Estudantes inscritos para seleção de estágio';
                    $this->Email->replyTo = '"ESS/UFRJ - Coordenação de Estágio & Extensão" <estagio@ess.ufrj.br>';
                    $this->Email->from = '"ESS/UFRJ - Coordenação de Estágio & Extensão" <estagio@ess.ufrj.br>';
                    $this->Email->template = 'emailinstituicao'; // note no '.ctp'
                    // Send as 'html', 'text' or 'both' (default is 'text')
                    $this->Email->sendAs = 'html'; // because we like to send pretty mail

                    $this->set('instituicao', $inscritos);
                    $this->set('inscritos', $inscritos_ordem);

                    /* Do not pass any args to send() */
                    $this->Email->send();
                    /* Check for SMTP errors. */
                    $this->set('smtp-errors', $this->Email->smtpError);

                    // Informo que o email foi enviado
                    $this->loadModel("Mural");
                    $this->Mural->id = $inscritos[0]['Mural']['id'];
                    $this->Mural->savefield('datafax', date('Y-m-d'));

                    $this->Session->setFlash('Email enviado');
                    $this->redirect('/Murals/view/' . $inscritos[0]['Mural']['id']);
                }
            } else {

                $this->Session->setFlash('Imposível enviar email (falta o endereço)');
                $this->redirect('/Murals/view/' . $inscritos[0]['Mural']['id']);
            }
        }
    }

    // Captura o registro digitado pelo estudante
    public function termosolicita() {

        if ($this->request->data) {
            // pr($this->request->data);
            $registro = $this->request->data['Inscricao']['registro'];
            // pr($registro);
            // die("termosoliciata");
            $this->redirect('/Inscricaos/termocompromisso?registro=' . $registro);
        }
    }

    // Com o numero de registro busco as informacoes em estagiario ou alunonovo
    // Se nao esta cadastrado em alunonovo faço o cadastramento
    // Se nao eh estagiario eh um alunonovo entao faço cadastramento
    public function termocompromisso($id = NULL) {
        
        if ($this->data):
            // pr($this->data);
            // die();
            /* Verifico se já está a cópia do alunonovo em aluno */
            $this->loadModel('Aluno');
            $alunoestagiario = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->data['Estagiario']['registro']]
            ]);
            /* Se não está então faço a cópia */
            if (empty($alunoestagiario)):
                $this->loadModel('Alunonovo');
                $estudante = $this->Alunonovo->find('first', [
                    'contain' => [''],
                    'conditions' => ['Alunonovo.registro' => $this->data['Estagiario']['registro']]
                ]);
                /* Retiro o Id para fazer uma inserção e não uma atualização */
                unset($estudante['Alunonovo']['id']);
                $this->Aluno->save($estudante['Alunonovo']);
                $aluno_id = $this->Aluno->getLastInsertID();
                $this->request->data['Estagiario']['id_aluno'] = $aluno_id;
            endif;
            // pr($this->data);
            // die();
            /* Agora sim faço a inserção ou atualização do estágio */
            if ($this->Inscricao->Estagiario->save($this->data)) {
                $this->Flash->success(__("Estagiaria(o) atualizada(o)"));
                if (isset($this->data['Estagiario']['id'])):
                    /* Se é uma atualização então vai para view com o id */
                    return $this->redirect('/estagiarios/view/' . $this->data['Estagiario']['id']);
                else:
                    /* Se é uma inserção vai com o novo ID */
                    return $this->redirect('/estagiarios/view/' . $this->Inscricao->Estagiario->getLastInsertID());
                endif;
            }
        endif;

        $registro = $this->request->query('registro');
        /* Captura o periodo de estagio para o termo de compromisso */
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];
        // pr($periodo);
        // die();
        /* Busca em estagiarios o ultimo estagio do aluno */
        $estagiario = $this->Inscricao->Estagiario->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'fields' => array('Estagiario.id', 'Estagiario.registro', 'Estagiario.periodo', 'Estagiario.tipo_de_estagio', 'Estagiario.turno', 'Estagiario.id_aluno', 'Estagiario.alunonovo_id', 'Estagiario.registro', 'Estagiario.nivel', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_professor', 'Aluno.id', 'Aluno.registro', 'Aluno.nome'),
            'order' => array('periodo' => 'DESC')
                )
        );
        // pr($estagiario);
        // die("estagiario");
        /* Se já é um aluno estagiario: há duas possibilidades atualização ou inserção */
        if ($estagiario) {
            // pr($estagiario);
            // die('estagiario');
            /* 1a. verificação se já está com o alunonovo_id */
            if (empty($estagiario['Estagiario']['alunonovo_id'])):
                $this->Flash->error(__('Estagiario sem número de estudante'));
                $this->loadModel('Alunonovo');
                $estudante = $this->Alunonovo->find('first', [
                    'conditions' => ['Alunonovo.registro' => $registro]
                ]);
                // pr($estudante);
                // die();
                if ($estudante):
                    $estagiario['Estagiario']['alunonovo_id'] = $estudante['Alunonovo']['id'];
                else:
                    /* Situação absurda: Fazer cadastro como estudante */
                    return $this->redirect('/alunonovos/add?registro=' . $registro);
                endif;
            endif;

            /* 2a. verificação se insere ou atualiza estágio */
            // echo $estagiario['Estagiario']['periodo'] . " " . " ".  $periodo . "</br>";
            if ($estagiario['Estagiario']['periodo'] < $periodo):
                // echo "Inserção de novo estágio";
                /* Se o periodo de estágio atual é maior que o último estágio então é uma insernção */
                unset($estagiario['Estagiario']['id']);
                /*
                 * Inserir aqui o ajuste2020 em lugar do número 4
                 *
                 */
                if ($estagiario['Estagiario']['nivel'] < 4):
                    $estagiario['Estagiario']['nivel']++;
                else:
                    /* Para além do 4 nível é estágio não obrigatorio */
                    $estagiario['Estagiario']['nivel'] = 9;
                endif;
            elseif ($estagiario['Estagiario']['periodo'] == $periodo):
                // echo 'Atualização de estágio atual';
                $estagiario_atual_id = $estagiario['Estagiario']['id'];
            endif;
            // die();

            $aluno_atual_id = $estagiario['Estagiario']['id_aluno'];
            $alunonovo_atual_id = $estagiario['Estagiario']['alunonovo_id'];
            $periodo_ultimo = $estagiario['Estagiario']['periodo'];
            $tipo_de_estagio = $estagiario['Estagiario']['tipo_de_estagio'];
            $nivel_ultimo = $estagiario['Estagiario']['nivel'];
            $turno_ultimo = $estagiario['Estagiario']['turno'];
            $instituicao_atual = $estagiario['Estagiario']['id_instituicao'];
            $supervisor_atual = $estagiario['Estagiario']['id_supervisor'];
            $professor_atual = $estagiario['Estagiario']['id_professor'];
            $aluno_nome = $estagiario['Aluno']['nome'];

            $estagiario['Estagiario']['nivel'] = $nivel_ultimo;
            // pr($estagiario);
            // die();
            $this->set('aluno', $aluno_nome);

            /* Para saber se atualizar ou inserir, porque nos estagiáios existem as duas possibilidades */
            if (isset($estagiario['Estagiario']['id'])):
                $this->set('estagiario_id', $estagiario['Estagiario']['id']);
            else:
                $this->set('estagiario_id', NULL);
            endif;
            
            $this->set('estagiario', $estagiario);
            $this->set('aluno_atual_id', $aluno_atual_id);
            $this->set('alunonovo_atual_id', $alunonovo_atual_id);
            $this->set('tipo_de_estagio', $tipo_de_estagio);
            $this->set('instituicao_atual', $instituicao_atual);
            $this->set('instituicao_atual', $instituicao_atual);
            $this->set('supervisor_atual', $supervisor_atual);
            $this->set('professor_atual', $professor_atual);
            // die('fim de aluno estágiario');
        } else {
            // Aluno nao estagiario -> inserção de estagiários
            // Turno incompleto (ou ignorado)
            $turno_ultimo = 'I';
            // Nivel eh I
            $nivel_ultimo = 1;
            
            $this->loadModel('Alunonovo');
            $alunonovo = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro]
            ]);
            // Situação absurda: alunonovo nao cadastrado: vai para cadastro e retorna
            if (!($alunonovo)) {
                $this->Flash->error(__("Aluno não cadastrado"));
                $this->Session->write('termo', $id);
                // die("Aluno novo nao cadastrado: " . $id);
                return $this->redirect('/alunonovos/add?registro=' . $registro);
                die("Redireciona para cadastro de alunos novos ");
            } else {
                $this->set('aluno', $alunonovo['Alunonovo']['nome']);
                $this->set('alunonovo_atual_id', $alunonovo['Alunonovo']['id']);
            }

            $this->set('instituicao_atual', 0);
            $this->set('supervisor_atual', 0);
            $this->set('professor_atual', 0);
        }

        // Pego as instituicoes
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', array(
            'fields' => array('Instituicao.id', 'Instituicao.instituicao'),
            'order' => 'Instituicao.instituicao',
                )
        );
        asort($instituicoes);
        // pr($instituicoes);
        // Pego os supervisores da instituicao atual
        if (isset($instituicao_atual)) {
            $supervisores = $this->Instituicao->find('first', array(
                'conditions' => array('Instituicao.id' => $instituicao_atual)
                    )
            );
            // pr($supervisores);
            foreach ($supervisores['Supervisor'] as $c_supervisor) {
                $super_atuais[$c_supervisor['id']] = $c_supervisor['nome'];
                // pr($c_supervisor['nome']);
            }
            asort($super_atuais);
            // pr($super_atuais);
        }

        // Envio os dados
        // die($registro);
        $this->set('estagiario', $estagiario); // Poderia enviar todo
        $this->set('registro', $registro);

        if (isset($estagiario['Estagiario']['id'])):
            $this->set('estagiario_id', $estagiario['Estagiario']['id']); // Aluno estagiario tem id
        else:
            $this->set('estagiario_id', NULL); // Aluno sem estagio não tem id
        endif;
        $this->set('periodo', $periodo);
        $this->set('nivel', $nivel_ultimo);
        $this->set('turno', $turno_ultimo);
        $this->set('instituicoes', $instituicoes);
        if (isset($super_atuais)):
            $this->set('supervisores', $super_atuais); // Aluno sem estaǵio não tem supervisores de instituição cadastrados
        endif;
    }

    /*
     * O id eh o numero de registro do aluno
     */

    public function termocadastra($id = NULL) {

        $registro = $this->request->query('registro');
        // pr($registro);
        // die('registro');
        // Se ja esta como estagiario pego o id para atualizar
        // $this->loadModel("Estagiario");
        $periodo_estagio = $this->Inscricao->Estagiario->find('first', [
            'conditions' => ['Estagiario.periodo' => $this->data['Inscricao']['periodo'], 'Estagiario.registro' => $this->data['Inscricao']['id_aluno']],
            'fields' => ['Estagiario.id', 'Estagiario.id_aluno', 'Estagiario.alunonovo_id']]);
        // pr($periodo_estagio);
        // die('periodo estagio');

        /* Capturo os valores da area e professor da instituicao selecionada
         * Estes valores foram capturados no controller Instituicao funcao seleciona_supervisor
         */
        $id_area = $this->Session->read('id_area');
        $id_prof = $this->Session->read('id_prof');
        // Apago os cookies que foram passados na sessao
        $this->Session->delete('id_area');
        $this->Session->delete('id_prof');
        // echo $id_area . " " . $id_prof . "<br>";
        // die();
        //
        // pr($this->data);
        // die();
        //
        // Tem que ter o id da instituicao diferente de zero
        if (empty($this->data['Inscricao']['id_instituicao'])) {
            $this->Flash->error(__('Selecione uma instituição de estágio'));
            $this->redirect('/Inscricaos/termosolicita/');
            die('Faltou selecionar uma instituição');
        }
        // Estagio ja cadastrado: atualizacao.
        if ($periodo_estagio) {
            $id_estagio = $periodo_estagio['Estagiario']['id'];
            $id_aluno = $periodo_estagio['Estagiario']['id_aluno'];
            $alunonovo_id = $periodo_estagio['Estagiario']['alunonovo_id'];

            $dados = array("Estagiario" => array(
                    'id' => $id_estagio,
                    'id_aluno' => $id_aluno,
                    'alunonovo_id' => $alunonovo_id,
                    'registro' => $this->data['Inscricao']['id_aluno'],
                    'nivel' => $this->data['Inscricao']['nivel'],
                    'turno' => $this->data['Inscricao']['turno'],
                    'tc' => '0',
                    'tc_solicitacao' => date('Y-m-d'),
                    'periodo' => $this->data['Inscricao']['periodo'],
                    'id_professor' => $id_prof,
                    'id_instituicao' => $this->data['Inscricao']['id_instituicao'],
                    'id_supervisor' => $this->data['Inscricao']['id_supervisor'],
                    'id_area' => $id_area,
            ));
            // pr($dados);
            // die('dados1');

            $this->Inscricao->Estagiario->set($dados);
            if ($this->Inscricao->Estagiario->save($dados, array('validate' => TRUE))) {
                $this->Flash->success(__('Registro de estágio atualizado'));
                // die('save dados1');
                $this->redirect('/Inscricaos/termoimprime?estagiario_id=' . $id_estagio . '&tipo_de_estagio=' . $this->data['Inscricao']['tipo_de_estagio']);
            } else {
                $errors = $this->Inscricao->Estagiario->invalidFields();
                $this->Session->setFlash(implode(', ', $errors));
                die("Error: não foi possível atualizar inscrição de estágio");
            }
            // die("save dados1-1");
        } else {
            /*
             * Aluno: pode haver duas situacoes:
             * eh um aluno que ja estava em estagio ou
             * eh um aluno novo que precisa ser cadastrado primeiro
             */
            // Verifico se ja esta cadastrado
            $this->loadModel('Aluno');
            $alunocadastrado = $this->Aluno->find('first', array(
                'conditions' => array('Aluno.registro = ' . $registro)
            ));
            // pr($alunocadastrado);
            // die();
            /* Se não está cadastrado como aluno estagiario busco entre os alunonovos */
            if (empty($alunocadastrado)) {
                // echo "Aluno nao cadastrado";
                $this->loadModel('Alunonovo');
                $alunonovo = $this->Alunonovo->find('first', array(
                    'conditions' => array('Alunonovo.registro =' . $registro)
                ));
                // pr($alunonovo);
                // die();
                /*
                 * Alunonovo nao cadastrado como estagiário. Cadastrar como aluno
                 */
                $cadastroaluno = array('Aluno' => array(
                        'alunonovo_id' => $alunonovo['Alunonovo']['id'],
                        'nome' => $alunonovo['Alunonovo']['nome'],
                        'registro' => $alunonovo['Alunonovo']['registro'],
                        'codigo_telefone' => $alunonovo['Alunonovo']['codigo_telefone'],
                        'telefone' => $alunonovo['Alunonovo']['telefone'],
                        'codigo_celular' => $alunonovo['Alunonovo']['codigo_celular'],
                        'celular' => $alunonovo['Alunonovo']['celular'],
                        'email' => $alunonovo['Alunonovo']['email'],
                        'cpf' => $alunonovo['Alunonovo']['cpf'],
                        'identidade' => $alunonovo['Alunonovo']['identidade'],
                        'orgao' => $alunonovo['Alunonovo']['orgao'],
                        'nascimento' => $alunonovo['Alunonovo']['nascimento'],
                        'endereco' => $alunonovo['Alunonovo']['endereco'],
                        'cep' => $alunonovo['Alunonovo']['cep'],
                        'municipio' => $alunonovo['Alunonovo']['municipio'],
                        'bairro' => $alunonovo['Alunonovo']['bairro'],
                        'observacoes' => $alunonovo['Alunonovo']['observacoes']
                ));
                // pr($cadastroaluno);
                // die();

                $this->loadModel('Aluno');
                $this->Aluno->set($cadastroaluno);
                if ($this->Aluno->save($cadastroaluno, array('validate' => TRUE))) {
                    $this->Flash->success(__('Registro do aluno novo inserido'));
                    $aluno_id = $this->Aluno->getLastInsertId();
                } else {
                    $errors = $this->Aluno->invalidFields();
                    $this->Session->setFlash(implode(', ', $errors));
                    die('Error: Não foi possível inserir dados do aluno novo');
                }
            } else {
                echo "Aluno cadastrado: ";
                $aluno_id = $alunocadastrado['Aluno']['id'];
                // $alunonovo_id = $alunocadastrado['Alunonovo']['id'];
                // echo "aluno_id: " . $aluno_id;
                // die('626');
            }

            /*
             * Inserir estagiario para este periodo
             */
            $dados = array("Estagiario" => array(
                    'id_aluno' => $aluno_id,
                    'alunonovo_id' => $alunonovo_id,
                    'registro' => $this->data['Inscricao']['id_aluno'],
                    'nivel' => $this->data['Inscricao']['nivel'],
                    'turno' => $this->data['Inscricao']['turno'],
                    'tc' => '0',
                    'tc_solicitacao' => date('Y-m-d'),
                    'periodo' => $this->data['Inscricao']['periodo'],
                    'id_professor' => $id_prof,
                    'id_instituicao' => $this->data['Inscricao']['id_instituicao'],
                    'id_supervisor' => $this->data['Inscricao']['id_supervisor'],
                    'id_area' => $id_area,
            ));
            // pr($dados);
            // die('dados2');

            $this->Inscricao->Estagiario->set($dados);
            if ($this->Inscricao->Estagiario->save($dados, array('validate' => TRUE))) {
                $this->Flash->success(__('Registro de estágio inserido'));
                $estagiario_id = $this->Inscricao->Estagiario->getlastInsertId();
                $this->redirect('/Inscricaos/termoimprime?estagiario_id=' . $estagiario_id . '&tipo_de_estagio=' . $this->data['Inscricao']['tipo_de_estagio']);
            } else {
                $errors = $this->Inscricao->Estagiario->invalidFields();
                $this->Session->setFlash(implode(',', $errors));
                die('Error: Não foi possível inserir dados de estágio');
            }
        }
    }

    /* id eh o numero de estagiario */

    public function termoimprime($id = NULL) {

        ini_set('memory_limit', '512M');
        // echo "Estagiario id " . $id . "<br>";
        // Configure::write('debug', 2);

        $id = $this->request->query['estagiario_id'];
        // $tipo_de_estagio = $this->request->query['tipo_de_estagio'];
        // die($id);

        $estagiario = $this->Inscricao->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id)
        ));
        // pr($estagiario);
        // die("estagiario");

        $instituicao_nome = $estagiario['Instituicao']['instituicao'];
        $tipo_de_estagio = $estagiario['Estagiario']['tipo_de_estagio'];
        $supervisor_nome = $estagiario['Supervisor']['nome'];
        if (empty($supervisor_nome)) {
            $supervisor_nome = NULL;
        }
        $aluno_nome = $estagiario['Aluno']['nome'];
        $nivel = $estagiario['Estagiario']['nivel'];
        $registro = $estagiario['Estagiario']['registro'];
        $supervisor_cress = $estagiario['Supervisor']['cress'];
        // pr($nivel);
        // die("nivel");
        // Capturo o inicio e o fim do termo de compromisso
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $termoinicio = $configuracao['Configuracao']['termo_compromisso_inicio'];
        $termofinal = $configuracao['Configuracao']['termo_compromisso_final'];

        $termoinicio_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termoinicio)));
        $termofinal_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termofinal)));
        // die('termoimprime');

        $this->set('id', $id);
        $this->set('registro', $registro);
        $this->set('instituicao_nome', $instituicao_nome);
        $this->set('aluno_nome', $aluno_nome);
        $this->set('supervisor_nome', $supervisor_nome);
        $this->set('nivel', $nivel);
        $this->set('termoinicio', $termoinicio_f);
        $this->set('termofinal', $termofinal_f);
        $this->set('registro', $registro);
        $this->set('supervisor_cress', $supervisor_cress);
        // die();

        /* Imprime PDF. */
        if ($tipo_de_estagio == "1") {
            $this->redirect(['action' => 'imprimepdf', $id, 'ext' => 'pdf', $registro]);
            // echo $this->Html->link(__('Imprime PDF'), array('action' => 'imprimepdf', $id, 'ext' => 'pdf', $registro));
        } elseif ($tipo_de_estagio == "2") {
            $this->redirect(['action' => 'imprimepdfremoto', $id, 'ext' => 'pdf', $registro]);
        } else {
            $this->Flash->error(__('Selecione o tipo de estágio que vai cursar'));
            $this->redirect('termocompromisso');
        }
    }

    /* Envia os dados para imprimir o PDF diretamente  */

    function imprimepdf($id = NULL) {

        // pr($id);
        // die('id');
        $estagiario = $this->Inscricao->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id)
        ));
        // pr($estagiario);
        // die('estagiario');

        $instituicao_nome = $estagiario['Instituicao']['instituicao'];
        $supervisor_nome = $estagiario['Supervisor']['nome'];
        $aluno_nome = $estagiario['Aluno']['nome'];
        $nivel = $estagiario['Estagiario']['nivel'];
        $registro = $estagiario['Estagiario']['registro'];
        $supervisor_cress = $estagiario['Supervisor']['cress'];
        // pr($nivel);
        // die('nivel');
        // Capturo o inicio e o fim do termo de compromisso
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $termoinicio = $configuracao['Configuracao']['termo_compromisso_inicio'];
        $termofinal = $configuracao['Configuracao']['termo_compromisso_final'];

        $termoinicio_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termoinicio)));
        $termofinal_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termofinal)));

        $this->set('registro', $registro);
        $this->set('instituicao_nome', $instituicao_nome);
        $this->set('aluno_nome', $aluno_nome);
        $this->set('supervisor_nome', $supervisor_nome);
        $this->set('nivel', $nivel);
        $this->set('termoinicio', $termoinicio_f);
        $this->set('termofinal', $termofinal_f);
        $this->set('supervisor_cress', $supervisor_cress);
    }

    /* Termo de compromisso para estágio remoto */

    function imprimepdfremoto($id = NULL) {

        // pr($id);
        // die('id');
        $estagiario = $this->Inscricao->Estagiario->find('first', array(
            'conditions' => array('Estagiario.id' => $id)
        ));
        // pr($estagiario);
        // die('estagiario');

        $instituicao_nome = $estagiario['Instituicao']['instituicao'];
        $supervisor_nome = $estagiario['Supervisor']['nome'];
        $aluno_nome = $estagiario['Aluno']['nome'];
        $nivel = $estagiario['Estagiario']['nivel'];
        $registro = $estagiario['Estagiario']['registro'];
        $supervisor_cress = $estagiario['Supervisor']['cress'];
        // pr($nivel);
        // die('nivel');
        // Capturo o inicio e o fim do termo de compromisso
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $termoinicio = $configuracao['Configuracao']['termo_compromisso_inicio'];
        $termofinal = $configuracao['Configuracao']['termo_compromisso_final'];

        $termoinicio_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termoinicio)));
        $termofinal_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termofinal)));

        $this->set('registro', $registro);
        $this->set('instituicao_nome', $instituicao_nome);
        $this->set('aluno_nome', $aluno_nome);
        $this->set('supervisor_nome', $supervisor_nome);
        $this->set('nivel', $nivel);
        $this->set('termoinicio', $termoinicio_f);
        $this->set('termofinal', $termofinal_f);
        $this->set('supervisor_cress', $supervisor_cress);
    }

    /* Preencho a tabela inscrição com o id da tabela alunosnovos (alias estudantes) */

    public function estudante() {

        $this->loadModel('Alunonovo');
        $this->Alunonovo->recursive = 0;
        $estudantes = $this->Alunonovo->find('all', [
            'fields' => ['id', 'registro']
        ]);
        // pr($estudantes);
        // die();

        foreach ($estudantes as $c_estudante) {
            // pr($c_estudante);
            // die();
            $this->Inscricao->recursive = -1;
            $inscricao = $this->Inscricao->find('first', [
                'conditions' => ['Inscricao.id_aluno' => $c_estudante['Alunonovo']['registro']],
                'fields' => ['id', 'id_aluno']
            ]);
            // pr($inscricao);
            // die();
            if ($inscricao) {
                if ($this->Inscricao->updateAll(
                                ['Inscricao.alunonovo_id' => $c_estudante['Alunonovo']['id']],
                                ['Inscricao.id_aluno' => $inscricao['Inscricao']['id_aluno']]
                        )
                )
                    ;
            } else {
                echo "Estudante sem inscricao";
            }
            // $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($inscricao);
            // die();
        }
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        die("Tarefa finalizada!");
    }

    /* Preencho a tabela inscrição com o id da tabela alunosnovos (alias estudantes) */

    public function aluno() {

        $this->loadModel('Aluno');
        $this->Aluno->recursive = 0;
        $alunos = $this->Aluno->find('all', [
            'fields' => ['id', 'registro']
        ]);
        // pr($alunos);
        // die();

        foreach ($alunos as $c_aluno) {
            // pr($c_aluno);
            // die();
            $this->Inscricao->recursive = -1;
            $inscricao = $this->Inscricao->find('first', [
                'conditions' => ['Inscricao.id_aluno' => $c_aluno['Aluno']['registro']],
                'fields' => ['id', 'id_aluno']
            ]);
            // pr($inscricao);
            // die();
            if ($inscricao) {
                if ($this->Inscricao->updateAll(
                                ['Inscricao.aluno_id' => $c_aluno['Aluno']['id']],
                                ['Inscricao.id_aluno' => $inscricao['Inscricao']['id_aluno']]
                        )
                )
                    ;
            } else {
                echo "Estudante sem inscricao";
            }
            // $log = $this->Estagiario->getDataSource()->getLog(false, false);
            // debug($log);
            // pr($inscricao);
            // die();
        }
        // $log = $this->Estagiario->getDataSource()->getLog(false, false);
        // debug($log);
        die("Tarefa finalizada!");
    }

}

?>
