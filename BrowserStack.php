<?php
/**
 * @author Akshay Agarwal
 * @website http://akshayagarwal.in
 * @license Open Source, GPL
 * @file PHP Client for BrowserStack http://browserstack.com
 */

class BrowserStack
{
    var $username;
    var $password;
    var $apiVersion;

    private static $browserStackURL = "http://api.browserstack.com";

    function query($methodName, $request, $authRequired, $requestVerb){
        $baseURL = $url = BrowserStack::$browserStackURL . '/' . $this->apiVersion . '/' . $methodName;
        $ch = curl_init($baseURL);
        // Don't include the headers in HTTP Response
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        if($authRequired){
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->username}:{$this->password}");
        }
        switch($requestVerb){
            case 'GET':
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                if(!empty($request)){
                    if(is_array($request)){
                        $fullURL = $baseURL . '?' . http_build_query($request);
                    } else {
                        $fullURL = $baseURL . "/{$request}";
                    }
                } else {
                    $fullURL = $baseURL;
                }
                curl_setopt($ch, CURLOPT_URL, $fullURL);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                $fullURL = $baseURL . "/{$request}";
                curl_setopt($ch, CURLOPT_URL, $fullURL);
                break;
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    function BrowserStack($username, $password, $apiVersion = '2'){
        $this->username = $username;
        $this->password = $password;
        $this->apiVersion = $apiVersion;
    }

    function getBrowsers(){
        return $this->query('browsers', '', true, 'GET');
    }

    function createWorker($os,$browser,$version,$url,$timeout){
        $response = $this->query('worker',
                            array('os' => $os, 'browser' => $browser, 'device' => $browser, 'version' => $version, 'url' => $url, 'timeout' => $timeout),
                            true,
                            'POST'
                           );
        return $response['id'];
    }

    function terminateWorker($instanceID){
        $response = $this->query('worker',"{$instanceID}",true,'DELETE');
        return $response['time'];
    }

    function getWorkerStatus($instanceID){
        return $this->query('worker',"{$instanceID}",true,'GET');
    }

    function getWorkers(){
        return $this->query('workers','',true,'GET');
    }
}

?>
