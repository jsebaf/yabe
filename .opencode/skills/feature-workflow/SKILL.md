# Feature Workflow

Use this skill when a task starts, implements, verifies, publishes, or finishes a feature associated with a GitHub Issue.

## Phases

Features have three explicit phases:

1. **Start**: inspect the issue, prepare `context/current-feature.md`, and set the issue to `in-progress`.
2. **Implementation and verification**: implement the requested changes and verify the acceptance criteria.
3. **Finish**: update and clean the feature context, publish the final changes, and set the issue to `done`.

Do not advance to a later phase without an explicit user request. Completing one command must stop the workflow at that phase.

## Context

Load these files when working on a feature:

- `context/current-feature.md` for the active feature.
- `context/current-feature-file-spec.md` for the descriptor format and lifecycle.
- `context/feature-workflow.md` for the general workflow.
- `context/coding-conventions.md` for project conventions.

The feature, its GitHub Issue, and `context/current-feature.md` are linked. The descriptor must contain the active feature's objectives and notes, and `## Notas` must include `- Issue: #<number>`. Preserve all existing history when updating it.

## Issue states

Represent the feature state with mutually exclusive labels:

- `in-progress` while implementation is active.
- `done` when implementation is complete and the Pull Request is ready to merge.

Do not close the issue manually. Use `Closes #<issue-number>` in the Pull Request so GitHub closes it when the Pull Request is merged.

## Safety

- Keep unrelated work out of commits.
- Never push directly to `main`.
- Ask for explicit confirmation immediately before external operations such as issue-label changes, commits, pushes, and Pull Request creation.
- Do not merge Pull Requests or close issues manually.
