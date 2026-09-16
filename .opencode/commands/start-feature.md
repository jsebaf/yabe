# Start Feature

Start a feature from a GitHub Issue. `$ARGUMENTS` must contain the issue number.

## Instructions

1. Load the `feature-workflow` skill and the feature context files listed there.
2. Validate that `$ARGUMENTS` contains a valid issue number.
3. Retrieve the issue with its title, description, labels, comments, and acceptance criteria using the available GitHub tooling.
4. Update `context/current-feature.md`:
   - Set the first-level heading to the feature name.
   - Put the requirements and acceptance criteria under `## Objetivos`.
   - Put `- Issue: #<number>` under `## Notas`, along with relevant notes.
   - Preserve the existing `## Histórico` and every existing entry.
5. Show the proposed descriptor changes.
6. Ask for explicit confirmation before changing the issue labels.
7. After confirmation, add `in-progress` and remove `done` from the issue when necessary.

Stop after completing the Start phase. Do not implement the feature, create commits, push, or create a Pull Request.
