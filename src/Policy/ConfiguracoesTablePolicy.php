<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\ConfiguracoesTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;


class ConfiguracoesTablePolicy implements BeforePolicyInterface
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity) {
      $data = $identity->getOriginalData();
      if ($data and $data->categoria_id == 1) {
        return true;
      }
    }
    return null;
  }

  public function canIndex()
  {
    return new Result(false, 'Erro: configuracoes index policy not authorized');
  }

  public function canView()
  {
    return new Result(false, 'Erro: configuracoes view policy not authorized');
  }
  
  public function canEdit()
  {
    return new Result(false, 'Erro: configuracoes edit policy not authorized');
  }

  public function canAdd()
  {
    return new Result(false, 'Erro: configuracoes add policy not authorized');
  }

  public function canDelete()
  {
    return new Result(false, 'Erro: configuracoes delete policy not authorized');
  }
}