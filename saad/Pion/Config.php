<?php

namespace Pion;

class Config {
    const FILE = __DIR__ . '/.pioncfg';
    public static object $Cfg;
    private static string $active;
    private static array $pioncfg = [
        'ignore'=>[],
        'map'=>[],
        'only'=>[]
    ];
    private static object $all;

    public static array $headers = [];

    public static function set(string $key, $val, string $channel = '') {
        if (!$channel) {
            $channel = self::$active;
        }
        if (!isset(self::$all->$channel)) {
            Color::red();
            echo "Channel `$channel` doesn't exist!\n";
            Color::reset();
            return;
        }
        self::$all->$channel->$key = $val;
        file_put_contents(self::FILE, json_encode(self::$all, JSON_PRETTY_PRINT));
    }

    public static function get(string $key) {
        if (!isset(self::$Cfg->$key)) {
            return null;
        }
        return self::$Cfg->$key;
    }

    public static function channel($name){
        if(!$name){
            Color::greenBG();
            Color::red();
            echo self::$active;
            Color::resetBG();
            Color::reset();
            return;
        }
        if(!isset(self::$all->$name)){
            self::new($name, true);
        }elseif($name!=='active'){
            self::$all->active = $name;
            file_put_contents(self::FILE, json_encode(self::$all, JSON_PRETTY_PRINT));
            self::load();
        }
    }

    public static function new(string $channel, bool $active = false) {
        $cfg = [
            'src' => '.'
        ];
        $cfg['url'] = readline('Base url: ');
        if (!is_file(self::FILE)) {
            $content = json_encode([
                'active' => $channel,
                $channel => $cfg
            ], JSON_PRETTY_PRINT);
            file_put_contents(self::FILE, $content);
        } else {
            self::$all->$channel = $cfg;
            if($active){
                self::$all->active = $channel;
            }
            file_put_contents(self::FILE, json_encode(self::$all, JSON_PRETTY_PRINT));
            self::load();
        }
    }

    public static function load() {
        if (!is_file(self::FILE)) {
            Color::red();
            echo "(!)  There is no configuration file." . PHP_EOL;
            Color::blue();
            echo "Let's create one!" . PHP_EOL . PHP_EOL;
            Color::reset();
            self::new('default');
        }
        self::$all = json_decode(file_get_contents(self::FILE));
        self::$active = $active = self::$all->active;
        self::$Cfg = self::$all->$active;
        if (isset(self::$Cfg->headers)) {
            foreach (self::$Cfg->headers as $k => $v) {
                self::$headers[] = $k . ': ' . $v;
            }
        }
    }

    public static function initPusher() {
        $file = '.pioncfg';
        if (!file_exists($file)) {
            return;
        }
        $handle = fopen($file, "r");
        if (!$handle) {
            return;
        }
        $in =  null;
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if(!isset($line[0]) || $line[0] == '#'){
                continue;
            }
            if($line[0] == '['){
                $in = substr($line, 1, -1);
                continue;
            }
            if($in == 'map'){
                $kv = explode('=', $line, 2);
                if(!isset($kv[1])){
                    continue;
                }
                $k = trim($kv[0], '\\/ ').'/';
                $k = '#^'.str_replace('/', '\\/', $k).'#';
                self::$pioncfg[$in]['keys'][]=$k;
                self::$pioncfg[$in]['values'][] = trim($kv[1], '\\/ ').'/'; 
            }else{
                self::$pioncfg[$in][] = trim($line, '\\/ ');
            }
        }
        fclose($handle);
    }

    public static function mapFile(array $paths){
        if(!isset(self::$pioncfg['map']['keys']) || !self::$pioncfg['map']['keys']){
            return $paths;
        }
        return preg_replace(self::$pioncfg['map']['keys'], self::$pioncfg['map']['values'], $paths);
    }

    public static function ignorePush(string $path){
        if(sizeof(self::$pioncfg['only'])){
            $in = false;
            foreach(self::$pioncfg['only'] as $only){
                if(strpos($path, $only) === 0){
                    $in = true;
                }
            }
            if(!$in){
                return true;
            }
        }
        return in_array($path, self::$pioncfg['ignore']);
    }
}
