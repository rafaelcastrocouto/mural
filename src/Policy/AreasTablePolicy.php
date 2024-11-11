<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AreasTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;


class AreasTablePolicy implements BeforePolicyInterface
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity->getOriginalData()->categoria_id == 1) {
      return true;
    }
    return null;
  }

  public function canIndex()
  {
    return new Result(false, 'Erro: policy not authorized');
  }

  public function canView()
  {
    return new Result(false, 'Erro: policy not authorized');
  }
  
  public function canEdit()
  {
    return new Result(false, 'Erro: policy not authorized');
  }

  public function canAdd()
  {
    return new Result(false, 'Erro: policy not authorized');
  }

  public function canDelete()
  {
    return new Result(false, 'Erro: policy not authorized');
  }
}