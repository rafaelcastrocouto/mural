<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Configuracoes Controller
 *
 * @property \App\Model\Table\ConfiguracoesTable $Configuracoes
 * @method \App\Model\Entity\Configuracao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConfiguracoesController extends AppController {
    /**
     * beforeFilter method
     */
	//public function beforeFilter(Cake\Event\EventInterface $event) {

      //parent::beforeFilter($event);
      // Admin
      //if ($this->Session->read('id_categoria') == '1') {
      //	$this->Auth->allow();
      //	$this->Flash->usuario(__("Administrador"));
      //} else {
      //	$this->Flash->error(__("Administração: Não autorizado"));
      //}
      // die(pr($this->Session->read('user')));
	//}

	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->redirect('/configuracoes/view/1');
    }
	
    /**
     * View method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function view($id = NULL) {

		$configuracao = $this->Configuracoes->find()->first();
		$this->set('configuracao', $configuracao);
	}
  
    /**
     * Edit method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function edit($id = NULL)
    {
        $configuracao = $this->Configuracoes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $configuracao = $this->Configuracoes->patchEntity($configuracao, $this->request->getData());
            if ($this->Configuracoes->save($configuracao)) {
                $this->Flash->success(__('The configuracao has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The configuracao could not be saved. Please, try again.'));
        }
        $this->set(compact('configuracao'));
      
		//$this->Configuracao->id = $id;
		//if (empty($this->data)) {
		//	$this->data = $this->Configuracao->read();
		//} else {
		//	if ($this->Configuracao->save($this->data)) {
		//		// print_r($this->data);
		//		$this->Session->setFlash("Atualizado");
		//		$this->redirect('/Configuracaos/view/' . $id);
		//	}
		//}
	}

}

?>