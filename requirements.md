# How MDPI Works Internally — Research Notes for System Design

Source: MDPI's own published editorial process, "For Editors" page, and peer-review policy pages (mdpi.com), current as of Aug 2026.

---

## 1. Business Model (why the workflow looks the way it does)

- MDPI is a pure **Open Access / APC (Article Processing Charge)** publisher. No subscriptions. Authors (or their institutions/funders) pay a fee **only if the article is accepted**, which funds peer-review management, copyediting, and hosting.
- Critically: **APC information is walled off from the people making the accept/reject decision.** Academic Editors never see fee data — this is a COPE-driven anti-conflict-of-interest control. This is a real design requirement, not a nice-to-have: your system needs a hard permission boundary between "billing" and "editorial decision" roles/data.
- ~500+ journals run on **one shared submission platform** ("SuSy") and one shared in-house operations team, rather than each journal having its own bespoke system. This "one platform, many journals" model is probably the most relevant architectural fact for you: journals are basically **tenants/config profiles** (own scope, own board, own article types, own fees) on top of a common engine (submission, review, decision, production).

## 2. The Two Population Types

MDPI's internal world splits cleanly into two groups, and your data model should probably mirror this:

**A. In-house staff (employees, salaried, sit in MDPI offices)**
- Managing Editor — coordinates the *entire* editorial process for a given journal (assigns staff, owns the pipeline for that title)
- Assistant Editor — does the operational legwork per manuscript: sends review invitations, chases reviewers/authors, runs technical pre-check
- Production Editor / English Editor / Copyeditor / Data Specialist — post-acceptance: copyediting, language editing, XML/PDF/HTML conversion
- Software Engineers, Administrative Specialists

**B. External/academic actors (unpaid or honorarium, affiliated with universities, work via one-time-use links — no account needed)**
- Editor-in-Chief (EiC) — owns journal scope, final oversight, 2-year term
- Section Editor-in-Chief / Co-Section EiC — same but scoped to a "Section" (a journal sub-category)
- Associate Editor — deputizes for EiC/Section EiC
- Advisory Board Member — pre-screens submissions, helps with appeals/ethics disputes
- Statistical Editor — checks methodology/stats rigor specifically
- Editorial Board Member — the pool of subject-matter people who review + make decisions in their field; can be scoped to a Section
- Guest Editor — owns a *Special Issue* (a themed sub-collection with its own scope, its own call for papers, its own mini-review pipeline)
- Topic Editor / Collection Editor — same idea as Guest Editor but for "Topics" (cross-journal thematic groupings) and permanent "Topical Collections"
- Subject Editor — works across many journals in one discipline to grow "Topics"
- Topical Advisory Panel — a bench of vetted reviewers/near-board-members being groomed for promotion to full Editorial Board
- Early Career Editorial Board Members — junior board seats with lighter duties (review ≥4/year)
- Reviewer — anonymous by default (single-anonymized: reviewer knows author identity, author doesn't know reviewer's), can opt into "open identity" (sign the report). No account required — accesses everything through a tokenized one-time link.

**Key modeling implication:** a person can hold *multiple roles simultaneously across multiple journals* (e.g., Editorial Board Member on Journal A, ordinary Reviewer on Journal B, Guest Editor of a Special Issue on Journal A). Roles are scoped to (journal, and optionally section/special-issue/topic), not just to a person.

## 3. The Manuscript Lifecycle (state machine)

This is the core workflow — essentially a finite state machine with branching and loop-back states:

```
SUBMITTED
   │
   ▼
TECHNICAL PRE-CHECK (Editorial Office / Assistant Editor)
   - ethics screening, format/scope check, plagiarism scan (iThenticate),
     image-integrity scan, duplicate-submission check
   - reviewer shortlist compiled (author-suggested + office-suggested,
     screened for conflict of interest, minus author-excluded names)
   │
   ├─► REJECTED (fails pre-check) ──► END
   │
   ▼
EDITORIAL PRE-CHECK (Academic Editor)
   - scope fit + scientific soundness judgement
   - approves/edits the reviewer shortlist
   │
   ├─► REJECTED
   ├─► REVISION REQUESTED (before peer review)
   ▼
PEER REVIEW
   - Editorial Office sends invites, tracks accept/decline
   - min. 2 reviewers required (3rd pulled in if the first two disagree
     substantially)
   - normal SLA: 7–10 days per reviewer (revision-round SLA: 3 days)
   - extensions grantable on request
   │
   ▼
FIRST EDITORIAL DECISION (Academic Editor, after ≥2 reports in)
   - options: accept as-is / minor revision / major revision (reconsider)
     / reject-no-resubmit / reject-encourage-resubmit / request more reviewers
   │
   ├─► MINOR REVISION ──► author has 5 days ──► re-check ──► loop
   ├─► MAJOR REVISION ──► author has 10 days ──► may go back to
   │        same reviewers (up to ~2 rounds typically) ──► loop
   ├─► REJECT + encourage resubmit ──► new manuscript ID, LINKED to
   │        original, same reviewers reused
   ▼
FINAL EDITORIAL DECISION (Academic Editor)
   - accept in current form / accept after minor revision /
     reject-no-resubmit / reject-encourage-resubmit
   - SPECIAL RULE: if the Academic Editor wants to accept despite a
     reviewer recommending rejection → "double decision" required:
     Editorial Board Member or EiC gives a second independent opinion,
     which becomes the binding final call.
   │
   ├─► REJECTED ──► author may APPEAL within 3 months, using a
   │        structured appeal form → routed to a different Academic
   │        Editor for an advisory recommendation → validated by EiC →
   │        that decision is final, no further appeal
   ▼
PRODUCTION (in-house only, no Academic Editor involvement)
   copyediting → English editing → author proofreading → corrections
   → pagination → XML/PDF/HTML generation → publish (continuous —
   articles go live individually, not batched by "issue")
```

