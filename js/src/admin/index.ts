import app from 'flarum/admin/app';

export { default as extend } from './extend';

app.initializers.add('rysstad-blocked-usernames', () => {
  // Settings are registered through the extenders in ./extend.ts
});
