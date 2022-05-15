<?php

namespace Pion\Job;

use Pion\Color;
use Pion\Config;
use Pion\Http;
use Pion\Pion;

trait Basic{
    

    public function url($cmd){
        if(sizeof($cmd) == 0){
            echo Config::get('url').PHP_EOL;
        }else{
            Config::set('url', $cmd[0]);
        }
    }

    
    public function perm(array $dirs){
        echo 'Please wait...';
        if(!isset($dirs[0])){
            $dirs[0] = '.';
        }
        $res = Http::post('check_perm', ['path'=>$dirs[0]]);
        $this->clear(14);
        if(!$res->result){
            Color::red();
            echo '(!) '.$res->error;
            Color::reset();
            return;
        }
        
        Color::green();
        echo '(!) '.$res->result;
        Color::reset();
    }

    public function ls(array $dirs){
        echo 'Please wait...';
        $res = Http::post('list', ['paths'=>implode('|', $dirs)]);
        $this->clear(14);
        if(!$res->result){
            Color::red();
            echo '(!) '.$res->error;
            Color::reset();
            return;
        }
        foreach ($res->result as $path=>$list) {
            echo '|--'.$path.'/'.PHP_EOL;
            foreach($list as $item){
                if($item == '.' || $item == '..'){
                    continue;
                }
                echo '   |--'.$item.PHP_EOL;
            }
        }
    }

    public function ren($paths){
        $data = [];
        $len = sizeof($paths);
        if($len == 0){
            echo 'No file specified';
            return;
        }
        if($paths[$len - 1] === '--force'){
            array_pop($paths);
            $len--;
            $force = true;
        }elseif($paths[0] === '--force'){
            array_shift($paths);
            $len--;
            $force = true;
        }else{
            $force = false;
        }

        if($len % 2 == 1){
            Color::red();
            echo 'Invalid pair of renames';
            Color::reset();
            return;
        }

        for($i=0; $i < $len; $i+=2){
            $data[$paths[$i]] = $paths[$i+1];
        }
        
        echo 'Please wait...';
        $res = Http::post('ren', ['paths'=>json_encode($data), 'force'=>$force?'true':'false']);
        Pion::clear(14);
        if($res->error){
            Color::red();
            echo '(!) '.$res->error;
            Color::reset();
        }else foreach ($res->result as $from => $to) {
            echo '[->] '.$from.PHP_EOL;
            if($to[0] == '|'){
                Color::red();
                echo '    => '.substr($to, 1).PHP_EOL;
            }else{
                Color::blue();
                echo '    => '.$to.PHP_EOL;
            }
            Color::reset();
        }
    }


    public function rm($cmd){
        $len = sizeof($cmd);
        if($len == 0){
            echo 'No file specified';
            return;
        }
        echo 'Please wait...';
        $res = Http::post('rm', [
            'path'=>$cmd[0],
            'is_dir'=> isset($cmd[1]) && $cmd[1]=='--dir'?'true':'false'
        ]);
        Pion::clear(14);
        if($res->error){
            Color::red();
            echo '(!) '.$res->error;
            Color::reset();
        }else{
            Color::yellow();
            echo '[OK] Deleted successfully !'.PHP_EOL;
            Color::reset();
        }
    }

    public function mkdir($cmd){
        $len = sizeof($cmd);
        if($len == 0){
            echo 'No path specified';
            return;
        }
        echo 'Please wait...';
        $res = Http::post('mkdir', [
            'path'=>$cmd[0]
        ]);
        Pion::clear(14);
        
        if($res->error){
            Color::red();
            echo '(!) '.$res->error;
            Color::reset();
        }else{
            Color::green();
            echo '[OK] Directory created !'.PHP_EOL;
            Color::reset();
        }
    }

    public function extract($cmd){
        $len = sizeof($cmd);
        if($len < 2){
            echo 'Invalid command! run `php pion extract <from> <to>'.PHP_EOL;
            return;
        }
        echo 'Please wait...';
        $res = Http::post('mkdir', [
            'archieve'=>$cmd[0],
            'to' => $cmd[1]
        ]);
        Pion::clear(14);
        
        if($res->error){
            Color::red();
            echo '(!) '.$res->error;
            Color::reset();
        }else{
            Color::green();
            echo '[OK] Extracted successfully !'.PHP_EOL;
            Color::reset();
        }
    }

    public function query(){
        (new Query())->query();
    }
}