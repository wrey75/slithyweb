# Documentation of Slithy Web

## Setup

You should use the preferred loading method by using directly the WordPress plugins
facilities. Our plugin can be found at https://fr.wordpress.org/plugins/slithy-web/

## Clients of MaisonWP

If you are clients of the hosting offered by MaisonWP, you just have to leave it as
the link is made automatically. The usage of our plugin is not mandatory but can
help you in various ways. Please look up at the maisonwp.com website for more information.

## Capabilities

You must go to the Setting page which is under the "Settings" menu (we have not a dedicated
page as some others plugins because you will have to made the configuration once in your life).

### Google Analytic Tag

If you use Google Analytics for the analysis of your visitors, you must add a script in the
&lt;head&gt; par of your HTML. Our plugin can do it for your if you add you identifier (in
the form `UA-xxxxxx-1` where xxxxxx are digits) in the field. The gtag (Google Tag) code
will be added to all the pages of your website.

The Google Analytic code is _only_ added if the user is _not_ an administrator. An administrator
is someone who can manage options on the Website. This restriction is mainly added to avoid
surestimated visits when the site has just started. You could avoid this if you ban some IP
addresses and with some other rules on Google Analytics but the right way is to disable the count
for administrators.

## Short codes

Short codes are not part of the settings but available at your discretion in any posts
(including pages).

### \[slithy\_tooltip]

You can add a tooltip anywhere in your text. A tooltip is a text which appears when your mouse
goes over a text. A tooltip is usually made of a text and a definition. You can write something like:

    [slithy_tooltip text="The prime numbers are the natural numbers greater than one that are not products of two smaller natural numbers."]prime number[/slithy_tooltip]

The attribute "text" will be displayed in a tooltip near the original text. This is quite usefull in many cases.

From version 0.11, if you have the [Name Directory](https://fr.wordpress.org/plugins/name-directory/) plugin
installed, you can use the shortcut with the entry name in your directory.

    [slithyweb_tooltip name="DVD" dir="3"]

will display the description of the word "DVD" which must resides in your directory number 3. Note the directory is not
mandatory as you should not have duplicates of your terms in multiple directories. This is an "add-on" to the Name
Directory plugin. For speed access, the value is loaded from the database.

If you don't give your text, the "name" attribute will be used even you should not omit the text.

If you try this feature and the plugin does not exists anymore, the look up will fail and no error will be displayed. This
is why the following usage will preserve your post:

    [slithyweb_tooltip name="DVD"]DVD[/slithyweb_tooltip]
  


