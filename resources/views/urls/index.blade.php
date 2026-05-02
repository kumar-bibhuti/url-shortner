<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Url List') }}
        </h2>
    </x-slot>
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
                            @foreach($urls as $url)
                                <tr>
                                    <td class="border px-4 py-2">{{ $url->original_url }}</td>
                                    <td class="border px-4 py-2"><a href="{{ route('url.redirect', $url->short_code) }}" target="_blank">{{ url($url->short_code) }}</a></td>
                                    <td class="border px-4 py-2">{{ $url->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $url->company->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
