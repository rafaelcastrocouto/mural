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
            $periodoconfiguracao = $configuracaotabela->find()->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }
        
        $user_id = $this->Authentication->getIdentifier();
        $aluno = $this->fetchTable('Alunos')->find()->where(['user_id' => $user_id ])->first();
        
        if (!$aluno) {
            $this->Flash->error(__('Erro ao selecionar aluno'));
            //$session = $this->request->getAttribute('identity');
            //if ($session->get('categoria_id') == 1) {
            //    return    $this->redirect(['controller' => 'Users', 'action' => 'alternarusuario']);
            //} else return $this->redirect(['controller' => 'Inscricoes', 'action' => 'index']);
        }
        
        /** Verifico o periodo do mural e comparo com o periodo da inscricao */
        $muralestagiotabela = $this->fetchTable('Muralestagios');

        $request_id = $this->getRequest()->getData('mural_estagio_id');

        if (!$request_id) {
            $this->Flash->error(__('Erro no identificador do mural de estagios'));
        }

        if ($request_id) {
            $muralestagio = $muralestagiotabela->find()->where(['id' => $request_id])->first();
            if ($muralestagio->periodo <> $this->getRequest()->getData('periodo')) {
                $this->Flash->error(__('O periodo de inscricao nao coincide com o periodo do Mural.'));
                //return $this->redirect(['controller' => 'Muralestagios', 'action' => 'view', $this->getRequest()->getData('mural_estagio_id')]);
            }
        }
        
        if ($aluno) {
            /** Verifico se já fez inscrição para não duplicar */
            $inscricao_dupli = $this->Inscricoes->find()->where(['Inscricoes.aluno_id' => $aluno->id, 'Inscricoes.mural_estagio_id' => $muralestagio->id])->first();
            if ($inscricao_dupli) {
                $this->Flash->error(__("Inscrição já realizada"));
                //return $this->redirect(['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id]);
            }
        

            $dados = $this->request->getData();
            $dados['registro'] = $aluno->registro;
            $dados['aluno_id'] = $aluno->id;
            $dados['mural_estagio_id'] = $this->getRequest()->getData('muralestagio_id');
            $dados['data'] = date('Y-m-d');
            $dados['periodo'] = $this->getRequest()->getData('periodo');
        }

        
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
            'contain' => ['Alunos'],
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


    /**
     * Termocompromisso method
     *
     * @param string|null $id Inscricao id.
     * @return \Cake\Http\Response|null|void Renders termocompromisso
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function termocompromisso($id = null) {

        $registro = $this->getRequest()->getQuery('registro');
        if (!$registro) {
            $this->Flash->error(__("Registro não encontrado"));
        }
            
        // pr($registro);
        // die("termocompromisso");

        /* Captura o periodo de estagio para o termo de compromisso */
        //$this->loadModel("Configuracao");
        //$configuracao = $this->Configuracao->findById('1');
        //$periodo = $configuracao['Configuracao']['termo_compromisso_periodo'];
        $periodo = $this->fetchTable("Configuracoes")->find()->first()['termo_compromisso_periodo'];

        /* Busca em estagiarios o ultimo estagio do aluno */
        $estagiario = $this->fetchTable("Estagiarios")->find('all',
                [
                    'conditions' => ['Estagiarios.registro IS' => $registro],
                    'fields' => [
                        'Estagiarios.id', 
                        'Estagiarios.periodo', 
                        'Estagiarios.turno', 
                        'Estagiarios.complemento_id', 
                        'Estagiarios.aluno_id', 
                        'Estagiarios.registro', 
                        'Estagiarios.nivel', 
                        'Estagiarios.instituicao_id', 
                        'Estagiarios.supervisor_id', 
                        'Estagiarios.professor_id', 
                       // 'Alunos.id', 
                       // 'Alunos.registro', 
                       // 'Alunos.nome', 
                       // 'Alunos.ingresso', 
                       // 'Alunos.turno'
                    ],
                    'order' => ['nivel' => 'DESC', 'periodo' => 'DESC']
                ]
        )->first();
        // pr($estagiario);
        // die();
        /* Se nao encontra nada entao eh um aluno que ainda nao eh estagiario, portanto vai cursar estagio I */
        if (empty($estagiario)) {

            /* Aluno sem estágios registrados. Inícia estágio I */
            $nivel_ultimo = 1; // Nivel eh 1
            $inserir = 0; // Inserir estagiário novo no nível I

            /* Capturo os dados do aluno na tabela alunos */
            //$this->loadModel("Alunos");
            //$this->Alunos->contain();
            $aluno = $this->fetchTable("Alunos")->find('all', [
                'conditions' => ['Alunos.registro IS' => $registro]
            ])->first();
            // pr($alunos);
            // die('alunos');
            /* Aluno novo cadastrado: copia todos os dados do alunos para a tabela aluno excluindo o id. */
            if (empty($aluno)) {
                // pr('Cadastra alunos em aluno');
                /* Busca se ja esta registrado como Aluno. O resultado normal eh que nao estaja cadastrado. */
                /* Se nao esta cadastrado, o que eh normal, entao copia para aluno excluindo o id */
                /* Excluo o id porque é uma nova inserção */
                //unset($alunos['Alunos']['id']);
                // pr($alunos);
                // die('alunos');
                //$this->Aluno->set($alunos['Alunos']);
                /* Aluno criado ainda sem o estagiario. 
                 * Se o usuário aborta a operação de inserir um estagiário então o aluno fica orfão (sem estagio) */
                //if ($this->Aluno->save()):
                //    $this->Flash->success(__("Aluno cadastrado"));
                //else:
                    // pr($this->Aluno->validationErrors);
                    // die();
                //    $this->Flash->error(__("Não foi possível finalizar o cadastro. Preencha corretamente todos os dados"));
                //    $this->redirect(['controller' => 'Alunos', 'action' => 'view', $alunos['Alunos']['id']]);
                //   die("Não cadastrado");
                //endif;
                
            //} else {
                $this->Flash->error(__("Aluno não cadastrado"));
                //$this->redirect(['controller' => 'Alunos', 'action' => 'add?registro=' . $registro]);
            }
            // Aluno estagiário
        } else {

            /* Calculo o ano de ingresso para definir se é do ajuste2020 */
            // pr(intval(substr($estagiario['Estagiario']['registro'], 1, 2)));
            if (strlen(trim($estagiario['Estagiario']['registro'])) == 9) {
                /* Se o aluno ingressou depois de 2019 entao são tres niveis de estagio, senao son 4 niveis */
                /* O calculo deveria ser realizado com o campo de inscricao e nao a partir do registro */
                if (intval(substr(trim($estagiario['Estagiario']['registro']), 1, 2)) > 19) {
                    // echo 'estudante ingressou em 2020 ou depois';
                    $estagiario['Estagiario']['ajuste2020'] = 1;
                    $ultimo_nivel_curricular = 3;
                } else {
                    $estagiario['Estagiario']['ajuste2020'] = 0;
                    $ultimo_nivel_curricular = 4;
                }
            } elseif (strlen(trim($estagiario['Estagiario']['registro'])) == 8) {
                /* Alunos anteriores ao ano de 2000 */
                $estagiario['Estagiario']['ajuste2020'] = 0;
                $ultimo_nivel_curricular = 4;
            }
            // die();
            $nivel_ultimo = null;
            /* Ultimo periodo cadastrado é menor que periodo atual então tem que cadastrar novo estágio */
            if ($estagiario['Estagiario']['periodo'] < $periodo) {

                $estagiario['Estagiario']['id'] = null;
                $inserir = 0; // Inserir

                /* Se o nivel de estagio a ser cadastrado eh menor que o ultimo nivel curricular entao aumento o nivel de estagio para o seguinte nivel */
                if ($estagiario['Estagiario']['nivel'] < $ultimo_nivel_curricular) {
                    $nivel_ultimo = $estagiario['Estagiario']['nivel'] + 1;
                    // die("Inserir novo estágio");
                /* Caso contrario, ou seja, se o nivel a ser cadastrado supera o nivel curricular, entao o aluno ja finalizou estagio curricular e agora esta fazendo estagio nao obrigatorio */    
                } elseif ($estagiario['Estagiario']['nivel'] >= $ultimo_nivel_curricular) {
                    $nivel_ultimo = 9; // estágio não obrigatório
                    // die("Inserir novo estágio não obrigatório");
                }
                // pr($nivel_ultimo);
                // die();
                /* Se o periodo cadastrado é igual ao periodo atual então o aluno está solicitando novamente o mesmo termo de compromisso */
            } elseif ($estagiario['Estagiario']['periodo'] == $periodo) {
                $nivel_ultimo = $estagiario['Estagiario']['nivel'];
                $inserir = 1; // Atualizar estagiario
                // die("Atualizar estágio");
            } else {
                $this->Flash->error(__("Período atual é menor que período de estágio cadastrado. Verifique os dados."));
                //$this->redirect(['controller' => 'inscricaos', 'action' => 'termosolicita']);
            }
            // die();
        }

        /* Capturo as instituicoes */
        //$this->loadModel('Instituicao');
        //$this->Instituicao->contain();
        $instituicoes = $this->fetchTable("Instituicoes")->find(
                'list',
                [
                    'fields' => ['Instituicoes.id', 'Instituicoes.instituicao'],
                    'order' => 'Instituicoes.instituicao',
                ]
        );
        // pr($instituicoes);

        /* Capturo os supervisores da instituicao atual */
        if (isset($estagiario['Estagiario']['instituicao_id'])) {
            // $this->Instituicao->contain('Supervisor', ['order' => 'nome']);
            $supervisores = $this->Instituicao->find(
                    'first',
                    [
                        'contain' => ['Supervisor' => ['order' => 'nome']],
                        'conditions' => ['Instituicao.id' => $estagiario['Estagiario']['instituicao_id']]
                    ]
            );

            foreach ($supervisores['Supervisor'] as $supervisor) {
                $supervisoresAtuais[$supervisor['id']] = $supervisor['nome'];
                // pr($supervisor['nome']);
            }
        }

        // Envio os dados
        $this->set('estagiario_id', isset($estagiario['Estagiario']['id']) ? $estagiario['Estagiario']['id'] : null);
        $this->set('inserir', $inserir);
        $this->set('nivel', $nivel_ultimo);
        $this->set('ingresso', isset($estagiario['Alunos']['ingresso']) ? $estagiario['Alunos']['ingresso'] : (isset($alunos['Alunos']['ingresso']) ? $alunos['Alunos']['ingresso'] : null));
        $this->set('alunoturno', isset($estagiario['Alunos']['turno']) ? $estagiario['Alunos']['turno'] : (isset($alunos['Alunos']['turno']) ? $alunos['Alunos']['turno'] : null));
        $this->set('aluno_id', isset($estagiario['Estagiario']['id_aluno']) ? $estagiario['Estagiario']['id_aluno'] : null);
        $this->set('registro', $registro);
        $this->set('aluno', isset($estagiario['Alunos']['nome']) ? $estagiario['Alunos']['nome'] : (isset($alunos['Alunos']['nome']) ? $alunos['Alunos']['nome'] : null));
        $this->set('turno', isset($turno_ultimo) ? $turno_ultimo : 'I');
        $this->set('periodo', $periodo);
        // $this->set('id_area', $id_area);
        $this->set('complemento_id', isset($estagiario['Estagiario']['complemento_id']) ? $estagiario['Estagiario']['complemento_id'] : null);
        //$this->set('alunos_id', isset($estagiario['Alunos']['id']) ? $estagiario['Alunos']['id'] : '');
        $this->set('ajuste2020', isset($estagiario['Estagiario']['ajuste2020']) ? $estagiario['Estagiario']['ajuste2020'] : 0);

        $this->set('professor_atual', isset($estagiario['Estagiario']['id_professor']) ? $estagiario['Estagiario']['id_professor'] : 0);
        $this->set('instituicao_atual', isset($estagiario['Estagiario']['id_instituicao']) ? $estagiario['Estagiario']['id_instituicao'] : 0);
        $this->set('supervisor_atual', isset($estagiario['Estagiario']['id_supervisor']) ? $estagiario['Estagiario']['id_supervisor'] : 0);

        $this->set('instituicoes', $instituicoes);
        $this->set('supervisores', isset($super_atuais) ? $super_atuais : null); // Aluno sem estaǵio não tem supervisores de instituição cadastrados
    }
    
}
