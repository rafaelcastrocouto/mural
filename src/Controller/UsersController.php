<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    /**
     * beforeFilter method
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    
        $this->Authentication->allowUnauthenticated(['login', 'add']);
        $this->Authorization->authorizeModel('Users');
    }

    /**
     * paginate array
     */
    protected array $paginate = [
        'sortableFields' => [
            'id', 'email', 'categoria_id', 'Alunos.nome', 'Professores.nome', 'Supervisores.nome', 'created', 'modified'
        ]
    ];   
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Authorization->applyScope($this->Users->find()->contain(['Categorias']));
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Categorias', 'Administradores', 'Alunos', 'Supervisores', 'Professores'],
        ]);
        try {
            $this->Authorization->authorize($user);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Authorization error.');
        }
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        
        $session = $this->request->getAttribute('identity');
        $authAdmin = ($session and $session->get('categoria_id') == 1);
        
        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user);
        
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), [
                'fields' => ['categoria_id', 'password', 'email'],
                'accessibleFields' => ['password' => true]
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        // filter input list options
        if ($authAdmin) {
            $categorias = $this->Users->Categorias->find('list');
        } else {
            $categorias = $this->Users->Categorias->find('list')->where(['id !=' => 1]);            
        }
        
        $this->set(compact('user', 'categorias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $session = $this->request->getAttribute('identity');
        $authAdmin = ($session and $session->get('categoria_id') == 1);
        $authUser = ($session and $session->get('id') == $id);
        
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $opt = ['fields' => ['categoria_id', 'email']];
            $data = $this->request->getData();
            if ($data['password']) {
                $opt = [
                    'fields' => ['categoria_id', 'email', 'password'],
                    'accessibleFields' => ['password' => ($authAdmin OR $authUser)]
                ];
            } else { unset($data['password']); }
            $user = $this->Users->patchEntity($user, $data, $opt);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        
        if ($authAdmin) {
            $categorias = $this->Users->Categorias->find('list');
        } else {
            $categorias = $this->Users->Categorias->find('list')->where(['id !=' => 1]);            
        }

        $user['password'] = '';    
        $this->set(compact('user', 'categorias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) 
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        try {
            $this->Authorization->authorize($user);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('The user has been deleted.'));
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }
        } catch (ForbiddenException $error) {
            $this->Flash->error(__('Authorization error.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /*
     * Login method
     */
    public function login()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid username or password');
        }
    }
    

    /*
     * Logout method
     */
    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }


    /*
     * Alternarusuario method
     * https://book.cakephp.org/authentication/3/en/impersonation.html
     */
    public function alternarusuario() 
    {

        // pr($this->data);
        // die();
        
 
    }
    
}
