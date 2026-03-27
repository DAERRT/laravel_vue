<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const form = useForm<{
    password: string;
    newPassword: string;
    newPassword_confirmation: string;
}>({
    password: '',
    newPassword: '',
    newPassword_confirmation: '',
});

const submit = () => {
    form.post('/profile/change-password');
};
</script>

<template>
    <div class="md-page">
        <div class="md-container md-stack" style="max-width: 760px">
            <div>
                <Link href="/profile"><button class="md-btn md-btn-tonal"><- Назад</button></Link>
            </div>

            <form class="md-card md-form" @submit.prevent="submit">
                <h1 class="md-title">Смена пароля</h1>

                <div class="md-field">
                    <label class="md-label">Старый пароль</label>
                    <input class="md-input" type="password" v-model="form.password" />
                </div>

                <div class="md-field">
                    <label class="md-label">Новый пароль</label>
                    <input class="md-input" type="password" v-model="form.newPassword" />
                </div>

                <div class="md-field">
                    <label class="md-label">Подтверлите новый пароль</label>
                    <input class="md-input" type="password" v-model="form.newPassword_confirmation" />
                </div>

                <button class="md-btn md-btn-success" :disabled="form.processing">Сохранить</button>

                <div class="md-error" v-if="form.errors" v-for="(error, i) in form.errors" :key="i">{{ error }}</div>
            </form>
        </div>
    </div>
</template>
