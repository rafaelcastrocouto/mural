<?php

declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Event\EventInterface;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController {
    /**
     * beforeFilter method
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    
        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = null)
    {
        $periodo = $this->getRequest()->getParam('pass') ? $this->request->getParam('pass')[0] : $this->fetchTable("Configuracoes")->find()->first()['mural_periodo_atual'];
        $this->set('periodo', $periodo);
        
        $contained = ['Instituicoes', 'Professores'];
        
        if ($periodo == 'all') {
            $muralestagios = $this->Muralestagios->find('all')
            ->contain($contained);
        } else {
            $muralestagios = $this->Muralestagios->find('all', ['conditions' => ['Muralestagios.periodo' => $periodo] ])
            ->contain($contained);
        }

        // verifica se o aluno está inscrito
        $user_data = ['administrador_id'=>0,'aluno_id'=>0,'professor_id'=>0,'supervisor_id'=>0];
        $user_session = $this->request->getAttribute('identity');
        if ($user_session) { $user_data = $user_session->getOriginalData(); }
        
        if ($user_data['aluno_id']) {
            $muralestagios->
                formatResults(function (\Cake\Collection\CollectionInterface $results) use ($user_data) {
                return $results->map(function ($row) use ($user_data) {
                    $condition = ['aluno_id' => $user_data->aluno_id];
                    $inscricoes = $this->fetchTable('Inscricoes')->find('all', ['conditions' => $condition]);
                    $inscrito = false;
                    foreach ($inscricoes as $inscricao) {
                        if ($row['id'] == $inscricao->mural_estagio_id) { $inscrito = true; }
                    }
                    $row['inscricao'] = $inscrito;
                    return $row;
                });
            });
        }
        
        $this->set('muralestagios', $this->paginate($muralestagios));

        // cria a lista de periodos
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        $periodos = array_merge($periodos, array('all' => 'Todos'));
        $periodos = array_reverse($periodos);
        
        $this->set('periodos', $periodos);
    }

    /**
     * View method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $this->Authorization->authorize($this->Muralestagios);
        } catch (ForbiddenException $error) {
            $user_session = $this->request->getAttribute('identity');
            $this->Flash->error('Authorization error: ' . $error->getMessage());
            return $this->redirect(['action' => 'view', $user_session->id]);
        }
        
        $contained = ['Instituicoes', 'Turmas', 'Turnos', 'Professores', 'Inscricoes' => ['Alunos']];
        $muralestagio = $this->Muralestagios->get($id, ['contain' => $contained]);

        $inscricao = $this->fetchTable('Inscricoes')
            ->find('all', ['conditions' =>['mural_estagio_id' => $id]])
            ->contain(['Alunos', 'Muralestagios' => ['Instituicoes']])
            ->first();

        $this->set(compact('muralestagio', 'inscricao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $periodo = $this->fetchTable("Configuracoes")->find()->first()['mural_periodo_atual'];
        
        $muralestagio = $this->Muralestagios->newEmptyEntity();
        if ($this->request->is('post')) {
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registro de mural de estágio feito com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro de mural de estágio não foi feito. Tente novamente.'));
        }
        $professores = $this->Muralestagios->Professores->find('list');
        $instituicoes = $this->Muralestagios->Instituicoes->find('list');
        $turmas = $this->Muralestagios->Turmas->find('list');
        $turnos = $this->Muralestagios->Turnos->find('list');
        $this->set(compact('muralestagio', 'instituicoes', 'turmas', 'turnos', 'professores', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $muralestagio = $this->Muralestagios->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('The muralestagio has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The muralestagio could not be saved. Please, try again.'));
        }
        $instituicoes = $this->Muralestagios->Instituicoes->find('list');
        $turmas = $this->Muralestagios->Turmas->find('list');
        $turnos = $this->Muralestagios->Turnos->find('list');
        $professores = $this->Muralestagios->Professores->find('list', ['limit' => 500]);
        $this->set(compact('muralestagio', 'instituicoes', 'turmas', 'turnos', 'professores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $muralestagio = $this->Muralestagios->get($id);
        if ($this->Muralestagios->delete($muralestagio)) {
            $this->Flash->success(__('The muralestagio has been deleted.'));
        } else {
            $this->Flash->error(__('The muralestagio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     * Buscar method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function buscar () 
    {
        try {
            $this->Authorization->authorize($this->Muralestagios);
        } catch (ForbiddenException $error) {
            $this->Flash->error('Erro de authorização: ' . $error->getMessage());
            return $this->redirect('/');
        }
        $condition = ['Muralestagios.id' => ''];
        
        $requisitos = $this->getRequest()->getQuery('requisitos');
        if ($requisitos) { $condition = ['Muralestagios.requisitos LIKE' => '%' . $requisitos . '%']; }

        $outras = $this->getRequest()->getQuery('outras');
        if ($outras) { $condition = ['Muralestagios.outras LIKE' => '%' . $outras. '%']; }
        
        $instituicao = $this->getRequest()->getQuery('instituicao');
        if ($instituicao) { $condition = ['Instituicoes.instituicao LIKE' => '%' . $instituicao . '%']; }
                
        $cnpj = $this->getRequest()->getQuery('cnpj');
        if ($cnpj) { $condition = ['Instituicoes.cnpj LIKE' => '%' . $cnpj. '%']; }
        
        $email = $this->getRequest()->getQuery('email');
        if ($email) { $condition = ['Instituicoes.email' => $email]; }
        
        $contained = ['Instituicoes'];
        
        $busca = $this->Muralestagios->find('all',  ['conditions' => $condition ])->contain($contained)->order(['periodo' => 'DESC']);
        $muralestagios = $this->paginate($busca);
        $this->set(compact('muralestagios'));
    }
       

}
