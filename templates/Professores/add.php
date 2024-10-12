<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="professores form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Professores'), ['action' => 'index'], ['class' => 'button']) ?>
                </div>
            </aside>
            <?= $this->Form->create($professor) ?>
            <fieldset>
                <h3><?= __('Adicionando Professor') ?></h3>
                <?php
                    if ($categoria_id == 1):
                        $val = $this->request->getParam('pass') ? $this->request->getParam('pass')[0] : '';
                        echo $this->Form->control('user_id', ['type' => 'number', 'value' => $val ]); 
                    endif;
                    echo $this->Form->control('nome');
                    echo $this->Form->control('cpf');
                    echo $this->Form->control('siape');
                    echo $this->Form->control('datanascimento', ['empty' => true]);
                    echo $this->Form->control('localnascimento');
                    echo $this->Form->control('ddd_telefone');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('ddd_celular');
                    echo $this->Form->control('celular');
                    echo $this->Form->control('email');
                    echo $this->Form->control('homepage');
                    echo $this->Form->control('redesocial');
                    echo $this->Form->control('curriculolattes');
                    echo $this->Form->control('atualizacaolattes', ['empty' => true]);
                    echo $this->Form->control('curriculosigma');
                    echo $this->Form->control('pesquisadordgp');
                    echo $this->Form->control('formacaoprofissional');
                    echo $this->Form->control('universidadedegraduacao');
                    echo $this->Form->control('anoformacao');
                    echo $this->Form->control('mestradoarea');
                    echo $this->Form->control('mestradouniversidade');
                    echo $this->Form->control('mestradoanoconclusao');
                    echo $this->Form->control('doutoradoarea');
                    echo $this->Form->control('doutoradouniversidade');
                    echo $this->Form->control('doutoradoanoconclusao');
                    echo $this->Form->control('dataingresso', ['empty' => true]);
                    echo $this->Form->control('formaingresso');
                    echo $this->Form->control('tipocargo');
                    echo $this->Form->control('regimetrabalho');
                    echo $this->Form->control('departamento');
                    echo $this->Form->control('dataegresso', ['empty' => true]);
                    echo $this->Form->control('motivoegresso');
                    echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
