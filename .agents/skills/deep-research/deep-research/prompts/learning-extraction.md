# Learning Extraction Prompt

> **Source:** Adapted from [dzhng/deep-research](https://github.com/dzhng/deep-research/blob/main/src/deep-research.ts) - `processSerpResult()`

---

## Purpose

Extract key learnings from search results and scraped content. Learnings should be information-dense, factual, and include specific entities, metrics, and dates.

---

## Prompt Template

```
Given the following contents from a web search for the query, extract key learnings.

<query>
{query}
</query>

<research_goal>
{research_goal}
</research_goal>

<contents>
{scraped_content}
</contents>

## Instructions

1. Return a maximum of {num_learnings} learnings
2. Each learning should be UNIQUE and not similar to each other
3. Learnings should be:
   - Concise and to the point
   - As detailed and information-dense as possible
   - Include specific entities (people, companies, products, places)
   - Include exact metrics, numbers, dates when available
4. Also generate follow-up questions to research further

## Output Format

### Learnings

1. **{Entity/Topic}:** {detailed learning with specific facts, numbers, dates}
2. **{Entity/Topic}:** {detailed learning with specific facts, numbers, dates}
3. **{Entity/Topic}:** {detailed learning with specific facts, numbers, dates}

### Follow-up Questions

1. {specific question to research further}
2. {specific question to research further}
3. {specific question to research further}

### Source URLs
- {url_1}
- {url_2}
- {url_3}
```

---

## Parameters

| Parameter | Description | Default |
|-----------|-------------|---------|
| `{query}` | The search query used | Required |
| `{research_goal}` | Why we searched this | Required |
| `{scraped_content}` | Content from URLs | Required |
| `{num_learnings}` | Max learnings to extract | 3-5 |

---

## Example Output

### Learnings

1. **GPT Researcher (assafelovic/gpt-researcher):** Open-source autonomous research agent with 25,223+ GitHub stars as of Feb 2026. Uses LangGraph for multi-agent orchestration with 7 specialized agents (Browser, Editor, Researcher, Reviewer, Revisor, Writer, Publisher). Generates 5-6 page reports with citations.

2. **STORM Paper Architecture:** Stanford's STORM paper (arxiv.org/abs/2402.14207) introduced the perspective-guided article writing approach. GPT Researcher's multi-agent system is inspired by this architecture, using iterative research and review cycles.

3. **Firecrawl Adoption:** Firecrawl (firecrawl.dev) emerged as the preferred web scraping solution for AI research agents in 2025-2026, offering unified search + scrape API. dzhng/deep-research and several other projects use it as the primary data collection layer.

### Follow-up Questions

1. How does GPT Researcher's LangGraph implementation handle agent coordination and state management?
2. What are the key differences between STORM's original approach and GPT Researcher's adaptation?
3. Are there Firecrawl alternatives that offer similar capabilities for research agents?

### Source URLs
- https://github.com/assafelovic/gpt-researcher
- https://docs.gptr.dev/docs/gpt-researcher/multi_agents/langgraph
- https://arxiv.org/abs/2402.14207

---

## Key Principles

1. **Information Density** - Không generic, phải có specifics
2. **Entities** - Luôn mention specific names, products, companies
3. **Numbers** - Include metrics, dates, star counts, versions
4. **Actionable Follow-ups** - Questions lead to deeper research
5. **Source Tracking** - Ghi lại URLs cho citations
