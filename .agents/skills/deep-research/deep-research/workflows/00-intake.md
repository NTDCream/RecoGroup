# Intake Workflow

<required_reading>
**Đọc trước khi execute:**
- templates/project-structure.md
- templates/state.md
</required_reading>

<purpose>
Khởi tạo research project: thu thập query, parameters, tạo project folder.
</purpose>

<process>
## Step 1: Collect Research Topic

Ask user:
```
What would you like to research?
```

Store response as `{topic}`.

---

## Step 2: Collect Parameters

Ask user (có thể skip với defaults):
```
Research parameters:
• Breadth (2-10, default 4): How many queries per depth level?
• Depth (1-5, default 2): How many levels deep to research?
• Output type (report/answer, default report): Full report or short answer?

Enter as: breadth depth type (e.g., "4 2 report") or press Enter for defaults:
```

Parse response:
- `{breadth}` = first number or 4
- `{depth}` = second number or 2
- `{output_type}` = "report" or "answer"

---

## Step 3: Generate Project Slug

Create slug from topic:
```
{slug} = topic.toLowerCase()
              .replace(/[^a-z0-9]+/g, '-')
              .substring(0, 30)
              .replace(/-+$/, '')

{timestamp} = YYYYMMDD-HHMM format

{project_folder} = playground/deep-research-{slug}-{timestamp}/
```

---

## Step 4: Create Project Folder Structure

```bash
mkdir -p {project_folder}/phases/depth-{depth}
mkdir -p {project_folder}/phases/depth-{depth-1}
# ... for each depth level down to 0
```

---

## Step 5: Write 00-INTAKE.md

Create file `{project_folder}/00-INTAKE.md`:

```markdown
# Research Intake

## Topic
{topic}

## Parameters
| Parameter | Value |
|-----------|-------|
| Breadth | {breadth} |
| Depth | {depth} |
| Output Type | {output_type} |

## Estimated Scope
- Total queries: ~{estimate} 
- Estimated time: {time_estimate}

## Created
{timestamp}
```

Estimate formula:
- Total queries ≈ breadth × (1 + 0.5 + 0.25 + ...) up to depth levels
- Time ≈ 3-5 min per depth level

---

## Step 6: Initialize STATE.md

Create file `{project_folder}/STATE.md`:

```markdown
# Research State

## Metadata
- Project: deep-research-{slug}
- Topic: {topic}
- Created: {timestamp}
- Status: initializing

## Parameters
- Initial Breadth: {breadth}
- Initial Depth: {depth}
- Current Depth: {depth}
- Current Breadth: {breadth}
- Output Type: {output_type}

## Progress
- Total Queries Planned: ~{estimate}
- Queries Completed: 0
- Current Phase: intake

## Learnings
(none yet)

## Sources
(none yet)

## Next Context
- Current Query: {topic}
- Next Directions: (pending clarification)
```

---

## Step 7: Initialize Empty Files

Create empty files:
- `{project_folder}/LEARNINGS.md` - Header only
- `{project_folder}/SOURCES.md` - Header only

---

## Step 8: Output Summary (Brief)

Display in chat (keep minimal):
```
✅ Project initialized

📁 Folder: playground/deep-research-{slug}-{timestamp}/
📊 Parameters: breadth={breadth}, depth={depth}
📝 Output: {output_type}

→ Proceeding to clarification...
```
</process>

<next_step>
→ Go to `01-research-loop.md` which will first run clarification if output_type is "report"
</next_step>

<outputs>
| File | Content |
|------|---------|
| `00-INTAKE.md` | Topic + parameters |
| `STATE.md` | Initial state |
| `LEARNINGS.md` | Empty with header |
| `SOURCES.md` | Empty with header |
</outputs>

<success_criteria>
Workflow complete khi:
- [ ] Project folder created với correct structure
- [ ] 00-INTAKE.md written với topic và parameters
- [ ] STATE.md initialized với status "initializing"
- [ ] Empty LEARNINGS.md và SOURCES.md created
- [ ] Brief confirmation message displayed
</success_criteria>
