<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Userestagios Controller
 *
 * @property \App\Model\Table\UserestagiosTable $Userestagios
 * @method \App\Model\Entity\Userestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserestagiosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Alunos', 'Supervisores', 'Professores'],
        ];
        $userestagios = $this->paginate($this->Userestagios);

        $this->set(compact('userestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $userestagio = $this->Userestagios->get($id, [
            'contain' => ['Alunos', 'Supervisores', 'Professores'],
        ]);

        $this->set(compact('userestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $userestagio = $this->Userestagios->newEmptyEntity();
        if ($this->request->is('post')) {
            $userestagio = $this->Userestagios->patchEntity($userestagio, $this->request->getData());
            if ($this->Userestagios->save($userestagio)) {
                $this->Flash->success(__('The userestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
        }
        $alunos = $this->Userestagios->Alunos->find('list', ['limit' => 200]);
        $supervisores = $this->Userestagios->Supervisores->find('list', ['limit' => 200]);
        $professores = $this->Userestagios->Professores->find('list', ['limit' => 200]);
        $this->set(compact('userestagio', 'alunos', 'supervisores', 'professores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $userestagio = $this->Userestagios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userestagio = $this->Userestagios->patchEntity($userestagio, $this->request->getData());
            if ($this->Userestagios->save($userestagio)) {
                $this->Flash->success(__('The userestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
        }
        $alunos = $this->Userestagios->Alunos->find('list', ['limit' => 200]);
        $supervisores = $this->Userestagios->Supervisores->find('list', ['limit' => 200]);
        $professores = $this->Userestagios->Professores->find('list', ['limit' => 200]);
        $this->set(compact('userestagio', 'alunos', 'supervisores', 'professores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Userestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $userestagio = $this->Userestagios->get($id);
        if ($this->Userestagios->delete($userestagio)) {
            $this->Flash->success(__('The userestagio has been deleted.'));
        } else {
            $this->Flash->error(__('The userestagio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /*
     * Preenche o id da tabela userestagios com os valores correspondentes
     */
    public function preencher() {

        $user = $this->Userestagios->find('all');
        foreach ($user as $c_user) {
            // pr($c_user->categoria);
            if ($c_user->categoria == 2) {
                // pr($c_user->numero);
                $this->loadModel('Alunos');
                aluno = $this->Alunos->find()
                        ->contain([])
                        ->where(['alunos.registro' => $c_user->numero]);
                // pr($aluno);
                // pr($aluno->first()->registro);
                $c_user->aluno_id = $aluno->first()->id;
                // pr($c_user->aluno_id);
                // pr($c_user->id);
                if ($this->Userestagios->save($c_user)) {
                    // echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    // echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die();
            }
            // die('Alunos');
            // Professores
            if ($c_user->categoria == 3) {
                // pr($c_user->numero);
                // die();
                $this->loadModel('Professores');
                $professor = $this->Professores->find()
                        ->contain([])
                        ->where(['professores.siape' => $c_user->numero]);
                // pr($professor);
                // pr($professor->first()->siape);
                $c_user->professor_id = $professor->first()->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die('if professores');
            }
            // die('Professores');
            // Supervisores
            if ($c_user->categoria == 4) {
                // pr($c_user->numero);
                // die();
                $this->loadModel('Supervisores');
                $supervisor = $this->Supervisores->find()
                        ->contain([])
                        ->where(['supervisores.cress' => $c_user->numero]);
                // pr($professor);
                // pr($professor->first()->siape);
                $c_user->supervisor_id = $supervisor->first()->id;
                // pr($c_user->professor_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die('if professores');
            }
            // die('Professores');
        }
        // pr($user);
        die();
    }

}
