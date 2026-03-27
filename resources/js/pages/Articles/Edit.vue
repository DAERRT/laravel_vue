<script setup lang="ts">
import { User } from '@/types';
import { useForm, Link } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

interface Article {
    id: number;
    title: string;
    subtitle?: string;
    body: string;
    author_id: number;
    author: User;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    article: Article;
}>();

const form = useForm<{
    id: number;
    title: string;
    subtitle?: string;
    body: string;
}>({
    id: props.article.id,
    title: props.article.title,
    subtitle: props.article.subtitle,
    body: props.article.body,
});

const submit = () => {
    form.post(`/articles/${props.article.id}/edit`);
};
</script>

<template>
    <div class="md-page">
        <div class="md-container" style="max-width: 1000px">
            <form class="md-card md-form" @submit.prevent="submit">
                <input v-model="props.article.id" hidden="true" />

                <h1 class="md-title">Edit Article</h1>

                <div class="md-field">
                    <label class="md-label">Title</label>
                    <input class="md-input" type="text" v-model="form.title" />
                </div>

                <div class="md-field">
                    <label class="md-label">Subtitle</label>
                    <input class="md-input" type="text" v-model="form.subtitle" />
                </div>

                <div class="md-field">
                    <label class="md-label">Body</label>
                    <QuillEditor v-model:content="form.body" contentType="html" theme="snow" toolbar="full" style="height: 400px" />
                </div>

                <div class="md-row" style="justify-content: center">
                    <Link :href="`/articles/${props.article.id}`"><button class="md-btn md-btn-tonal" type="button"><- Back</button></Link>
                    <button class="md-btn md-btn-success" type="submit" :disabled="form.processing">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>
