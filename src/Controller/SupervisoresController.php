<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Event\EventInterface;

/**
 * Supervisores Controller
 *
 * @property \App\Model\Table\SupervisoresTable $Supervisores
 * @method \App\Model\Entity\Supervisor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupervisoresController extends AppController
{
    /**
     * beforeFilter method
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $supervisores = $this->paginate($this->Supervisores->find('all', [
            'contain' => ['Users'],
        ]));
        $this->set(compact('supervisores'));
    }

    /**
     * View method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contained = [
            'Instituicoes' => ['Areas'], 
            'Estagiarios' => ['Alunos', 'Instituicoes', 'Supervisores', 'Professores', 'Turmas'], 
            'Users'
        ];
        $this->paginate = [
            'contain' => $contained
        ];
        
        $supervisor = $this->Supervisores->get($id, [
            'contain' => $contained
        ]);

        $this->set(compact('supervisor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $supervisor = $this->Supervisores->newEmptyEntity();
        if ($this->request->is('post')) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            
            if (!$supervisor->user_id) { 
                $user = $this->Authentication->getIdentity();
                $supervisor->user_id = $user->get('id'); 
            }
            
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('The supervisor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supervisor could not be saved. Please, try again.'));
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list');
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $supervisor = $this->Supervisores->get($id, [
            'contain' => ['Instituicoes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('The supervisor has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The supervisor could not be saved. Please, try again.'));
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list');
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supervisor = $this->Supervisores->get($id);
        if ($this->Supervisores->delete($supervisor)) {
            $this->Flash->success(__('The supervisor has been deleted.'));
        } else {
            $this->Flash->error(__('The supervisor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    
    /**
     * Busca method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function buscar() 
    {
        try {
            $supervisor = $this->Supervisores->newEmptyEntity();
            $this->Authorization->authorize($supervisor);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Erro de authorização: ' . $error->getMessage());
            return $this->redirect('/');
        }
        $condition = ['Supervisores.id' => ''];
        
        $nome = $this->getRequest()->getQuery('nome');
        if ($nome) { $condition = ['Supervisores.nome LIKE' => '%' . $nome . '%']; }

        $cress = $this->getRequest()->getQuery('cress');
        if ($cress) { $condition = ['Supervisores.cress' => $cress]; }
                
        $cpf = $this->getRequest()->getQuery('cpf');
        if ($cpf) { $condition = ['Supervisores.cpf' => $cpf]; }
        
        $email = $this->getRequest()->getQuery('email');
        if ($email) { $condition = ['Users.email' => $email]; }
        
        $busca = $this->Supervisores->find('all',  ['conditions' => $condition ])->contain(['Users']);
        $supervisores = $this->paginate($busca);
        $this->set(compact('supervisores'));

    }
    
}
