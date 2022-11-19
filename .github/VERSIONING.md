# Versioning

All packages follow [Semantic Versioning 2.0](https://semver.org/) as closely as possible.

If there is a standard release schedule it will be noted in the read-me. For the most part, we prefer releasing on demand over a recurring date.

How we define the parts of the semantic version notation of: MAJOR.MINOR.PATCH

**Major:** We knowingly changed the way you interact with the package. (Chances are this means we needed to modify the way an existing test works in order to pass.)

**Minor:** We added functionality in a way that should not impact the way you already interact with the package; however, we may have introduce new ways. (Chances are we had to write new tests to cover the change.)

**Patch:** One or more bits of functionality were shown not to work as intended and we fixed them without effecting current behavior. (Chances are we wrote new tests to cover the discovered defect and the fix didn’t alter how you interact with the package.)

## Zero-major

The zero-major signifies the package is still seeing rapid and consistent changes in architecture and could fundamentally change often.

**Minor (on a zero-major):** Signifies that we knowingly changed the way you interact with the package while still a zero-major version.

**Patch (on a zero-major):** Signifies we added features, fixed defects, or both without knowingly changing the way you interact with the package.

## Non-versions

If you use a package that is not versioned, you are essentially using a package that could change at any level, at any time, with little to know knowledge of what or how a change might affect you and your application.
