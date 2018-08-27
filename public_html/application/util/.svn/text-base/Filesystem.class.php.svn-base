<?php
/**
 * Filesystem class
 *
 * @author Gabriel Guzmán
 * 
 */
class Filesystem {
	
	/**
	 * Returns the filename for use with filesystem functions (WIN hotfix)
	 *
	 * @param  string $file
	 * @return string
	 */
	static function setName($file) {
		
		if ((DIRECTORY_SEPARATOR == "\\") && ($_SESSION ['s_dbConnectionType'] != Util::DB_SQLSERVER)) {
			// hotfix: convert from latin to utf8 on windows (compatibility
			// issues with filesystem functions and UTF8)
			$file = utf8_decode ( $file );
		}
		return $file;
	}
	
	/**
	 * Encondes the filename returned by filesystem functions (WIN hotfix)
	 *
	 * @param  string $file
	 * @return string
	 */
	static function getName($file) {
		
		if ((DIRECTORY_SEPARATOR == "\\") && ($_SESSION ['s_dbConnectionType'] != Util::DB_SQLSERVER)) {
			// hotfix: convert from latin to utf8 on windows (compatibility
			// issues with filesystem functions and UTF8)
			$file = utf8_encode ( $file );
		}
		return $file;
	}
	
	/**
	 * Wrapper for PHP chmod() function
	 */
	static function chmod($filename, $mode) {
		return chmod ( self::setName ( $filename ), $mode );
	}
	
	/**
	 * Wrapper for PHP copy() function
	 */
	static function copy($source, $dest) {
		return copy ( self::setName ( $source ), self::setName ( $dest ) );
	}
	
	/**
	 * Wrapper for PHP file_exists() function
	 */
	static function file_exists($filename) {
		return file_exists ( self::setName ( $filename ) );
	}
	
	/**
	 * Wrapper for PHP filesize() function
	 */
	static function filesize($filename) {
		return filesize ( self::setName ( $filename ) );
	}
	
	/**
	 * Wrapper for PHP fopen() function
	 */
	static function fopen($filename, $mode) {
		return fopen ( self::setName ( $filename ), $mode );
	}
	
	/**
	 * Wrapper for PHP is_dir() function
	 */
	static function is_dir($filename) {
		return is_dir ( self::setName ( $filename ) );
	}
	
	/**
	 * Wrapper for PHP is_file() function
	 */
	static function is_file($filename) {
		return is_file ( self::setName ( $filename ) );
	}
	
	/**
	 * Wrapper for PHP is_link() function
	 */
	static function is_link($filename) {
		return is_link ( self::setName ( $filename ) );
	}
	
	/**
	 * Wrapper for PHP mkdir() function
	 */
	static function mkdir($pathname, $mode = 0777, $recursive = false) {
		return mkdir ( self::setName ( $pathname ), $mode, $recursive );
	}
	
	/**
	 * Wrapper for PHP opendir() function
	 */
	static function opendir($dirname) {
		return opendir ( self::setName ( $dirname ) );
	}
	
	/**
	 * Wrapper for PHP readdir() function
	 */
	static function readdir($dir_handle) {
		$file = readdir ( $dir_handle );
		if ($file) {
			// check if file is found before converting it's
			// name or we will convert bool(false) to string
			$file = self::getName ( $file );
		}
		return $file;
	}
	
	/**
	 * Wrapper for PHP rename() function
	 */
	static function rename($oldname, $newname) {
		
		$return = false;
		
		if (DIRECTORY_SEPARATOR == "/") {
			// fix: on linux, rename() returns 'false' even on success
			// in some cases (i.e. moving to mounted drives)
			setlocale ( LC_CTYPE, "en_US.UTF-8" );
			$cmd = 'mv ' . escapeshellarg ( self::setName ( $oldname ) ) . ' ' . escapeshellarg ( self::setName ( $newname ) );
			exec ( $cmd, $output, $val );
			if ($val == 0) {
				$return = true;
			}
		} else {
			if (self::file_exists ( $newname )) {
				// fix: on windows if destination file exists it will
				// raise an error and won't rename the file 
				@unlink ( self::setName ( $newname ) );
			}
			if (rename ( self::setName ( $oldname ), self::setName ( $newname ) )) {
				// fix: on windows under php 5.2 original file does not get
				// deleted on network drives
				@unlink ( self::setName ( $oldname ) );
				$return = true;
			}
		}
		
		return $return;
	
	}
	
	/**
	 * Wrapper for PHP rmdir() function
	 */
	static function rmdir($dirname) {
		return rmdir ( self::setName ( $dirname ) );
	}
	
	/**
	 * Wrapper for PHP unlink() function
	 */
	static function unlink($filename) {
		return unlink ( self::setName ( $filename ) );
	}
	
	/**
	 * Deletes files recursively
	 *
	 * @param  string  $file the file or directory
	 * @return boolean true on success
	 */
	static function delete($file) {
		
		if (self::file_exists ( $file )) {
			self::chmod ( $file, 0777 );
			if (self::is_dir ( $file )) {
				$handle = self::opendir ( $file );
				while ( $filename = self::readdir ( $handle ) ) {
					if (($filename != ".") && ($filename != "..")) {
						if (! self::delete ( $file . "/" . $filename ))
							return false;
					}
				}
				closedir ( $handle );
				if (! self::rmdir ( $file ))
					return false;
			} else {
				if (! self::unlink ( $file ))
					return false;
			}
		}
		
		return true;
	
	} // delete
	

	/**
	 * Creates directories recursively
	 *
	 * @param  string  $file the directory
	 * @param  int     $mode the access mode
	 * @return boolean true on success
	 */
	static function mkpath($path, $mode = 0700) {
		
		$path = str_replace ( "\\", "/", trim ( $path ) ); // unificación de separador del path
		$dirs = explode ( "/", $path );
		
		$thepath = "";
		foreach ( $dirs as $thedir ) {
			$thepath .= trim ( $thedir ) . "/";
			if (! self::file_exists ( $thepath )) {
				if (! self::mkdir ( $thepath, $mode ))
					return false;
			}
		}
		
		return true;
	
	} // mkpath
	

	/**
	 * Returns a human readable filesize. Added to DocManager by Juan Galdeano.
	 *
	 * @author      wesman20 (php.net)
	 * @author      Jonas John
	 * @version     0.3
	 * @link        http://www.jonasjohn.de/snippets/php/readable-filesize.htm
	 */
	static function humanFileSize($size) {
		$mod = 1024;
		$units = explode ( ' ', 'B KB MB GB TB PB' );
		for($i = 0; $size > $mod; $i ++) {
			$size /= $mod;
		}
		return round ( $size, 2 ) . ' ' . $units [$i];
	} // humanFileSize


} // Filesystem

?>