<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estagiario;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class EstagiarioPolicy implements BeforePolicyInterface
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
  
  public function canAdd()
  {
      return new Result(false, 'Erro: estagiario add policy not authorized');
  }
  
  public function canView(IdentityInterface $userSession, Estagiario $estagiarioData)
  {
    if ($this->sameUser($userSession, $estagiarioData)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: estagiario view policy not authorized');
    }
  }
  
  public function canEdit(IdentityInterface $userSession, Estagiario $estagiarioData)
  {
    if ($this->sameUser($userSession, $estagiarioData)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: estagiario edit policy not authorized');
    }
  }
  
  public function canDelete(IdentityInterface $userSession, Estagiario $estagiarioData)
  {
    return new Result(false, 'Erro: estagiario delete policy not allowed');
  }

  
  protected function sameUser(IdentityInterface $userSession, Estagiario $estagiarioData)
  {
    return ($userSession->id == $estagiarioData->aluno->user_id);
  }
  
}