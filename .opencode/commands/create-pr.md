# Create Pull Request

Prepare and create the Pull Request for the feature. `$ARGUMENTS` must contain the issue number.

## Instructions

1. Load `feature-workflow` and `pull-request`, plus the active feature context.
2. Validate the issue number and confirm it matches `context/current-feature.md`.
3. Check the current branch and stop if it is `main`.
4. Inspect status, complete diff, recent history, and the files belonging to this feature.
5. Run the required verification commands and report their results.
6. Check whether a Pull Request already exists for the current branch.
7. Show the files and changes that will be published.
8. Ask for explicit confirmation before commit, push, or Pull Request creation.
9. After confirmation, stage only explicit feature paths, commit any unpublished changes, and push the current branch.
10. If no Pull Request exists, create one against `main` with `Closes #<issue-number>` in its body. If one exists, do not create another.
11. Report the Pull Request URL and stop.

Do not merge the Pull Request or close the issue manually.
