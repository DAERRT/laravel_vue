<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const form = useForm<{
    title: string;
    subtitle?: string;
    body: string;
}>({
    title: '',
    subtitle: '',
    body: '',
});

const submit = () => {
    form.post('/articles/create');
};
</script>

<template>
    <div class="md-page">
        <div class="md-container" style="max-width: 1000px">
            <form class="md-card md-form" @submit.prevent="submit">
                <h1 class="md-title">Создание статьи</h1>

                <div class="md-field">
                    <label class="md-label">Заголовок</label>
                    <input class="md-input" type="text" v-model="form.title" />
                </div>

                <div class="md-field">
                    <label class="md-label">Подзаголовок</label>
                    <input class="md-input" type="text" v-model="form.subtitle" />
                </div>

                <div class="md-field">
                    <label class="md-label">Статья</label>
                    <div>
                        <QuillEditor v-model:content="form.body" contentType="html" theme="snow" toolbar="full" style="height: 400px" />
                    </div>
                </div>

                <button class="md-btn" :disabled="form.processing">Создать</button>

                <div v-if="form.errors" class="md-error" v-for="error in form.errors" :key="error">{{ error }}</div>
            </form>
        </div>
    </div>
</template>
