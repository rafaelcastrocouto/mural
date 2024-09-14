<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estagiarios Model
 *
 * @property \App\Model\Table\AlunosTable&\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\InstituicaoestagiosTable&\Cake\ORM\Association\BelongsTo $Instituicaoestagios
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsTo $Supervisores
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professores
 * @property \App\Model\Table\AreaestagiosTable&\Cake\ORM\Association\BelongsTo $Areaestagios
 *
 * @method \App\Model\Entity\Estagiario newEmptyEntity()
 * @method \App\Model\Entity\Estagiario newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estagiario findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Estagiario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EstagiariosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('estagiarios');
        $this->setAlias('estagiarios');
        $this->setDisplayField('registro');
        $this->setPrimaryKey('id');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'id_aluno',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Instituicaoestagios', [
            'foreignKey' => 'id_instituicao',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Supervisores', [
            'foreignKey' => 'id_supervisor',
        ]);
        $this->belongsTo('Professores', [
            'foreignKey' => 'id_professor',
        ]);
        $this->belongsTo('Areaestagios', [
            'foreignKey' => 'id_area',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('registro')
            ->notEmptyString('registro');

        $validator
            ->scalar('ajustecurricular2020')
            ->maxLength('ajustecurricular2020', 1)
            ->notEmptyString('ajustecurricular2020');

        $validator
            ->scalar('turno')
            ->maxLength('turno', 1)
            ->notEmptyString('turno');

        $validator
            ->scalar('nivel')
            ->maxLength('nivel', 1)
            ->notEmptyString('nivel');

        $validator
            ->notEmptyString('tc');

        $validator
            ->date('tc_solicitacao')
            ->allowEmptyDate('tc_solicitacao');

        $validator
            ->scalar('periodo')
            ->maxLength('periodo', 6)
            ->notEmptyString('periodo');

        $validator
            ->decimal('nota')
            ->allowEmptyString('nota');

        $validator
            ->allowEmptyString('ch');

        $validator
            ->scalar('observacoes')
            ->maxLength('observacoes', 255)
            ->allowEmptyString('observacoes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['aluno_id'], 'Alunos'), ['errorField' => 'aluno_id']);
        $rules->add($rules->existsIn(['instituicaoestagio_id'], 'Instituicaoestagios'), ['errorField' => 'instituicaoestagio_id']);
        $rules->add($rules->existsIn(['supervisor_id'], 'Supervisores'), ['errorField' => 'supervisor_id']);
        $rules->add($rules->existsIn(['professor_id'], 'Professores'), ['errorField' => 'professor_id']);
        $rules->add($rules->existsIn(['areaestagio_id'], 'Areaestagios'), ['errorField' => 'areaestagio_id']);

        return $rules;
    }
}
