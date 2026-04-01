<?php

declare(strict_types=1);

$user_data = ['administrador_id'=>0,'aluno_id'=>0,'professor_id'=>0,'supervisor_id'=>0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $user_data = $user_session->getOriginalData(); }

//if (!empty($originalUser)) { pr($originalUser); }   
?>

<div class="users alternar edit content">
    
	<aside>
		<div class="nav">
            <?= $this->Html->link('Listar Usuários', '/users/index', ['role' => 'button', 'class' => 'button']) ?>
            <?php if ($user_data['administrador_id']): ?>
                <?= $this->Html->link('Buscar Usuários', '/users/buscar', ['role' => 'button', 'class' => 'button']) ?>
                <?= $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'button']) ?>
            <?php endif; ?>
		</div>
	</aside>

    <div>
        <?php if (empty($originalUser)): ?>
            <h3>Usuário não impersonado</h3>
            <?= $this->Form->create() ?>
            <?= $this->Form->control('id', ['label' => ['text' => 'Nova ID do Usuário'], 'class' => 'form-control']) ?>
            <?= $this->Form->submit('Alternar Usuário', ['type' => 'Submit', 'class' => 'button']) ?>
            <?= $this->Form->end() ?>
    
        <?php else: ?>
            <h3>Usuário impersonado</h3>
            <p>Usuário original: <?= $originalUser->email ?></p>
            <?= $this->Html->link('Restaurar Usuário', '/users/alternar?reset=true', ['role' => 'button', 'class' => 'button']) ?>
        <?php endif; ?>
    </div>
    
</div>