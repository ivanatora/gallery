<?php
namespace App\Model\Table;

use App\Model\Entity\OldAssociation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Files Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Fs
 */
class OldAssociationsTable extends Table
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

        $this->table('associations');
    }
}
