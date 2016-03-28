<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */
$core_resource = Mage::getSingleton('core/resource');
$installer->startSetup();

$check_permission_block_table = $installer->getConnection()->isTableExists(
    $core_resource->getTableName('permission_block')
);
if ($check_permission_block_table) {
	$installer->run("
		INSERT INTO {$core_resource->getTableName('permission_block')} (`block_name`, `is_allowed`) VALUES ('isfeatured/isfeatured', '1');
	");
}
$installer->endSetup();
?>