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
        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracao = $this->fetchTable('Configuracoes');
            $periodo_atual = $configuracao->find()->select(['mural_periodo_atual'])->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }
        
        $estagiariotabela = $this->fetchTable('Estagiarios');
        $periodototal = $estagiariotabela->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();

        $query = $this->Inscricoes->find()
                ->contain(['Alunos', 'Muralestagios' => ['Instituicoes']])
                ->where(['Inscricoes.periodo' => $periodo]);

        $inscricoes = $this->paginate($query);

        $this->set(compact('inscricoes', 'periodos', 'periodo'));
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
            'contain' => ['Alunos', 'Muralestagios' => ['Instituicoes']],
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
        
        $mural_estagio_id = $this->getRequest()->getQuery('mural_estagio_id');
        $periodo = $this->getRequest()->getQuery('periodo');

        if (empty($periodo)) {
            $configuracaotabela = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotabela->find()
                    ->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }
        
        $user_id = $this->Authentication->getIdentifier();
        $aluno = $this->fetchTable('Alunos')->find()->where(['user_id' => $user_id ])->first();
        if (!$aluno) {
            $this->Flash->error(__('Selecione aluno'));
            return $this->redirect(['controller' => 'Inscricoes', 'action' => 'add', '?' => ['mural_estagio_id' => $mural_estagio_id]]);
        }
        
        /** Verifico o periodo do mural e comparo com o periodo da inscricao */
        $muralestagiotabela = $this->fetchTable('Muralestagios');
        $muralestagio = $muralestagiotabela->find()->where(['id' => $this->getRequest()->getData('mural_estagio_id')])->first();
        if ($muralestagio->periodo <> $this->getRequest()->getData('periodo')) {
            $this->Flash->error(__('O periodo de inscricao nao coincide com o periodo do Mural.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'view', $this->getRequest()->getData('mural_estagio_id')]);
        }

        /** Verifico se já fez inscrição para não duplicar */
        $inscricao_dupli = $this->Inscricoes->find()->where(['Inscricoes.aluno_id' => $aluno->id, 'Inscricoes.mural_estagio_id' => $muralestagio->id])->first();
        if ($inscricao_dupli) {
            $this->Flash->error(__("Inscrição já realizada"));
            return $this->redirect(['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id]);
        }

        $dados = $this->request->getData();
        $dados['registro'] = $aluno->registro;
        $dados['aluno_id'] = $aluno->id;
        $dados['mural_estagio_id'] = $this->getRequest()->getData('muralestagio_id');
        $dados['data'] = date('Y-m-d');
        $dados['periodo'] = $this->getRequest()->getData('periodo');
        
        if ($this->request->is('post')) {
            $inscricao = $this->Inscricoes->patchEntity($inscricao, $dados);
            if ($this->Inscricoes->save($inscricao)) {
                $this->Flash->success(__('The inscricao has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The inscricao could not be saved. Please, try again.'));
        }
        $this->set(compact('inscricao', 'aluno', 'periodo', 'mural_estagio_id'));
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
        $this->set(compact('inscricao'));
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
    
}
