# 8fold Syndication for PHP

A library for generating standards-compliant [web feeds](https://en.wikipedia.org/wiki/Web_feed) using both [Atom](https://validator.w3.org/feed/docs/atom.html) (recommended) and [RSS](https://cyber.harvard.edu/rss/) specifications.

Versions:

|Library |JSON Feed |Atom |RSS |
|:------:|:--------:|:---:|:--:|
|current |1.1       |1.0  |2.0 |

## Installation

{how does one install the product}

## Usage

{brief example of how to use the product}

### JSON Feed

JSON Feed reference used: https://www.jsonfeed.org

When it comes to content, JSON feed is quite flexible; you may have:

1. Plain text content via the `content_text` member.
2. HTML content via the `content_html` member.
3. Or, both.

You must have at least one.

Therefore, we have added `content` as a required part of the initializer using a plain text string (`content_text`) or an instance of `ContentHtml` (`content_text`).

Further, you may call the `withExtraContent` method to use both. With that said, if both are of the same type, the content provided from the `withExtraContent` method will be used; last in overwrite rules.

Note: JSON Feed does not require a `content` member and is able to accept both plain text and html content types; using `content_text` and `context_html`. Both are optional, however, at least one of them must be present. Therefore, we require `content` as part of the initializer, which can accept a plain text string (`content_text`) or an instance of `ContentHtml`. We also give you the ability to

### Atom

Atom specification reference used: https://validator.w3.org/feed/docs/atom.html#content

#### Authors

Recommended

- Feed MUST contain at least one author element, unless all entries have an author element.
- Feed and Entries MAY have multiple authors.

#### Link

Recommended

- Must use `rel` attribute.
    - `rel` MAY be: alternate, enclosure, related, self, or via.
    - Default is alternate.
    - Feed MUST NOT have more than one alternate link.

### RSS

RSS specification reference used: https://cyber.harvard.edu/rss/

## Details

We practice the art of the soft failure. As such, if a document is malformed, we return an empty string.

We **do not** sanitize the input; therefore, it is recommended you do so prior to initializing, building, and rendering the feed.

The fundamental approach is that the required elements for each feed (and sub-element) are required by the initializer of the Document (and sub-element). Recommended, but optional, elements are optional within the initializer. Strictly optional elements may be added by calling the corresponding method; most of which use the prefix `with`.

Note: Not all specifications explicitly state whether items (or entries) are required; however, a feed without items (or entries) seems odd, therefore, we require them for each feed type. Further, if an item (or entry) does not meet the criteria of the specification, the entire document will become an empty string. We will do what we can to enable you to explore the soft failure.

When possible, we will render elements and properties in the order they appear in the reference specification.

## Other

{links or descriptions or license, versioning, and governance}
