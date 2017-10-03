<?php
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

class UserInputShell extends Shell {
    public function initialize(){
        parent::initialize();
    }
    public function main() {
　　　　//シェルを叩いたときの内容
        $this->out('以下のテーブルが利用できます');
        $this->out('[B]oards');
        $this->out('[P]eople');
       //ユーザーにどのテーブルを使用するか選択させ$tに格納
        $t = $this->in('テーブルを選択',['B','P'],'B');
        $t = strtoupper($t);
        $table = null;
        $id = $this->in('IDを入力：',null,1);
        $data = null;
        //$tの内容に応じて、switchで切り分ける
        switch($t) {
            case 'B':
                $table = 'Boards';
                $this->loadModel('Boards');
                $data = $this->Boards->get($id);
                break;
            case 'P':
                $table = 'People';
                $this->loadModel('People');
                $data = $this->People->get($id);
                break;
            default:
                $this->info("can't access Database...");
                exit();
        }
        //配列一覧を表示
        $this->out();
        $this->out("※{$table} id={$id}のレコード:");
        $this->out(print_r($data->toArray()));
    }
}
?>


<?php
// 関数に分けて記述したバージョン
namespace App\Shell;

use Cake\Console\ConsoleOutput;
use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;

class FuncUserInputShell extends Shell {

    public function initialize() {
        parent::initialize();
    }

    public function main(){
        $this->out('※以下のテーブルが利用できます。');
        $this->out('[B]oards');
        $this->out('[P]eople');
        $t = $this->in('テーブルを選択：', ['B', 'P'], 'B');
        $t = strtoupper($t);
        $n = $this->in('ID番号を入力：', null, 1);
        switch($t){
            case 'B':
                $this->boards($n);
                break;
            case 'P':
                $this->people($n);
                break;
            default:
                $this->info("can't access Database...");
                exit();
        }
    }

    public function boards($id){
        $this->loadModel('Boards');
        $data = $this->Boards->get($id);
        $this->out("※Boards id={$id}");
        $this->out(print_r($data->toArray()));
    }

    public function people($id){
        $this->loadModel('People');
        $data = $this->People->get($id);
        $this->out("※People id={$id}");
        $this->out(print_r($data->toArray()));
    }
}