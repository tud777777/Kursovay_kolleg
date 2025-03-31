<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {nextTick, onMounted, ref} from "vue";

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    patronymic: user.patronymic,
    phone: user.phone,
    email: user.email,
});

const phoneInput = ref<HTMLInputElement | null>(null);

const formatPhoneNumber = (value: string): string => {
    const cleaned = value.replace(/\D/g, '');
    let formatted = '';

    if (cleaned.length > 0) {
        formatted = `+${cleaned.substring(0, 1)}`;
    }
    if (cleaned.length > 1) {
        formatted += ` (${cleaned.substring(1, 4)}`;
    }
    if (cleaned.length > 4) {
        formatted += `) ${cleaned.substring(4, 7)}`;
    }
    if (cleaned.length > 7) {
        formatted += `-${cleaned.substring(7, 9)}`;
    }
    if (cleaned.length > 9) {
        formatted += `-${cleaned.substring(9, 11)}`;
    }

    return formatted;
};

const formatPhone = (event: Event): void => {
    const target = event.target as HTMLInputElement;
    const selectionStart = target.selectionStart;
    const previousLength = target.value.length;

    form.phone = formatPhoneNumber(target.value);

    // Корректируем позицию курсора
    if (selectionStart && form.phone.length > previousLength) {
        nextTick(() => {
            if (phoneInput.value) {
                phoneInput.value.setSelectionRange(selectionStart + 1, selectionStart + 1);
            }
        });
    }
};

const handleKeyDown = (e: KeyboardEvent): void => {
    // Разрешаем: backspace, delete, tab, escape, enter, стрелки
    const allowedKeys = [46, 8, 9, 27, 13, 110];
    const arrowKeys = [35, 36, 37, 38, 39, 40];

    if (
        allowedKeys.includes(e.keyCode) ||
        (e.keyCode === 65 && e.ctrlKey) || // Ctrl+A
        arrowKeys.includes(e.keyCode)
    ) {
        return;
    }

    // Запрещаем все, кроме цифр
    if (
        (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
        (e.keyCode < 96 || e.keyCode > 105)
    ) {
        e.preventDefault();
    }
};

// Инициализация значения при загрузке
onMounted(() => {
    if (phoneInput.value && phoneInput.value.value) {
        form.phone = formatPhoneNumber(phoneInput.value.value);
    }
});

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="last_name" value="Last name" />

                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div>
                <InputLabel for="first_name" value="First name" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div>
                <InputLabel for="patronymic" value="Patronymic" />

                <TextInput
                    id="patronymic"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.patronymic"
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.patronymic" />
            </div>

            <div>
                <InputLabel for="phone" value="Phone number" />

                <TextInput
                    id="phone"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    autofocus
                    autocomplete="name"
                    type="tel"
                    ref="phoneInput"
                    @input="formatPhone"
                    @keydown="handleKeyDown"
                    placeholder="+7 (___) ___-__-__"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
