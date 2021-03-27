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
            // $this->redirect('/murals/index');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index() {

        $this->Paginator->settings = [
            'Professor' => [
                'order' => ['nome'],
                'limit' => 10
            ]
        ];
        $this->set('professores', $this->Paginator->paginate('Professor'));
    }

    public function view($id = NULL) {

        if (!is_numeric($id)) {
            $professor_id = $this->Professor->find('first', [
                'conditions' => ['Professor.siape' => $this->request->query('siape')]]
            );
            if ($professor_id) {
                $id = $professor_id['Professor']['id'];
                // echo $id;
            } else {
                $this->Session->setFlash(__('Alguma coisa deu errado!'));
                $this->redirect('/Murals/index');
            }
        }
        // pr($id);
        // die();
        // Configure::write('debug', 0);
        // Somente o próprio pode ver
        if ($this->Session->read('numero')) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Professor->findBySiape($this->Session->read('numero'));
            // pr($verifica);
            // die();
            if ($id != $verifica['Professor']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Professors/index");
                die("Não autorizado");
            }
        }

        $siape = $this->request->query('siape');
        if ($siape) {
            $professor = $this->Professor->find('first', array(
                'conditions' => array('Professor.siape' => $siape),
                'order' => 'Professor.nome'));
        } elseif ($id) {
            $professor = $this->Professor->find('first', array(
                'conditions' => array('Professor.id' => $id),
                'order' => 'Professor.nome'));
        }
        // pr($professor);

        $proximo = $this->Professor->find('neighbors', array(
            'field' => 'nome', 'value' => $professor['Professor']['nome']));

        $this->set('registro_next', $proximo['next']['Professor']['id']);
        $this->set('registro_prev', $proximo['prev']['Professor']['id']);

        $this->set('professor', $professor);
    }

    public function edit($id = NULL) {

        $this->Professor->id = $id;
        // $this->set('meses', $this->meses());
        // Somente o próprio pode ver
        if ($this->Session->read('numero')) {
            // die(pr($this->Session->read('numero')));
            $verifica = $this->Professor->findBySiape($this->Session->read('numero'));
            if ($id != $verifica['Professor']['id']) {
                $this->Session->setFlash("Acesso não autorizado");
                $this->redirect("/Professors/view/" . $id);
                die("Não autorizado");
            }
        }

        if (empty($this->data)) {
            $this->data = $this->Professor->read();
        } else {
            if ($this->Professor->save($this->data)) {
                // print_r($this->data);
                $this->Session->setFlash("Atualizado");
                $this->redirect('/Professors/view/' . $id);
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
            pr($this->data);
            // die();
            if ($this->Professor->save($this->data, ['validate' => false])) {
                // pr($this->data);
                // die();
                $this->Session->setFlash('Dados inseridos');
                $this->Session->write('user', strtolower($this->data['Professor']['email']));
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

        if (!$periodo)
            $periodo = end($todosPeriodo);

        $this->Professor->recursive = 1;
        $estagiarios = $this->Professor->find('all');
        // pr($estagiarios);

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

                if ($estagiariodoprofessor['periodo'] == $periodo) {

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
                }
                // echo "Periodo " . $p . "<br>";
                $i++;
            }
        }

        $this->set('todosPeriodo', $todosPeriodo);
        $this->set('periodo', $periodo);
        $this->set('professores', $pauta);
    }

}

?>
