<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifikasi') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Notifikasi</h2>

        @if($notifications->count())
            <div class="bg-white shadow rounded-md overflow-hidden">
                <ul>
                    @foreach($notifications as $notif)
                        <li class="border-b last:border-none 
                                {{ $notif->unread() ? 'bg-gray-50' : 'bg-white' }}">
                            <a href="{{ route('notifikasi.show', $notif->id) }}"
                            class="flex justify-between items-center px-4 py-3 hover:bg-gray-100">
                                <div>
                                    <p class="text-sm text-gray-800">
                                        {{ $notif->data['message'] ?? 'Notifikasi tanpa pesan' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $notif->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if($notif->unread())
                                    <span class="text-xs font-semibold text-red-600">Baru</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="bg-white shadow rounded-md p-4 text-gray-500">
                Tidak ada notifikasi
            </div>
        @endif
    </div>
</x-app-layout>

