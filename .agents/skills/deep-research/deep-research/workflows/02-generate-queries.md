# Generate Queries Workflow

<required_reading>
**Đọc trước khi execute:**
- prompts/system.md (researcher mindset)
- prompts/query-generation.md (query structure)
</required_reading>

<purpose>
Generate diverse SERP queries from a research topic. Each query has a specific research goal and follow-up directions.
</purpose>

<inputs>
| Input | Description |
|-------|-------------|
| `{query}` | Current research query/topic |
| `{num_queries}` | Number of queries to generate (= breadth) |
| `{learnings}` | Previous learnings (empty for first iteration) |
| `{output_file}` | Where to write queries |
</inputs>

<process>
## Step 1: Apply System Prompt Mindset

Read and internalize `prompts/system.md`:
- Expert-level output
- Be proactive
- Consider contrarian ideas

## Step 2: Generate Queries

Using the prompt from `prompts/query-generation.md`:

Think through diverse angles:
1. **Direct approach** - Straightforward search for the topic
2. **Comparative** - Compare with alternatives/competitors
3. **Technical deep-dive** - Implementation details, architecture
4. **Problems/challenges** - Limitations, issues, criticisms
5. **Trends/future** - Recent developments, predictions
6. **Practical** - Real-world usage, case studies

Generate `{num_queries}` queries covering different angles.

## Step 3: Output to File

Write to `{output_file}` (e.g., `phases/depth-2/queries.md`):

```markdown
# Generated Queries - Depth {N}

## Context
- Original Query: {query}
- Previous Learnings: {count} items
- Queries to Generate: {num_queries}

---

## Queries

### Query 1
**Search Query:** {actual_search_query}
**Research Goal:** {why_this_query}
**Follow-up Directions:** {next_steps_after_results}

### Query 2
**Search Query:** {actual_search_query}
**Research Goal:** {why_this_query}
**Follow-up Directions:** {next_steps_after_results}

### Query 3
**Search Query:** {actual_search_query}
**Research Goal:** {why_this_query}
**Follow-up Directions:** {next_steps_after_results}

### Query 4
**Search Query:** {actual_search_query}
**Research Goal:** {why_this_query}
**Follow-up Directions:** {next_steps_after_results}

---

*Generated: {timestamp}*
```
</process>

<query_quality>
**Good Query Characteristics:**
- Specific, not vague
- Includes relevant context (years, versions, names)
- Searchable (would return useful results)
- Different angle from other queries

**Bad Query Examples:**
- ❌ "AI" (too vague)
- ❌ "best AI framework" (subjective, no context)
- ❌ Same topic with minor word changes

**Good Query Examples:**
- ✅ "LangGraph multi-agent orchestration tutorial 2025 2026"
- ✅ "AutoGen vs CrewAI benchmark comparison"
- ✅ "challenges limitations multi-agent AI coordination"
- ✅ "GPT Researcher architecture implementation details"
</query_quality>

<iteration_behavior>
**First Iteration (depth = initial):**
- Broad coverage
- No previous learnings
- Cover fundamental aspects

**Later Iterations (depth < initial):**
- More specific, narrower
- Build on previous learnings
- Follow up on interesting findings
- Fill gaps identified earlier
</iteration_behavior>

<example>
For topic "AI research agents 2026" with breadth=4:

```markdown
# Generated Queries - Depth 2

## Context
- Original Query: AI research agents 2026
- Previous Learnings: 0 items
- Queries to Generate: 4

---

## Queries

### Query 1
**Search Query:** "autonomous AI research agent frameworks 2025 2026"
**Research Goal:** Find the major frameworks and tools available for building research agents, understand the current landscape.
**Follow-up Directions:** For each framework found, research its architecture, community adoption, and unique features.

### Query 2
**Search Query:** "GPT Researcher vs Perplexity deep research comparison"
**Research Goal:** Understand how open-source solutions compare to commercial products, identify key differentiators.
**Follow-up Directions:** Deep dive into the winning approach's implementation, look for integration guides.

### Query 3
**Search Query:** "multi-agent AI research systems LangGraph implementation"
**Research Goal:** Understand how LangGraph enables multi-agent research workflows, find concrete examples.
**Follow-up Directions:** Study the agent orchestration patterns, state management approaches.

### Query 4
**Search Query:** "challenges problems autonomous web research AI"
**Research Goal:** Identify current limitations and problems to have a balanced view and understand trade-offs.
**Follow-up Directions:** Research proposed solutions, academic papers addressing these challenges.

---

*Generated: 2026-02-06 21:30*
```
</example>

<success_criteria>
Workflow complete khi:
- [ ] {num_queries} queries generated
- [ ] Each query covers different angle
- [ ] Each has clear research goal
- [ ] Each has follow-up directions
- [ ] Output written to {output_file}
</success_criteria>
