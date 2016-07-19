# YAPF #
Yet Another PHP Framework

## Goal ##
The goal here was to provide simple php lightweight framework to start with when doing repetivive, small projects. 
Its ideal for school projects, even for small companies, which want to build simple, fast and cheap interactive web sites.

## Installation ##
Clone the repository to your computer, configure stuff at `app/config` directory and write your app using  PHP5 MVC!

## Structure ##
    +---app
    |   +---config      # routing, db 
    |   +---controller  
    |   +---log         
    |   +---model       
    |   +---vendor      # 3rd party libs
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