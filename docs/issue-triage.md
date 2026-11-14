<!--
Maintained and synced from 8fold/repo-skeleton, do not update outside of the 8fold/repo-skeleton repository
-->
# Issue Triage Protocol

This document defines the canonical operational procedure for issue triage, qualitative impact labeling, backlog auditing, and next-increment recommendations.

---

## Qualitative Impact Categories

Labels route maintainer and agent attention based on qualitative impact (ordered from highest to lowest priority). Multiple overlapping categories may apply to a single issue:

1. **`security/accessibility`:** Potential security vulnerabilities or accessibility defects. Use the private security reporting route for zero-day vulnerabilities.
    - Clarify that public issues flagging potential security bugs should be converted or redirected to **GitHub Private Security Advisories** (or private maintainer channels) prior to public triage.
2. **`broken`:** Functionality that does not work as promised.
3. **`annoying`:** Functionality that does not work as promised but has a workaround, or minor friction points.
4. **`refactor/re-engineer`:** Structural or explicit contract/behavior changes.
5. **`new-by-policy`:** A capability proposed, adopted, or mandated by maintainer policy or law.
6. **`new-user-request`:** A capability requested without policy authority and not yet adopted by a maintainer.

> **Escalation Path:** When a maintainer adopts an outside request (`new-user-request`), append `new-by-policy` while retaining `new-user-request` as demand evidence.

> **Priority Resolution Rule:** When an issue carries multiple qualitative impact labels, its priority during triage, backlog ordering, and increment selection is strictly governed by the **highest-ranking category** present on the issue. Lower-ranking labels serve only to provide secondary context.

---

## Focus & Disposition Labels

- **`documentation`:** Work focused on writing, reviewing, organizing, or publishing documentation. (Not a priority modifier; combine with impact categories).
- **`tracking`:** Records strategic epics, discovery tasks, or umbrella initiatives whose implementation details or downstream sub-tasks are not yet fully settled.
- **`wontfix`:** Indicates no current plans to address the issue. Exclude from active work recommendations.

---

## Triage Procedure

When auditing the backlog or recommending next steps:

1. **Pre-filter Ineligible Work:** Exclude `wontfix` issues and issues with active, linked pull requests at the search query level.
    - **Tracking Disposition:** Exclude `tracking` issues from code-implementation queues. Recommend action on a `tracking` issue only when the next increment is explicitly a *scoping, discovery, or architecture definition* task designed to unblock implementation.
2. **Metadata Sweep:** Query lightweight metadata (`#` ID, title, labels, updated date) for remaining open issues.
3. **Assess Scope & Readiness:**
   - **Impact Rubric:** If issues lack qualitative impact labels, inspect bodies to apply appropriate labels.
   - **Targeted Deep-Dive:** Fetch full comment threads and linked context only for top candidate issues under active consideration.
4. **Recommend Next Increment:** Propose the smallest useful, unblocking scope.
5. **Preserve Human Gates:** Maintain user approval boundaries before making issue or repository changes.

---

## Label Replication in Consuming Repositories

Labels are repository metadata. Clone the canonical label set to consuming projects using the GitHub CLI:

```sh
gh label clone OWNER/SOURCE-REPO --repo OWNER/TARGET-REPO
```
