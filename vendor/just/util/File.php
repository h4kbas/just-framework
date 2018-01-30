<?php namespace Just\Util;

class File{
	public static function removedir($dir) { 
	   if (is_dir($dir)) { 
		 $objects = scandir($dir); 
		 foreach ($objects as $object) { 
		   if ($object != "." && $object != "..") { 
			 if (filetype($dir."/".$object) == "dir") self::removedir($dir."/".$object); else unlink($dir."/".$object); 
		   } 
		 } 
		 reset($objects); 
		 rmdir($dir); 
	   } 
	} 
	public static function remove($f){
		return unlink($f);
	}
	
	public static function copy($f,$d){
		return copy($f, $d);
	}
	
	public static function copyR($source, $dest){
		if(is_dir($source)) {
			$dir_handle=opendir($source);
			while($file=readdir($dir_handle)){
				if($file!="." && $file!=".."){
					if(is_dir($source.DS.$file)){
						if(!is_dir($dest.DS.$file)){
							mkdir($dest.DS.$file);
						}
						cpy($source.DS.$file, $dest.DS.$file);
					} else {
						copy($source.DS.$file, $dest.DS.$file);
					}
				}
			}
			closedir($dir_handle);
		} else {
			copy($source, $dest);
		}
	}
	
	public static function readdir($dir){
		$dh  = opendir($dir);
		$files = array();
		while (false !== ($filename = readdir($dh))) {
			$files[] = $filename;
		}
		return $files;
	}
}