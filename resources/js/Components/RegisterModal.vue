<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(['close', 'switchToLogin']);

const registerForm = useForm({
    username: '',
    email: '',
    password: '',
    'password_confirmation': '',
    terms: false,
});

const submitRegister = () => {
    registerForm.post(route('register'), {
        onFinish: () => {
            registerForm.reset('password', 'password_confirmation');
            emit('close');
        },
    });
};

const close = () => {
    emit('close');
};

const switchToLogin = () => {
    emit('switchToLogin');
};
</script>

<template>
    <div v-if="show" class="modal-overlay" @click.self="close">
        <div class="modal-content max-w-2xl">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </h3>
                    <button @click="close" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <form @submit.prevent="submitRegister">
                    <div class="form-group">
                        <InputLabel for="username" value="Username" />
                        <TextInput
                            id="username"
                            v-model="registerForm.username"
                            type="text"
                            class="input"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="error-message" :message="registerForm.errors.username" />
                    </div>

                    <div class="form-group">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="registerForm.email"
                            type="email"
                            class="input"
                            required
                            autocomplete="email"
                        />
                        <InputError class="error-message" :message="registerForm.errors.email" />
                    </div>

                    <div class="form-group">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            v-model="registerForm.password"
                            type="password"
                            class="input"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="error-message" :message="registerForm.errors.password" />
                    </div>

                    <div class="form-group">
                        <InputLabel for="password_confirmation" value="Confirm Password" />
                        <TextInput
                            id="password_confirmation"
                            v-model="registerForm.password_confirmation"
                            type="password"
                            class="input"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="error-message" :message="registerForm.errors.password_confirmation" />
                    </div>

                    <div class="form-group">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="registerForm.terms" name="terms" required />
                            <span class="ml-2 text-sm text-gray-600">I agree to the Terms of Service and Privacy Policy</span>
                        </label>
                        <InputError class="error-message" :message="registerForm.errors.terms" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <PrimaryButton
                            class="btn btn-primary w-full"
                            :class="{ 'opacity-25': registerForm.processing }"
                            :disabled="registerForm.processing"
                        >
                            <span v-if="registerForm.processing">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Creating account...
                            </span>
                            <span v-else>
                                <i class="fas fa-user-plus mr-2"></i>Register
                            </span>
                        </PrimaryButton>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <button @click="switchToLogin" class="text-[#B91C1C] hover:text-[#7F1D1D] font-semibold transition-colors">
                            Log in here
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
