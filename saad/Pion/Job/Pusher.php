<?php

namespace Pion\Job;

use Pion\Color;
use Pion\Config;
use Pion\Http;
use Pion\Pion;

class Pusher{

    private bool $single = false;
    private array $files = [], $to, $rm = [];
    private string $tmpZip = __DIR__.'/.tmp_file_to_send';

    public function __construct(){
        Config::initPusher();
    }

    public function push(array $cmd){
        if(isset($cmd[0]) && $cmd[0] == '*'){
            $this->single = isset($cmd[1]) && $cmd[1] == '-s';
            $this->pushAll();
            return;
        }
        $look = 'git';
        $skip = false;
        $skipRegex = '#^(';
        foreach($cmd as $p){
            if($p === '-d'){
                $look = 'dir';
                $skip = false;
                continue;
            }
            if($p === '-f'){
                $look = 'file';
                $skip = false;
                continue;
            }
            
            if($p === '-git'){
                $look = 'git';
                $skip = false;
                continue;
            }
            if($p === '-s'){
                $this->single = true;
                $skip = false;
                continue;
            }
            if($p === '--skip'){
                $skip = true;
                continue;
            }
            if($skip){
                $skipRegex.=str_replace('/', '\\/', trim($p, '\\/ ')).'|';
            }elseif($look === 'file'){
                $this->files[] = trim($p, '\\/ ');
            }elseif($look === 'dir'){
                $this->addDir(trim($p, '\\/ '));
            }else{
                echo 'Invalid argument `'.$p.'`';
                return;
            }
        }
        if($look == 'git'){
            $this->addGit();
        }
        if(isset($skipRegex[3])){
            $skipRegex = rtrim($skipRegex, '|').')#';
            $this->files = array_filter($this->files, function($item) use($skipRegex){
                return !preg_match($skipRegex, $item);
            });
        }

        $this->to = Config::mapFile($this->files);

        if($this->single){
            $this->uploadSingle();
        }else{
            $this->uploadAll();
        }
    }
    
    private function addDir($dir){
        if(Config::ignorePush($dir)){
            return;
        }

        foreach(scandir($dir) as $path){
            if($path == '.' || $path == '..'){
                continue;
            }
            if($path == '.htaccess'){
                echo '->  Ignoring '.$dir.'/.htaccess'.PHP_EOL;
                continue;
            }
            $p = $dir.'/'.$path;
            if(is_dir($p)){
                $this->addDir($p);
            }elseif(!Config::ignorePush($p)){
                $this->files[] = $p;
            }
        }
    }

    
    private function addGit(){
        exec('git ls-files -m -o --exclude-standard', $list);
        foreach($list as $path){
            if(file_exists($path)){
                if(
                    is_file($path) &&
                    basename($path) !== '.htaccess' &&
                    !Config::ignorePush($path)
                ){
                    $this->files[] = $path;
                }
            }else{
                $this->rm[] = $path;
            }
        }
    }

    private function printFiles($rm, $rrm){
        foreach($this->files as $k => $file){
            echo '(+) '.$file.PHP_EOL;
            Color::green();
            echo '    => '.$this->to[$k].PHP_EOL;
            Color::reset();
        }
        if(sizeof($rm) !== sizeof($rrm)){
            echo '(!) Deletion of files '.PHP_EOL;
            Color::red();
            echo '    => Was not success!';
            Color::reset();
            return;
        }
        foreach($rrm as $key=>$error){
            echo '(-) '.$this->rm[$key]."  \n";
            if(!$error){
                Color::yellow();
                echo '     => '.$rm[$key].PHP_EOL;
            }else{
                Color::red();
                echo '     => '.$error.PHP_EOL;
            }
            Color::reset();
        }
    }

    private function uploadSingle(){

        foreach($this->files as $k => $file){
            echo '(...) '.$file."\r";
            $res = Http::post('push', ['paths'=>json_encode(['only'=>$this->to[$k]])], ['only'=>$file]);
            echo '(+) '.$file."  \n";
            if($res->error){
                Color::red();
                echo '     => '.$res->error.PHP_EOL;
            }elseif(!isset($res->result->files) || !$res->result->files || !isset($res->result->files->only)){
                Color::red();
                echo '     => File did not post correctly!'.PHP_EOL;
            }elseif($res->result->files->only){
                Color::red();
                echo '     => '.$res->files->only.PHP_EOL;
            }else{
                Color::green();
                echo '     => '.$this->to[$k].PHP_EOL;
            }
            Color::reset();
        }
        if(sizeof($this->rm) == 0){
            return;
        }
        $rm = Config::mapFile($this->rm);
        $res = Http::post('push', ['rm'=>json_encode($rm)]);
        if($res->error){
            Color::yellow();
            echo '(-) Deletion of files'.PHP_EOL;
            Color::red();
            echo '     => '.$res->error.PHP_EOL;
        }elseif(!isset($res->result->rm)){
            Color::yellow();
            echo '(-) Deletion of files'.PHP_EOL;
            Color::red();
            echo '     => Nothing posted to delete'.PHP_EOL;
        }else foreach ($res->result->rm as $key => $error) {
            echo '(-) '.$this->rm[$key]."  \n";
            if(!$error){
                Color::yellow();
                echo '     => '.$rm[$key].PHP_EOL;
            }else{
                Color::red();
                echo '     => '.$error.PHP_EOL;
            }
            Color::reset();
        }
        Color::reset();
        
    }

    private function uploadAll(){
        $Zip = new \ZipArchive();
        if(!$Zip->open($this->tmpZip,  \ZipArchive::CREATE | \ZipArchive::OVERWRITE)){
            Color::red();
            echo "Cannot open zip.";
            Color::reset();
            return null;
        }
        foreach($this->files as $k=>$file){
            $Zip->addFile($file, $this->to[$k]);
        }
        $Zip->close();
        echo 'Please wait...';
        $rm = Config::mapFile($this->rm);
        $res = Http::post('push', [
            'rm'=>json_encode($rm)
        ], ['zip'=>$this->tmpZip]);
        @unlink($this->tmpZip);
        Pion::clear(14);

        if($res->error){
            echo "(!) Pushing files \n";
            Color::red();
            echo '    =>'.$res->error.PHP_EOL;
            Color::reset();
        }else{
            if(isset($res->result->files)){
                $this->printFiles($rm, $res->result->rm??[]);
            }
        }
    }

    private function pushAll(){
        foreach(scandir('.') as $path){
            if($path == '.' || $path == '..'){
                continue;
            }
            if($path == '.htaccess'){
                echo '->  Ignoring .htaccess'.PHP_EOL;
                continue;
            }
            if(is_dir($path)){
                $this->addDir($path);
            }elseif(!Config::ignorePush($path)){
                $this->files[] = $path;
            }
        }
        $this->to = Config::mapFile($this->files);

        if($this->single){
            $this->uploadSingle();
        }else{
            $this->uploadAll();
        }
    }


}