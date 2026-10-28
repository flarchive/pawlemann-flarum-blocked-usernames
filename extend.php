<?php

use Flarum\Api\Resource;
use Flarum\Extend;
use Rysstad\BlockedUsernames\UsernameFieldMutator;

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Settings())
        ->default('rysstad-blocked-usernames.blocked_usernames', "admin\nadministrator\nroot\nmoderator\nsupport")
        ->default('rysstad-blocked-usernames.message', ''),

    // Adds the blocklist check as an extra validation rule on the user's
    // `username` attribute. This covers registration and username changes.
    (new Extend\ApiResource(Resource\UserResource::class))
        ->field('username', UsernameFieldMutator::class),
];
