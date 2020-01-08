<?php 
namespace Log;
use Illuminate\Database\Capsule\Manager as DB;
/**
 * 单例模式
 * @author EDZ
 */

class Log{
	
	static private $db;
	static private $table = 'logs';

	private function __construct() {
		
	}
	
	static public function Init(){
		
		if( ! self::$db instanceof DB){
			self::$db = new DB();
			self::$db->addConnection([
					'driver'    => 'mysql',
					'host'      => '127.0.0.1',
					'database'  => 'devlog',
					'username'  => 'root',
					'password'  => '',
					'charset'   => 'utf8',
					'collation' => 'utf8_general_ci',
					'prefix'    => '',
			]);
	
			// 设置全局静态可访问DB
			self::$db->setAsGlobal();
			// 启动Eloquent （如果只使用查询构造器，这个可以注释）
			self::$db->bootEloquent();
		}
		return self::$db;
	}
	
	/**
	 * debug
	 */
	static public function debug($message,$tag = '',$data = ''){
		self::write("debug", $message, $data, $tag);
	}
	
	/**
	 * info
	 */
	static public function info($message,$tag = '',$data = ''){
		self::write("info", $message, $data, $tag);
	}
	
	/**
	 * 警告
	 * @param unknown $message
	 * @param string $tag
	 * @param string $data
	 */
	static public function warn($message,$tag = '',$data = ''){
		self::write("warn", $message, $data, $tag);
	}
	
	/**
	 * 错误
	 * @param unknown $message
	 * @param string $tag
	 * @param string $data
	 */
	static public function error($message,$tag = '',$data = ''){
		self::write("error", $message, $data, $tag);
	}
	
	/**
	 * 写入数据
	 * @param integer $type
	 * @param string $tag
	 * @param string $message
	 * @param string $data
	 * @return boolean
	 */
	static private function write($type, $message, $data, $tag){
		$debugInfo = debug_backtrace();
	
		//数据
		$data = [
			'tag'		=> $tag,
			'type'		=> $type,
			'message'	=> $message,
			'path'		=> $debugInfo[1]['file'],
			'line'		=> $debugInfo[1]['line'],
			'data'		=> $data,
			'addtime'	=> date('Y-m-d H:i:s'),
		];
		
		//写入数据库
		$query = DB::table(self::$table)->insert($data);
		if($query === FALSE){
			return false;
		}
		return true;
	}
	
	
	static public function getList($page = 1,$pageNum = 20,$type = '',$message = '',$tag = '',$data = '') {
		//写入数据库
		$tA = DB::table(self::$table)->offset(($page - 1)*$pageNum)->limit($pageNum)->get();
		return $tA;
	}
	
}