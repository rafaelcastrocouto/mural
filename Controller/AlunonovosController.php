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
    public $components = array('Auth', 'Flash', 'Paginator');
    public $paginate = array(
        'limit' => 10
    );

    public function beforeFilter() {

        parent::beforeFilter();
        // Para cadastrar usuarios do sistema precisso abrir este metodo

        $this->Auth->allow('add');

        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash('Administrador');
            // Estudantes podem somente fazer inscricao
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('add', 'edit', 'index', 'view');
            // $this->Session->setFlash('Estudante');
            // die();
            // Professores podem atualizar murais
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('edit', 'index', 'view');
            // $this->Session->setFlash('Professor');
            // No futuro os supervisores poderao lançar murals
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('add', 'edit', 'index', 'view');
            // $this->Session->setFlash('Supervisor');
            // Todos
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->Paginator->settings = [
            'Alunonovo' => [
                'order' => ['Alunonovo.nome'],
                'limit' => 10
            ]
        ];

        $this->set('alunonovo', $this->Paginator->paginate('Alunonovo'));
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso
     */

    public function add($id = NULL) {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        /* alunonovos/add?dre=100100100 */
        if (!$registro) {
            $registro = $this->request->query('registro');
        }
        // pr($registro);
        // die('registro');
        $this->set('registro', $registro);
        // pr($this->data);
        // die();
        if ($this->Alunonovo->save($this->data)) {
            // Capturo o id da instituicao (se foi chamada desde inscriacao add)
            $inscricao_selecao_estagio = $this->Session->read('id_instituicao');

            // Capturo se foi chamado desde a solicitacao do termo
            $registro_termo = $this->Session->read('termo');
            // Acho que posso apagar aqui porque nao vai ser chamado novamente
            $this->Session->delete('termo');

            // Vejo se foi chamado desde users/cadastro. Acho que já não tem nenhuma função
            $cadastro = $this->Session->read('cadastro');
            $this->Session->write('user', $this->data['Alunonovo']['nome']);

            $nome = $this->data['Alunonovo']['nome'];
            $this->Flash->success(__("Cadastro realizado: " . $nome));

            /* Inserir o estudante_id na tabela User */
            $this->loadModel('User');
            $user = $this->User->find('first', ([
                'conditions' => ['User.numero' => $this->data['Alunonovo']['registro']]
            ]));
            // Se há um user cadastrado, então atualiza com o estudante_id
            if ($user) {
                $this->User->id = $user['User']['id'];
                if ($this->User->id) {
                    $this->User->saveField('estudante_id', $this->Alunonovo->getLastInsertId());
                    $this->Flash->success(__("Atualizada tabela User: " . $registro));
                }
            }

            if ($inscricao_selecao_estagio) {
                $this->redirect("/Inscricaos/inscricao?registro=" . $registro);
            } elseif ($registro_termo) {
                $this->redirect("/Inscricaos/termocompromisso?registro=" . $registro_termo);
                die("Redireciona para concluir solicitacao de termo de compromisso");
            } elseif ($cadastro) {
                $this->Session->delete('cadastro');
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                $this->redirect("/Alunonovos/view/" . $id_alunonovo);
            } else {
                $id_alunonovo = $this->Alunonovo->getLastInsertId();
                $this->Flash->success(__('Dados inseridos'));
                $this->redirect("/Alunonovos/view/" . $id_alunonovo);
            }
        }
    }

    /*
     * Além de ser chamada por ela propria
     * esta funcao eh chamada desde inscricao para selecao de estagio
     * e tambem desde termo de compromisso
     */

    /*
     * id eh o id do alunonovo
     * registro vem como parâmetro
     */

    public function edit($id = NULL) {

        // pr($id);
        // pr($this->data);
        // die();
        // Somente o administrador e o próprio podem editar
        $id_categoria = $this->Session->read('id_categoria');
        if ($id_categoria != 1):
            if ($this->Session->read('numero')) {
                $verifica = $this->Alunonovo->findByRegistro($this->Session->read('numero'));
                if ($id != $verifica['Alunonovo']['id']) {
                    $this->Flash->error(__("Acesso não autorizado"));
                    $this->redirect("/Murals/index");
                    die("Não autorizado");
                }
            }
        endif;

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query("registro");
        }
        // pr($registro);
        // die();

        /* Calculo o id a partir do registro */
        if ($registro) {
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro]
            ]);
            if ($alunonovo_id) {
                $id = $alunonovo_id['Alunonovo']['id'];
            } else {
                $this->Flash->error(__("Registro do estudante inexistente"));
                $this->redirect('/alunonovos/index');
                die();
            }
        }
        $this->Alunonovo->id = $id;
        // pr($id);
        // pr($this->data);
        // die();
        // $this->set('meses', $this->meses());
        if (empty($this->data)) {
            // die('read this->data');
            $this->data = $this->Alunonovo->read();
        } else {
            if ($this->Alunonovo->save($this->data)) {
                $this->Flash->success(__("Atualizado!"));

                // Capturo o id da instituicao (se foi chamada desde inscriacao add)
                $inscricao_selecao_estagio = $this->Session->read('id_instituicao');
                // die();
                // Ainda nao posso apagar
                // $this->Session->delete('id_instituicao');
                // Capturo se foi chamado desde a solicitacao do termo
                $registro_termo = $this->Session->read('termo');
                $this->Session->delete('termo');
                if ($inscricao_selecao_estagio) {
                    // Faz inscricao para selecao de estagio
                    $this->Flash->success(__("Inscricao para selecao de estagio"));
                    $this->redirect('/Inscricaos/inscricao?registro=' . $this->data['Alunonovo']['registro']);
                } elseif (!empty($registro_termo)) {
                    // Solicita termo de compromisso
                    $this->Flash->success(__("Solicitacao de termo de compromisso"));
                    // $this->redirect('/Inscricaos/termocompromisso/' . $registro_termo);
                } else {
                    // Simplesmente atualiza e mostra o resultado
                    $this->redirect('/Alunonovos/view/' . $id);
                }
            }
        }
    }

    public function view($id = NULL) {

        // pr($id);
        // die();
        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query("registro");
        }
        // pr($registro);
        // die();
        /* Calculo o id a partir do registro */
        if ($registro) {
            $alunonovo_id = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $registro]
            ]);
            if ($alunonovo_id) {
                $id = $alunonovo_id['Alunonovo']['id'];
            } else {
                $this->Flash->error(__("Registro do estudante inexistente"));
                $this->redirect('/alunonovos/index');
                die();
            }
        }
        // $log = $this->Alunonovo->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($alunonovo_id);
        // die();
        if (!isset($id) && (!empty($id))) {
            $id = $alunonovo_id['Alunonovo']['id'];
        }

        // pr($id);
        // die();
        // pr($registro);
        // die('registro');
        // echo $this->Session->read('id_categoria');
        // die();
        if ($this->Session->read('id_categoria') != 1) {
            if (($this->Session->read('id_categoria') == '2') && ($this->Session->read('numero'))) {
                $verifica = $this->Alunonovo->findByRegistro($this->Session->read('numero'));
                // pr($verifica);
                // die('verifica');
                // pr($this->Session->read('numero'));
                if ($id != $verifica['Alunonovo']['id']) {
                    $this->Flash->error(__("Acesso não autorizado"));
                    $this->redirect("/Alunonovos/index");
                    die("Não autorizado");
                }
            } else {
                $this->Flash->error(__("Acesso não autorizado"));
                $this->redirect("/Alunonovos/index");
                // die("Não autorizado");
            }
        }
        // pr($id);
        //die('id');

        if ($id) {
            $aluno = $this->Alunonovo->find('first',
                    array('conditions' => array('Alunonovo.id' => $id)));
        } elseif ($registro) {
            $aluno = $this->Alunonovo->find('first',
                    array('conditions' => array('Alunonovo.registro' => $registro)));
        }
        // pr($aluno);
        // die('aluno');
        if (!isset($aluno) || empty($aluno)) {
            $this->Flash->error(__('Estudante não cadastrado'));
            $this->redirect('/Alunonovos/index');
            die();
        }
        // Onde fizeram inscricoes
        $this->loadModel('Inscricao');
        $inscricoes = $this->Inscricao->findAllByIdAluno($aluno['Alunonovo']['registro']);

        // Onde fizeram estágios
        $this->loadModel('Estagiario');
        $estagios = $this->Estagiario->find('all', [
            'conditions' => ['Estagiario.registro' => $aluno['Alunonovo']['registro']]
        ]);
        // pr($estagios);
        // die('estagios');

        $this->set('alunos', $aluno);
        $this->set('inscricoes', $inscricoes);
        $this->set('estagios', $estagios);
    }

    public function delete($id = NULL) {

        // Capturo o numero de registro
        $registro = $this->Alunonovo->find('first', [
            'conditions' => ['Alunonovo.id' => $id],
            'fields' => 'registro'
        ]);
        // pr($registro);
        // die();
        if ($registro) {
            // Capturo os estagios realizados
            $this->loadModel('Estagiario');
            $estagiario = $this->Estagiario->find('first', array(
                'conditions' => array('Estagiario.registro' => $registro['Alunonovo']['registro']),
                'fields' => 'Estagiario.id'));
            // pr($estagiario);
            // die('estagiario');
            if ($estagiario) {
                $this->Flash->error(__('Estudante com estágios. Exclua os estágio primeiro'));
                $this->redirect('/Estagiarios/view/' . $estagiario['Estagiario']['id']);
                die();
            }

            // Capturo as inscricoes realizadas
            $this->loadModel('Inscricao');
            $inscricao = $this->Inscricao->find('all', array(
                'conditions' => array('Inscricao.id_aluno' => $registro['Alunonovo']['registro']),
                'fields' => 'id'));
            // pr($inscricao);
            // die();
            if ($inscricao) {
                foreach ($inscricao as $c_inscricao) {
                    // pr($c_inscricao['Inscricao']['id']);
                    // die();
                    $this->Inscricao->delete($c_inscricao['Inscricao']['id']);
                }
            }
        }
        if ($this->Alunonovo->delete($id)) {
            $this->Flash->success(__("Registro excluído (junto com as inscrições)"));
            $this->redirect("/Inscricaos/index/");
        } else {
            $this->Flash->error(__("Não foi possível excluir o registro"));
            $this->redirect("/Inscricaos/index/");
        }
    }

    public function busca($nome = NULL) {

        // Para paginar os resultados da busca por nome
        if (isset($nome)) {
            $this->request->data['Alunonovo']['nome'] = $nome;
        }

        if (!empty($this->data['Alunonovo']['nome'])) {

            $this->Alunonovo->recursive = -1;
            $condicaoalunonovo = array('Alunonovo.nome like' => '%' . $this->data['Alunonovo']['nome'] . '%');
            $alunos = $this->Alunonovo->find('all', [
                'conditions' => $condicaoalunonovo
            ]);
            // pr($alunos);
            // die();
            // Nenhum resultado
            if (empty($alunos)) {
                $this->loadModel('Aluno');
                $condicaoaluno = array('Aluno.nome like' => '%' . $this->data['Alunonovo']['nome'] . '%');
                $alunos = $this->Aluno->find('all', array('conditions' => $condicaoaluno));
                if (empty($alunonovos)) {
                    $this->Session->setFlash("Não foram encontrados registros");
                } else {
                    $this->Paginator->settings = array('order' => array('Alunonovo.nome ASC'), 'limit' => 10, 'conditions' => $condicaoalunonovo);
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
                // Buscar na tabela alunos. Não deveria existr um Aluno que não seja também Alunonovo
                $this->loadModel('Aluno');
                $alunonovos = $this->Aluno->findFirstByRegistro($this->data['Alunonovo']['registro']);
                // pr($alunonovos);
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros da(o) estudante"));
                    $this->redirect('/Alunonovos/busca_dre');
                } else {
                    $this->redirect('/Aluno/view/', $alunonovos['Aluno']['id']);
                }
            } else {
                // die($alunos['Alunonovo']['id']);
                $this->redirect('/Alunonovos/view/' . $alunos['Alunonovo']['id']);
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
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunonovos/busca');
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
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect('/Alunonovos/busca_cpf');
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function padroniza() {

        $alunos = $this->Alunonovo->find('all', array('fields' => array('id', 'nome', 'email', 'endereco', 'bairro')));
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

    public function aluno() {

        $this->loadModel('Aluno');
        $this->Aluno->recursive = 0;
        $alunos = $this->Aluno->find('all');

        $i = 0;
        foreach ($alunos as $c_aluno):

            // echo $c_aluno['Aluno']['registro'] . " ";
            $this->Alunonovo->recursive = 0;
            $aluno = $this->Alunonovo->find('first', [
                'conditions' => ['Alunonovo.registro' => $c_aluno['Aluno']['registro']]
            ]);
            // pr($aluno);
            // die();
            if (!$aluno) {
                echo $c_aluno['Aluno']['registro'] . " Não cadastrado" . "<br>";
                $nao_cadastrado[] = $c_aluno;
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
            // $log = $this->Aluno->getDataSource()->getLog(false, false);
            // debug($log);
            // die();

        endforeach;
        // $log = $this->Aluno->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($nao_cadastrado);
        die("Tarefa finalizada!");
    }

    public function alunonovos() {

        $this->loadModel('Aluno');
        $this->Alunonovo->recursive = 0;
        $alunonovos = $this->Alunonovo->find('all');

        $i = 0;
        foreach ($alunonovos as $c_alunonovo):

            // echo $c_alunonovo['Alunonovo']['registro'] . " ";
            $this->Aluno->recursive = 0;
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $c_alunonovo['Alunonovo']['registro']]
            ]);
            // pr($aluno);
            // die();
            if (!$aluno) {
                echo $c_alunonovo['Alunonovo']['registro'] . " Não cadastrado" . "<br>";
                $nao_cadastrado[] = $c_alunonovo;
                // cadastrar
                // die();
                /*
                  if ($this->Alunonovo->save($c_aluno)) {
                  $this->Flash->success(__("Cadastro realizado: " . $c_aluno['Aluno']['nome']));
                  }
                 */
            } else {
                // echo $c_alunonovo['Alunonovo']['registro'] . " Cadastrado" . "<br>";
                $estudantes[] = $aluno;
                // pr($alunos);
            }
            // $log = $this->Aluno->getDataSource()->getLog(false, false);
            // debug($log);
            // die();

        endforeach;
        // $log = $this->Aluno->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($nao_cadastrado);
        die("Tarefa finalizada!");
    }

}

?>
