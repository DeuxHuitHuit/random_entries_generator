# Random Entries Generator

> A really quick way to create dummy entries for Symphony CMS

## TL;DR

1. [REQUIREMENTS](#requirements)
2. [INSTALLATION](#installation)
3. [HOW TO USE](#how-to-use)
4. [SUPPORTED FIELDS](#supported-fields)
5. [DELEGATES](#delegates)
6. [Help, my field is blank!!!](#help-my-field-is-blank)
7. [LICENSE](#license)

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
- Repeat.

### SUPPORTED FIELDS ###

- **All core fields** (author, checkbox, date, input, select box, tag list, textarea, upload)
- [Address Location](http://symphonyextensions.com/extensions/addresslocationfield/)
- [Color Chooser](http://symphonyextensions.com/extensions/color_chooser_field/)
- [Date Time](http://symphonyextensions.com/extensions/datetime/)
- [Entry Relationship](http://symphonyextensions.com/extensions/entry_relationship_field/)
- [Image Upload](http://symphonyextensions.com/extensions/image_upload/)
- [Languages](http://symphonyextensions.com/extensions/languages/)
- [Multilingual Textbox](http://symphonyextensions.com/extensions/multilingual_field/)
- [Multilingual Image Upload](http://symphonyextensions.com/extensions/multilingual_image_upload/)
- [Multilingual oEmbed](http://symphonyextensions.com/extensions/multilingual_oembed_field/)
- [Number](http://symphonyextensions.com/extensions/numberfield/)
- [oEmbed](http://symphonyextensions.com/extensions/oembed_field/)
- [Order Entries](http://symphonyextensions.com/extensions/order_entries/)
- [Pages](http://symphonyextensions.com/extensions/pagesfield/)
- [Select Box Link](http://symphonyextensions.com/extensions/selectbox_link_field/)
- [Textbox](http://symphonyextensions.com/extensions/textboxfield/)

### DELEGATES ###

This extension also provides developers with two delegates,
`EntriesPreCreateRandomData` and `EntriesPostCreateRandomData`.
Delegates are fire once per field and offers developer the ability to change field and/or generated data. Check the
[FieldAdapter::generateData() method](https://github.com/DeuxHuitHuit/random_entries_generator/blob/master/lib/class.fieldadapter.php) for more information on those delegates.

### Help, my field is blank!!! ###

In order to generate data for a particular field, this extension requires a [field adapter](https://github.com/DeuxHuitHuit/random_entries_generator/blob/master/lib/class.fieldadapter.php)
that will populate the data in the database.

If a field stays blank, it's probably because the adapter for it does not exists. If the adapter does exists,
it is also possible that it does not cover all cases.

You can [look here](https://github.com/DeuxHuitHuit/random_entries_generator/tree/master/lib/adapters)
to see if there is already an adapter for the field in question. If not, feel free
to implement it (it's really easy!) and send a Pull Request.

### LICENSE ###

[MIT](http://deuxhuithuit.mit-license.org)

Made with love in Montréal by [Deux Huit Huit](https://deuxhuithuit.com/)

Copyright (c) 2015
