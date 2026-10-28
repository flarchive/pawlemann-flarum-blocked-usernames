<?php

namespace Rysstad\BlockedUsernames;

use Closure;
use Flarum\Api\Context;
use Flarum\Api\Schema;
use Flarum\Locale\TranslatorInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;

class UsernameFieldMutator
{
    public function __construct(
        protected SettingsRepositoryInterface $settings,
        protected TranslatorInterface $translator
    ) {
    }

    public function __invoke(Schema\Str $field): Schema\Str
    {
        // The callable is evaluated for each request, so the settings are read
        // fresh every time and changes in the admin panel apply immediately.
        return $field->rule(function (Context $context, ?User $model = null): Closure {
            return function (string $attribute, mixed $value, Closure $fail) use ($context, $model): void {
                if (! is_string($value)) {
                    return;
                }

                // Administrators may always assign any username.
                if ($context->getActor()->isAdmin()) {
                    return;
                }

                // Leave an existing user's unchanged username alone, so users who
                // already hold a name that is blocked later are not locked out of
                // saving other changes.
                if ($model?->exists && mb_strtolower($model->username) === mb_strtolower(trim($value))) {
                    return;
                }

                $entries = UsernameBlocklist::parse(
                    $this->settings->get('rysstad-blocked-usernames.blocked_usernames')
                );

                if (UsernameBlocklist::isBlocked($value, $entries)) {
                    $fail($this->message());
                }
            };
        });
    }

    protected function message(): string
    {
        $custom = trim((string) $this->settings->get('rysstad-blocked-usernames.message'));

        if ($custom !== '') {
            return $custom;
        }

        return $this->translator->trans('rysstad-blocked-usernames.api.default_message');
    }
}
