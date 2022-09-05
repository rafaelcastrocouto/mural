<?php

class SupervisorsController extends AppController {

    public $name = 'Supervisors';
    public $components = array('Auth', 'Paginator', 'Flash');

    public function beforeFilter() {

        // pr($this->Session->read('id_categoria'));

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'busca');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('add', 'edit', 'addinstituicao', 'deleteassociacao', 'index', 'view', 'busca');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('add', 'edit', 'addinstituicao', 'deleteassociacao', 'index', 'view', 'busca');
            // $this->Session->setFlash("Supervisor");
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;

        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }

        $this->Supervisor->virtualFields['virtualestagiarios'] = 'count(Estagiario.registro)';
        $this->Supervisor->virtualFields['virtualestudantes'] = 'count(Distinct Estagiario.registro)';
        $this->Supervisor->virtualFields['virtualperiodos'] = 'count(Distinct Estagiario.periodo)';
        $this->Supervisor->virtualFields['virtualmaxperiodo'] = 'max(periodo)';

        /* Para caixa de seleção */
        $todosPeriodos = $this->Supervisor->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));

        if ($periodo):
            $this->paginate = array(
                'Estagiario' => array(
                    'limit' => 10,
                    // 'fields' => array('Supervisor.id', 'Supervisor.cress', 'Supervisor.nome', 'count("Estagiario.registro") as "Supervisor__virtualestagiarios"', 'count(Distinct Estagiario.registro) as `Supervisor__virtualestudantes`', 'count(Distinct Estagiario.periodo) as "Supervisor__virtualperiodos"', 'max(periodo) as "Supervisor__virtualmaxperiodo"'),
                    'conditions' => array('Estagiario.periodo' => $periodo),
                    'group' => array('Estagiario.id_supervisor'),
                    'order' => array('Supervisor.nome' => 'asc'))
            );
        else:
            $this->paginate = array(
                'Estagiario' => array(
                    'limit' => 10,
                    // 'fields' => array('Supervisor.id', 'Supervisor.cress', 'Supervisor.nome', 'count("Estagiario.registro") as "Supervisor__virtualestagiarios"', 'count(Distinct Estagiario.registro) as `Supervisor__virtualestudantes`', 'count(Distinct Estagiario.periodo) as "Supervisor__virtualperiodos"', 'max(periodo) as "Supervisor__virtualmaxperiodo"'),
                    'group' => array('Estagiario.id_supervisor'),
                    'order' => array('Supervisor.nome' => 'asc'))
            );
        endif;

        $this->set('todosPeriodos', $todosPeriodos);
        $this->set('periodo', $periodo);
        $this->set('supervisores', $this->Paginate($this->Supervisor->Estagiario));
    }

    public function view($id = NULL) {

        $cress = $this->request->query('cress');
        if ($cress) {
            $supervisor = $this->Supervisor->find('first', array(
                'conditions' => array('Supervisor.cress' => $cress)
            ));
        } elseif ($id) {
            $supervisor = $this->Supervisor->find('first', array(
                'conditions' => array('Supervisor.id' => $id)
            ));
        }

        /* Para o select de inserir uma nova instituicao */
        $this->loadModel('Instituicao');
        $instituicoes = $this->Instituicao->find('list', array('order' => 'Instituicao.instituicao'));
        asort($instituicoes);
        $this->set('instituicoes', $instituicoes);

        // pr($supervisor);

        $proximo = $this->Supervisor->find('neighbors', array(
            'field' => 'nome', 'value' => $supervisor['Supervisor']['nome']));

        $this->set('registro_next', $proximo['next']['Supervisor']['id']);
        $this->set('registro_prev', $proximo['prev']['Supervisor']['id']);

        $this->set('supervisor', $supervisor);
    }

    public function add() {

        $this->loadModel('Instituicao');
        $this->Instituicao->contain();
        $instituicoes = $this->Instituicao->find('list', [
            'order' => ['Instituicao.instituicao']
        ]);
        $this->set('instituicoes', $instituicoes);

        $this->Supervisor->contain();
        $supervisores = $this->Supervisor->find('list', [
            'order' => ['nome' => 'ASC'],
            'fields' => ['nome']
        ]);
        $this->set('supervisores', $supervisores);

        if ($this->data) {
            /* O supervisor tem que estar numa instituição */
            if ($this->data['Instituicao']['id'] == 0) {
                $this->Flash->error(__('Selecione a instituição na que trabalha o(a) supervisor(a)'));
                $this->redirect('/Supervisors/add');
            }

            /* Verifico o nome do supervisor */
            $this->Supervisor->contain();
            $nome = $this->Supervisor->find('first', [
                'conditions' => ['Supervisor.nome' => $this->data['Supervisor']['nome']]
            ]);
            if ($nome) {
                $this->Flash->error(__('Já há um(a) supervisor(a) cadastrado(a) com esse mesmo nome'));
                $this->redirect(['controller' => 'supervisors', 'action' => 'view', $nome['Supervisor']['id']]);
            }

            /* O supervisor não pode estar repetido */
            $this->Supervisor->contain();
            $cress = $this->Supervisor->find('first', [
                'conditions' => ['Supervisor.cress' => $this->data['Supervisor']['cress']]
            ]);
            if ($cress) {
                $this->Flash->error(__('Cress do(a) supervisor(a) já cadastrado'));
                $this->redirect('/Supervisors/view/' . $cress['Supervisor']['id']);
            } else {
                if ($this->Supervisor->save($this->data)) {
                    $this->Flash->success(__('Dados inseridos'));
                    $this->redirect('/Supervisors/view/' . $this->Supervisor->getLastInsertId());
                }
            }
        }
    }

    public function busca($id = NULL) {

        if ($id) {
            $this->request->data['Supervisor']['nome'] = $id;
        }

        $this->paginate = array(
            'limit' => 10,
            'order' => array(
                'Supervisor.nome' => 'asc')
        );

        if (isset($this->data['Supervisor']['nome'])) {

            $condicao = array('Supervisor.nome like' => '%' . $this->data['Supervisor']['nome'] . '%');
            $supervisores = $this->Supervisor->find('all', array('conditions' => $condicao));

            // Nenhum resultado
            if (empty($supervisores)) {
                $this->Session->setFlash("Não foram encontrados registros");
            } else {
                $this->set('supervisores', $this->Paginate($condicao));
                $this->set('busca', $this->data['Supervisor']['nome']);
            }
        }
    }

    public function edit($id = NULL) {

        $cress = $this->request->query('cress');
        // pr($cress);
        // die();
        $this->Supervisor->recursive = -1;
        $supervisor = $this->Supervisor->find('first', [
            'conditions' => ['Supervisor.cress' => $cress]
        ]);
        // pr($supervisor);
        // die();

        if (!isset($id)) {
            $id = $supervisor['Supervisor']['id'];
            $this->Supervisor->id = $id;
        } else {
            $this->Supervisor->id = $id;
        }

        if (empty($this->data)) {
            $this->data = $this->Supervisor->read();
        } else {
            if ($this->Supervisor->save($this->data)) {
                // print($id);
                // die();
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Supervisors/view/' . $id);
            }
        }
    }

    public function delete($id = NULL) {

        $supervisores = $this->Supervisor->find('first', array(
            'conditions' => array('Supervisor.id' => $id)
        ));

        // pr($supervisores);
        // die();

        if ($supervisores['Estagiario']) {
            $this->Session->setFlash('Há estagiários vinculados a este supervisor');
            $this->redirect('/Supervisors/view/' . $id);
            exit;
        } elseif ($supervisores['Instituicao']) {
            $this->Session->setFlash('Há instituições vinculadas a este supervisor');
            $this->redirect('/Supervisors/view/' . $id);
            exit;
        } else {
            $this->Supervisor->delete($id);
            $this->Session->setFlash("Supervisor excluido");
            $this->redirect('/Supervisors/index/');
        }
    }

    public function addinstituicao() {

        if ($this->data) {
            // pr($this->data);
            // die();
            if ($this->Supervisor->InstSuper->save($this->data)) {
                $this->Session->setFlash('Dados inseridos');
                $this->redirect('/Supervisors/view/' . $this->data['InstSuper']['id_supervisor']);
            }
        }
    }

    public function deleteassociacao($id = NULL) {

        $id_superinstituicao = $this->Supervisor->InstSuper->find('first', array('conditions' => 'InstSuper.id= ' . $id));
        // pr($id_superinstituicao);
        // die();
        $this->Supervisor->InstSuper->delete($id);

        $this->Session->setFlash("Instituição excluída do supervisor");
        $this->redirect('/Supervisors/view/' . $id_superinstituicao['InstSuper']['id_supervisor']);
    }

    public function repetidos() {

        $repetidos = $this->Supervisor->find('all', array(
            'fields' => array('id', 'cress', 'nome', 'count(cress) as quantidade'),
            'group' => 'cress having quantidade > 1',
            'order' => 'nome')
        );

        $this->set('repetidos', $repetidos);
    }

    public function semalunos() {

        $this->Paginator->settings = [
            'Supervisor' => array(
                'limit' => 10,
                'fields' => array('Supervisor.id', 'Supervisor.cress', 'Supervisor.nome', 'Estagiario.id_supervisor', 'Instituicao.instituicao'),
                'joins' => array(
                    array(
                        'table' => 'estagiarios',
                        'alias' => 'Estagiario',
                        'type' => 'LEFT',
                        'conditions' => 'Supervisor.id = Estagiario.id_supervisor'
                    ),
                    array(
                        'table' => 'estagio',
                        'alias' => 'Instituicao',
                        'type' => 'LEFT',
                        'conditions' => 'Estagiario.id_instituicao = Instituicao.id'
                    )
                ),
                'conditions' => array('Estagiario.id_supervisor IS NULL'),
                'order' => 'Supervisor.nome'
        )];

        $this->set('semalunos', $this->Paginator->paginate('Supervisor'));
    }

}

?>
