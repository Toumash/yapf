
# YAPF #
Yet Another PHP Framework  
[bitbucket.org/toumash/yapf](https://bitbucket.org/Toumash/yapf/overview)

# Goal #
The goal here was to provide simple asp.net mvc like framework to start with when doing repetitive, small projects.
Its ideal for school projects, even for small companies, which want to build simple, fast and cheap interactive web sites.

## Features ##
 
 - [x] Simple MVC structure  
 - [x] Regex Routing engine (AltoRouter)  
 - [x] Templating system with stacking layouts and sections  
 - [x] Examples for everything  
 - [x] Multiple realms (subdirectories/subprojects) support `/projx/home/index`  
 
 
 **todo**  
 at this moment im using the framework in a projects/testing for bugs


## Configuration ##
 - basic configuration `app/config/configuration.php` (**samples provided**)
 - examples everywhere - you wont get lost ;\) 
 - \[OPTIONAL\] Set-up database connection data at `app/config/database.ini.php`
 - Set-up custom routing at `/app/config/routes.php`
 
 If you done everything:  
 - report issues at [bitbucket yapf project](https://bitbucket.org/Toumash/yapf/issues)  
 - **PROFIT (???)**  

## Structure ##
    +---app
    |   +---config      # routing, basic configuration 
    |   +---controller  
    |   +---helper      # your own files, which dont fall into controllers
    |   +---log         
    |   +---model 
    |   +---plugin      # 3rd party scripts
    |   \---view        # base for view files. Each controller has own folder in which 
    |       \---home    # there are files with names same as metho_names.php
    +---css
    +---images
    \---js
Every class is autoloaded by PSR-0 convention (`spl_autoload_register`). For example file
 
    namespace app\controller;
    class home_controller {...}
will be located att `app/controller` with filename home_controller.php

## Dependencies ##
This project uses AltoRouter for basic routing functionality.
https://github.com/dannyvankooten/AltoRouter