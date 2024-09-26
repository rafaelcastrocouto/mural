<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Inscricoes Controller
 *
 * @property \App\Model\Table\InscricoesTable $Inscricoes
 * @method \App\Model\Entity\Inscricao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InscricoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        //$this->paginate = [
        //    'contain' => ['Alunos', 'Muralestagios'],
        //];
        $inscricoes = $this->paginate($this->Inscricoes->find()
        ->contain(['Alunos', 'Muralestagios' /*=> ['Instituicoes']*/]));

        $this->set(compact('inscricoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Inscricao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inscricao = $this->Inscricoes->get($id, [
            'contain' => ['Alunos', 'Muralestagios' /*=> ['Instituicoes']*/],
        ]);

        $this->set(compact('inscricao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inscricao = $this->Inscricoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $inscricao = $this->Inscricoes->patchEntity($inscricao, $this->request->getData());
            if ($this->Inscricoes->save($inscricao)) {
                $this->Flash->success(__('The inscricao has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscricao could not be saved. Please, try again.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', ['limit' => 200]);
        $muralestagios = $this->Inscricoes->Muralestagios->find('list', ['limit' => 200]);
        $this->set(compact('inscricao', 'alunos', 'muralestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inscricao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inscricao = $this->Inscricoes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inscricao = $this->Inscricoes->patchEntity($inscricao, $this->request->getData());
            if ($this->Inscricoes->save($inscricao)) {
                $this->Flash->success(__('The inscricao has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscricao could not be saved. Please, try again.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', ['limit' => 200]);
        $muralestagios = $this->Inscricoes->Muralestagios->find('list', ['limit' => 200]);
        $this->set(compact('inscricao', 'alunos', 'muralestagios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inscricao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inscricao = $this->Inscricoes->get($id);
        if ($this->Inscricoes->delete($inscricao)) {
            $this->Flash->success(__('The inscricao has been deleted.'));
        } else {
            $this->Flash->error(__('The inscricao could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    //public function mural($id = null)
    //{
        //$inscricao = $this->Inscricoes->find('all');
        // pr($inscricao);
        //foreach ($inscricao as $c_inscriacao) {
            // pr($c_inscriacao);
        //}
        //die();
    //}
    
}
