# State Template

## Template for STATE.md

```markdown
# Research State

## Metadata
- Project: deep-research-{slug}
- Topic: {original_topic}
- Created: {timestamp}
- Status: {status}

## Parameters
- Initial Breadth: {initial_breadth}
- Initial Depth: {initial_depth}
- Current Depth: {current_depth}
- Current Breadth: {current_breadth}
- Output Type: {report|answer}

## Progress
- Total Queries Planned: ~{estimate}
- Queries Completed: {completed}
- Current Phase: {phase}

## Checkpoints
| Depth | Breadth | Status | Queries Done |
|-------|---------|--------|--------------|
| {N}   | {B}     | ✅/🔄/⏳ | {count}     |
| ...   | ...     | ...    | ...          |

## Accumulated
- Learnings: {count} items
- Sources: {count} URLs

## Current Context
- Last Query: "{query}"
- Next Directions:
  1. {direction_1}
  2. {direction_2}
  3. {direction_3}
```

---

## Status Values

| Status | Meaning |
|--------|---------|
| `initializing` | Project just created |
| `clarifying` | Collecting follow-up answers |
| `researching` | In research loop |
| `synthesizing` | Writing final report |
| `completed` | Research done |
| `paused` | Can resume |
| `error` | Something went wrong |

---

## Phase Values

| Phase | Meaning |
|-------|---------|
| `intake` | Initial setup |
| `clarification` | Follow-up Q&A |
| `depth-N` | Researching at depth N |
| `synthesis` | Final report generation |

---

## Checkpoint Status Icons

| Icon | Meaning |
|------|---------|
| ✅ | Completed |
| 🔄 | In progress |
| ⏳ | Pending |
| ❌ | Error/Skipped |

---

## Example Filled State

```markdown
# Research State

## Metadata
- Project: deep-research-ai-agents-2026-20260206-2130
- Topic: AI research agents landscape 2026
- Created: 2026-02-06 21:30
- Status: researching

## Parameters
- Initial Breadth: 4
- Initial Depth: 2
- Current Depth: 1
- Current Breadth: 2
- Output Type: report

## Progress
- Total Queries Planned: ~12
- Queries Completed: 6
- Current Phase: depth-1

## Checkpoints
| Depth | Breadth | Status | Queries Done |
|-------|---------|--------|--------------|
| 2     | 4       | ✅     | 4            |
| 1     | 2       | 🔄     | 2            |
| 0     | 1       | ⏳     | 0            |

## Accumulated
- Learnings: 12 items
- Sources: 18 URLs

## Current Context
- Last Query: "LangGraph multi-agent state management patterns"
- Next Directions:
  1. Explore AutoGen's conversation-based alternative
  2. Research CrewAI's approach to agent coordination
  3. Find benchmarks comparing framework performance
```

---

## Resume Logic

When resuming from checkpoint:

1. Read STATE.md
2. Check `Status`: if not `completed`, can resume
3. Check `Current Phase`: determines where to continue
4. Read `Current Context` for next query
5. Continue from that point
