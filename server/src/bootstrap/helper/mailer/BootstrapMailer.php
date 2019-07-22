<?php

namespace Bootstrap\Helper\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use Slim\Psr7\Uri;
use Slim\Routing\RouteParser;

class BootstrapMailer
{
    protected $mailer;
    protected $route;

    /**
     * Construct
     *
     * @param PHPMailer $mailer
     */
    public function __construct(PHPMailer $mailer, RouteParser $route)
    {
        //injecting
        $this->mailer = $mailer;
        $this->route = $route;

        // mail setting
        $this->mailer->isSMTP(); // Set mailer to use SMTP
        $this->mailer->SMTPDebug = getenv("DEBUG") ? 2 : 0; // Enable verbose debug output
        $this->mailer->Host = getenv("MAIL_HOST"); // Specify main and backup SMTP servers
        $this->mailer->SMTPAuth = true; // Enable SMTP authentication
        $this->mailer->Username = getenv("MAIL_USERNAME"); // SMTP username
        $this->mailer->Password = getenv("MAIL_PASSWORD"); // SMTP password
        $this->mailer->SMTPSecure = "tls";
        $this->mailer->Port = 587;
        $this->mailer->setFrom("ksbmailer2019@vocmaytinh.com", "Ksb Mailer");
        $this->mailer->CharSet = "UTF-8";
    }

    /**
     * Gửi mail kích hoạt tài khoản
     *
     * @return void
     */
    public function sendRegisterMail(string $toAddress, $userId, string $userName, string $activeToken)
    {
        $url = $this->route->fullUrlFor(new Uri($_SERVER["REQUEST_SCHEME"], $_SERVER["HTTP_HOST"]), "user.active", [
            "userId" => $userId,
            "activeToken" => $activeToken,
        ]);
        $this->resetMailSetting();
        $this->mailer->addAddress($toAddress); // Add a recipient
        $this->mailer->Subject = "Kích hoạt tài khoản Vọc Máy Tính";
        $this->mailer->Body = "Cám ơn {$userName} đã đến với Vọc Máy Tính\n\nĐể kích hoạt tài khoản, xin vui lòng truy cập vào đường dẫn sau:\n${url}\n* Lưu ý: Đường dẫn chỉ có hiệu lực trong vòng 1 tiếng\n\n Trân trọng\nBan quản trị Vọc Máy Tính";
        $this->mailer->send();
    }

    /**
     * Thiết lập lại thông tin mail
     *
     * @return void
     */
    protected function resetMailSetting()
    {
        $this->mailer->clearAddresses();
        $this->mailer->clearAllRecipients();
        $this->mailer->clearCCs();
        $this->mailer->clearBCCs();
        $this->mailer->clearReplyTos();
        $this->mailer->clearCustomHeaders();
        $this->mailer->clearAttachments();
    }
}
