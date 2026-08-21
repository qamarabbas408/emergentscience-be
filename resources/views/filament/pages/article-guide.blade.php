<x-filament-panels::page>
    <div class="space-y-10">

        <div>
            <h2 class="text-2xl font-bold">Article Guide</h2>
            <p class="mt-1 text-gray-500 dark:text-gray-400">
                Reference documentation for all article fields. Use this when creating or editing articles.
            </p>
        </div>

        {{-- Manuscript --}}
        <x-filament::section>
            <x-slot name="heading">Manuscript</x-slot>
            <x-slot name="description">Core content fields for the article.</x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Field</th>
                            <th class="px-4 py-2 font-semibold">Type</th>
                            <th class="px-4 py-2 font-semibold">Required</th>
                            <th class="px-4 py-2 font-semibold">Description</th>
                            <th class="px-4 py-2 font-semibold">Example</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700">
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">journal_id</td>
                            <td class="px-4 py-2">foreignId</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">The journal this article belongs to. Each article must belong to exactly one journal.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">1</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">article_type_id</td>
                            <td class="px-4 py-2">foreignId</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">The type of article (e.g. Research Article, Review, Case Report). Determines word limits and required files.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">1</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">title</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">Full article title as displayed to authors and readers.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">Climate Variability in Coastal Regions</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">abstract</td>
                            <td class="px-4 py-2">text</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">Structured summary of the article shown on listing pages and used by indexing services.</td>
                            <td class="px-4 py-2">A short paragraph summarising the study.</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">keywords</td>
                            <td class="px-4 py-2">json array</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">List of keywords used for search and discovery.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">["climate", "coastal"]</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">slug</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">URL-safe key used in article URLs. Must be unique within the journal. Use lowercase with hyphens.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">climate-variability-coastal-regions</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Identifiers --}}
        <x-filament::section>
            <x-slot name="heading">Identifiers</x-slot>
            <x-slot name="description">Standard identifiers for indexing and discovery.</x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Field</th>
                            <th class="px-4 py-2 font-semibold">Type</th>
                            <th class="px-4 py-2 font-semibold">Required</th>
                            <th class="px-4 py-2 font-semibold">Description</th>
                            <th class="px-4 py-2 font-semibold">Example</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700">
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">doi</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Digital Object Identifier. Assigned automatically on publication using the journal's <code>doi_prefix</code>.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">10.XXXX/XXXXX</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">language</td>
                            <td class="px-4 py-2">string (2)</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">ISO 639-1 language code of the manuscript. Defaults to English when not provided.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">en</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Publication Details --}}
        <x-filament::section>
            <x-slot name="heading">Publication Details</x-slot>
            <x-slot name="description">Bibliographic fields assigned when the article is published.</x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Field</th>
                            <th class="px-4 py-2 font-semibold">Type</th>
                            <th class="px-4 py-2 font-semibold">Required</th>
                            <th class="px-4 py-2 font-semibold">Description</th>
                            <th class="px-4 py-2 font-semibold">Example</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700">
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">volume</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Volume number assigned at publication.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">12</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">issue</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Issue number assigned at publication.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">3</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">page_start</td>
                            <td class="px-4 py-2">integer</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">First page number of the article within the issue.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">145</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">page_end</td>
                            <td class="px-4 py-2">integer</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Last page number of the article within the issue.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">158</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Dates --}}
        <x-filament::section>
            <x-slot name="heading">Dates</x-slot>
            <x-slot name="description">Key milestones in the editorial workflow.</x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Field</th>
                            <th class="px-4 py-2 font-semibold">Type</th>
                            <th class="px-4 py-2 font-semibold">Required</th>
                            <th class="px-4 py-2 font-semibold">Description</th>
                            <th class="px-4 py-2 font-semibold">Example</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700">
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">date_submitted</td>
                            <td class="px-4 py-2">date</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Date the author submitted the manuscript.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">2026-01-15</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">date_accepted</td>
                            <td class="px-4 py-2">date</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Date the editorial decision to accept was made.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">2026-03-02</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">publication_date</td>
                            <td class="px-4 py-2">date</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Date the article was officially published.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">2026-04-01</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Status --}}
        <x-filament::section>
            <x-slot name="heading">Status</x-slot>
            <x-slot name="description">Editorial state and usage counters for the article.</x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-2 font-semibold">Field</th>
                            <th class="px-4 py-2 font-semibold">Type</th>
                            <th class="px-4 py-2 font-semibold">Default</th>
                            <th class="px-4 py-2 font-semibold">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-700">
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">status</td>
                            <td class="px-4 py-2">enum: draft, under_review, revision, accepted, published, rejected</td>
                            <td class="px-4 py-2">draft</td>
                            <td class="px-4 py-2">Current editorial state. Only articles with status <code>published</code> are visible in the public API.</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">view_count</td>
                            <td class="px-4 py-2">integer</td>
                            <td class="px-4 py-2">0</td>
                            <td class="px-4 py-2">Number of article views. Auto-incremented on each view; not manually editable.</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">download_count</td>
                            <td class="px-4 py-2">integer</td>
                            <td class="px-4 py-2">0</td>
                            <td class="px-4 py-2">Number of file downloads. Auto-incremented on each download; not manually editable.</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">citation_count</td>
                            <td class="px-4 py-2">integer</td>
                            <td class="px-4 py-2">0</td>
                            <td class="px-4 py-2">Number of citations. Maintained manually from indexing services.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Relationships --}}
        <x-filament::section>
            <x-slot name="heading">Relationships</x-slot>
            <x-slot name="description">How articles connect to other entities in the system.</x-slot>

            <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                <p><strong>article_type</strong> — The type of article (Research Article, Review, etc.). Determines word limits and required files for submission. (Implemented)</p>
                <p><strong>journal</strong> — The journal the article belongs to. The journal's <code>doi_prefix</code> allocates DOIs on acceptance. (Implemented)</p>
                <p><strong>topics</strong> — Many-to-many. Authors select topics during submission to categorise their work. (Implemented)</p>
                <p><strong>authors</strong> — One-to-many. Ordered via <code>sort_order</code>; the corresponding author is flagged with <code>is_corresponding</code>. (Implemented)</p>
                <p><strong>files</strong> — One-to-many. Manuscript, figures and supplementary files, validated against the article type requirements. (Implemented)</p>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
