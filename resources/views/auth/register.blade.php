<x-layouts.auth title="Register">
    <form action="/register" method="POST" class="bg-white p-6 rounded shadow-md w-96">
        @csrf
        <h1 class="text-2xl font-bold mb-4 text-center">Register</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="border w-full p-2 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="border w-full p-2 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="border w-full p-2 rounded mt-1" required>
        </div>

        <div class="mb-4">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="border w-full p-2 rounded mt-1" required>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white w-full p-2 rounded mt-2">Register</button>
        
        <div class="mt-4 text-center text-sm">
            <a href="/login" class="text-blue-500 hover:underline">Sudah punya akun? Login di sini</a>
        </div>
    </form>
</x-layouts.auth>