Things worth stealing directly for your schema:
- **Manuscript has a version history**, not a single doc — resubmissions get a new ID but a `parent_manuscript_id` link.
- **Decisions are an audit log, not a single status field** — each decision event records who made it, at what stage, with what reviewer reports attached.
- Two independent SLA clocks: reviewer response time and author revision time, both configurable per stage.
- Reviewer identity is stored **decoupled from what the author sees** (support single-anon, double-anon, and open/signed as three separate visibility modes per journal/reviewer choice).
- If rejected, review reports/identities are never published — visibility rules differ pre/post decision.

## 4. Collections above the single manuscript

MDPI doesn't just have "journal → article." There's a layer of curated sub-collections that each behave like a mini-journal with their own editor and own call for papers:

| Construct | Scope | Owner role | Notes |
|---|---|---|---|
| Journal | top-level | Editor-in-Chief | has Sections |
| Section | sub-category within a journal | Section Editor-in-Chief | e.g. discipline split within a broad journal |
| Special Issue | themed, time-boxed, within one journal | Guest Editor | has its own scope/title/CFP, feeds into normal review pipeline |
| Topic | cross-journal, thematic | Topic Editor / Subject Editor | spans multiple journals |
| Topical Collection | permanent, within a journal | Collection Editor | like a Special Issue but ongoing/no end date |

If you're building "a system of this sort," this hierarchy (Journal → Section → [Special Issue | Topical Collection], plus cross-cutting Topics) is probably the single most important structural decision to get right early, since roles, scope-of-visibility, and review-routing all key off it.

## 5. Systems & Tooling MDPI Actually Names Publicly

- **SuSy** (susy.mdpi.com) — the shared submission/peer-review/decision system across all journals. Reviewers and external editors use **one-time tokenized URLs**, not full accounts — worth copying: it removes onboarding friction for people who review once a year.
- **iThenticate** — plagiarism/similarity checking, run at pre-check and again pre-acceptance.
- Internal **AI-assisted Reviewer Finder** — NLP matching of manuscript topic against a citation database (they use their own "Scilit" index, 180M+ articles) to suggest qualified reviewers by publication history.
- **Duplicate Submission Checker** — cross-publisher check via the STM Integrity Hub (industry-shared plagiarism/duplicate-submission registry — an existing consortium you could eventually plug into rather than reinvent).
- Internal template-detection tooling to flag reviewers submitting generic/boilerplate reports, and self-citation-request flagging.
- Explicit policy: Academic Editors are **banned** from pasting manuscript content into generative AI tools during review (confidentiality policy) — worth having as a stated policy in your own system even if you can't enforce it technically, and worth thinking about if you want to offer in-system AI assistance to editors (it would need to run inside your own controlled environment, not a third-party API call with the raw manuscript).

## 6. Governance / Ethics Layer

- Formal COPE (Committee on Publication Ethics) membership — they follow published external standards rather than inventing their own, and cite specific frameworks per manuscript type: ICMJE (medical), CONSORT (RCTs), PRISMA (systematic reviews), ARRIVE (animal studies), TOP (transparency standards), FAIR (data).
- Authorship disputes, misconduct allegations, and retraction handling go through a defined COPE flowchart process, not ad hoc judgement.
- No author may review or decide on their own submission (basic conflict-of-interest rule) — again, likely a hard constraint in your permissions model (reviewer_id != any author_id on the same manuscript).

## 7. Suggested Core Entities for Your Data Model

Based on the above, a first-pass schema would likely need at least:

