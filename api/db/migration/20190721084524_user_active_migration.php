<?php

use Phinx\Migration\AbstractMigration;

class UserActiveMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table("user_active", ["id" => false, "primary_key" => "user_id"]);
        $table->addColumn("user_id", "integer")
            ->addColumn("active_token", "string", ["limit" => 255, "comment" => "Chuỗi token để kích hoạt tài khoản"])
            ->addColumn("token_valid_time", "timestamp", ["null" => true, "timezone" => false, "comment" => "Thời gian hết hạn của token"])
            ->addColumn("created_at", "timestamp", ["default" => "CURRENT_TIMESTAMP", "timezone" => false, "comment" => "Thời gian tạo mới"])
            ->addColumn("updated_at", "timestamp", ["null" => true, "timezone" => false, "comment" => "Thời gian cập nhập"])
            ->create();
    }
}
