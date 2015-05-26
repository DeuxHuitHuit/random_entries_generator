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

### SUPPORTED FIELDS ###

- All core fields (author, checkbox, date, input, select box, tag list, textarea, upload)
- [Color Chooser](http://symphonyextensions.com/extensions/color_chooser_field/)
- [Date Time](http://symphonyextensions.com/extensions/datetime/)
- [Image Upload](http://symphonyextensions.com/extensions/image_upload/)
- [Multilingual Textbox](http://symphonyextensions.com/extensions/multilingual_field/)
- [Multilingual Image Upload](http://symphonyextensions.com/extensions/multilingual_image_upload/)
- [Multilingual oEmbed](http://symphonyextensions.com/extensions/multilingual_oembed_field/)
- [oEmbed](http://symphonyextensions.com/extensions/oembed_field/)
- [Order Entries](http://symphonyextensions.com/extensions/order_entries/)
- [Textbox](http://symphonyextensions.com/extensions/textboxfield/)

### Help, my field is blank!!! ###

In order to generate data for a particular field, this extension requires a [field adapter](https://github.com/DeuxHuitHuit/random_entries_generator/blob/dev/lib/class.fieldadapter.php)
that will populate the data in the database.

If a field stays blank, it's probably because the adapter for it does not exists. If the adapter does exists,
it is also possible that it does not cover all cases.

You can [look here](https://github.com/DeuxHuitHuit/random_entries_generator/tree/dev/lib/adapters)
to see if there is already an adapter for the field in question. If not, feel free
to implement it (it's really easy!) and send a Pull Request.

### LICENSE ###

[MIT](http://deuxhuithuit.mit-license.org)

Made with love in Montréal by [Deux Huit Huit](https://deuxhuithuit.com)

Copyright (c) 2015
