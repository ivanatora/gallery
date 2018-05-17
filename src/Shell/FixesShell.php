<?

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Database\Type;

class FixesShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Files');
    }

    public function main()
    {
        $this->out('Hello world.');
    }

    public function clearDeadRecords()
    {
        $tmp = $this->Files->find('all');

        $iCntTotal = $tmp->count();

        foreach ($tmp as $idx => $item) {
            $bExists = file_exists($item->filename);
            print "$idx/$iCntTotal {$item->filename} Exists? ".(int) $bExists."\n";

            if (!$bExists) {
                $this->Files->deleteAll(['id' => $item->id]);
            }
        }
    }

    public function fixCreated()
    {
        $tmp = $this->Files->find('all');
        foreach ($tmp as $item) {
            $sFilename     = $item->filename;
            $tsModified    = filemtime($sFilename);
            $item->created = date('Y-m-d H:i:s', $tsModified);
            $this->Files->save($item);
        }
    }

    public function crawl($sRootDir = '/home/ivanatora/ip')
    {
        $aExtensions = array('jpg', 'jpeg', 'png', 'gif');
//        $sRootDir = '/home/ivanatora/ip/'; //@TODO: get directories from db
        $tmp         = $this->Files->find('all',
            [
            'order' => ['created DESC', 'id DESC']
        ]);
//        print_r($tmp->first());
        $sFilename   = $tmp->first()->filename;
        $tsModified  = filemtime($sFilename);
        $tsNow       = time();
        $iDiffDays   = ceil(($tsNow - $tsModified) / (24 * 3600));
        print "Diff days: $iDiffDays\n";
        $sCmd        = "find $sRootDir -mtime -$iDiffDays";
        $res         = `$sCmd`;
        $aLines      = explode("\n", $res);
//        print_r($aLines);

        foreach ($aLines as $sFullpath) {
            $sExtension = pathinfo($sFullpath, PATHINFO_EXTENSION);
            if (in_array($sExtension, $aExtensions)) {
                $bFileExists = $this->Files->find('all',
                        array(
                        'conditions' => array(
                            'Files.filename' => $sFullpath,
                        )
                    ))->count();

                if (!$bFileExists) {
                    print "adding $sFullpath\n";
                    $aUpdateData  = array(
                        'filename' => $sFullpath,
                        'last_viewed' => date('Y-m-d H:i:s'),
                        'needs_tagging' => 1,
                        'cnt_views' => 0
                    );
                    print_r($aUpdateData);
                    $dateTimeType = Type::build('datetime')->useLocaleParser(false);
                    $e            = $this->Files->newEntity($aUpdateData);
//                    print_r($e);
                    $this->Files->save($e);
                    $dateTimeType->useLocaleParser(true);
                }
            }
        }
    }

    public function voteRandom()
    {
        $tmp = $this->Files->find('all')->order('rand()')->limit(20);
        foreach ($tmp as $item){
            print_r($item);
            $item->needs_tagging = 1;
            $this->Files->save($item);
        }

    }
}