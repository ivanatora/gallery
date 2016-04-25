<?php
namespace App\Model\Table;

use App\Model\Entity\OldFile;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Files Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Fs
 */
class OldFilesTable extends Table
{
    public static function defaultConnectionName()
    {
        return 'old';
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('files');
        $this->displayField('f_id');
        $this->primaryKey('f_id');

        $this->belongsTo('Fs', [
            'foreignKey' => 'f_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('f_filename', 'create')
            ->notEmpty('f_filename');

        $validator
            ->requirePresence('f_need_tagging', 'create')
            ->notEmpty('f_need_tagging');

        $validator
            ->integer('f_views')
            ->requirePresence('f_views', 'create')
            ->notEmpty('f_views');

        $validator
            ->dateTime('f_last_viewed')
            ->requirePresence('f_last_viewed', 'create')
            ->notEmpty('f_last_viewed');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['f_id'], 'Fs'));
        return $rules;
    }
}
