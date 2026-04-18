<?php
declare(strict_types=1);

namespace App\Form;

use App\Mailer\ContactMailer;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Log\Log;
use Cake\Validation\Validator;
use Throwable;

class ContactForm extends Form
{
    /**
     * Build form schema.
     *
     * @param \Cake\Form\Schema $schema Form schema.
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema
            ->addField('name', ['type' => 'string'])
            ->addField('email', ['type' => 'string'])
            ->addField('message', ['type' => 'text'])
            ->addField('website', ['type' => 'string']);
    }

    /**
     * Build validator rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Naam is verplicht.')
            ->maxLength('name', 120, 'Naam mag maximaal 120 tekens bevatten.');

        $validator
            ->scalar('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'E-mailadres is verplicht.')
            ->email('email', false, 'Vul een geldig e-mailadres in.')
            ->maxLength('email', 190, 'E-mailadres mag maximaal 190 tekens bevatten.');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message', 'Bericht is verplicht.')
            ->maxLength('message', 5000, 'Bericht mag maximaal 5000 tekens bevatten.');

        // Honeypot field must stay empty.
        $validator
            ->allowEmptyString('website')
            ->add('website', 'honeypot', [
                'rule' => static function ($value): bool {
                    return trim((string)$value) === '';
                },
                'message' => 'Spam gedetecteerd.',
            ]);

        return $validator;
    }

    /**
     * Process validated form data.
     *
     * @param array<string, mixed> $data Submitted data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        try {
            (new ContactMailer())->send('ownerNotification', [$data]);

            return true;
        } catch (Throwable $exception) {
            Log::error(sprintf(
                'Contact form email failed: %s',
                $exception->getMessage()
            ));

            return false;
        }
    }
}
