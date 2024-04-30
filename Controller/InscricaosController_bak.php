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

    public function index($id = null) {

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

        if ($this->request->is("ajax")) {
            $this->autoRender = false;

            $params['draw'] = $_REQUEST['draw'];

            // pr($this->request->data);
            $draw = $this->request->query['draw'];

            /* Ordem */
            $idColunaOrdem = isset($this->request->query['order']) ? $this->request->query['order'] : null;
            $coluna = $idColunaOrdem[0]['column'];
            $direcao = $idColunaOrdem[0]['dir'];
            $colunaOrdem = isset($this->request->query['columns']) ? $this->request->query['columns'] : null;
            $ordem = $colunaOrdem[$coluna]['data'];

            $this->loadModel("Alunonovo");

            /* Calculo a totalidade dos registro */
            $total = $this->Alunonovo->find('all');

            /* Quantos registros mostrar (quantidade) e a partir de qual (inicio) */
            $inicio = isset($this->request->query['start']) ? $this->request->query['start'] : 10;
            $quantidade = isset($this->request->query['length']) ? $this->request->query['length'] : sizeof($total);

            $this->Alunonovo->contain(['Inscricao' => ['id_aluno', 'aluno_id', 'alunonovo_id'], 'Estagiario' => 'registro']);

            /* Busca */
            $search_value = isset($this->request->query['search']['value']) ? $this->request->query['search']['value'] : null;
            if ($search_value) {
                // $condiciones = ['OR' => ['Alunonovo.nome LIKE' => '%'. $search_value . '%'], ['Alunonovo.registro LIKE' => '%'. $search_value . '%'], ['Alunonovo.email' => $search_value], ['Alunonovo.celular' => $search_value]];
                $condiciones = ['OR' => [['Alunonovo.nome LIKE' => '%'. $search_value . '%'], ['Alunonovo.registro LIKE' => '%'. $search_value . '%']]];
                $dados = $this->Alunonovo->find('all', [
                    'fields' => ['Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.registro', 'Alunonovo.email', 'Alunonovo.celular'],
                    'conditions' => $condiciones,
                    'order' => [$ordem => $direcao],
                    'offset' => $inicio,
                    'limit' => $quantidade
                ]);
            } else {
                $dados = $this->Alunonovo->find('all', [
                    'fields' => ['Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.registro', 'Alunonovo.email', 'Alunonovo.celular'],
                    'order' => [$ordem => $direcao],
                    'offset' => $inicio,
                    'limit' => $quantidade
                ]);
            }

            foreach ($dados as $dado) {
                // pr($dado);
                $novodados[] = $dado['Alunonovo'];
            }
            // pr($novodados);
            // die();
            $estudantes = [
                "draw" => intval($draw),
                "recordsTotal" => sizeof($total),
                "recordsFiltered" => sizeof($dados),
                "data" => $novodados   // total data array
            ];
            // debug(json_encode($estudantes)) or die;
            return json_encode($estudantes);
        }
    }

    /* Insere inscrição a partir do registro (id_aluno) do aluno e do id do mural */

    public function add($id = null) {

        /* Se é um aluno então capturo o número */
        if ($this->Session->read('id_categoria') == '2'):
            $registro = $this->Session->read('numero');
        endif;
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
            
            $this->set('ingresso', isset($alunonovo['Alunonovo']['ingresso']) ? $alunonovo['Alunonovo']['ingresso'] : null);
            $this->set('turno', isset($alunonovo['Alunonovo']['turno']) ? $alunonovo['Alunonovo']['turno'] : null);
        } else {
            /* Se o usuário não é um aluno */
            if ($this->Session->read('id_categoria') != '2') {
                // die('Administrador');
                $this->Flash->error(__('Administrador, supervisor ou professor sem registro de aluno. Digite o registro.'));
                $this->redirect(['controller' => 'inscricaos', 'action' => 'inscricao?id_instituicao=' . $id]);
            }
            $this->Flash->error(__('Registro do aluno não localizado'));
            $this->redirect('/Alunonovos/add?registro=' . $registro);
        }

        if ($id) {
            $this->loadModel('Mural');
            $this->Mural->contain();
            $mural = $this->Mural->find('first', [
                'conditions' => ['Mural.id' => $id],
                'fields' => 'periodo'
            ]);
            $periodo = $mural['Mural']['periodo'];
            /* Envio o id_instituicao e o periodo */
            $this->set('id_instituicao', $id);
            $this->set('periodo', $periodo);
        }

        if ($this->data) {

            /* Verificacoes */
            if ((strlen($this->request->data['Inscricao']['id_aluno'])) < 9) {
                $this->Flash->error(__("Registro incorreto"));
                $this->redirect('/Murals/index/');
                die("Registro incorreto");
            }

            // Verifico se já fez inscrição para não duplicar
            $inscricao = $this->Inscricao->find('first', [
                'conditions' => [
                    ['Inscricao.periodo' => $this->data['Inscricao']['periodo']],
                    ['Inscricao.id_aluno' => $this->data['Inscricao']['id_aluno']],
                    ['Inscricao.id_instituicao' => $id]
                ]
            ]);
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
                $alunonovo_id['Alunonovo']['ingresso'] = isset($this->data['Inscricao']['ingresso']) ? $this->data['Inscricao']['ingresso'] : null;
                $alunonovo_id['Alunonovo']['turno'] = isset($this->data['Inscricao']['turno']) ? $this->data['Inscricao']['turno'] : null;
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
     * Inscreve o aluno para seleção de estágio por parte do administrador, supervisor ou professor
     * O Id e o numero de registro
     */

    public function inscricao($id = null) {

        $id_instituicao = $this->request->query('id_instituicao');

        if (empty($id_instituicao)) {
            $this->Flash->error(__('Falta selecionar a instituição'));
            $this->redirect('/Murals/index');
        } else {
            $this->set('id_instituicao', $id_instituicao);
        }

        if ($this->data) {

            if (empty($this->data['Inscricao']['id_instituicao'])) {
                $this->Flash->error(__('Falta selecionar a instituição'));
                $this->redirect('/Murals/index');
            }

            /* Com o id_institucao (muralestagio_id) capturo o periodo para o registro de inscricao */
            $this->loadModel('Mural');
            $instituicao = $this->Mural->find('first', [
                'conditions' => ['Mural.id' => $this->data['Inscricao']['id_instituicao']],
                'fields' => 'periodo'
            ]);
            $periodo = $instituicao['Mural']['periodo'];

            /* Verifica se já fez inscrição */
            $this->Inscricao->contain();
            $inscricao = $this->Inscricao->find('first', [
                'conditions' => ['Inscricao.periodo' => $periodo, 'Inscricao.id_aluno' => $this->data['Inscricao']['registro'], 'Inscricao.id_instituicao' => $id_instituicao]
            ]);
            if ($inscricao) {
                $this->Flash->error(__("Aluno já fez inscrição para este estágio"));
                $this->redirect(['controller' => 'Inscricaos', 'action' => 'view', $inscricao['Inscricao']['id']]);
            }

            /* Capturo o id do Aluno */
            $this->loadModel('Aluno');
            $this->Aluno->contain();
            $aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->data['Inscricao']['registro']],
                'fields' => 'Aluno.id'
            ]);

            /* Capturo o id do Alunonovo */
            $this->loadModel('Alunonovo');
            $this->Alunonovo->contain();
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $this->data['Inscricao']['registro']],
                'fields' => 'Alunonovo.id'
            ]);

            /* Carrego o array de inscrição com os valores */
            $data['Inscricao']['periodo'] = $periodo;
            $data['Inscricao']['id_instituicao'] = $id_instituicao;
            $data['Inscricao']['data'] = date('Y-m-d');
            $data['Inscricao']['id_aluno'] = $this->data['Inscricao']['registro'];
            $data['Inscricao']['aluno_id'] = $aluno_id['Aluno']['id'] ? $aluno_id['Aluno']['id'] : null;
            $data['Inscricao']['alunonovo_id'] = $alunonovo_id['Alunonovo']['id'];

            if ($this->Inscricao->save($data)) {
                $this->Flash->success(__("Inscrição realizada"));
                $this->redirect('/Inscricaos/view/' . $this->Inscricao->id);
            }
        }
    }

    public function view($id = null) {

        $inscricao = $this->Inscricao->findById($id);
        // pr($inscricao);
        $this->set('inscricao', $inscricao);
    }

    public function edit($id = null) {

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

    public function delete($id = null) {

        $instituicao = $this->Inscricao->findById($id, array('fields' => 'id_instituicao'));
        $this->Inscricao->delete($id);
        $this->Flash->success(__("Inscrição excluída"));
        $this->redirect('/Inscricaos/index/' . $instituicao['Inscricao']['id_instituicao']);
    }

    public function emailparainstituicao($id = null) {

        if ($id) {
            $inscritos = $this->Inscricao->find(
                    'all',
                    array(
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
                    // $this->Email->to = $user['email'];
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

    public function termocompromisso($id = null) {

        $registro = $this->request->query('registro');
        // pr($registro);
        // die("termocompromisso");

        /* Captura o periodo de estagio para o termo de compromisso */
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];

        /* Busca em estagiarios o ultimo estagio do aluno */
        $estagiario = $this->Inscricao->Estagiario->find(
                'first',
                [
                    'conditions' => ['Estagiario.registro' => $registro],
                    'fields' => ['Estagiario.id', 'Estagiario.periodo', 'Estagiario.turno', 'Estagiario.complemento_id', 'Estagiario.id_aluno', 'Estagiario.alunonovo_id', 'Estagiario.registro', 'Estagiario.nivel', 'Estagiario.id_instituicao', 'Estagiario.id_supervisor', 'Estagiario.id_professor', 'Estagiario.ajuste2020', 'Aluno.id', 'Aluno.registro', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.ingresso', 'Alunonovo.turno'],
                    'order' => ['nivel' => 'DESC', 'periodo' => 'DESC']
                ]
        );
        // pr($estagiario);
        // Aluno nao estagiario
        if (empty($estagiario)) {

            /* Aluno sem estágios registrados. Inícia estágio I */
            $nivel_ultimo = 1; // Nivel eh 1
            $inserir = 0; // Inserir estagiário novo no nível I

            /* Capturo os dados do aluno na tabela alunonovo */
            $this->Inscricao->Alunonovo->contain();
            $alunonovo = $this->Inscricao->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro]
            ]);
            // pr($alunonovo);
            // die('alunonovo');
            // Aluno novo cadastrado: cadastra aluno com os dados do alunonovo
            if ($alunonovo) {
                // pr('Cadastra alunonovo em aluno');
                /* Situação irregular aluno sem estágio porém cadastrado como estagiário */
                $this->Inscricao->Aluno->contain();
                $aluno = $this->Inscricao->Aluno->find('first', [
                    'conditions' => ['Aluno.registro' => $registro]
                ]);
                if (empty($aluno)) {
                    /* Excluo o id porque é uma nova inserção */
                    unset($alunonovo['Alunonovo']['id']);
                    // pr($alunonovo);
                    // die('alunonovo');
                    $this->Inscricao->Aluno->set($alunonovo['Alunonovo']);
                    /* Aluno criado ainda sem o estagiario. Se o usuário aborta a operação de inserir um estagiário então o aluno fica orfão */
                    if ($this->Inscricao->Aluno->save()):
                        $this->Flash->success(__("Aluno cadastrado"));
                    else:
                        // pr($this->Inscricao->Aluno->validationErrors);
                        // die();
                        $this->Flash->error(__("Não foi possível finalizar o cadastro. Preencha corretamente todos os dados"));
                        $this->redirect(['controller' => 'Alunonovos', 'action' => 'view', $alunonovo['Alunonovo']['id']]);
                        die("Não cadastrado");
                    endif;
                }
            } else {
                $this->Flash->error(__("Aluno não cadastrado"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'add?registro=' . $registro]);
            }
            // Aluno estagiário
        } else {

            /* Calculo o ano de ingresso para definir se é do ajuste2020 */
            // pr(intval(substr($estagiario['Estagiario']['registro'], 1, 2)));
            if (strlen(trim($estagiario['Estagiario']['registro'])) == 9) {
                if (intval(substr(trim($estagiario['Estagiario']['registro']), 1, 2)) > 19) {
                    // echo 'estudante ingressou em 2020 ou depois';
                    $estagiario['Estagiario']['ajuste2020'] = 1;
                    $ultimo_nivel_curricular = 3;
                } else {
                    $estagiario['Estagiario']['ajuste2020'] = 0;
                    $ultimo_nivel_curricular = 4;
                }
            } elseif (strlen(trim($estagiario['Estagiario']['registro'])) == 8) {
                /* Alunos anteriores ao ano de 2000 */
                $estagiario['Estagiario']['ajuste2020'] = 0;
                $ultimo_nivel_curricular = 4;
            }
            // die();
            $nivel_ultimo = null;
            /* Periodo cadastrado é menor que periodo atual então tem que cadastrar novo estágio */
            if ($estagiario['Estagiario']['periodo'] < $periodo) {

                $estagiario['Estagiario']['id'] = null;
                $inserir = 0; // Inserir

                if ($estagiario['Estagiario']['nivel'] < $ultimo_nivel_curricular) {
                    $nivel_ultimo = $estagiario['Estagiario']['nivel'] + 1;
                    // die("Inserir novo estágio");
                } elseif ($estagiario['Estagiario']['nivel'] >= $ultimo_nivel_curricular) {
                    $nivel_ultimo = 9; // estágio não obrigatório
                    // die("Inserir novo estágio não obrigatório");
                }
                // pr($nivel_ultimo);
                // die();
                /* Se o periodo cadastrado é igual ao periodo atual então o aluno está solicitando novamente o mesmo termo de compromisso */
            } elseif ($estagiario['Estagiario']['periodo'] == $periodo) {
                $nivel_ultimo = $estagiario['Estagiario']['nivel'];
                $inserir = 1; // Atualizar estagiario
                // die("Atualizar estágio");
            } else {
                $this->Flash->error(__("Período atual é menor que período de estágio cadastrado. Verifique os dados."));
                $this->redirect(['controller' => 'inscricaos', 'action' => 'termosolicita']);
            }
            // die();
        }

        /* Capturo as instituicoes */
        $this->loadModel('Instituicao');
        $this->Instituicao->contain();
        $instituicoes = $this->Instituicao->find(
                'list',
                [
                    'fields' => ['Instituicao.id', 'Instituicao.instituicao'],
                    'order' => 'Instituicao.instituicao',
                ]
        );
        // pr($instituicoes);

        /* Capturo os supervisores da instituicao atual */
        if (isset($estagiario['Estagiario']['id_instituicao'])) {
            // $this->Instituicao->contain('Supervisor', ['order' => 'nome']);
            $supervisores = $this->Instituicao->find(
                    'first',
                    [
                        'contain' => ['Supervisor' => ['order' => 'nome']],
                        'conditions' => ['Instituicao.id' => $estagiario['Estagiario']['id_instituicao']]
                    ]
            );

            foreach ($supervisores['Supervisor'] as $supervisor) {
                $supervisoresAtuais[$supervisor['id']] = $supervisor['nome'];
                // pr($supervisor['nome']);
            }
        }

        // Envio os dados
        $this->set('estagiario_id', isset($estagiario['Estagiario']['id']) ? $estagiario['Estagiario']['id'] : null);
        $this->set('inserir', $inserir);
        $this->set('nivel', $nivel_ultimo);
        $this->set('ingresso', isset($estagiario['Alunonovo']['ingresso']) ? $estagiario['Alunonovo']['ingresso'] : (isset($alunonovo['Alunonovo']['ingresso']) ? $alunonovo['Alunonovo']['ingresso'] : null));
        $this->set('alunonovoturno', isset($estagiario['Alunonovo']['turno']) ? $estagiario['Alunonovo']['turno'] : (isset($alunonovo['Alunonovo']['turno']) ? $alunonovo['Alunonovo']['turno'] : null));
        $this->set('id_aluno', isset($estagiario['Estagiario']['id_aluno']) ? $estagiario['Estagiario']['id_aluno'] : null);
        $this->set('registro', $registro);
        $this->set('aluno', isset($estagiario['Alunonovo']['nome']) ? $estagiario['Alunonovo']['nome'] : (isset($alunonovo['Alunonovo']['nome']) ? $alunonovo['Alunonovo']['nome'] : null));
        $this->set('turno', isset($turno_ultimo) ? $turno_ultimo : 'I');
        $this->set('periodo', $periodo);
        // $this->set('id_area', $id_area);
        $this->set('complemento_id', isset($estagiario['Estagiario']['complemento_id']) ? $estagiario['Estagiario']['complemento_id'] : null);
        $this->set('alunonovo_id', isset($estagiario['Alunonovo']['id']) ? $estagiario['Alunonovo']['id'] : '');
        $this->set('ajuste2020', isset($estagiario['Estagiario']['ajuste2020']) ? $estagiario['Estagiario']['ajuste2020'] : 0);

        $this->set('professor_atual', isset($estagiario['Estagiario']['id_professor']) ? $estagiario['Estagiario']['id_professor'] : 0);
        $this->set('instituicao_atual', isset($estagiario['Estagiario']['id_instituicao']) ? $estagiario['Estagiario']['id_instituicao'] : 0);
        $this->set('supervisor_atual', isset($estagiario['Estagiario']['id_supervisor']) ? $estagiario['Estagiario']['id_supervisor'] : 0);

        $this->set('instituicoes', $instituicoes);
        $this->set('supervisores', isset($super_atuais) ? $super_atuais : null); // Aluno sem estaǵio não tem supervisores de instituição cadastrados
    }

    /*
     * O id eh o registro do aluno
     * Está com um problema na hora de avançar um nível de estágio
     */

    public function termocadastra($id = null) {

        $registro = $this->request->query('registro');

        // pr($this->data);
        // die();
        if ($this->data) {

            // Tem que ter o id da instituicao diferente de zero
            if (empty($this->data['Estagiario']['id_instituicao'])) {
                $this->Flash->error(__('Selecione uma instituição de estágio'));
                $this->redirect('/Inscricaos/termosolicita/');
                die('Faltou selecionar uma instituição');
            }

            $this->Inscricao->Alunonovo->contain();
            $alunonovo = $this->Inscricao->Alunonovo->find(
                    'first',
                    [
                        'conditions' => ['Alunonovo.registro' => $this->data['Estagiario']['registro']]
                    ]
            );

            /* Verifica que o ano de ingresso digitado corresponda com a numeração inicial do DRE */
            $anoRegistro = '20' . substr(trim($this->data['Estagiario']['registro']), 1, 2); // ano a partir do registro
            $anoDigitado = substr(trim($this->data['Estagiario']['ingresso']), 0, 4); // ano digitado

            if ($anoRegistro != $anoDigitado) {
                $this->Flash->error(__("Ano e semestre de ingresso errado. Ano de ingresso digitado é " . $anoDigitado . " quando deveria ser " . $anoRegistro . "."));
                $this->redirect(['controller' => 'alunonovos', 'action' => 'view?registro=' . $registro]);
            }

            $alunonovo['Alunonovo']['ingresso'] = $this->data['Estagiario']['ingresso'];
            $alunonovo['Alunonovo']['turno'] = $this->data['Estagiario']['alunonovoturno'];

            /* Atualiza o registro do alunonovo como os dados de ingresso e de turno */
            if ($this->Inscricao->Alunonovo->save($alunonovo)) {
                $this->Flash->success(__("Atualização realizada"));
            }

            if (!ctype_digit($this->data['Estagiario']['benebolsa'])) {
                $this->Flash->error(__("Preencha o valor da bolsa com números ou, se não tiver bolsa, digite o número 0"));
                $this->redirect('termocompromisso?registro=' . $registro);
            }

            /* Atualiza o registro do aluno como os dados de ingresso e de turno */
            $this->Inscricao->Aluno->contain();
            $aluno = $this->Inscricao->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->data['Estagiario']['registro']]
            ]);
            /*
              Se o estagiario não está cadastrado na tabela Aluno, é um erro muito raro.
              Pode ter acontecido por excluir um aluno sem excluir os estágios correspondentes.
              Faço o cadastro.
             */
            if (empty($aluno)) {
                /* Cadastro o aluno com o id que está na tabela de estagiario? */
                $alunonovo['Alunonovo']['id'] = $this->data['Estagiario']['id_aluno'];
                $this->Inscricao->Aluno->save($alunonovo['Alunonovo'], ['validate' => true]);
                // $this->redirect(['controller' => 'estagiarios', 'action' => 'view', $this->Aluno->id]);
            } else {
                /* Preservo o valor da variavel $alunonovo['Alunonovo']['id'] */
                $alunonovoId = $alunonovo['Alunonovo']['id'];
                /* Para atualizar a tabela Aluno tenho que utilizar o id do Aluno */
                $alunonovo['Alunonovo']['id'] = $aluno['Aluno']['id'];
                //  pr($alunonovo['Alunonovo']);
                // die('Atualiza');
                $this->Inscricao->Aluno->save($alunonovo['Alunonovo'], ['validate' => true]);
                $this->Flash->success(__("Aluno atualizado"));
            }

            /* Capturo o $aluno_id */
            $this->Inscricao->Aluno->contain();
            $query_aluno_id = $this->Inscricao->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro],
                'fields' => ['id']
            ]);
            // pr($query_aluno_id);
            // die();
            $id_aluno = $query_aluno_id['Aluno']['id'];

            /* Preencho com o valor 0 o complemento_id caso esteja vazio */
            if (empty($this->data['Estagiario']['complemento_id'])) {
                $this->request->data['Estagiario']['complemento_id'] = 0;
            }

            $this->request->data['Estagiario']['id_aluno'] = $id_aluno;
            $this->request->data['Estagiario']['alunonovo_id'] = $alunonovoId;
            $this->Inscricao->Estagiario->set($this->data);
            if ($this->Inscricao->Estagiario->save($this->data, ['validate' => true])) {
                $this->Flash->success(__('Registro de estágio inserido/atualizado'));
                $this->redirect('/Inscricaos/termoimprime?estagiario_id=' . $this->Inscricao->Estagiario->id . '&tipo_de_estagio=' . $this->data['Estagiario']['complemento_id']);
            } else {
                $errors = $this->Inscricao->Estagiario->invalidFields();
                $this->Session->setFlash(implode(', ', $errors));
                $this->Flash->error(__('Não foi possível fazer a inscrição. Tente novamente.'));
                die("Error: não foi possível atualizar inscrição de estágio");
            }
        }
    }

    /* id eh o id do estagiario */

    public function termoimprime($id = null) {

        ini_set('memory_limit', '512M');
        // echo "Estagiario id " . $id . "<br>";
        // Configure::write('debug', 2);

        if (is_null($id)) {
            $id = $this->request->query['estagiario_id'];
        }

        $estagiario = $this->Inscricao->Estagiario->find('first', [
            'conditions' => ['Estagiario.id' => $id]
        ]);
        $tipo_de_estagio = $estagiario['Estagiario']['complemento_id'];

        $instituicao_nome = $estagiario['Instituicao']['instituicao'];
        $supervisor_nome = $estagiario['Supervisor']['nome'];
        if (empty($supervisor_nome)) {
            $supervisor_nome = null;
        }
        $aluno_nome = $estagiario['Alunonovo']['nome'];
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
        if (empty($tipo_de_estagio) || $tipo_de_estagio == "0") {
            // pr($tipo_de_estagio);
            // die('presencial');
            $this->redirect(['action' => 'imprimepdf', $id, 'ext' => 'pdf', $registro]);
            // echo $this->Html->link(__('Imprime PDF'), array('action' => 'imprimepdf', $id, 'ext' => 'pdf', $registro));
        } else {
            // pr($tipo_de_estagio);
            // die('remoto');
            $this->redirect(['action' => 'imprimepdfremoto', $id, 'ext' => 'pdf', $registro]);
        }
    }

    /* Envia os dados para imprimir o PDF diretamente  */

    function imprimepdf($id = null) {

        $this->Inscricao->Estagiario->contain('Alunonovo', 'Instituicao', 'Supervisor');
        $estagiario = $this->Inscricao->Estagiario->find(
                'first',
                [
                    'conditions' => array('Estagiario.id' => $id)
                ]
        );

        // Capturo o inicio e o fim do termo de compromisso
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $termoinicio = $configuracao['Configuracao']['termo_compromisso_inicio'];
        $termofinal = $configuracao['Configuracao']['termo_compromisso_final'];

        $termoinicio_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termoinicio)));
        $termofinal_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termofinal)));

        $this->set('registro', $estagiario['Estagiario']['registro']);
        $this->set('instituicao_nome', $estagiario['Instituicao']['instituicao']);
        $this->set('aluno_nome', $estagiario['Alunonovo']['nome']);
        $this->set('supervisor_nome', $estagiario['Supervisor']['nome']);
        $this->set('supervisor_cress', $estagiario['Supervisor']['cress']);
        $this->set('nivel', $estagiario['Estagiario']['nivel']);
        $this->set('termoinicio', $termoinicio_f);
        $this->set('termofinal', $termofinal_f);
    }

    /* Termo de compromisso para estágio remoto */

    function imprimepdfremoto($id = null) {

        $this->Inscricao->Estagiario->contain('Alunonovo', 'Instituicao', 'Supervisor');
        $estagiario = $this->Inscricao->Estagiario->find(
                'first',
                [
                    'conditions' => array('Estagiario.id' => $id)
                ]
        );

        // Capturo o inicio e o fim do termo de compromisso
        $this->loadModel("Configuracao");
        $configuracao = $this->Configuracao->findById('1');
        $termoinicio = $configuracao['Configuracao']['termo_compromisso_inicio'];
        $termofinal = $configuracao['Configuracao']['termo_compromisso_final'];

        $termoinicio_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termoinicio)));
        $termofinal_f = utf8_encode(strftime('%e de %B de %Y', strtotime($termofinal)));

        $this->set('registro', $estagiario['Estagiario']['registro']);
        $this->set('instituicao_nome', $estagiario['Instituicao']['instituicao']);
        $this->set('aluno_nome', $estagiario['Alunonovo']['nome']);
        $this->set('supervisor_nome', $estagiario['Supervisor']['nome']);
        $this->set('supervisor_cress', $estagiario['Supervisor']['cress']);
        $this->set('nivel', $estagiario['Estagiario']['nivel']);
        $this->set('termoinicio', $termoinicio_f);
        $this->set('termofinal', $termofinal_f);
    }

    /* Preencho a tabela inscrição com o id da tabela alunosnovos (alias estudantes) */

    public function estudante() {

        $this->loadModel('Alunonovo');
        $this->Alunonovo->contain();
        $estudantes = $this->Alunonovo->find('all', [
            'fields' => ['id', 'registro']
        ]);
        // pr($estudantes);
        // die();

        foreach ($estudantes as $c_estudante) {
            // pr($c_estudante);
            // die();
            $this->Inscricao->contain();
            $inscricao = $this->Inscricao->find('first', [
                'conditions' => ['Inscricao.id_aluno' => $c_estudante['Alunonovo']['registro']]
            ]);
            // pr($inscricao);
            /*
              if ($this->Inscricao->save($this->data)) {
              $this->Session->setFlash(__("Inscrição atualizada"));
             */

            if ($inscricao) {
                if (
                        $this->Inscricao->updateAll(
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
                if (
                        $this->Inscricao->updateAll(
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
