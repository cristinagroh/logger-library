
# Logger library exercise



This library can send logs to files, sockets, inboxes, databases and various web services depending on which handlers are defined in the application. Once the handler is created as a class and saved in the appropriate area 'app\Log\Handler\HandlerTypes' it will be selectable as a target.

## Description
The role of the project is to create a stand-alone library that has 4 declared log levels (DEBUG, INFO, WARNING, ERROR) compared to the other libraries that have 8. A log message in general is a text string with an abundance of contextual information. 
- As a first step I wanted to log all the information in the console and declare a minimum level that can be modified in runtime;
- Secondly, we wanted to expand the logging area by declaring some targets for each level;
- Thirdly, I wanted each target to have a minimum level from which it can be activated;

That said, a general config variable has been created for the minimum value to enable a log fetched from the config table. The target log manager table is to store information related to the log handler and its minimum level.

## Basic Usage

```php
<?php

use App\Log\Logger;

logger = new Logger();
$logger->log(Logger::DEBUG, 'Message from index.php');
```

## Set up

The config variable is set to 'debug' by default, it can be changed by accessing the main page. Loading it in the config is done when starting the application in AppServiceProvider.php

The target log manager table will start with the log level values ​​with the handler set to null (the target) and the minimum level set also to null, this also cand be changed by accessing the main page.

The information related to the handler is brought directly from the project structure, reading the dedicated folder and bringing the names of the files, in fact their names are selectable for the target.

## How it works

For example, we want to display a log info with the text ('test'). 

In the config, the minimum value is set to info, in our case, the log will go to the next step because it falls within the minimum value, but if it was debug, it was avoided.

After that, all the handles where the log level falls will be detected and an event will be called. If the log level doesn't fall for the value, but the handler is dedicated (this means that the id from target log manager is equal to the level of log, it has a target set but no minimum level) than this will be also called. The respective event will have a listener within which the detected handlers will be activated. Laravel's events provide a simple observer pattern implementation, allowing us to subscribe and listen for various events that occur within our application, such as logging. Laravel events are synchronous, just like the whole php language is synchronous. 

## Update
In order for all the logs to go on the created system, namely the calling of each target in which the respective log falls, the logging.php file was modified, where a new custom channel was created that goes via the log file.
