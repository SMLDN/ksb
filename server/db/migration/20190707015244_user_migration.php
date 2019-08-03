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
        $table = $this->table("user");
        $table->addColumn("user_name", "string", ["limit" => 127, "comment" => "Tên hiển thị"])
            ->addColumn("password", "string", ["null" => true, "limit" => 255, "comment" => "Mật khẩu"])
            ->addColumn("remember_key", "string", ["null" => true, "limit" => 255, "comment" => "Khóa để lưu thông tin người dùng"])
            ->addColumn("remember_value", "string", ["null" => true, "limit" => 255, "comment" => "Giá trị để lưu thông tin người dùng"])
            ->addColumn("remember_last", "timestamp", ["null" => true, "timezone" => false, "comment" => "Thời gian hết hạn thông tin đăng nhập"])
            ->addColumn("email", "string", ["null" => true, "limit" => 255, "comment" => "Email"])
            ->addColumn("active_status", "char", ["default" => "0", "limit" => 1, "comment" => "Trạng thái tài kích hoạt"])
            ->addColumn("created_at", "timestamp", ["default" => "CURRENT_TIMESTAMP", "timezone" => false, "comment" => "Thời gian tạo mới"])
            ->addColumn("updated_at", "timestamp", ["null" => true, "timezone" => false, "comment" => "Thời gian cập nhập"])
            ->create();
        $count = $this->execute("ALTER SEQUENCE user_id_seq RESTART WITH 1000000");
    }
}
