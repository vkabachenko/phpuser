<?php

namespace vkabachenko\phpuser;


use yii\base\Action;

class AddUserAction extends Action
{
    public $pathAlias = '@app';

    public function run()
    {
        $userName = $this->controller->prompt(\Yii::t('app','Username'),['required' => true,]);
        $password = $this->controller->prompt(\Yii::t('app','Password'),['required' => true,]);
        $password_hash = \Yii::$app->security->generatePasswordHash($password);
        $auth_key = \Yii::$app->security->generateRandomString();
        $userData = [
            $userName => [
                'password' => $password_hash,
                'authkey' => $auth_key ]
        ];
        $manager = new UserManager(['path' => $this->pathAlias]);
        $manager->addUser($userData);
    }

} 
