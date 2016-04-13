<?php

namespace vkabachenko\phpuser;

use yii\web\IdentityInterface;
use yii\base\Model;
use yii\base\NotSupportedException;

class User extends Model implements IdentityInterface
{
    public $username;
    public $password;
    public $authkey;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $userData = \Yii::$app->params['users'][$id];
        if (isset($userData)) {
            return new self([
                'username' => $id,
                'password' => $userData['password'],
                'authkey' => $userData['authkey']
            ]);
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
}
