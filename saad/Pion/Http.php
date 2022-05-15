<?php
namespace Pion;

use Exception;

class Http{

    private static int $upLen = 0;
    
    public static function login(string $user = '', string $pass = ''){
        $url = readline('Url: ');
        if(!$user){
            $user = readline('Username or Email: ');
        }

        if(!$pass){
            $pass = readline('Password: ');
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'login'=>$user,
            'password'=>$pass
        ]);
        echo 'Please wait...';
        $res = curl_exec($ch);
        echo "\r";
        curl_close($ch);
        try {
            $json = json_decode($res);
            if(isset($json->error) && $json->error){
                Color::red();
                echo $json->error;
            }elseif(isset($json->token) && $json->token){
                Config::set('headers', ['Authorization'=>'Bearer '.$json->token]);
                Color::green();
                echo 'Alhamdulillah! Logged in successfully!';
            }else{
                Color::red();
                echo 'No token found in response!';
            }
            
            Color::reset();
        } catch (\Throwable $th) {
            echo $res;
        }
    }



    public static function get(string $url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Config::$headers);
        $res = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!$err){
            return $res;
        }
        throw new \Exception($err);
    }

    public static function progress($ch, $dltotal, $dlnow, $uptotal, $upnow){
        if($uptotal <= 0){
            return;
        }
        $per = round($upnow * 100/$uptotal);
        Color::green();
        $str = "[$per%] Uploading...\r";
        echo $str;
        Color::reset();
        if($per >= 100){
            self::$upLen = strlen($str);
        }
    }

    
    public static function rawPost(string $url, array $fields, array $files = []){
        if($files){
            foreach ($files as $key => $path) {
                $fields[$key] = new \CURLFile($path);
            }
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Config::$headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        if(sizeof($files) > 0){
            curl_setopt($ch, CURLOPT_NOPROGRESS, false);
            curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, '\Pion\Http::progress');
            echo PHP_EOL;
        }

        $res = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(self::$upLen){
            Pion::clear(self::$upLen);
            self::$upLen = 0;
        }
        if(!$err){
            return $res;
        }
        throw new \Exception($err);
    }

    public static function post (string $url, array $fields, array $files = []){
        $res = self::rawPost(Config::get('url').'/'.$url, $fields, $files);
        if(!$res){
            throw new \Exception('Empty response!');
        }
        if($res[0]!=='{'){
            Pion::clear(14);
            echo $res;
            throw new \Exception('Invalid response!');
        }
        try{
            $res = json_decode($res);
            if(!isset($res->result)){
                $res->result = false;
                $res->error = $res->error??'Unknown error happened!';
            }
            if(!isset($res->error)){
                $res->error = false;
            }
            return $res;
        }catch(\Throwable $th){
            Pion::clear(14);
            echo PHP_EOL;
            echo $res;
            throw $th;
        }
    }

}