# Project Structure Template

## Template

Khi tạo project folder, sử dụng structure sau:

```
playground/deep-research-{slug}-{timestamp}/
│
├── 00-INTAKE.md              # Initial query + parameters
├── 01-CLARIFICATION.md       # Follow-up Q&A (if report mode)
├── STATE.md                  # Current research state
│
├── phases/                   # Research phases by depth
│   ├── depth-{N}/            # Initial depth (e.g., depth-2)
│   │   ├── queries.md        # Generated queries for this level
│   │   ├── search-1.md       # Results for query 1
│   │   ├── search-2.md       # Results for query 2
│   │   ├── search-3.md       # Results for query 3
│   │   └── search-4.md       # Results for query 4
│   ├── depth-{N-1}/          # Next depth (e.g., depth-1)
│   │   ├── queries.md
│   │   ├── search-1.md
│   │   └── search-2.md       # Narrowed breadth
│   └── depth-0/              # Final depth
│       ├── queries.md
│       └── search-1.md
│
├── LEARNINGS.md              # Accumulated learnings (append-only)
├── SOURCES.md                # All visited URLs
│
└── REPORT.md                 # Final synthesized report
    (or ANSWER.md if answer mode)
```

---

## Naming Convention

### Project Folder

Format: `deep-research-{slug}-{timestamp}`

- `{slug}`: Topic lowercase, spaces to hyphens, max 30 chars
- `{timestamp}`: YYYYMMDD-HHMM

Examples:
- `deep-research-ai-agents-2026-20260206-2130`
- `deep-research-climate-change-solutions-20260206-1445`

### Depth Folders

Format: `depth-{N}`

- Start from initial depth (e.g., `depth-2`)
- Count down to `depth-0`

### Search Files

Format: `search-{N}.md`

- Sequential numbering per depth level
- N = 1 to breadth (at that level)

---

## File Purposes

| File | Purpose | When Written |
|------|---------|--------------|
| `00-INTAKE.md` | Initial setup | At start |
| `01-CLARIFICATION.md` | Refined query | After clarification |
| `STATE.md` | Progress tracking | Updated throughout |
| `phases/*/queries.md` | Generated queries | Before searches |
| `phases/*/search-*.md` | Search results | During research |
| `LEARNINGS.md` | Accumulated insights | Appended per search |
| `SOURCES.md` | All URLs | Appended per search |
| `REPORT.md` | Final output | At end |

---

## Quick Reference: Folder Count

| Depth | Folders Needed |
|-------|----------------|
| 1 | depth-1, depth-0 |
| 2 | depth-2, depth-1, depth-0 |
| 3 | depth-3, depth-2, depth-1, depth-0 |
| 4 | depth-4, depth-3, depth-2, depth-1, depth-0 |
| 5 | depth-5, depth-4, depth-3, depth-2, depth-1, depth-0 |
