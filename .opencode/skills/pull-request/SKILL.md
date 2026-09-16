# Pull Request

Use this skill when preparing, creating, or updating a Pull Request for the active feature.

## Checks

1. Confirm the current branch is not `main`.
2. Inspect `git status`, the complete diff, and recent history.
3. Identify the files changed by the feature and exclude unrelated changes.
4. Run the project's relevant tests, linters, formatters, and other verification commands.
5. Show the exact files and changes that will be committed.

Use explicit paths with `git add`; never stage the entire working tree when unrelated changes may exist.

## Publishing

Ask for explicit user confirmation after the checks and immediately before external operations. After confirmation:

- Commit only the feature files when there are unpublished changes.
- Push the current branch.
- Create the Pull Request against `main` when no Pull Request exists for the branch.
- Include `Closes #<issue-number>` in the Pull Request body.
- Use a Markdown body with real line breaks, preferably through `--body-file`.

If a Pull Request already exists for the branch, do not create another one. Push new commits to the same branch so the existing Pull Request is updated.

Never push to `main`, merge a Pull Request, or close an issue manually.
