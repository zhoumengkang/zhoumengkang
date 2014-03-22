<?php
class MailModel {
    protected $mail;
    public function __construct($address,$nickname,$boby,$title=null) {
        require_once(dirname(__FILE__).'/../library/phpmailer/class.phpmailer.php');
        require_once(dirname(__FILE__).'/../library/phpmailer/class.pop3.php');
        require_once(dirname(__FILE__).'/../library/phpmailer/class.smtp.php');
        $this->mail = new PHPMailer(); //实例化
        $this->mail->IsSMTP(); // 启用SMTP
        $this->mail->Host = "smtp.exmail.qq.com"; //SMTP服务器
        $this->mail->Port = 25;  //邮件发送端口
        $this->mail->SMTPAuth   = true;  //启用SMTP认证
        $this->mail->CharSet  = "UTF-8"; //字符集
        $this->mail->Encoding = "base64"; //编码方式
        $this->mail->Username = "i@mengkang.net";  //你的邮箱
        $this->mail->Password = "xxxx";  //你的密码
        $this->mail->Subject = $title ? $title : '主人，北剅轩有人造访'; //邮件标题
        $this->mail->From = "i@mengkang.net";  //发件人地址（也就是你的邮箱）
        $this->mail->FromName = "周梦康";  //发件人姓名
        $this->mail->AddAddress($address,$nickname);//添加收件人（地址，昵称）
        $this->mail->IsHTML(true);
        $this->mail->Body = $boby;//内容里面必须带博客的id链接
        if(!$this->mail->Send()) {
            echo "发送失败: " .$this->mail->ErrorInfo;
        }
    }
}