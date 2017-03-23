<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;
use Mail;

use App\Models\M3Email;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        /*发送邮件*/
        $m3_email = new M3Email;
        $m3_email->to = $event->user->email;
        $m3_email->cc = '18708156629@163.com';
        $m3_email->subject = '艾邦OA系统注册通知';
        $m3_email->content = $event->user->name.' 你于 '.Carbon::now()->format('Y年m月d日 H:i:s').' 注册账号：'.$event->user->username.' 初始密码为：123456 请及时修改';
        Mail::send('componet.email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
            $m->to($m3_email->to, '尊敬的用户')
              ->cc($m3_email->cc)
              ->subject($m3_email->subject);
        });        
    }
}
