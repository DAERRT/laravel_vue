<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';

interface Form {
    name: string;
    email: string;
    password: string;
    remember_me: boolean;
}

const form = useForm<Form>({
    name: '',
    email: '',
    password: '',
    remember_me: false,
});

const submit = () => {
    form.post('/login', {
        onSuccess: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="md-center-page">
        <form class="md-card md-form" style="max-width: 420px; width: 100%" @submit.prevent="submit">
            <h1 class="md-title">Вход</h1>

            <div class="md-field">
                <label class="md-label">Email</label>
                <input class="md-input" type="email" placeholder="example@gmail.com" v-model="form.email" />
            </div>

            <div class="md-field">
                <label class="md-label">Пароль</label>
                <input class="md-input" type="password" placeholder="qwerty123" v-model="form.password" />
            </div>

            <label class="md-row" style="justify-content: flex-start">
                <input type="checkbox" v-model="form.remember_me" />
                <span class="md-note">Запомнить меня?</span>
            </label>

            <button class="md-btn" type="submit" :disabled="form.processing">Войти</button>

            <div class="md-error" v-if="form.errors" v-for="(error, i) in form.errors" :key="i">{{ error }}</div>

            <div class="md-note">
                <Link href="/register">Нет аккаунта? Зарегистрироватся</Link>
            </div>
        </form>
    </div>
</template>
