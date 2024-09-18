<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Muralinscricoes Model
 *
 * @property \App\Model\Table\AlunosTable&\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\MuralestagiosTable&\Cake\ORM\Association\BelongsTo $Muralestagios
 *
 * @method \App\Model\Entity\Muralinscricao newEmptyEntity()
 * @method \App\Model\Entity\Muralinscricao newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Muralinscricao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Muralinscricao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Muralinscricao findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Muralinscricao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Muralinscricao[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Muralinscricao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Muralinscricao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MuralinscricoesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('mural_inscricao');
        $this->setAlias('muralinscricoes');
        $this->setDisplayField('registro');
        $this->setPrimaryKey('id');

        $this->belongsTo('Alunos', [
            'foreignKey' => 'aluno_id',
        ]);
        $this->belongsTo('Muralestagios', [
            'foreignKey' => 'instituicao_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
                ->integer('id')
                ->allowEmptyString('id', null, 'create');
        $validator
                ->integer('registro')
                ->notEmptyString('registro');
        $validator
                ->integer('aluno_id')
                ->notEmptyString('aluno_id');

        $validator
                ->integer('alunonovo_id')
                ->notEmptyString('alunonovo_id');
        
        $validator
                ->integer('instituicao_id')
                ->notEmptyString('instituicao_id');
        
        $validator
                ->date('data')
                ->requirePresence('data', 'create')
                ->notEmptyDate('data');

        $validator
                ->scalar('periodo')
                ->maxLength('periodo', 6)
                ->notEmptyString('periodo');

        $validator
                ->dateTime('timestamp')
                ->notEmptyDateTime('timestamp');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['registro'], 'Alunos'), ['errorField' => 'registro']);
        $rules->add($rules->existsIn(['instituicao_id'], 'Muralestagios'), ['errorField' => 'instituicao_id']);

        return $rules;
    }

}
