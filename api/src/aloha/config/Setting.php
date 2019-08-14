<?php

namespace Aloha\Config;

class Setting
{
    protected $defaultSettings;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->defaultSettings = [
            "errorMiddleware" => [
                "displayErrorDetails" => getenv("DEBUG"),
                "logErrors" => getenv("DEBUG"),
                "logErrorDetails" => getenv("DEBUG"),
            ],
            "db" => [
                "driver" => "pgsql",
                "host" => getenv("DB_HOST"),
                "database" => getenv("DB_DATABASE"),
                "username" => getenv("DB_USERNAME"),
                "password" => getenv("DB_PASSWORD"),
                "charset" => "utf8",
            ],
        ];
    }

    /**
     * Lấy giá trị từ Thiết lập mặc định
     * Phân tách phần từ con bởi dấu chấm
     * VD: "errorMiddleware.displayErrorDetails"
     *
     * @param string $props
     * @return void
     */
    public function get(string $props)
    {
        $frags = explode(".", $props);
        $result = $this->defaultSettings;
        foreach ($frags as $frag) {
            if (isset($result[$frag])) {
                $result = $result[$frag];
            } else {
                return null;
            }
        }
        return $result;
    }
}
