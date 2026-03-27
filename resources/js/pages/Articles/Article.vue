<script setup lang="ts">
import { User } from '@/types';
import { Link, router, useForm } from '@inertiajs/vue3';

interface Article {
    id: number;
    title: string;
    subtitle?: string;
    body: string;
    author_id: number;
    author: User;
    viewers: User[];
    created_at: string;
    updated_at: string;
}

interface Rate {
    id: number;
    user_id: number;
    article_id: number;
    rate: boolean;
}

const props = defineProps<{
    article: Article;
    user: User;
    rates: Rate[];
}>();

const form = useForm();

const deleteArticle = () => {
    if (confirm('Вы уверены, что хотите удалить эту статью?')) {
        form.delete(`/articles/${props.article.id}/delete`, {
            onSuccess: () => {
                router.visit('/articles');
            },
            onError: (errors) => {
                alert('Ошибка при удалении статьи: ' + errors);
            },
        });
    }
};

const formatDate = (dateString: string) => {
    if (!dateString) return '';
    const [year, month, day, time] = [dateString.slice(0, 4), dateString.slice(5, 7), dateString.slice(8, 10), dateString.slice(11, 16)];
    return `${day}.${month}.${year} ${time}`;
};

const likes = (rates: Rate[]) => rates.filter((item) => item.rate).length;
const dislikes = (rates: Rate[]) => rates.filter((item) => !item.rate).length;
</script>

<template>
    <div class="md-page">
        <div class="md-container" style="max-width: 1000px">
            <article class="md-card md-stack">
                <div class="md-row" style="justify-content: space-between; align-items: flex-start">
                    <h1 class="md-title">{{ props.article.title }}</h1>
                    <div class="md-row" v-if="props.article.author.id === props.user.id">
                        <Link :href="`/articles/${props.article.id}/edit`"><button class="md-btn">Edit</button></Link>
                        <Link @click="deleteArticle"><button class="md-btn md-btn-danger">Delete</button></Link>
                    </div>
                </div>

                <div class="md-row" style="justify-content: space-between; align-items: flex-start">
                    <small class="md-subtitle" v-if="props.article.subtitle">{{ props.article.subtitle }}</small>
                    <small class="md-subtitle" v-if="props.article.author">Автор: {{ props.article.author.name }}</small>
                    <small class="md-subtitle" v-else>Автор: [Удаленный аккаунт]</small>
                </div>

                <div class="prose" v-html="props.article.body"></div>

                <div class="md-row" style="justify-content: space-between">
                    <div class="md-row">
                        <label class="md-chip">👁 {{ props.article.viewers.length }}</label>
                        <label class="md-chip">{{ formatDate(props.article.created_at) }}</label>
                    </div>

                    <div class="md-row">
                        <div class="md-row">
                            <Link :href="`/articles/${props.article.id}/like`"><button class="md-btn md-btn-tonal">👍</button></Link>
                            <label class="md-chip">{{ likes(props.rates) }}</label>
                        </div>
                        <div class="md-row">
                            <Link :href="`/articles/${props.article.id}/dislike`"><button class="md-btn md-btn-tonal">👎</button></Link>
                            <label class="md-chip">{{ dislikes(props.rates) }}</label>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</template>
