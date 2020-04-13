# Slithy Web

A plug-in for WordPress specially dedicated to the maisonwp hosting.

## The intended usage of this plugin

As this plugin is mainly oriented to be used by people having their
sites hosted by the "maisonwp.com" hosting service, this plugin is
NOT an exclusive one and gives power to people who want to have a
simple plugin for classic business behaviour.

## If you are hosted by MaisonWP

In this case, the "monitoring.php" code is loaded in addition. You don't
have to bother because this part of the plugin is only loaded if you
have a website which is hosted by MaisonWP. Technically, if you have
a website hosted by MaisonWP, you have a `SLITHYWEB_ID` automatically
defined in the `wp-config.php` provided by them.

This part is only used to discuss with the monitoring stuff of maisonWP.
For example, if you have activated the DEBUG mode for your web site, the
plugin will try to upload the error and access logs immediately to the
manager rather than waiting for the next upload batching (usually once
a day).

If you change something in the administrator panel (like the title of
you website), this change will be reflected in the administration
panel of your web sites.

## Is it a good idea to install this plugin?

I will rather say "yes". But you can have other plugins doing the same
than this one, then in this case, do not install a new plugin!

## Why this plugin is free?

Because this plugin is especially developped for the needs of the
MaisonWP clients, then this plugin is just a additional service but,
as long as the need of the hosting company are the same than clients
from hosting companies, there is no reason not to offer this plugin
for free.

## Is the plugin fully open sourced?

Yes. For the information transmission to the MaisonWP clients, we
simply use an API through the `wp_remote_post()` function provided by
WordPress itself. The processing of the API is, of course, a black box.

If your website is not hosted by MaisonWP, there is absolutely no
information sent to us. Even the code is _not_ loaded. You can check yourself
by removing manually the file  `maisonwp.php`.

## Is this plugin is referenced by WordPres

Not yet. We are working on that.

## Why this name?

The name "Slithy Web" comes from the fact that the MaisonWP uses
the "slithyweb.site" domain for all their installations (even the
websites are running on different machines).

The term "slithy" is from the poem _"Through the Looking Glass (And What Alice Found There)"_ written by _Lewis Carroll_: 

> Well, "SLITHY" means "lithe and slimy." "Lithe" is the 
> same as "active." You see it's like a portmanteau — there 
> are two meanings packed up into one word.

This is the definition of what the founders of MaisonWP dreamed the
proposed service.

