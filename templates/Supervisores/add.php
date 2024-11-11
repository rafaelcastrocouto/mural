<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */

declare(strict_types=1);

$categoria_id = 0;
$session = $this->request->getAttribute('identity');

if ($session) { $categoria_id = $session->get('categoria_id'); }

?>
<div>
    <div class="column-responsive column-80">
        <div class="supervisores form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Supervisores'), ['action' => 'index'], ['class' => 'button']) ?>
                </div>
            </aside>
            <?= $this->Form->create($supervisor) ?>
            <fieldset>
                <h3><?= __('Adicionando Supervisor') ?></h3>
                <?php
                    if ($categoria_id == 1):
                        $val = $this->request->getParam('pass') ? $this->request->getParam('pass')[0] : '';
                        echo $this->Form->control('user_id', ['type' => 'number', 'value' => $val ]); 
                    else:
                        echo $this->Form->control('user_id', ['type' => 'number', 'value' => $session->get('id'), 'hidden' => true ]); 
                    endif;
                    echo $this->Form->control('nome');
                    echo $this->Form->control('cpf');
                    echo $this->Form->control('endereco');
                    echo $this->Form->control('bairro');
                    echo $this->Form->control('municipio');
                    echo $this->Form->control('cep');
                    echo $this->Form->control('codigo_tel');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('codigo_cel');
                    echo $this->Form->control('celular');
                    echo $this->Form->control('email');
                    echo $this->Form->control('escola');
                    echo $this->Form->control('ano_formatura');
                    echo $this->Form->control('cress');
                    echo $this->Form->control('regiao');
                    echo $this->Form->control('outros_estudos');
                    echo $this->Form->control('area_curso');
                    echo $this->Form->control('ano_curso');
                    echo $this->Form->control('cargo');
                    echo $this->Form->control('num_inscricao');
                    echo $this->Form->control('curso_turma');
                    echo $this->Form->control('observacoes');
                    echo $this->Form->control('instituicoes._ids', ['options' => $instituicoes]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
