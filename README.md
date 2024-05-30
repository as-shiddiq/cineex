![Cineex Logo](https://kodingakan.com/cineex.png)

# Cineex  
## What is this?
Cineex is a framework that uses codeigniter 4 as its base, which makes it easy to create projects with a module system.

## What to use?
Cineex uses an additional base in its manufacture :
1. [CodeIgniter 4.3.7](https://codeigniter.com/)  
2. [NeomorphismeUI](https://themesberg.com/product/ui-kit/neumorphism-ui-kit-bootstrap) as CSS Framework
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
Installation is very easy, after create project with CodeIgniter then just use composer to install:
```console
composer require as-shiddiq/cineex
```
next, copy file `run` as `spark` with command
```console
cp vendor/as-shiddiq/cineex/run run
```

if you dont install codeigniter default, copy directory default codeigniter
```console
cp -r vendor/codeigniter4/framework/public public
```
```console
cp -r vendor/codeigniter4/framework/app app
```
```console
cp -r vendor/codeigniter4/framework/writable writable
```
then change path config on `app\Config\Paths.php`
```php
public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

```


then run the command, to replace the default codeigniter file
```console
php run replace:all
```
after that configure the .env file as desired, and then run 
```console
php run install
```
to install and run the project 😊