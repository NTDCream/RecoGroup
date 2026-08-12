---
name: deep-research
description: Use when you need to conduct comprehensive web research on any topic using recursive depth-first exploration. Adapted from dzhng/deep-research.
---

<objective>
Skill này thực hiện deep research trên bất kỳ topic nào bằng cách sử dụng **recursive depth-first search pattern**. Được adapt từ [dzhng/deep-research](https://github.com/dzhng/deep-research) repository.

**Key Features:**
- **Iterative Research** - Recursive depth-first exploration
- **Intelligent Query Generation** - LLM-generated diverse search queries
- **Depth & Breadth Control** - Configurable research parameters
- **Smart Follow-up** - Clarification questions before deep dive
- **File-Based Output** - All output to files, preserving chat context
- **Resumable State** - Can continue after context reset
</objective>

<quick_start>
```
/quick:deep-research
```

Hoặc với parameters:
```
/quick:deep-research "topic" breadth depth output_type
```
</quick_start>

<how_it_works>
```
┌─────────────────────────────────────────────────────────────────┐
│                        USER INPUT                                │
│  • Topic/Query                                                   │
│  • Breadth (default: 4) - queries per level                     │
│  • Depth (default: 2) - levels of recursion                     │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                     CLARIFICATION                                │
│  • Generate follow-up questions                                  │
│  • Collect user answers                                          │
│  • Combine into refined query                                    │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                   RESEARCH LOOP (Recursive)                      │
│                                                                  │
│  FOR current_depth FROM {depth} DOWN TO 0:                      │
│                                                                  │
│    1. Generate {breadth} search queries                         │
│    2. FOR EACH query:                                           │
│       • search_web → get results                                │
│       • read_url_content → scrape top URLs                      │
│       • Extract learnings + follow-up directions                │
│    3. Accumulate learnings + URLs                               │
│    4. IF depth > 0:                                             │
│       • breadth = breadth / 2 (narrow)                          │
│       • Use follow-ups as next query                            │
│       • Continue loop                                           │
│    5. ELSE: → Synthesis                                         │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                       SYNTHESIS                                  │
│  • Compile all learnings                                         │
│  • Write comprehensive report                                    │
│  • Include all sources                                           │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    FINAL OUTPUT                                  │
│  📄 playground/deep-research-{topic}/REPORT.md                  │
└─────────────────────────────────────────────────────────────────┘
```
</how_it_works>

<parameters>
| Parameter | Description | Range | Default |
|-----------|-------------|-------|---------|
| `breadth` | Số search queries mỗi depth level | 2-10 | 4 |
| `depth` | Số levels đi sâu (recursion) | 1-5 | 2 |
| `output_type` | Loại output | report / answer | report |

**Breadth Guidelines:**
- `2-3`: Quick research, focused results
- `4-5`: Balanced (recommended)
- `6-10`: Comprehensive but time-consuming

**Depth Guidelines:**
- `1`: Shallow, fast (~5 min)
- `2`: Standard depth (recommended, ~15 min)
- `3-5`: Very deep, comprehensive (~30+ min)

**Query Explosion Formula:**
```
Total queries ≈ breadth × (2^depth - 1) / (breadth - 1)

Examples:
- breadth=4, depth=2: ~12 queries
- breadth=4, depth=3: ~28 queries
- breadth=6, depth=2: ~18 queries
```
</parameters>

<project_structure>
Mỗi research session tạo folder trong `playground/`:

```
playground/deep-research-{topic-slug}-{timestamp}/
├── 00-INTAKE.md              # Query + parameters
├── 01-CLARIFICATION.md       # Follow-up Q&A
├── STATE.md                  # Research state (resumable)
├── phases/
│   ├── depth-2/              # Initial depth level
│   │   ├── queries.md        # Generated queries for this level
│   │   ├── search-1.md       # Search results + learnings
│   │   ├── search-2.md
│   │   ├── search-3.md
│   │   └── search-4.md
│   ├── depth-1/              # Narrowed (breadth/2)
│   │   └── ...
│   └── depth-0/              # Final depth level
│       └── ...
├── LEARNINGS.md              # Accumulated learnings (append-only)
├── SOURCES.md                # All visited URLs
└── REPORT.md                 # Final synthesized report ⭐
```
</project_structure>

<workflows_index>
| Workflow | Purpose |
|----------|---------|
| 00-intake.md | User input + project setup |
| 01-research-loop.md | Core recursive algorithm orchestration |
| 02-generate-queries.md | SERP query generation |
| 03-execute-search.md | Search execution + scraping |
| 04-extract-learnings.md | Learning extraction from results |
| 05-synthesis.md | Final report generation |

**Execution Order:**
1. **00-intake** → Create project, get parameters
2. **01-research-loop** → Orchestrate recursive research
   - Inside loop: **02** → **03** → **04**
3. **05-synthesis** → Generate final report
</workflows_index>

<prompts_index>
| Prompt | Purpose |
|--------|---------|
| system.md | Expert researcher persona |
| query-generation.md | Diverse query generation template |
| learning-extraction.md | Information-dense extraction template |
| report-writing.md | Comprehensive report writing template |
</prompts_index>

<templates_index>
| Template | Purpose |
|----------|---------|
| project-structure.md | Folder structure reference |
| state.md | STATE.md format template |
| report.md | REPORT.md format template |
</templates_index>

<state_management>
**STATE.md Format:**

```markdown
# Research State

## Metadata
- Project: deep-research-{topic}
- Status: in_progress | completed

## Parameters
- Initial Breadth: 4
- Initial Depth: 2
- Current Depth: 1
- Current Breadth: 2

## Progress
- Queries Completed: 6/12
- Current Phase: depth-1

## Next Context
- Last Query: "..."
- Next Directions:
  1. ...
  2. ...
```

**Resume Capability:**
Nếu context reset, skill có thể:
1. Read STATE.md
2. Determine current position
3. Continue from last checkpoint
</state_management>

<usage_examples>
**Basic Research:**
```
User: /quick:deep-research
Agent: What would you like to research?
User: AI agent architectures for 2026

→ Creates project, runs research, writes REPORT.md
```

**Quick Research (Low Parameters):**
```
User: /quick:deep-research "best API design practices" 2 1 answer
→ breadth=2, depth=1, quick answer
```

**Deep Research (High Parameters):**
```
User: /quick:deep-research "climate change solutions 2030" 6 3 report
→ breadth=6, depth=3, comprehensive report
```
</usage_examples>

<integration>
**Deep Query Skill:**
- Deep Research: Web-focused, recursive exploration
- Deep Query: Multi-source (files, NotebookLM), index-based navigation
- Future: Unified research experience

**NotebookLM Skill:**
- Research output có thể được feed vào NotebookLM
- Tạo podcast từ research findings
</integration>

<limitations>
1. **Sequential Execution** - Không parallel như original (có thể mitigate bằng HITL sub-agents trong tương lai)
2. **Rate Limiting** - Phụ thuộc vào search_web tool limits
3. **Context Window** - Large research cần careful state management (đã addressed bằng file-based output)
</limitations>

<source_attribution>
Skill này được adapt từ:
- **Repository:** [dzhng/deep-research](https://github.com/dzhng/deep-research)
- **Author:** David Zhang
- **License:** MIT
- **Stars:** 18,437+

**Key Adaptations:**
- Firecrawl → search_web + read_url_content
- TypeScript → Agent workflow instructions
- In-memory state → File-based persistence
- Console output → File output
</source_attribution>

<related_files>
- **Implementation Plan:** `.deep-query/orchestration/PLAN-deep-research-skill.md`
- **Deep Dive Analysis:** `.deep-query/orchestration/DEEP-DIVE-dzhng-deep-research.md`
- **Slash Command:** `.agent/workflows/quick/deep-research.md`
</related_files>

<success_criteria>
Skill execution được coi là successful khi:

- [ ] Project folder được tạo với correct structure
- [ ] Clarification questions được asked (nếu report mode)
- [ ] Research loop completes tất cả depth levels
- [ ] LEARNINGS.md chứa extracted insights
- [ ] SOURCES.md chứa tất cả visited URLs
- [ ] STATE.md reflects completed status
- [ ] REPORT.md (hoặc ANSWER.md) được generated
- [ ] Output không pollute chat context (file-based)
- [ ] User có thể resume nếu interrupted
</success_criteria>
