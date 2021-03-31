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
        $this->Session->delete('numero');
        $this->Session->delete('id_categoria');
        $this->Session->delete('categoria');

        // pr($this->data);
        // die();
        if (!empty($this->data)) {

            $usuario = $this->User->find('first', array(
                'conditions' => array('User.email' => $this->data['User']['email'])));

            // pr($usuario);
            // die();
            if ($usuario['User']['password'] == sha1($this->data['User']['password'])) {
                // die(pr($usuario));
                $this->Session->write('user', $usuario['User']['email']);
                $this->Session->write('numero', $usuario['User']['numero']);
                $this->Session->write('id_categoria', $usuario['Role']['id']);
                $this->Session->write('categoria', $usuario['Role']['categoria']);
                // die();
                switch ($usuario['User']['categoria']) {
                    case 1: // Administrador
                        $this->Flash->success(__('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user')));
                        $this->redirect('/estagiarios/index/');
                        break;

                    // Categoria 2 eh estudante
                    case 2:
                        $this->Flash->success('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        $this->loadModel('Aluno');
                        $aluno_id = $this->Aluno->findByRegistro($usuario['User']['numero']);
                        if ($aluno_id) {
                            $this->Session->write('menu_aluno', 'estagiario');
                            $this->Session->write('menu_id_aluno', $aluno_id['Aluno']['id']);
                            $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                        } else {
                            $this->loadModel('Alunonovo');
                            $aluno_id = $this->Alunonovo->findByRegistro($usuario['User']['numero']);
                            if ($aluno_id) {
                                $this->Session->write('menu_aluno', 'alunonovo');
                                $this->Session->write('menu_id_aluno', $aluno_id['Alunonovo']['id']);
                                $this->redirect('/Alunonovos/view/' . $aluno_id['Alunonovo']['id']);
                            } else {
                                $this->Session->write('menu_aluno', 'semcadastro');
                                $this->Session->write('menu_id_aluno', 0);
                                $this->Flash->error(__('Estudante novo sem cadastro'));
                                // Tem que impedir que estudante nao cadastro possa continuar
                                $this->redirect('/Alunonovos/add/');
                            }
                        }
                        break;

                    // Professor
                    case 3:
                        $this->Flash->success(__('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user')));
                        // Verificar se cadastro do professor existe
                        $this->loadModel('Professor');
                        $professor = $this->Professor->findBySiape($usuario['User']['numero']);
                        // pr($professor);
                        // die("3");
                        if ($professor) {
                            $this->redirect('/Professors/view/' . $professor['Professor']['id']);
                        } else {
                            $this->Flash->error(__('Professor sem cadastrado'));
                            $this->redirect('/users/login/');
                            // die("Professor não cadastrado");
                        }
                        // die("Fin de professor");
                        break;

                    // Supervisor
                    case 4:
                        $this->Flash->success(__('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user')));
                        // Verifica se o cadastro do supervisor existe
                        $this->loadModel('Supervisor');
                        $supervisor = $this->Supervisor->findByCress($usuario['User']['numero']);
                        // pr($supervisor);
                        // die();
                        if ($supervisor) {
                            $this->Session->write("menu_id_supervisor", $supervisor['Supervisor']['id']);
                            $this->redirect('/Supervisors/view/' . $supervisor['Supervisor']['id']);
                        } else {
                            $this->Flash->error(__('Supervisor sem cadastrado: entrar em contato com a Coordenação de Estágio & Extensão'));
                            $this->redirect('/Supervisors/add/');
                        }
                        break;

                    default:
                        $this->Flash->error(__('Erro! Categoria de usuário desconhecida: ' . $this->Session->read('user')));
                        $this->redirect('/users/login/');
                        break;
                }
            } else {
                // die(pr($usuario));
                $this->Flash->error(__('Login/senha errado ou usuário não cadastrado'));
                $this->redirect('/users/login/');
            }
        }
    }

    public function logout() {

        $this->Session->delete('user');
        $this->Session->delete('numero');
        $this->Session->delete('categoria');
        $this->Session->delete('id_categoria');
        $this->Session->delete('menu_aluno');
        $this->Session->delete('menu_id_aluno');
        $this->Session->setFlash('Até mais!');
        $this->redirect($this->Auth->logout());
    }

    public function cadastro() {

        // pr($this->data);
        if (!empty($this->data)) {
            // pr($this->data);

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

            /*
             * Se está recuperando a senha
             * excluo o registro do usuer e do aro
             */
            if ($usuariocadastrado) {
                echo "Recuperação de senha de usuário já cadastrado";
                // pr($usuariocadastrado);
                // pr($usuariocadastrado['User']['id']);
                if ($this->User->delete($usuariocadastrado['User']['id'])) {
                    echo "Usuario excluido";
                    // die("delete user");
                }
                // die("delete user");
            }
            // die("usuariocadastrado");
            // Primeiro verifico se o registro ja nao esta cadastrado no user
            $numero = $this->User->findByNumero($this->data['User']['numero']);
            // pr($numero);
            // die('numero');

            if ($numero) {
                // $numero_user = $this->User->findByNumero($this->data['User']['numero']);
                // pr($email_user);
                // die();
                $this->Flash->error(__("Número (DRE, CRESS ou SIAPE) já cadastrado"));
                $this->redirect("/Users/login/");
                die("Numero já cadastrado");
            }
            // die("Numero já cadastrado");
            // Segundo verifico se o email ja nao esta cadastrado no user
            $email = $this->User->findByEmail($this->data['User']['email']);
            // pr($email);
            // die('email');

            if ($email) {
                // $email_user = $this->User->findByEmail($this->data['User']['email']);
                // pr($email_user);
                // die();
                $this->Flash->error(__("Email já cadastrado"));
                $this->redirect("/Users/login/");
                die("Email já cadastrado");
            }
            // die("Email já cadastrado");
            // Agora, tenho que cadastrar como alunos, professores, etc
            switch ($this->data['User']['categoria']) {
                case 2:
                    $grupo = 'alunos';
                    $this->loadModel('Aluno');
                    $aluno = $this->Aluno->findByRegistro($this->data['User']['numero']);
                    // pr($aluno);
                    //die(pr($this->data['User']['numero']));
                    if ($aluno) {
                        $situacao = 1; // Estudante estagiário
                        $nome = ucwords($aluno['Aluno']['nome']);
                        // $this->Session->write('menu_aluno', 'estagiario');
                        // $this->Session->write('menu_id_aluno', $aluno['Aluno']['id']);
                        // echo "Estudante estagiário ";
                    } else {
                        // echo "Estudante novo? ";
                        // die("Estudante novo?");
                        $this->loadModel('Alunonovo');
                        $alunonovo = $this->Alunonovo->findByRegistro($this->data['User']['numero']);
                        // die(pr($alunonovo));
                        if ($alunonovo) {
                            $situacao = 2; // Estudante novo que busca estágio
                            $nome = ucwords($aluno['Alunonovo']['nome']);
                            // $this->Session->write('menu_aluno', 'alunonovo');
                            // $this->Session->write('menu_id_aluno', $alunonovo['Alunonovo']['id']);
                            echo "Estudante novo ja cadastrado";
                        } else {
                            // echo "Estudante novo não cadastrado";
                            // die("Estudante novo não cadastrado");
                            $situacao = 3; // Estudante novo
                            // $this->Session->write('menu_aluno', 'semcadastro');
                            // Para ir para alunonovos e poder voltar
                            $this->Session->write('cadastro', strtolower($this->data['User']['email']));
                        }
                    }

                    $this->User->set($this->data);

                    if ($this->User->validates()) {
                        if ($this->User->save($this->data)) {
                            $this->Flash->success(__('Bem-vindo! Cadastro realizado'));
                            $this->Session->write('categoria', 'estudante');
                            $this->Session->write('id_categoria', '2');
                            $this->Session->write('user', strtolower($this->data['User']['email']));
                            $this->Session->write('numero', $this->data['User']['numero']);
                        }
                    } else {
                        // $errors = $this->User->invalidFields();
                        // pr($errors);
                        // $this->Session->setFlash(implode(', ', $errors));
                        $this->Flash->error(__('Não foi possível completar seu cadastro.'));
                        $this->redirect('/users/cadastro/');
                    }

                    break;

                case 3:
                    $grupo = 'professores';
                    /* Primeiro cadastro */
                    $this->User->save($this->data);
                    $this->Flash->success(__('Cadastro realizado!'));
                    $this->Session->write('categoria', 'professor');
                    $this->Session->write('id_categoria', '3');
                    $this->Session->write('user', strtolower($this->data['User']['email']));
                    $this->Session->write('numero', $this->data['User']['numero']);

                    /* Agora asocio o usuario ao professor através do SIAPE */
                    $this->loadModel('Professor');
                    $professor = $this->Professor->findBySiape($this->data['User']['numero']);
                    if (empty($professor)) {
                        $this->Flash->success(__("Cadastrar o SIAPE do usuário no professor"));
                        $this->redirect('/professors/usuarioprofessor?siape=' . $this->data['User']['numero'] . "&" . 'email=' . $this->data['User']['email']);
                        die();
                    } else {
                        $this->redirect('/professors/view?siape=' . $this->data['User']['numero']);
                        die();
                    }
                    break;

                case 4:
                    $grupo = 'supervisores';
                    $this->loadModel('Supervisor');
                    $supervisor = $this->Supervisor->findByCress($this->data['User']['numero']);

                    // O supervisor ja tem que estar cadastrado
                    if ($supervisor) {
                        $this->User->save($this->data);
                        $this->Flash->success(__('Bem-vindo! Cadastro realizado'));
                        $this->Session->write('user', strtolower($this->data['User']['email']));
                        $this->Session->write('numero', $this->data['User']['numero']);
                        // $this->redirect('/Supervisors/view/' . $supervisor['Supervisor']['id']);
                    } else {
                        $this->Flash->success(__("Supervisor ainda não cadastrado. Somente podem criar conta os supervisores com CRESS registrados na Coordenação de Estágio e Extensão"));
                        $this->redirect('/users/login/');
                    }
                    break;

                default:
                    $this->Flash->error(__('Error: Usuário não faz parte de nenhuma categoria'));
                    $this->redirect('/users/cadastro/');
                    break;
            }

            // Redirecionamentos
            switch ($this->data['User']['categoria']) {
                // Encaminhar para aluno ou alunonovo view
                case 2: // Aluno
                    // pr($usuario['User']['numero']);
                    // pr($usuario['User']['categoria']);
                    $this->loadModel('Aluno');
                    $aluno_id = $this->Aluno->findByRegistro($this->data['User']['numero']);
                    if ($aluno_id) {
                        $this->redirect('/Alunos/view/' . $aluno_id['Aluno']['id']);
                    } else {
                        $this->loadModel('Alunonovo');
                        $aluno_id = $this->Alunonovo->findByRegistro($this->data['User']['numero']);
                        if ($aluno_id) {
                            $this->redirect('/Alunonovos/view/' . $aluno_id['Alunonovo']['id']);
                        } else {
                            $this->redirect('/Alunonovos/add/');
                        }
                    }
                    break;

                case 3: // Professor
                    $this->loadModel('Professor');
                    $professor_id = $this->Professor->findBySiape($this->data['User']['numero']);
                    $this->redirect('/Professors/view/' . $professor_id['Professor']['id']);
                    break;

                case 4: // Supervisor
                    $this->loadModel('Supervisor');
                    $supervisor_id = $this->Supervisor->findByCress($this->data['User']['numero']);
                    $this->Session->write("menu_id_supervisor", $supervisor['Supervisor']['id']);
                    $this->redirect('/Supervisors/view/' . $supervisor_id['Supervisor']['id']);
                    break;
            }

            $this->redirect('/murals/index/');
        } else {
            // $this->request->data['User']['password'] = '';
            // $this->Session->setFlash('Não foi possível completar o cadastramento');
        }
    }

    public function contato() {

        // echo "Enviar email para estagio@ess.ufrj.br";
    }

    public function index($id = NULL) {

        $categoria = $this->request->query('categoria');
        // pr($categoria);

        if (is_null($categoria)) {
            $categoria = $this->Session->read('categoriadeusuario');
        };

        switch ($categoria) {
            case '2': // Estudante
                $this->Paginator->settings = array(
                    'User' => array(
                        'limit' => 10,
                        'order' => array('User.email'),
                        'conditions' => ['User.categoria' => $categoria],
                        'fields' => ['User.id', 'User.categoria', 'User.numero', 'User.email', 'Estudante.id', 'Estudante.nome', 'Estudante.registro', 'Role.categoria'],
                        'joins' => [
                            [
                                'alias' => 'Estudante',
                                'table' => 'alunosnovos',
                                'type' => 'INNER',
                                'conditions' => 'User.numero = Estudante.registro'
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
                                'conditions' => 'User.numero = Professor.siape'
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
                                'conditions' => 'User.numero = Supervisor.cress'
                            ]
                        ]
                    )
                );
                break;
        }
        $this->Session->write('categoriadeusuario', $categoria);

        $this->set('categoria', $categoria);
        $this->set('usuarios', $this->Paginator->paginate('User'));
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
                    $estudante = $this->Aluno->find('first', array(
                        'conditions' => 'Aluno.registro=' . $cadausuario['User']['numero']));

                    if ($estudante) {
                        $nome = $estudante['Aluno']['nome'];
                        $aluno_id = $estudante['Aluno']['id'];
                        $aluno_tipo = 0; // Aluno estagiario
                    } else {
                        // Se não está entre os estudantes em estágio busco entre os novos
                        // $estudantenovo = NULL;
                        $estudantenovo = $this->Alunonovo->find('first', array(
                            'conditions' => 'Alunonovo.registro=' . $cadausuario['User']['numero']));
                        if ($estudantenovo) {
                            $nome = $estudantenovo['Alunonovo']['nome'];
                            $aluno_id = $estudantenovo['Alunonovo']['id'];
                            $aluno_tipo = 1; // Aluno novo
                        } else {
                            // Se não está entre os novos então é um usuario nao cadastrado
                            $nome = "Usuário estudante sem cadastro";
                            $aluno_id = NULL;
                            $aluno_tipo = 2; // Usuario estudante nao cadastrado
                        }
                    }
                    break;
                case 3:
                    $professor = $this->Professor->find('first', array(
                        'conditions' => 'Professor.siape=' . $cadausuario['User']['numero']));
                    if ($professor) {
                        $nome = $professor['Professor']['nome'];
                    } else {
                        $nome = 'Professor não cadastrado!!';
                    }
                    $aluno_id = $professor['Professor']['id'];
                    $aluno_tipo = 3;
                    break;
                case 4:
                    $supervisor = $this->Supervisor->find('first', array(
                        'conditions' => 'Supervisor.cress=' . $cadausuario['User']['numero']));
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
        $usuario_id = $this->User->find('first', array('conditions' => array('User.numero' => $id)));
        // pr($usuario_id);
        // die();

        $this->loadModel('Aluno');
        $aluno = $this->Aluno->find('first', array('conditions' => array('Aluno.registro' => $id)));
        $this->loadModel('Alunonovo');
        $alunonovo = $this->Alunonovo->find('first', array('conditions' => array('Alunonovo.registro' => $id)));
        $this->loadModel('Professor');
        $professor = $this->Professor->find('first', array('conditions' => array('Professor.siape' => $id)));
        $this->loadModel('Supervisor');
        $supervisor = $this->Supervisor->find('first', array('conditions' => array('Supervisor.cress' => $id)));

        if ($aluno or $alunonovo or $professor or $supervisor) {
            $this->Session->setFlash('Usuário existe como aluno, alunonovo, professor ou supervisor');
            $this->redirect('/users/listausuarios');
        } else {
            $this->User->delete($usuario_id['User']['id']);
            $this->Flash->success(__('Registro excluído'));
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

        if ($usuario['Role']['id'] == '2') {
            // echo "Estudante";
            $this->loadModel("Aluno");
            $aluno = $this->Aluno->find('first', array(
                'conditions' => array('Aluno.registro' => $usuario['User']['numero'])
            ));
            // pr($aluno);
            if (!$aluno) {
                $this->Flash->error(__('Estudante sem estágio'));
                $this->loadModel("Alunonovo");
                $alunonovo = $this->Alunonovo->find('first', array(
                    'conditions' => array('Alunonovo.registro' => $usuario['User']['numero'])
                ));
                // pr($alunonovo);
            }

            if (isset($aluno) && !(empty($aluno))):
            // pr($aluno);
            elseif (isset($alunonovo) && !(empty($alunonovo))):
            // pr($alunonovo);
            endif;
            // die();
        } elseif ($usuario['Role']['id'] == '3') {
            // echo "Professor";
            $this->loadModel('Professor');
            $professor = $this->Professor->find('first', array(
                'conditions' => array('Professor.siape' => $id)
            ));
        } elseif ($usuario['Role']['id'] == '4') {
            // echo "Supervisor";
            $this->loadModel('Supervisor');
            $supervisor = $this->Supervisor->find('first', array(
                'conditions' => array('Supervisor.cress' => $id)
            ));
        }

        $this->set('usuario', $usuario);
        if (isset($aluno) && !(empty($aluno))):
            $this->set('aluno', $aluno);
        elseif (isset($alunonovo) && !(empty($alunonovo))):
            $this->set('alunonovo', $alunonovo);
        elseif (isset($professor) && !(empty($professor))):
            $this->set('professor', $professor);
        elseif (isset($supervisor) && !(empty($supervisor))):
            $this->set('supervisor', $supervisor);
        endif;
    }

    public function edit($id = NULL) {

        $this->User->id = $id;

        if (empty($this->data)) {
            $this->data = $this->User->read();
        } else {
            // pr($this->data);
            $this->User->save($this->data);
            // print_r($this->data);
            $this->Flash->success(__("Atualizado"));
            $this->redirect('/users/view/' . $this->data['User']['numero']);
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
                case '2':
                    $this->loadModel('Alunonovo');
                    $alunonovos = $this->Alunonovo->find('first', [
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

                case '3':
                    $this->loadModel('Professor');
                    $professor = $this->Professor->find('first', [
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

                case '4':
                    $this->loadModel('Supervisor');
                    $supervisor = $this->Supervisor->find('first', [
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
        if ($categoria == '1'):
            // echo "Administrador";
            if (empty($this->data)) {
                $this->data = $this->User->read();
            } else {
                switch ($this->data['User']['categoria']) {
                    case 2:
                        // pr($this->data);
                        // die();
                        // $this->Session->setFlash('Bem-vindo ' . $usuario['Role']['categoria'] . ': ' . $this->Session->read('user'));
                        $this->loadModel('Aluno');
                        $aluno_id = $this->Aluno->findByRegistro($this->data['User']['numero']);
                        // pr($aluno_id);
                        // die();
                        if ($aluno_id) {
                            $this->Session->write('id_categoria', 2);
                            $this->Session->write('numero', $this->data['User']['numero']);
                            // die();
                            $this->redirect('/murals/index');
                            // $this->redirect('/alunos/view/' . $aluno_id['Aluno']['id']);
                        } else {
                            $this->loadModel('Alunonovo');
                            $aluno_id = $this->Alunonovo->findByRegistro($this->data['User']['numero']);
                            if ($aluno_id) {
                                $this->Session->write('id_categoria', 2);
                                $this->Session->write('numero', $this->data['User']['numero']);
                                $this->redirect('/Alunonovos/view/' . $aluno_id['Alunonovo']['id']);
                            } else {
                                $this->Session->write('menu_aluno', 'semcadastro');
                                $this->Session->write('menu_id_aluno', 0);
                                // $this->Session->setFlash('Estudante novo sem cadastro');
                                // Tem que impedir que estudante nao cadastro possa continuar
                                $this->redirect('/Alunonovos/add/');
                            }
                        }
                        break;
                    case 3:
                        $this->loadModel('Professor');
                        $professor = $this->Professor->find('first', [
                            'conditions' => ['Professor.siape' => $this->data['User']['numero']]
                        ]);
                        if (empty($professor)) {
                            $this->Flash->error(__("Não foram encontrdos registro da(o) professor(a)"));
                            $this->redirect('/users/alternausuario');
                            die();
                        } else {
                            $this->Session->write('id_categoria', 3);
                            $this->Session->write('numero', $this->data['User']['numero']);
                            $this->redirect('/professors/view/' . $professor['Professor']['id']);
                            die();
                        }
                        break;
                    case 4:
                        $this->loadModel('Supervisor');
                        $supervisor = $this->Supervisor->find('first', [
                            'conditions' => ['Supervisor.cress' => $this->data['User']['numero']]
                        ]);
                        if (empty($supervisor)) {
                            $this->Flash->error(__("Não foram encontrdos registro da(o) supervisor(a)"));
                            $this->redirect('/users/alternarusuario');
                            die();
                        } else {
                            $this->Session->write('id_categoria', 4);
                            $this->Session->write('numero', $this->data['User']['numero']);
                            $this->redirect('/supervisors/view/' . $supervisor['Supervisor']['id']);
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

}

?>
