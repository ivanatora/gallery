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
class FileController extends AppController {
    public function beforeFilter(Event $event){
        $this->loadModel('Files');
        $this->loadModel('Tags');
        $this->loadModel('FilesTags');
        return parent::beforeFilter($event);
    }

    public function get($iFileId){
        $tmp = $this->Files->get($iFileId);
        //@TODO: increment views and last viewed
        
        if ($tmp){
            $tmp = $tmp->toArray();
            readfile($tmp['filename']);
        }
        exit();
    }
}
