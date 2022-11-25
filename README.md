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

The fundamental approach is that the required elements for each feed (and sub-element) are required by the initializer of the Document (or sub-element). Recommended, but optional, elements are optional within the initializer. Strictly optional elements may be added by calling the corresponding method; most of which use the prefix `with`.

## Other

{links or descriptions or license, versioning, and governance}
