<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="instituicoes form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Instituições'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $instituicao->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $instituicao->instituicao), 'class' => 'button']
                    ) ?>
                </div>
            </aside>
            <?= $this->Form->create($instituicao) ?>
            <fieldset>
                <h3><?= __('Editando instituição_') . $instituicao->id ?></h3>
                <?php
                    echo $this->Form->control('instituicao');
                    echo $this->Form->control('area_id', ['options' => $areas, 'class' => 'form-control']);
                    echo $this->Form->control('natureza');
                    echo $this->Form->control('cnpj');
                    echo $this->Form->control('email');
                    echo $this->Form->control('url');
                    echo $this->Form->control('endereco');
                    echo $this->Form->control('bairro');
                    echo $this->Form->control('municipio');
                    echo $this->Form->control('cep');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('beneficio');
                    echo $this->Form->control('fim_de_semana');
                    echo $this->Form->control('local_inscricao');
                    echo $this->Form->control('convenio');
                    echo $this->Form->control('expira', ['empty' => true]);
                    echo $this->Form->control('seguro');
                    echo $this->Form->control('avaliacao');
                    echo $this->Form->control('observacoes');
                    echo $this->Form->control('supervisores._ids', ['options' => $supervisores]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
