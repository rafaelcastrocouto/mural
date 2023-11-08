<?php

App::uses('AppController', 'Controller');

/**
 * Alunos Controller
 *
 * @property Aluno $Folhadeatividade
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 * @property RequestHandlerComponent $RequestHandler
 * @property AuthComponent $Auth
 */
class AlunosController extends AppController
{

    public $name = 'Alunos';
    public $components = array('Auth', 'Paginator', 'RequestHandler', 'Flash');
    public $paginate = array(
        'limit' => 15,
        'contain' => array('Estagiario')
    );

    public function beforeFilter()
    {

        parent::beforeFilter();
        // Admin
        if ($this->Session->read('id_categoria') == '1') {
            $this->Auth->allow();
            // $this->Session->setFlash("Administrador");
            // Estudantes
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit', 'avaliacaosolicita', 'avaliacaoverifica', 'avaliacaoedita', 'avaliacaoimprime', 'avaliacaoimprimepdf', 'folhasolicita', 'folhadeatividades', 'folhadeatividadespdf');
            // $this->Session->setFlash("Estudante");
            // Professor
        } elseif ($this->Session->read('id_categoria') == '3') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'edit', 'avaliacaosolicita', 'avaliacaoedita', 'avaliacaoimprimepdf', 'folhasolicita', 'folhadeatividadespdf');
            // $this->Session->setFlash("Professor");
            // Supervisores
        } elseif ($this->Session->read('id_categoria') == '4') {
            $this->Auth->allow('index', 'view', 'busca', 'busca_cpf', 'busca_dre', 'busca_email', 'avaliacaosolicita', 'avaliacaoverifica', 'avaliacaoedita', 'avaliacaoimprime', 'avaliacaoimprimepdf', 'folhasolicita', 'folhadeatividades', 'folhadeatividadespdf');
            // $this->Flash->success(__("Supervisor"));
        } else {
            $this->Flash->error(__("Não autorizado"));
            $this->redirect('/murals/index/');
        }
        // die(pr($this->Session->read('user')));
    }

    public function index()
    {

        $this->Paginator->settings = [
            'Aluno' => [
                'contain' => ['Estagiario' => ['Alunonovo']],
                'limit' => 10,
                'order' => [
                    'Aluno.nome' => 'asc'
                ]
            ]
        ];

        $this->set('alunos', $this->Paginator->paginate('Aluno'));
    }

    public function view($id = NULL)
    {

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query('registro');
        }

        if ($this->Session->read('id_categoria') != 1) {
            // die($this->Session->read('id_categoria'));
            if (($this->Session->read('id_categoria') == '2') && ($this->Session->read('numero'))) {
                // pr($this->Session->read('numero'));
                // die();
                if ($id) {
                    $this->Aluno->contain();
                    $verifica = $this->Aluno->find('first', [
                        'conditions' => ['Aluno.id' => $id]
                    ]);
                } elseif ($registro) {
                    $this->Aluno->contain();
                    $verifica = $this->Aluno->find('first', [
                        'conditions' => ['Aluno.registro' => $this->Session->read('numero')]
                    ]);
                }
                // pr($verifica);
                // die('verifica');
                if (!$verifica) {
                    $this->Flash->error(__("Estudante não estágiario"));
                    $this->redirect("/Alunonovos/view?registro=" . $this->Session->read('numero'));
                } else {
                    if ($this->Session->read('numero') != $verifica['Aluno']['registro']) {
                        $this->Flash->error(__("Acesso não autorizado"));
                        $this->redirect("/Murals/index");
                        die("Não autorizado");
                    }
                }
            }
        }

        /* Calculo o id a partir do registro */
        if ($registro) {
            $aluno_id = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro]
            ]);
            if ($aluno_id) {
                $id = $aluno_id['Aluno']['id'];
            } else {
                $this->Flash->error(__("Registro do estudante inexistente"));
                $this->redirect('/alunos/index');
                die();
            }
        }
        // pr('id ' . $id);
        // die('id');
        $this->Aluno->id = $id;

        if ($id):
            $this->Aluno->contain(['Estagiario' => ['Instituicao', 'Supervisor', 'Professor', 'Area']]);
            $instituicao = $this->Aluno->find('first', [
                'conditions' => ['Aluno.id' => $id]
            ]);

        elseif ($registro):
            $this->Aluno->contain(['Estagiario' => ['Instituicao', 'Supervisor', 'Professor', 'Area']]);
            $instituicao = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $registro]
            ]);
        endif;
        // pr($instituicao);
        // die();

        if (!isset($instituicao) || empty($instituicao)) {
            $this->Flash->error(__('Estudante não cadastrado em estágio'));
            // $this->redirect('/Estagiarios/index');
            // die('não cadastrado');
        }
        $this->set('estagiario', $instituicao);
    }

    /* Captura os orgaos para fazer a datalist no input do orgao */

    private function orgao()
    {

        $this->Aluno->contain();
        $orgao = $this->Aluno->find('list', [
            'fields' => ['orgao'],
            'order' => ['orgao'],
            'group' => ['orgao']
        ]);
        return $orgao;
    }

    public function planilhacress($id = NULL)
    {

        $periodo = isset($this->params['named']['periodo']) ? $this->params['named']['periodo'] : NULL;
        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }
        // pr($periodo);
        // die();
        // $periodo = '2015-2';
        // $ordem = 'Aluno.nome';

        $periodototal = $this->Aluno->Estagiario->find(
            'list',
            [
                'fields' => ['Estagiario.periodo'],
                'order' => ['Estagiario.periodo']
            ]
        );

        // pr($totalperiodo);
        // die();
        $periodosunicos = array_unique($periodototal);
        foreach ($periodosunicos as $c_periodo):
            $periodos[$c_periodo] = $c_periodo;
        endforeach;

        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $cress = $this->Aluno->Estagiario->find(
            'all',
            [
                'fields' => ['Estagiario.periodo', 'Aluno.id', 'Aluno.nome', 'Instituicao.id', 'Instituicao.instituicao', 'Instituicao.cep', 'Instituicao.endereco', 'Instituicao.bairro', 'Supervisor.nome', 'Supervisor.cress', 'Professor.nome'],
                'conditions' => ['Estagiario.periodo' => $periodo],
                'order' => ['Aluno.nome']
            ]
        );

        // pr($cress);
        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoatual', $periodo);
        // die();
    }

    public function edit($id = NULL)
    {

        if (empty($id)) {
            $aluno = $this->Aluno->find('first', [
                'conditions' => ['Aluno.registro' => $this->request->query('registro')],
                'fields' => 'id'
            ]);
            if ($aluno) {
                $id = $aluno['Aluno']['id'];
            }
        }

        if ($this->Session->read('id_categoria') != 1) {
            if ($this->Session->read('numero')) {
                $verifica = $this->Aluno->findByRegistro($this->Session->read('numero'));
                if ($id != $verifica['Aluno']['id']) {
                    $this->Flash->error(__("Acesso não autorizado"));
                    $this->redirect(['controller' => 'Murals', 'action' => 'index']);
                    die("Não autorizado");
                }
            }
        }

        $this->Aluno->id = $id;

        // Capturo os dados do orgão para enviar para o formulário
        $e_orgao = $this->Aluno->find('first', ['conditions' => ['Aluno.id' => $id]]);
        $this->set('e_orgao', $e_orgao);
        // Envio a lista dos orgãos para a datalist
        $this->set('orgaos', $this->orgao());

        if (empty($this->data)) {
            $this->data = $this->Aluno->read();
        } else {

            $duplicada = $this->Aluno->findByRegistro($this->data['Aluno']['registro']);
            if ($duplicada) {
                // $this->Session->setFlash("Este número de aluno já está cadastrado");
            }
            if ($this->Aluno->save($this->data)) {
                // print_r($this->data);
                $this->Flash->success(__("Atualizado"));

                // Verfico se esta fazendo inscricao para selecao de estagio
                $inscricao_selecao_estagio = $this->Session->read('id_instituicao');
                // Ainda nao posso apagar
                // $this->Session->delete('id_instituicao');
                // Verifico se foi chamado desde solicitacao do termo
                $registro_termo = $this->Session->read('termo');
                // $this->Session->delete('termo');

                if ($inscricao_selecao_estagio) {
                    $this->redirect(['controller' => 'Inscricaos', 'action' => 'inscricao?registro=' . $this->data['Aluno']['registro']]);
                } elseif ($registro_termo) {
                    $this->redirect(['controller' => 'Inscricaos', 'action' => 'termocompromisso?registro=' . $registro_termo]);
                } else {
                    $this->redirect(['controller' => 'Alunos', 'action' => 'view', $id]);
                }
            }
        }
    }

    public function delete($id = NULL)
    {

        // Se tem pelo menos um estagio nao excluir
        $estagiario = $this->Aluno->Estagiario->findById_aluno($id);
        if ($estagiario) {
            $this->Flash->error(__('Aluno com estágios não foi excluido. Exclua os estágios primeiro.'));
            $this->redirect(['controller' => 'Alunos', 'action' => 'view', $id]);
        } else {
            $this->Aluno->delete($id);
            $this->Flash->success(__('O registro ' . $id . ' foi excluido.'));
            // die();
            $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
        }
    }

    public function busca($nome = NULL)
    {

        // Para paginar os resultados da busca por nome
        if (isset($nome)) {
            $this->request->data['Aluno']['nome'] = $nome;
        }

        if (!empty($this->data['Aluno']['nome'])) {

            $condicaoaluno = ['Aluno.nome like' => '%' . $this->data['Aluno']['nome'] . '%'];
            $alunos = $this->Aluno->find('all', [
                'conditions' => $condicaoaluno,
                'order' => 'nome'
            ]);
            // pr($alunos);
            // die();
            // Nenhum resultado
            if (empty($alunos)) {
                $this->loadModel('Alunonovo');
                $condicaoalunonovo = ['Alunonovo.nome like' => '%' . $this->data['Aluno']['nome'] . '%'];
                $alunonovos = $this->Alunonovo->find('all', ['conditions' => $condicaoalunonovo]);
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros"));
                } else {
                    $this->Paginator->settings = ['order' => ['Alunonovo.nome ASC'], 'limit' => 10, 'conditions' => $condicaoalunonovo];
                    $this->set('alunos', $this->Paginator->paginate('Alunonovo'));
                    $this->set('nome', $this->data['Aluno']['nome']);
                }
            } else {
                $this->Paginator->settings = ['order' => 'Aluno.nome ASC', 'limit' => 10, 'conditions' => $condicaoaluno];
                $this->set('alunos', $this->Paginator->paginate('Aluno'));
                $this->set('nome', $this->data['Aluno']['nome']);
            }
        }
    }

    public function busca_dre()
    {

        if (!empty($this->data['Aluno']['registro'])) {
            $alunos = $this->Aluno->findFirstByRegistro($this->data['Aluno']['registro']);
            // pr($alunos);
            // die();
            if (empty($alunos)) {
                // Teria que buscar na tabela alunos_novos
                $this->loadModel('Alunonovo');
                $alunonovos = $this->Alunonovo->findFirstByRegistro($this->data['Aluno']['registro']);
                // pr($alunonovos);
                // die();
                if (empty($alunonovos)) {
                    $this->Flash->error(__("Não foram encontrados registros do aluno"));
                    $this->redirect(['controller' => 'Alunos', 'action' => 'busca']);
                } else {
                    // $this->set('alunos', $alunonovos);
                    // die('redirect');
                    $this->redirect(['controller' => 'Alunonovos', 'action' => 'view', $alunonovos['Alunonovo']['id']]);
                }
            } else {
                // pr($alunos['Aluno']['id']);
                // $this->set('alunos', $alunos);
                $this->redirect(['controller' => 'Alunos', 'action' => 'view', $alunos['Aluno']['id']]);
            }
        }
    }

    public function busca_email()
    {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByEmail($this->data['Aluno']['email']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do email aluno"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect(['controller' => 'Alunos', 'action' => 'busca']);
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    public function busca_cpf()
    {

        if (!empty($this->data)) {
            // pr($this->data);
            // die();
            $alunos = $this->Aluno->findAllByCpf($this->data['Aluno']['cpf']);
            // pr($alunos);
            // die("Sem registro");
            if (empty($alunos)) {
                $this->Flash->error(__("Não foram encontrados registros do CPF"));
                // Teria que buscar na tabela alunos_novos
                // $alunos_novos = $this->Aluno_novo->findAllByRegistro($this->data['Aluno']['registro']);
                // if (empty($alunos_novos)
                $this->redirect(['controller' => 'Alunos', 'action' => 'busca']);
            } else {
                $this->set('alunos', $alunos);
                // $this->set('alunos',$alunos_novos);
            }
        }
    }

    /*
     * Aluno sem estágio não pode existir.
     * Todos os alunos são estagiários.
     * Somente os Alunonovos podem estar sem estágio (porque estão cadastrados para buscar estágio).
     * Esta função está sem uso porque os alunos se cadastram como alunonovos. No ato de solicitar o termo de compromisso é que se cria e copia os dados do alunonvos para aluno.
     * A função tinha sentido no ínico do banco de dados quanto ainda não existia a tabela alunonovos.
     * Não faz sentido e está errado criar um registro de aluno sem não existe o alunonovo.
     */
    public function add($id = null)
    {
        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : null;
        if (empty($registro)) {
            $registro = $this->request->query('registro');
            if (empty($registro)) {
                $registro = isset($this->data['Aluno']['registro']) ? $this->data['Aluno']['registro'] : null;
            }
        }
        // pr($this->data);
        // pr($registro);
        // die('registro');
        if (empty($registro)) {
            $this->Flash->error(__('Informar o número de registro do estudante'));
            $this->redirect(['controller' => 'Alunonovos', 'action' => 'busca_dre']);
            die();
        }
        // pr($registro);
        // die('registro');
        // Para construir o datalist
        $this->set('orgaos', $this->orgao());

        if (!empty($this->data)) {
            // pr($this->data);

            if ($this->Aluno->save($this->data)) {
                $this->Flash->success(__('Dados do aluno inseridos!'));
                $this->redirect(['controller' => 'Alunos', 'action' => 'view', $this->Aluno->getLastInsertId()]);
                die();
            }
        }

        if ($registro) {

            // Primeiro verifico se ja nao esta cadastrado
            $this->Aluno->contain();
            $alunojacadastrado = $this->Aluno->find(
                'first',
                [
                    'conditions' => ['Aluno.registro' => $registro]
                ]
            );

            if (!empty($alunojacadastrado)) {
                $this->Flash->success(__("Aluno já cadastrado"));
                $this->redirect(['controller' => 'Alunos', 'action' => 'view', $alunojacadastrado['Aluno']['id']]);
                die();
            }

            // Logo busco entre os alunos novos
            $this->loadModel('Alunonovo');
            $this->Alunonovo->contain();
            $alunonovo = $this->Alunonovo->find(
                'first',
                [
                    'conditions' => ['Alunonovo.registro' => $registro]
                ]
            );
            // pr($alunonovo);
            // die();
            // Se não está cadastrado como alunonovo tem que fazer cadastro lá
            if (!$alunonovo) {
                $this->Flash->error(__("Fazer cadastro primeiro como Alunonovo"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'add']);
                die();
            }
        }
        // die();
        if ($registro) {
            $this->set('registro', $registro);
        }
    }

    /*
     * Funcao para solicitar avaliação do estudante
     */
    public function avaliacaosolicita()
    {

        // Verificar periodo da folha de avaliação
        // pr($this->data);
        // die('this->data');
        if ($this->data) {

            $aluno = $this->Aluno->Estagiario->find('first', [
                'contain' => ['Aluno', 'Supervisor'],
                'conditions' => ['Estagiario.registro' => $this->data['Aluno']['registro']],
                'order' => ['Estagiario.nivel DESC']
            ]);

            if ($aluno) {
                $this->redirect(['controller' => 'Alunos', 'action' => 'avaliacaoedita?instituicao_id=' . $aluno['Estagiario']['id_instituicao'] . '&registro=' . $this->data['Aluno']['registro'] . '&estagiario_id=' . $aluno['Estagiario']['id']]);
                // $this->redirect('/alunos/view?registro=' . $aluno['Aluno']['registro']);
                /*
                if (!empty($aluno['Supervisor']['id'])) {
                $this->Flash->error(__("Verificar e completar dados do supervisor da instituicao."));
                // die('Verificar dados do supervisor');
                $this->redirect('/Alunos/avaliacaoedita?supervisor_id=' . $aluno['Supervisor']['id'] . '&registro=' . $this->data['Aluno']['registro']);
                } else {
                $this->Flash->error(__("Não foi indicada a supervisora da instituicao."));
                $this->redirect('/alunos/view?registro=' . $aluno['Aluno']['registro']);
                }
                *
                */
            } else {
                $this->Flash->error(__("Não há estágios cadastrados para este estudante"));
            }
        }
    }

    /* Administrador, professor e supervisor precisam solicitar a folha */
    public function folhasolicita()
    {

        if ($this->Session->read('id_categoria') != '2') {

            // pr($this->data);
            // die();
            if (empty($this->data)) {
                $this->data = $this->Aluno->read();
            } else {
                // pr($this->data);
                // die();
                // $this->Session->write('menu_aluno', 'estagiario');
                $this->Session->write('numero', $this->data['Aluno']['registro']);
                // $this->redirect('folhadeatividades');
                $this->redirect(['action' => 'folhadeatividadespdf', $this->data['Aluno']['registro'], 'ext' => 'pdf', 'folhadeatividades']);
            }
        } elseif ($this->Session->read('id_categoria') == '2') {
            $this->redirect(['action' => 'folhadeatividadespdf', $this->Session->read('numero'), 'ext' => 'pdf', 'folhadeatividades']);
        }
    }

    public function folhadeatividades($id = null)
    {

        if ($this->Session->read('id_categoria') == '2') {
            $dre = $this->Session->read('numero');
        } else {
            $dre = $id;
        }

        if (!isset($dre) || empty($dre)) {
            $this->Flash->error(__("Precisa do númeo do DRE"));
            $this->redirect(['action' => 'folhasolicita']);
        } else {
            // pr($dre);
            $estagiario = $this->Aluno->Estagiario->find(
                'first',
                [
                    'conditions' => ['Estagiario.registro' => $dre],
                    'order' => ['Estagiario.nivel DESC']
                ]
            );
            // pr($estagiario);
            // die('estagiario');
            if (!$estagiario) {
                $this->Flash->error(__("Estudante sem estágio"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'view?registro=' . $dre]);
            }
            // $this->Session->delete('numero');
            // die('estagiario');

            $dia = strftime('%e', time());
            $mes = strftime('%B', time());
            $ano = strftime('%Y', time());

            $this->set('dia', $dia);
            $this->set('mes', $mes);
            $this->set('ano', $ano);
            $this->set('registro', $estagiario['Aluno']['registro']);
            $this->set('estudante', $estagiario['Aluno']['nome']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('cress', $estagiario['Supervisor']['cress']);
            $this->set('celular', $estagiario['Supervisor']['celular']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('professor', $estagiario['Professor']['nome']);

            $this->redirect(['action' => 'folhadeatividadespdf', $dre, 'ext' => 'pdf', $dre]);
            // echo $this->Html->link(__('Imprime PDF'), array('action' => 'folhadeatividadespdf', "?" => ["registro" => $registro], 'ext' => 'pdf', $registro));
        }
    }

    public function folhadeatividadespdf($id = null)
    {

        if ($this->Session->read('id_categoria') == '2') {
            $dre = $this->Session->read('numero');
        } else {
            $dre = $id;
        }

        if (!isset($dre) || empty($dre)) {
            $this->Flash->error(__("Precisa do númeo do DRE"));
            $this->redirect(['action' => 'folhasolicita']);
        } else {
            // pr($dre);
            $estagiario = $this->Aluno->Estagiario->find(
                'first',
                [
                    'conditions' => ['Estagiario.registro' => $dre],
                    'order' => ['Estagiario.nivel DESC']
                ]
            );
            // pr($estagiario);
            // die('estagiario');
            if (!$estagiario) {
                $this->Flash->error(__("Estudante sem estágio"));
                $this->redirect(['controller' => 'Alunonovos', 'action' => 'view?registro=' . $dre]);
            }
            // $this->Session->delete('numero');
            // die('estagiario');

            $this->set('registro', $estagiario['Aluno']['registro']);
            $this->set('estudante', $estagiario['Aluno']['nome']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('cress', $estagiario['Supervisor']['cress']);
            $this->set('celular', $estagiario['Supervisor']['celular']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('professor', $estagiario['Professor']['nome']);
            // die();
        }
    }

    public function avaliacaoedita()
    {

        $supervisor_id = isset($this->params['named']['supervisor_id']) ? $this->params['named']['supervisor_id'] : NULL;
        if (!$supervisor_id) {
            $supervisor_id = $this->request->query('supervisor_id');
        }

        $estagiario_id = isset($this->params['named']['estagiario_id']) ? $this->params['named']['estagiario_id'] : NULL;
        if (!$estagiario_id) {
            $estagiario_id = $this->request->query('estagiario_id');
        }

        $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query('registro');
        }

        $instituicao_id = isset($this->params['named']['instituicao_id']) ? $this->params['named']['instituicao_id'] : NULL;
        if (!$instituicao_id) {
            $instituicao_id = $this->request->query('instituicao_id');
        }

        if ($instituicao_id) {
            $this->loadModel('Instituicao');
            $this->Instituicao->contain(['Supervisor' => ['fields' => ['id', 'nome'], 'order' => 'nome']]);
            $supervisores = $this->Instituicao->find('first', [
                'conditions' => ['Instituicao.id' => $instituicao_id]
            ]);
        } else {
            $this->Flash->error(__('Estagiário sem instituição de estágio'));
            $this->redirect(['controller' => 'Estagiarios', 'action' => 'view?registro=' . $registro]);
        }

        foreach ($supervisores['Supervisor'] as $c_supervisor) {
            $listasupervisores[$c_supervisor['id']] = trim($c_supervisor['nome']);
        }
        asort($listasupervisores); // Ordena pelo valor

        $estagiario = $this->Aluno->Estagiario->find(
            'first',
            [
                'conditions' => ['Estagiario.id' => $estagiario_id],
                'order' => ['Estagiario.nivel DESC']
            ]
        );
        // pr($estagiario);
        // die('estagiario');

        if ($estagiario) {

            $dia = strftime('%e', time());
            $mes = strftime('%B', time());
            $ano = strftime('%Y', time());

            $this->set('dia', $dia);
            $this->set('mes', $mes);
            $this->set('ano', $ano);

            $this->set('supervisores', $listasupervisores);
            // $this->set('estagiario', $estagiario);
            $this->set('aluno', $estagiario['Aluno']['nome']);
            $this->set('estudante', $estagiario['Aluno']['nome']);
            $this->set('registro', $estagiario['Aluno']['registro']);
            $this->set('professor', $estagiario['Professor']['nome']);
            $this->set('instituicao', $estagiario['Instituicao']['instituicao']);
            $this->set('instituicao_id', $estagiario['Instituicao']['id']);
            $this->set('supervisor', $estagiario['Supervisor']['nome']);
            $this->set('supervisor_id', $estagiario['Supervisor']['id']);
            $this->set('cress', $estagiario['Supervisor']['cress']);
            $this->set('estagiario_id', $estagiario['Estagiario']['id']);
            $this->set('nivel', $estagiario['Estagiario']['nivel']);
            $this->set('periodo', $estagiario['Estagiario']['periodo']);
            // die("empty");
        }

        if (empty($this->data)) {
            // die("empty");
            $this->loadModel('Estagiario');
            $this->data = $this->Estagiario->read();
        } else {

            /* Capturo o estagiario para atualizar com o supervisor id */
            $this->Aluno->Estagiario->contain();
            $estagiario = $this->Aluno->Estagiario->find('first', [
                'conditions' => ['Estagiario.id' => $this->data['Estagiario']['estagiario_id']]
            ]);
            // pr($this->data);

            $estagiario['Estagiario']['id_supervisor'] = $this->data['Estagiario']['supervisor_id'];

            $this->loadModel('Estagiario');
            $this->Estagiario->contain();
            if ($this->Estagiario->save($estagiario)) {
                $this->Flash->success(__("Atualizado"));
                // $this->redirect(['action' => 'folhadeatividadespdf', $registro, 'ext' => 'pdf', $registro]);
                $this->redirect(['action' => 'avaliacaoimprimepdf', '?' => ['estagiario_id' => $this->data['Estagiario']['estagiario_id']], 'ext' => 'pdf', $registro]);
            } else {
                $this->Flash->error(__("Tente novamente"));
                // debug($this->Estagiario->validationErrors);
                $log = $this->Estagiario->getDataSource()->getLog(false, false);
                // debug($log);
            }
        }
    }

    public function avaliacaoimprime()
    {

        $registro = isset($this->request->params['named']['registro']) ? $this->request->params['named']['registro'] : NULL;
        if (!$registro) {
            $registro = $this->request->query('registro');
        }
        // pr($registro);
        // die('registro');

        $aluno = $this->Aluno->Estagiario->find(
            'first',
            [
                'conditions' => ['Estagiario.registro' => $registro],
                'order' => ['Estagiario.nivel DESC']
            ]
        );
        /*
        $estudante = $aluno['Aluno']['nome'];
        // $registro = $aluno['Aluno']['registro'];
        $nivel = $aluno['Estagiario']['nivel'];
        $periodo = $aluno['Estagiario']['periodo'];
        $supervisor = $aluno['Supervisor']['nome'];
        $cress = $aluno['Supervisor']['cress'];
        $telefone = $aluno['Supervisor']['telefone'];
        $celular = $aluno['Supervisor']['celular'];
        $email = $aluno['Supervisor']['email'];
        $instituicao = $aluno['Instituicao']['instituicao'];
        $endereco_inst = $aluno['Instituicao']['endereco'];
        $professor = $aluno['Professor']['nome'];
        */
        $this->set('estudante', $aluno['Aluno']['nome']);
        $this->set('registro', $registro);
        $this->set('nivel', $aluno['Estagiario']['nivel']);
        $this->set('periodo', $aluno['Estagiario']['periodo']);
        $this->set('supervisor', $aluno['Supervisor']['nome']);
        $this->set('cress', $aluno['Supervisor']['cress']);
        $this->set('telefone', $aluno['Supervisor']['telefone']);
        $this->set('celular', $aluno['Supervisor']['celular']);
        $this->set('email', $aluno['Supervisor']['email']);
        $this->set('instituicao', $aluno['Instituicao']['instituicao']);
        $this->set('endereco_inst', $aluno['Instituicao']['endereco']);
        $this->set('professor', $aluno['Professor']['nome']);
    }

    public function avaliacaoimprimepdf($id = NULL)
    {

        $estagiario = isset($this->request->params['named']['estagiario_id']) ? $this->request->params['named']['estagiario_id'] : NULL;
        if (!$estagiario) {
            $estagiario = $this->request->query('estagiario_id');
        }
        // pr($estagiario_id);
        // die('estagiario_id');

        $aluno = $this->Aluno->Estagiario->find(
            'first',
            [
                'conditions' => ['Estagiario.id' => $estagiario],
                'order' => ['Estagiario.nivel DESC']
            ]
        );
        /*
        $estudante = $aluno['Aluno']['nome'];
        $registro = $aluno['Aluno']['registro'];
        $nivel = $aluno['Estagiario']['nivel'];
        $periodo = $aluno['Estagiario']['periodo'];
        $supervisor = $aluno['Supervisor']['nome'];
        $cress = $aluno['Supervisor']['cress'];
        $telefone = $aluno['Supervisor']['telefone'];
        $celular = $aluno['Supervisor']['celular'];
        $email = $aluno['Supervisor']['email'];
        $instituicao = $aluno['Instituicao']['instituicao'];
        $endereco_inst = $aluno['Instituicao']['endereco'];
        $professor = $aluno['Professor']['nome'];
        */
        $this->set('estudante', $aluno['Aluno']['nome']);
        $this->set('registro', $aluno['Aluno']['registro']);
        $this->set('nivel', $aluno['Estagiario']['nivel']);
        $this->set('periodo', $aluno['Estagiario']['periodo']);
        $this->set('supervisor', $aluno['Supervisor']['nome']);
        $this->set('cress', $aluno['Supervisor']['cress']);
        $this->set('telefone', $aluno['Supervisor']['telefone']);
        $this->set('celular', $aluno['Supervisor']['celular']);
        $this->set('email', $aluno['Supervisor']['email']);
        $this->set('instituicao', $aluno['Instituicao']['instituicao']);
        $this->set('endereco_inst', $aluno['Instituicao']['endereco']);
        $this->set('professor', $aluno['Professor']['nome']);
    }

    public function planilhaseguro($id = null)
    {

        $periodo = isset($this->request->params['named']['periodo']) ? $this->request->params['named']['periodo'] : NULL;
        if (!$periodo) {
            $periodo = $this->request->query('periodo');
        }
        // pr($periodo);
        // die();
        // $periodo = '2015-2';
        $ordem = 'nome';

        $periodototal = $this->Aluno->Estagiario->find(
            'list',
            [
                'fields' => ['Estagiario.periodo'],
                'order' => ['Estagiario.periodo']
            ]
        );

        // pr($totalperiodo);
        // die();
        $periodosunicos = array_unique($periodototal);
        foreach ($periodosunicos as $c_periodo):
            $periodos[$c_periodo] = $c_periodo;
        endforeach;

        if (empty($periodo)) {
            $periodo = end($periodos);
        }
        // pr($periodos);

        $seguro = $this->Aluno->Estagiario->find(
            'all',
            [
                'fields' => [
                    'Aluno.id',
                    'Aluno.nome',
                    'Aluno.cpf',
                    'Aluno.nascimento',
                    'Aluno.registro',
                    'Estagiario.nivel',
                    'Estagiario.periodo',
                    'Instituicao.instituicao'
                ],
                'conditions' => ['Estagiario.periodo' => $periodo],
                'order' => ['Estagiario.nivel']
            ]
        );

        // pr($seguro);
        // die();
        $i = 0;
        foreach ($seguro as $c_seguro) {

            if ($c_seguro['Estagiario']['nivel'] == 1) {

                // Início
                $inicio = $c_seguro['Estagiario']['periodo'];

                // Final
                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $novoindicasemestre = $indicasemestre + 1;
                    $final = $novoano . "-" . $novoindicasemestre;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 2;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 2) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $novoano = $ano - 1;
                    $inicio = $novoano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $inicio = $ano . "-" . "1";
                }

                // Final
                if ($indicasemestre == 1) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . "2";
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 3) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                $novoano = $ano - 1;
                $inicio = $novoano . "-" . $indicasemestre;

                // Final
                if ($indicasemestre == 1) {
                    // $ano = $ano + 1;
                    $final = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $novoano = $ano + 1;
                    $final = $novoano . "-" . 1;
                }
            } elseif ($c_seguro['Estagiario']['nivel'] == 4) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 1;
                    $inicio = $ano . "-" . 1;
                }

                // Final
                $final = $c_seguro['Estagiario']['periodo'];

                // Estagio não obrigatório. Conto como estágio 5
            } elseif ($c_seguro['Estagiario']['nivel'] == 9) {

                $semestre = explode('-', $c_seguro['Estagiario']['periodo']);
                $ano = $semestre[0];
                $indicasemestre = $semestre[1];

                // Início
                if ($indicasemestre == 1) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 1;
                } elseif ($indicasemestre == 2) {
                    $ano = $ano - 2;
                    $inicio = $ano . "-" . 2;
                }

                // Final
                $final = $c_seguro['Estagiario']['periodo'];

                // echo "Nível: " . $c_seguro['Estagiario']['nivel'] . " Período: " . $c_seguro['Estagiario']['periodo'] . " Início: " . $inicio . " Final: " . $final . '<br>';
            }

            $t_seguro[$i]['id'] = $c_seguro['Aluno']['id'];
            $t_seguro[$i]['nome'] = $c_seguro['Aluno']['nome'];
            $t_seguro[$i]['cpf'] = $c_seguro['Aluno']['cpf'];
            $t_seguro[$i]['nascimento'] = $c_seguro['Aluno']['nascimento'];
            $t_seguro[$i]['sexo'] = "";
            $t_seguro[$i]['registro'] = $c_seguro['Aluno']['registro'];
            $t_seguro[$i]['curso'] = "UFRJ/Serviço Social";
            if ($c_seguro['Estagiario']['nivel'] == 9):
                // pr("Não");
                $t_seguro[$i]['nivel'] = "Não obrigatório";
            else:
                // pr($c_seguro['Estagiario']['nivel']);
                $t_seguro[$i]['nivel'] = $c_seguro['Estagiario']['nivel'];
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro['Estagiario']['periodo'];
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            $t_seguro[$i]['instituicao'] = $c_seguro['Instituicao']['instituicao'];
            $criterio[$i] = $t_seguro[$i][$ordem];

            $i++;
        }
        if (!empty($t_seguro)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        // pr($t_seguro);
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
        // die();
    }

    public function cargahoraria($ordem = null)
    {

        $ordem = isset($this->params['named']['ordem']) ? $this->params['named']['ordem'] : null;
        if (!$ordem) {
            $ordem = $this->request->query('ordem');
        }

        if (empty($ordem)):
            $ordem = 'q_semestres';
        endif;

        // pr($ordem);
        // die();

        $alunos = $this->Aluno->find('all');

        // pr($alunos);
        $i = 0;
        foreach ($alunos as $c_aluno):
            // pr($c_aluno);
            // if (sizeof($c_aluno['Estagiario']) >= 4):
            // pr(sizeof($c_aluno['Estagiario']));
            $cargahorariatotal[$i]['id'] = $c_aluno['Aluno']['id'];
            $cargahorariatotal[$i]['registro'] = $c_aluno['Aluno']['registro'];
            $cargahorariatotal[$i]['q_semestres'] = sizeof($c_aluno['Estagiario']);
            $carga_estagio = null;
            $y = 0; foreach ($c_aluno['Estagiario'] as $c_estagio):
                // pr($c_estagio);
                if ($c_estagio['nivel'] == 1):
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['ch'];
                    // $criterio[$i][$ordem] = $c_estagio['periodo'];
                else:
                    $cargahorariatotal[$i][$y]['ch'] = $c_estagio['ch'];
                    $cargahorariatotal[$i][$y]['nivel'] = $c_estagio['nivel'];
                    $cargahorariatotal[$i][$y]['periodo'] = $c_estagio['periodo'];
                    $carga_estagio['ch'] = $carga_estagio['ch'] + $c_estagio['ch'];
                    // $criterio[$i][$ordem] = NULL;
                endif;
                $y++;
            endforeach;
            $cargahorariatotal[$i]['ch_total'] = $carga_estagio['ch'];
            $criterio[$i] = $cargahorariatotal[$i][$ordem];
            $i++;
            //            endif;
        endforeach;

        array_multisort($criterio, SORT_ASC, $cargahorariatotal);
        // pr($cargahorariatotal);
        $this->set('cargahorariatotal', $cargahorariatotal);

        // die();
    }

    public function padroniza()
    {

        $this->Aluno->contain();
        $alunos = $this->Aluno->find('all', ['fields' => ['id', 'nome', 'email', 'endereco', 'bairro']]);
        // pr($alunos);
        // die();
        foreach ($alunos as $c_aluno):

            if ($c_aluno['Aluno']['email']):
                $email = strtolower($c_aluno['Aluno']['email']);
                $this->Aluno->query("UPDATE alunos set email = " . "\"" . $email . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno["Aluno"]['nome']):
                $nome = ucwords(strtolower($c_aluno['Aluno']['nome']));
                $this->Aluno->query("UPDATE alunos set nome = " . "\"" . $nome . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno['Aluno']['endereco']):
                $endereco = ucwords(strtolower($c_aluno['Aluno']['endereco']));
                $this->Aluno->query("UPDATE alunos set endereco = " . "\"" . $endereco . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

            if ($c_aluno['Aluno']['bairro']):
                $bairro = ucwords(strtolower($c_aluno['Aluno']['bairro']));
                $this->Aluno->query("UPDATE alunos set bairro = " . "\"" . $bairro . "\"" . " where id = " . $c_aluno['Aluno']['id']);
            endif;

        endforeach;
    }

}