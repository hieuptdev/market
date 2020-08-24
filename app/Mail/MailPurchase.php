<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Models\User;

class MailPurchase extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $product;
    public $user;
    public $notification;

    public function __construct(Product $product, User $user, $notification)
    {
        $this->product = $product;
        $this->user = $user;
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notify_purchase')
                    ->with([
                        'product' => $this->product,
                        'user' => $this->user,
                        'notification' => $this->notification
                    ]);
    }
}
