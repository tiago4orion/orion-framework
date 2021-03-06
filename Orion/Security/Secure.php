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
 * OrionSecurity_Secure
 * Classe com métodos úteis para segurança
 *
 * @package     Orion
 * @subpackage	Security
 * @author      Tiago Moura <tiago_moura@live.com>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.orion-framework.org
 * @since       1.0
 * @version     $Revision: 1 $
 */


/**
 * Classe estática de Segurança
 * Esta classe não precisa (e não deve) ser instaciada,
 *
 * Se necessário pegar uma instancia use OrionSecurity_Secure::getInstance()
 */

 class OrionSecurity_Secure 
 {

 	public function __construct() {
 		/** TODO : Other BlackHole */
 	}
 	
 	/**
     * Retorna a instancia da classe
     * Pega a instancia da classe somente para 
     * operações que necessite chamar uma função recursivamente,
     * num array_map ou num Tools_Functions::array_map_r() por exemplo.
     *
     * @return OrionSecurity_Secure
     */
    public static function getInstance()
    {
        static $instance;
        if ( ! isset($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
 	
 	/**
 	 * Retorna comandos SQL em caixas alta e baixa ( case insensitive ) 
 	 *
 	 * @return string 
 	 */
 	public static function getSQLRegCase( $nivel = 0 ) 
	{
 		
		$sql = 	"/(mysql|drop|database|databases|information_schema|" . 
				"information_schema\.tables|information_schema.columns|".
				"information_schema.column_privileges|".
				"information_schema.schema_privileges|".
				"information_schema.session_status|information_schema.session_variables|".
				"information_schema.table_provileges|".
				"\%27|\%22|\%20or\%20|\%20or\%201=1|".
				"union\%20all|union\%20all\%20select|".
				"\+or\+|\+or\+1\=1|\+order\+by)/i";
		return $sql;
 	}

 	/**
 	 * Método que usa um modo padrão de segurança
 	 * :: Retira Sintaxe SQL da variável
 	 * :: Retira Tags HTML e PHP
 	 * :: Escapa as Aspas
 	 * @param String
 	 * @return String -  String segura
 	 */
 	public static function secure( $var )
	{
		if( is_array( $var ) == true )
		{
			$var = OrionTools_Functions::array_map_r(array("OrionSecurity_Secure","shutSQLSintax"),$var);
		} else {

		$var = OrionSecurity_Secure::shutSQLSintax( $var );
		}
		return $var;
	}

	/**
	 * Método que retira sintaxe maliciosa da variável
	 *
	 * ::: Update 16/05/2009:::
	 * --- O método insensitive (com /i no final) anterior :
	 * --- Usando sql_regcase para poder usar níveis de segurança :)
	 *
	 * @param String
	 * @return String
	 */
	public static function shutSQLSintax( $var, $nivel = 0 )
	{

		$regex = OrionSecurity_Secure::getSQLRegCase( $nivel );
		
		/**
		 * Substitui por '' as strings maliciosas
		 */
		$newVar = preg_replace($regex,"",$var,-1,$count);
		if( $count > 0 ) {
			/**
			 * Se encontrou string maliciosa, resgata informações do atacante!!!
			 * 
			 */
			OrionSecurity_Secure::saveAtack( $var, $count);
		}
		// Retira os espaços vazios
		$newVar = trim($newVar);
		// Retira tags HTML e PHP
		$newVar = strip_tags($newVar);
		// Escapa às aspas
		if (stristr($newVar, '\'')) {
			OrionSecurity_Secure::saveAtack($var);
		}
		$newVar = addslashes($newVar);

		return $newVar;
	}
	
	/**
	 * Evita ataques avançados como:
	 * * SQL Injection pela URL,
	 * * XSS Scripts
	 * * Evitará roubo de seção e de cookie **** Ainda não implementado	 * 
	 * * etc
	 * 
	 * @param array $arr   Array com os diretórios da URL amigavel
	 */
	public static function URLSecure( $arr ) 
	{
		/**
		 * Retira a sintaxe maliciosa com nível == 0
		 */
		$arr = OrionTools_Functions::array_map_r(array('OrionSecurity_Secure','shutSQLSintax'),$arr);
		
		return $arr;
	}
	
	/**
	 * Método que identifica se o usuário
	 * está mal intencionado
	 *
	 * @param array $arr
	 */
	public static function isHacker( $arr ) 
	{
		
		$sqlInj = Tools_Functions::array_map_r(array('OrionSecurity_Secure', 'isSQLInjection'), $arr);
		
		//$xssScript = OrionSecurity_Secure::isXSSScript( $arr );
	}
	
	public static function isSQLInjection( $var ) 
	{
		$p = preg_match(OrionSecurity_Secure::getSQLRegCase(0), $var, $matchs);
		if(count($matchs) > 0) {
			print "Voce é um Kiddie??";
		}
	}

	/**
	 * Salva as informações do atacante
	 *
	 * @param array $var
	 * @param integer $count
	 */
	protected static function saveAtack( $var, $count = 1) 
	{
		$kiddie = new Security_Ident( $var );
		$kiddie->setCount($count);
		$kiddie->saveAtack();
		
	}
	
	public static function getHashOfString( $pass ) 
	{
		return md5($pass);
	}
}




?>