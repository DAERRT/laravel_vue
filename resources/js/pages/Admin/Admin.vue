<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { User } from '@/types';

defineProps<{
    users: User[];
}>();

const form = useForm({});

const deleteUser = (id: number) => {
    if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
        form.post(`/delete/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Пользователь успешно удален');
                alert('Пользователь удален!');
            },
            onError: (errors) => {
                console.error('Ошибка при удалении:', errors);
            },
        });
    }
};

const editUser = (id: number) => {
    form.get(`/edit/${id}`);
};

const page = usePage();
const currentUser = computed(() => page.props.auth.user);
</script>

<template>
    <div class="md-sidenav-layout">
        <aside class="md-sidenav">
            <h1 class="md-title" style="font-size: 22px">Админ панель</h1>
            <Link href="/home"><button class="md-btn md-btn-tonal" style="width: 100%">Домашняя</button></Link>
            <Link href="/admin"><button class="md-btn" style="width: 100%">Пользователи</button></Link>
            <Link href="/roles"><button class="md-btn md-btn-tonal" style="width: 100%">Роли</button></Link>
            <button class="md-btn md-btn-tonal" style="width: 100%" disabled>Скоро...</button>
            <p class="md-sidenav-footer">ТИУ 2026</p>
        </aside>

        <main class="md-page">
            <div class="md-container">
                <div class="md-card md-stack">
                    <h2 class="md-title" style="font-size: 24px">Пользователи</h2>

                    <div v-if="users.length" class="md-table-wrap">
                        <table class="md-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.id }}<span class="md-note" v-if="currentUser?.id == user.id"> (Вы)</span></td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>
                                        <div class="md-row" v-if="user.roles.length">
                                            <label class="md-chip" v-for="role in user.roles" :key="role.id">{{ role.name }}</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="md-row">
                                            <form @submit.prevent="deleteUser(user.id)">
                                                <button
                                                    class="md-btn md-btn-danger"
                                                    :disabled="currentUser?.id === user.id || form.processing"
                                                    type="submit"
                                                >
                                                    Delete
                                                </button>
                                            </form>

                                            <form @submit.prevent="editUser(user.id)">
                                                <button class="md-btn" :disabled="currentUser?.id === user.id || form.processing" type="submit">Edit</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="md-error">Пока нет пользователей</div>
                </div>
            </div>
        </main>
    </div>
</template>
