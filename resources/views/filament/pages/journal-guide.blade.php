<x-filament-panels::page>
    <div class="space-y-10">

        <div>
            <h2 class="text-2xl font-bold">Journal Guide</h2>
            <p class="mt-1 text-gray-500 dark:text-gray-400">
                Reference documentation for all journal fields. Use this when creating or editing journals.
            </p>
        </div>

        {{-- Identity --}}
        <x-filament::section>
            <x-slot name="heading">Identity</x-slot>
            <x-slot name="description">Core identification fields for the journal.</x-slot>

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
                            <td class="px-4 py-2 font-mono text-xs">slug</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">URL-safe key used in journal URLs. Must be unique. Use lowercase with hyphens.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">earth-science</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">title</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">Full journal name as displayed to authors and readers.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">Emerging Science</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">abbreviation</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Short form used in citations.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">Emerg. Sci.</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">doi_prefix</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">Yes</td>
                            <td class="px-4 py-2">DOI registrant prefix assigned by Crossref. Used to auto-allocate DOIs to manuscripts.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">10.3390</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Identifiers --}}
        <x-filament::section>
            <x-slot name="heading">Identifiers</x-slot>
            <x-slot name="description">Standard serial identifiers for indexing and discovery.</x-slot>

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
                            <td class="px-4 py-2 font-mono text-xs">issn</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Print ISSN. Required for most indexing services (Scopus, Web of Science).</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">1234-5678</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">eissn</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Electronic ISSN. Identifies the online version.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">1234-5679</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Metadata --}}
        <x-filament::section>
            <x-slot name="heading">Metadata</x-slot>
            <x-slot name="description">Descriptive fields about the journal's scope and publication policy.</x-slot>

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
                            <td class="px-4 py-2 font-mono text-xs">discipline</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Primary subject area. Used for categorisation and filtering.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">Earth Science</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">license</td>
                            <td class="px-4 py-2">string</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Default licence applied to published articles.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">CC-BY 4.0</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">scope</td>
                            <td class="px-4 py-2">text</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Aims &amp; scope statement shown on the journal homepage.</td>
                            <td class="px-4 py-2">A short paragraph about the journal's mission.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Status --}}
        <x-filament::section>
            <x-slot name="heading">Status</x-slot>
            <x-slot name="description">Controls whether the journal is visible and accepting submissions.</x-slot>

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
                            <td class="px-4 py-2 font-mono text-xs">is_active</td>
                            <td class="px-4 py-2">boolean</td>
                            <td class="px-4 py-2">true</td>
                            <td class="px-4 py-2">When off, the journal is hidden from the public API (returns 404) and is not accepting submissions.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- COPE Billing --}}
        <x-filament::section>
            <x-slot name="heading">COPE Billing</x-slot>
            <x-slot name="description">
                <span class="text-warning-600 dark:text-warning-400 font-semibold">These fields contain billing data.</span>
                Per COPE guidelines, this information is permissioned away from editorial and decision-making views. These fields are <strong>not exposed</strong> in the public API.
            </x-slot>

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
                            <td class="px-4 py-2 font-mono text-xs">apc_amount</td>
                            <td class="px-4 py-2">decimal(10,2)</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">Article Processing Charge. Used to generate APC invoices.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">1500.00</code></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-mono text-xs">apc_currency</td>
                            <td class="px-4 py-2">string (3)</td>
                            <td class="px-4 py-2">No</td>
                            <td class="px-4 py-2">ISO 4217 currency code for the APC amount.</td>
                            <td class="px-4 py-2"><code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">USD</code> <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">CHF</code> <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">EUR</code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        {{-- Relationships --}}
        <x-filament::section>
            <x-slot name="heading">Relationships</x-slot>
            <x-slot name="description">How journals connect to other entities in the system.</x-slot>

            <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                <p><strong>sections</strong> — Journals contain sections. Each section groups manuscripts. (Coming soon)</p>
                <p><strong>topics</strong> — Sections contain topics. Finest-grained categorisation. (Coming soon)</p>
                <p><strong>special_issues</strong> — Journals can run special issues with own scope, deadlines, guest editors. (Coming soon)</p>
                <p><strong>manuscripts</strong> — Belong to a journal via section. Journal's <code>doi_prefix</code> allocates DOIs on acceptance. (Coming soon)</p>
                <p><strong>apc_invoices</strong> — Generated from journal APC fields. Permissioned away from editorial views per COPE. (Coming soon)</p>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
