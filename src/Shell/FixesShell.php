<?
namespace App\Shell;

use Cake\Console\Shell;

class FixesShell extends Shell {

    public function initialize(){
        parent::initialize();
        $this->loadModel('Files');
    }

    public function main() {
        $this->out('Hello world.');
    }

    public function clearDeadRecords(){
        $tmp = $this->Files->find('all');

        $iCntTotal = $tmp->count();

        foreach ($tmp as $idx => $item){
            $bExists = file_exists($item->filename);
            print "$idx/$iCntTotal {$item->filename} Exists? ".(int)$bExists."\n";

            if (! $bExists) {
                $this->Files->deleteAll(['id' => $item->id]);
            }
        }
    }
}