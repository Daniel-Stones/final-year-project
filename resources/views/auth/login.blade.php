<x-layout title="Sign In">
    <h1 class="center-title">Sign In</h1>
    <form method="POST" action="/login" class="input-form-background">
        @csrf
        <div class="mb-4">
            <label for="email" class="input-field-font">Email:</label>
            <input
                type="text"
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
        <div>
            <button
                type="submit"
                class="large-submit-button"
            >
                Sign In
            </button>
        </div>
    </form>
</x-layout>
