<?php
class App {

    public static $key;
    public static $_conf = false;
    protected static $_init;
    const PATH = ROOT;

    use HardcoreInfoTrait;
    use CharInfoTrait;
    use AchievementTrait;
    use HonorTrait;
//    use NewsInfoTrait;


    public static function __Init(){
        $key = isset($_GET['_key']) ? $_GET['_key'] : false;

        if(self::$key !== $key){
            header('HTTP/1.1 404 Not Found');
            header('Status: 404 Not Found');
            exit();
        }

        if(self::$_init === null){
            self::$_init = new self();
        }
        return self::$_init;
    }

    protected function __construct(){
        $file = self::PATH.'api'.DS.'config.php';
        if(is_file($file)){
            self::$_conf = require_once $file;
        }else{
            $this->error('Not Found File config!',E_USER_ERROR);
        }
    }

    private function error($msg,$type){
        if(DISPLAY_ERROR === true){
            trigger_error($msg,$type);
        }
        exit();
    }

    private function TestConnect($host,$port){
        $fp = @fsockopen($host, $port, $errno, $errstr, 10);
        if($fp){
            return true;
        }else{
            return false;
        }
    }

    protected function Connect($db){
       if($this->TestConnect(self::$_conf['host'],self::$_conf['port'])) {
           return new \medoo(array(
                   'database_type' => 'mysql',
                   'database_name' => $db,
                   'server' => self::$_conf['host'],
                   'username' => self::$_conf['user'],
                   'password' => self::$_conf['pass'],
                   'charset' => 'utf8',
                   'port' => self::$_conf['port'],
                   'option' => array(
                       \PDO::ATTR_CASE => \PDO::CASE_NATURAL
                   ))
           );
       }else{
           exit();
       }
    }
}