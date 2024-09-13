<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Configuracao Entity
 *
 * @property int $id
 * @property int $instituicaoestagio_id
 * @property \Cake\I18n\FrozenDate $data
 * @property string $motivo
 * @property string $responsavel
 * @property string|null $descricao
 * @property string $avaliacao
 *
 * @property \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 */
class Configuracao extends Entity
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
        'mural_periodo_atual' => true,
        'curso_turma_atual' => true,
        'curso_abertura_inscricoes' => true,
        'curso_encerramento_inscricoes' => true,
        'termo_compromisso_periodo' => true,
        'termo_compromisso_inicio' => true,
        'termo_compromisso_final' => true,
		'periodo_calendario_academico' => true
    ];
}
