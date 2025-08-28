<x-layout>
    <div class="container mx-auto max-w-6xl mt-32 px-6 py-10 bg-gradient-to-br from-slate-200 via-slate-300 to-stone-300 rounded-2xl shadow-2xl border border-slate-400">
        {{-- Заголовок --}}
        <h1 class="text-4xl font-extrabold text-center text-slate-800 mb-8 tracking-wide">Список користувачів</h1>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full text-sm text-left text-gray-800 bg-white rounded-lg overflow-hidden">
                <thead class="text-xs uppercase bg-slate-600 text-white">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Ім'я</th>
                        <th class="px-6 py-4">Номер</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Роль</th>
                        <th class="px-6 py-4">Зареєстрований</th>
                        <th class="px-6 py-4">Верефікований</th>
                        <th>Керування</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-violet-100 transition duration-200">
                            <td class="px-6 py-4">{{ $user->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->phone }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->email_verified_at ? 'bg-emerald-200 text-emerald-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $user->email_verified_at ? 'Так' : 'Ні' }}
                                </span>
                            </td>
                           <td><a href="{{ route('observe-user')}}" class="inline-block text-xs font-semibold bg-green-200 text-emerald-800 px-2 py-1 rounded-full">Огляд</a></td> 
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
