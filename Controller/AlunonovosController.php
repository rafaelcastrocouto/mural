<?php

App::uses('AppController', 'Controller');

/**
 * Alunonovos Controller
 *
 * @property Alunonovo $Folhadeatividade
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 * @property RequestHandlerComponent $RequestHandler
 * @property AuthComponent $Auth
 */
class AlunonovosController extends AppController {

    public $name = "Alunonovos";
    public $components = ['Auth', 'Flash', 'Paginator', 'RequestHandler'];
    public $paginate = [
        'limit' => 15,
        'contain' => ['Estagiario']
    ];

    public function beforeFilter() {

        parent::beforeFilter();

        /** Para cadastrar usuarios do sistema precisso abrir este metodo */
        $this->Auth->allow('add');

        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash('Administrador');
            /** Estudantes podem somente fazer inscricao */
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('add', 'edit', 'index', 'view', 'certificadoperiodo', 'declaracaoperiodopdf');
            // $this->Session->setFlash('Estudante');
            /** Professores podem atualizar murais */
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('edit', 'index', 'view');
            // $this->Session->setFlash('Professor');
            /** No futuro os supervisores poderao lançar murals */
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('add', 'edit', 'index', 'view');
            // $this->Session->setFlash('Supervisor');
            /** Os outros não podem fazer nada */
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect(['controller' => 'murals', 'action' => 'index']);
        }
    }

    public function index() {

        $this->Paginator->settings = [
            'Alunonovo' => [
                'limit' => 10,
                'order' => ['Alunonovo.nome' => 'ASC']
            ]
        ];

        $this->set('alunonovo', $this->Paginator->paginate('Alunonovo'));
    }

    public function estudantes() {
 
        $this->Alunonovo->contain(['Estagiario', 'Inscricao']);

        /* Conta as inscrições e os estágios cursados. O servidor não suporta todos os registros, faço por lotes de 1000 */ 
        $estudantes = $this->Alunonovo->find('all');
        // $estudantes = $this->Alunonovo->find('all', ['limit' => 1000, 'offset' => 0]);
 
        if ($estudantes) {
            foreach ($estudantes as $estudante) {
                if ($estudante['Alunonovo']['inscricao_count'] == 0 || $estudante['Alunonovo']['estagiario_count'] == 0) {
                    $estudante['Alunonovo']['inscricao_count'] = count($estudante['Inscricao']);
                    $estudante['Alunonovo']['estagiario_count'] = count($estudante['Estagiario']);
 
                    /* Atualiza o registro com os novos dados */
                    if ($this->Alunonovo->save($estudante['Alunonovo'], ['validates' => true])) {
                        // echo $id = $this->Alunonovo->id;
                     } else {
                        // echo $errors = $this->Alunonovo->validationErrors;
                    }
                }

                if (empty($estudante['Alunonovo']['ingresso'])) {
                    // Se o DRE tem 9 dígitos então os dígitos 1 e 2 correspondem ao século XXI
                    if (strlen(trim($estudante['Alunonovo']['registro'])) == 9) {
                        $estudante['Alunonovo']['ingresso'] = '20' . substr($estudante['Alunonovo']['registro'], 1, 2);
                    // Se o DRE tem 8 dígitos então os dois primeiros dígitos corresponde ao século XX
                    } elseif (strlen(trim($estudante['Alunonovo']['registro'])) == 8) {
                        // pr($aluno);
                        $estudante['Alunonovo']['ingresso'] = '19' . substr($estudante['Alunonovo']['registro'], 0, 2);
                    } else {
                        // $this->Flash->error(__("DRE errado: " . $estudante['Alunonovo']['registro'] . " " . $estudante['Alunonovo']['nome']));
                    }

                    if ($this->Alunonovo->save($estudante['Alunonovo'], ['validates' => true])) {
                        // echo $id = $this->Alunonovo->id;
                    } else {
                        // $errors = $this->Alunonovo->validationErrors;
                    }
                }
            } // fecha loop foreach
        } // fecha If estudantes

        $this->Paginator->settings = [
            'fields' => ['Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.registro', 'Alunonovo.email', 'Alunonovo.celular', 'Alunonovo.ingresso', 'Alunonovo.inscricao_count', 'Alunonovo.estagiario_count'],
            'limit' => 10,
            'order' => ['Alunonovo.nome']
        ];

        $this->set('estudantes', $this->Paginator->paginate('Alunonovo'));
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso
     */
    public function add($id = null) {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        /* alunonovos/add?dre=100100100 */
        if (!$registro) {
            $registro = $this->request->query('registro');
        }
        // pr($registro);
        // die('registro');
        $this->set('registro', $registro);

        // Para construir o datalist
        $this->set('orgaos', $this->orgao());

        // pr($this->data);
        // die();
        if ($this->Alunonovo->save($this->data, ['validate' => false])) {

            /** Se o aluno foi cadastrado então gravo na sessao para continuar na navegação */
            $this->Session->write('id_categoria', '2');
            $this->Session->write('numero', $registro);
            // die();
            /** Capturo o id da instituicao (se foi chamada desde inscriacao add) */
            $inscricao_selecao_estagio = $this->Session->read('id_instituicao');

            /** Capturo se foi chamado desde a solicitacao do termo */
            $registro_termo = $this->Session->read('termo');

            /** Vejo se foi chamado desde users/cadastro. Acho que já não tem nenhuma função */
            $cadastro = $this->Session->read('cadastro');
            $this->Session->write('user', $this->data['Alunonovo']['nome']);

            $nome = $this->data['Alunonovo']['nome'];
            $this->Flash->success(__("Cadastro realizado: " . $nome));

            /** Inserir o estudante_id na tabela User */
            $this->loadModel('User');
            $user = $this->User->find('first', [
                'conditions' => ['User.numero' => $this->data['Alunonovo']['registro']]
            ]);
            /** Se já há um user cadastrado, então atualiza com o estudante_id */
            if ($user) {
                $this->User->id = $user['User']['id'];
                if ($this->User->id) {
                    $this->User->saveField('estudante_id', $this->Alunonovo->getLastInsertId());
                    $this->Flash->success(__("Atualizada tabela User: " . $registro));
                }
            }

            if ($inscricao_selecao_estagio) {
                $this->redirect(['controller' => 'Inscricaos', 'action' => 'inscricao?registro=' . $registro]);
            }

            if ($registro_termo) {
                $this->Session->delete('termo');
                $this->redirect(['controller' => 'Inscricaos', 'action' => 'termocompromisso?registro=' . $registro_termo]);
                die("Redireciona para concluir solicitacao de termo de compromisso");
            }

            if ($cadastro) {
                $this->Session->delete('cadastro');
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'view', $id_alunonovo]);
            } else {
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                $this->Flash->success(__('Dados inseridos'));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'view', $id_alunonovo]);
            }
        }
    }

    /*
     * id eh o id do alunonovo
     * registro vem como parâmetro
     *
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso     *
     */
    public function edit($id = null) {

        /** Verifica autorização: somente o administrador e o próprio aluno podem editar */
        if ($this->Session->read('id_categoria') != 1):
            if ($this->Session->read('id_categoria') == '2' && $this->Session->read('numero')) {
                $this->Alunonovo->contain();
                $verifica = $this->Alunonovo->find('first', [
                    'conditions' => ['registro' => $this->Session->read('numero')],
                    'fields' => ['id', 'registro']
                ]);
                if ($id) {
                    if ($id != $verifica['Alunonovo']['id']) {
                        $this->Flash->error(__("Acesso não autorizado"));
                        $this->redirect(['controller' => 'Alunonovo', 'action' => 'index']);
                        die("Não autorizado");
                    }
                } else {
                    $this->Flash->error(__("Error: Id nulo"));
                    $this->redirect(['controller' => 'Alunonovos', 'action' => 'index']);
                    die("Não autorizado");
                }
            } else {
                $this->Flash->error(__("Acesso não autorizado"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'index']);
            }
        endif;

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : null;
        if (!$registro) {
            $registro = $this->request->query("registro");
        }
        // pr($registro);
        // die();

        /** Calculo o id a partir do registro */
        if ($registro) {
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro]
            ]);
            if ($alunonovo_id) {
                $id = $alunonovo_id['Alunonovo']['id'];
            } else {
                $this->Flash->error(__("Registro do estudante inexistente"));
                $this->redirect(['controller' => 'alunonovos', 'action' => 'index']);
                die();
            }
        }
        // pr($id);
        // die();
        /** Capturo os dados do orgão para enviar para o formulário */
        $e_orgao = $this->Alunonovo->find('first', ['conditions' => ['Alunonovo.id' => $id]]);
        $this->set('e_orgao', $e_orgao);

        /** Chamo a função orgao() para capturar os orgãos de expedição da carteira de identidade */
        $this->set('orgaos', $this->orgao());

        $this->Alunonovo->id = $id;

        if (empty($this->data)) {
            $this->data = $this->Alunonovo->read();
        } else {
            /** Se a data de ingresso vem com o semestre igual a 0 então só guardo o ano */
            if ($this->data['Alunonovo']['ingresso']) {
                $ingresso = explode('-', $this->data['Alunonovo']['ingresso']);
                if ($ingresso[1] == 0) {
                    $this->request->data['Alunonovo']['ingresso'] = $ingresso[0];
                }
            }
            // pr($this->data);
            // die();
            if ($this->Alunonovo->save($this->data)) {
                $this->Flash->success(__("Atualizado!"));

                /** Capturo o id da instituicao (se foi chamada desde inscriacao add)  */
                $inscricao_selecao_estagio = $this->Session->read('id_instituicao');
                // die();
                // Ainda nao posso apagar
                // $this->Session->delete('id_instituicao');
                /** Capturo se foi chamado desde a solicitacao do termo  */
                $registro_termo = $this->Session->read('termo');
                $this->Session->delete('termo');
                if ($inscricao_selecao_estagio) {
                    /** Faz inscricao para selecao de estagio  */
                    $this->Flash->success(__("Inscricao para selecao de estagio"));
                    $this->redirect(['controller' => 'Inscricaos', 'action' => 'inscricao?registro=' . $this->data['Alunonovo']['registro']]);
                } elseif (!empty($registro_termo)) {
                    /** Solicita termo de compromisso  */
                    $this->Flash->success(__("Solicitação do termo de compromisso"));
                    $this->redirect(['controller' => 'Inscricaos', 'action' => 'termocompromisso?registro=' . $registro_termo]);
                } else {
                    /** Simplesmente atualiza e mostra o resultado  */
                    $this->redirect(['controller' => 'Alunonovos', 'action' => 'view', $id]);
                }
            }
        }
    }

    public function view($id = null) {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query("registro");
        }

        /** Obtenho o id a partir do registro */
        if ($registro) {
            $this->Alunonovo->contain();
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro]
            ]);
            if ($alunonovo_id) {
                $id = $alunonovo_id['Alunonovo']['id'];
            } else {
                $this->Flash->error(__("Registro do estudante inexistente"));
                $this->redirect(['controller' => 'alunonovos', 'action' => 'index']);
                die();
            }
        }

        if (!isset($id) && (!empty($id))) {
            $id = $alunonovo_id['Alunonovo']['id'];
        }

        /** Verifica autorização */
        if ($this->Session->read('id_categoria') != 1) {
            if (($this->Session->read('id_categoria') == '2') && ($this->Session->read('numero'))) {
                $this->Alunonovo->contain();
                $verifica = $this->Alunonovo->find('first', [
                    'conditions' => ['Alunonovo.registro' => $this->Session->read('numero')],
                    'fields' => ['registro', 'id']
                ]);
                // pr($verifica);
                // die('verifica');
                if ($id) {
                    if ($id != $verifica['Alunonovo']['id']) {
                        $this->Flash->error(__("Acesso não autorizado"));
                        $this->redirect(['controller' => 'Alunonovos', 'action' => 'index']);
                        die("Não autorizado");
                    }
                } elseif ($registro) {
                    if ($registro != $verifica['Alunonovo']['registro']) {
                        $this->Flash->error(__("Acesso não autorizado"));
                        $this->redirect(['controller' => 'Alunonovos', 'action' => 'index']);
                        die("Não autorizado");
                    }
                }
            } else {
                $this->Flash->error(__("Acesso não autorizado"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'index']);
            }
        }

        /** Obtenho o registro do aluno com o Id ou com o Registro */ 
        if ($id) {
            $aluno = $this->Alunonovo->find(
                    'first',
                    ['conditions' => ['Alunonovo.id' => $id]]
            );
        } elseif ($registro) {
            $aluno = $this->Alunonovo->find(
                    'first',
                    ['conditions' => ['Alunonovo.registro' => $registro]]
            );
        }

        if (!isset($aluno) || empty($aluno)) {
            $this->Flash->error(__('Estudante não cadastrado'));
            $this->redirect(['controller' => 'Alunonovos', 'action' => 'index']);
            die();
        }

        /** Inscricoes realizadas */ 
        $this->loadModel('Inscricao');
        $this->Inscricao->contain(['Mural']);
        $inscricoes = $this->Inscricao->findAllByIdAluno($aluno['Alunonovo']['registro']);

        /** Estágios cursados */
        $this->loadModel('Estagiario');
        $this->Estagiario->contain(['Supervisor', 'Instituicao', 'Professor', 'Complemento', 'Area']);
        $estagios = $this->Estagiario->find('all', [
            'conditions' => ['Estagiario.registro' => $aluno['Alunonovo']['registro']]
        ]);

        /** Para construir o menu superior da view */
        if ($estagios):
            $this->Session->write('estagiario', '1');
        else:
            $this->Session->write('estagiario', '0');
        endif;

        $this->set('alunos', $aluno);
        $this->set('inscricoes', $inscricoes);
        $this->set('estagios', $estagios);
    }

    public function delete($id = NULL) {

        /** Capturo o numero de registro */
        $registro = $this->Alunonovo->find('first', [
            'conditions' => ['Alunonovo.id' => $id],
            'fields' => 'registro'
        ]);

        if ($registro) {
            /** Capturo os estagios realizados */
            $this->loadModel('Estagiario');
            $estagiario = $this->Estagiario->find(
                    'first',
                    [
                        'conditions' => ['Estagiario.registro' => $registro['Alunonovo']['registro']],
                        'fields' => 'Estagiario.id'
                    ]
            );
            /** Se tem estágios não pode ser excluído */
            if ($estagiario) {
                $this->Flash->error(__('Estudante com estágios. Exclua os estágio primeiro'));
                $this->redirect(['controller' => 'Estagiarios', 'action' => 'view', $estagiario['Estagiario']['id']]);
                die();
            }

            /** Capturo as inscricoes realizadas */
            $this->loadModel('Inscricao');
            $inscricao = $this->Inscricao->find(
                    'first',
                    [
                        'conditions' => ['Inscricao.id_aluno' => $registro['Alunonovo']['registro']],
                        'fields' => 'id'
                    ]
            );

            /** Se tem inscrições para seleção de estágio não pode ser excluído */
            if ($inscricao) {
                $this->Flash->error(__('Estudante com inscrições. Exclua as inscrições primeiro'));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'view', $inscricao['Inscricao']['alunonovo_id']]);
            }
        }

        if ($this->Alunonovo->delete($id)) {
            $this->Flash->success(__("Registro excluído"));
            $this->redirect(['controller' => 'Inscricaos', 'action' => 'index']);
        } else {
            $this->Flash->error(__("Não foi possível excluir o registro"));
            $this->redirect(['controller' => 'Inscricaos', 'action' => 'index']);
        }
    }

    /** Captura todos os orgaos de expedição de carterira de identidade para fazer a datalist no input do orgao */
    private function orgao() {

        $this->Alunonovo->contain();
        $orgao = $this->Alunonovo->find('list', [
            'fields' => ['orgao'],
            'order' => ['orgao'],
            'group' => ['orgao']
        ]);
        return $orgao;
    }

    public function busca($nome = NULL) {

        /** Para paginar os resultados da busca por nome */
        if (isset($nome)) {
            $this->request->data['Alunonovo']['nome'] = $nome;
        }

        if (!empty($this->data['Alunonovo']['nome'])) {

            $this->Alunonovo->contain();
            $condicaoalunonovo = ['Alunonovo.nome like' => '%' . $this->data['Alunonovo']['nome'] . '%'];
            $alunos = $this->Alunonovo->find('all', [
                'conditions' => $condicaoalunonovo
            ]);
            // pr($alunos);
            // die();
            /** Se não houver resultados informo como erro, se houver então envio paginado para a view */
            if (empty($alunos)) {
                $this->loadModel('Aluno');
                $condicaoaluno = ['Aluno.nome like' => '%' . $this->data['Alunonovo']['nome'] . '%'];
                $alunos = $this->Aluno->find('all', ['conditions' => $condicaoaluno]);
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros"));
                } else {
                    $this->Paginator->settings = ['order' => ['Alunonovo.nome ASC'], 'limit' => 10, 'conditions' => $condicaoalunonovo];
                    $this->set('alunos', $this->Paginator->paginate('Alunonovo'));
                    $this->set('nome', $this->data['Aluno']['nome']);
                }
            } else {
                $this->Paginator->settings = ['order' => 'Alunonovo.nome ASC', 'limit' => 10, 'conditions' => $condicaoalunonovo];
                $this->set('alunos', $this->Paginator->paginate('Alunonovo'));
                $this->set('nome', $this->data['Alunonovo']['nome']);
            }
        }
    }

    public function busca_dre() {

        // pr($this->data);
        if (!empty($this->data['Alunonovo']['registro'])) {
            $alunos = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $this->data['Alunonovo']['registro']]
            ]);
            // pr($alunos);
            // die('alunos');
            if (empty($alunos)) {
                /** Buscar na tabela alunos. Não deveria existr um Aluno que não seja também Alunonovo */
                $this->loadModel('Aluno');
                $alunonovos = $this->Aluno->findFirstByRegistro($this->data['Alunonovo']['registro']);
                // pr($alunonovos);
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros da(o) estudante"));
                    $this->redirect(['controller' => 'Alunonovos', 'action' => 'busca_dre']);
                } else {
                    $this->Flash->success(__('Estudante'));
                    $this->redirect(['controller' => 'Alunos', 'action' => 'view', $alunonovos['Aluno']['id']]);
                }
            } else {
                // die($alunos['Alunonovo']['id']);
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'view', $alunos['Alunonovo']['id']]);
            }
        }
    }

    public function busca_email() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Alunonovo->findAllByEmail($this->data['Alunonovo']['email']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do email aluno"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'busca']);
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
            $alunos = $this->Alunonovo->findAllByCpf($this->data['Alunonovo']['cpf']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do CPF"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'busca_cpf']);
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function certificadoperiodo($id = NULL) {

        /** Autorização */
        if ($this->Session->read('id_categoria') == 1):
            $usuarioautorizado = 1;
        else:
            $registro = $this->request->query('registro');
            if ($registro):
                if ($this->Session->read('id_categoria') == 2 && $this->Session->read('numero') == $registro):
                    $usuarioautorizado = 1;
                else:
                    $this->Flash->error(__("Estudante não autorizado"));
                    die("Acesso denegado: registro de estudante não autorizado");
                endif;
            elseif ($id):
                $this->Alunonovo->contain();
                $estudanteregistro = $this->Alunonovo->find(
                        'first',
                        [
                            'conditions' => ['Alunonovo.id' => $id]
                        ]
                );
                if ($estudanteregistro):
                    if ($this->Session->read('id_categoria') == 2 && $this->Session->read('numero') == $estudanteregistro['Alunonovo']['registro']):
                        $usuarioautorizado = 1;
                    else:
                        $this->Flash->error(__("Estudante não autorizado"));
                        die("Acesso denegado: id de estudante não autorizado");
                    endif;
                else:
                    $this->Flash->error(__("Estudante não localizado"));
                    die('Estudante não localizado');
                endif;
            else:
                $this->Flash->error(__("Estudante não autorizado"));
                die("Acesso denegado");
            endif;
        endif;

        if ($id) {
            $this->Alunonovo->contain();
            $estudante = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.id' => $id]
            ]);
        } else {
            $registro = $this->request->query('registro');
            if ($registro) {
                $this->Alunonovo->contain();
                $estudante = $this->Alunonovo->find('first', [
                    'conditions' => ['Alunonovo.registro' => $registro]
                ]);
            }
        }

        if (empty($estudante)):
            $this->Flash->error(__("Estudante não cadastado na tabela de alunonovos"));
            $this->redirect(['controller' => 'Alunonovos', 'action' => 'busca']);
        endif;

        /** Capturo o periodo do calendario academico atual */
        $this->loadModel('Configuracao');
        $periodoacademicoatual = $this->Configuracao->find('first');

        $this->set('estudante', $estudante);
        $this->set('periodocalendarioacademico', $periodoacademicoatual['Configuracao']['periodo_calendario_academico']);
    }

    public function declaracaoperiodopdf($id = NULL) {

        if ($this->data) {
            if ($this->Alunonovo->save($this->data)):
                $this->Flash->success(__('Atualizado!'));
            else:
                $errors = $this->Alunonovo->invalidFields();
                // pr($errors);
                $this->Flash->error(__('Não atualizado!'));
            endif;
        }

        if ($id) {
            $estudante = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.id' => $id],
                'fields' => ['id', 'nome', 'cpf', 'identidade', 'orgao', 'registro', 'ingresso', 'turno']
            ]);
        } else {
            $registro = $this->request->query('registro');
            if ($registro) {
                $estudante = $this->Alunonovo->find('first', [
                    'conditions' => ['Alunonovo.registro' => $registro],
                    'fields' => ['id', 'nome', 'cpf', 'identidade', 'orgao', 'registro', 'ingresso', 'turno']
                ]);
            }
        }

        $periodoacademico = explode('-', $this->data['Alunonovo']['periodoacademico']);
        if (strlen($this->data['Alunonovo']['ingresso'] == 6)) {
            $ingresso = explode('-', $this->data['Alunonovo']['ingresso']);
        } else {
            $this->Flash->error(__('Digite o ano e semestre de ingresso no curso'));
            $this->redirect(['controller' => 'Alunonovo', 'action' => 'view', $id]);
        }
        $totalperiodo = (intval($periodoacademico[0]) - intval($ingresso[0])) * 2;

        if ((intval($ingresso[1]) == 1) && (intval($periodoacademico[1]) == 1)):
            $totalperiodo = $totalperiodo + 1;
        endif;

        if ((intval($ingresso[1]) == 1) && (intval($periodoacademico[1]) == 2)):
            $totalperiodo = $totalperiodo + 2;
        endif;

        if ((intval($ingresso[1]) == 2) && (intval($periodoacademico[1]) == 1)):
            $totalperiodo = $totalperiodo;
        endif;

        if ((intval($ingresso[1]) == 2) && (intval($periodoacademico[1]) == 2)):
            $totalperiodo = $totalperiodo + 1;
        endif;

        $this->set('estudante', $estudante);
        $this->set('totalperiodo', $totalperiodo);
    }

    public function padroniza() {

        $alunos = $this->Alunonovo->find('all', ['fields' => ['id', 'nome', 'email', 'endereco', 'bairro']]);
        // pr($alunos);
        // die();
        foreach ($alunos as $c_aluno):

            if ($c_aluno['Alunonovo']['email']):
                $email = strtolower($c_aluno['Alunonovo']['email']);
                $this->Alunonovo->query("UPDATE alunosnovos set email = " . "\"" . $email . "\"" . " where id = " . $c_aluno['Alunonovo']['id']);
            endif;

            if ($c_aluno["Alunonovo"]['nome']):
                $nome = ucwords(strtolower($c_aluno['Alunonovo']['nome']));
                $this->Alunonovo->query("UPDATE alunosnovos set nome = " . "\"" . $nome . "\"" . " where id = " . $c_aluno['Alunonovo']['id']);
            endif;

            if ($c_aluno['Alunonovo']['endereco']):
                $endereco = ucwords(strtolower($c_aluno['Alunonovo']['endereco']));
                $this->Alunonovo->query("UPDATE alunosnovos set endereco = " . "\"" . $endereco . "\"" . " where id = " . $c_aluno['Alunonovo']['id']);
            endif;

            if ($c_aluno['Alunonovo']['bairro']):
                $bairro = ucwords(strtolower($c_aluno['Alunonovo']['bairro']));
                $this->Alunonovo->query("UPDATE alunosnovos set bairro = " . "\"" . $bairro . "\"" . " where id = " . $c_aluno['Alunonovo']['id']);
            endif;

        endforeach;
    }

    /** Cadastro alunonovo a partir do aluno se não estiver cadastrado */
    public function aluno() {

        $this->loadModel('Aluno');
        $this->Aluno->contain();
        $alunos = $this->Aluno->find('all');

        foreach ($alunos as $c_aluno):

            // echo $c_aluno['Aluno']['registro'] . " ";
            $this->Alunonovo->contain();
            $aluno = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $c_aluno['Aluno']['registro']]
            ]);
            // pr($aluno);
            // die();
            if (!$aluno) {
                // echo $c_aluno['Aluno']['registro'] . " Não cadastrado" . "<br>";
                $c_aluno['Aluno']['id'] = null;
                // cadastrar
                // die();
                if ($this->Alunonovo->save($c_aluno)) {
                    $this->Flash->success(__("Cadastro realizado: " . $c_aluno['Aluno']['nome']));
                }
            } else {
                // echo $c_aluno['Aluno']['registro'] . " Cadastrado" . "<br>";
                $alunos[] = $aluno;
                // pr($alunos);
            }

        endforeach;

        die("Tarefa finalizada!");
    }

    public function alunonovos() {

        $this->loadModel('Aluno');
        $this->Alunonovo->contain();
        $alunonovos = $this->Alunonovo->find('all');

        foreach ($alunonovos as $c_alunonovo):

            $this->Aluno->contain();
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $c_alunonovo['Alunonovo']['registro']]
            ]);
            if (!$aluno) {
                echo $c_alunonovo['Alunonovo']['registro'] . " Não cadastrado" . "<br>";
                $nao_cadastrado[] = $c_alunonovo;
                $c_alunonovo['Alunonovo']['id'] = null;
                /*
                  if ($this->Aluno->save($c_alunonovo)) {
                  $this->Flash->success(__("Cadastro realizado: " . $c_alunonovo['Alunonovo']['nome']));
                  }
                 */
            } else {
                $estudantes[] = $aluno;
            }

        endforeach;

        die("Tarefa finalizada!");
    }
}
