<script setup lang="ts">
import { User } from '@/types';
import { Link } from '@inertiajs/vue3';

interface Articles {
    id: number;
    title: string;
    subtitle?: string;
    body: string;
    author_id: number;
    author: User;
    viewers: User[];
    raters: User[];
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    articles: Articles[];
}>();

const formatDate = (dateString: string) => {
    if (!dateString) return '';
    const [year, month, day, time] = [dateString.slice(0, 4), dateString.slice(5, 7), dateString.slice(8, 10), dateString.slice(11, 16)];
    return `${day}.${month}.${year} ${time}`;
};
</script>

<template>
    <div class="md-page">
        <div class="md-container md-stack">
            <template v-if="props.articles.length >= 1">
                <Link v-for="article in props.articles" :key="article.id" :href="`/articles/${article.id}`">
                    <article class="md-card md-stack">
                        <h1 class="md-title">{{ article.title }}</h1>
                        <div class="md-row" style="justify-content: space-between; align-items: flex-start">
                            <small class="md-subtitle" v-if="article.subtitle">{{ article.subtitle }}</small>
                            <small class="md-subtitle" v-if="article.author">Автор: {{ article.author.name }}</small>
                            <small class="md-subtitle" v-else>Автор: [Удаленный аккаунт]</small>
                        </div>
                        <div class="md-row" style="justify-content: flex-end">
                            <label class="md-chip">👁 {{ article.viewers.length }}</label>
                            <label class="md-chip">{{ formatDate(article.created_at) }}</label>
                        </div>
                    </article>
                </Link>
                <Link href="/articles/create"><button class="md-btn md-btn-success md-fab">+</button></Link>
            </template>
            <p v-else class="md-note">Тут пока ничего нет. Станьте первым!</p>
        </div>
    </div>
</template>
