<x-layout>
    <x-partials.heading>Register</x-partials.heading>
    <x-forms.form method="POST" action="/register" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" />
        <x-forms.input label="Email" name="email" type="email" />
        <x-forms.input label="Password" name="password" type="password" />
        <x-forms.input label="Password Confirmation" name="password_confirmation" type="password" />

        <x-forms.divider />
        <x-forms.button>Create Account</x-forms.button>
    </x-forms.form>
</x-layout>
