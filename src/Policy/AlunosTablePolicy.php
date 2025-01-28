<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AlunosTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class AlunosTablePolicy implements BeforePolicyInterface
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity) {
      $data = $identity->getOriginalData();
      if ($data and ( $data->categoria_id == 1 || $data->categoria_id == 3 || $data->categoria_id == 4 )) {
        return true;
      }
    }
    return null;
  }

  public function canIndex(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    return new Result(false, 'Erro: alunos index policy not authorized');
  }
  
  public function scopeIndex($user, $query)
  {
    return $query->where(['Alunos.user_id' => $user->getIdentifier()]);
  }

  public function canAdd(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    $alunocadastrado = $alunosTable->find()->where(['user_id' => $userSession->id]);

    if ($alunocadastrado->count() > 0) {
        return new Result(false, 'Erro: alunos add policy not authorized');
    } else {
      return new Result(true);
    }
    
  }
  
  public function canBusca()
  {
    return new Result(false, 'Erro: alunos busca policy not authorized');
  }

}