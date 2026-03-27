<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';

interface Form {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    description: string;
    remember_me: boolean;
}

const form = useForm<Form>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    description: '',
    remember_me: false,
});

const submit = () => {
    form.post('/register', {
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="md-center-page">
        <form class="md-card md-form" style="max-width: 420px; width: 100%" @submit.prevent="submit">
            <h1 class="md-title">Регистрация</h1>

            <div class="md-field">
                <label class="md-label">Имя</label>
                <input class="md-input" type="text" placeholder="Vasia" v-model="form.name" />
            </div>

            <div class="md-field">
                <label class="md-label">Email</label>
                <input class="md-input" type="email" placeholder="example@gmail.com" v-model="form.email" />
            </div>

            <div class="md-field">
                <label class="md-label">Пароль</label>
                <input class="md-input" type="password" placeholder="qwerty123" v-model="form.password" />
            </div>

            <div class="md-field">
                <label class="md-label">Повторите пароль</label>
                <input class="md-input" type="password" placeholder="qwerty123" v-model="form.password_confirmation" />
            </div>

            <label class="md-row" style="justify-content: flex-start">
                <input type="checkbox" v-model="form.remember_me" />
                <span class="md-note">Запомнить меня?</span>
            </label>

            <button class="md-btn" type="submit" :disabled="form.processing">Войти</button>

            <div class="md-error" v-if="form.errors" v-for="(error, i) in form.errors" :key="i">{{ error }}</div>

            <div class="md-note"><Link href="/login"> Есть аккаунт? Войти </Link></div>
        </form>
    </div>
</template>
