# CommonMark

This is a very basic Drupal 8 port of the
[CommonMark Drupal Module](https://www.drupal.org/project/commonmark).

See: <https://www.drupal.org/node/2610884#comment-11464893>

## Installation

Install Drupal 8.

At the root of the Drupal directory, edit the `composer.json` file.

**Note:** these are the installation instructions for *this* CommonMark module
for Drupal 8, from *this* github.com repository. It is still work-in-progress.

Add the requirement for `drupal/commonmark` as well as a reference to this
github repository.

The relevant part of the `composer.json` file should look something like this:

```
    "require": {
        "composer/installers": "^1.0.21",
        "wikimedia/composer-merge-plugin": "~1.3",
        "drupal/commonmark": "dev-master"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/michaellenahan/commonmark"
        }
    ],
    "replace": {
        "drupal/core": "~8.1"
    },
    "minimum-stability": "dev",
```

Once you have made your changes to composer.json, run:

```
composer update
```

This will download the module to `modules/commonmark`, the commonmark
php library to `vendor/league/` and the commonmark executable to
`vendor/bin/commonmark`.

Now, enable the CommonMark module on your Drupal 8 site:

```
drush en -y commonmark
```

## Usage

Here is an example of how you can use the CommonMark text filter in Drupal:

Go to `admin/config/content/formats` and click `Add text format`.

Fill out the form as follows:

`Name`: `CommonMark`

`Roles`: `Administrator`, `Authenticated user`

`Text editor`: `None`

`Enabled filters`: `CommonMark`

... and click `Save configuration`.

Now go to `node/add/page`, and for `Text format`, select `CommonMark`.

Enter some markdown into the body field:

```
# Heading 1

## Heading 2

*Italic*

**Bold**

[Link](https://drupal.org)

* List
* List
* List

1. One
2. Two
3. Three
```

Save the page. The markdown will be converted to html using CommonMark
standards.
