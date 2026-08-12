# Execute Search Workflow

<required_reading>
**Đọc trước khi execute:**
(No external prompts - uses tools directly)
</required_reading>

<purpose>
Execute a single search query using available tools, scrape relevant URLs, and prepare content for learning extraction.
</purpose>

<inputs>
| Input | Description |
|-------|-------------|
| `{query}` | The search query to execute |
| `{research_goal}` | Why we're searching this |
| `{output_file}` | Where to write results |
</inputs>

<process>
## Step 1: Execute Web Search

Use `search_web` tool:
```
search_web(query="{query}")
```

The tool returns a summary of relevant information.

## Step 2: Identify Top URLs

From search results, identify 3-5 most relevant URLs to scrape.

Selection criteria:
- Relevance to research goal
- Source credibility (official docs, reputable sites)
- Recent content (prefer newer)
- Diverse sources (not all from same site)

## Step 3: Scrape Content

For each selected URL, use `read_url_content`:
```
read_url_content(url="{url}")
```

If URL fails:
- Log error
- Continue with remaining URLs
- Don't fail entire search

## Step 4: Write Search Results

Write to `{output_file}` (e.g., `phases/depth-2/search-1.md`):

```markdown
# Search Results: Query {N}

## Query
**Search:** {query}
**Goal:** {research_goal}

## Search Summary
{summary_from_search_web_tool}

---

## Scraped Content

### Source 1: {url_1}
**Title:** {page_title}
**Relevance:** {why_selected}

{scraped_content_trimmed_to_reasonable_length}

---

### Source 2: {url_2}
**Title:** {page_title}
**Relevance:** {why_selected}

{scraped_content_trimmed_to_reasonable_length}

---

### Source 3: {url_3}
**Title:** {page_title}
**Relevance:** {why_selected}

{scraped_content_trimmed_to_reasonable_length}

---

## Metadata
- Query executed: {timestamp}
- URLs attempted: {count}
- URLs successful: {count}
- Total content: ~{word_count} words
```
</process>

<content_trimming>
To manage context, trim each scraped page:
- Keep first ~2000 words of main content
- Remove navigation, footers, ads
- Preserve code blocks and key sections
- Note if content was truncated
</content_trimming>

<error_handling>
**Search Tool Failure:**
```markdown
## Search Results: Query {N}

## Query
**Search:** {query}
**Goal:** {research_goal}

## Error
Search failed: {error_message}

Proceeding to next query...
```

**URL Scrape Failure:**
```markdown
### Source {N}: {url}
**Status:** Failed to scrape
**Error:** {error_message}
```
</error_handling>

<output_quality>
**Good Output:**
- Clear organization
- Relevant content extracted
- Sources documented
- Ready for learning extraction

**What to Avoid:**
- Too much raw HTML
- Irrelevant content (ads, navigation)
- Excessively long content (trim!)
- Missing source attribution
</output_quality>

<example>
```markdown
# Search Results: Query 1

## Query
**Search:** "autonomous AI research agent frameworks 2025 2026"
**Goal:** Find the major frameworks and tools available for building research agents

## Search Summary
The search reveals several key developments in AI research agents:
- GPT Researcher continues to lead with 25K+ stars
- LangChain's open-deep-research gaining traction
- New entrants like Khoj and Scira emerging
...

---

## Scraped Content

### Source 1: https://github.com/assafelovic/gpt-researcher
**Title:** GPT Researcher - Autonomous AI Research Agent
**Relevance:** Most-starred open-source research agent

# GPT Researcher

GPT Researcher is an autonomous agent designed for comprehensive online research on a variety of tasks.

## Features
- Autonomous research on any topic
- Multi-source fact checking
- Comprehensive reports with citations
...

(content continues, trimmed at ~2000 words)

---

### Source 2: https://docs.gptr.dev/
**Title:** GPT Researcher Documentation
**Relevance:** Official documentation with architecture details

## Architecture

GPT Researcher uses a multi-agent system with LangGraph...

---

## Metadata
- Query executed: 2026-02-06 21:35
- URLs attempted: 4
- URLs successful: 3
- Total content: ~4500 words
```
</example>

<success_criteria>
Workflow complete khi:
- [ ] search_web executed for query
- [ ] 3-5 relevant URLs identified
- [ ] URLs scraped (with error handling)
- [ ] Content trimmed to reasonable length
- [ ] Output written to {output_file}
</success_criteria>
