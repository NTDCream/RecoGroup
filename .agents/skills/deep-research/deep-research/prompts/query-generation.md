# Query Generation Prompt

> **Source:** Adapted from [dzhng/deep-research](https://github.com/dzhng/deep-research/blob/main/src/deep-research.ts) - `generateSerpQueries()`

---

## Purpose

Generate diverse, targeted search queries from a user's research topic. Each query should have a clear research goal and follow-up directions.

---

## Prompt Template

```
Given the following prompt from the user, generate a list of SERP queries to research the topic.

<prompt>
{query}
</prompt>

{{#if learnings}}
Here are some learnings from previous research, use them to generate more specific queries:

<previous_learnings>
{learnings}
</previous_learnings>
{{/if}}

## Instructions

1. Return a maximum of {num_queries} queries
2. Make sure each query is UNIQUE and not similar to each other
3. Cover different angles/perspectives of the topic
4. For each query, explain:
   - The research goal (what we hope to find)
   - Follow-up directions (how to advance research after results)

## Output Format

### Query 1
**Search Query:** {the actual search query to use}
**Research Goal:** {why this query, what information we expect to find}
**Follow-up Directions:** {specific ways to deepen research based on expected results}

### Query 2
**Search Query:** ...
**Research Goal:** ...
**Follow-up Directions:** ...

(continue for all {num_queries} queries)
```

---

## Parameters

| Parameter | Description | Default |
|-----------|-------------|---------|
| `{query}` | User's research topic/question | Required |
| `{num_queries}` | Number of queries to generate | breadth parameter |
| `{learnings}` | Previous learnings (optional) | Empty for first iteration |

---

## Example Output

### Query 1
**Search Query:** "multi-agent AI systems architecture 2025 2026"
**Research Goal:** Find recent developments in multi-agent AI architectures, including new frameworks and methodologies emerging in 2025-2026.
**Follow-up Directions:** If promising frameworks found, research their implementation details, compare with established solutions like AutoGen and CrewAI.

### Query 2
**Search Query:** "LangGraph vs AutoGen multi-agent comparison"
**Research Goal:** Understand the key differences between major multi-agent frameworks, their strengths and weaknesses.
**Follow-up Directions:** Deep dive into the winning framework's documentation, look for real-world case studies.

### Query 3
**Search Query:** "autonomous AI research agent open source GitHub"
**Research Goal:** Find open-source implementations of autonomous research agents that can be studied or adapted.
**Follow-up Directions:** If good repos found, analyze their architecture, star count, and community activity.

### Query 4
**Search Query:** "challenges problems multi-agent AI coordination"
**Research Goal:** Understand current limitations and challenges in multi-agent systems to have a balanced view.
**Follow-up Directions:** Research proposed solutions to identified challenges, academic papers on coordination.

---

## Key Principles

1. **Diversity** - Queries should cover different angles, not just variations
2. **Specificity** - Include relevant years, terms, and context
3. **Research Goals** - Each query has a clear purpose
4. **Follow-up Ready** - Directions enable iterative deepening
5. **Build on Learnings** - Later iterations use previous findings
