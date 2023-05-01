<?php

class UsersController extends AppController {

    public $name = 'Users';
    public $components = array('Auth', 'Paginator', 'Flash');

    public function beforeFilter() {

        parent::beforeFilter();

        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
        } else {
            $this->Auth->allow('login', 'cadastro', 'contato');
        }
    }

    public function login() {

        $this->Session->delete('user');
        $this->Session->delete('categoria');
        $this->Session->delete('id_categoria');
        $this->Session->delete('numero');
        $this->Session->delete('estagiario');

        // pr($this->data);
        // die();
        if (!empty($this->data)) {

            $usuario = $this->User->find('first', array(
                'contain' => ['Role', 'Alunonovo', 'Professor', 'Supervisor'],
                'conditions' => array('User.email' => $this->data['User']['email'])));

            // pr($usuario);
            if (!empty($usuario) and ($usuario['User']['password'] == sha1($this->data['User']['password']))) {
                // die(pr($usuario));
                // die();
                switch ($usuario['User']['categoria']) {
                    case 1: // Administrador
                        $this->Session->write('user', 'Administrador');
                        $this->Session->write('categoria', 'Administrador');
                        $this->Session->write('id_categoria', 1);
                        $this->Session->write('numero', 0);

                        $this->Flash->success(__('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user')));
                        $this->redirect('/estagiarios/index/');
                        break;

                    // Categoria 2 eh estudante
                    case 2:

                        $this->Session->write('user', $usuario['Alunonovo']['email']);
                        $this->Session->write('categoria', $usuario['Role']['categoria']);
                        $this->Session->write('id_categoria', $usuario['User']['categoria']);
                        $this->Session->write('numero', $usuario['User']['numero']);

                        $this->Flash->success('Bem-vinda{o} ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));

                        /*
                         * Busco se há um estudante com esse número de user
                         */
                        $this->loadModel('Alunonovo');
                        $this->Alunonovo->contain(['Estagiario']);
                        $alunonovo = $this->Alunonovo->find('first', [
                            'contain' => [],
                            'fields' => ['Alunonovo.registro', 'Alunonovo.id', 'Alunonovo.nome'],
                            'conditions' => ['Alunonovo.registro' => $usuario['User']['numero']]
                        ]);
                        // pr($alunonovo['Alunonovo']);
                        // die();

                        if (sizeof($alunonovo['Estagiario']) > 0):
                            $this->Session->write('estagiario', '1');
                        else:
                            $this->Session->write('estagiario', '0');
                        endif;

                        /*
                         * Se não há um estudante vou para alunonovo/add para fazer cadastro
                         */
                        if ($alunonovo) {
                            $this->Session->write('user', $alunonovo['Alunonovo']['nome']);
                        } else {
                            // echo "Estudante não cadastrado " . "<br>";
                            $this->redirect('/alunonovos/add?registro=' . $usuario['User']['numero']);
                            die();
                        }

                        // Se o campo User.estudante_id está vazio e há um estudante com o numero então tem que linkar
                        if ($alunonovo['Alunonovo'] && empty($usuario['User']['estudante_id'])) {
                            $this->User->id = $usuario['User']['id'];
                            if ($this->User->id) {
                                $this->User->saveField('estudante_id', $alunonovo['Alunonovo']['id']);
                            }
                        }
                        // die();
                        /*
                         * Se há um estudante e está linkado então mostra o registro
                         */
                        $this->redirect('/alunonovos/view?registro=' . $usuario['User']['numero']);
                        break;

                    // Professor
                    case 3:

                        $this->Session->write('user', $usuario['Professor']['email']);
                        $this->Session->write('categoria', $usuario['Role']['categoria']);
                        $this->Session->write('id_categoria', $usuario['User']['categoria']);
                        $this->Session->write('numero', $usuario['User']['numero']);

                        $this->Flash->success(__('Bem-vindo{a} ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user')));

                        // Verificar se cadastro do professor existe
                        $this->loadModel('Professor');
                        $this->Professor > contain();
                        $professor = $this->Professor->find('first', [
                            'conditions' => ['Professor.siape' => $usuario['User']['numero']]]);
                        // pr($professor);
                        // die("3");
                        if ($professor) {
                            $this->Session->write('user', $professor['Professor']['nome']);
                            $this->redirect('/Professors/view/' . $professor['Professor']['id']);
                        } else {
                            $this->Flash->error(__('Professor sem cadastrado. Somente a Cooredenação de Estágio cadastra professores.'));
                            $this->redirect('/users/login/');
                            // die("Professor não cadastrado");
                        }
                        // die("Fin de professor");
                        break;

                    // Supervisor
                    case 4:

                        $this->Session->write('user', $usuario['Supervisor']['email']);
                        $this->Session->write('categoria', $usuario['Role']['categoria']);
                        $this->Session->write('id_categoria', $usuario['User']['categoria']);
                        $this->Session->write('numero', $usuario['User']['numero']);

                        $this->Flash->success(__('Bem-vinda{o} ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user')));

                        // Verifica se o cadastro do supervisor existe
                        $this->loadModel('Supervisor');
                        $supervisor = $this->Supervisor->find('first', [
                            'contain' => [],
                            'conditions' => ['Supervisor.cress' => $usuario['User']['numero']]]);
                        // pr($supervisor);
                        // die();
                        if ($supervisor) {
                            $this->Session->write('user', $supervisor['Supervisor']['nome']);
                            $this->redirect('/Supervisors/view/' . $supervisor['Supervisor']['id']);
                        } else {
                            $this->Flash->error(__('Supervisor sem cadastrado. Somente a Coordenação de Estágio cadastra supervisores.'));
                            $this->redirect('/users/login/');
                        }
                        break;

                    default:
                        $this->Flash->error(__('Erro! Categoria de usuário desconhecida: ' . $this->Session->read('user')));
                        $this->redirect('/users/login/');
                        break;
                }
            } else {
                // echo "Error" . "<br>";
                // die(pr($usuario));
                $this->Flash->error(__('Login/senha errado ou usuário não cadastrado'));
                $this->redirect('/users/login/');
            }
        }
    }

    public function logout() {

        $this->Session->delete('user');
        $this->Session->delete('categoria');
        $this->Session->delete('id_categoria');
        $this->Session->delete('numero');

        $this->Session->setFlash(__('Até mais!'));
        $this->redirect($this->Auth->logout());
    }

    public function cadastro($id = NULL) {

        $recadastro = $this->request->query('recadastro');
        if ($recadastro) {
            $this->set('recadastro', $recadastro);
        }
        
        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            /*
             * Para recuperar a senha faz um novo cadastro
             */
            $usuariocadastrado = $this->User->find('first', array(
                'conditions' => array(
                    'User.categoria' => $this->data['User']['categoria'],
                    'User.email' => $this->data['User']['email'],
                    'User.numero' => $this->data['User']['numero'])
                    )
            );
            // pr($usuariocadastrado);
            // die();

            /*
             * Se está recuperando a senha
             * excluo o registro do usuer
             */
            if ($usuariocadastrado) {
                // echo "Recuperação de senha de usuário já cadastrado" . "<br>";
                // pr($usuariocadastrado);
                // pr($usuariocadastrado['User']['id']);
                if ($this->User->delete($usuariocadastrado['User']['id'])) {
                    // echo "Usuario excluido";
                    // die("delete user");
                }
                // die("delete user");
            }
            // die("usuariocadastrado");
            // Primeiro verifico se o numero ja nao esta cadastrado no user
            $numero = $this->User->find('first', [
                'conditions' => ['User.numero' => $this->data['User']['numero']]
            ]);
            // pr($numero);
            // die('numero');

            if ($numero) {
                $this->Flash->error(__("Número (DRE, CRESS ou SIAPE) já cadastrado"));
                $this->redirect("/Users/login/");
                die("Numero já cadastrado");
            }
            // die("Numero já cadastrado");
            // Segundo verifico se o email ja nao esta cadastrado no user
            $email = $this->User->find('first', [
                'conditions' => ['User.email' => $this->data['User']['email']]
                    ]
            );
            // pr($email);
            // die('email');
            if ($email) {
                $this->Flash->error(__("Email já cadastrado"));
                $this->redirect("/Users/login/");
                die("Email já cadastrado");
            }
            // die("Email já cadastrado");
            // Agora, tenho que cadastrar como alunos, professores, etc
            switch ($this->data['User']['categoria']) {
                case 2:
                    // Estudante;
                    $this->User->set($this->data);
                    // pr($this->data);
                    // die();
                    if ($this->User->save($this->data)) {
                        $this->User->id = $this->User->getLastInsertId();
                        $this->Flash->success(__('Bem-vindo! Cadastro realizado'));

                        $this->Session->write('user', strtolower($this->data['User']['email']));
                        $this->Session->write('categoria', 'estudante');
                        $this->Session->write('id_categoria', '2');
                        $this->Session->write('numero', $this->data['User']['numero']);

                        // Verifica se já está cadastrado como estudante
                        $this->loadModel('Alunonovo');
                        $alunonovo = $this->Alunonovo->find('first', [
                            'contain' => [],
                            'conditions' => ['Alunonovo.registro' => $this->data['User']['numero']]
                        ]);
                        // pr($alunonovo['Alunonovo']['id']);
                        // die();

                        if ($alunonovo) {
                            // Se o estudante já está cadastrado preencho o campo estudante_id do User
                            if ($this->User->id) {
                                $this->User->saveField('estudante_id', $alunonovo['Alunonovo']['id']);
                                $this->Session->write('user', $alunonovo['Alunonovo']['nome']);
                                // die('user_id');
                                $this->redirect('/alunonovos/view/' . $alunonovo['Alunonovo']['id']);
                            }
                        } else {
                            // echo "Cadastra alunonovo" . "<br>";
                            // die();
                            // Se nao está cadastrado vai para add alunonovo
                            $this->redirect('/alunonovos/add?registro=' . $this->data['User']['numero']);
                        }
                    } else {
                        $errors = $this->User->invalidFields();
                        // pr($errors);
                        $this->Flash->error(__('Não foi possível completar seu cadastro.'));
                        $this->redirect('/users/cadastro/');
                    }
                    $this->redirect('/users/login/');
                    break;

                case 3:
                    // Professor
                    /* Verifico se o usuario é um professor cadastrado através do SIAPE */
                    $this->loadModel('Professor');
                    $professor = $this->Professor->find('first', [
                        'contain' => [],
                        'conditions' => ['Professor.siape' => $this->data['User']['numero']]
                    ]);
                    // pr($professor);
                    // die();

                    if ($professor) {
                        $this->request->data['User']['docente_id'] = $professor['Professor']['id'];
                        // pr($this->data);
                        // die();
                        if ($this->User->save($this->data)) {
                            $this->User->id = $this->User->getLastInsertId();
                            // die(pr($this->User->getLastInsertId()));
                            $this->Flash->success(__('Cadastro realizado!'));

                            $this->Session->write('user', $professor['Professor']['nome']);
                            $this->Session->write('categoria', 'professor');
                            $this->Session->write('id_categoria', '3');
                            $this->Session->write('numero', $this->data['User']['numero']);

                            $this->redirect('/professors/view/' . $professor['Professor']['id']);
                        } else {
                            $errors = $this->User->invalidFields();
                            // pr($errors);
                            $this->Flash->error(__('Não foi possível completar seu cadastro.'));
                            $this->redirect('/users/cadastro');
                        }
                    } else {
                        $this->Flash->error(__("Somente podem criar conta os/as professores/as com o SIAPE cadastraado na Coordenação de Estágio."));
                        $this->redirect('/users/cadastro');
                        // $this->redirect('/professors/usuarioprofessor?siape=' . $this->data['User']['numero'] . "&" . 'email=' . $this->data['User']['email']);
                        die();
                    }
                    $this->redirect('/users/login');
                    break;

                case 4:

                    $this->loadModel('Supervisor');
                    $supervisor = $this->Supervisor->find('first', [
                        'contain' => [],
                        'conditions' => ['Supervisor.cress' => $this->data['User']['numero']]
                            ]
                    );

                    // O supervisor ja tem que estar cadastrado
                    if ($supervisor) {
                        $this->request->data['User']['supervisor_id'] = $supervisor['Supervisor']['id'];
                        if ($this->User->save($this->data)) {
                            $this->User->id = $this->User->getLastInsertId();
                            $this->Flash->success(__('Bem-vindo! Cadastro realizado'));

                            $this->Session->write('user', $supervisor['Supervisor']['nome']);
                            $this->Session->write('categoria', 'supervisor');
                            $this->Session->write('id_categoria', '4');
                            $this->Session->write('numero', $this->data['User']['numero']);

                            $this->redirect('/supervisors/view/' . $supervisor['Supervisor']['id']);
                        } else {
                            $errors = $this->User->invalidFields();
                            // pr($errors);
                            $this->Flash->error(__('Não foi possível completar seu cadastro.'));
                            $this->redirect('/Useres/cadastro');
                        }
                    } else {
                        $this->Flash->error(__("Somente podem criar conta os/as supervisores/as com CRESS registrados na Coordenação de Estágio."));
                        $this->redirect('/users/login/');
                    }
                    break;

                default:
                    $this->Flash->error(__('Error: Usuário não faz parte de nenhuma categoria'));
                    $this->redirect('/users/cadastro/');
                    break;
            }
            $this->redirect('/users/login/');
        } else {
            // $this->Session->setFlash(__('Não foi possível completar o cadastramento'));
            // $this->redirect('/users/login/');
        }
    }

    public function excluir($id = null) {

        $this->User->contain();
        $user = $this->User->find('first',
                ['conditions' => ['User.id' => $id]]);

        if ($user['User']['estudante_id']) {
            $estudante_id = $user['User']['estudante_id'];
        } elseif ($user['User']['supervisor_id']) {
            $supervisor_id = $user['User']['supervisor_id'];
        } elseif ($user['User']['docente_id']) {
            $docente_id = $user['User']['docente_id'];
        } else {
            $this->Flash->error(__("Não tem cadastro"));
        }

        $this->User->delete($id);
        $this->Flash->success(__('Registro excluído ' . $id));
        if (isset($estudante_id)) {
            $this->redirect('/Alunonovos/view/' . $estudante_id);
        } elseif (isset($supervisor_id)) {
            $this->redirect('/Supervisors/view/' . $supervisor_id);
        } elseif (isset($docente_id)) {
            $this->redirect('/Professors/view/' . $docente_id);
        }
    }

    public function contato() {

        // echo "Enviar email para estagio@ess.ufrj.br";
    }

    public function index($id = NULL) {

        $categoria = $this->request->query('categoria');
        // pr($categoria);

        if (is_null($categoria)) {
            $categoria = $this->Session->read('id_categoria');
        };

        /*
          switch ($categoria) {
          case '2': // Estudante
          $this->Paginator->settings = array(
          'User' => array(
          'limit' => 10,
          'order' => array('User.email'),
          'conditions' => ['User.categoria' => $categoria],
          'fields' => ['User.id', 'User.categoria', 'User.numero', 'User.email', 'Alunonovo.id', 'Alunonovo.nome', 'Alunonovo.registro', 'Role.categoria'],
          'joins' => [
          [
          'alias' => 'Alunonovo',
          'table' => 'alunosnovos',
          'type' => 'INNER',
          'conditions' => 'User.estudante_id = Alunonvo.id'
          ]
          ]
          )
          );
          break;
          case '3': // Professor
          $this->Paginator->settings = array(
          'User' => array(
          'limit' => 10,
          'order' => array('User.email'),
          'conditions' => ['User.categoria' => $categoria],
          'fields' => ['User.id', 'User.categoria', 'User.numero', 'User.email', 'Professor.id', 'Professor.nome', 'Professor.siape', 'Role.categoria'],
          'joins' => [
          [
          'alias' => 'Professor',
          'table' => 'docentes',
          'type' => 'INNER',
          'conditions' => 'User.docente_id = Professor.id'
          ]
          ]
          )
          );
          break;
          case '4': // Supervisor
          $this->Paginator->settings = array(
          'User' => array(
          'limit' => 10,
          'order' => array('User.email'),
          'conditions' => ['User.categoria' => $categoria],
          'fields' => ['User.id', 'User.categoria', 'User.numero', 'User.email', 'Supervisor.id', 'Supervisor.nome', 'Supervisor.cress', 'Role.categoria'],
          'joins' => [
          [
          'alias' => 'Supervisor',
          'table' => 'supervisores',
          'type' => 'INNER',
          'conditions' => 'User.supervisor_id = Supervisor.id'
          ]
          ]
          )
          );
          break;
          }
         */
        if ($categoria) {
            $usuario = $this->User->find('all', [
                'contain' => ['Role', 'Alunonovo', 'Professor', 'Supervisor'],
                'conditions' => ['User.categoria' => $categoria]
            ]);
        } else {
            $usuario = $this->User->find('all', [
                'contain' => ['Alunonovo', 'Professor', 'Supervisor']
            ]);
        }

        $this->Paginator->settings = array(
            'User' => array(
                'order' => array('User.email'),
                'contain' => ['Role', 'Alunonovo', 'Professor', 'Supervisor'],
                'conditions' => ['User.categoria' => $categoria],
                'fields' => ['User.id', 'User.categoria', 'User.numero', 'User.email', 'Alunonovo.id', 'Alunonovo.registro', 'Alunonovo.nome', 'Alunonovo.email', 'Professor.id', 'Professor.siape', 'Professor.nome', 'Professor.email', 'Supervisor.id', 'Supervisor.cress', 'Supervisor.nome', 'Supervisor.email', 'Role.categoria']
        ));

        $this->set('categoria', $categoria);
        $this->set('usuarios', $this->Paginator->paginate('User'));
        // $this->set('usuarios', $usuario);
    }

    public function listausuarios() {

        $parametros = $this->params['named'];
        $ordem = isset($parametros['ordem']) ? $parametros['ordem'] : 'nome';
        $direcao = isset($parametros['direcao']) ? $parametros['direcao'] : 'ascendente';
        $linhas = isset($parametros['linhas']) ? $parametros['linhas'] : 15;
        $pagina = isset($parametros['pagina']) ? $parametros['pagina'] : 1;
        $q_paginas = isset($parametros['q_paginas']) ? $parametros['q_paginas'] : NULL;
        // pr('param: ' . $pagina);
        // die();

        if (!$ordem) {
            $ordem = $this->request->query('ordem');
        }
        if (!$direcao) {
            $direcao = $this->request->query('direcao');
        }
        if (!$linhas) {
            $linhas = $this->request->query('linhas');
        }
        if (!$pagina) {
            $pagina = $this->request->query('pagina');
        }
        if (!$q_paginas) {
            $q_paginas = $this->request->query('q_paginas');
        }

        $usuarios = $this->User->find('all');
        // pr($usuarios);
        // die();

        $this->loadModel('Aluno');
        $this->loadModel('Alunonovo');
        $this->loadModel('Professor');
        $this->loadModel('Supervisor');
        $i = 1;
        foreach ($usuarios as $cadausuario) {
            // pr($cadausuario);
            $estudante = NULL;
            $nome = NULL;
            $aluno_id = NULL;
            $aluno_tipo = NULL;
            switch ($cadausuario['User']['categoria']) {
                case 1:
                    $nome = 'Administrador';
                    $aluno_tipo = 5;
                    break;
                case 2:
                    // Busco entre os estudantes em estágio
                    $estudante = $this->User->Alunonovo->find('first', array(
                        'contain' => [],
                        'conditions' => ['Alunonovo.registro' => $cadausuario['User']['numero']]));
                    // pr($estudante);
                    // die();

                    if ($estudante) {
                        $nome = $estudante['Alunonovo']['nome'];
                        $aluno_id = $estudante['Alunonovo']['id'];
                        $aluno_tipo = 0; // Estudante
                    }
                    // die();
                    break;
                case 3:

                    $professor = $this->User->Professor->find('first', array(
                        'conditions' => ['Professor.siape' => $cadausuario['User']['numero']]));
                    // pr($professor);
                    // die();
                    if ($professor) {
                        $nome = $professor['Professor']['nome'];
                    } else {
                        $nome = 'Professor não cadastrado!!';
                    }
                    $aluno_id = $professor['Professor']['id'];
                    $aluno_tipo = 3;
                    break;
                case 4:

                    $supervisor = $this->User->Supervisor->find('first', array(
                        'conditions' => ['Supervisor.cress' => $cadausuario['User']['numero']]));
                    if ($supervisor) {
                        $nome = $supervisor['Supervisor']['nome'];
                    } else {
                        $nome = "Supervisor não cadastrado!!";
                    }
                    $aluno_id = $supervisor['Supervisor']['id'];
                    $aluno_tipo = 4;
                    break;
                default:
                    $nome = 'Sem categoria!!';
                    $aluno_id = NULL;
                    $aluno_tipo = 5;
                    break;
            }
            // echo "Indice " . $i . "<br>";
            $todos[$i]['id'] = $cadausuario['User']['id'];
            $todos[$i]['aluno_tipo'] = $aluno_tipo;
            $todos[$i]['aluno_id'] = $aluno_id;
            $todos[$i]['numero'] = $cadausuario['User']['numero'];
            $todos[$i]['nome'] = $nome;
            $todos[$i]['email'] = $cadausuario['User']['email'];
            $todos[$i]['categoria'] = $cadausuario['Role']['categoria'];
            $criterio[$i] = $todos[$i][$ordem];
            $i++;
        }
        // pr($criterio);
        // pr($direcao);
        if ($direcao):
            if ($direcao == 'ascendente'):
                array_multisort($criterio, SORT_ASC, $todos);
                $direcao = 'descendente';
            elseif ($direcao == 'descendente'):
                array_multisort($criterio, SORT_DESC, $todos);
                $direcao = 'ascendente';
            else:
                $direcao = 'ascendente';
                array_multisort($criterio, SORT_ASC, $todos);
            endif;
        endif;
        // pr($direcao);

        if ($linhas == 0) { // Sem paginação
            $q_paginas = 1;
        } else {
            $registros = sizeof($todos);
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
                $c_pagina[] = array_slice($todos, $pagina_inicial, $pagina_final);
            endfor;
        }
        // pr($c_pagina[10]);
        // pr($todos);
        if ($linhas == 0):
            $this->set('listausuarios', $todos);
        else:
            $this->set('listausuarios', $c_pagina[$pagina]);
            $this->set('pagina', $pagina);
            $this->set('q_paginas', ceil($q_paginas));
        endif;
        $this->set('ordem', $ordem);
        $this->set('linhas', $linhas);
        $this->set('direcao', $direcao);

        // $this->set('listausuarios', $this->User->find('all'));
    }

    public function delete($id = NULL) {

        // pr($id);
        // die();
        $usuario = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        // pr($usuario);
        // die();
        if ($usuario) {
            if ($usuario['Alunonovo']['registro'] or $usuario['Professor']['siape'] or $usuario['Supervisor']['cress']) {
                $this->Flash->error(__('Usuário cadastrado como estudante, professor ou supervisor'));
                $this->redirect('/users/view/' . $id);
            } else {
                $this->User->delete($usuario['User']['id']);
                $this->Flash->success(__('Registro excluído ' . $id));
                $this->redirect('/users/listausuarios/');
            }
        } else {
            echo 'Usuário não cadastrado' . "<br>";
            $this->redirect('/users/listausuarios/');
        }
    }

    public function view($id = NULL) {

        $usuario = $this->User->find('first', [
            'conditions' => ['User.id' => $id]
        ]);
        // pr($id);
        // pr($usuario);
        // die();
        $this->set('usuario', $usuario);
    }

    public function edit($id = NULL) {

        $this->User->id = $id;

        if (empty($this->data)) {
            $this->data = $this->User->read();
        } else {
            // pr($this->data);
            // die();
            $this->User->save($this->data);
            // print_r($this->data);
            $this->Flash->success(__("Atualizado"));
            $this->redirect('/users/view/' . $this->data['User']['id']);
        }
    }

    public function busca_email() {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $usuarios = $this->User->find('first', [
                'conditions' => ['User.email' => $this->data['User']['email']]
            ]);
            // pr($alunos);
            // die("Sem registro");
            if (empty($usuarios)) {
                $this->Flash->error(__("Não foram encontrados registros de email"));
                $this->redirect('/Users/busca_email');
            } else {
                // pr($usuarios);
                switch ($usuarios['Role']['id']) {
                    case 2:
                        $this->loadModel('Aluno');
                        $estudante = $this->Aluno->find('first', [
                            'conditions' => ['Aluno.registro' => $usuarios['User']['numero']]
                        ]);
                        $this->set('segmento', $estudante);
                        break;
                    case 3:
                        $this->loadModel('Professor');
                        $professor = $this->Professor->find('first', [
                            'conditions' => ['Professor.siape' => $usuarios['User']['numero']]
                        ]);
                        $this->set('segmento', $professor);
                        break;
                    case 4:
                        $this->loadModel('Supervisor');
                        $supervisor = $this->Supervisor->find('first', [
                            'conditions' => ['Supervisor.cress' => $usuarios['User']['numero']]
                        ]);
                        $this->set('segmento', $supervisor);
                        break;
                }
                $this->set('usuarios', $usuarios);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function busca_numero() {

        // pr($this->data);
        if (!empty($this->data['User']['numero'])) {
            $usuarios = $this->User->find('first', [
                'conditions' => ['User.numero' => $this->data['User']['numero']]
            ]);
            // pr($usuarios);
            // die('usuarios');
            if (empty($usuarios)) {
                $this->Flash->error(__("Não foram encontrados registros do(a) usuario(a)"));
                $this->redirect('/users/busca_numero');
            }
            switch ($usuarios['User']['categoria']) {
                case 2:
                    $this->loadModel('Alunonovo');
                    $alunonovos = $this->User->Alunonovo->find('first', [
                        'conditions' => ['Alunonovo.registro' => $this->data['User']['numero']]
                    ]);
                    // pr($alunonovos);
                    if (empty($alunonovos)) {
                        $this->Flash->error(__("Não foram encontrados registros da(o) estudante"));
                        $this->redirect('/users/busca_numero');
                    } else {
                        $this->redirect('/users/view/' . $usuarios['User']['id']);
                    }
                    break;

                case 3:
                    $this->loadModel('Professor');
                    $professor = $this->User->Professor->find('first', [
                        'conditions' => ['Professor.siape' => $this->data['User']['numero']]
                    ]);
                    if (empty($professor)) {
                        $this->Flash->error(__("Não foram encontrdos registro da(o) professor(a)"));
                        $this->redirect('/users/busca_numero');
                        die();
                    } else {
                        $this->redirect('/users/view/' . $usuarios['User']['id']);
                        die();
                    }
                    break;

                case 4:
                    $this->loadModel('Supervisor');
                    $supervisor = $this->User->Supervisor->find('first', [
                        'conditions' => ['Supervisor.cress' => $this->data['User']['numero']]
                    ]);
                    if (empty($supervisor)) {
                        $this->Flash->error(__("Não foram encontrdos registro da(o) supervisor(a)"));
                        $this->redirect('/users/busca_numero');
                        die();
                    } else {
                        $this->redirect('/users/view/' . $usuarios['User']['id']);
                        die();
                    }
                    break;
                default:
                    $this->redirect('/Users/view/' . $usuarios['User']['id']);
            }
        }
    }

    public function alternarusuario() {

        // pr($this->data);
        // die();
        $categoria = $this->Session->read('id_categoria');
        // pr($categoria);
        if ($categoria == 1):
            // echo "Administrador";
            if (empty($this->data)) {
                $this->data = $this->User->read();
            } else {
                switch ($this->data['User']['categoria']) {
                    case 2:
                        // pr($this->data);
                        // die();
                        $aluno_id = $this->User->find('first', [
                            'contain' => ['Alunonovo'],
                            'conditions' => ['User.numero' => $this->data['User']['numero']]
                        ]);
                        // pr($aluno_id['Alunonovo']);
                        // die();
                        if ($aluno_id) {
                            $this->Session->write('categoria', 'estudante');
                            $this->Session->write('id_categoria', 2);
                            $this->Session->write('user', $aluno_id['Alunonovo']['email']);
                            $this->Session->write('numero', $this->data['User']['numero']);

                            $this->loadModel('Estagiario');
                            $this->Estagiario->contain();
                            $estagiario = $this->Estagiario->find('first', [
                                'conditions' => ['Estagiario.registro' => $this->data['User']['numero']]
                            ]);
                            // pr($estagiario);
                            // die();
                            if (isset($estagiario) && !empty($estagiario)) {
                                $this->Session->write('estagiario', '1');
                                // pr($this->Session->read('estagiario'));
                            } else {
                                $this->Session->write('estagiario', '0');
                                // pr($this->Session->read('estagiario'));
                            }
                            // die();
                            $this->redirect('/murals/index');
                            // $this->redirect('/alunos/view/' . $aluno_id['Aluno']['id']);
                        } else {
                            $this->Flash->error(__("Sem registros da(o) estudante(a)"));
                            $this->redirect('/users/alternarusuario');
                        }
                        break;
                    case 3:
                        $this->loadModel('Professor');
                        $professor = $this->Professor->find('first', [
                            'conditions' => ['Professor.siape' => $this->data['User']['numero']]
                        ]);
                        if ($professor) {
                            $this->Session->write('categoria', 'professor/a');
                            $this->Session->write('id_categoria', 3);
                            $this->Session->write('user', $professor['Professor']['email']);
                            $this->Session->write('numero', $this->data['User']['numero']);
                            $this->redirect('/professors/view/' . $professor['Professor']['id']);
                            die();
                        } else {
                            $this->Flash->error(__("Não foram encontrdos registro da(o) professor(a)"));
                            $this->redirect('/users/alternarusuario');
                            die();
                        }
                        break;
                    case 4:
                        $this->loadModel('Supervisor');
                        $supervisor = $this->Supervisor->find('first', [
                            'conditions' => ['Supervisor.cress' => $this->data['User']['numero']]
                        ]);
                        if ($supervisor) {
                            $this->Session->write('categoria', 'Supervisor');
                            $this->Session->write('id_categoria', 4);
                            $this->Session->write('user', $supervisor['Supervisor']['email']);
                            $this->Session->write('numero', $this->data['User']['numero']);
                            $this->redirect('/supervisors/view/' . $supervisor['Supervisor']['id']);
                            die();
                        } else {
                            $this->Flash->error(__("Não foram encontrdos registro da(o) supervisor(a)"));
                            $this->redirect('/users/alternarusuario');
                            die();
                        }
                        break;
                }
                //  pr($this->data);
                // $this->Session->write();
            }
        endif;
    }

    public function padroniza() {

        $emails = $this->User->find('all', array('fields' => array('id', 'email', 'timestamp')));
        // pr($emails);
        foreach ($emails as $c_email):
            if ($c_email['User']['timestamp'] === '0000-00-00 00:00:00'):
                // pr($c_email['User']['timestamp']);
                $this->User->query("UPDATE users set timestamp = '2000-01-01 00:00:00' where id = " . $c_email['User']['id']);
            endif;
            // pr(strtolower($c_email['User']['email']));
            // $this->User->query("UPDATE users set email = '" . strtolower($c_email['User']['email'] . "' where id = ". $c_email['User']['id']));
        endforeach;
        die();
    }

    public function preencher() {

        $user = $this->User->find('all');
        foreach ($user as $c_user) {
            // pr($c_user['User']['categoria']);
            // Estudantes
            if ($c_user['User']['categoria'] == 2) {
                // pr($c_user['User']['numero']);
                $this->loadModel('Alunonovo');
                $estudante = $this->Alunonovo->find('first', [
                    'conditions' => ['Alunonovo.registro' => $c_user['User']['numero']]
                ]);
                // pr($estudante);
                // die();
                $c_user['User']['estudante_id'] = $estudante['Alunonovo']['id'];
                if ($this->User->save($c_user)) {
                    echo "Atualizado";
                    $this->Flash->success(__('Registro atualizado!'));
                } else {
                    echo "Error!";
                    $this->Flash->error(__('Registro NÃO atualizado!'));
                }
            }
            // Professores
            if ($c_user['User']['categoria'] == 3) {
                // pr($c_user['User']['numero']);
                $this->loadModel('Professor');
                $professor = $this->Professor->find('first', [
                    'conditions' => ['Professor.siape' => $c_user['User']['numero']]
                ]);
                // pr($professor);
                // die();
                $c_user['User']['docente_id'] = $professor['Professor']['id'];
                if ($this->User->save($c_user)) {
                    echo "Atualizado";
                    $this->Flash->success(__('Registro atualizado!'));
                } else {
                    echo "Error!";
                    $this->Flash->error(__('Registro NÃO atualizado!'));
                }
            }
            // Supervisores
            if ($c_user['User']['categoria'] == 4) {
                // pr($c_user['User']['numero']);
                $this->loadModel('Supervisor');
                $supervisor = $this->Supervisor->find('first', [
                    'conditions' => ['Supervisor.cress' => $c_user['User']['numero']]
                ]);
                // pr($supervisor);
                // die();
                $c_user['User']['supervisor_id'] = $supervisor['Supervisor']['id'];
                if ($this->User->save($c_user)) {
                    echo "Atualizado";
                    echo $this->Flash->success(__('Registro atualizado!'));
                } else {
                    echo "Error!";
                    echo $this->Flash->error(__('Registro NÃO atualizado!'));
                }
            }
            // die();
        }
        die();
    }

}

?>
