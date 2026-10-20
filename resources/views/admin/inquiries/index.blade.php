@extends('layouts.admin')

@section('title', 'Patient Inquiries & CRM')
@section('header', 'Visitor & Patient Inquiries (CRM)')

@section('content')
<div class="space-y-6" x-data="{ 
    activeModalInquiry: null,
    openCrmModal(inq) {
        this.activeModalInquiry = inq;
    },
    closeCrmModal() {
        this.activeModalInquiry = null;
    }
}">

    <!-- Top CRM Overview Banner -->
    <div class="bg-gradient-to-r from-navy-950 via-navy-900 to-hospital-800 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold uppercase tracking-wider text-white mb-2">
                Hospital Patient CRM
            </span>
            <h2 class="text-xl sm:text-2xl font-heading font-black tracking-tight text-white mb-1">
                Customer Inquiries & Communication Center
            </h2>
            <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-light">
                Manage visitor and patient inquiries, initiate instant 1-click WhatsApp discussions, make direct phone calls, send emails, and maintain internal follow-up logs.
            </p>
        </div>
        <div class="absolute right-0 top-0 bottom-0 w-80 bg-radial from-white/10 to-transparent pointer-events-none"></div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-2xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search & Filter Controls -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 bg-white p-1 rounded-xl border border-slate-200 shadow-2xs overflow-x-auto">
            <a href="{{ route('admin.inquiries.index', array_filter(['search' => $search])) }}" 
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($status) ? 'bg-hospital-700 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                All Inquiries
            </a>
            <a href="{{ route('admin.inquiries.index', array_filter(['status' => 'new', 'search' => $search])) }}" 
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'new' ? 'bg-emergency-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                New / Unread
            </a>
            <a href="{{ route('admin.inquiries.index', array_filter(['status' => 'in_progress', 'search' => $search])) }}" 
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'in_progress' ? 'bg-amber-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                In Progress
            </a>
            <a href="{{ route('admin.inquiries.index', array_filter(['status' => 'resolved', 'search' => $search])) }}" 
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'resolved' ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                Resolved
            </a>
            <a href="{{ route('admin.inquiries.index', array_filter(['status' => 'archived', 'search' => $search])) }}" 
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'archived' ? 'bg-slate-700 text-white shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}">
                Archived
            </a>
        </div>

        <!-- CRM Customer Search Input -->
        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="flex items-center gap-2">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative w-full sm:w-72">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}" 
                    placeholder="Search patient, phone, email..." 
                    class="w-full text-xs rounded-xl border-slate-300 pl-9 pr-8 py-2 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500"
                />
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                @if(!empty($search))
                    <a href="{{ route('admin.inquiries.index', array_filter(['status' => $status])) }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        &times;
                    </a>
                @endif
            </div>
            <button type="submit" class="px-3.5 py-2 rounded-xl bg-navy-800 hover:bg-navy-900 text-white font-bold text-xs shadow-2xs transition">
                Search
            </button>
        </form>
    </div>

    <!-- Inquiries Cards / Table -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Patient / Customer</th>
                        <th class="px-6 py-3 font-semibold">One-Click Contact</th>
                        <th class="px-6 py-3 font-semibold">Inquiry & Internal Log</th>
                        <th class="px-6 py-3 font-semibold">Received</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">CRM Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($inquiries as $inq)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $inq->phone ?? '');
                            $whatsappText = urlencode("Hello {$inq->name}, this is Ephamarcy Hospital regarding your inquiry: '{$inq->subject}'. How may we assist you?");
                            $emailSubject = urlencode("Ephamarcy Hospital Response: {$inq->subject}");
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <!-- Customer Info -->
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900 text-sm">{{ $inq->name }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $inq->email }}</div>
                                @if($inq->phone)
                                    <div class="text-xs text-slate-600 font-mono font-medium">{{ $inq->phone }}</div>
                                @endif
                            </td>

                            <!-- 1-Click Multi-Channel Contact Bar -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <!-- WhatsApp Direct -->
                                    @if($cleanPhone)
                                        <a 
                                            href="https://wa.me/{{ $cleanPhone }}?text={{ $whatsappText }}" 
                                            target="_blank" 
                                            rel="noopener noreferrer"
                                            title="Chat on WhatsApp"
                                            class="h-8 w-8 rounded-lg bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200 flex items-center justify-center transition shadow-2xs group"
                                        >
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    <!-- Direct Phone Call -->
                                    @if($inq->phone)
                                        <a 
                                            href="tel:{{ $inq->phone }}" 
                                            title="Call Phone Number"
                                            class="h-8 w-8 rounded-lg bg-sky-50 hover:bg-sky-600 text-sky-600 hover:text-white border border-sky-200 flex items-center justify-center transition shadow-2xs"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    <!-- Direct Email -->
                                    <a 
                                        href="mailto:{{ $inq->email }}?subject={{ $emailSubject }}" 
                                        title="Send Email"
                                        class="h-8 w-8 rounded-lg bg-hospital-50 hover:bg-hospital-700 text-hospital-700 hover:text-white border border-hospital-200 flex items-center justify-center transition shadow-2xs"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>

                            <!-- Message & CRM Notes -->
                            <td class="px-6 py-4 max-w-sm">
                                <div class="font-semibold text-slate-900 text-xs mb-1">{{ $inq->subject }}</div>
                                <div class="text-xs text-slate-600 line-clamp-2">{{ $inq->message }}</div>
                                @if($inq->reply_notes)
                                    <div class="mt-2 p-1.5 rounded-lg bg-hospital-50/70 border border-hospital-100 text-[11px] text-hospital-900 flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-hospital-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        <div class="line-clamp-2">
                                            <span class="font-bold">Log:</span> {{ $inq->reply_notes }}
                                        </div>
                                    </div>
                                @endif
                            </td>

                            <!-- Date Received -->
                            <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                <div>{{ $inq->created_at->format('M d, Y') }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $inq->created_at->format('H:i') }}</div>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($inq->status === 'new')
                                    <x-badge color="emergency" size="xs" :pulse="true">New / Unread</x-badge>
                                @elseif($inq->status === 'in_progress')
                                    <x-badge color="amber" size="xs">In Progress</x-badge>
                                @elseif($inq->status === 'resolved')
                                    <x-badge color="emerald" size="xs">Resolved</x-badge>
                                @else
                                    <x-badge color="slate" size="xs">Archived</x-badge>
                                @endif
                            </td>

                            <!-- CRM Actions -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        @click="openCrmModal(@js($inq))"
                                        class="px-3 py-1.5 rounded-lg bg-navy-800 hover:bg-navy-950 text-white font-bold text-xs transition shadow-2xs flex items-center gap-1.5"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        <span>CRM Notes</span>
                                    </button>

                                    <form method="POST" action="{{ route('admin.inquiries.status', $inq) }}" class="inline-flex">
                                        @csrf
                                        @method('PATCH')
                                        <select 
                                            name="status" 
                                            onchange="this.form.submit()" 
                                            class="text-xs rounded-lg border-slate-300 py-1 px-2 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500"
                                        >
                                            <option value="new" {{ $inq->status === 'new' ? 'selected' : '' }}>New</option>
                                            <option value="in_progress" {{ $inq->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $inq->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="archived" {{ $inq->status === 'archived' ? 'selected' : '' }}>Archive</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">
                                No customer inquiries found matching this criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $inquiries->links() }}
            </div>
        @endif
    </x-card>

    <!-- Interactive CRM Follow-up & Contact Modal -->
    <div 
        x-show="activeModalInquiry" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-navy-950/70 backdrop-blur-xs"
        @keydown.escape.window="closeCrmModal()"
    >
        <div 
            class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-slate-200"
            @click.away="closeCrmModal()"
        >
            <template x-if="activeModalInquiry">
                <div>
                    <!-- Modal Header -->
                    <div class="px-6 py-4 bg-navy-950 text-white rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-xl bg-hospital-600 flex items-center justify-center text-white font-bold text-sm">
                                CRM
                            </div>
                            <div>
                                <h3 class="font-heading font-black text-base text-white">
                                    Patient Touchpoint & Communication Log
                                </h3>
                                <p class="text-xs text-slate-300">
                                    Inquiry #<span x-text="activeModalInquiry.id"></span> &bull; <span x-text="activeModalInquiry.name"></span>
                                </p>
                            </div>
                        </div>
                        <button type="button" @click="closeCrmModal()" class="text-slate-400 hover:text-white text-xl leading-none">
                            &times;
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-6">
                        <!-- Customer Bio Card -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm" x-text="activeModalInquiry.name"></h4>
                                <div class="text-xs text-slate-600 font-mono mt-0.5" x-text="activeModalInquiry.email"></div>
                                <div class="text-xs text-slate-600 font-mono" x-text="activeModalInquiry.phone || 'No phone provided'"></div>
                            </div>
                            
                            <!-- Instant Contact Actions -->
                            <div class="flex items-center gap-2">
                                <template x-if="activeModalInquiry.phone">
                                    <a 
                                        :href="'https://wa.me/' + (activeModalInquiry.phone.replace(/[^0-9]/g, '')) + '?text=' + encodeURIComponent('Hello ' + activeModalInquiry.name + ', this is Ephamarcy Hospital regarding your inquiry. How may we assist you?')"
                                        target="_blank" 
                                        class="px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-2xs transition"
                                    >
                                        <span>WhatsApp Chat</span>
                                    </a>
                                </template>

                                <template x-if="activeModalInquiry.phone">
                                    <a 
                                        :href="'tel:' + activeModalInquiry.phone" 
                                        class="px-3 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs flex items-center gap-1.5 shadow-2xs transition"
                                    >
                                        <span>Call Phone</span>
                                    </a>
                                </template>

                                <a 
                                    :href="'mailto:' + activeModalInquiry.email + '?subject=' + encodeURIComponent('Response from Ephamarcy Hospital: ' + (activeModalInquiry.subject || 'Inquiry'))" 
                                    class="px-3 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs flex items-center gap-1.5 shadow-2xs transition"
                                >
                                    <span>Send Email</span>
                                </a>
                            </div>
                        </div>

                        <!-- Original Inquiry Message -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Customer Subject & Message</label>
                            <div class="p-4 rounded-xl bg-slate-100 border border-slate-200 text-xs text-slate-800 space-y-1">
                                <div class="font-bold text-sm text-slate-900" x-text="activeModalInquiry.subject"></div>
                                <div class="leading-relaxed whitespace-pre-line" x-text="activeModalInquiry.message"></div>
                            </div>
                        </div>

                        <!-- CRM Reply & Notes Form -->
                        <form 
                            method="POST" 
                            :action="'{{ url('/admin/inquiries') }}/' + activeModalInquiry.id + '/status'" 
                            class="space-y-4"
                        >
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                    Internal CRM Follow-up Log / Hospital Notes
                                </label>
                                <textarea 
                                    name="reply_notes" 
                                    rows="4" 
                                    x-text="activeModalInquiry.reply_notes || ''"
                                    placeholder="Log internal details: e.g. 'Contacted via WhatsApp on Oct 15, patient booked consultation with Dr. Kimambo for Thursday 10:00 AM.'"
                                    class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 text-slate-800 shadow-2xs focus:border-hospital-500 focus:ring-hospital-500"
                                ></textarea>
                                <p class="text-[11px] text-slate-400 mt-1">
                                    This log is retained in the hospital database for audit, doctor coordination, and front-desk follow-up.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                        Update Inquiry Status
                                    </label>
                                    <select 
                                        name="status" 
                                        x-model="activeModalInquiry.status"
                                        class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800 font-semibold focus:border-hospital-500 focus:ring-hospital-500"
                                    >
                                        <option value="new">New / Unread</option>
                                        <option value="in_progress">In Progress / Contacted</option>
                                        <option value="resolved">Resolved</option>
                                        <option value="archived">Archive</option>
                                    </select>
                                </div>
                                <div class="flex items-end justify-end">
                                    <button 
                                        type="submit" 
                                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-md transition"
                                    >
                                        Save CRM Notes & Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
@endsection
