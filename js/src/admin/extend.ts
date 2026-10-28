import Extend from 'flarum/common/extenders';
import app from 'flarum/admin/app';

export default [
  new Extend.Admin()
    .setting(() => ({
      setting: 'rysstad-blocked-usernames.blocked_usernames',
      type: 'textarea',
      rows: 8,
      label: app.translator.trans('rysstad-blocked-usernames.admin.blocked_usernames_label'),
      help: app.translator.trans('rysstad-blocked-usernames.admin.blocked_usernames_help'),
    }))
    .setting(() => ({
      setting: 'rysstad-blocked-usernames.message',
      type: 'text',
      label: app.translator.trans('rysstad-blocked-usernames.admin.message_label'),
      help: app.translator.trans('rysstad-blocked-usernames.admin.message_help'),
      placeholder: app.translator.trans('rysstad-blocked-usernames.admin.message_placeholder'),
    })),
];
