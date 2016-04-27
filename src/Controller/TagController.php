<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class TagController extends AppController {
    public function beforeFilter(Event $event){
        $this->loadModel('Files');
        $this->loadModel('Tags');
        $this->loadModel('FilesTags');
        return parent::beforeFilter($event);
    }

    public function index(){
        $this->viewBuilder()->layout('ajax');
    }
    
    public function stats(){
        $tmp = $this->FilesTags->find();
        $tmp->select([
            'Tags.name',
            'tag_id',
            'cnt' => $tmp->func()->count('tag_id')
        ])->group('tag_id')->order('cnt DESC')->contain(['Tags']);
        lm("DA vidim ko doide" . print_r($tmp, true));
        $aTopTags = array();
        foreach ($tmp as $item){
            lm("ITEM: " . print_r($item, true));
            $aTopTags[] = [
                'tag_id' => $item->tag_id,
                'name' => $item->tag->name,
                'cnt' => $item->cnt
            ];
        }
        $this->set('top_tags', $aTopTags);

        lm('final' . print_r($aTopTags, true));

        $this->viewBuilder()->layout('ajax');
    }

    public function generateSequence($mTagIds = 'rand'){
        $aTagIds = [];
        if ($mTagIds == 'rand'){
            $tmp = $this->Tags->find('all', [
                'order' => 'RAND()'
            ]);
            $aTagIds[] = $tmp->first()->id;
        }
        else {
            $aTagIds = explode(',', $mTagIds);
        }

        //@TODO: multiple categories

        $tmp = $this->FilesTags->find('all', [
            'conditions' => [
                'FilesTags.tag_id IN' => $aTagIds
            ],
            'order' => 'RAND()',
            'contain' => ['Files']
        ]);
        lm("PRE EEC " . print_r($tmp, true));

        $aFileIds = [];
        foreach ($tmp as $item){
            lm("FILETAG item " . print_r($item, true));
            $aFileIds[] = $item->file->id;
        }
        $this->set('data', $aFileIds);

        $this->viewBuilder()->layout('ajax');
    }
    
    public function getCloud(){
        $tmp = $this->Tags->find('all', array(
            'order' => 'Tags.id ASC'
        ));
        $result = array();
        foreach ($tmp as $item){
            $result[] = $item->toArray();
        }


        $data = array(
            'success' => true,
            'data' => $result
        );
        echo json_encode($data); exit();
    }

    public function toggle(){
        $iFileId = $this->getQueryVal('file_id');
        $iTagId = $this->getQueryVal('tag_id');

        if (! $iFileId || ! $iTagId){
            exit();
        }

        $bOldExists = $this->FilesTags->find('all', array(
            'conditions' => array(
                'FilesTags.file_id' => $iFileId,
                'FilesTags.tag_id' => $iTagId,
            )
        ))->count();

        if ($bOldExists){
            $this->FilesTags->deleteAll([
                'FilesTags.file_id' => $iFileId,
                'FilesTags.tag_id' => $iTagId,
            ]);
        }
        else {
            $aUpdateData = array(
                'file_id' => $iFileId,
                'tag_id' => $iTagId,
            );
            $e = $this->FilesTags->newEntity($aUpdateData);
            $this->FilesTags->save($e);
        }

        $data = array(
            'success' => true
        );
        echo json_encode($data); exit();
    }

    public function setIsTagged(){
        $iFileId = $this->getQueryVal('file_id');

        $tmp = $this->Files->find('all', array(
            'conditions' => array(
                'Files.id' => $iFileId
            )
        ))->first();

        if ($tmp){
            $tmp->needs_tagging = 0;
            $this->Files->save($tmp);
        }


        $data = array(
            'success' => true,
        );
        echo json_encode($data); exit();
    }

    public function getNeedsTagging(){
        $tmp = $this->Files->find('all', array(
            'conditions' => array(
                'Files.needs_tagging' => 1
            ),
            'order' => 'RAND()'
        ))->contain(['FilesTags'])->first();

        $data = array(
            'success' => true,
            'data' => $tmp->toArray()
        );
        echo json_encode($data); exit();
    }

}
