<?php 
namespace OlTheme\Table;
class SubscriberTable extends BaseTable
{
	private $_table_base_name = 'subscriber';
	public function __construct()
	{
		parent::__construct();
		$this->table_name = "{$this->_wpdb->prefix}{$this->_table_base_name}";
	}
	public function createTable()
	{
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		$sql_1="
			CREATE TABLE IF NOT EXISTS {$this->table_name} ( 
			`id` BIGINT NOT NULL AUTO_INCREMENT 
			, `name` VARCHAR(100) NULL 
			, `email` VARCHAR(100) NOT NULL
			, `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
			, `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
			, PRIMARY KEY (`id`)
			, INDEX `subscriber_email_index` (`email`)
			){$this->chaset_collate};";
		dbDelta($sql_1);		
	}		
}