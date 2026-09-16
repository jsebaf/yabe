# Finish Feature

Finish the active feature on the current branch. `$ARGUMENTS` may contain the issue number; otherwise obtain it from `context/current-feature.md`.

## Instructions

1. Load `feature-workflow` and `pull-request`, plus all active feature context files.
2. Resolve the issue number and verify that it matches the active feature descriptor.
3. Confirm that the implementation is verified and meets the acceptance criteria. Run missing checks before continuing.
4. Confirm the current branch is not `main`.
5. Inspect `git status`, the complete diff, and recent history. Exclude unrelated changes.
6. Update `context/current-feature.md`:
   - Change the first-level heading to `# Feature actual`.
   - Empty `## Objetivos` and `## Notas`.
   - Preserve all required headings and existing history.
   - Add a one-line summary at the beginning of `## Histórico`.
7. Show the resulting descriptor and exact files to publish.
8. Ask for explicit confirmation before committing, pushing, or changing issue labels.
9. After confirmation, stage only explicit feature paths, create the final commit, and push the current branch.
10. Remove `in-progress` from the issue and add `done`.
11. Report the result. If a Pull Request already exists, the push must update that same Pull Request; never create another one.

Do not merge the Pull Request or close the issue manually.
