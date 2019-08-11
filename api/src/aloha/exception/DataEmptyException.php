<?php

namespace Aloha\Exception;

use Exception;

class DataEmptyException extends Exception
{
    protected $message = "Lỗi dữ liệu không được thiết lập";
}