- `users` (with role assignments scoped per journal/section/special-issue, not global roles)
- `journals`, `sections`, `special_issues`, `topics`, `topical_collections`
- `manuscripts` (+ `manuscript_versions`, `parent_manuscript_id` for resubmissions)
- `reviews` (report content, recommendation, visibility mode, timestamps, SLA deadline)
- `decisions` (event log: stage, decision type, actor, timestamp, linked review reports)
- `conflicts_of_interest` (declared per user per manuscript)
- `apc_invoices` (deliberately isolated/permissioned away from editorial-decision views)
- `appeals`
- `production_assets` (copyedited files, XML/PDF/HTML renditions, versioned)

---

## 8. Comparative Landscape — How Other Publishers Differ

MDPI is one model. Here's how the other major players diverge, and what's worth borrowing from each.

### Open Journal Systems (OJS / PKP) — the open-source reference implementation

The most useful comparison for you, since **the actual codebase is public** (PHP, github.com/pkp/ojs) — you can read real schema and workflow code, not just marketing copy.

- Used by 44,000+ journals in 148 countries — mostly small/independent/university-run journals, not big commercial publishers.
- **Fully role-based and re-nameable**: default roles are Journal Manager, Editor, Section Editor, Author, Reviewer, Copyeditor, Layout Editor, Proofreader, Reader, plus Site Administrator. Crucially, OJS 3.x lets an admin **rename any role or invent custom roles** and attach them to any workflow stage — this is a much more flexible permissions model than MDPI's fixed role list.
- Same person, multiple roles, switchable per context — same principle as MDPI but implemented with a first-class "assign user to role at stage X" table rather than baked-in job titles.
- Workflow is explicitly **stage-skippable**: journals can turn off copyediting or proofreading entirely and just hit "Send to Production." Good pattern for you — don't hardcode all stages as mandatory; make each stage a configurable on/off toggle per journal.
- Plugin architecture (like WordPress) — new features bolt on without touching core. Worth considering if you want a small core (submission → review → decision → publish) with everything else (plagiarism checks, DOI registration, AI reviewer-matching) as pluggable modules.
- Supports single-blind, double-blind, or open review, configurable per journal, same as MDPI.
- Weakness noted in independent usability research: OJS scored below-average on usability (SUS 65.5, "poor" by convention) — mainly around submission, registration, and password recovery flows. If you build a simpler, more modern onboarding than OJS, that alone is a differentiator.

### Frontiers — a genuinely different review *model*, not just different roles

Frontiers is the one publisher here whose actual review **mechanics** differ from MDPI's, not just its org chart.

- **Two-phase review**: Phase 1 "Independent Review" — reviewers assess privately, like everywhere else. Phase 2 "Interactive Review" — author, reviewers, and the handling ("Associate") Editor then move into a **live, threaded, real-time discussion forum** on the platform until they reach consensus or the editor closes it. This is structurally different from MDPI's private-report → editor-decides model; it's closer to a collaborative doc/thread than a report queue.
- Reviewers are *named on the published article* (not just optionally, as in MDPI's open-identity opt-in) — identity disclosure is the default policy, not a choice.
- Roles: Chief Editor (journal/section-level, like EiC), Associate Editor (per-manuscript handling editor, invites reviewers, moderates the interactive phase), Review Editor (the standing pool of reviewers), Research Integrity Team (separate from editorial — investigates misconduct/manipulation independent of the people making the accept/reject call).
- Internal tooling named: "Digital Editorial Office" (dashboard for Chief Editors), "myFrontiers" (unified per-user view across all their editorial/review/authoring activity), and the "Collaborative Review platform" itself.
- **Design implication for you**: if you ever want a more modern, less report-centric experience, model your `reviews` table around **threaded discussion entries with an author-reply flag**, not just one static report submission per reviewer — this supports both the classic MDPI-style model (one report, no thread) and a Frontiers-style iterative discussion, using the same schema.

### Editorial Manager (Aries Systems, owned by Elsevier's parent-adjacent ecosystem) & ScholarOne (Clarivate) — the commercial incumbents

These two systems, not MDPI's SuSy or PKP's OJS, run the review pipeline for the *majority* of the world's journals (Elsevier, Springer Nature, Wiley, and most society journals license one of these rather than building in-house).

- Both are **licensed SaaS**, configured per-journal by the publisher, not open-source — this is the "enterprise" end of the market and the most direct commercial comparison for what you're building.
- ScholarOne: "wizard-style" submission (linear step-by-step: enter info → upload files → auto-build a PDF → review → submit); very structured task-list UI for editors ("Reviewer Selection," "Make Decision," etc. as explicit checklist items); used by 7,000+ journals; owned by Clarivate (who also run the Web of Science citation index — same "own the whole research-infrastructure stack" logic MDPI applies with Scilit).
- Editorial Manager: more configurable/flexible per-journal, more concise homepage/task list, widely used across medical/health journals — but scored poorly in independent usability testing (SUS 34.5, "awful"), largely due to dense, dated UI and unclear system status feedback.
- **Takeaway**: the dominant systems are not loved by their users. Both score below the general software usability benchmark (68) in independent studies. That's a real opening — a lot of the "moat" here is entrenchment (journals don't want to re-migrate 10 years of manuscript history) rather than product quality. For a regional/niche launch this matters less than for a challenger to Elsevier, but it's worth knowing the bar is genuinely low.

