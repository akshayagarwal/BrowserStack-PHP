#BrowserStack-PHP
================

A PHP Client for [BrowserStack API] (http://www.browserstack.com/automated-browser-testing-api)

Compatible with API v1.0 & v2.0

##Usage
=======

###Installation
```php
require 'BrowserStack.php';
$browserStack = new BrowserStack($username,$password);
```
Parameters
* $username: Username associated with your BrowserStack account
* $password: Password associated with your BrowserStack account

Eg:
```php
require 'BrowserStack.php';
$browserStack = new BrowserStack('foo@bar.com','foobar');
```

###Getting List of Available Browsers
```php
$browserList = $browserStack->getBrowsers();
```
Returns an associative array containing list of all supported browsers indexed by the OS name

###Creating a new Worker Instance
```php
$workerID = $browserStack->createWorker($os,$browser,$version,$url,$timeout);
```  
Creates a new worker and returns its ID for future referencing

Parameters

* $os: Name of the OS to use for the new worker. This value can be derived from result obtained in getBrowsers()
* $browser: Name of the browser/device to use in the new worker. Can be also derived from getBrowsers()
* $version: Which Version of the the specified browser to use
* $url: The URL to navigate upon worker creation
* $timeout: (optional): defaults to 300 seconds. Use 0 for "forever" (BrowserStack will kill the worker after 1,800 seconds).

Eg: 
```php
$workerID = $browserStack->createWorker('win','ie','6.0','http://akshayagarwal.in',180);
```
```php
$workerID = $browserStack->createWorker('ios','iPad','3.2','http://google.com',500);
```

###Getting the status of the worker
```php
$status = $browserStack->getWorkerStatus($workerID);
```
Parameters
* $workerID: ID of the worker obtained during createWorker() call

Returns an associative array containing the status, browser, version, os of the Worker

Eg:
```php
$status = $browserStack->getWorkerStatus(171223);
echo $status['status']; //Prints 'Running' or 'Queue'
```

###Getting a list of workers
```php
$workerList = $browserStack->getWorkers();
```

Returns an array containing list of running/queued workers alongwith their status details

###Terminating a worker
```php
$time = $browserStack->terminateWorker($workerID);
```

Parameters
* $workerID: ID of the worker obtained during createWorker() call

Terminates the worker & returns a float value containing the number of seconds the worker was running 

Eg:
```php
$time = $browserStack->terminateWorker(171223);
echo $time; //Prints 32.1123
```

## Getting in touch

For bugs, feature requests etc. drop me a line on info [at] akshayagarwal.in

