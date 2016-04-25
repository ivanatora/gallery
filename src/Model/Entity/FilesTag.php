<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesTag Entity.
 *
 * @property int $id
 * @property int $file_id
 * @property \App\Model\Entity\File $file
 * @property int $tag_id
 * @property \App\Model\Entity\Tag $tag
 */
class FilesTag extends Entity
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
        'id' => true,
    ];
}
