<?php

namespace Pion\Job;

use Pion\Http;
use Pion\Pion;

class Query{
    public function query(){
        echo '----- SQL Query -----'.PHP_EOL;
        $query = '';
        $del = ';';
        while ($line = readline('>>> ')) {
            if($line == 'exit'){
                return;
            }elseif(!$line){
                break;
            }elseif(preg_match('#DELIMITER+(\s*)+([^\s]+)#', $line, $m)){
                $del = $m[2];
                $query = '';
                continue;
            }elseif(($i = strpos($line, $del)) !== false){
                $query.=PHP_EOL.substr($line, 0, $i);
                break;
            }
            $query.=PHP_EOL.$line;
        }
        if(!$query){
            echo '(!) No query to run!'.PHP_EOL;
            return $this->query();
        }
        echo 'Please wait...';
        $res = Http::post('query', ['sql'=>$query]);
        Pion::clear(14);

        if($res->error){
            echo '(!) '.$res->error.PHP_EOL;
            return $this->query();
        }
        echo 'Rows affected: '.$res->result->rows.PHP_EOL;
        echo 'Execution time: '.$res->result->time.PHP_EOL;

        if(sizeof($res->result->fetch) > 0){
            $this->useFetch($res->result->fetch);
        }else{
            echo '(*) No results to fetch..'.PHP_EOL;
            return $this->query();
        }
    }

    private function useFetch($data){
        $i = -1;
        while(($cmd = readline('(*) Result > '))!='exit'){
            if($cmd=='next'){
                $i++;
                if($i > sizeof($data)){
                    break;
                }else{
                    print_r($data[$i]);
                }
            }else if($cmd=='prev'){
                $i--;
                if($i < 0){
                    continue;
                }else{
                    print_r($data[$i]);
                }
            }elseif($cmd=='all'){
                print_r($data);
                break;
            }elseif(is_numeric($cmd)){
                if($cmd > 0 && $cmd < sizeof($data)){
                    print_r($data[$cmd]);
                }
            }
        }
        $this->query();
    }
}