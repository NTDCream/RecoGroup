# Research Loop Workflow

<required_reading>
**Đọc trước khi execute:**
- prompts/system.md (researcher persona)
- prompts/query-generation.md (nếu generating queries)
- templates/state.md (state format)
</required_reading>

<purpose>
Core recursive research algorithm. Orchestrates query generation, search execution, and learning extraction across depth levels.
</purpose>

<prerequisites>
- `00-intake.md` completed
- `STATE.md` exists with initial state
- Project folder structure created
</prerequisites>

<algorithm>
```
deepResearch(query, breadth, depth, learnings):
    
    # Step 1: Generate diverse queries
    queries = generateQueries(query, breadth, learnings)
    
    # Step 2: For each query
    FOR query in queries:
        results = search_web(query)
        scraped = read_url_content(top_urls)
        new_learnings = extractLearnings(scraped)
        learnings += new_learnings
    
    # Step 3: Recursion check
    IF depth > 0:
        new_query = build from follow-up directions
        new_breadth = breadth / 2 (min 1)
        return deepResearch(new_query, new_breadth, depth-1, learnings)
    ELSE:
        return learnings
```
</algorithm>

<process>
## Step 0: Clarification (if report mode)

**Only if `output_type == "report"`:**

Read `prompts/system.md` for mindset, then:

1. Generate 3 follow-up questions to clarify research direction:
   ```
   Given topic "{topic}", generate 3 clarifying questions to understand:
   - Specific focus areas
   - Depth of technical detail needed
   - Any constraints or preferences
   ```

2. Ask user each question, collect answers

3. Write to `{project_folder}/01-CLARIFICATION.md`:
   ```markdown
   # Clarification
   
   ## Questions & Answers
   
   **Q1:** {question_1}
   **A1:** {answer_1}
   
   **Q2:** {question_2}
   **A2:** {answer_2}
   
   **Q3:** {question_3}
   **A3:** {answer_3}
   
   ## Combined Query
   
   Original: {topic}
   
   Refined: {topic} with focus on {answer_1}, considering {answer_2}, and {answer_3}
   ```

4. Update `{combined_query}` for research

---

## Step 1: Initialize Loop Variables

```
current_depth = {depth} (from STATE.md)
current_breadth = {breadth}
current_query = {combined_query} or {topic}
all_learnings = [] (or read from LEARNINGS.md if resuming)
all_sources = [] (or read from SOURCES.md if resuming)
```

---

## Step 2: Depth Level Loop

**FOR current_depth FROM {depth} DOWN TO 0:**

### 2.1 Update State
Update `STATE.md`:
```markdown
## Progress
- Current Phase: depth-{current_depth}
- Current Query: {current_query}
- Current Breadth: {current_breadth}
```

### 2.2 Generate Queries
Execute `02-generate-queries.md` with:
- query = {current_query}
- num_queries = {current_breadth}
- learnings = {all_learnings}

Output to: `phases/depth-{current_depth}/queries.md`

### 2.3 Execute Searches
FOR EACH query (index i = 1 to current_breadth):

Execute `03-execute-search.md` with:
- query = {query_i}
- research_goal = {goal_i}
- output_file = `phases/depth-{current_depth}/search-{i}.md`

### 2.4 Extract Learnings
FOR EACH search result:

Execute `04-extract-learnings.md` with:
- search_file = `phases/depth-{current_depth}/search-{i}.md`

Append to: `LEARNINGS.md`, `SOURCES.md`

### 2.5 Aggregate Follow-up Directions
Collect all follow-up questions from this depth level.
Combine into next query.

### 2.6 Recursion Decision

```
IF current_depth > 0:
    current_depth = current_depth - 1
    current_breadth = max(1, floor(current_breadth / 2))
    current_query = combined follow-up directions
    → Continue to next iteration
ELSE:
    → Break loop, proceed to synthesis
```

---

## Step 3: Synthesis

Execute `05-synthesis.md` with:
- topic = {topic}
- clarification = content of 01-CLARIFICATION.md
- learnings = content of LEARNINGS.md
- sources = content of SOURCES.md

Output to: `REPORT.md` (or `ANSWER.md` if answer mode)

---

## Step 4: Final State Update

Update `STATE.md`:
```markdown
## Metadata
- Status: completed

## Progress
- Current Phase: synthesis
- Queries Completed: {total}

## Summary
- Total Learnings: {count}
- Total Sources: {count}
- Report: REPORT.md
```

---

## Step 5: Completion Message (Brief)

Display in chat:
```
✅ Deep Research Complete!

📁 Project: playground/deep-research-{slug}/
📄 Report: REPORT.md
📊 Stats: {X} queries, {Y} sources

Open REPORT.md to view full findings.
```
</process>

<error_handling>
**Search Failure:**
If `search_web` fails for a query:
1. Log error in search file
2. Continue with remaining queries
3. Do not fail entire research

**Context Window Concern:**
If response getting large:
1. Always output to files, not chat
2. Use brief chat messages only
3. State is saved, can resume

**Resume from Checkpoint:**
If context resets:
1. Read STATE.md
2. Determine current_depth, current_query
3. Continue from last checkpoint
</error_handling>

<state_transitions>
```
intake → clarification → depth-N → depth-N-1 → ... → depth-0 → synthesis → completed
```
</state_transitions>

<success_criteria>
Workflow complete khi:
- [ ] Clarification collected (if report mode)
- [ ] All depth levels processed
- [ ] LEARNINGS.md contains accumulated insights
- [ ] SOURCES.md contains all visited URLs
- [ ] STATE.md updated to "completed"
- [ ] REPORT.md (or ANSWER.md) generated
- [ ] Brief completion message displayed
</success_criteria>
