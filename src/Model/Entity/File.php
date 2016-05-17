<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity.
 *
 * @property int $f_id
 * @property \App\Model\Entity\F $f
 * @property string $f_filename
 * @property string $f_need_tagging
 * @property int $f_views
 * @property \Cake\I18n\Time $f_last_viewed
 */
class File extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => true
    ];
}
