<?php
/**
 * @author Akshay Agarwal
 * @website http://akshayagarwal.in
 * @license Open Source, GPL
 * @file PHP Unit tests for BrowserStack class
 */

define('bsUsername', 'yourname@domain.com');
define('bsPassword', 'foobar');

require '/Users/akshay.a/IdeaProjects/BrowserStack-PHP/BrowserStack.php';

class BrowserStackTest extends PHPUnit_Framework_TestCase {

    public function testGetBrowsers(){
        $browserStack = new BrowserStack(bsUsername,bsPassword);
        $browserList = $browserStack->getBrowsers();
        $this->assertArrayHasKey('win',$browserList);
    }

    public function testCreateWorker(){
        $browserStack = new BrowserStack(bsUsername,bsPassword);
        $workerID = $browserStack->createWorker('win','ie','6.0','http://akshayagarwal.in',180);
        $this->assertNotEmpty($workerID);
        return $workerID;
    }

    /**
     * @depends testCreateWorker
     */
    public function testGetWorkerStatus($workerID){
        $browserStack = new BrowserStack(bsUsername,bsPassword);
        $status = $browserStack->getWorkerStatus($workerID);
        $this->assertArrayHasKey('status',$status);
    }

    /**
    * @depends testCreateWorker
    */
    public function testGetWorkers(){
        $browserStack = new BrowserStack(bsUsername,bsPassword);
        $workerList = $browserStack->getWorkers();
        $this->assertNotEmpty($workerList);
    }

    /**
     * @depends testCreateWorker
     */
    public function testTerminateWorker($workerID){
        $browserStack = new BrowserStack(bsUsername,bsPassword);
        $time = $browserStack->terminateWorker($workerID);
        $this->assertNotNull($time);
    }
}
