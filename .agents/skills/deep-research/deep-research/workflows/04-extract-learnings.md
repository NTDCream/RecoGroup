# Extract Learnings Workflow

<required_reading>
**Đọc trước khi execute:**
- prompts/learning-extraction.md (extraction criteria)
</required_reading>

<purpose>
Extract key learnings from search results. Produce information-dense insights and follow-up research directions.
</purpose>

<inputs>
| Input | Description |
|-------|-------------|
| `{search_file}` | Path to search results file |
| `{query}` | Original search query |
| `{research_goal}` | Why we searched this |
</inputs>

<process>
## Step 1: Read Search Results

Read content from `{search_file}` (e.g., `phases/depth-2/search-1.md`)

## Step 2: Apply Extraction Prompt

Using `prompts/learning-extraction.md`, analyze the scraped content.

Key extraction criteria:
1. **Unique insights** - Not repetitive
2. **Information-dense** - Specific facts, not vague statements
3. **Entities included** - Names, companies, products
4. **Numbers included** - Metrics, dates, versions, counts
5. **Actionable follow-ups** - Questions leading to deeper research

## Step 3: Format Learnings

For each learning, format as:
```
**{Entity/Category}:** {Detailed learning with specific facts, numbers, and context}
```

## Step 4: Append to LEARNINGS.md

Append to project's `LEARNINGS.md`:

```markdown
---

## Learnings from: {query}
*Depth: {current_depth} | Query: {query_number}*

### Key Learnings

1. **{Entity_1}:** {learning_with_specifics}

2. **{Entity_2}:** {learning_with_specifics}

3. **{Entity_3}:** {learning_with_specifics}

### Follow-up Directions
- {direction_1}
- {direction_2}
- {direction_3}
```

## Step 5: Append to SOURCES.md

Append URLs to project's `SOURCES.md`:

```markdown
## From Query: {query}
- {url_1}
- {url_2}
- {url_3}
```

## Step 6: Return Follow-up Directions

Return the follow-up questions/directions for use in next iteration:
```
[direction_1, direction_2, direction_3]
```
</process>

<quality_guidelines>
**Good Learnings:**
- ✅ "**GPT Researcher:** Open-source research agent with 25,223 GitHub stars (as of Feb 2026). Uses LangGraph for 7-agent coordination. Average report is 5-6 pages with 10-30 citations."
- ✅ "**Firecrawl:** Unified search+scrape API adopted by 15+ major research agent projects. Offers 1000 free API calls/month."

**Bad Learnings:**
- ❌ "GPT Researcher is a good tool" (no specifics)
- ❌ "AI agents can do research" (too vague)
- ❌ "Many frameworks exist" (uninformative)

**Good Follow-up Directions:**
- ✅ "How does GPT Researcher's LangGraph implementation handle state management between agents?"
- ✅ "What are the cost differences between Firecrawl and Tavily for research agent use cases?"

**Bad Follow-up Directions:**
- ❌ "Learn more about AI" (too vague)
- ❌ "Research agents" (not a question)
</quality_guidelines>

<deduplication>
Before appending, check if similar learning exists:
- Same entity + similar fact → Skip or merge
- Same entity + new fact → Add
- New entity → Add
</deduplication>

<example>
**Appended to LEARNINGS.md:**

```markdown
---

## Learnings from: "autonomous AI research agent frameworks 2025 2026"
*Depth: 2 | Query: 1 of 4*

### Key Learnings

1. **GPT Researcher (assafelovic/gpt-researcher):** Most-starred open-source research agent with 25,223 GitHub stars. Uses LangGraph for multi-agent coordination with 7 specialized agents: Browser, Editor, Researcher, Reviewer, Revisor, Writer, Publisher. Inspired by Stanford's STORM paper.

2. **LangGraph Adoption:** Emerged as the de facto standard for multi-agent orchestration in 2025-2026. Used by GPT Researcher, LangChain's open-deep-research, and several enterprise solutions. Provides state management, conditional routing, and human-in-the-loop support.

3. **Research Output Standards:** Modern research agents produce 5-6 page reports with 10-30 sources, inline citations, and structured sections (Executive Summary, Findings, Conclusions). PDF/Docx/Markdown export is standard.

### Follow-up Directions
- Deep dive into GPT Researcher's LangGraph agent definitions and coordination logic
- Compare LangGraph with AutoGen's conversation-based approach for multi-agent systems
- Research the STORM paper's methodology for perspective-guided article generation
```

**Appended to SOURCES.md:**

```markdown
## From Query: "autonomous AI research agent frameworks 2025 2026"
- https://github.com/assafelovic/gpt-researcher
- https://docs.gptr.dev/docs/gpt-researcher/multi_agents/langgraph
- https://arxiv.org/abs/2402.14207
```
</example>

<error_handling>
**Empty Search Results:**
```markdown
---

## Learnings from: {query}
*Depth: {depth} | Query: {N}*

### Key Learnings
(No content could be extracted from this search)

### Follow-up Directions
- Try alternative search terms
- Broaden or narrow the query
```

**Low Quality Content:**
If scraped content is mostly irrelevant:
1. Extract what's available
2. Note limitations
3. Suggest better search terms as follow-up
</error_handling>

<success_criteria>
Workflow complete khi:
- [ ] Search results read và analyzed
- [ ] Key learnings extracted (information-dense)
- [ ] LEARNINGS.md updated với new insights
- [ ] SOURCES.md updated với URLs
- [ ] Follow-up directions returned for next iteration
</success_criteria>
