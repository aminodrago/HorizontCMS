<?php

namespace App\Model;

use \App\Libs\Model;

class Plugin extends Model
{
    public $timestamps = false;

    public static function exists($plugin){
    	return file_exists("plugins/".$plugin);
    }


	public function __construct($root_dir = null,array $attributes = array()){
		
		parent::__construct($attributes); 

		isset($this->root_dir) ? : $this->root_dir = $root_dir;			
	}


    public function isInstalled(){
    	$result = self::where('root_dir',$this->root_dir)->get();

    	return $result->isEmpty();
    }


	public function getConfig($config, $default = NULL){

		isset($this->config)? : $this->config = file_exists($this->getPath()."config.php")? require($this->getPath()."config.php") : NULL;

		return isset($this->config[$config])? $this->config[$config]: $default;
	}

	public function getName(){
		return $this->getInfo('name')==NULL? $this->root_dir : $this->getInfo('name');
	}


	public function getPath(){
		return 'plugins'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR;
	}


	public function getIcon(){
		return $this->getPath()."icon.jpg";
	}

	public function getInfo($info){

		isset($this->info)? : $this->info = file_exists($this->getPath()."plugin_info.xml")? simplexml_load_file($this->getPath()."plugin_info.xml") : NULL;

		return isset($this->info->{$info})? $this->info->{$info}: NULL;
	}

	public function getShortCode(){
		return str_slug($this->root_dir,"_");
	}

	public function getWidget(){
		return (file_exists($this->getPath()."index.php"))? file_get_contents($this->getPath()."index.php") : /*NULL*/ "";
	}


}
