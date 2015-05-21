# Random Entries Generator

Version: 1.0.x

> A really quick way to create dummy entries for Symphony CMS

### REQUIREMENTS ###

- Symphony CMS version 2.6.x and up (as of the day of the last release of this extension)

### INSTALLATION ###

- `git clone` / download and unpack the tarball file
- Put into the extension directory
- Enable/install just like any other extension

You can also install it using the [extension downloader](http://symphonyextensions.com/extensions/extension_downloader/).
Just search for `random_entries_generator`.

For more information, see <http://getsymphony.com/learn/tasks/view/install-an-extension/>

### HOW TO USE ###

- Go on the publish index or edit page of a section.
- Click on the "Create Random Entry" button.
- Enjoy some beer.

### Help, my field is blank!!! ###

In order to generate data for a particular field, this extension requires a [field adapter](https://github.com/DeuxHuitHuit/random_entries_generator/blob/master/lib/class.fieldadapter.php)
that will populate the data in the database.

We currently support only core fields.
If a field stays blank, it's probably because the adapter for it does not exists.

You can [look here](https://github.com/DeuxHuitHuit/random_entries_generator/tree/master/lib/adapters)
to see if there is already an adapter for the field in question. If not, feel free
to implement it (it's really easy!) and send a Pull Request.

### LICENSE ###

[MIT](http://deuxhuithuit.mit-license.org)

Made with love in Montréal by [Deux Huit Huit](https://deuxhuithuit.com)

Copyright (c) 2015
