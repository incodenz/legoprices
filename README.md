Yii Admin App Template
================================

REQUIREMENTS
------------

The minimum requirements by this application template are:
* [git](http://git-scm.com/downloads)
* [vagrant](https://www.vagrantup.com/downloads.html)
* [php](http://php.net)
* [composer](http://getcomposer.org/)

INSTALLATION
------------
You can install the application template using the following command:
~~~
composer global require "fxp/composer-asset-plugin:1.0.0"
composer create-project incodenz/yii-app-admin-project AppName
~~~

Now all the dependencies have been installed, next step is to configure the project.

PROJECT CONFIGURATION
-------------

### Vagrant

Open the `Vagrantfile` in the project root and update the following variables at the top of the file:

~~~
vagrant up
~~~ 

Add the hostname (`yiiapp` is default) to `/etc/hosts` to access the app using `http://yiiapp/`


Environment Configuration
-------------------------

The application environment is configured in the `environment.php` file found in the project root, 
this file must return one of the pre-defined environment variables: `prod` `stage` `test` `dev`
