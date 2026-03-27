<script setup lang="ts">
import { User } from '@/types';
import { Link, router, useForm } from '@inertiajs/vue3';

interface Article {
    id: number;
    title: string;
    subtitle?: string;
    body: string;
    author_id: number;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    user: User;
    articles?: Article[];
}>();

const formatDate = (dateString: string) => {
    if (!dateString) return '';
    const [year, month, day, time] = [dateString.slice(0, 4), dateString.slice(5, 7), dateString.slice(8, 10), dateString.slice(11, 19)];
    return `${day}.${month}.${year} ${time}`;
};

const datetimeCreated = formatDate(props.user?.created_at);
const datetimeUpdated = formatDate(props.user?.updated_at);

function logout() {
    if (confirm('Вы уверенны что хотите выйти?')) {
        return router.get('/logout');
    }
}

const deleteForm = useForm();

const submitDelete = () => {
    if (confirm('Вы уверенны что хотите удалить аккаунт?')) {
        if (confirm('Это действие нельзя будет отменить!')) {
            deleteForm.post('/profile/delete');
        }
    }
};
</script>

<template>
    <div class="md-page">
        <div class="md-container md-stack" style="max-width: 920px">
            <div>
                <Link href="/home"><button class="md-btn md-btn-tonal"><- Назад</button></Link>
            </div>

            <div class="md-card md-form">
                <h1 class="md-title">Профиль</h1>

                <div class="md-field">
                    <label class="md-label">Имя</label>
                    <input class="md-input" type="text" disabled="true" :value="props.user.name" />
                </div>

                <div class="md-field">
                    <label class="md-label">Email</label>
                    <input class="md-input" type="text" disabled="true" :value="props.user.email" />
                </div>

                <div class="md-field">
                    <label class="md-label">Дата создания</label>
                    <input class="md-input" type="text" disabled="true" :value="datetimeCreated" />
                </div>

                <div class="md-field" v-if="datetimeCreated !== datetimeUpdated">
                    <label class="md-label">Updated at</label>
                    <input class="md-input" type="text" disabled="true" :value="datetimeUpdated" />
                </div>

                <div class="md-field">
                    <label class="md-label">About Me</label>
                    <textarea class="md-textarea" v-if="props.user.description" disabled="true">{{ props.user.description }}</textarea>
                    <textarea class="md-textarea" v-else disabled="true" placeholder="Расскажите о себе"></textarea>
                </div>

                <div class="md-field">
                    <label class="md-label">Статьи</label>
                    <div class="md-stack" v-if="articles">
                        <div v-for="article in articles" :key="article.id" class="md-card" style="padding: 10px 12px; border-radius: 10px">
                            <Link :href="`/articles/${article.id}`">{{ article.title }}</Link>
                        </div>
                    </div>
                </div>

                <div class="md-row">
                    <Link href="/profile/edit"><button class="md-btn md-btn-success">Редактировать</button></Link>
                    <Link href="/profile/change-password"><button class="md-btn md-btn-warning">Смена пароля</button></Link>
                    <button class="md-btn md-btn-danger" @click="logout">Выйти</button>
                    <form @submit.prevent="submitDelete">
                        <button class="md-btn md-btn-danger">Удалить аккаунт</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
