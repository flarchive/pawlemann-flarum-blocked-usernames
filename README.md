# Blocked Usernames (Flarum 2.x)

Lets administrators block usernames such as `Admin` or `Administrator` from being used at registration.

## Settings

Open **Administration → Extensions → Blocked Usernames**:

- **Blocked usernames**: one name per line (commas also work). Matching ignores upper/lower case. Use `*` as a wildcard, so `admin*` blocks `admin`, `admin1` and `administrator`, and `*staff` blocks `bigstaff`.
- **Error message**: the text shown to someone who tries a blocked name. If left empty, a translatable default is used.

Some names are pre-filled the first time (`admin`, `administrator`, `root`, `moderator`, `support`). Edit or clear them as you like.

## Behaviour

- Applies to registration and to users changing their own username.
- Administrators are never blocked, so you can still create or rename accounts with any name.
- A user who already holds a name that is blocked later keeps it and can still edit their profile.
- The check runs on the server as an extra rule on the `username` field, so it cannot be bypassed from the browser.

## Install

composer require rysstad/blocked-usernames
php flarum cache:clear

Then enable it under Administration → Extensions.

## By PM.Rysstad
