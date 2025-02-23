<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RfqEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $value;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $value)
    {
        $this->user  = $user;
        $this->value = $value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->value['data_type'] == 'shipyards') {
            $subject = 'RFQ Contact';
        } elseif ($this->value['data_type'] == 'tenders') {
            $subject = 'Join Tender';
        }

        return $this->view('emails.rfq')
            ->subject("{$subject} From " . strtoupper($this->user['name']) . " :: DockyardID #" . strtotime('now'))
            ->to($this->value['email_to'])
            ->with([
                'user'  => $this->user,
                'value' => $this->value
            ]);
    }
}
