<?php

use Phinx\Migration\AbstractMigration;

class UserMigration extends AbstractMigration
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
        $table = $this->table("user", ["id" => "user_id"]);
        $table->addColumn("user_name", "string", ["limit" => 127, "comment" => "Tên hiển thị"])
            ->addColumn("password", "string", ["null" => true, "limit" => 255, "comment" => "Mật khẩu"])
            ->addColumn("remember_key", "string", ["null" => true, "limit" => 255, "comment" => "Khóa để lưu thông tin người dùng"])
            ->addColumn("remember_value", "string", ["null" => true, "limit" => 255, "comment" => "Giá trị để lưu thông tin người dùng"])
            ->addColumn("email", "string", ["null" => true, "limit" => 255, "comment" => "Email"])
            ->addColumn("active_status", "char", ["default" => "0", "limit" => 1, "comment" => "Trạng thái tài kích hoạt"])
            ->addColumn("created_at", "timestamp", ["default" => "CURRENT_TIMESTAMP", "timezone" => false, "comment" => "Thời gian tạo mới"])
            ->addColumn("updated_at", "timestamp", ["null" => true, "timezone" => false, "comment" => "Thời gian cập nhập"])
            ->addIndex(["user_name"], ["unique" => true, "name" => "idx_user_name"])
            ->addIndex(["email"], ["unique" => true, "name" => "idx_email"])
            ->create();
    }
}
