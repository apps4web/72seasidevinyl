<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\Reservation;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class ReservationMailer extends Mailer
{
    public function clientConfirmation(Reservation $reservation): void
    {
        $fromEmail = (string)Configure::read('Contact.fromEmail', 'noreply@72seasidevinyl.nl');
        $fromName  = '72 Seaside Vinyl';
        $ownerEmail = (string)Configure::read('Contact.ownerEmail', 'info@72seasidevinyl.nl');

        $this
            ->setTo($reservation->email, $reservation->name)
            ->setFrom([$fromEmail => $fromName])
            ->setReplyTo([$ownerEmail => $fromName])
            ->setSubject('Bevestiging van uw reservering – 72 Seaside Vinyl')
            ->setEmailFormat('both')
            ->setViewVars(['reservation' => $reservation]);

        $this->viewBuilder()
            ->setTemplate('reservation_confirmation')
            ->setLayout('reservation');

        $this->attachLogo();
    }

    public function adminAlert(Reservation $reservation): void
    {
        $fromEmail  = (string)Configure::read('Contact.fromEmail', 'noreply@72seasidevinyl.nl');
        $fromName   = '72 Seaside Vinyl';
        $ownerEmail = (string)Configure::read('Contact.ownerEmail', 'info@72seasidevinyl.nl');

        $this
            ->setTo($ownerEmail)
            ->setFrom([$fromEmail => $fromName])
            ->setReplyTo([$reservation->email => $reservation->name])
            ->setSubject('Nieuwe reservering: ' . $reservation->name . ' – ' . $reservation->email)
            ->setEmailFormat('both')
            ->setViewVars(['reservation' => $reservation]);

        $this->viewBuilder()
            ->setTemplate('reservation_admin_alert')
            ->setLayout('reservation');

        $this->attachLogo();
    }

    private function attachLogo(): void
    {
        $logoPath = WWW_ROOT . 'img' . DS . 'logo-72-seaside-vinyl.png';
        if (is_file($logoPath)) {
            $this->setAttachments([
                'logo-72-seaside-vinyl.png' => [
                    'file'               => $logoPath,
                    'mimetype'           => 'image/png',
                    'contentId'          => 'seaside-logo',
                    'contentDisposition' => false,
                ],
            ]);
        }
    }
}
