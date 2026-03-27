<script setup lang="ts">
import { User } from '@/types';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    user: User;
}>();

const form = useForm<{
    name: string;
    email: string;
    description?: string;
}>({
    name: props.user.name,
    email: props.user.email,
    description: props.user.description,
});
const submit = () => {
    form.post('/profile/edit');
};
</script>

<template>
    <div class="md-page">
        <div class="md-container md-stack" style="max-width: 760px">
            <div>
                <Link href="/profile"><button class="md-btn md-btn-tonal"><- Назад</button></Link>
            </div>
            <form class="md-card md-form" @submit.prevent="submit">
                <h1 class="md-title">Редактирование</h1>

                <div class="md-field">
                    <label class="md-label">Имя</label>
                    <input class="md-input" type="text" v-model="form.name" />
                </div>

                <div class="md-field">
                    <label class="md-label">Email</label>
                    <input class="md-input" type="email" v-model="form.email" />
                </div>

                <div class="md-field">
                    <label class="md-label">О себе</label>
                    <textarea class="md-textarea" v-model="form.description"></textarea>
                </div>

                <button class="md-btn md-btn-success" :disabled="form.processing">Сохранить</button>
            </form>
        </div>
    </div>
</template>
