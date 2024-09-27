<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
//pr($aluno);
//pr($users);
?>
<div>
    <div class="column-responsive column-80">
        <div class="alunos view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Editar Aluno'), ['action' => 'edit', $aluno->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Aluno'), ['action' => 'delete', $aluno->id], ['confirm' => __('Are you sure you want to delete {0}?', $aluno->nome), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Listar Alunos'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>aluno_<?= h($aluno->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($aluno->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($aluno->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= $aluno->email ? $this->Text->autoLinkEmails($aluno->email) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $this->Number->format($aluno->registro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpf') ?></th>
                    <td><?= h($aluno->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Identidade') ?></th>
                    <td><?= h($aluno->identidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Orgao') ?></th>
                    <td><?= h($aluno->orgao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= '(' . $aluno->codigo_telefone . ') ' . h($aluno->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= '(' . $aluno->codigo_celular . ') ' . h($aluno->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereco') ?></th>
                    <td><?= h($aluno->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cep') ?></th>
                    <td><?= h($aluno->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Municipio') ?></th>
                    <td><?= h($aluno->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($aluno->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observacoes') ?></th>
                    <td><?= h($aluno->observacoes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nascimento') ?></th>
                    <td><?= h($aluno->nascimento) ?></td>
                </tr>
            </table>
            
            <?php if (!empty($users)) : ?>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <div class="table_wrap">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Senha') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Data') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= h($user->id) ?></td>
                            <td><?= $user->email ? $this->Text->autoLinkEmails($user->email) : '' ?></td>
                            <td><?= h($user->password) ?></td>
                            <td><?= $this->Number->format($user->registro) ?></td>
                            <td><?= h($user->data) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Users', 'action' => 'view', $user->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Users', 'action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($aluno->estagiarios)) : ?>
            <div class="related">
                <h4><?= __('Related Estagiarios') ?></h4>
                <div class="table_wrap">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Ajustecurricular2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitacao') ?></th>
                            <th><?= __('Instituicao Id') ?></th>
                            <th><?= __('Supervisor Id') ?></th>
                            <th><?= __('Professor Id') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Areaestagio Id') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('Ch') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($aluno->estagiarios as $estagiario) : ?>
                        <tr>
                            <td><?= h($estagiario->id) ?></td>
                            <td><?= h($estagiario->aluno_id) ?></td>
                            <td><?= h($estagiario->registro) ?></td>
                            <td><?= h($estagiario->ajustecurricular2020) ?></td>
                            <td><?= h($estagiario->turno) ?></td>
                            <td><?= h($estagiario->nivel) ?></td>
                            <td><?= h($estagiario->tc) ?></td>
                            <td><?= h($estagiario->tc_solicitacao) ?></td>
                            <td><?= h($estagiario->instituicao_id) ?></td>
                            <td><?= h($estagiario->supervisor_id) ?></td>
                            <td><?= h($estagiario->professor_id) ?></td>
                            <td><?= h($estagiario->periodo) ?></td>
                            <td><?= h($estagiario->areaestagio_id) ?></td>
                            <td><?= h($estagiario->nota) ?></td>
                            <td><?= h($estagiario->ch) ?></td>
                            <td><?= h($estagiario->observacoes) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiario->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($aluno->inscricoes)) : ?>
            <div class="related">
                <h4><?= __('Related Inscricoes') ?></h4>
                <div>
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Muralestagio Id') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Data') ?></th>
                        </tr>
                        <?php foreach ($aluno->inscricoes as $inscricao) : ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscricao->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscricao->id)]) ?>
                            </td>
                            <td><?= h($inscricao->id) ?></td>
                            <td><?= h($inscricao->registro) ?></td>
                            <td><?= h($inscricao->aluno_id) ?></td>
                            <td><?= h($inscricao->muralestagio_id) ?></td>
                            <td><?= h($inscricao->data) ?></td>
                            <td><?= h($inscricao->periodo) ?></td>
                            <td><?= h($inscricao->timestamp) ? h($inscricao->timestamp) : '' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>