<?php
class Log{
	
	
	public function __construct(){
		
		
	}
	
	
	public static function log($log,$name,$append=true){
		
		
		$date = date("d-m-Y H:i:s");
		if($append){
			$fp=fopen($_SERVER['DOCUMENT_ROOT'].'/../log/'.$name.'log','a+');
		}else{
			$fp=fopen($_SERVER['DOCUMENT_ROOT'].'/../log/'.$name.'log','w');
			
		}
		
		//$fp=fopen('gdr','x')
		fwrite($fp,'-----------------------------'.$date.'-----------------------------'.PHP_EOL.$log.PHP_EOL);
		fclose($fp) ;	
				
	}
		
}
?>