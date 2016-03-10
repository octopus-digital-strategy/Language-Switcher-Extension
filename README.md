#Language Switcher Extension

Some additional functionality for the Multisite Language Switcher


##Features

Adds 2 new short codes **lsex-link-to-language** and **lsex-get-language-url**.

##Usage

###Shortcodes

####1. lsex-link-to-language

Use this short code to build a link that points to a post in another language

Users parameter **language** to indicate which language will the link be targeting. 

```

[lsex-link-to-language language='es_MX']<strong>Some HTML</strong>[/lsex-link-to-language]

```

####2. lsex-get-language-url 

It is a very simple short code. Provide the target language –In the correct format ***en_EN*** or ***fr_FR***– and get the target url for the given language.

```

[lsex-get-language-url language='es_MX' /]

```

####3. lsex-translation-links 

The easier of them all. Returns a string with all the links to available translations. No parameters.

```

[lsex-translation-links /]

```


##Change Log


###Version 0.7.1 - Site Option Fix!

- Updated BaseSettingsPage to use get_option and update_option instead of site_option alternatives


###Version 0.7.0 - Upgrade to WPExpress 1.2.4

- Modified BaseSettings Page to Allow empty values
- Added translation files for Spanish and English
- Tested All ShortCodes and Filters
- Updated template link-to-language.mustache
- Updated documentation
- Upgraded to WPExpress/UI 1.0.2
- Added Menu class methods renderMenuItemsForAvailableTranslations, renderMenuItemsForAvailableTranslationsWithoutFlags and renderMenuItems
- Added method Translations/getLanguageTranslation
- Added template list-item-template.mustache
- Removed the parsing of HTML in code in favor of mustache templates
- Upgraded the options page
- Upgraded UI class
- Upgraded to WPExpress 1.2.4
- Fixed some rendering errors
- Updated OptionsPage class
- Edited the gitignore file
- Added the whole vendor folder to the repository minus the tests and docs


###Version 0.6.1 - Fixes short code magic

- Added link to ShortCodes/translationLinks
- Updated documentation 

###Version 0.6.0 - Short code magic 

- Added short-code **lsex-translation-links**
- Fixed short-code **lsex-link-to-language**
- Added class Translations 

###Version 0.5.1

- Replaced MsLsLink class usage with a string for the flag
- Adopted [Semantic Versioning](http://semver.org)

###Version 0.5

- Fixed an error on homepage options


###Version 0.4

- Fixed small compatibility error for php 5.3
- Completed the Append translations to Menu
- Implemented select2 for menus in options page
- Implemented select controls on OptionsPage
- Added select2 as bower_components
- Added the custom mustache template for the settings page
- Configured the Options Page
- Configured the custom Filter for the Menus
- Added the CustomFilters/Menu class
- Added functionality to append translations to the menu
- Added Options Page


###Version 0.3 

- Updated documentation
- Created short code lsex-link-to-language
- Created short code lsex-get-language-url
- Added msls_output filter
- Added link-output.mustache file
- Added link-template.mustache file
- Added WPExpress ti use the render engine


###Version 0.2

- Added the first shortcode
- Refactored the Setup class
- Modified init file to run setup on plugins_loaded
- Added UI class
- Configured the [WP BareBones Plugin](https://github.com/octopus-digital-strategy/wp-barebones-plugin)
- Added composer.lock to .gitignore file
- Cloned the Bare Bones into the project

###Version 0.1

- Added empty files for the project
- First commit of the repository