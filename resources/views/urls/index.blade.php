<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if(auth()->user()->isSuperAdmin())
                    <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-bold mb-6">Company Members</h2>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Company</th>
                                <th class="border px-4 py-2">Users</th>
                                <th class="border px-4 py-2">Total URLs Generated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                                <tr>
                                    <td class="border px-4 py-2">{{ $company->name }}</td>
                                    <td class="border px-4 py-2 text-center">{{ $company->users_count }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-semibold">
                                            {{ $company->urls_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">No companies found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="flex justify-end mb-4 space-x-2">
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
            <a href="{{ route('invitation.create') }}" class="px-4 py-2 bg-green-500 text-black rounded-md">Invite User</a>
        @endif
        <a href="{{ route('url.create') }}" class="px-4 py-2 bg-blue-500 text-black rounded-md">Add New URL</a>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Original URL</th>
                                <th class="border px-4 py-2">Short URL</th>
                                <th class="border px-4 py-2">User</th>
                                <th class="border px-4 py-2">Company</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($urls as $url)
                                <tr>
                                    <td class="border px-4 py-2">{{ $url->original_url }}</td>
                                    <td class="border px-4 py-2"><a href="{{ route('url.redirect', $url->short_code) }}" target="_blank">{{ url($url->short_code) }}</a></td>
                                    <td class="border px-4 py-2">{{ $url->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $url->company->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">No URLs found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-6 flex justify-center">
                        {{ $urls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->isAdmin() && isset($members))
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-bold mb-6">Company Members</h2>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Role</th>
                                <th class="border px-4 py-2">Total URLs Generated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td class="border px-4 py-2">{{ $member->name }}</td>
                                    <td class="border px-4 py-2">{{ $member->email }}</td>
                                    <td class="border px-4 py-2">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                                            @if($member->role === 'admin') bg-red-100 text-red-800
                                            @elseif($member->role === 'member') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($member->role) }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-semibold">
                                            {{ $member->urls_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">No members found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
