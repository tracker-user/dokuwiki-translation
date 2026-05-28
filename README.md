# Translation plugin for DokuWiki — local fork

Supports the easy setup of a multi-language wiki by providing language namespaces,
a language selector widget, UI translation, browser-language redirect, and an admin
panel for tracking outdated or missing translations.

**Upstream:** [dokuwiki.org/plugin:translation](https://www.dokuwiki.org/plugin:translation)  
**Original author:** Andreas Gohr <andi@splitbrain.org>  
**License:** GPL 2

---

## How it works

Pages in different languages live in per-language namespaces (e.g. `de:pagename`,
`fr:pagename`). The plugin detects which namespace a page belongs to, renders a
language selector, and optionally switches the DokuWiki UI language to match.

The default language has no namespace prefix (or sits inside the configured
translation namespace root).

---

## Configuration

All options are available through the DokuWiki configuration manager.

| Option | Default | Description |
|---|---|---|
| `translations` | *(empty)* | Space-separated ISO language codes to support (e.g. `de fr ja`). Do not include the default language. |
| `translationns` | *(empty)* | Restrict translations to a sub-namespace (e.g. `wiki`). |
| `skiptrans` | *(empty)* | Regex — pages whose ID matches are excluded from the selector. |
| `display` | `langcode,title` | What to show in the selector: `langcode`, `name`, `flag`, `title` (any combination). |
| `dropdown` | off | Use a dropdown instead of an inline list — recommended for more than 5 languages. |
| `translateui` | off | Switch the DokuWiki UI language to match the page's language namespace. |
| `redirectstart` | off | Redirect the start page to the browser's preferred language on first visit. |
| `checkage` | off | Show a notice on translated pages that are older than the original. |
| `about` | *(empty)* | Page ID to link from the selector as an explanatory "about" page. |
| `localabout` | off | Use a per-language version of the about page instead of one global page. |
| `copytrans` | off | Pre-load an existing translation into the editor when creating a new translation. |
| `show_path` | on | Show the page ID column in the admin outdated-translations table. |

---

## Language selector

Call from a template or a wiki page:

```php
// template
$trans = plugin_load('helper', 'translation');
if ($trans) echo $trans->showTranslations();
```

Or place `~~TRANS~~` in a page (via the syntax component if installed).

The selector renders as `div.plugin_translation`. Add `dropdown` in config to get
`div.plugin_translation.is-dropdown`, which shows only the current language until
hovered or focused.

---

## Admin panel

**Admin → Translation** lists every page in the default language that has at least
one outdated or missing translation. Columns per configured language show:

- **Missing** (red) — no translated page exists yet
- **Outdated** (yellow) — the translated page is older than the default-language page, with a diff link
- **Up-to-date** (green) — translation is current

---

## Page templates

When `copytrans` is enabled and a user creates a new translation, the plugin:

1. Loads the content of an existing translation into the editor.
2. Prepends the content of `lang/<lc>/totranslate.txt` as a warning header.
3. Displays a message letting the user choose which source translation to copy from.

The `@LANG@` and `@TRANS@` placeholders are available in DokuWiki page templates
and are replaced with the current UI language code and the page's translation
language code respectively.

---

## hreflang

The plugin emits `<link rel="alternate" hreflang="…">` tags for all existing
translations of the current page, plus an `x-default` pointing to the default
language. This assists search engines in serving the correct language variant.

---

## Local fork — changes from upstream

- **Security:** replaced `$_REQUEST` and `$_SERVER` direct access with DokuWiki
  `$INPUT` API throughout
- **Security:** escaped language codes and default-language label through `hsc()`
  in admin panel output; diff link URL also escaped
- **Bug fix:** `getOldDiffLink()` now returns `false` (instead of a link with an
  empty `rev=`) when no revision predates the translation
- **Bug fix:** outdated-translation age check uses `file_exists()` before
  `filemtime()` instead of `@`-suppression
- **PHP 8.3:** added `DOKU_INC` guards; removed dead `require_once` calls for
  autoloaded includes; `strpos()` replaced with `str_starts_with()` / `str_contains()`
- **PHP 8.3:** `array()` replaced with `[]` in `conf/metadata.php`
- **CSS:** `overflow-x: clip` (Firefox 81+) replaced with `overflow-x: hidden`
  for Firefox 78 ESR compatibility
