<?php

class ProfessorsController extends AppController {

    public $name = "Professors";
    public $components = array('Auth', 'Paginator', 'Flash');
    public $paginate = array(
        'limit' => 10,
        'order' => array('Professor.nome' => 'asc'));

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow('usuarioprofessor', 'view');

        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'view', 'pauta');
            // $this->Session->setFlash("Estudante");
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('add', 'edit', 'index', 'view', 'pauta');
            // $this->Session->setFlash("Professor");
            // Professores, Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('usuarioprofessor', 'index', 'view', 'pauta', 'edit');
            // $this->Session->setFlash("Professor/Supervisor");
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $departamento = $this->request->query("departamento");

        if (!isset($departamento)):
            // echo "Null";
            $departamento = 0;
        // pr($departamento);
        endif;

        if ($departamento != '0') {
            // pr($departamento);
            $this->Paginator->settings = [
                'Professor' => [
                    'contain' => false,
                    'order' => ['nome'],
                    'conditions' => ['Professor.departamento' => $departamento],
                    'limit' => 10
                ]
            ];
        } else {
            $this->Paginator->settings = [
                'Professor' => [
                    'contain' => false,
                    'order' => ['nome'],
                    'limit' => 10
                ]
            ];
        }
        $this->set('professores', $this->Paginator->paginate('Professor'));
    }

    public function view($id = NULL) {

        $siape = $this->request->query("siape");
        if ($siape) {
            $professor_id = $this->Professor->find('first', [
                'contain' => [],
                'conditions' => ['Professor.siape' => $this->request->query('siape')]]
            );
            if ($professor_id) {
                $id = $professor_id['Professor']['id'];
            } else {
                $this->Flash->error(__('Erro em localizar o índice do/a professor/a!'));
                $this->redirect('/Murals/index');
            }
        }

        // Somente o próprio pode ver
        $id_categoria = $this->Session->read('id_categoria');
        if ($id_categoria != 1):
            if ($this->Session->read('numero')) {
                // die(pr($this->Session->read('numero')));
                $verifica = $this->Professor->find('first', [
                    'contain' => [],
                    'conditions' => ['Professor.siape' => $this->Session->read('numero')]
                ]);
                // pr($verifica);
                // die();
                if (!$verifica) {
                    $this->Flash->error(__("Acesso não autorizado"));
                    $this->redirect("/Professors/index");
                    die("Não autorizado");
                }
            }
        endif;
        // die('verifica');

        $siape = $this->request->query('siape');
        // pr($siape);
        if ($siape) {
            // die('siape');
            $professor = $this->Professor->find('first', [
                'contain' => [],
                'conditions' => ['Professor.siape' => $siape]
            ]);
        } elseif ($id) {
            // die('id');
            $professor = $this->Professor->find('first', [
                'contain' => [],
                'conditions' => ['Professor.id' => $id]
            ]);
        }
        // pr($professor);
        // die();
        $this->set('professor', $professor);
    }

    public function edit($id = NULL) {

        // pr($id);
        // pr($this->Session->read('numero'));
        // Somente o próprio pode ver
        $id_categoria = $this->Session->read("id_categoria");
        if ($id_categoria != 1):
            if ($this->Session->read('numero')) {
                // pr($this->Session->read('numero'));
                $verifica = $this->Professor->findBySiape($this->Session->read('numero'));
                // pr($verifica);
                // die();
                if ($this->request->query('siape') != $verifica['Professor']['siape']) {
                    $this->Flash->error(__("Acesso não autorizado"));
                    $this->redirect("/Professors/view/" . $id);
                    die("Não autorizado");
                }
            }
        endif;
// die();

        if (empty($this->data)) {
            $this->Professor->recursive = -1;
            $professor = $this->Professor->find('first', [
                'conditions' => ['Professor.id' => $id]
            ]);
            // pr($professor);
            // die();
            $this->Professor->id = $professor['Professor']['id'];
            $this->data = $this->Professor->read();
        } else {
            if ($this->Professor->save($this->data)) {
                // print_r($this->data);
                $this->Flash->success(__("Atualizado"));
                $this->redirect('/Professors/view/' . $this->Professor->id);
            }
        }
    }

    public function add() {

        // $this->set('meses', $this->meses());
        // pr($meses);

        if ($this->data) {
            // pr($this->data);
            // die();
            if ($this->Professor->save($this->data)) {
                $this->Session->setFlash(__('Dados inseridos'));
                $this->Professor->getLastInsertId();
                $this->redirect('/Professors/view/' . $this->Professor->getLastInsertId());
            }
        }
    }

    public function delete($id = NULL) {

        $professores = $this->Professor->find('first', array(
            'conditions' => array('Professor.id' => $id)
        ));

        // pr($professores);
        // die();

        if ($professores['Estagiario']) {
            $this->Flash->error(__('Há estagiários vinculados a este professor'));
            $this->redirect('/Professors/view/' . $id);
            exit;
        } else {
            $this->Professor->delete($id);
            $this->Flash->success(__("Supervisor excluido"));
            $this->redirect('/Professors/index/');
        }
    }

    public function busca($id = NULL) {

        if (isset($id))
            $this->request->data['Professor']['nome'] = $id;

        // $id = isset($this->request->data['Supervisor']['nome']) ? $this->request->data['Supervisor']['nome'] : null;
        // pr($id);
        if (!empty($this->request->data['Professor']['nome'])) {
            $condicao = ['Professor.nome like' => '%' . $this->request->data['Professor']['nome'] . '%'];
            $professores = $this->Professor->find('all', [
                'recursive' => -1, // Para excluir as associações
                'conditions' => $condicao,
                'order' => 'Professor.nome']);

            // pr($professores);
            // die('professores');

            /* Nenhum resultado */
            if (empty($professores)) {
                $this->Session->setFlash(__("Não foram encontrados registros"), "flash_notification");
            } else {
                // pr($professores);
                // die('professores');
                $this->Paginator->settings = ['Professor' => [
                        'contain' => [], // Para excluir as associações
                        'conditions' => ['Professor.nome like' => '%' . $this->request->data['Professor']['nome'] . '%'],
                        'order' => 'Professor.nome'
                    ]
                ];
                $this->set('professores', $this->Paginator->paginate('Professor'));
                $this->set('busca', $this->request->data['Professor']['nome']);
            }
        }
    }

    public function usuarioprofessor($id = NULL) {

        $this->set('siape', $siape = $this->request->query('siape'));
        $this->set('email', $email = $this->request->query('email'));

        // $this->request->data['siape'] = $siape;
        // $this->request->data['email'] = $email;

        $this->set('professores', $professores = $this->Professor->find('list', ['order' => 'Professor.nome']));
        // $log = $this->Professor->getDataSource()->getLog(false, false);
        // debug($log);
        // pr($professores);
        // die();
        if ($this->data) {
            // pr($this->data);
            // die();
            $this->Professor->id = $this->data['Professor']['professor_id'];
            $nome = $this->Professor->find('first', [
                'conditions' => ['Professor.id' => $this->data['Professor']['professor_id']],
                'fields' => 'Professor.nome'
            ]);
            // pr($nome);
            // die();
            $this->request->data['Professor']['nome'] = $nome['Professor']['nome'];
            $this->request->data['Professor']['id'] = $this->data['Professor']['professor_id'];
            // pr($this->data);
            // die();
            if ($this->Professor->save($this->data, ['validate' => false])) {
                // pr($this->data);
                // die();
                $this->Session->setFlash('Dados inseridos');
                $this->Session->write('user', $nome['Professor']['nome']);
                $this->Session->write('numero', $this->data['Professor']['siape']);
                $this->Session->write('categoria', 'professor');
                $this->Session->write('id_categoria', '3');
                $this->Professor->getLastInsertId();
                $this->redirect('/professors/view?siape=' . $this->data['Professor']['siape']);
            }
        }
    }

    public function pauta() {

        $parametros = $this->params['named'];
        $periodo = isset($parametros['periodo']) ? $parametros['periodo'] : NULL;

        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }

        $todosPeriodo = $this->Professor->Estagiario->find('list', array(
            'fields' => array('Estagiario.periodo', 'Estagiario.periodo'),
            'group' => array('Estagiario.periodo'),
            'order' => array('Estagiario.periodo')
        ));
        // pr($todosPeriodo);
        // die();

        if (!$periodo)
            $periodo = end($todosPeriodo);

        $estagiarios = $this->Professor->find('all', [
            'contain' => ['Estagiario']
        ]);
        // pr($estagiarios);
        // die();

        $k = 0;
        foreach ($estagiarios as $c_professor) {
            $professor = $c_professor['Professor']['nome'];
            $professor_id = $c_professor['Professor']['id'];
            $departamento = $c_professor['Professor']['departamento'];
            // $area = $c_professor['Professor']['id_area'];

            $k++;
            // echo $professor . " ";
            $i = 0;
            $estagiariostotal = sizeof($c_professor['Estagiario']);
            // echo '<br>';
            $p = 1;
            foreach ($c_professor['Estagiario'] as $estagiariodoprofessor) {
                // pr($estagiariodoprofessor['periodo']);
                // die();
                // echo "Periodo selecionado " . $periodo . "<br>";
                // pr($estagiariodoprofessor['periodo']);
                // die();
                if ($estagiariodoprofessor['periodo'] == $periodo) {
                    // echo $estagiariodoprofessor['periodo'] . " " . $periodo . "<br>";
                    $this->loadModel('Area');
                    $this->Area->recursive = -1;
                    $area = $this->Area->find('first', array('conditions' => array('Area.id' => $estagiariodoprofessor['id_area'])));
                    // pr($area);
                    // echo $k . " " . $professor . " -> " . " " . $periodo . " " . $p++ . "<br>";
                    $pauta[$k]['id'] = $k;
                    $pauta[$k]['professor'] = $professor;
                    $pauta[$k]['professor_id'] = $professor_id;
                    $pauta[$k]['departamento'] = $departamento;
                    $pauta[$k]['estagariariostotal'] = $estagiariostotal;
                    if ($area) {
                        $pauta[$k]['area'] = $area['Area']['area'];
                        $pauta[$k]['area_id'] = $area['Area']['id'];
                    } else {
                        $pauta[$k]['area'] = NULL;
                        $pauta[$k]['area_id'] = NUll;
                    }
                    $pauta[$k]['estagiariosperiodo'] = $p;
                    $p++;
                    // pr($pauta);
                } else {
                    // echo "Sem estagiários no periódo: " . $periodo . "<br>";
                }
                // pr($pauta);
                // die();
                // echo "Periodo " . $p . "<br>";
                $i++;
            }
        }

        // pr($pauta);
        // die();
        $this->set('todosPeriodo', $todosPeriodo);
        $this->set('periodo', $periodo);
        if (isset($pauta)) {
            $this->set('professores', $pauta);
        }
    }

}

?>
