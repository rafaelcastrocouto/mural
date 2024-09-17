<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Userestagio Entity
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string $categoria_id
 * @property int $numero
 * @property int|null $aluno_id
 * @property int|null $supervisor_id
 * @property int|null $professor_id
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \App\Model\Entity\Aluno $aluno
 * @property \App\Model\Entity\Supervisor $supervisor
 * @property \App\Model\Entity\Professor $professor
 */
class Userestagio extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'email' => true,
        'password' => true,
        'categoria_id' => true,
        'numero' => true,
        'timestamp' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected array $_hidden = [
        'password'
    ];
}