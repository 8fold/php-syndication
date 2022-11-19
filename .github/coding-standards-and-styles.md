# Coding Standards and Styles

Coding standards help multiple developers work in the same codebase and not have to answer certain questions because they are already answered by the standards. Further, whenever possible, if the language being discussed has community accepted standards or a governing body, those standards should be used. Finally, minimal exceptions can be made with just cause so long as those changes minimize cognitive load across the majority of developers working in the various codebases.

For example, the [w3c](https://www.w3.org/) is the generally accepted governing body for HTML and CSS; therefore, when it comes to answering questions or disputes related to HTML or CSS, that's where one should go. ECMAScript is the generally accepted standard for JavaScript. And, the PHP Framework Interop Group \([PHP-Fig](https://www.php-fig.org)\) is the same for PHP.

Therefore, if I, as a developer, go from the 8fold Component, to Laravel, to AMOS, there are certain conventions I should be able to reasonably expect.

## PHP

Standards come in the form of PHP Standards Recommendations \([PSRs](https://www.php-fig.org/psr/)\) proposals are made, debated, modified, and potentially accepted. As the PHP-FIG discusses proposals that could impact all PHP developers, the PSRs are generally not accepted lightly.

If no commentary is added for a specific PSR or section of a PSR, it is safe to assume following the full specification is desired. Modifications and extensions will be indicated by _italics_.

* [**PSR-1**](https://www.php-fig.org/psr/psr-1/)**:**
	* PSR-1 is the base recommendation and is required by both of the following recommendations.
* [**PSR-2**](https://www.php-fig.org/psr/psr-2/)**:**
  * As visibility is required and the following are not, `abstract`, `final`, _and_ `static` must precede visibility. If `static` is present, it must come directly before the visibility. _These modifications front-load the answering of the following questions in turn: Do I need to implement it? Can I override it? Is it a class function or instance method? From where can I see it, if at all?
  * Opening braces for control structures MUST go on the same line, and closing braces MUST go on the next line after the body. _The body of a control structure SHOULD be followed by a blank line to distinguish between discreet thoughts. The body MAY be preceded by a blank line to reduce visual complexity and minimize blurring the lines._
* [**PSR-12**](https://github.com/php-fig/fig-standards/blob/master/proposed/extended-coding-style-guide.md)**:** This PSR is under review. With that said, it is the primary recommendation followed. Specifically-multi line control structures.
  * 2.5: _Unless a library we use needs something else. At which point we should notify the library authors._
  * 4.4: _See modifications from PSR-2._
  * 4.5: _Any method returning a value MUST declare a return type. Methods SHOULD NOT return null (void is exception), favoring an empty value of the correct type. Wildcard arguments that can be of_ any _type SHOULD be avoided, and arguments SHOULD have a type specified._
  * 5.1: _See modifications from PSR-2 regarding ordering._
  * 5.2: _See modifications from PSR-2 regarding control structures._
  * 5.6: _See modifications from PSR-2 regarding control structures._
  * 6: _Ternary operators SHOULD NOT be used unless simple in form and MUST NOT be more than one unless as an artifact of a library being used. Unary operators SHOULD be avoided to clearly express the intent and reduce possible ordering problems \(ex. x-- may not be the same as --x; whereas x-y and y-x is clearly understood\)._
* **Other**
  * Variables SHOULD NOT be nullable. Instead of null, use an empty variation of the same type. This reduces boilerplate null-checking code.

