<div>
    <form wire:submit.prevent="login">


        <div class="mt-4">
            <label for="email">Email</label>
            <input id="email" type="email" wire:model="email" required autofocus>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="password">Password</label>
            <input id="password" type="password" wire:model="password" required>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <input type="checkbox" id="remember_me" wire:model="remember_me">
            <label for="remember_me">Remember Me</label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="ml-4">
                Login
            </button>
        </div>
    </form>
</div>
