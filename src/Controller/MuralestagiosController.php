<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($periodo = NULL) {

        if ($periodo) {
            $muralestagios = $this->Muralestagios->find('all', [
                'conditions' => ['muralestagios.periodo' => $periodo]
            ]);
        } else {
            $muralestagios = $this->Muralestagios->find('all');
        }
        $this->set('muralestagios', $this->paginate($muralestagios));

        $query = $this->Muralestagios->find('all', [
            'fields' => ['periodo'],
            'group' => ['periodo'],
            'order' => ['periodo']
        ]);
        $periodos = $query->all()->toArray();
        foreach ($query as $periodo) {
            $periodostotal[$periodo->periodo] = $periodo->periodo;
        }
        $this->set('periodos', $periodostotal);
        $this->set('periodo', $periodo);
    }

    /**
     * View method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        // pr($id);
        // die();
        /*
        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicaoestagios', 'Areaestagios', 'Docentes', 'Muralinscricoes'],
        ]);
         */
        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicaoestagios', 'Areaestagios', 'Docentes', 'Muralinscricoes' => ['Estudantes']],
        ]);
        // pr($muralestagio);
        // die();
        $this->set(compact('muralestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $muralestagio = $this->Muralestagios->newEmptyEntity();
        if ($this->request->is('post')) {
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('The muralestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The muralestagio could not be saved. Please, try again.'));
        }
        $instituicaoestagios = $this->Muralestagios->Instituicaoestagios->find('list', ['limit' => 200]);
        $areaestagios = $this->Muralestagios->Areaestagios->find('list', ['limit' => 200]);
        $docentes = $this->Muralestagios->Docentes->find('list', ['limit' => 200]);
        $this->set(compact('muralestagio', 'instituicaoestagios', 'areaestagios', 'docentes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {

        $muralestagio = $this->Muralestagios->get($id, [
            'contain' => ['Instituicaoestagios'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('The muralestagio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The muralestagio could not be saved. Please, try again.'));
        }
        $instituicaoestagios = $this->Muralestagios->Instituicaoestagios->find('list');
        $areaestagios = $this->Muralestagios->Areaestagios->find('list', ['limit' => 200]);
        $docentes = $this->Muralestagios->Docentes->find('list', ['limit' => 500]);
        $this->set(compact('muralestagio', 'instituicaoestagios', 'areaestagios', 'docentes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $muralestagio = $this->Muralestagios->get($id);
        if ($this->Muralestagios->delete($muralestagio)) {
            $this->Flash->success(__('The muralestagio has been deleted.'));
        } else {
            $this->Flash->error(__('The muralestagio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
