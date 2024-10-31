=== Pesistulokset ===
Contributors: Rishadan
Plugin URI: https://bitbucket.org/koutamiika/pesistulokset/
Author URI: https://miikasalo.com
Requires at least: 6.2
Tested up to: 6.6
Stable tag: 1.8.6
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display Pesäpallo standings, stats or matches on your site.

== Installation ==

1. Upload the 'pesistulokset' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Insert your pesistulokset.fi API-key to the plugin settings.

== About ==

Pesäpallo or colloquially known as "Pesis" is a Finnish baseball-like sport played mostly in Finland. The purpose of this plugin is to allow sites to display official Pesäpallo standings, statistics or matches from various Pesäpallo leagues (eg. Superpesis or Ykköspesis leagues). This plugin relies on a 3rd party API (external service) to get the data.

The service used is provided by [https://www.pesistulokset.fi](pesistulokset.fi).

The official API documentation can be found at [https://ttk.pesistulokset.fi/api-docs](https://ttk.pesistulokset.fi/api-docs). To read the API documentation, you must provide an API-key.
API-key is required to use this plugin and the API.

== Getting Started ==

The plugin requires pesistulokset.fi API-key to work. After activating the plugin, add your API-key to the plugin settings. If you don't have an API-key, you can request one by sending an email to tulospalvelu@pesis.fi.

After inserting your API-key to the plugin settings, you can use the blocks, shortcodes and widgets provided by this plugin to display data on your site.

The official API documentation can be found at [https://ttk.pesistulokset.fi/api-docs](https://ttk.pesistulokset.fi/api-docs). You should check the documentation since very specific values are needed when using this plugin.

== Terms of use ==

Usage of the service is free.

The usage of the API requires an API-key, which can be obtained for free. See Getting started -section regarding obtaining the key.

The API used by this plugin does NOT provide any terms of use and/or privacy policies the user must agree to.

This plugin does NOT add any additional terms or policies.

== Privacy policy ==

No information about the user is sent to any 3rd party service. 3rd party service is only used to view and display data provided by the service.

== Disclaimer ==

The author of this plugin does not manage, develop or maintain the API used by this plugin.
Pesistulokset.fi service does not endorse, sponsor, manage or develop this plugin.

== Changelog ==

= 1.8.6 =
* Fixed php warning in Pesisottelut block for upcoming matches.
* Renamed Tilastot block to Pesistilastot.

= 1.8.5 =
* Changed "Requires at least" to 6.2

= 1.8.4 =
* Added typography settings to blocks.

= 1.8.3 =
* Added placeholder image for missing player photos.

= 1.8.2 =
* Stats table stylings.

= 1.8.1 =
* Fix console error.

= 1.8.0 =
* Added Tilastot block.

= 1.7.1 =
* Added Region-parameter to Ottelut block.

= 1.7.0 =
* Styling and additional changes.

= 1.6.0 =
* Changed block controls form selects to textfields so it allows to get more data from the API.
* Added block for matches.

= 1.5.2 =
* Added translations.

= 1.5.1 =
* Added Pohjoislohko.

= 1.5.0 =
* Added show header options to block and shortcode.
* Added header color options to block and shortcode.
* Fixed block column settings not saving in edit.

= 1.4.2 =
* Added highlight color options

= 1.4.1 =
* Team name class to row

= 1.4.0 =
* Added gutenberg block

= 1.3.0 =
* Added ppg column

= 1.2.1 =
* Removed border-radius css

= 1.2.0 =
* Added columns attribute to shortcode

= 1.1.4 =
* Added team logo alt-text

= 1.1.3 =
* Coding standards

= 1.1.0 =
* Added highlight attribute to shortcode

= 1.0 =
* Initial release
