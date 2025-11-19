<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
{
    $subject = $this->data['subject'] ?? 'رسالة جديدة من المنصة';

    return $this->subject($subject)
                ->view('emails.contact_message')
                ->text('emails.contact_message')
                ->with([
                    'name' => $this->data['name'] ?? 'غير معروف',
                    'email' => $this->data['email'] ?? 'غير محدد',
                    'phone_number' => $this->data['phone_number'] ?? 'غير محدد',
                    'subject' => $this->data['subject'] ?? 'بدون موضوع',
                    'messageBody' => $this->data['message'] ?? 'لا يوجد محتوى',
                    'siteName' => 'مركز الحوار والسلم الأهلي',
                    'adminUrl' => 'https://dcpc.org.sy/ar/dashboard',
                    'logo' => 'https://dcpc.org.sy/logo.png',
                ]);
}
}
