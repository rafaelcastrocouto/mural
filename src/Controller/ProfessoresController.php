<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Event\EventInterface;


/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 * @method \App\Model\Entity\Professor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfessoresController extends AppController
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
        $professores = $this->paginate($this->Professores->find('all', [
            'contain' => ['Users'],
        ]));
        $this->set(compact('professores'));
    }

    /**
     * View method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->paginate = [
            'Estagiarios' => ['limit' => 5, 'scope' => 'estagiario'],
            /*'Muralestagios' => ['limit' => 5, 'scope' => 'muralestagio']*/
        ];
        $professor = $this->Professores->get($id, [
            'contain' => [ 'Users', 'Muralestagios' => ['Instituicoes'] ],
            
        ]);
        
        $estagiarios = $this->paginate($this->Professores->Estagiarios->find('all', [
            'contain' => ['Alunos', 'Instituicoes', 'Supervisores', 'Turmas'],
        ])->innerJoinWith('Professores', function (\Cake\ORM\Query $query) use ($professor) {
            return $query->where([
                'professor_id' => $professor->id,
            
            ]);
        }));
        /*
        $muralestagios = $this->paginate($this->Professores->Muralestagios->find('all', [
            'contain' => ['Instituicoes'],
        ])->innerJoinWith('Professores', function (\Cake\ORM\Query $query) use ($professor) {
            return $query->where([
                'professor_id' => $professor->id,
            
            ]);
        }));
        */
        $this->set(compact('professor', 'estagiarios'/*, 'muralestagios'*/));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $professor = $this->Professores->newEmptyEntity();
        if ($this->request->is('post')) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());

            if (!$professor->user_id) { 
                $user = $this->Authentication->getIdentity();
                $professor->user_id = $user->get('id'); 
            }
            
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('The professor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The professor could not be saved. Please, try again.'));
        }
        $this->set(compact('professor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $professor = $this->Professores->get($id);
        
        try {
            $this->Authorization->authorize($professor);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Authorization error: ' . $error->getMessage());
            return $this->redirect('/');
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('The professor has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The professor could not be saved. Please, try again.'));
        }
        $this->set(compact('professor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $professor = $this->Professores->get($id);

        try {
            $this->Authorization->authorize($professor);
            if ($this->Professores->delete($professor)) {
                $this->Flash->success(__('The professor has been deleted.'));
            } else {
                $this->Flash->error(__('The professor could not be deleted. Please, try again.'));
            }
        } catch (ForbiddenException $error) {
            $this->Flash->error(__( 'Authorization error: ' . $error->getMessage() ));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Busca method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function busca() 
    {
        try {
            $professor = $this->Professores->newEmptyEntity();
            $this->Authorization->authorize($professor);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Erro de authorização: ' . $error->getMessage());
            return $this->redirect('/');
        }
        $condition = ['Professores.nome LIKE' => ''];
        
        $nome = $this->getRequest()->getQuery('nome');
        if ($nome) { $condition = ['Professores.nome LIKE' => '%' . $nome . '%']; }

        $siape = $this->getRequest()->getQuery('siape');
        if ($siape) { $condition = ['Professores.siape' => $siape]; }
                
        $cpf = $this->getRequest()->getQuery('cpf');
        if ($cpf) { $condition = ['Professores.cpf' => $cpf]; }
        
        $email = $this->getRequest()->getQuery('email');
        if ($email) { $condition = ['Users.email' => $email]; }
        
        $busca = $this->Professores->find('all',  ['conditions' => $condition ])->contain(['Users']);
        $professores = $this->paginate($busca);
        $this->set(compact('professores'));

    }

    
}
