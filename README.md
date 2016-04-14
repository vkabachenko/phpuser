OVERVIEW
========

This extension provides user model based on user information gathered in configuration file instead of traditional database table. It may be useful in the case of one or few users in web application.

INSTALLATION
============

Either run

``` 
php composer.phar require vkabachenko/phpuser "dev-master"
```

or add

```
"vkabachenko/phpuser": "dev-master"
```

to the require section of your `composer.json`

SETUP
=====

**Prepare your console controller, say `UserController` as follows:**

```
class UserController extends \yii\console\Controller
{

    public function actions()
    {
        return [
            'add' => [
                'class' => 'vkabachenko\phpuser\AddUserAction',
                'pathAlias' => '@common'
            ],
        ];
    }
}
```

Property `pathAlias` depends on where user configuration file would be. In that case in `@common/config/users.php`.

**Run the controller's action in console**

Run 

```
php yii user/add
```

and enter username and password for the user. Appropriate data would be stored in configuration file `users.php`.

**Merge user's data as application parameter**

Merge `users.php` file with other parameters files. For example in `@common/config/main.php`

```
$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php'),
...........................................,
    require(__DIR__ . '/users.php')
);
```

**Use class `vkabachenko\phpuser\User.php` in application**

Now you can use model `vkabachenko\phpuser\User.php` for identifying user throughout the application: in `identityClass` at the `components/user` config section, in `login` action and so on. 




