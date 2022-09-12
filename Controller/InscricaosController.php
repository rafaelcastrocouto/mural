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
            $this->Auth->allow('index', 'view', 'add', 'delete', 'inscricao', 'termocadastra', 'termocompromisso', 'termoimprime', 'termosolicita', 'imprimepdf', 'imprimeremoto');
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
    }

    public function index($id = NULL) {

        // Capturo o periodo de estagio para o mural
        $periodo = $this->Session->read('mural_periodo');
        if (!$periodo) {
            $this->loadModel("Configuracao");
            $configuracao = $this->Configuracao->findById('1');
            $periodo = $configuracao['Configuracao']['mural_periodo_atual'];
        }

        /* Inscrições para uma determinada instituição */
        if ($id) {
            $this->Paginator->settings = [
                'contain' => ['Mural', 'Alunonovo' => ['Estagiario' => ['fields' => 'id']], 'Aluno'],
                'conditions' => ['Inscricao.id_instituicao' => $id],
                'fields' => ['Inscricao.periodo', 'Inscricao.data', 'Inscricao.id_instituicao', 'Inscricao.id', 'Inscricao.id_aluno', 'Inscricao.aluno_id', 'Mural.id_estagio', 'Mural.instituicao', 'Mural.vagas', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Alunonovo.id', 'Alunonovo.registro', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email'],
                'group' => ['Inscricao.id'],
                'limit' => 10,
                'order' => ['Alunonovo.nome']
            ];
            /* Inscrições para todas as instituições */
        } else {
            $this->Paginator->settings = [
                'contain' => ['Mural', 'Alunonovo' => ['Estagiario' => ['fields' => 'id']], 'Aluno'],
                'conditions' => ['Inscricao.periodo' => $periodo],
                'fields' => ['Inscricao.periodo', 'Inscricao.data', 'Inscricao.id_instituicao', 'Inscricao.id', 'Inscricao.id_aluno', 'Inscricao.aluno_id', 'Mural.id_estagio', 'Mural.instituicao', 'Mural.vagas', 'Aluno.id', 'Aluno.nome', 'Aluno.nascimento', 'Aluno.telefone', 'Aluno.celular', 'Aluno.email', 'Alunonovo.id', 'Alunonovo.registro', 'Alunonovo.nome', 'Alunonovo.nascimento', 'Alunonovo.telefone', 'Alunonovo.celular', 'Alunonovo.email'],
                'group' => ['Inscricao.id'],
                'limit' => 10,
                'order' => ['Alunonovo.nome']
            ];
        }
        // pr($inscritos);
        // die();
        $this->set('inscritos', $this->Paginator->paginate('Inscricao'));
    }

    public function orfao() {

        $this->loadModel("Alunonovo");

        // $this->Alunonovo->virtualFields['virtualinscricao'] = 'count(Inscricao.id_aluno)';
        // $this->Alunonovo->virtualFields['virtualestagiario'] = 'count(Estagiario.registro)';

        $this->Paginator->settings = [
            'contain' => ['Inscricao', 'Estagiario'],
            // 'fields' => ['Alunonovo.id', 'Alunonovo.registro', 'Alunonovo.nome', 'Alunonovo.celular', 'Alunonovo.email', 'virtualinscricao', 'virtualestagiario'],
            'order' => ['Alunonovo.nome' => 'asc'],
            'limit' => 10,
        ];
        $this->set('orfaos', $this->Paginator->paginate('Alunonovo'));
    }

    /* Insere inscrição a partir do registro (id_aluno) do aluno e do id do mural */

    public function add($id = NULL) {

        /* Id do mural de estágios */
        // Verifico se foi preenchido o numero de registro
        // O id_aluno eh o registro
        $registro = $this->Session->read('numero');
        // pr($registro);
        if (isset($registro) && $registro != '0') {
            $this->loadModel('Alunonovo');
            $this->Alunonovo->contain();
            $alunonovo = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro],
                'fields' => ['Alunonovo.ingresso', 'Alunonovo.turno']
            ]);

            if (empty($alunonovo)) {
                $this->Flash->error(__('Aluno não cadastrado'));
                $this->redirect('/Alunonovos/add?registro=' . $registro);
            }

            $this->set('ingresso', $ingresso = isset($alunonovo['Alunonovo']['ingresso']) ? $alunonovo['Alunonovo']['ingresso'] : null);
            $this->set('turno', $turno = isset($alunonovo['Alunonovo']['turno']) ? $alunonovo['Alunonovo']['turno'] : null);
        }
        $this->set('id_instituicao', $id);

        if (isset($this->data['Inscricao']['id_aluno'])) {
            // pr($this->data);
            // die();
            /* Verificacoes */
            if ((strlen($this->request->data['Inscricao']['id_aluno'])) < 9) {
                $this->Flash->error(__("Registro incorreto"));
                $this->redirect('/Inscricaos/add/');
                die("Registro incorreto");
                exit;
            }

            // Verifico se já fez inscrição paa não duplicar
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
            $this->Mural->contain();
            $instituicao = $this->Mural->find('first', [
                'conditions' => ['Mural.id' => $id],
                'fields' => 'periodo'
            ]);
            $periodo = $instituicao['Mural']['periodo'];
            // echo "Período: " . $periodo;
            // die();

            /* Capturo o id do Aluno a partir do registro (id_aluno) */
            /* Pode retornar vazio porque não é ainda estagiário */
            $this->loadModel('Aluno');
            $this->Aluno->contain();
            $aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->data['Inscricao']['id_aluno']],
                'fields' => 'Aluno.id'
            ]);
            // pr($aluno_id);

            /* Capturo o id do Alunonovo a partir do registro (id_aluno) */
            $this->loadModel('Alunonovo');
            $this->Alunonovo->contain();
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $this->data['Inscricao']['id_aluno']]
            ]);

            if (empty($alunonovo_id)) {
                // die('empty');
                $this->Flash->error(__('Estudante não cadastrado'));
                $this->redirect('/Alunonovos/add?registro=' . $registro);
            } else {
                // die('not empty');
                $alunonovo_id['Alunonovo']['ingresso'] = isset($this->data['Inscricao']['ingresso']) ? $this->data['Inscricao']['ingresso'] : NULL;
                $alunonovo_id['Alunonovo']['turno'] = isset($this->data['Inscricao']['turno']) ? $this->data['Inscricao']['turno'] : NULL;
                if ($this->Alunonovo->save($alunonovo_id)) {
                    $this->Flash->success(__("Atualização realizada"));
                }
            }

            /* Carrego o array de inscrição com os valores */
            $data['Inscricao']['periodo'] = $periodo;
            $data['Inscricao']['id_instituicao'] = $id;
            $data['Inscricao']['data'] = date('Y-m-d');
            $data['Inscricao']['id_aluno'] = $this->data['Inscricao']['id_aluno']; // Registro
            $data['Inscricao']['aluno_id'] = isset($aluno_id['Aluno']['id']) ? $aluno_id['Aluno']['id'] : NULL;
            $data['Inscricao']['alunonovo_id'] = $alunonovo_id['Alunonovo']['id'];

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
     * Este método ficou obsoleto
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
            $this->Aluno->contain();
            $aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro],
                'fields' => 'Aluno.id'
            ]);
            // pr($aluno_id);
            // die();

            /* Capturo o id do Alunonovo */
            $this->loadModel('Alunonovo');
            $this->Alunonovo->contain();
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
                $this->Flash->success(__("Inscrição atualizada"));
                $this->redirect('/Inscricaos/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        $instituicao = $this->Inscricao->findById($id, array('fields' => 'id_instituicao'));
        $this->Inscricao->delete($id);
        $this->Flash->success(__("Inscrição excluída"));
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
                    $this->Email->replyTo = '"ESS/UFRJ - Coordenação de Estágio" <estagio@ess.ufrj.br>';
                    $this->Email->from = '"ESS/UFRJ - Coordenação de Estágio" <estagio@ess.ufrj.br>';
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

                    $this->Flash->success('Email enviado');
                    $this->redirect('/Murals/view/' . $inscritos[0]['Mural']['id']);
                }
            } else {

                $this->Flash->error('Imposível enviar email (falta o endereço)');
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

    /* Com o numero de registro busco as informacoes para preencher o formulário */

    public function termocompromisso($id = NULL) {

        $registro = $this->request->query('registro');
        // pr($registro);
        // die("termocompromisso");

        /* Captura o periodo de estagio para o termo de compromisso */
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

        /* Busca em estagiarios o ultimo estagio do aluno */
        $this->Inscricao->contain(['Estagiario', 'Alunonovo', 'Aluno']);
        $estagiario = $this->Inscricao->find('first', array(
            'conditions' => array('Estagiario.registro' => $registro),
            'fields' => array('Estagiario.id', 'Estagiario.periodo', 'Estagiario.turno', 'Estagiario.complemento_id', 'Estagiario.id_aluno', 'Estagiario.alunonovo_id', 'Estagiario.registro', 'Estagiario.nivel', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_professor', 'Estagiario.ajuste2020', 'Aluno.id', 'Aluno.registro', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.ingresso', 'Alunonovo.turno'),
            'order' => array(['nivel' => 'DESC', 'periodo' => 'DESC'])
                )
        );
        // pr($estagiario);
        // die();
        // Aluno estagiario
        if (!empty($estagiario['Estagiario']['id'])) {

            /* Calculo o ano de ingresso para definir se é do ajuste2020 */
            // pr(intval(substr($estagiario['Estagiario']['registro'], 1, 2)));
            if (strlen(trim($estagiario['Estagiario']['registro'])) == 9) {
                if (intval(substr(trim($estagiario['Estagiario']['registro']), 1, 2)) > 19) {
                    // echo 'estudante ingressou em 2020 ou depois';
                    $estagiario['Estagiario']['ajuste2020'] = 1;
                }
            } elseif (strlen(trim($estagiario['Estagiario']['registro'])) == 8) {
                /* Alunos anteriores ao ano de 2000 */
                $estagiario['Estagiario']['ajuste2020'] = 0;
            }
            // pr($estagiario['Estagiario']['ajuste2020']);
            // die();
            /* Se eh o periodo anterior adianta em uma unidade o nivel */
            /* Se é maior que o último nível então é estágio não obrigatório */
            if ($estagiario['Estagiario']['ajuste2020'] == 0) {
                $ultimo_nivel_curricular = 4;
            } else {
                $ultimo_nivel_curricular = 3;
            }
            // pr('Periodo de estagio ' . $periodo);
            // pr('Perido do estagiário ' . $estagiario['Estagiario']['periodo']);
            // pr('Nivel do estagiário ' . $estagiario['Estagiario']['nivel']);
            // die();
            $nivel_ultimo = NULL;
            if ($estagiario['Estagiario']['periodo'] < $periodo) {

                if ($estagiario['Estagiario']['nivel'] < $ultimo_nivel_curricular) {
                    $nivel_ultimo = $estagiario['Estagiario']['nivel'] + 1;
                    $estagiario['Estagiario']['id'] = NULL;
                    $inserir = 0; // Inserir
                    // pr($nivel_ultimo);
                    // die("Inserir novo estágio");
                } elseif ($estagiario['Estagiario']['nivel'] >= $ultimo_nivel_curricular) {
                    $nivel_ultimo = 9; // estágio não obrigatório
                    $estagiario['Estagiario']['id'] = NULL;
                    $inserir = 0; // Inserir novo estagiario
                    // pr($nivel_ultimo);
                    // die("Inserir novo estágio não obrigatório");
                }
            } else {
                $nivel_ultimo = $estagiario['Estagiario']['nivel'];
                $inserir = 1; // Atualizar estagiario
                // pr('Atualizar para ' . $nivel_ultimo);
                // die("Atualizar estágio");
            }
            // pr("Nivel novo de estágio " . $nivel_ultimo);
            // pr($inserir);
            // die();
        } else {
            /* Aluno nao estagiario */
            $inserir = 0; // Inserir estagiário novo no nível I
            $nivel_ultimo = 1; // Nivel eh 1

            $this->loadModel('Alunonovo');
            $this->Alunonovo->contain();
            $alunonovo = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro]
            ]);
            // pr($alunonovo);
            // die('alunonovo');
            // Aluno novo nao cadastrado: vai para cadastro e retorna
            if (!($alunonovo)) {
                $this->Flash->error(__("Aluno não cadastrado"));
                $this->Session->write('termo', $registro);
                // die("Aluno novo nao cadastrado: " . $id);
                $this->redirect('/Alunonovos/add?registro=' . $registro);
                // die("Redireciona para cadastro de alunos novos ");
            }
        }

        /* Capturo as instituicoes */
        $this->loadModel('Instituicao');
        $this->Instituicao->contain();
        $instituicoes = $this->Instituicao->find('list', [
            'fields' => ['Instituicao.id', 'Instituicao.instituicao'],
            'order' => 'Instituicao.instituicao',
                ]
        );
        // pr($instituicoes);

        /* Capturo os supervisores da instituicao atual */
        if (isset($estagiario['Estagiario']['id_instituicao'])) {
            // $this->Instituicao->contain('Supervisor', ['order' => 'nome']);
            $supervisores = $this->Instituicao->find('first', [
                'contain' => ['Supervisor' => ['order' => 'nome']],
                'conditions' => ['Instituicao.id' => $estagiario['Estagiario']['id_instituicao']]
                    ]
            );

            foreach ($supervisores['Supervisor'] as $c_supervisor) {
                $super_atuais[$c_supervisor['id']] = $c_supervisor['nome'];
                // pr($c_supervisor['nome']);
            }
        }

        // Envio os dados
        $this->set('estagiario_id', $estagiario_id = isset($estagiario['Estagiario']['id']) ? $estagiario['Estagiario']['id'] : NULL);
        $this->set('inserir', $inserir);
        $this->set('ingresso', $ingresso = isset($estagiario['Alunonovo']['ingresso']) ? $estagiario['Alunonovo']['ingresso'] : $alunonovo['Alunonovo']['ingresso']);
        $this->set('alunonovoturno', $alunonovoturno = isset($estagiario['Alunonovo']['turno']) ? $estagiario['Alunonovo']['turno'] : $alunonovo['Alunonovo']['turno']);
        $this->set('id_aluno', $id_aluno = isset($estagiario['Estagiario']['id_aluno']) ? $estagiario['Estagiario']['id_aluno'] : NULL);
        $this->set('registro', $registro);
        $this->set('aluno', $aluno_nome = isset($estagiario['Alunonovo']['nome']) ? $estagiario['Alunonovo']['nome'] : $alunonovo['Alunonovo']['nome']);
        $this->set('turno', $turno_ultimo = isset($turno_ultimo) ? $turno_ultimo : 'I');
        $this->set('nivel', $nivel_ultimo);
        $this->set('professor_atual', $professor_atual = isset($estagiario['Estagiario']['id_professor']) ? $estagiario['Estagiario']['id_professor'] : 0);
        $this->set('periodo', $periodo);
        // $this->set('id_area', $id_area);
        $this->set('complemento_id', isset($estagiario['Estagiario']['complemento_id']) ? $estagiario['Estagiario']['complemento_id'] : NULL);
        $this->set('alunonovo_id', $alunonovo_id = isset($estagiario['Alunonovo']['id']) ? $estagiario['Alunonovo']['id'] : '');
        $this->set('ajuste2020', $ajuste2020 = isset($estagiario['Estagiario']['ajuste2020']) ? $estagiario['Estagiario']['ajuste2020'] : 0);
        $this->set('instituicao_atual', $instituicao_atual = isset($estagiario['Estagiario']['id_instituicao']) ? $estagiario['Estagiario']['id_instituicao'] : 0);
        $this->set('supervisor_atual', $supervisor_atual = isset($estagiario['Estagiario']['id_supervisor']) ? $estagiario['Estagiario']['id_supervisor'] : 0);

        $this->set('instituicoes', $instituicoes);
        $this->set('supervisores', $super_atuais = isset($super_atuais) ? $super_atuais : NULL); // Aluno sem estaǵio não tem supervisores de instituição cadastrados
    }

    /*
     * O id eh o numero de registro do aluno
     * Está com um problema na hora de avançar um nível de estágio
     */

    public function termocadastra($id = NULL) {

        $registro = $this->request->query('registro');

        /* Capturo os valores da area e professor da instituicao selecionada
         * Estes valores foram capturados no controller Instituicao funcao seleciona_supervisor
         * Acho que está desativada esta função
         */
        $id_area = $this->Session->read('id_area');
        $id_prof = $this->Session->read('id_prof');
        // Apago os cookies que foram passados na sessao
        // echo $id_area . " " . $id_prof . "<br>";
        $this->Session->delete('id_area');
        $this->Session->delete('id_prof');

        // pr($this->data);
        if ($this->data) {

            // Tem que ter o id da instituicao diferente de zero
            if (empty($this->data['Estagiario']['id_instituicao'])) {
                $this->Flash->error(__('Selecione uma instituição de estágio'));
                $this->redirect('/Inscricaos/termosolicita/');
                die('Faltou selecionar uma instituição');
            }

            $this->loadModel('Alunonovo');
            $this->Alunonovo->contain();
            $alunonovo = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $this->data['Estagiario']['registro']]
                    ]
            );

            $alunonovo['Alunonovo']['ingresso'] = $this->data['Estagiario']['ingresso'];
            $alunonovo['Alunonovo']['turno'] = $this->data['Estagiario']['alunonovoturno'];
            // pr($alunonovo);
            // die('Alunonovo');
            if ($this->Alunonovo->save($alunonovo)) {
                $this->Flash->success(__("Atualização realizada"));
            }

            $this->loadModel('Aluno');
            $this->Aluno->contain();
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->data['Estagiario']['registro']]
            ]);
            // pr($aluno);
            // die('Aluno');
            if (isset($aluno) && empty($aluno)) {
                // die('Inserir');
                $this->Aluno->create();
                /* Guardo o valor do id do Alunonovo */
                $alunonovo_id = $alunonovo['Alunonovo']['id'];
                $alunonovo['Alunonovo']['id'] = NULL;
                // pr($alunonovo['Alunonovo']);
                // die('Insere');
                $this->Aluno->save($alunonovo['Alunonovo'], array('validate' => TRUE));
                $this->Flash->success(__("Aluno inserido"));
            } else {
                /* Para atualizar Aluno tenho que utilizar o id do Aluno */
                /* Guardo o valor do id do Alunonovo */
                $alunonovo_id = $alunonovo['Alunonovo']['id'];
                $alunonovo['Alunonovo']['id'] = $aluno['Aluno']['id'];
                // pr($alunonovo['Alunonovo']);
                // die('Atualiza');

                $this->Aluno->save($alunonovo['Alunonovo'], array('validate' => TRUE));
                $this->Flash->success(__("Aluno atualizado"));
            }
            // die('Insere ou Atualiza');
            // pr($alunonovo_id);
            // die();
            // Capturo o $aluno_id;
            $this->loadModel('Aluno');
            $this->Aluno->contain();
            $query_aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro],
                'fields' => ['id']
            ]);
            // pr($query_aluno_id);
            // die();
            $id_aluno = $query_aluno_id['Aluno']['id'];

            /* Preencho com o valor 0 o complemento_id caso esteja vazio */
            if (empty($this->data['Estagiario']['complemento_id'])) {
                $this->request->data['Estagiario']['complemento_id'] = 0;
            };

            $this->request->data['Estagiario']['id_aluno'] = $id_aluno;
            $this->request->data['Estagiario']['alunonovo_id'] = $alunonovo_id;
            $this->Inscricao->Estagiario->set($this->data);
            // pr($this->data);
            // die();
            if ($this->Inscricao->Estagiario->save($this->data, ['validate' => TRUE])) {
                $this->Flash->success(__('Registro de estágio atualizado'));
                // pr($this->data);
                if (isset($this->data['Estagiario']['id']) && !empty($this->data['Estagiario']['id'])) {
                    $this->redirect('/Inscricaos/termoimprime?estagiario_id=' . $this->data['Estagiario']['id'] . '&tipo_de_estagio=' . $this->data['Estagiario']['complemento_id']);
                } else {
                    $this->redirect('/Inscricaos/termoimprime?estagiario_id=' . $this->Inscricao->Estagiario->getLastInsertId() . '&tipo_de_estagio=' . $this->data['Estagiario']['complemento_id']);
                }
            } else {
                $errors = $this->Inscricao->Estagiario->invalidFields();
                $this->Session->setFlash(implode(', ', $errors));
                $this->Flash->error(__('Não foi possível fazer a inscrição. Tente novamente.'));
                die("Error: não foi possível atualizar inscrição de estágio");
            }
        }
    }

    /* id eh o numero de estagiario */

    public function termoimprime($id = NULL) {

        ini_set('memory_limit', '512M');
        // echo "Estagiario id " . $id . "<br>";
        // Configure::write('debug', 2);

        $id = $this->request->query['estagiario_id'];
        $tipo_de_estagio = $this->request->query['tipo_de_estagio'];

        $estagiario = $this->Inscricao->Estagiario->find('first', [
            'conditions' => ['Estagiario.id' => $id]
        ]);

        $instituicao_nome = $estagiario['Instituicao']['instituicao'];
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

        /* Imprime PDF. */
        if (is_null($tipo_de_estagio) || $tipo_de_estagio == "0") {
            $this->redirect(['action' => 'imprimepdf', $id, 'ext' => 'pdf', $registro]);
            // echo $this->Html->link(__('Imprime PDF'), array('action' => 'imprimepdf', $id, 'ext' => 'pdf', $registro));
        } else {
            $this->redirect(['action' => 'imprimepdfremoto', $id, 'ext' => 'pdf', $registro]);
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
        $this->Alunonovo->recursive = -1;
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
                'conditions' => ['Inscricao.id_aluno' => $c_estudante['Alunonovo']['registro']]
            ]);
            // pr($inscricao);
            /*
              if ($this->Inscricao->save($this->data)) {
              $this->Session->setFlash(__("Inscrição atualizada"));
             */

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

    /* Preencho a tabela inscrição com o id da tabela alunos */

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
