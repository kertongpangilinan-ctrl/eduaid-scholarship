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
    canResetPassword: Boolean,
    status: String,
});

const emit = defineEmits(['close', 'switchToRegister']);

const loginForm = useForm({
    email: '',
    password: '',
    remember: false,
});

const submitLogin = () => {
    loginForm.transform(data => ({
        ...data,
        remember: loginForm.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => {
            loginForm.reset('password');
            emit('close');
        },
    });
};

const close = () => {
    emit('close');
};

const switchToRegister = () => {
    emit('switchToRegister');
};
</script>

<template>
    <div v-if="show" class="modal-overlay" @click.self="close">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-sign-in-alt mr-2"></i>Welcome Back
                    </h3>
                    <button @click="close" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div v-if="status" class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                    {{ status }}
                </div>

                <form @submit.prevent="submitLogin">
                    <div class="form-group">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="loginForm.email"
                            type="email"
                            class="input"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="error-message" :message="loginForm.errors.email" />
                    </div>

                    <div class="form-group">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            v-model="loginForm.password"
                            type="password"
                            class="input"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="error-message" :message="loginForm.errors.password" />
                    </div>

                    <div class="form-group">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="loginForm.remember" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-[#B91C1C] hover:text-[#7F1D1D] transition-colors">
                            Forgot your password?
                        </Link>

                        <PrimaryButton
                            class="btn btn-primary"
                            :class="{ 'opacity-25': loginForm.processing }"
                            :disabled="loginForm.processing"
                        >
                            <span v-if="loginForm.processing">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Logging in...
                            </span>
                            <span v-else>
                                <i class="fas fa-sign-in-alt mr-2"></i>Log in
                            </span>
                        </PrimaryButton>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <button @click="switchToRegister" class="text-[#B91C1C] hover:text-[#7F1D1D] font-semibold transition-colors">
                            Register here
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
