<?php namespace App\Controllers\Webhooks;

use \App\Libraries\Api;

class Email extends BaseWebhooks
{
    public function kibers_webhook()
    {
        if (empty($this->request->getPost('message_id')))
        {
            return 'Error request Webhook';
        }
        $message_id = $this->request->getPost('message_id');
        if ($this->request->getPost('type'))
        {
            switch ($this->request->getPost('type')) {
                case'delivery':
                    (new Api())->call('notify.email.updateStatuses', [
                        'hash'   => $message_id,
                        'type'   => 'delivery',
                        'status' => $this->request->getPost('status'),
                        'info'   => (empty($message_id) ? '' : $message_id),
                    ]);
                    break;
            }
        }
        return 'OK';
    }

    public function img($token = '', $name = '')
    {
        if (empty($name))
        {
            return ;
        }
        $this->response->setContentType('image/png');

        $hash = substr($name, 0, -5);
        $image = imagecreatetruecolor(1, 1);
        imagefill($image, 0, 0, 0xFFFFFF);
        imagepng($image);
        imagedestroy($image);

        (new Api())->call('notify.emailUpdateStatuses', [
            'hash'   => $hash,
            'type'   => 'open',
            'status' => 1,
            'info'   => '',
        ]);
        return ;
    }

    public function link($token = '', $name = '')
    {
        if (empty($name))
        {
            return;
        }
        $hash = $name;

        $link = '';
        if (! empty($this->request->getGet('l')))
        {
            $link = base64_decode($this->request->getGet('l'));
        }
        if (empty($link))
        {
            return;
        }

        $resp = (new Api())->call('notify.emailUpdateStatuses', [
            'hash'   => $hash,
            'type'   => 'click',
            'status' => 1,
            'info'   => $link,
        ]);

        if ($link !== '')
        {
            return $this->response->redirect($link);
        }
        return;
    }

}
