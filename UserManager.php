<?php

namespace vkabachenko\phpuser;

use yii\base\Object;
use yii\helpers\VarDumper;

class UserManager extends Object
{
    const FILENAME = 'users.php';

    /**
     * @var $_params array
     * Structure:
     * [
     *     'users' => [
     *                'user1'=> [
     *                    'password' => 'hash11',
     *                    'authkey => 'hash12'
     *                  ],
     *                 'user2' => [
     *                    'password' => 'hash21',
     *                    'authkey => 'hash22'
     *                  ],
     * ........................................
     *               ]
     * ]
     */
    private $_params;

    /**
     * @var $_file string user config file with path
     */
    private $_file;

    public $path; // alias of directory where config file exists

    /**
     * prepare array of users in init
     */
    public function init()
    {
        $this->_file = \Yii::getAlias($this->path.'/config/'.self::FILENAME);
        $this->loadFromFile();
    }

    /**
     * @param $userData array
     * structure:
     * ['user1' => [
     *   'password' => 'hash11',
     *   'authkey => 'hash12']
     * ]
     */
    public function addUser($newData)
    {
        $this->_params['users'] = array_merge($this->_params['users'],$newData);
        $this->saveToFile();
    }

    /**
     * load user data from config file
     */
    private function loadFromFile()
    {
        if (is_file($this->_file)) {
            $this->_params = require($this->_file);
        } else {
            $this->_params = ['users' => []];
        }
    }

    /**
     * save user data to config file
     */
    private  function saveToFile()
    {
        file_put_contents($this->_file, "<?php\nreturn " . VarDumper::export($this->_params) . ";\n", LOCK_EX);
    }

} 
