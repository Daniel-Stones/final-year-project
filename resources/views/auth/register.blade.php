<x-layout title="Register">
    <h1 class="center-title">Register</h1>

    @if ($errors->any())
        <div class="max-w-md mx-auto mb-6">
            <div class="bg-red-100 text-red-700 p-4 rounded w-full">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="/register" class="input-form-background">
        @csrf
        <div class="mb-4">
            <label for="name" class="input-field-font">Name:</label>
            <input
                type="text"
                id="name"
                name="name"
                class="input-field"
                placeholder="Enter your name"
                required
            />
        </div>
        <div class="mb-4">
            <label for="email" class="input-field-font">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                class="input-field"
                placeholder="Enter your email"
                required
            />
        </div>
        <div class="mb-4">
            <label for="password" class="input-field-font">Password:</label>
            <input
                type="password"
                id="password"
                name="password"
                class="input-field"
                placeholder="Enter your password"
                required
            />
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="input-field-font">Confirm Password:</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="input-field"
                placeholder="Confirm your password"
                required
            />
        </div>
        <div>
            <button
                type="submit"
                class="large-submit-button"
            >
                Register
            </button>
        </div>
    </form>
</x-layout>
