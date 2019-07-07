<?php

namespace Bootstrap\Config;

class BootstrapSetting
{
    /**
     * Thiết lập mặc định
     *
     * @var array
     */
    protected $defaultSettings = [
        "errorMiddleware" => [
            "displayErrorDetails" => true,
            "logErrors" => true,
            "logErrorDetails" => true,
        ],
        "view" => [
            "templateDir" => __DIR__ . "/../../view",
        ],
        "db" => [
            "driver" => "pgsql",
            "host" => "localhost",
            "database" => "ksb",
            "username" => "ksb",
            "password" => "ksb",
            "charset" => "utf8",
        ],
    ];

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
