<?php
/*
    This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Library General Public
    License version 2 as published by the Free Software Foundation.

    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Library General Public License for more details.

    You should have received a copy of the GNU Library General Public License
    along with this library; see the file COPYING.LIB.  If not, write to
    the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
    Boston, MA 02110-1301, USA.

    ---
    Copyright (C) 2009, Tiago Natel de Moura tiago_moura@live.com
*/

/**
 * Orion
 * {info}
 *
 * @package     Orion
 * @author      Tiago Moura <tiago_moura@live.com>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.orion-framework.org
 * @since       1.0
 * @version     $Revision: 1 $
 */

 class OrionBuilder_Files
	extends OrionBuilder
 {
	public $argv = array();
	
	public function __construct( $argv )
	{
		$this->argv = $argv;
	}
	
	public function generateHtaccess( $path )
	{
		$opts = array();
		
		for($i=0; $i<count($this->argv);$i++)
		{
			if($this->argv[$i] == '--force')
				$opts['force'] = true;
			if($this->argv[$i] == '--url-default')
				$opts[Orion::ATTR_FACTORY_URL] = Orion::ATTR_FACTORY_URL_DEFAULT;
			if($this->argv[$i] == '--url-friendly')
				$opts[Orion::ATTR_FACTORY_URL] = Orion::ATTR_FACTORY_URL_FRIENDLY;
		}
		if( empty($opts[Orion::ATTR_FACTORY_URL]) )
			$opts[Orion::ATTR_FACTORY_URL] = Orion::ATTR_FACTORY_URL_FRIENDLY;
			
		$this->_generateHtaccess( $path, $opts );
	}
	
	private function _generateHtaccess( $path, $opts = array() )
	{
		$q[]	= "#\tHTACCESS";
		$q[]	= "#\tAuto-Generated by Orion Framework.";
		$q[]	= "#\t";
		$q[]	= "RewriteCond %{REQUEST_FILENAME} !-f";
		$q[]	= "RewriteCond %{REQUEST_FILENAME} !-d";
		if( $opts[Orion::ATTR_FACTORY_URL] == Orion::ATTR_FACTORY_URL_FRIENDLY )
		{
			$q[]	= "RewriteRule .(/)?$ index.php";
		}
		
		$file = $path . DIRECTORY_SEPARATOR . '.htaccess';
		if(! file_exists($path) )
			if(mkdir($path) !== FALSE)
				printf("directory created: ".$path);
			else {
				printf("Não foi possivel criar o diretório: %s\n",$path);
				exit(1);
			}
		if(! file_exists($file) )
		{
			$fp = fopen($file, "w");
			$content = implode("\n", $q);
			if( fwrite($fp, $content) !== FALSE )
				printf("file created: .htaccess\n");
		} else {
			for($i=0;$i<count($this->argv);$i++)
				if($this->argv[$i] == '--force')
					$force = true;
			if($force == true)
			{
				/** sobrescrever */
				$fp = fopen($file, "w");
				$content = implode('\n', $q);
				if( fwrite($fp, $content) !== FALSE )
					printf("file created: .htaccess\n");
			} else 
				printf("Arquivo já existe: %s, para sobrescrevê-lo acrescente a opção --force\n", $file);
		}
		
		return true;
	}
	
	public function generateConfigFile( $config )
	{
		if( file_exists($config) )
			$this->_generateDfConfigFile($config);
		else
			throw new Exception("Não foi possivel abrir o template de configuração. file: ".$config);
	}
	
	private function _generateDfConfigFile( $path )
	{
		$file = "";
		$fp = fopen($path, 'r');
		while( !feof($fp) )
			$file .= fgets($fp, 1024);
		
		$file = str_replace('{info}', 		'Arquivo de configuração Orion', $file);
		$file = str_replace('{database}', 	$this->argv[2], 	$file);
		$file = str_replace('{project}', 	$this->argv[2], 	$file);
		$file = str_replace('{date}', 		date('d-m-Y'), 		$file);
		$file = str_replace('{apps}', 		'apps',				$file);
		$file = str_replace('{libs}', 		'libs', 			$file);
		
		$filename = 'apps' . DIRECTORY_SEPARATOR . $this->argv[2] . DIRECTORY_SEPARATOR . 'config.yml';
		$fp = fopen($filename, 'w');
		
		if( fwrite($fp, $file) === FALSE )
			printf("Error: Não foi possivel gravar no arquivo %s.\n",$filename); 
	}
	
	public function generateFile( $src, $dst )
	{
		if(file_exists($src))
			return $this->_generateFile($src, $dst);
	}
	
	private function _generateFile($src, $dst)
	{
		$fp1 = fopen($src, "r");
		if(!$fp1)
			throw new Exception("Não foi possivel abrir o arquivo: ".$src);
		$fp2 = fopen($dst, "w");
		if(!$fp2)
			throw new Exception("Não foi possivel abrir o arquivo: ".$dst);
		
		$strSRC = "";
		while(!feof($fp1))
			$strSRC .= fgets($fp1, 1024);
		
		$strSRC = str_replace("{project}", $this->argv[2], $strSRC);
		if(fwrite($fp2, $strSRC) === FALSE)
			throw new Exception("Não foi possivel gravar no arquivo: ".$dst);
		
		fclose($fp1);
		fclose($fp2);
		return true;
	}
	
 }