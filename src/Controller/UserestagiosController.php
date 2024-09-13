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
        //this->paginate = [
        //    'contain' => ['Estudantes', 'Supervisores', 'Docentes'],
        //];
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
            'contain' => ['Estudantes', 'Supervisores', 'Docentes'],
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
        $estudantes = $this->Userestagios->Estudantes->find('list', ['limit' => 200]);
        $supervisores = $this->Userestagios->Supervisores->find('list', ['limit' => 200]);
        $docentes = $this->Userestagios->Docentes->find('list', ['limit' => 200]);
        $this->set(compact('userestagio', 'estudantes', 'supervisores', 'docentes'));
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
        $estudantes = $this->Userestagios->Estudantes->find('list', ['limit' => 200]);
        $supervisores = $this->Userestagios->Supervisores->find('list', ['limit' => 200]);
        $docentes = $this->Userestagios->Docentes->find('list', ['limit' => 200]);
        $this->set(compact('userestagio', 'estudantes', 'supervisores', 'docentes'));
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
                $this->loadModel('Estudantes');
                $estudante = $this->Estudantes->find()
                        ->contain([])
                        ->where(['estudantes.registro' => $c_user->numero]);
                // pr($estudante);
                // pr($estudante->first()->registro);
                $c_user->estudante_id = $estudante->first()->id;
                // pr($c_user->estudante_id);
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
            // die('Estudantes');
            // Professores
            if ($c_user->categoria == 3) {
                // pr($c_user->numero);
                // die();
                $this->loadModel('Docentes');
                $docente = $this->Docentes->find()
                        ->contain([])
                        ->where(['docentes.siape' => $c_user->numero]);
                // pr($docente);
                // pr($docente->first()->siape);
                $c_user->docente_id = $docente->first()->id;
                // pr($c_user->docente_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die('if docentes');
            }
            // die('Docentes');
            // Supervisores
            if ($c_user->categoria == 4) {
                // pr($c_user->numero);
                // die();
                $this->loadModel('Supervisores');
                $supervisor = $this->Supervisores->find()
                        ->contain([])
                        ->where(['supervisores.cress' => $c_user->numero]);
                // pr($docente);
                // pr($docente->first()->siape);
                $c_user->supervisor_id = $supervisor->first()->id;
                // pr($c_user->docente_id);
                // pr($c_user->id);
                // die();
                if ($this->Userestagios->save($c_user)) {
                    echo "Atualizado!" . "</br>";
                    $this->Flash->success(__('The userestagio has been saved.'));
                } else {
                    echo "Erro!" . "<br>";
                    $this->Flash->error(__('The userestagio could not be saved. Please, try again.'));
                };
                // die('if docentes');
            }
            // die('Docentes');
        }
        // pr($user);
        die();
    }

}
