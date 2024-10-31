<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 * @method \App\Model\Entity\Aluno[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlunosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $alunos = $this->paginate($this->Alunos->find('all')->contain(['Users']));
        $this->set(compact('alunos'));
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $condition = ['Alunos.id' => $id];
        
        $registro = $this->getRequest()->getQuery('registro');
        if ($registro) { $condition = ['Alunos.registro' => $registro]; }
            
        $contained = [
            'Estagiarios' => ['Instituicoes', 'Supervisores', 'Professores'], 
            'Inscricoes' => ['Muralestagios' => ['Instituicoes']], 
            'Users'
        ];

        $aluno = $this->Alunos->find('all',  ['conditions' => $condition ])->contain($contained)->first();
        
        if (!isset($aluno)) {
            $this->Flash->error(__('Nao ha registros para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }
        
        $this->set(compact('aluno'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $aluno = $this->Alunos->newEmptyEntity();
        if ($this->request->is('post')) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData());

            $registro = $this->getRequest()->getQuery('registro');
            if ($registro) {
                $estudantecadastrado = $this->Alunos->find()->where(['registro' => $registro])->first();
                if ($estudantecadastrado) {
                    $this->Flash->error(__('Aluno já cadastrado'));
                    return $this->redirect(['view' => $estudantecadastrado->id]);
                }
            }
            
            if (!$aluno->user_id) { 
                $user = $this->Authentication->getIdentity();
                $aluno->user_id = $user->get('id'); 
            }
            
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('The aluno has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aluno could not be saved. Please, try again.'));
        }
        $this->set(compact('aluno'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $aluno = $this->Alunos->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aluno = $this->Alunos->patchEntity($aluno, $this->request->getData());
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('The aluno has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The aluno could not be saved. Please, try again.'));
        }
        $this->set(compact('aluno'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $aluno = $this->Alunos->get($id, ['contain' => ['Estagiarios']]);
        
        if (sizeof($aluno->estagiarios) > 0) {
            $this->Flash->error(__('Aluno tem estagiários associados.'));
            return $this->redirect(['controller' => 'alunos', 'action' => 'view', $id]);
        }
        if ($this->Alunos->delete($aluno)) {
            $this->Flash->success(__('The aluno has been deleted.'));
        } else {
            $this->Flash->error(__('The aluno could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Planilhacress method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function planilhacress($id = null) 
    {

        $periodo = $this->getRequest()->getParam('pass') ? $this->request->getParam('pass')[0] : $this->fetchTable("Configuracoes")->find()->first()['mural_periodo_atual'];
        $this->set('periodo', $periodo);
        
        /* lista de periodos */
        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        $periodos = array_merge($periodos, array('all' => 'Todos'));
        $periodos = array_reverse($periodos);
        $this->set('periodos', $periodos);
        
        /* Se o periodo não veio anexo como parametro então o período é o último da lista dos períodos */
        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $contained = ['Alunos', 'Instituicoes', 'Supervisores', 'Professores'];
        
        $selected = ['Estagiarios.periodo', 'Alunos.id', 'Alunos.nome', 'Instituicoes.id', 'Instituicoes.instituicao', 'Instituicoes.cep', 'Instituicoes.endereco', 'Instituicoes.bairro', 'Supervisores.nome', 'Supervisores.cress', 'Professores.nome'];

        $ordered = ['Alunos.nome'];
        
        if ($periodo === 'all') {
            //ini_set('memory_limit', '2048M');
            $cress = $this->Alunos->Estagiarios->find()
                    ->contain($contained)
                    ->select($selected)
                    ->order($ordered);
        } else {
            $cress = $this->Alunos->Estagiarios->find()
                    ->contain($contained)
                    ->select($selected)
                    ->where(['Estagiarios.periodo' => $periodo])
                    ->order($ordered);
        }

        // pr($cress);
        // die();
        $this->set('cress', $this->paginate($cress));
    }

    /**
     * Planilhaseguro method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function planilhaseguro($id = null) 
    {
        
        $periodo = $this->getRequest()->getParam('pass') ? $this->request->getParam('pass')[0] : $this->fetchTable("Configuracoes")->find()->first()['mural_periodo_atual'];
        $this->set('periodo', $periodo);

        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo'
        ]);
        $periodos = $periodototal->toArray();
        $periodos = array_merge($periodos, array('all' => 'Todos'));
        $periodos = array_reverse($periodos);
        $this->set('periodos', $periodos);

        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $contained = ['Alunos', 'Instituicoes'];

        $selected = [
            'Alunos.id',
            'Alunos.nome',
            'Alunos.cpf',
            'Alunos.nascimento',
            'Alunos.registro',
            'Estagiarios.nivel',
            'Estagiarios.periodo',
            'Instituicoes.id',
            'Instituicoes.instituicao'
        ];

        $ordered = ['Estagiarios.nivel'];

        if ($periodo === 'all') {
            //ini_set('memory_limit', '2048M');
            $seguro = $this->Alunos->Estagiarios->find()
                ->contain($contained)
                ->select($selected)
                ->order($ordered);
        } else {
            $seguro = $this->Alunos->Estagiarios->find()
                ->contain($contained)
                ->where(['Estagiarios.periodo' => $periodo])
                ->select($selected)
                ->order($ordered);
        }

        //if (!empty($t_seguro)) {
        //    array_multisort($criterio, SORT_ASC, $t_seguro);
        //}
        // pr($t_seguro);
        //$this->set('t_seguro', $t_seguro);
        
        $this->set('seguro', $this->paginate($seguro));

        $instituicao = $this->fetchTable("Configuracoes")->find()->first()['instituicao'];
        $this->set('instituicao', $instituicao);
        // die();
    }
    
    /**
     * Certificadoperiodo method
     *
     * @param string|null $nome Aluno nome.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

 public function busca($nome = null) 
    {
     
        $nome = $this->getRequest()->getQuery('nome');
     
        if ($nome) {
            //pr($nome);
            //die();
            $condition = ['Alunos.nome LIKE' => '%' . $nome . '%'];
            //$condition = ['Alunos.nome' => $nome];
            $busca = $this->Alunos->find('all',  ['conditions' => $condition ])->contain(['Users']);
            // pr($busca);
            // die();
            if (iterator_count($busca) == 0) {
                // Nenhum resultado
                $this->Flash->error(__("Não foram encontrados registros"));
            } else {
                $alunos = $this->paginate($busca);
                $this->set(compact('alunos'));
            }
        }
    }
    
    /**
     * Busca_dre
     *
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function buscaDre() 
    {

        // pr($this->data);
        if (!empty($this->data['Alunos']['registro'])) {
            $alunos = $this->Alunos->find('first', [
                'conditions' => ['Alunos.registro' => $this->data['Alunos']['registro']]
            ]);
            // pr($alunos);
            // die('alunos');
                // pr($alunos);
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do aluno"));
                $this->redirect(['controller' => 'Alunoss', 'action' => 'busca_dre']);
            } else {
                $this->Flash->success(__('Estudante'));
                $this->redirect(['controller' => 'Alunos', 'action' => 'view', $alunos['Aluno']['id']]);
            }
        }
    }
    
    /**
     * Busca_email method
     *
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function busca_email() 
    {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Alunos->findAllByEmail($this->data['Alunos']['email']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do email aluno"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect(['controller' => 'Alunoss', 'action' => 'busca']);
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }
    
    /**
     * Busca_cpf method
     *
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function busca_cpf() 
    {
        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Alunos->findAllByCpf($this->data['Alunos']['cpf']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do CPF"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect(['controller' => 'Alunoss', 'action' => 'busca_cpf']);
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    
    public function certificadoperiodo($id = null) 
    {
        /**
         * Autorização. Verifica se o aluno cadastrado no Users está acessando seu próprio registro.
         */
        $option = 0;
        if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 2) {
            $aluno_id = $this->getRequest()->getAttribute('identity')['aluno_id'];
            if ($id == $aluno_id) {
                /**
                 * @var $option
                 * Para consultar a tabela alunos com o id.
                 */
                $option = "id = $aluno_id";
                // echo "Aluno Id autorizado";
            } else {
                $estudante_registro = $this->getRequest()->getAttribute('identity')['registro'];
                if ($estudante_registro == $this->getRequest()->getQuery('registro')) {
                    /**
                     * @var $option
                     * Para consultar a tabela alunos com o registro
                     */
                    $option = "Alunos.registro  =  $estudante_registro";
                    // echo "Aluno registro autorizado";
                } else {
                    // echo "Registros não coincidem" . "<br>";
                    $this->Flash->error(__('1. Operação não autorizada.'));
                    return $this->redirect(['controller' => 'Alunos', 'action' => 'certificadoperiodo?registro=' . $this->getRequest()->getAttribute('identity')['registro']]);
                    // die('Aluno não autorizado.');
                }
            }
        } elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1) {
            
            $this->Flash->info(__("Administrador autorizado"));
        } else {
            $this->Flash->error(__('2. Operação não autorizada.'));
            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            // die('Professores e Supervisores não autorizados');
        }

        /**
         * Consulto a tabela alunos com o registro ou com o id
         */
        if ($option) {
            $aluno = $this->Alunos->find()->where([$option])->first();
        } else {
            $aluno = $this->Alunos->find()->first();
        }

        
        /**
         * Calculo a partir do ingresso em que periodo o aluno esté neste momento.
         */
        /* Capturo o periodo do calendario academico atual */
        $configuracaotabela = $this->fetchTable('Configuracoes');
        $periodoacademicoatual = $configuracaotabela->find()->select(['periodo_calendario_academico'])->first();
        // pr($periodoacademicoatual);
        // die();
        /**
         * Separo o periodo em duas partes: o ano e o indicador de primeiro ou segundo semestre.
         */
        $periodo_atual = $periodoacademicoatual->periodo_calendario_academico;
        /** Capturo o periodo inicial para o cálculo dos semetres.
         *  Inicialmente coincide com o campo de ingresso.
         *  Mas pode ser alterada para fazer coincider os semestres no casos dos alunos que trancaram.
         */
        $novoperiodo = $this->getRequest()->getData('novoperiodo');
        if ($novoperiodo) {
            $periodo_inicial = $this->getRequest()->getData('novoperiodo');
        } else {
            $periodo_inicial = $aluno->ingresso;
        }

        //pr($periodo_inicial); die();
        
        //$inicial = explode('-', $periodo_inicial);
        $inicial = [$periodo_inicial, 1];
        $atual = explode('-', $periodo_atual);
        // echo $atual[0] . ' ' . $inicial[0] . '<br>';
        /**
         * Calculo o total de semestres
         */
        $semestres = (($atual[0] - $inicial[0]) + 1) * 2;
        // pr($semestres);

        /** Se começa no semestre 1 e finaliza no 2 então são anos inteiros */
        if (($inicial[1] == 1) && ($atual[1] == 2)) {
            $totalperiodos = $semestres;
        }

        /** Se começa no semestre 1 e finaliza no 1 então perdeu um semestre (o segundo semestre atual) */
        if (($inicial[1] == 1) && ($atual[1] == 1)) {
            $totalperiodos = $semestres - 1;
        }

        /** Se começa no semestre 2 e finaliza no 2 então perdeu um semestre (o primeiro semestre inicial) */
        if (($inicial[1] == 2) && ($atual[1] == 2)) {
            $totalperiodos = $semestres - 1;
        }

        /** Se começa no semestre 2 e finaliza no semestre 1 então perdeu dois semestres (o primeiro do ano inicial e o segundo do ano atual) */
        if (($inicial[1] == 2) && ($atual[1] == 1)) {
            $totalperiodos = $semestres - 2;
        }

        /** Se o período inicial é maior que o período atual então informar que há um erro */
        if ($totalperiodos <= 0) {
            $this->Flash->error(__('Error: período inicial é maior que período atual'));
        }


        if ($totalperiodos > 20) {
            $this->Flash->error(__('Error: período é maior q o permitido'));
        }

        // pr($totalperiodos);
        if (isset($this->getRequest()->getData()['novoperiodo'])) {
            $aluno->periodonovo = $this->getRequest()->getData()['novoperiodo'];
        } else {
            $aluno->periodonovo = $aluno->ingresso;
        }

        // pr($aluno);
        // die();
        $this->set('aluno', $aluno);
        $this->set('totalperiodos', $totalperiodos);
    }

    /**
     * Certificadoperiodopdf method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function certificadoperiodopdf($id = NULL) {

        $this->layout = false;
        $id = $this->getRequest()->getQuery('id');
        $totalperiodos = $this->getRequest()->getQuery('totalperiodos');

        if (is_null($id)) {
            $this->cakeError('error404');
        } else {
            $aluno = $this->Alunos->find()
                    ->contain([])
                    ->where(['Alunos.id' => $id])
                    ->first();
        }
        // pr($id);
        // pr($totalperiodos);
        // pr($aluno);
        // die('aluno');

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'declaracao_de_periodo_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
        );

        $this->set('aluno', $aluno);
        $this->set('totalperiodos', $totalperiodos);
    }

    /**
     * Cargahoraria method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function cargahoraria($ordem = null) {

        $alunos = $this->Alunos->find()->contain(['Estagiarios']);

        $this->set('alunos', $this->paginate($alunos));
    }
    
}
