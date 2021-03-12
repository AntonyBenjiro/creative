<?php


namespace Core;


use Core\Entity\File;
use Core\Entity\Get;
use Core\Entity\Post;

/**
 * Class Request
 * this must be readonly singleton data accessor
 * @package Core
 */
class Request
{
	/** @var Request */
	private static $_instance;

	/** @var Get */
	private $get;

	/** @var Post */
	private $post;

	/** @var File */
	private $file;

	protected function __construct(array $get,array $post,array $file){
		$this->get=new Get($get);
		$this->post=new Post($post);
		$this->file=new File($file);
	}

	/**
	 * Singleton accessor
	 * @return Request
	 */
	public static function get(){
		if(!self::$_instance){
			self::$_instance=new self($_GET,$_POST,$_FILES);
		}
		return self::$_instance;
	}

	/**
	 * @param $name
	 * @return string
	 */
	public function value($name){
		return $this->get->get($name);
	}

	/**
	 * @param $name
	 * @return string
	 */
	public function valuePost($name){
		return $this->post->get($name);
	}
}