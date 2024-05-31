<div>
    <form wire:submit.prevent="register">

        <div class="mt-4">
            <label for="user_type">User Type</label>
            <select id="user_type" wire:model="user_type" required>
                <option value="individual">Individual</option>
                <option value="company">Company</option>
            </select>
            @error('user_type')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>


        <div x-data="{ userType: @entangle('user_type') }">
            <div x-show="userType === 'individual'">
                <div>
                    <label for="name">Name</label>
                    <input id="name" type="text" wire:model="name" required autofocus autocomplete="name">
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <label for="family_name">Family Name</label>
                <input id="family_name" type="text" wire:model="family_name" required autofocus
                    autocomplete="family_name">
                @error('family_name')
                    <span class="error">{{ $message }}</span>
                @enderror
                <div>

                </div>
            </div>

            <div x-show="userType === 'company'">
                <label for="company_name">Company Name</label>
                <input id="company_name" type="text" wire:model="company_name" required>
                @error('company_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <label for="email">Email</label>
            <input id="email" type="email" wire:model="email" required>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="password">Password</label>
            <input id="password" type="password" wire:model="password" required autocomplete="new-password">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation" required
                autocomplete="new-password">
            @error('password_confirmation')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="phone_number">Phone Number</label>
            <input id="phone_number" type="text" wire:model="phone_number" required>
            @error('phone_number')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="birthday">Birthday</label>
            <input id="birthday" type="date" wire:model="birthday" required>
            @error('birthday')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>



        <div class="mt-4" x-data="{ userType: @entangle('user_type') }">
            <div x-show="userType === 'individual'">
                <label for="fiscal_code">Fiscal Code</label>
                <input id="fiscal_code" type="text" wire:model="fiscal_code">
                @error('fiscal_code')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div x-show="userType === 'company'">
                <label for="vat_number">VAT Number</label>
                <input id="vat_number" type="text" wire:model="vat_number">
                @error('vat_number')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <label for="street">Street</label>
            <input id="street" type="text" wire:model="street" required>
            @error('street')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="city">City</label>
            <input id="city" type="text" wire:model="city" required>
            @error('city')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="province">State</label>
            <input id="province" type="text" wire:model="province" required>
            @error('state')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="postal_code">Postal Code</label>
            <input id="postal_code" type="text" wire:model="postal_code" required>
            @error('postal_code')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <label for="country">Country</label>
            <input id="country" type="text" wire:model="country" required>
            @error('country')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <input type="checkbox" id="same_address" wire:model="same_address" value="1">
            <label for="same_address">Use same address for billing</label>
        </div>

        <div class="mt-4" x-data="{ sameAddress: @entangle('same_address') }" x-show="!sameAddress">
            <div class="mt-4">
                <label for="billing_street">Billing Street</label>
                <input id="billing_street" type="text" wire:model="billing_street">
                @error('billing_street')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="billing_city">Billing City</label>
                <input id="billing_city" type="text" wire:model="billing_city">
                @error('billing_city')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="billing_state">Billing State</label>
                <input id="billing_state" type="text" wire:model="billing_state">
                @error('billing_state')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="billing_postal_code">Billing Postal Code</label>
                <input id="billing_postal_code" type="text" wire:model="billing_postal_code">
                @error('billing_postal_code')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <label for="billing_country">Billing Country</label>
                <input id="billing_country" type="text" wire:model="billing_country">
                @error('billing_country')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="ml-4">
                Register
            </button>
        </div>
    </form>
</div>
