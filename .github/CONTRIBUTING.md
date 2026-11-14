<!--
Maintained and synced from 8fold/repo-skeleton, do not update outside of the 8fold/repo-skeleton repository
-->

# Contributing

Contributions are **welcome** and will be **credited**. We accept contributions via pull requests to the GitHub project repository.

## Commit & PR discipline

- **Single-Classification Commits:** A single commit MUST NOT mix Refactoring and Re-engineering changes.
- **Conventional Commits Syntax:**
  - `refactor:` Internal restructuring without behavior changes (**Refactoring**).
  - `feat:`, `fix:`, `perf:` Observable capabilities or contract updates (**Re-engineering**).
  - `docs:`, `test:`, `chore:` Maintenance, verification, or documentation.
  - `BREAKING CHANGE:` footer for breaking contract changes.
- **PR Template Compliance:** Inspect [the pull request template](PULL_REQUEST_TEMPLATE.md), complete all required sections, and classify each meaningful change in the PR body.

## Priorities

We leverage GitHub's labeling system to inform prioritization of issues; see [issue triage](../docs/issue-triage.md) for details.

Security and accessibility are always the highest priority within the applicable scope of the project. Therefore, some packages are low-level and intended for developers and give the flexibility to them to surround the package within a security layer.

## Overall goals (philosophy and values)

There are a lot of philosphical things tied in to the way we strive to do software development. Some you are most likely familiar with, others maybe not so much.

**You ain't gonna need it (YAGNI):** If someone hasn't asked for it, someone's not paying for it, and it's not needed to finish what has been asked and paid for, then don't develop that thing. (There are some extreme corner cases here, but they are extreme and rare.) (Drawback: Exploration and innovation often require doing things people haven't asked for and aren't paying for.)

**Don't repeat yourself (DRY):** If you are about to copy and paste that bit of code, reconsider. If you have a method that does exactly what you need it to, creating two means there's a possibility one will get out of sync or miss out on that update you make in a few months. (Drawback: DRY can sometimes lead to abstractions that would be easier to maintain if they remained more concrete.)

**Keep it simple, stupid:** (I could really live without the "stupid" piece.) Write the simplest code that could work. (This one actually comes with a lot of caveats, but it does hold true quite often.)

**Make it SOLID:** This is actually a set of principles in and of itself:

- *Single responsibility principle:* Each thing you write should have one responsibility. Specifically classes.
- *Open/closed principle:* Objects should be open for extension, but closed to modification.
- *Liskov substitution principle:* Object should be replaceable by subtypes without affecting the correctness of the program.
- *Interface segregation principle:* Prefer client-specific interfaces over generic catch-all interfaces.
- *Dependency inversion principle:* Admittedly, don't really know this one well enough to say we follow it or not. (Most likely not as well as we could.)

**Solutions over scapegoats:** There are times when these principles will not be followed or someone will make a mistake. Berating the offender doesn't get any of us any closer to improving the execution of these principles.

**The Community Principle:** If you create or acquire it you help maintain it; time, food, money, and so on.

## Code promotion

Capabilities should be implemented at a low, concrete level before being promoted to higher-levels and made more abstract.

## Code access

If the language being used allows access levels on variables, constants, methods, and so on, it is preferred that the access level begins at the most strict and becomes less restrictive out of necessity. (A desire to create a test for the thing, does not constitute a necessity.)

This reduces the size of the public API, which makes the class easier to consume by developers.

Further, it is preferred that class properties remain private, always. This means pre- and post-processing for setting and getting properties can be added without being a breaking change to developers.
