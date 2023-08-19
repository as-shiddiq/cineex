
```console
               ▒▒▒▒▒▒▒                                                                              
   ▒▒         ▒▒▒▒▒▒▒▒▒▒▒                                                                           
 ▒▓▓▓▓▒     ▒▒▒▒▒▒▒▒▒▒▒                                                                          
▒▓▓▓▓▓▓▓▒  ▒▒▒▒▒▒▒▒▒▒               ▒▓▓▓▒      ███▓                                                 
▒▓▓▓▓▓▓▓▓▓▒▒▒▒▒▒▒▒▒▒▒▒           ▓█████████▓                                                     
  ▒▓▓▓▓▓▓▓▓▓▓▒▒▒▒▒▒▒▒▒▒▒        ▓███▒   ░▓██▓  ███▒  ███▓█████▓   ▒▓██████▓   ▒▓██████▒  ▒███▒ ▒███
   ░▒▓▓▓▓▓▓▓▓▓▓▒▒▒▒▒▒▒▒▒▒▒      ███            ███▒  ███▓▒░▒███▒ ▒███▒  ▓███ ▒███▒  ▓██▓   ██████▓  
      ▒▓▓▓▓▓▓▓▓▓▒▒▒▒▒▒▒▒▒▒▒▒   ░███▒           ███▒  ███   ░▓██▓ ▓██████████ ▓██████████   ░████▓   
        ▒▓▓▓▓▓▓▓▓▓▒▒▒▒▒▒▒▒▒▒▒   ▓███▒   ▒███▓  ███▒  ███   ░▓██▓ ▒███        ▒███          ▓█████▒  
         ▓▓▓▓▓▓▓▓▓▒  ▒▒▒▒▒▒▒▒▒   ▒▓████████▒   ███▒  ███   ░▓██▓  ▒████▓███▓   ▒███▓███▓  ███▒ ▓██▓
      ░▓▓▓▓▓▓▓▓▓▓▒     ▒▒▒▒▒▒        ████      ███▒  ███    ▓██▓    ▓████▓      ▓████▓   ███     ███
     ▓▓▓▓▓▓▓▓▓▓▒         ▒▒                                                                        
     ▒▓▓▓▓▓▓▓▒ 
```

# Cineex  
## What is this?
Cineex is a framework that uses codeigniter 4 as its base, which makes it easy to create projects with a module system.

## What to use?
Cineex uses an additional base in its manufacture :
1. [CodeIgniter 4.3.7](https://codeigniter.com/)  
2. [Metronic](https://keenthemes.com/metronic) or [Bootstrap 5](https://getbootstrap.com/) CSS Framework
3. [Dompdf](https://github.com/dompdf/dompdf) for pdf creation purposes, can be replaced if needed
4. [UUID](https://github.com/ramsey/uuid) to create a uuid
5. [WEBP Convert](https://github.com/rosell-dk/webp-convert) for image to webp convertion.
6. [PHPMailer](https://github.com/PHPMailer/PHPMailer) to send email

## Why Should?
1. Has a command line (RUN) that can be used to speed up the build up your project,   
2. Ready to be used for team projects because it uses the HMVC scheme.
3. With a modular system so that modules can be used for other projects.
4. Templates can be replaced and created for other project needs, except for the dashboard there is already a user interface.
5. RestAPI ready! no need to create restapi manually, such as, create, read, update, delete, multidelete, nested arrays, even upload data
6. Authentication ready!, Login, sign up, forgot password and profile features are already available so there is no need to create them again.

## How to Use?
### Installations
Installation is very easy, just use composer :
```console
composer require as-shiddiq/cineex
```
and after everything is installed please create a new file with the name `run` without an extension like `spark` on codeigniter
```php
<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
chdir(FCPATH);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();
$app = Config\Services::codeigniter();
$app->initialize();
$cli = new \Cineex\Console();
$cli->run();
die();

```
then run the command, to replace the default codeigniter file
```console
php run replace:all

```
after that configure the .env file as desired 