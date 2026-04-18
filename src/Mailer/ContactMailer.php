<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\I18n\FrozenTime;
use Cake\Mailer\Mailer;

class ContactMailer extends Mailer
{
    /**
     * Send the owner notification for a contact form submission.
     *
     * @param array<string, mixed> $contact Contact form data.
     * @return void
     */
    public function ownerNotification(array $contact): void
    {
        $ownerEmail = (string)Configure::read('Contact.ownerEmail', 'info@72seasidevinyl.nl');
        $fromEmail = (string)Configure::read('Contact.fromEmail', 'noreply@72seasidevinyl.nl');
        $fromName = (string)Configure::read('Contact.fromName', '72 Seaside Vinyl Contactformulier');

        $name = trim((string)($contact['name'] ?? ''));
        $email = trim((string)($contact['email'] ?? ''));

        $this
            ->setTo($ownerEmail)
            ->setFrom([$fromEmail => $fromName])
            ->setReplyTo([$email => $name !== '' ? $name : $email])
            ->setSubject('Nieuw contactformulier bericht - 72 Seaside Vinyl')
            ->setEmailFormat('both')
            ->setTemplate('contact_owner_notification')
            ->setLayout('retro_contact')
            ->setViewVars([
                'contact' => $contact,
                'submittedAt' => FrozenTime::now(),
            ]);

        $logoPath = WWW_ROOT . 'img' . DS . 'logo-72-seaside-vinyl.png';
        if (is_file($logoPath)) {
            $this->setAttachments([
                'logo-72-seaside-vinyl.png' => [
                    'file' => $logoPath,
                    'mimetype' => 'image/png',
                    'contentId' => 'seaside-logo',
                    'contentDisposition' => false,
                ],
            ]);
        }
    }
}
