<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($periodo = NULL)
    {
        
        // echo "Período " . $periodo;
        if ($periodo) {
            $query = $this->Estagiarios->find('all')
            ->where(['estagiarios.periodo' => $periodo])
            ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Areaestagios']);
        } else {
            $query = $this->Estagiarios->find('all')
            ->contain(['Alunos', 'Professores', 'Supervisores', 'Instituicoes', 'Areaestagios']);
        }
        //$config = $this->paginate = ['sortWhitelist' => ['id', 'Alunos.nome', 'registro', 'turno', 'nivel', 'Instituicoes.instituicao', 'Supervisores.nome', 'Professores.nome']];
        $estagiarios = $this->paginate($query);

        $query = $this->Estagiarios->find('all', [
            'fields' => ['periodo'],
            'group' => ['periodo'],
            'order' => ['periodo']
        ]);
        $periodos = $query->all()->toArray();
        foreach ($query as $periodo) {
            $periodostotal[$periodo->periodo] = $periodo->periodo;
        }
        $this->set('periodo', $periodo);        
        $this->set('periodos', $periodostotal);

        $this->set(compact('estagiarios'));
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => ['Alunos', 'Instituicoes', 'Supervisores', 'Professores', 'Areaestagios'],
        ]);

        $this->set(compact('estagiario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estagiario = $this->Estagiarios->newEmptyEntity();
        if ($this->request->is('post')) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('The estagiario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list', ['limit' => 200]);
        $instituicoes = $this->Estagiarios->Instituicoes->find('list', ['limit' => 200]);
        $supervisores = $this->Estagiarios->Supervisores->find('list', ['limit' => 200]);
        $professores = $this->Estagiarios->Professores->find('list', ['limit' => 200]);
        $areaestagios = $this->Estagiarios->Areaestagios->find('list', ['limit' => 200]);
        $this->set(compact('estagiario', 'alunos', 'instituicoes', 'supervisores', 'professores', 'areaestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estagiario = $this->Estagiarios->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity($estagiario, $this->request->getData());
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('The estagiario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estagiario could not be saved. Please, try again.'));
        }
        $alunos = $this->Estagiarios->Alunos->find('list');
        $instituicoes = $this->Estagiarios->Instituicoes->find('list');
        $supervisores = $this->Estagiarios->Supervisores->find('list');
        $professores = $this->Estagiarios->Professores->find('list', ['limit' => 500]);
        $areaestagios = $this->Estagiarios->Areaestagios->find('list', ['limit' => 200]);
        $this->set(compact('estagiario', 'alunos', 'instituicoes', 'supervisores', 'professores', 'areaestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estagiario = $this->Estagiarios->get($id);
        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('The estagiario has been deleted.'));
        } else {
            $this->Flash->error(__('The estagiario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
