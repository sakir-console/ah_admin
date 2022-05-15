<?php

namespace Pion;

use Pion\Job\Pusher;

trait Job{
    public static function readCmd(){
        $line = trim(readline('$ '));
        if(!$line){
            self::readCmd();
        }else{
            $cmd = explode(' ', $line);
            self::runCmd($cmd);
        }
    }


    public function login(){
        Http::login();
    }

    public function get(array $url){
        $url = $url[0]??'';
        if(!$url){
            $url = readline('Enter url: ');
        }
        echo Http::get($url);
    }

    public function post(array $data){
        $fields = [];
        if(!isset($data[0])){
            $url = readline('Enter url: ');
        }else{
            $url = $data[0];
            array_shift($data);
        }
        $len = sizeof($data);
        if($len > 0)for($i = 0; $i < $len; $i+=2){
            if(isset($data[$i])){
                $fields[$data[$i]] = $data[$i+1]??'';
            }
        }else while(($k = trim(readline(' Key: '))) !== ''){
            $fields[$k] = readline(" Value: ");
        }

        echo Http::rawPost($url, $fields);
    }


    public function channel($cmd){
        Config::channel($cmd[0]??false);
    }

    public function push(array $cmd){
        (new Pusher())->push($cmd);
    }

}