### PLOS — nonprofit, similar shape to MDPI but different decision-maker terminology

- Structurally close to MDPI: **Academic Editor** = the person who actually runs peer review and decides per manuscript (equivalent to MDPI's Academic Editor); **Section Editor** = higher-level oversight of a subject area (roughly MDPI's Section EiC); Editor-in-Chief above that.
- Uses Editorial Manager (the Aries product above) as its actual platform — PLOS doesn't run its own bespoke system, another data point for "most publishers rent the pipeline software rather than build it."
- Publicly documented pipeline timing (PLOS ONE, third-party analysis): desk-reject rate ~20–31%, in-house technical + fit check before Academic Editor assignment, Academic Editor then invites 2–3 external reviewers, median time-to-first-decision ~29 days. This is a useful real-world SLA benchmark if you want to show journals expected turnaround stats in your own product.
- Distinct feature: publishes reviewer reports optionally, and separately maintains public annual "thank you" credit lists of everyone (editors, guest editors, reviewers) who served that year — a lightweight reputation/recognition mechanic you could replicate cheaply (a public, opt-in "reviewed for [journal] in [year]" credit) since unpaid reviewers list this on CVs/grant applications.

### Cross-Publisher Comparison Table

| | MDPI | OJS (PKP) | Frontiers | Editorial Manager / ScholarOne | PLOS |
|---|---|---|---|---|---|
| Ownership of platform | In-house (SuSy) | Open-source, self-hosted | In-house | Licensed SaaS (Aries / Clarivate) | Licensed (uses Editorial Manager) |
| Review visibility default | Single-anon (reviewer sees author) | Configurable | Single-anon, but reviewer named at publication | Configurable by journal | Configurable, transparent review optional |
| Review interaction style | Static report → editor decides | Static report → editor decides | Two-phase: private review, then live threaded discussion | Static report → editor decides | Static report → editor decides |
| Decision-maker | Academic Editor (+ "double decision" escalation) | Editor/Section Editor | Associate Editor | Varies by journal config | Academic Editor (+ Section Editor oversight) |
| Roles model | Fixed named roles | Fully configurable/renameable roles | Fixed named roles + separate integrity team | Configurable per journal | Similar to MDPI |
| Access for external reviewers | One-time tokenized links, no account | Full account | Full account (myFrontiers) | Full account | Full account |
| Typical adopter | Publisher's own 500+ journal portfolio | Small/independent/university journals | Publisher's own 100+ journal portfolio | Large commercial publishers, societies | Nonprofit, PLOS's own journal family |

### What This Means for Your System

1. **Steal OJS's configurability, not its UI.** A stage-skippable, role-renameable workflow engine is the right underlying architecture even for a small regional launch — it costs little extra now and saves a rebuild later if you add journals with different needs.
2. **Steal MDPI's tokenized-link access for reviewers/external editors.** Forcing every occasional reviewer to create and remember an account is friction that both Editorial Manager and ScholarOne still have, and it's a real source of the poor usability scores above.
3. **Consider Frontiers' threaded-discussion model as an optional review mode**, not the default — it's more engaging but requires more moderation overhead than your team likely has at launch. Build the reviews table to support it later without a schema rewrite (see suggested schema note above: reviews as threaded entries, not just flat reports).
4. **The commercial incumbents' weak usability is your actual competitive opening**, more than any specific feature — both dominant systems score below-average in independent usability research. A clean, fast, mobile-usable editor/reviewer dashboard is a legitimate differentiator, not a nice-to-have.
5. **PLOS's public reviewer credit list** is a cheap, high-goodwill feature (unpaid reviewers want CV-able proof of service) worth including from day one.

---

**Sources:** mdpi.com/editorial_process, mdpi.com/editors, mdpi.com/reviewers, blog.mdpi.com (Peer Review Week 2025 posts on AI tooling); pkp.sfu.ca, openjournalsystems.com (OJS 3 User Guide), en.wikipedia.org/wiki/Open_Journal_Systems; frontiersin.org (peer review, editor guidelines, progress report 2022); enago.com, capterra.com, theeditorialhub.com, researchgate.net (Editorial Manager / ScholarOne comparisons); journals.plos.org (editor resources, editorial process pages), manusights.com (PLOS ONE timing analysis).